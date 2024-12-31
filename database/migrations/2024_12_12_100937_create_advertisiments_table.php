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
        Schema::create('advertisiments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('crop_type', ['crop', 'livestock'])->default('crop');
            $table->enum('type', ['product','service'])->default('product');
            $table->string('problem');
            $table->string('diagnosis');
            $table->string('management');
            $table->string('product_name');
            $table->string('product_image');
            $table->string('benefits');
            $table->string('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advertisiments');
    }
};
