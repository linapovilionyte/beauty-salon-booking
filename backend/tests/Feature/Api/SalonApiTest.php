<?php

namespace Tests\Feature\Api;

use App\Models\Salon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SalonApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_salons(): void
    {
	Salon::create([
	    'name' => 'Grožio studija Vilnius',
	    'address' => 'Gedimino pr. 10, Vilnius',
	]);

        $response = $this->getJson('/api/salons');

        $response->assertOk()
	    ->assertJsonCount(1);
    }

    public function test_can_create_a_salon(): void
    {
	$response = $this->postJson('/api/salons', [
	    'name' => 'Grožio studija Kaunas',
	    'address' => 'Laisvės al. 15, Kaunas',
	    'email' => 'info@example.com',
	]);

	$response->assertCreated()
	    ->assertJsonPath('name', 'Grožio studija Kaunas');

	$this->assertDatabaseHas('salons', [
	    'name' => 'Grožio studija Kaunas',
	]);
    }

    public function test_cannot_create_a_salon_without_required_fields(): void
    {
	$response = $this->postJson('/api/salons/', []);

	$response->assertUnprocessable()
	    ->assertJsonValidationErrors(['name', 'address']);
    }

    public function test_returns_404_for_a_missing_salon(): void
    {
	$response = $this->getJson('/api/salons/99999');

	$response->assertNotFound();
    }

    public function test_can_update_a_salon(): void
    {
	$salon = Salon::create([
	    'name' => 'Senas pavadinimas',
	    'address' => 'Vilnius',
	]);

	$response = $this->patchJson(
	    "/api/salons/{$salon->id}",
	    ['name' => 'Naujas pavadinimas']
	);

	$response->assertOk()
	    ->assertJsonPath('name', 'Naujas pavadinimas');

	$this->assertDatabaseHas('salons', [
	    'id' => $salon->id,
	    'name' => 'Naujas pavadinimas',
	]);
    }

    public function test_can_delete_a_salon(): void
    {
	$salon = Salon::create([
	    'name' => 'Trinama studija',
	    'address' => 'Kaunas',
	]);

	$response = $this->deleteJson("/api/salons/{$salon->id}");

	$response->assertNoContent();

	$this->assertDatabaseMissing('salons', [
	    'id' => $salon->id,
	]);
    }
}
