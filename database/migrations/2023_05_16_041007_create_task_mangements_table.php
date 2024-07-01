<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_mangements', function (Blueprint $table) {
            $table->id();
            $table->integer('created_user_id');
            $table->integer('assign_user_id')->default(0);
            $table->string('title');
            $table->string('keyword');
            $table->integer('word_count');
            $table->longText('guideline')->nullable();
            $table->longText('content')->nullable();
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('task_mangements');
    }
};
