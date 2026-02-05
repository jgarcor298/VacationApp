<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $table = 'reserva';
    
    protected $fillable = ['iduser', 'idvacacion'];

    public function user() {
        return $this->belongsTo(User::class, 'iduser');
    }

    public function vacacion() {
        return $this->belongsTo(Vacacion::class, 'idvacacion');
    }
}
