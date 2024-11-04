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
        Schema::create('messages', function (Blueprint $table) {
            $table->biginteger('id')->autoIncrement();
            $table->string('message');
            $table->json('tags')->nullable();
            $table->biginteger('sender');
            $table->biginteger('receiver');
            $table->biginteger('app')->nullable();
            $table->biginteger('transaction')->nullable();
            $table->biginteger('account')->nullable();
            $table->string('status')->default('unread');
            $table->foreign('sender')->references('id')->on('staff')->onDelete('cascade');
            $table->foreign('app')->references('id')->on('disciplines')->onDelete('cascade');
            $table->foreign('transaction')->references('id')->on('applications')->onDelete('cascade');
            $table->foreign('account')->references('id')->on('staff')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
