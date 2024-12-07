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
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('names');
            $table->string('email')->unique();
            $table->unsignedBigInteger('department_id')->nullable()->after('column_name'); // Adjust 'column_name' as necessary
            $table->foreign('department')->references('id')->on('departments')->onDelete('cascade');
            $table->string('role');
            $table->string('profile_picture');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
