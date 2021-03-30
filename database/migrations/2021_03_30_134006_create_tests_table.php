<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestsTable extends Migration
{
    public function up()
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('teacher_id')->constrained('users');
            $table->foreignId('course_id')->constrained('courses');
            $table->tinyInteger('number_classroom_archived');
            $table->char('postfix_classroom_archived', 4);
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('passed_at');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tests');
    }
}
