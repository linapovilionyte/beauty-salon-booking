<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
	'service_id',
	'client_name',
	'client_email',
	'client_phone',
	'reservation_datetime',
	'status',
	'notes',
    ];

    protected function casts(): array
    {
	return [
	    'reservation_datetime' => 'datetime',
	];
    }

    public function service(): BelongsTo
    {
	return $this->belongsTo(Service::class);
    }
}
