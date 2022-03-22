<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TicketIntervention extends Model
{
    use HasFactory;

    protected $table = 'ticket_interventions';
    protected $primaryKey = ['id_ticket', 'id_intervention'];
    public $timestamps = false;

    function ticket() {
        return $this->hasOne(Ticket::class, 'id_ticket', 'id_ticket');
    }

    function intervention() {
        return $this->hasOne(Ticket::class, 'id_intervention', 'id_intervention');
    }

}