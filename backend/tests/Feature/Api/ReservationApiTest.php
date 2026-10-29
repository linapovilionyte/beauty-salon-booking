<?php

namespace Tests\Feature\Api;

use App\Models\Reservation;
use App\Models\Salon;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservationApiTest extends TestCase
{
    use RefreshDatabase;

    public function createService(): Service
    {
        $salon = Salon::create([
	    'name' => 'Grožio studija Vilnius',
	    'address' => 'Gedimino pr. 10, Vilnius',
	]);

        return Service::create([
	    'salon_id' => $salon->id,
	    'name' => 'Moteriškas kirpimas',
	    'description' => 'Plaukų kirpimas ir formavimas',
	    'duration_minutes' => 45,
	    'price' => 30.00,
	]);
    }

    private function createReservation(Service $service): Reservation
    {
	return Reservation::create([
	    'service_id' => $service->id,
	    'client_name' => 'Aistė Petrauskaitė',
	    'client_email' => 'aiste@example.com',
	    'client_phone' => '+37061111111',
	    'reservation_datetime' => '2027-01-15 10:00:00',
	    'status' => 'pending',
	    'notes' => 'Pirmas apsilankymas',
	]);
    }

    public function test_can_list_reservations(): void
    {
	$service = $this->createService();
	$this->createReservation($service);

	$response = $this->getJson('/api/reservations');

	$response->assertOk()
	    ->assertJsonCount(1)
	    ->assertJsonPath('0.client_name', 'Aistė Petrauskaitė')
	    ->assertJsonPath('0.service.id', $service->id);
    }

    public function test_can_create_a_reservation(): void
    {
	$service = $this->createService();

	$response =$this->postJson('/api/reservations', [
	    'service_id' => $service->id,
	    'client_name' => 'Jonas Jonaitis',
	    'client_email' => 'jonas@example.com',
	    'client_phone' => '+37060000000',
	    'reservation_datetime' => '2027-02-15 12:00:00',
	    'notes' => 'Pirmas vizitas',
	]);

	$response->assertCreated()
	    ->assertJsonPath('client_name', 'Jonas Jonaitis')
	    ->assertJsonPath('service.id', $service->id)
	    ->assertJsonPath('service.salon.id', $service->salon_id);

	$this->assertDatabaseHas('reservations', [
	    'service_id' => $service->id,
	    'client_email' => 'jonas@example.com',
	]);
    }

    public function test_cannot_create_a_reservation_without_required_fields(): void
    {
	$response = $this->postJson('/api/reservations', []);

	$response->assertUnprocessable()
	    ->assertJsonValidationErrors([
	    	'service_id',
		'client_name',
		'client_email',
		'reservation_datetime',
	    ]);
    }

    public function test_cannot_create_a_reservation_for_a_nonexistent_service(): void
    {
	$response = $this->postJson('/api/reservations', [
	    'service_id' => 99999,
	    'client_name' => 'Jonas Jonaitis',
	    'client_email' => 'jonas@example.com',
	    'reservation_datetime' => '2027-02-15 12:00:00',
	]);

	$response->assertUnprocessable()
	    ->assertJsonValidationErrors(['service_id']);
    }

    public function test_cannot_create_a_reservation_in_the_past(): void
    {
	$service = $this->createService();

	$response = $this->postJson('/api/reservations', [
	    'service_id' => $service->id,
	    'client_name' => 'Jonas Jonaitis',
	    'client_email' => 'jonas@example.com',
	    'reservation_datetime' => '2020-01-01 10:00:00',
	]);

	$response->assertUnprocessable()
	    ->assertJsonValidationErrors(['reservation_datetime']);
    }

    public function test_returns_404_for_a_missing_reservation(): void
    {
	$response = $this->getJson('/api/reservations/99999');

	$response->assertNotFound();
    }

    public function test_can_update_a_reservation(): void
    {
	$service = $this->createService();
	$reservation = $this->createReservation($service);

	$response = $this->patchJson(
	    "/api/reservations/{$reservation->id}",
	    ['status' => 'confirmed']
	);

	$response->assertOk()
	    ->assertJsonPath('status', 'confirmed');

	$this->assertDatabaseHas('reservations', [
	    'id' => $reservation->id,
	    'status' => 'confirmed',
	]);
    }

    public function test_can_delete_a_reservation(): void
    {
	$service = $this->createService();
	$reservation = $this->createReservation($service);

	$response = $this->deleteJson(
	    "/api/reservations/{$reservation->id}"
	);

  	$response->assertNoContent();

	$this->assertDatabaseMissing('reservations', [
	    'id' => $reservation->id,
	]);
    }
}
