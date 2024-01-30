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
        Schema::create('vins', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->integer('code_saq');
            $table->string('size', 20);
            $table->float('price');
            $table->string('country');
            $table->string('type');
            $table->string('photo', 200);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vins');
    }
};
