<?php

namespace Database\Seeders;

use App\Models\Etat;
use App\Models\Operateur_famille_problemes;
use App\Models\Probleme;
use App\Models\Role;
use App\Models\User;
use App\Models\Probleme_Famille;
use App\Models\Probleme_Type;
use App\Models\Procedure;
use App\Models\Urgence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *  @return void
     */
    public function run()
    {
        // Role
        $demandeur = Role::create([
            "id_role" => 1,
            "libelle_role" => "demandeur"
        ]);
        $operateur = Role::create([
            "id_role" => 2,
            "libelle_role" => "operateur"
        ]);
        $responsable = Role::create([
            "id_role" => 3,
            "libelle_role" => "responsable"
        ]);

        // User
        $sanchez = User::create([
            "name" => "Sanchez",
            "email" => "sanchez@gmail.com",
            "password" => Hash::make("sanchez"),
            "id_role" => $operateur->id_role
        ]);
        // $sanchez->Role()->save($operateur->id_role); marche pas

        $chaplin = User::create([
            "name" => "Chaplin",
            "email" => "chaplin@gmail.com",
            "password" => Hash::make("chaplin"),
            "id_role" => $demandeur->id_role
        ]);

        $nilson = User::create([
            "name" => "Nilson",
            "email" => "nilson@gmail.com",
            "password" => Hash::make("nilson"),
            "id_role" => $operateur->id_role
        ]);

        $jones = User::create([
            "name" => "Jones",
            "email" => "jones@gmail.com",
            "password" => Hash::make("jones"),
            "id_role" => $responsable->id_role
        ]);

        //Etat
        $enAttente = Etat::create([
            "id_etat" => 1,
            "libelle_etat" => "En attente"
        ]);
        $enCours = Etat::create([
            "id_etat" => 2,
            "libelle_etat" => "En cours"
        ]);
        $termine = Etat::create([
            "id_etat" => 3,
            "libelle_etat" => "Terminé"
        ]);

        // Urgences
        $peu = Urgence::create([
            "id_urgence" => 1,
            "libelle_urgence" => "Peu urgent"
        ]);
        $urgent = Urgence::create([
            "id_urgence" => 2,
            "libelle_urgence" => "Urgent"
        ]);
        $trés = Urgence::create([
            "id_urgence" => 3,
            "libelle_urgence" => "Très urgent"
        ]);

        //Probleme_Famille
        $logiciel = Probleme_Famille::create([
            "id_famille_probleme" => 1,
            "libelle_famille_probleme" => "Logiciel"
        ]);
        $materiel = Probleme_Famille::create([
            "id_famille_probleme" => 2,
            "libelle_famille_probleme" => "Materiel"
        ]);
        $utilisateur = Probleme_Famille::create([
            "id_famille_probleme" => 3,
            "libelle_famille_probleme" => "Utilisateur"
        ]);

        //Probleme
        $bloquage = Probleme::create([
            "libelle_probleme" => "Blocage",
            "id_famille_probleme" => $utilisateur->id_famille_probleme
        ]);
        // $bloquage->famille_probleme()->save($utilisateur);

        $erreur = Probleme::create([
            "libelle_probleme" => "Erreur",
            "id_famille_probleme" => $logiciel->id_famille_probleme
        ]);

        $fct = Probleme::create([
            "libelle_probleme" => "Fonction non disponible",
            "id_famille_probleme" => $logiciel->id_famille_probleme
        ]);

        $sauv = Probleme::create([
            "libelle_probleme" => "Problème de sauvegarde",
            "id_famille_probleme" => $logiciel->id_famille_probleme
        ]);

        $licence = Probleme::create([
            "libelle_probleme" => "Licence expirée",
            "id_famille_probleme" => $logiciel->id_famille_probleme
        ]);

        $crash = Probleme::create([
            "libelle_probleme" => "Crash",
            "id_famille_probleme" => $materiel->id_famille_probleme
        ]);

        $dysfct = Probleme::create([
            "libelle_probleme" => "Dysfonctionnement",
            "id_famille_probleme" => $materiel->id_famille_probleme
        ]);

        $degra = Probleme::create([
            "libelle_probleme" => "Dégradation",
            "id_famille_probleme" => $materiel->id_famille_probleme
        ]);

        $vol = Probleme::create([
            "libelle_probleme" => "Vol",
            "id_famille_probleme" => $materiel->id_famille_probleme
        ]);

        $connexion = Probleme::create([
            "libelle_probleme" => "Connexion",
            "id_famille_probleme" => $utilisateur->id_famille_probleme
        ]);

        $mess = Probleme::create([
            "libelle_probleme" => "Messagerie",
            "id_famille_probleme" => $logiciel->id_famille_probleme
        ]);

        $accescase = Probleme::create([
            "libelle_probleme" => "Accès aux casiers",
            "id_famille_probleme" => $utilisateur->id_famille_probleme
        ]);

        // Type Probleme
        // $tra->famille_probleme()->save($logiciel);

        $tra = Probleme_Type::create([
            "libelle_type_probleme" => "Traitement texte",
            "id_famille_probleme" => $logiciel->id_famille_probleme
        ]);

        $os = Probleme_Type::create([
            "libelle_type_probleme" => "OS",
            "id_famille_probleme" => $materiel->id_famille_probleme
        ]);

        $erp = Probleme_Type::create([
            "libelle_type_probleme" => "ERP",
            "id_famille_probleme" => $logiciel->id_famille_probleme
        ]);

        $lec = Probleme_Type::create([
            "libelle_type_probleme" => "Lecture PDF",
            "id_famille_probleme" => $logiciel->id_famille_probleme
        ]);

        $mot = Probleme_Type::create([
            "libelle_type_probleme" => "Moteur de recherche",
            "id_famille_probleme" => $logiciel->id_famille_probleme
        ]);

        $sui = Probleme_Type::create([
            "libelle_type_probleme" => "Suite bureautique",
            "id_famille_probleme" => $logiciel->id_famille_probleme
        ]);

        $ges = Probleme_Type::create([
            "libelle_type_probleme" => "Gestionnaire de fichiers",
            "id_famille_probleme" => $logiciel->id_famille_probleme
        ]);

        $cli = Probleme_Type::create([
            "libelle_type_probleme" => "Client de messagerie",
            "id_famille_probleme" => $logiciel->id_famille_probleme
        ]);

        $ant = Probleme_Type::create([
            "libelle_type_probleme" => "Antivirus",
            "id_famille_probleme" => $logiciel->id_famille_probleme
        ]);

        $ges = Probleme_Type::create([
            "libelle_type_probleme" => "Gestion de projet",
            "id_famille_probleme" => $utilisateur->id_famille_probleme
        ]);

        $dé = Probleme_Type::create([
            "libelle_type_probleme" => "Développement",
            "id_famille_probleme" => $utilisateur->id_famille_probleme
        ]);

        $lec = Probleme_Type::create([
            "libelle_type_probleme" => "Lecture multimédia",
            "id_famille_probleme" => $logiciel->id_famille_probleme
        ]);

        $car = Probleme_Type::create([
            "libelle_type_probleme" => "Carte mère",
            "id_famille_probleme" => $materiel->id_famille_probleme
        ]);

        $ali = Probleme_Type::create([
            "libelle_type_probleme" => "Alimentation",
            "id_famille_probleme" => $materiel->id_famille_probleme
        ]);

        $dis = Probleme_Type::create([
            "libelle_type_probleme" => "Disque dur",
            "id_famille_probleme" => $materiel->id_famille_probleme
        ]);

        $ecr = Probleme_Type::create([
            "libelle_type_probleme" => "Ecran",
            "id_famille_probleme" => $materiel->id_famille_probleme
        ]);

        $imp = Probleme_Type::create([
            "libelle_type_probleme" => "Imprimante",
            "id_famille_probleme" => $materiel->id_famille_probleme
        ]);

        $cla = Probleme_Type::create([
            "libelle_type_probleme" => "Clavier",
            "id_famille_probleme" => $materiel->id_famille_probleme
        ]);

        $sou = Probleme_Type::create([
            "libelle_type_probleme" => "Souris",
            "id_famille_probleme" => $materiel->id_famille_probleme
        ]);

        $lec = Probleme_Type::create([
            "libelle_type_probleme" => "Lecteur disque",
            "id_famille_probleme" => $materiel->id_famille_probleme
        ]);

        $por = Probleme_Type::create([
            "libelle_type_probleme" => "Port USB",
            "id_famille_probleme" => $materiel->id_famille_probleme
        ]);

        $ven = Probleme_Type::create([
            "libelle_type_probleme" => "Ventilation",
            "id_famille_probleme" => $materiel->id_famille_probleme
        ]);

        $oub = Probleme_Type::create([
            "libelle_type_probleme" => "Oubli mail",
            "id_famille_probleme" => $utilisateur->id_famille_probleme
        ]);

        $oub = Probleme_Type::create([
            "libelle_type_probleme" => "Oubli mot de passe",
            "id_famille_probleme" => $utilisateur->id_famille_probleme
        ]);

        $vir = Probleme_Type::create([
            "libelle_type_probleme" => "Virus",
            "id_famille_probleme" => $logiciel->id_famille_probleme
        ]);

        $acc = Probleme_Type::create([
            "libelle_type_probleme" => "Accès internet",
            "id_famille_probleme" => $materiel->id_famille_probleme
        ]);

        $sto = Probleme_Type::create([
            "libelle_type_probleme" => "Stockage",
            "id_famille_probleme" => $materiel->id_famille_probleme
        ]);

        $son = Probleme_Type::create([
            "libelle_type_probleme" => "Son",
            "id_famille_probleme" => $materiel->id_famille_probleme
        ]);

        $pop = Probleme_Type::create([
            "libelle_type_probleme" => "Pop up",
            "id_famille_probleme" => $materiel->id_famille_probleme
        ]);

        //Procédure
        $inv = Procedure::create([
            "libelle_procedure" => "Inventaire des biens"
        ]);

        $mai = Procedure::create([
            "libelle_procedure" => "Maintenance du matériel"
        ]);

        $ré = Procedure::create([
            "libelle_procedure" => "Réalisation de sauvegarde"
        ]);

        $cha = Procedure::create([
            "libelle_procedure" => "Changement d'un composant"
        ]);

        $ins = Procedure::create([
            "libelle_procedure" => "Installation d'un driver"
        ]);

        $ins = Procedure::create([
            "libelle_procedure" => "Installation d'un composant "
        ]);

        $sanchez->famillesProblemes()->attach($logiciel);
        $sanchez->famillesProblemes()->attach($utilisateur);
        $nilson->famillesProblemes()->attach($logiciel);
        $nilson->famillesProblemes()->attach($utilisateur);

    }
}
