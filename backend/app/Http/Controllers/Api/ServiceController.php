<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Salon;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
	    Service::with('salon')->get(),
	    200
	);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
	    'salon_id' => ['required', 'integer', 'exists:salons,id'],
	    'name' => ['required', 'string', 'max:255'],
	    'description' => ['nullable', 'string'],
	    'duration_minutes' => ['required', 'integer', 'min:1'],
	    'price' => ['required', 'numeric', 'min:0'],
	]);

	$service = Service::create($validated);

	return response()->json($service->load('salon'), 201);
    }

    public function show(Service $service): JsonResponse
    {
        return response()->json($service->load('salon'), 200);
    }

    public function update(Request $request, Service $service): JsonResponse
    {
        $validated = $request->validate([
	    'salon_id' => ['sometimes', 'required', 'integer', 'exists:salons,id'],
	    'name' => ['sometimes', 'required', 'string', 'max:255'],
	    'description' => ['sometimes', 'nullable', 'string'],
	    'duration_minutes' => ['sometimes', 'required', 'integer', 'min:1'],
	    'price' => ['sometimes', 'required', 'numeric', 'min:0'],
	]);

	$service->update($validated);

	return response()->json($service->load('salon'), 200);
    }

    public function destroy(Service $service): JsonResponse
    {
        $service->delete();

	return response()->json(null, 204);
    }

    public function bySalon(Salon $salon): JsonResponse
    {
	return response()->json($salon->services, 200);
    }
}
