<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';
    protected $primaryKey = 'id_ticket';
    public $timestamps = false;

    protected $with = ['famille', 'type', 'probleme', 'createur', 'operateur', 
        'etat', 'urgence', 'interventions'];

    function famille(){
        return $this->hasOne(Probleme_Famille::class, 'id_famille_probleme', 'id_famille_probleme');
    }

    function type(){
        return $this->hasOne(Probleme_Type::class, 'id_type_probleme', 'id_type_probleme');
    }

    function probleme(){
        return $this->hasOne(Probleme::class, 'id_probleme', 'id_probleme');
    }

    function createur(){
        return $this->hasOne(User::class, 'id', 'id_createur');
    }

    function operateur(){
        return $this->hasOne(User::class, 'id', 'id_operateur');
    }

    function etat(){
        return $this->hasOne(Etat::class, 'id_etat', 'id_etat');
    }

    function urgence(){
        return $this->hasOne(Urgence::class, 'id_urgence', 'id_urgence');
    }

    function interventions(){
        return $this->hasMany(Intervention::class, 'id_ticket', 'id_ticket');
    }
}