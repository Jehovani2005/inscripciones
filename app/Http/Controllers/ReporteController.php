<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Disciplina;
use App\Models\ParticipanteOferta;
use App\Models\OfertaDisciplina;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReporteDisciplinaExport;
use App\Exports\ReporteConsolidadoExport;
use Carbon\Carbon;
use DB;

class ReporteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        $disciplinas = Disciplina::orderBy('nombre')->get();

        // Estadísticas generales
        $totalInscritos = ParticipanteOferta::count();
        $aprobadas = ParticipanteOferta::where('estado', 'aprobada')->count();
        $rechazadas = ParticipanteOferta::where('estado', 'rechazada')->count();
        $pendientes = ParticipanteOferta::where('estado', 'pendiente')->count();

        // Por disciplina
        $porDisciplina = OfertaDisciplina::withCount(['inscripciones as total_inscritos'])
            ->with('disciplina')
            ->get()
            ->map(fn($o) => [
                'disciplina' => $o->disciplina->nombre ?? 'Sin nombre',
                'inscritos' => $o->total_inscritos
            ]);

        return view('reportes.index', compact(
            'user', 'disciplinas', 'totalInscritos', 'aprobadas', 'rechazadas', 'pendientes', 'porDisciplina'
        ));
    }

    // 📊 Reporte por disciplina (Administrador)
    public function reportePorDisciplina(Request $request)
    {
        $disciplinaId = $request->get('disciplina_id');

        if (!$disciplinaId) {
            return back()->with('error', 'Selecciona una disciplina para generar el reporte.');
        }

        $disciplina = Disciplina::findOrFail($disciplinaId);
        $nombre = 'reporte_' . str_replace(' ', '_', strtolower($disciplina->nombre)) . '_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new ReporteDisciplinaExport($disciplinaId), $nombre);
    }

    // 📈 Reporte consolidado (Supervisor)
    public function reporteConsolidado()
    {
        $nombre = 'reporte_consolidado_' . now()->format('Ymd_His') . '.xlsx';
        return Excel::download(new ReporteConsolidadoExport, $nombre);
    }
}
