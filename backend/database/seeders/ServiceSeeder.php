<?php

namespace Database\Seeders;

use App\Models\Salon;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
	    // Grožio studija Vilnius
	    [
		'salon_id' => 1,
		'name' => 'Moteriškas kirpimas',
		'description' => 'Plaukų kirpimas ir formavimas.',
		'duration_minutes' => 45,
		'price' => 30.00,
	    ],
	    [
		'salon_id' => 1,
		'name' => 'Plaukų dažymas',
		'description' => 'Plaukų dažymas ir spalvos atnaujinimas.',
		'duration_minutes' => 120,
		'price' => 75.00,
	    ],
	    [
	 	'salon_id' => 1,
		'name' => 'Vakarinis makiažas',
		'description' => 'Profesionalus makiažas ypatingoms progoms.',
		'duration_minutes' => 60,
		'price' => 50.00,
	    ],

	    // Elegancija Kaunas
	    [
		'salon_id' => 2,
		'name' => 'Manikiūras',
		'description' => 'Nagų priežiūra ir lakavimas.',
		'duration_minutes' => 60,
		'price' => 25.00,
	    ],
	    [
		'salon_id' => 2,
		'name' => 'Gelinis lakavimas',
		'description' => 'Ilgalaikis gelinis nagų lakavimas.',
		'duration_minutes' => 90,
		'price' => 35.00,
	    ],
	    [
		'salon_id' => 2,
		'name' => 'Pedikiūras',
		'description' => 'Pėdų ir nagų priežiūros procedūra.',
		'duration_minutes' => 75,
		'price' => 40.00,
	    ],

	    // Grožio kampelis Klaipėda
	    [
		'salon_id' => 3,
		'name' => 'Antakių korekcija',
		'description' => 'Antakių formavimas ir korekcija.',
		'duration_minutes' => 30,
		'price' => 15.00
	    ],
	    [
		'salon_id' => 3,
		'name' => 'Blakstienų laminavimas',
		'description' => 'Natūralių blakstienių pakėlimas ir formavimas.',
		'duration_minutes' => 60,
		'price' => 40.00,
	    ],
	    [
		'salon_id' => 3,
		'name' => 'Veido valymas',
		'description' => 'Giliai valanti veido odos procedūra.',
		'duration_minutes' => 90,
		'price' => 55.00,
	    ],
	];

	foreach($services as $service) {
	    Service::create($service);
	}
    }
}
