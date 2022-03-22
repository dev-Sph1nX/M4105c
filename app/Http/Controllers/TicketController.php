<?php

namespace App\Http\Controllers;

use App\Http\Traits\ModalTicketData;
use App\Models\Intervention;
use App\Models\Notification;
use App\Models\Probleme;
use App\Models\Probleme_Famille;
use App\Models\Probleme_Type;
use App\Models\Ticket;
use App\Models\TicketIntervention;
use App\Models\Urgence;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class TicketController extends Controller
{

    use ModalTicketData;

    public function newNotif($libelle, $id_user){
        $new = new Notification;
        $new->libelle_notification = $libelle;
        $new->date_notification = Carbon::now()->setTimezone('Europe/Paris');
        $new->id_user = $id_user;
        // dd($new);
        $new->save();
    }

    // public function findOperateur(Ticket $ticket){
    //     $users = DB::select(
    //         DB::raw("select u.name, u.id, count(t.id_operateur) 
    //             from users u 
    //             join operateur_famille_probleme ofp on u.id = ofp.id_utilisateur 
    //             left join tickets t on u.id = t.id_operateur 
    //             where ofp.id_famille_probleme = " . $ticket->id_famille_probleme . " 
    //             group by u.name, u.id 
    //             order by count(t.id_operateur)"));
    //     return $users[0]->id;
    // }

    public function addTicket(Request $request){

        // dd($request);
        $ticket = new Ticket;

        $time = Carbon::now(); 
 
        $ticket->poste_ticket = $request->poste;
        $ticket->date_ticket = $time->setTimezone('Europe/Paris');
        $ticket->description_ticket = $request->message;

        $ticket->commentaire_ticket = null;
        $ticket->date_resolution_prevu = null;

        if ($request->file('file')){
			$filname = $this->random(64) . '.png';
			Storage::disk('public')->put($filname, $request->file('file')->get());
            $ticket->path_piece_ticket = $filname;
        } else {
            $ticket->path_piece_ticket = null;
        }

        $ticket->id_etat = 1; // En attente	 	
        $ticket->id_createur = $request->user_id; 	

        $fam = Probleme_Famille::where('id_famille_probleme', '=', $request->fam_probleme)->first();
        $ticket->id_famille_probleme = $fam->id_famille_probleme;

        $ticket->id_operateur = null;
        $urgence = Urgence::where('id_urgence', '=', $request->urgence)->first();
        $ticket->id_urgence =  $urgence->id_urgence;
        $ticket->nb_redirections = 0;

        $type = Probleme_Type::where('id_type_probleme', '=', $request->type_probleme)->first();
        $ticket->id_type_probleme = $type->id_type_probleme;	 

        $prbl = Probleme::where('id_probleme', '=', $request->probleme)->first();
        $ticket->id_probleme = $prbl->id_probleme;
        
        $users = DB::select(
            DB::raw("select u.name, u.id, count(t.id_operateur) 
                from users u 
                join operateur_famille_problemes ofp on u.id = ofp.id_utilisateur 
                left join tickets t on u.id = t.id_operateur 
                where ofp.id_famille_probleme = " . $ticket->id_famille_probleme . " 
                group by u.name, u.id 
                order by count(t.id_operateur)"));
        
        if(count($users) == 0){
            $responsable = User::where('id_role', '=', '3')->first(); // Ok parce qu'il y en a qu'un 
            $ticket->id_operateur = $responsable->id;
        }
        else{
            $ticket->id_operateur = $users[0]->id; // = findOperateur($ticket);
        }
        

        $ticket->save();
        
        return response()->redirectToRoute('dem.dashboard');
    }

    public function updateTicket(Request $request){
        // dd($request);

        $ticket = Ticket::find($request->id_ticket);

        $ticket->description_ticket = $request->message;

        $ticket->save();

        return redirect()->route('dem.dashboard');
    }

    public function redirectToOpefromOpe(Request $request){
        $ticket = Ticket::find($request->route('id_ticket'));
        $id_operateur = $request->route('id_operateur');

        $users = DB::select(
            DB::raw("select u.name, u.id, count(t.id_operateur) 
                from users u 
                join operateur_famille_problemes ofp on u.id = ofp.id_utilisateur 
                left join tickets t on u.id = t.id_operateur 
                where ofp.id_famille_probleme = " . $ticket->id_famille_probleme . " 
                group by u.name, u.id 
                order by count(t.id_operateur)"));
        $ticket->nb_redirections += 1;
        if(count($users) == 1 && $users[0]->id == $id_operateur){
            return redirect()->route('ope.dashboard')->with('error', 'Redirection vers un autre opérateur impossible : Vous êtes le seul opérateur compétent.');
        }else if($users[0]->id == $id_operateur){

            TicketController::newNotif(
                "Le ticket n°".$ticket->id_ticket." a été redirigé vers l'opérateur : ".$users[1]->name . ". Le ticket est mis en attente.", 
                $ticket->id_createur
            );

            $ticket->date_resolution_prevu = null;

            $ticket->id_operateur = $users[1]->id;
            $ticket->id_etat = 1; // En attente
            $ticket->commentaire_ticket = null;
            $ticket->save();
            return redirect()->route('ope.dashboard')->with('success', 'Le ticket a été redirigé vers l\'opérateur : ' . $users[1]->name );
        }else{
            TicketController::newNotif(
                "Le ticket n°".$ticket->id_ticket." a été redirigé vers l'opérateur : ".$users[0]->name . ". Le ticket est mis en attente.", 
                $ticket->id_createur
            );
            $ticket->date_resolution_prevu = null;
            $ticket->commentaire_ticket = null;

            $ticket->id_operateur = $users[0]->id;
            $ticket->id_etat = 1; // En attente
            $ticket->save();
            return redirect()->route('ope.dashboard')->with('success', 'Le ticket a été redirigé vers l\'opérateur : ' . $users[0]->name);
        }
        
       

    }
    public function redirectToOpefromRes(Request $request){
        $ticket = Ticket::find($request->route('id'));
        $users = DB::select(
            DB::raw("select u.name, u.id, count(t.id_operateur) 
                from users u 
                join operateur_famille_problemes ofp on u.id = ofp.id_utilisateur 
                left join tickets t on u.id = t.id_operateur 
                where ofp.id_famille_probleme = " . $ticket->id_famille_probleme . " 
                group by u.name, u.id 
                order by count(t.id_operateur)"));
        if(count($users) == 0){
            $ope = User::where('id_role', '=', 2)->get();
            return redirect()->route('res.dashboard')->with([
                'action' => 'forceOpenUserModal',
                'action_data' => [
                    'id' => $request->route('id'),
                    'liste_operateur' => $ope
                ]
            ]);
        }else{
            $ticket->nb_redirections += 1;

            $ticket->id_etat = 1; // En attente
            $ticket->commentaire_ticket = null;
            $ticket->date_resolution_prevu = null;
            $ticket->id_operateur = $users[0]->id;
            $ticket->save();

            TicketController::newNotif(
                "Le ticket n°".$ticket->id_ticket." a été redirigé vers l\'opérateur : ".$users[0]->name. ". Le ticket est mis en attente.", 
                $ticket->id_createur
            );
    
            return redirect()->route('res.dashboard')->with('success', 'Le ticket a été redirigé vers l\'opérateur : ' . $users[0]->name);
        }
        
    }

    public function redirectToResfromOpe(Request $request){
        $ticket = Ticket::find($request->route('id'));
        
        $responsable = User::where('id_role', '=', '3')->get(); // Ok parce qu'il y en a qu'un 

        if(count($responsable)== 0){
            return redirect()->route('ope.dashboard')->with('error', 'Aucun responsable trouvé dans la base de donnée.');
        }else{ 
            $ticket->id_etat = 1; // En attente
            $ticket->date_resolution_prevu = null;
            $ticket->commentaire_ticket = null;
            $ticket->id_operateur = $responsable[0]->id;
            $ticket->nb_redirections += 1;
            $ticket->save();
    
            TicketController::newNotif(
                "Le ticket n°".$ticket->id_ticket." a été redirigé vers le responsable : ".$responsable[0]->name . ". Le ticket est mis en attente.", 
                $ticket->id_createur
            );

            return redirect()->route('ope.dashboard')->with('success', 'Le ticket a été redirigé vers le responsable : ' . $responsable[0]->name);
        }
        
    }

    public function prendreCharge(Request $request){
        $ticket = Ticket::find($request->id_ticket);

        $year = substr($request->date, 0, -14);
        $hours = substr($request->date, 11, -5);
        // dd($year." ".$hours);

        if($request->comment || !empty($request->comment)){
            $ticket->commentaire_ticket = $request->comment;
        }

        $ticket->id_etat = 2;
        $ticket->date_resolution_prevu = $request->date;
        $ticket->save();

        TicketController::newNotif(
            "Le ticket n°".$ticket->id_ticket." a été pris en charge par : ".$ticket->operateur->name. ". Date de resolution prévu : ".$year, 
            $ticket->id_createur
        );

        return redirect()->route('dashboard');
    }

    public function addIntervention(Request $request){
        $intervention = new Intervention;
        $intervention->libelle_intervention = $request->libelle_intervention;
        $intervention->id_procedure = $request->id_procedure;
        $intervention->date_intervention = Carbon::now()->setTimezone('Europe/Paris');
        $intervention->id_operateur = $request->id_operateur; 
        $intervention->id_ticket = $request->id_ticket;       
        $intervention->save();

        $ticket = Ticket::where('id_ticket', '=', $request->id_ticket)->first();
        TicketController::newNotif(
            $intervention->operateur->name. " est intervenu sur le ticket n°". $ticket->id_ticket . " : $request->libelle_intervention", 
            $ticket->id_createur
        );

        return redirect()->route('dashboard');

    }

    function requalifierTicket(Request $request){
        // dd($request);
        $ticket = Ticket::where('id_ticket', '=', $request->id_ticket)->first();

        if($ticket->id_type_probleme != $request->id_type_probleme)
            $ticket->id_type_probleme = $request->id_type_probleme;
        
        if($ticket->id_urgence != $request->id_urgence)
            $ticket->id_urgence = $request->id_urgence;

        $ticket->save();

        TicketController::newNotif(
            "Le ticket n°".$ticket->id_ticket." a été requalifié par ". $ticket->operateur->name.". Allez dans votre dashboard pour voir les modifications effectuées.", 
            $ticket->id_createur
        );

        return redirect()->route('dashboard');
    }

    function fermerTicket(Request $request){
        // dd($request);
        $ticket = Ticket::where('id_ticket', '=', $request->id_ticket)->first();

        $ticket->id_etat = 3; // Terminé
        $ticket->isResolved = $request->resolved;

        $ticket->save();

        $responsable = User::where('id_role', '=', '3')->first(); // Ok parce qu'il y en a qu'un 
        // dd($responsable);

        if($request->resolved){
            TicketController::newNotif(
                "Le probléme du ticket n°".$ticket->id_ticket." a été resolu par ". $ticket->operateur->name.". Le ticket a donc été clos.", 
                $ticket->id_createur
            );
        }else{
            TicketController::newNotif(
                "Le probléme du ticket n°".$ticket->id_ticket." n'a malheursement pas été resolu. Le ticket a donc été clos, rapprochez de ". $responsable->name .", le responsable pour en savoir plus.", 
                $ticket->id_createur
            );
        }

        return redirect()->route('dashboard');
            
    }

    function forceRedirect(Request $request){
        $id_ticket = $request->route('id');
        $id_operateur = $request->id_operateur;

        $ticket = Ticket::where('id_ticket', '=', $id_ticket)->first();
        $ope = User::where('id', '=', $id_operateur)->first();
        
        $ticket->id_etat = 1; // En attente
        $ticket->date_resolution_prevu = null;
        $ticket->commentaire_ticket = null;
        $ticket->id_operateur = $ope->id;
        $ticket->nb_redirections += 1;

        $ticket->save();

        TicketController::newNotif(
            "Le ticket n°".$ticket->id_ticket." a été redirigé vers l\'opérateur : ".$ope->name. ". Le ticket est mis en attente.", 
            $ticket->id_createur
        );
        
        return back();
    }
}
