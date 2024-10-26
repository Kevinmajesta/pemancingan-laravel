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
        // Migration
        Schema::create('schedules', function (Blueprint $table) {
            $table->bigIncrements('id_schedule');
            $table->string('activity_name');
            $table->date('date');
            $table->time('time'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules'); // Pastikan nama tabelnya konsisten
    }
};

