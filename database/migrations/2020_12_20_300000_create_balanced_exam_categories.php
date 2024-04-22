<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBalancedExamCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balanced_exam_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_category_id')->constrained();
            $table->integer('size')->unsigned();
            $table->enum('type', ['NORMAL', 'SMALL']);
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
        Schema::dropIfExists('balanced_exam_categories');
    }
}
