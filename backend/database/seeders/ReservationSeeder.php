<?php

namespace Database\Seeders;

use App\Models\Reservation;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        $reservations = [
	    [
		'service_id' => 1,
		'client_name' => 'Aistė Petrauskaitė',
		'client_email' => 'aiste@example.com',
		'client_phone' => '+37061111111',
		'reservation_datetime' => '2027-01-15 10:00:00',
		'status' => 'confirmed',
		'notes' => 'Pirmas apsilankymas.',
	    ],
	    [
		'service_id' => 2,
		'client_name' => 'Gabija Kazlauskaitė',
		'client_email' => 'gabija@example.com',
		'client_phone' => '+37062222222',
		'reservation_datetime' => '2027-01-16 12:00:00',
		'status' => 'pending',
		'notes' => 'Norima išlaikyti natūralią plaukų spalvą.'
	    ],
	    [
		'service_id' => 3,
		'client_name' => 'Emilija Jankauskaitė',
		'client_email' => 'emilija@example.com',
		'client_phone' => '+37063333333',
		'reservation_datetime' => '2027-01-17 14:00:00',
		'status' => 'confirmed',
		'notes' => 'Makiažas vakariniam renginiui.',
	    ],
	    [
		'service_id' => 4,
		'client_name' => 'Ieva Stankevičiūtė',
		'client_email' => 'ieva@example.com',
		'client_phone' => '+37064444444',
		'reservation_datetime' => '2027-01-18 11:00:00',
		'status' => 'pending',
		'notes' => 'Pageidaujamas švelnus nagų atspalvis.',
	    ],
	    [
		'service_id' => 5,
		'client_name' => 'Monika Petrauskienė',
		'client_email' => 'monika@example.com',
		'client_phone' => '+37065555555',
		'reservation_datetime' => '2027-01-19 13:00:00',
		'status' => 'completed',
		'notes' => 'Trumpi nagai, apvalios formos.',
	    ],
	    [
		'service_id' => 7,
		'client_name' => 'Laura Vaitkutė',
		'client_email' => 'laura@example.com',
		'client_phone' => '+37066666666',
		'reservation_datetime' => '2027-01-20 09:30:00',
		'status' => 'cancelled',
		'notes' => 'Klientė atšaukė rezervaciją.',
	    ],
	];

	foreach ($reservations as $reservation) {
	    Reservation::create($reservation);
	}
    }
}
