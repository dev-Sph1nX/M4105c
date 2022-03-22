<?php

namespace App\Http\Traits;

use App\Models\Probleme;
use App\Models\Probleme_Famille;
use App\Models\Probleme_Type;
use App\Models\Procedure;
use App\Models\Urgence;
use Inertia\Inertia;

trait ModalTicketData {
    function getModalTicketData() { 
        $type_probleme = Probleme_Type::all();
        $famille_probleme = Probleme_Famille::all();
        $probleme = Probleme::all();
        $urgence = Urgence::all();
        

        Inertia::share([
            "type_probleme" => $type_probleme,
            "famille_probleme" => $famille_probleme,
            "probleme" => $probleme,
            "urgence" => $urgence
        ]);
    }
    function getModalInterventionData(){
        $procedure = Procedure::all();
        

        Inertia::share([
            "procedure" => $procedure
        ]);
    }
    function getModalRequalifierData(){
        $type_probleme = Probleme_Type::all();
        $urgence = Urgence::all();

        Inertia::share([
            "type_probleme" => $type_probleme,
            "urgence" => $urgence
        ]);
    }
}