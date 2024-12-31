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
        Schema::create('crop_inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('crop_name');
            $table->string('country');
            $table->string('ploughing_qty')->default('0')->nullable();
            $table->string('ploughing_price')->default('0')->nullable();
            $table->string('seed_qty')->default('0')->nullable();
            $table->string('seed_price')->default('0')->nullable();
            $table->string('fertilizer_qty')->default('0')->nullable();
            $table->string('fertilizer_price')->default('0')->nullable();
            $table->string('herbicides_qty')->default('0')->nullable();
            $table->string('herbicides_price')->default('0')->nullable();
            $table->string('pesticide_qty')->default('0')->nullable();
            $table->string('pesticide_price')->default('0')->nullable();
            $table->string('labour_qty')->default('0')->nullable();
            $table->string('labour_price')->default('0')->nullable();
            $table->string('packaing_qty')->default('0')->nullable();
            $table->string('packaing_price')->default('0')->nullable();
            $table->string('storage_qty')->default('0')->nullable();
            $table->string('storage_price')->default('0')->nullable();
            $table->string('transport_qty')->default('0')->nullable();
            $table->string('transport_price')->default('0')->nullable();
            $table->string('trees_qty')->default('0')->nullable();
            $table->string('trees_price')->default('0')->nullable();
            $table->string('equipment_qty')->default('0')->nullable();
            $table->string('equipment_price')->default('0')->nullable();
            $table->string('tools_qty')->default('0')->nullable();
            $table->string('tools_price')->default('0')->nullable();
            $table->string('feeders_qty')->default('0')->nullable();
            $table->string('feeders_price')->default('0')->nullable();
            $table->string('land_size_qty')->default('0')->nullable();
            $table->string('land_size_price')->default('0')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crop_inventories');
    }
};
