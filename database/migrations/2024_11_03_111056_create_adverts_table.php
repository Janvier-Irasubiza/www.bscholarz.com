<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertsTable extends Migration
{
    public function up()
    {
        Schema::create('adverts', function (Blueprint $table) {
            $table->biginteger('id')->autoIncrement();
            $table->string('title');
            $table->string('owner');
            $table->string('owner_phone');
            $table->string('type');
            $table->decimal('amount', 10, 2);
            $table->string('payment_circle');
            $table->string('amount_gen')->nullable();
            $table->timestamp('posted_on')->nullable();
            $table->timestamp('time_taken')->nullable();
            $table->timestamp('expiry_date')->nullable();
            $table->string('media')->nullable();
            $table->string('media_type')->nullable();
            $table->string('status')->default('Inactive');
            $table->string('link')->nullable();
            $table->integer('clicks')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('adverts');
    }
}
