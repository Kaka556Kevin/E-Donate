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
        Schema::create('uang_donasi', function (Blueprint $table) {
            $table->id(); // Kolom id dengan auto_increment dan primary key
            $table->string('nama_donasi')->nullable();
            $table->bigInteger('uang_masuk')->default(0);
            $table->bigInteger('uang_keluar')->default(0);
            $table->bigInteger('saldo')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uang_donasi');
    }
};
