<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Probleme extends Model
{
    use HasFactory;

    protected $table = 'problemes';
    protected $primaryKey = 'id_probleme';
    public $timestamps = false;

    protected $fillable = [
        'libelle_probleme',
        'id_famille_probleme'
    ];

    function famille_probleme() {
        return $this->hasOne(Probleme_Famille::class, 'id_famille_probleme', 'id_famille_probleme');
    }
}