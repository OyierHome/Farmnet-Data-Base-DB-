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
        Schema::create('enterprise_livestock_productions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('crop_name');
            $table->string('country');
            $table->string('production_cost_plan')->nullable()->default(0);
            $table->string('production_cost_actual')->nullable()->default(0);
            $table->string('ploughing_plan')->nullable()->default(0);
            $table->string('ploughing_actual')->nullable()->default(0);
            $table->string('seed_plan')->nullable()->default(0);
            $table->string('seed_actual')->nullable()->default(0);
            $table->string('fertilizer_plan')->nullable()->default(0);
            $table->string('fertilizer_actual')->nullable()->default(0);
            $table->string('herbicide_plan')->nullable()->default(0);
            $table->string('herbicide_actual')->nullable()->default(0);
            $table->string('pesticide_plan')->nullable()->default(0);
            $table->string('pesticide_actual')->nullable()->default(0);
            $table->string('labour_plan')->nullable()->default(0);
            $table->string('labour_actual')->nullable()->default(0);
            $table->string('packaging_plan')->nullable()->default(0);
            $table->string('packaging_actual')->nullable()->default(0);
            $table->string('storage_plan')->nullable()->default(0);
            $table->string('storage_actual')->nullable()->default(0);
            $table->string('transport_plan')->nullable()->default(0);
            $table->string('transport_actual')->nullable()->default(0);
            $table->string('variety_plan')->nullable()->default(0);
            $table->string('variety_actual')->nullable()->default(0);
            $table->string('equipment_plan')->nullable()->default(0);
            $table->string('equipment_actual')->nullable()->default(0);
            $table->string('land_size_plan')->nullable()->default(0);
            $table->string('land_size_actual')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enterprise_livestock_productions');
    }
};
