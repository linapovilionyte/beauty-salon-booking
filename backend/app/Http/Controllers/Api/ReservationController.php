<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
	    Reservation::with('service.salon')->get(),
	    200
	);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
	    'service_id' => ['required', 'integer', 'exists:services,id'],
	    'client_name' => ['required', 'string', 'max:255'],
	    'client_email' => ['required', 'email', 'max:255'],
	    'client_phone' => ['nullable', 'string', 'max:30'],
	    'reservation_datetime' => ['required', 'date', 'after:now'],
	    'status' => ['sometimes', 'in:pending,confirmed,cancelled,completed'],
	    'notes' => ['nullable', 'string'],
	]);

	$reservation = Reservation::create($validated);

	return response()->json(
	    $reservation->load('service.salon'),
	    201
	);
    }

    public function show(Reservation $reservation): JsonResponse
    {
        return response()->json(
	    $reservation->load('service.salon'),
	    200
	);
    }

    public function update(
	Request $request,
	Reservation $reservation
    ): JsonResponse {
        $validated = $request->validate([
	    'service_id' => ['sometimes', 'required', 'integer', 'exists:services,id'],
	    'client_name' => ['sometimes', 'required', 'string', 'max:255'],
	    'client_email' => ['sometimes', 'required', 'email', 'max:255'],
	    'client_phone' => ['sometimes', 'nullable', 'string', 'max:30'],
	    'reservation_datetime' => ['sometimes', 'required', 'date', 'after:now'],
	    'status' => ['sometimes', 'required', 'in:pending,confirmed,cancelled,completed'],
	    'notes' => ['sometimes', 'nullable', 'string'],
	]);

	$reservation->update($validated);

	return response()->json(
	    $reservation->load('service.salon'),
	    200
	);
    }

    public function destroy(Reservation $reservation): JsonResponse
    {
        $reservation->delete();

	return response()->json(null, 204);
    }
}
