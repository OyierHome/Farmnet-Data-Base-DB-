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
        Schema::create('livestock_production_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('crop_name');
            $table->string('country');
            $table->string('equipment_qty')->default(0)->nullable();
            $table->string('equipment_price')->default(0)->nullable();
            $table->string('seed_qty')->default(0)->nullable();
            $table->string('seed_price')->default(0)->nullable();
            $table->string('feeds_qty')->default(0)->nullable();
            $table->string('feeds_price')->default(0)->nullable();
            $table->string('suppliements_qty')->default(0)->nullable();
            $table->string('suppliements_price')->default(0)->nullable();
            $table->string('pesticide_qty')->default(0)->nullable();
            $table->string('pesticide_price')->default(0)->nullable();
            $table->string('labour_qty')->default(0)->nullable();
            $table->string('labour_price')->default(0)->nullable();
            $table->string('packaing_qty')->default(0)->nullable();
            $table->string('packaing_price')->default(0)->nullable();
            $table->string('storage_qty')->default(0)->nullable();
            $table->string('storage_price')->default(0)->nullable();
            $table->string('transport_qty')->default(0)->nullable();
            $table->string('transport_price')->default(0)->nullable();
            $table->string('spray_qty')->default(0)->nullable();
            $table->string('spray_price')->default(0)->nullable();
            $table->string('variety_qty')->default(0)->nullable();
            $table->string('variety_price')->default(0)->nullable();
            $table->string('tool_qty')->default(0)->nullable();
            $table->string('tool_price')->default(0)->nullable();
            $table->string('model_qty')->default(0)->nullable();
            $table->string('model_price')->default(0)->nullable();
            $table->string('range_qty')->default(0)->nullable();
            $table->string('range_price')->default(0)->nullable();
            $table->string('land_size_qty')->default(0)->nullable();
            $table->string('land_size_price')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('livestock_production_records');
    }
};
