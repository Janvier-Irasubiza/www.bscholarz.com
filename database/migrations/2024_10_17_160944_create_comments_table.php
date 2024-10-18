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
        Schema::create('comments', function (Blueprint $table) {
            $table->biginteger('id');
            $table->biginteger('discipline_id');
            $table->biginteger('applicant_id');
            $table->text('comment');
            $table->enum('status', ['active', 'inactive'])->default('inactive');
            $table->timestamps();
            $table->foreign('discipline_id')->references('id')->on('disciplines')->onDelete('cascade');
            $table->foreign('applicant_id')->references('id')->on('applicant_info')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
