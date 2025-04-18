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
        Schema::create('form_donasi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kelola_donasi_id');
            $table->string('nama');
            $table->string('nominal');
            $table->string('whatsapp');
            $table->text('pesan')->nullable();
            $table->timestamps();
        
            $table->foreign('kelola_donasi_id')->references('id')->on('kelola_donasi')->onDelete('cascade');
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_donasis');
    }
};
