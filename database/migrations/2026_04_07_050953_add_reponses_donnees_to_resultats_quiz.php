<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReponsesDonneesToResultatsQuiz extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resultats_quiz', function (Blueprint $table) {
            // Stocke les réponses choisies en JSON
            $table->json('reponses_donnees')->nullable();
        });
    }

    public function down()
    {
        Schema::table('resultats_quiz', function (Blueprint $table) {
            $table->dropColumn('reponses_donnees');
        });
    }
}
