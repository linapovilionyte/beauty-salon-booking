<?php

namespace Tests\Feature\Api;

use App\Models\Salon;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceApiTest extends TestCase
{
    use RefreshDatabase;

    public function createSalon(): Salon
    {
        return Salon::create([
	    'name' => 'Grožio studija Vilnius',
	    'address' => 'Gedimino pr. 10, Vilnius',
	]);
    }

    private function createService(Salon $salon): Service
    {
	return Service::create([
	    'salon_id' => $salon->id,
	    'name' => 'Moteriškas kirpimas',
	    'description' => 'Plaukų kirpimas ir formavimas',
	    'duration_minutes' => 45,
	    'price' => 30.00,
	]);
    }

    public function test_can_list_services(): void
    {
	$salon = $this->createSalon();
	$this->createService($salon);

	$response = $this->getJson('/api/services');
	
	$response->assertOk()
	    ->assertJsonCount(1)
	    ->assertJsonPath('0.name', 'Moteriškas kirpimas');
    }

    public function test_can_create_a_service(): void
    {
	$salon = $this->createSalon();

	$response = $this->postJson('/api/services', [
	    'salon_id' => $salon->id,
	    'name' => 'Manikiūras',
	    'description' => 'Nagų priežiūra',
	    'duration_minutes' => 60,
	    'price' => 25.00,
	]);

	$response->assertCreated()
	    ->assertJsonPath('name', 'Manikiūras')
	    ->assertJsonPath('salon.id', $salon->id);

	$this->assertDatabaseHas('services', [
	    'salon_id' => $salon->id,
	    'name' => 'Manikiūras',
	]);
    }

    public function test_cannot_create_a_service_without_required_fields(): void
    {
	$response = $this->postJson('/api/services', []);

	$response->assertUnprocessable()
	    ->assertJsonValidationErrors([
		'salon_id',
		'name',
		'duration_minutes',
		'price',
	    ]);
    }

    public function test_cannot_create_a_service_for_a_nonexistent_salon(): void
    {
	$response = $this->postJson('/api/services', [
	    'salon_id' => 99999,
	    'name' => 'Manikiūras',
	    'duration_minutes' => 60,
	    'price' => 25.00,
	]);

	$response->assertUnprocessable()
	    ->assertJsonValidationErrors(['salon_id']);
    }

    public function test_return_404_for_a_missing_service(): void
    {
	$response = $this->getJson('/api/services/99999');

	$response->assertNotFound();
    }

    public function test_can_update_a_service(): void
    {
	$salon = $this->createSalon();
	$service = $this->createService($salon);

	$response = $this->patchJson(
	    "/api/services/{$service->id}",
	    ['price' => 35.00]
	);

	$response->assertOk()
	    ->assertJsonPath('price', '35.00');

	$this->assertDatabaseHas('services', [
	    'id' => $service->id,
	    'price' => 35.00,
	]);
    }

    public function test_can_delete_a_service(): void
    {
	$salon = $this->createSalon();
	$service =$this->createService($salon);

	$response = $this->deleteJson("/api/services/{$service->id}");

	$response->assertNoContent();

	$this->assertDatabaseMissing('services', [
	    'id' => $service->id,
	]);
    }

    public function test_can_list_services_for_a_salon(): void
    {
	$salon = $this->createSalon();
	$this->createService($salon);

	$response = $this->getJson("/api/salons/{$salon->id}/services");

	$response->assertOk()
	    ->assertJsonCount(1)
	    ->assertJsonPath('0.salon_id', $salon->id)
	    ->assertJsonPath('0.name', 'Moteriškas kirpimas');
    }

    public function test_returns_404_when_listing_services_for_a_missing_salon(): void
    {
	$response = $this->getJson('/api/salons/99999/services');

	$response->assertNotFound();
    }
}
