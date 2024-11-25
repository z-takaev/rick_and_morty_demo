<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->json('name');
            $table->json('description')->nullable();

            $table->string('status')->nullable();
            $table->string('gender')->nullable();
            $table->string('image')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};
