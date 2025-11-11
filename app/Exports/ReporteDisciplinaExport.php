<?php

namespace App\Exports;

use App\Models\ParticipanteOferta;
use App\Models\OfertaDisciplina;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReporteDisciplinaExport implements FromCollection, WithHeadings, WithMapping
{
    protected $disciplinaId;

    public function __construct($disciplinaId)
    {
        $this->disciplinaId = $disciplinaId;
    }

    public function collection()
    {
        return ParticipanteOferta::with(['participante', 'oferta.disciplina'])
            ->whereHas('oferta', fn($q) => $q->where('disciplina_id', $this->disciplinaId))
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID Participante',
            'Nombre',
            'Número Trabajador',
            'Disciplina',
            'Estado',
            'Fecha de Registro'
        ];
    }

    public function map($row): array
    {
        return [
            $row->participante->id ?? '-',
            $row->participante->nombre_completo ?? '-',
            $row->participante->numero_trabajador ?? '-',
            $row->oferta->disciplina->nombre ?? '-',
            ucfirst($row->estado),
            $row->created_at->format('Y-m-d H:i')
        ];
    }
}
