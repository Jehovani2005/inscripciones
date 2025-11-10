<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disciplina extends Model
{
    protected $table = 'disciplinas';
    protected $fillable = ['nombre', 'descripcion', 'tipo'];

    public function ofertas()
    {
        return $this->hasMany(OfertaDisciplina::class, 'disciplina_id');
    }
}
