<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Probleme_Famille extends Model
{
    use HasFactory;

    protected $table = 'famille_problemes';
    protected $primaryKey = 'id_famille_probleme';
    public $timestamps = false;

    protected $fillable = [
        'id_famille_probleme',
        'libelle_famille_probleme',
    ];

    public function users(){
        return $this->belongsToMany(User::class, 'operateur_famille_problemes', 
        'id_utilisateur', 'id_famille_probleme', 'id_famille_probleme', 'id');
    }
}