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
        Schema::create('livestock_revenue_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('crop_name');
            $table->string('country');
            $table->string('cash_sale_qty')->nullable()->default('0');
            $table->string('cash_sale_price')->nullable()->default('0');
            $table->string('credit_sale_qty')->nullable()->default('0');
            $table->string('credit_sale_price')->nullable()->default('0');
            $table->string('services_qty')->nullable()->default('0');
            $table->string('services_price')->nullable()->default('0');
            $table->string('advertisiment_qty')->nullable()->default('0');
            $table->string('advertisiment_price')->nullable()->default('0');
            $table->string('donation_qty')->nullable()->default('0');
            $table->string('donation_price')->nullable()->default('0');
            $table->string('farm_visit_qty')->nullable()->default('0');
            $table->string('farm_visit_price')->nullable()->default('0');
            $table->string('royality_qty')->nullable()->default('0');
            $table->string('royality_price')->nullable()->default('0');
            $table->string('incentives_qty')->nullable()->default('0');
            $table->string('incentives_price')->nullable()->default('0');
            $table->string('bonuses_qty')->nullable()->default('0');
            $table->string('bonuses_price')->nullable()->default('0');
            $table->string('research_qty')->nullable()->default('0');
            $table->string('research_price')->nullable()->default('0');
            $table->string('traning_qty')->nullable()->default('0');
            $table->string('traning_price')->nullable()->default('0');
            $table->string('hospitality_qty')->nullable()->default('0');
            $table->string('hospitality_price')->nullable()->default('0');
            $table->string('intrests_qty')->nullable()->default('0');
            $table->string('intrests_price')->nullable()->default('0');
            $table->string('land_size_qty')->nullable()->default('0');
            $table->string('land_size_price')->nullable()->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('livestock_revenue_records');
    }
};
