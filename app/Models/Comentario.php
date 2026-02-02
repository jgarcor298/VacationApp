<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $table = 'comentario';
    protected $fillable = ['iduser', 'idvacacion', 'texto', 'puntuacion'];

    public function user() {
        return $this->belongsTo(User::class, 'iduser');
    }

    public function vacacion() {
        return $this->belongsTo(Vacacion::class, 'idvacacion');
    }
}
