<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('promo_code')->unique()->nullable();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->string('name');
            $table->integer('months');
            $table->integer('monthly_price');
            $table->boolean('active')->default(false);
            $table->boolean('public')->default(false);
            $table->boolean('protected')->default(false);
            $table->boolean('featured')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }
}
