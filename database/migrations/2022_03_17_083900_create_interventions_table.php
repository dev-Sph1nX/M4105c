<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterventionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interventions', function (Blueprint $table) {
            $table->id('id_intervention');
            $table->string('libelle_intervention');
            $table->foreignId('id_procedure')->nullable()->constrained('procedures', 'id_procedure');
            $table->date('date_intervention');
            $table->foreignId('id_operateur')->nullable()->constrained('users', 'id');
            $table->foreignId('id_ticket')->nullable()->constrained('tickets', 'id_ticket');
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
        Schema::dropIfExists('interventions');
    }
}
