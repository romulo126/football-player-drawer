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
        Schema::create('soccer_players', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('skill_level')->default(1)->comment('Escala de 1 a 5, onde 5 é o mais habilidoso');
            $table->boolean('goalkeeper')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soccer_players');
    }
};
