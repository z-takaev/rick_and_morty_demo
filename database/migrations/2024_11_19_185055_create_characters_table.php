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

            $table->string('name');
            $table->string('status');
            $table->string('gender');
            $table->string('image');

            $table->json('translations')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};
