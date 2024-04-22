<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('public_id')->unique();
            $table->unsignedInteger('parent_exam_id')->nullable()->constrained('exams');
            $table->foreignId('question_category_id')->nullable()->constrained();
            $table->foreignId('user_id')->constrained();
            $table->enum('type', ['STANDARD', 'BALANCED', 'CATEGORY', 'SIMULACRUM']);
            $table->integer('score')->default(0);
            $table->string('sharing_token');
            $table->timestamp('completed_at')->nullable();
            $table->string('utm_source')->nullable();
            $table->string('utm_medium')->nullable();
            $table->string('utm_campaign')->nullable();
            $table->string('utm_term')->nullable();
            $table->string('utm_content')->nullable();
            $table->timestamp('expiration_at')->nullable();
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
        Schema::dropIfExists('exams');
    }
}
