<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Etat extends Model
{
    use HasFactory;

    protected $table = 'etats';
    protected $primaryKey = 'id_etat';
    public $timestamps = false;

    protected $fillable = [
        'id_etat',
        'libelle_etat'
    ];
}