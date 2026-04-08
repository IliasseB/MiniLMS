<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('resultats_quiz', function (Blueprint $table) {
            $table->id();
            $table->integer('score');
            $table->foreignId('apprenant_id')->constrained('apprenants')->onDelete('cascade');
            $table->unsignedBigInteger('quiz_id');
            $table->foreign('quiz_id')->references('id')->on('quiz')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('resultats_quiz');
    }
};