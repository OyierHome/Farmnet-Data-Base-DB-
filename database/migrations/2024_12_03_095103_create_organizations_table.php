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
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
<<<<<<< HEAD
            $table->string('org_name')->nullable();
            $table->string('org_country')->nullable();
            $table->string('org_phone')->nullable();
            $table->string('org_email')->nullable();
            $table->string('org_password')->nullable();
=======
            $table->string('org_name');
            $table->string('org_country');
            $table->string('org_phone');
            $table->string('org_email');
            $table->string('org_password');
>>>>>>> ae4bcff0aa80d991d7d0fd374b31a0c584ca7e3b
            $table->string('service_provider');
            $table->string('offtake_partner');
            $table->string('input_supplier');
            $table->string('development_partner');
            $table->string('education');
            $table->string('institude');
            $table->string('community');
            $table->string('invester');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
