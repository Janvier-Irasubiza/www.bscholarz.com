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
            $table->biginteger('app')->nullable();
            $table->biginteger('request')->nullable();
            $table->biginteger('account')->nullable();
            $table->biginteger('user')->nullable();
            $table->biginteger('advert')->nullable();
            $table->foreignId('subscriber_id')->nullable()->constrained()->onDelete('cascade');
            $table->biginteger('sub_plan_id')->nullable()->constrained()->onDelete('cascade');
            $table->biginteger('sub_service_is')->nullable()->constrained()->onDelete('cascade');
            $table->string('status')->default('unread');
            $table->foreign('sender')->references('id')->on('staff')->onDelete('cascade');
            $table->foreign('app')->references('id')->on('disciplines')->onDelete('cascade');
            $table->foreign('request')->references('app_id')->on('applications')->onDelete('cascade');
            $table->foreign('account')->references('id')->on('staff')->onDelete('cascade');
            $table->foreign('user')->references('id')->on('applicant_info')->onDelete('cascade');
            $table->foreign('advert')->references('id')->on('adverts')->onDelete('cascade');
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
