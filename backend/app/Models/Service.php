<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
	'salon_id',
	'name',
	'description',
	'duration_minutes',
	'price',
    ];

    protected function casts(): array
    {
	return [
	    'duration_minutes' => 'integer',
	    'price' => 'decimal:2',
	];
    }

    public function salon(): BelongsTo
    {
	return $this->belongsTo(Salon::class);
    }

    public function reservations(): HasMany
    {
	return $this->hasMany(Reservation::class);
    }
}