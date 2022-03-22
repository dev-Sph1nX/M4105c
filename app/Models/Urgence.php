<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Urgence extends Model
{
    use HasFactory;

    protected $table = 'urgences';
    protected $primaryKey = 'id_urgence';
    public $timestamps = false;

}