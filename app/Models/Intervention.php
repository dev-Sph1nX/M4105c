<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Intervention extends Model
{
    use HasFactory;

    protected $table = 'interventions';
    protected $primaryKey = 'id_intervention';
    public $timestamps = false;

    protected $with = ['operateur'];

    function operateur(){
        return $this->hasOne(User::class, 'id', 'id_operateur');
    }
    function ticket(){ 
        return $this->hasOne(User::class, 'id', 'id_operateur');
    }
}