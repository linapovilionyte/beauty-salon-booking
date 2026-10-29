<?php

namespace Database\Seeders;

use App\Models\Salon;
use Illuminate\Database\Seeder;

class SalonSeeder extends Seeder
{
    public function run(): void
    {
        $salons = [
	    [
		'name' => 'Grožio studija Vilnius',
		'address' => 'Gedimino pr. 10, Vilnius',
		'phone' => '+37060000001',
		'email' => 'vilnius@grozio-studija.lt',
		'description' => 'Moderni grožio studija Vilniaus centre.',
	    ],
	    [
		'name' => 'Elegancija Kaunas',
		'address' => 'Laisvės al. 15, Kaunas',
		'phone' => '+37060000002',
		'email' => 'kaunas@elegancija.lt',
		'description' => 'Grožio salonas, siūlantis plaukų ir nagų priežiūros paslaugas.',
	    ],
	    [
		'name' => 'Grožio kampelis Klaipėda',
		'address' => 'Taikos pr. 20, Klaipėda',
		'phone' => '+37060000003',
		'email' => 'klaipeda@groziokampelis.lt',
		'description' => 'Jaukus grožio salonas kasdienei grožio priežiūrai.',
	    ],
	];

	foreach ($salons as $salon) {
	    Salon::create($salon);
	}
    }
}
