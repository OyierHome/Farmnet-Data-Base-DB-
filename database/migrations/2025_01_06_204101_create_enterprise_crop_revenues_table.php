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
        Schema::create('enterprise_crop_revenues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('crop_name');
            $table->string('country');
            $table->string('production_cost_plan')->nullable()->default(0);
            $table->string('production_cost_actual')->nullable()->default(0);
            $table->string('cash_sale_plan')->nullable()->default(0);
            $table->string('cash_sale_actual')->nullable()->default(0);
            $table->string('credit_sale_plan')->nullable()->default(0);
            $table->string('credit_sale_actual')->nullable()->default(0);
            $table->string('service_plan')->nullable()->default(0);
            $table->string('service_actual')->nullable()->default(0);
            $table->string('advertisement_plan')->nullable()->default(0);
            $table->string('advertisement_actual')->nullable()->default(0);
            $table->string('donation_plan')->nullable()->default(0);
            $table->string('donation_actual')->nullable()->default(0);
            $table->string('farm_visit_plan')->nullable()->default(0);
            $table->string('farm_visit_actual')->nullable()->default(0);
            $table->string('royalty_plan')->nullable()->default(0);
            $table->string('royalty_actual')->nullable()->default(0);
            $table->string('incentive_plan')->nullable()->default(0);
            $table->string('incentive_actual')->nullable()->default(0);
            $table->string('bonus_plan')->nullable()->default(0);
            $table->string('bonus_actual')->nullable()->default(0);
            $table->string('research_plan')->nullable()->default(0);
            $table->string('research_actual')->nullable()->default(0);
            $table->string('training_plan')->nullable()->default(0);
            $table->string('training_actual')->nullable()->default(0);
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
        Schema::dropIfExists('enterprise_crop_revenues');
    }
};
