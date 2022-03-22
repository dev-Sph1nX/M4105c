<?php

namespace App\Http\Controllers\Auth;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Http\Traits\ModalTicketData;
use App\Models\Notification;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class RedirectionController extends Controller
{
    use ModalTicketData;
    
    function redirection()
    {   
        if (Auth::user()->id_role == 1){
            return redirect(route('dem.dashboard'));
        } elseif (Auth::user()->id_role == 2){
            return redirect(route('ope.dashboard'));
        } elseif (Auth::user()->id_role == 3){
            return redirect(route('res.dashboard'));
        } else{
            return back();
        }
    }

    function demandeurDepot()
    {
        $tickets = Ticket::where('id_createur', '=', Auth::user()->id)->where('id_etat', '<>', 3)->orderBy('date_ticket', 'desc')->get();
        $this->getModalTicketData();

        return Inertia::render('dashboard-demandeur', [
            "tickets" => $tickets,
        ]);
    }

    function demandeurFinish()
    {
        $tickets = Ticket::where('id_createur', '=', Auth::user()->id)->where('id_etat', '=', 3)->orderBy('date_ticket', 'desc')->get();
        $this->getModalTicketData();

        return Inertia::render('dashboard-demandeur', [
            "tickets" => $tickets,
            "src" => "finish"
        ]);
    }

    function demandeurAll()
    {
        $tickets = Ticket::where('id_createur', '=', Auth::user()->id)->orderBy('date_ticket', 'desc')->get();
        $this->getModalTicketData();

        return Inertia::render('dashboard-demandeur', [
            "tickets" => $tickets,
            "src" => "all"
        ]);
    }

    function demandeurNotif(Request $request){

        $request->validate([
            "id_notif" => ["nullable"]
        ]);
        
        if($request->id_notif){
            $readingNotif = Notification::where('id_notification', '=', $request->id_notif)->first();
            $readingNotif->isRead = true;
            $readingNotif->save();
        }

        $user = User::where('id', '=', Auth::user()->id)->first();
        $notifs = Notification::where('id_user', "=", Auth::user()->id)->where('isRead', '=', false)->orderBy('date_notification', 'DESC')->get();
        
        if($request->id_notif){
            return Redirect::route('dem.notif');
        }else{
            return Inertia::render('notif-demandeur', [
                "user" => $user,
                "notifs" => $notifs,
            ]);
        }
        
    }

    function operateurDepot(Request $request)
    {
        $request->validate([
            "name" => ["nullable"],
            "date_ticket" => ["nullable"],
            "id_urgence" => ["nullable"]
        ]);

        $tickets = Ticket::join('users', 'id_createur', '=', 'users.id')
            ->where(function($query) use ($request) {
                if(isset($request->name)){
                    $query->where('users.name','like', ucfirst($request->name).'%');
                }
                if(isset($request->date_ticket)){
                    $query->whereDate('date_ticket','=', $request->date_ticket);
                }
                if(isset($request->id_urgence)){
                    $query->where('id_urgence','=', $request->id_urgence);
                }
        })->where('id_operateur', '=', Auth::user()->id)->where('id_etat', '<>', 3)->orderBy('date_ticket', 'desc')->get();
        $this->getModalTicketData();
        $this->getModalInterventionData();
        $this->getModalRequalifierData();

        return Inertia::render('dashboard-operateur', [
            "tickets" => $tickets
        ]);
    }

    function operateurFinish(Request $request)
    {
        $request->validate([
            "name" => ["nullable"],
            "date_ticket" => ["nullable"],
            "id_urgence" => ["nullable"]
        ]);
        
        $tickets = Ticket::join('users', 'id_createur', '=', 'users.id')
            ->where(function($query) use ($request) {
                if(isset($request->name)){
                    $query->whereRaw('LOWERCASE(`users.name`) like'.$request->name.'%');
                }
                if(isset($request->date_ticket)){
                    $query->whereDate('date_ticket','=', $request->date_ticket);
                }
                if(isset($request->id_urgence)){
                    $query->where('id_urgence','=', $request->id_urgence);
                } 
        })->where('id_operateur', '=', Auth::user()->id)->where('id_etat', '=', 3)->orderBy('date_ticket', 'desc')->get();
        $this->getModalTicketData();

        return Inertia::render('dashboard-operateur', [
            "tickets" => $tickets,
            "src" => "finish"
        ]);
    }

    function responsable()
    {
        $tickets = Ticket::where('id_etat', '<>', 3)->where('id_operateur', '=', Auth::user()->id)->orderBy('date_ticket', 'desc')->get();
        $this->getModalTicketData();
        $this->getModalInterventionData();
        $this->getModalRequalifierData();

        return Inertia::render('dashboard-responsable',[
            "tickets" => $tickets
        ]);
    }

    function responsableFinish()
    {
        $tickets = Ticket::where('id_operateur', '=', Auth::user()->id)->where('id_etat', '=', 3)->orderBy('date_ticket', 'desc')->get();
        $this->getModalTicketData();

        return Inertia::render('dashboard-responsable', [
            "tickets" => $tickets,
            "src" => "finish"
        ]);
    }

    function responsableRapport()
    {
        function resolutionTimeMoy(){
            $tickets = Ticket::where('id_etat', '3')->get();
            $allmoy = array();
            foreach($tickets as $ticket){
                $resol_time = Carbon::parse($ticket->date_ticket)->diff($ticket->date_resolution_prevu)->d*24;
                array_push($allmoy, $resol_time);
            }
            return array_sum($allmoy)/count($allmoy) . " h";
        }

        function ticketEnAttente(){
            $tickets = Ticket::where('id_etat', '1')->get();
            return count($tickets)." tickets";
        }

        function ticketResolus(){
            $tickets = Ticket::where('id_etat', '3')->get();
            return count($tickets)." tickets";
        }

        function ticketAll(){
            $tickets = Ticket::all();
            return count($tickets)." tickets";
        }

        function operateurAll(){
            $ope = User::where('id_role', '2')->get();
            return count($ope)." opérateurs";
        }

        function redirections(){
            $ticketRedirige = Ticket::where('nb_redirections','>',0)->get();
            $tickets = Ticket::all();
            $percent = round(count($ticketRedirige)/count($tickets)*100, 0);
            return count($ticketRedirige)." ticket sur ".count($tickets)." (soit ".$percent."%)";
        }

        $stats = array (
            array("icon"=>"time-outline","title"=>"Temps de résolution moyen","info"=>resolutionTimeMoy()),
            array("icon"=>"hourglass-outline","title"=>"Nombre de tickets en attente","info"=>ticketEnAttente()),
            array("icon"=>"checkmark-outline","title"=>"Nombre de tickets résolus","info"=>ticketResolus()),
            array("icon"=>"stats-chart-outline","title"=>"Nombre de tickets au total","info"=>ticketAll()),
            array("icon"=>"person-outline","title"=>"Nombre d'opérateur en service","info"=>operateurAll()),
            array("icon"=>"swap-horizontal-outline","title"=>"Nombre de redirections","info"=>redirections())
            );
        return Inertia::render('rapport-responsable', [
            "stats" => $stats
        ]);
    }
}