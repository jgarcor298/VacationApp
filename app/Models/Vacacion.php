<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vacacion extends Model
{
    protected $table = 'vacacion';
    protected $fillable = ['titulo', 'descripcion', 'precio', 'idtipo', 'pais'];

    public function tipo() {
        return $this->belongsTo(Tipo::class, 'idtipo');
    }

    public function fotos() {
        return $this->hasMany(Foto::class, 'idvacacion');
    }

    public function reservas() {
        return $this->hasMany(Reserva::class, 'idvacacion');
    }

    public function comentarios() {
        return $this->hasMany(Comentario::class, 'idvacacion');
    }
}
