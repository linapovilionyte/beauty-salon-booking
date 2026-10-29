<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Salon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SalonController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Salon::all(), 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
	    'name' => ['required', 'string', 'max:255'],
	    'address' => ['required', 'string', 'max:255'],
	    'phone' => ['nullable', 'string', 'max:30'],
	    'email' => ['nullable', 'email', 'max:255'],
	    'description' => ['nullable', 'string'],
	]);

	$salon = Salon::create($validated);

	return response()->json($salon, 201);
    }

    public function show(Salon $salon): JsonResponse
    {
        return response()->json($salon, 200);
    }

    public function update(Request $request, Salon $salon): JsonResponse
    {
        $validated =$request->validate([
	    'name' => ['sometimes', 'required', 'string', 'max:255'],
	    'address' => ['sometimes', 'required', 'string', 'max:255'],
	    'phone' => ['sometimes', 'nullable', 'string', 'max:30'],
	    'email' => ['sometimes', 'nullable', 'email', 'max:255'],
	    'description' => ['sometimes', 'nullable', 'string'],
	]);

	$salon->update($validated);

	return response()->json($salon, 200);
    }

    public function destroy(Salon $salon): JsonResponse
    {
        $salon->delete();

        return response()->json(null, 204);
    }
}
