<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id('id_ticket');
            $table->string('poste_ticket');
            $table->date('date_ticket');
            $table->string('description_ticket')->nullable();
            $table->string('commentaire_ticket')->nullable();
            $table->date('date_resolution_prevu')->nullable();
            $table->string('path_piece_ticket')->nullable();
            $table->integer('nb_redirections')->default(0);
            $table->boolean('isResolved')->default(false);
            $table->foreignId('id_etat')->nullable()->constrained('etats', 'id_etat');
            $table->foreignId('id_createur')->nullable()->constrained('users', 'id');
            $table->foreignId('id_famille_probleme')->nullable()->constrained('famille_problemes', 'id_famille_probleme');
            $table->foreignId('id_operateur')->nullable()->constrained('users', 'id');
            $table->foreignId('id_urgence')->nullable()->constrained('urgences', 'id_urgence');
            $table->foreignId('id_type_probleme')->nullable()->constrained('type_problemes', 'id_type_probleme');
            $table->foreignId('id_probleme')->nullable()->constrained('problemes', 'id_probleme');
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
        Schema::dropIfExists('tickets');
    }
}
