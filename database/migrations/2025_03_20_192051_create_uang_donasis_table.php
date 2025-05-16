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
            $table->id();
            $table->string('nama_donasi')->nullable();
            $table->bigInteger('uang_masuk')->default(0);
            $table->bigInteger('uang_keluar')->default(0);
            $table->bigInteger('saldo')->default(0);

            // Perbaikan: Hapus ->after('id')
            $table->unsignedBigInteger('kelola_donasi_id')->nullable();

            // Foreign key constraint
            $table->foreign('kelola_donasi_id')
                  ->references('id')
                  ->on('kelola_donasi')
                  ->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('uang_donasi', function (Blueprint $table) {
            $table->dropForeign(['kelola_donasi_id']);
            $table->dropColumn('kelola_donasi_id');
        });

        Schema::dropIfExists('uang_donasi');
    }
};