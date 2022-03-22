<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Procedure extends Model
{
    use HasFactory;

    protected $table = 'procedures';
    protected $primaryKey = 'id_procedure';
    public $timestamps = false;

}