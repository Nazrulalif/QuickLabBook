<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('no_matric');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->enum('level_study', ['Sarjana Muda', 'Sarjana', 'Doktor Falsafah']);
            $table->integer('year_study')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'return'])->default('pending');
            $table->date('start_at');
            $table->date('end_at');
            $table->text('purpose')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
