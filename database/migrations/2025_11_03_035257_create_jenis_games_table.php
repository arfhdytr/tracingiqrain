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
        Schema::create('jenis_games', function (Blueprint $table) {
            $table->id('jenis_game_id');
            $table->unsignedBigInteger('tingkatan_id');
            $table->string('nama_game', 50);
            $table->integer('poin_maksimal');
            $table->text('deskripsi')->nullable();
            $table->timestamps();

            $table->foreign('tingkatan_id')->references('tingkatan_id')->on('tingkatan_iqras')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_games');
    }
};
