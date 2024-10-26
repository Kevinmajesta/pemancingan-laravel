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
        Schema::create('schedule_detail', function (Blueprint $table) {
            $table->bigIncrements('id_schedule_detail'); // This should be your primary key
            $table->unsignedBigInteger('id_schedule');
            $table->unsignedBigInteger('id_user');

            // Foreign keys
            $table->foreign('id_schedule')->references('id_schedule')->on('schedules')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }




    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_detail');
    }
};
