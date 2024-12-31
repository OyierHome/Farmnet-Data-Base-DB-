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
        Schema::create('crop_production_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('crop_name');
            $table->string('country');
<<<<<<< HEAD
            $table->string('ploughing_qty')->default(0)->nullable();
            $table->string('ploughing_price')->default(0)->nullable();
            $table->string('seed_qty')->default(0)->nullable();
            $table->string('seed_price')->default(0)->nullable();
            $table->string('fertilizer_qty')->default(0)->nullable();
            $table->string('fertilizer_price')->default(0)->nullable();
            $table->string('herbicide_qty')->default(0)->nullable();
            $table->string('herbicide_price')->default(0)->nullable();
            $table->string('pesticide_qty')->default(0)->nullable();
            $table->string('pesticide_price')->default(0)->nullable();
            $table->string('labour_qty')->default(0)->nullable();
            $table->string('labour_price')->default(0)->nullable();
            $table->string('packaging_qty')->default(0)->nullable();
            $table->string('packaging_price')->default(0)->nullable();
            $table->string('storage_qty')->default(0)->nullable();
            $table->string('storage_price')->default(0)->nullable();
            $table->string('transport_qty')->default(0)->nullable();
            $table->string('transport_price')->default(0)->nullable();
            $table->string('variety_qty')->default(0)->nullable();
            $table->string('variety_price')->default(0)->nullable();
            $table->string('equipment_qty')->default(0)->nullable();
            $table->string('equipment_price')->default(0)->nullable();
            $table->string('spray_qty')->default(0)->nullable();
            $table->string('spray_price')->default(0)->nullable();
            $table->string('tool_qty')->default(0)->nullable();
            $table->string('tool_price')->default(0)->nullable();
            $table->string('model_qty')->default(0)->nullable();
            $table->string('model_price')->default(0)->nullable();
            $table->string('range_qty')->default(0)->nullable();
            $table->string('range_price')->default(0)->nullable();
            $table->string('land_size_qty')->default(0)->nullable();
            $table->string('land_size_price')->default(0)->nullable();
=======
            $table->string('ploughing_qty');
            $table->string('ploughing_price');
            $table->string('seed_qty');
            $table->string('seed_price');
            $table->string('fertilizer_qty');
            $table->string('fertilizer_price');
            $table->string('herbicides_qty');
            $table->string('herbicides_price');
            $table->string('pesticide_qty');
            $table->string('pesticide_price');
            $table->string('labour_qty');
            $table->string('labour_price');
            $table->string('packaing_qty');
            $table->string('packaing_price');
            $table->string('storage_qty');
            $table->string('storage_price');
            $table->string('transport_qty');
            $table->string('transport_price');
            $table->string('variety_qty');
            $table->string('variety_price');
            $table->string('equipment_qty');
            $table->string('equipment_price');
            $table->string('land_size_qty');
            $table->string('land_size_price');
>>>>>>> ae4bcff0aa80d991d7d0fd374b31a0c584ca7e3b
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crop_production_records');
    }
};
