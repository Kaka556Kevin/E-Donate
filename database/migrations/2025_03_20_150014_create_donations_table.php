<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('image');
            $table->integer('min_amount');
            $table->integer('max_amount');
            $table->integer('collected')->default(0);
            $table->integer('target');
            $table->timestamps();
        });
    }
    

    public function down(): void {
        Schema::dropIfExists('donations');
    }
};

