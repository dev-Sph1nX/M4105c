<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeProblemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_problemes', function (Blueprint $table) {
            $table->id('id_type_probleme');
            $table->string('libelle_type_probleme');
            $table->foreignId('id_famille_probleme')->nullable()->constrained('famille_problemes', 'id_famille_probleme');
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
        Schema::dropIfExists('type_problemes');
    }
}
