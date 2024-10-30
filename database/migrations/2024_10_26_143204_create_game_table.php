<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('game', function (Blueprint $table) {
            $table->id('id_game');
            $table->unsignedBigInteger('id_schedule_detail');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_schedule'); // Tambahkan kolom id_schedule
            $table->date('date')->nullable(); // Tambahkan kolom date
            $table->decimal('ikanterberat_sesi1', 5, 2)->nullable();
            $table->decimal('ikanterberat_sesi2', 5, 2)->nullable();
            $table->integer('ikanterbanyak')->nullable();
            $table->string('pemenang')->nullable();

            $table->foreign('id_schedule_detail')->references('id_schedule_detail')->on('schedule_detail')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_schedule')->references('id_schedule')->on('schedules')->onDelete('cascade'); // Foreign key untuk id_schedule
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game');
    }
};
