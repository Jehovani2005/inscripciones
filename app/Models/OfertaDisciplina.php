<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfertaDisciplina extends Model
{
    protected $table = 'ofertas_disciplinas';
    protected $fillable = ['disciplina_id', 'capacidad', 'inicio_inscripcion', 'fin_inscripcion'];

    public function disciplina()
    {
        return $this->belongsTo(Disciplina::class, 'disciplina_id');
    }

    public function inscripciones()
    {
        return $this->hasMany(ParticipanteOferta::class, 'oferta_disciplina_id');
    }

    public function cuposDisponibles()
    {
        // Contar solo las inscripciones aprobadas
        $ocupados = $this->inscripciones()
            ->where('estado', 'aprobada')
            ->whereNull('deleted_at')
            ->count();

        return max(0, $this->capacidad - $ocupados);
    }

}
