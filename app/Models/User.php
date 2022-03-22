<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'id_role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $with = [
        "famillesProblemes"
    ];

    function Role() {
        return $this->hasOne(Role::class, 'id_role', 'id_role');
    }

    function TicketsOperateur() {
        return $this->hasMany(Ticket::class, 'id_operateur', 'id');
    }

    public function famillesProblemes(){
        return $this->belongsToMany(Probleme_Famille::class, 'operateur_famille_problemes', 
        'id_famille_probleme', 'id_utilisateur', 'id', 'id_famille_probleme');
    }

    function notifications() {
        return $this->hasMany(Notification::class, 'id_user', 'id');
    }
}