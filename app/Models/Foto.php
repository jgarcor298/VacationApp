<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    protected $table = 'foto';
    protected $fillable = ['idvacacion', 'ruta'];

    public function vacacion() {
        return $this->belongsTo(Vacacion::class, 'idvacacion');
    }
}
