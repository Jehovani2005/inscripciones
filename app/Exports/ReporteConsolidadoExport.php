<?php

namespace App\Exports;

use App\Models\ParticipanteOferta;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReporteConsolidadoExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return ParticipanteOferta::with(['participante', 'oferta.disciplina'])
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
