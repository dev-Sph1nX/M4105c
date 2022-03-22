<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperateurFamilleProblemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operateur_famille_problemes', function (Blueprint $table) {
            $table->foreignId('id_utilisateur')->nullable()->constrained('users', 'id');
            $table->foreignId('id_famille_probleme')->nullable()->constrained('famille_problemes', 'id_famille_probleme');
            $table->primary(['id_utilisateur', 'id_famille_probleme']);
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
        Schema::dropIfExists('operateur_famille_problemes');
    }
}
