<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('test_id')->constrained('tests')->onDelete('cascade');
            $table->integer('number');
            $table->string('postfix')->nullable();
            $table->integer('min_score');
            $table->integer('max_score');
            $table->integer('sort');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
