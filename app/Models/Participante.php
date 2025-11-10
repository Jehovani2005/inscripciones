<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Participante extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'participantes';

    protected $fillable = [
        'user_id',
        'numero_trabajador',
        'curp',
        'nombre_completo',
        'fecha_nacimiento',
        'antiguedad',
        'fotografia_path',
        'constancia_laboral_path',
        'comprobante_pago_path',
    ];

    // Relación opcional con User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ofertas()
    {
        return $this->hasMany(ParticipanteOferta::class, 'participante_id');
    }

}
