<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('winner_ahp', function (Blueprint $table) {
            $table->id('id_winner_ahp');
            $table->unsignedBigInteger('id_user');
            $table->integer('month');
            $table->integer('year');
            $table->decimal('score', 8, 3);
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('winner_ahp');
    }
};
