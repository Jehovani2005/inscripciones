<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class ParticipanteOferta extends Model
{
    // use SoftDeletes;

    protected $table = 'participante_oferta';
    protected $fillable = [
        'participante_id',
        'oferta_disciplina_id',
        'estado',
        'motivo_rechazo'
    ];

    public function oferta()
    {
        return $this->belongsTo(OfertaDisciplina::class, 'oferta_disciplina_id');
    }

    public function participante()
    {
        return $this->belongsTo(Participante::class, 'participante_id');
    }

    public function usuario()
{
    return $this->hasOneThrough(
        User::class,
        Participante::class,
        'id', // Foreign key on Participante table
        'id', // Foreign key on User table
        'participante_id', // Local key on ParticipanteOferta table
        'user_id' // Local key on Participante table
    );
}
}
