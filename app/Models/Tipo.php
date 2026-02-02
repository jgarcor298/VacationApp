<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    protected $table = 'tipo';
    public $timestamps = false;
    protected $fillable = ['nombre'];

    public function vacacions() {
        return $this->hasMany(Vacacion::class, 'idtipo');
    }
}
