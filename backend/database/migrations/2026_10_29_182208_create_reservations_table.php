<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
	    $table->foreignId('service_id')->constrained()->cascadeOnDelete();
	    $table->string('client_name');
	    $table->string('client_email');
	    $table->string('client_phone', 30)->nullable();
	    $table->dateTime('reservation_datetime');
	    $table->string('status')->default('pending');
	    $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
