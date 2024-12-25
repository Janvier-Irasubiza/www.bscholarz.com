<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->biginteger('applicant_id')->nullable();
            $table->foreign('applicant_id')->references('id')->on('applicant_info')->onDelete('cascade');
            $table->biginteger('application_id')->nullable();
            $table->foreign('application_id')->references('app_id')->on('applications')->onDelete('cascade');
            $table->decimal('amount', 10, 2)->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
