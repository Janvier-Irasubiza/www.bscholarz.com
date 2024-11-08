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
            $table->string('uuid')->unique();
            $table->string('issue');
            $table->json('tags')->nullable();
            $table->biginteger('sender');
            $table->biginteger('receiver');
            $table->string('app')->nullable();
            $table->string('request')->nullable();
            $table->string('account')->nullable();
            $table->string('user')->nullable();
            $table->string('advert')->nullable();
            $table->string('subscriber_id')->nullable();
            $table->string('sub_plan_id')->nullable();
            $table->string('sub_service_id')->nullable();
            $table->string('status')->default('unread');
            $table->foreign('sender')->references('id')->on('staff')->onDelete('cascade');
            $table->foreign('receiver')->references('id')->on('staff')->onDelete('cascade');
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
