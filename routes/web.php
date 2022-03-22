<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RedirectionController;
use App\Http\Controllers\TicketController;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function() { return Inertia::render("login"); })->name("index");


// Connexion
Route::get('/login', [LoginController::class, "displayLogin"])->middleware(['guest'])->name("login.view");
Route::post('/login', [LoginController::class, "login"])->middleware(['guest'])->name("login");

Route::get('/logout', function() { Auth::logout(); return redirect(route('index')); })->middleware(['auth'])->name("logout");
Route::post('/logout', function() { Auth::logout(); return redirect(route('index')); })->middleware(['auth'])->name("logout");


// Inventaire
    // Commmun
Route::get('/utilisateur', [RedirectionController::class, "redirection"])->middleware(['auth'])->name('dashboard'); 
Route::post('/requalifier-ticket', [TicketController::class, "requalifierTicket"])->middleware(['auth'])->name('requalifier-ticket'); 
Route::post('/fermer-ticket', [TicketController::class, "fermerTicket"])->middleware(['auth'])->name('fermer-ticket'); 

    // Demandeur
Route::get('/demandeur/dashboard', [RedirectionController::class, "demandeurDepot"])->middleware(['auth','demandeur'])->name('dem.dashboard');
Route::get('/demandeur/all', [RedirectionController::class, "demandeurAll"])->middleware(['auth','demandeur'])->name('dem.all');
Route::get('/demandeur/finish', [RedirectionController::class, "demandeurFinish"])->middleware(['auth','demandeur'])->name('dem.finish');
Route::get('/demandeur/notifications', [RedirectionController::class, "demandeurNotif"])->middleware(['auth','demandeur'])->name('dem.notif');

// Opérateur
Route::get('/operateur/dashboard', [RedirectionController::class, "operateurDepot"])->middleware(['auth','operateur'])->name('ope.dashboard');
Route::get('/operateur/dashboard/redirectOperateur/{id_ticket}/{id_operateur}', [TicketController::class, "redirectToOpefromOpe"])->middleware(['auth','operateur'])->name('ope.redirect.operateur');
Route::get('/operateur/dashboard/redirectResponsable/{id}', [TicketController::class, "redirectToResfromOpe"])->middleware(['auth','operateur'])->name('ope.redirect.responsable');
Route::get('/operateur/finish', [RedirectionController::class, "operateurFinish"])->middleware(['auth','operateur'])->name('ope.finish');

// Responsable
Route::get('/responsable/dashboard', [RedirectionController::class, "responsable"])->middleware(['auth','responsable'])->name('res.dashboard');
Route::get('/responsable/finish', [RedirectionController::class, "responsableFinish"])->middleware(['auth','responsable'])->name('res.finish');
Route::get('/responsable/rapport', [RedirectionController::class, "responsableRapport"])->middleware(['auth','responsable'])->name('res.rapport');
Route::get('/responsable/dashboard/redirectOperateur/{id}', [TicketController::class, "redirectToOpefromRes"])->middleware(['auth','responsable'])->name('res.redirect.operateur');
Route::post('/responsable/dashboard/force-redirection/{id}', [TicketController::class, "forceRedirect"])->middleware(['auth','responsable'])->name('res.force.redirect');

//tickets
Route::post('/demandeur/add', [TicketController::class, "addTicket"])->middleware(['auth','demandeur'])->name('add-ticket');
Route::post('/demandeur/update', [TicketController::class, "updateTicket"])->middleware(['auth','demandeur'])->name('update-ticket');

//Prendre en charge
Route::post('/responsable/prendre-charge', [TicketController::class, "prendreCharge"])->middleware(['auth','responsable'])->name('res.prendre-charge');
Route::post('/operateur/prendre-charge', [TicketController::class, "prendreCharge"])->middleware(['auth','operateur'])->name('ope.prendre-charge');

// Intervention
Route::post('/operateur/add-intervention', [TicketController::class, "addIntervention"])->middleware(['auth','operateur'])->name('ope.add-intervention');
Route::post('/responsable/add-intervention', [TicketController::class, "addIntervention"])->middleware(['auth','responsable'])->name('res.add-intervention');
