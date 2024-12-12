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
        Schema::create('crop_revenue_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('crop_name');
            $table->string('country');
            $table->string('cash_sale_qty')->default('0');
            $table->string('cash_sale_price')->default('0');
            $table->string('credit_sale_qty')->default('0');
            $table->string('credit_sale_price')->default('0');
            $table->string('services_qty')->default('0');
            $table->string('services_price')->default('0');
            $table->string('advertisiment_qty')->default('0');
            $table->string('advertisiment_price')->default('0');
            $table->string('donation_qty')->default('0');
            $table->string('donation_price')->default('0');
            $table->string('farm_visit_qty')->default('0');
            $table->string('farm_visit_price')->default('0');
            $table->string('royality_qty')->default('0');
            $table->string('royality_price')->default('0');
            $table->string('incentives_qty')->default('0');
            $table->string('incentives_price')->default('0');
            $table->string('bonuses_qty')->default('0');
            $table->string('bonuses_price')->default('0');
            $table->string('research_qty')->default('0');
            $table->string('research_price')->default('0');
            $table->string('traning_qty')->default('0');
            $table->string('traning_price')->default('0');
            $table->string('land_size_qty')->default('0');
            $table->string('land_size_price')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crop_revenue_records');
    }
};
