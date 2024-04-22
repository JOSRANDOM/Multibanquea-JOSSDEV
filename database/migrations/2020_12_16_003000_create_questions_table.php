<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_subcategory_id')->constrained();
            $table->string('image')->nullable();
            $table->text('text');
            $table->string('source')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->string('question_explanation')->nullable();
            $table->string('question_explanation_img')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
