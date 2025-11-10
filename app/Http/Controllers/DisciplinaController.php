<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Disciplina;
use App\Models\OfertaDisciplina;
use App\Models\Participante;
use App\Models\ParticipanteOferta;

class DisciplinaController extends Controller
{
    public function index()
    {
        // Verificar participante registrado (no soft-deleted)
        $usuario = Auth::user();
        $participante = Participante::where('user_id', $usuario->id)->whereNull('deleted_at')->first();

        // Traer ofertas activas (puedes ajustar criterio)
        $hoy = Carbon::today();
        $ofertas = OfertaDisciplina::with('disciplina')
            ->where('inicio_inscripcion', '<=', $hoy)
            ->where('fin_inscripcion', '>=', $hoy)
            ->get();

        // Si el usuario es participante, obtener sus inscripciones activas
        $selecciones = [];
        if ($participante) {
            $selecciones = ParticipanteOferta::where('participante_id', $participante->id)
                ->whereNull('deleted_at')
                ->pluck('oferta_disciplina_id')
                ->toArray();
        }

        return view('disciplinas', [
            'participante' => $participante,
            'ofertas' => $ofertas,
            'selecciones' => $selecciones,
        ]);
    }

    public function seleccionar(Request $request)
    {
        $request->validate([
            'oferta_id' => 'required|integer|exists:ofertas_disciplinas,id',
        ]);

        $usuario = Auth::user();
        $participante = Participante::where('user_id', $usuario->id)->whereNull('deleted_at')->first();

        if (!$participante) {
            return response()->json(['mensaje' => 'Debes registrarte antes de seleccionar disciplinas.'], 422);
        }

        $ofertaId = (int) $request->oferta_id;

        DB::beginTransaction();
        try {
            // Bloqueamos la fila de la oferta
            $oferta = OfertaDisciplina::where('id', $ofertaId)->lockForUpdate()->firstOrFail();

            $hoy = Carbon::today();
            if ($hoy->lt(Carbon::parse($oferta->inicio_inscripcion)) || $hoy->gt(Carbon::parse($oferta->fin_inscripcion))) {
                DB::rollBack();
                return response()->json(['mensaje' => 'El periodo de inscripción para esta oferta está cerrado.'], 422);
            }

            // Contar inscripciones activas en esta oferta
            $ocupados = ParticipanteOferta::where('oferta_disciplina_id', $oferta->id)->whereNull('deleted_at')->count();

            if ($ocupados >= $oferta->capacidad) {
                DB::rollBack();
                return response()->json(['mensaje' => 'Ya no hay cupos disponibles en esta oferta.'], 422);
            }

            // Verificar que el participante no esté ya inscrito en esta oferta
            $ya = ParticipanteOferta::where('participante_id', $participante->id)
                ->where('oferta_disciplina_id', $oferta->id)
                ->whereNull('deleted_at')
                ->exists();
            if ($ya) {
                DB::rollBack();
                return response()->json(['mensaje' => 'Ya estás inscrito en esta disciplina.'], 422);
            }

            // Verificar límite de 2 disciplinas por participante
            $contador = ParticipanteOferta::where('participante_id', $participante->id)
                ->whereNull('deleted_at')
                ->count();
            if ($contador >= 2) {
                DB::rollBack();
                return response()->json(['mensaje' => 'Solo puedes seleccionar hasta 2 disciplinas.'], 422);
            }

            // Crear inscripción
            ParticipanteOferta::create([
                'participante_id' => $participante->id,
                'oferta_disciplina_id' => $oferta->id,
            ]);

            DB::commit();

            return response()->json(['mensaje' => 'Inscripción realizada con éxito.', 'oferta_id' => $oferta->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al seleccionar oferta: ' . $e->getMessage());
            return response()->json(['mensaje' => 'Ocurrió un error interno. Intenta de nuevo.'], 500);
        }
    }

    public function deseleccionar(Request $request)
    {
        $request->validate([
            'oferta_id' => 'required|integer|exists:ofertas_disciplinas,id',
        ]);

        $usuario = Auth::user();
        $participante = Participante::where('user_id', $usuario->id)->whereNull('deleted_at')->first();

        if (!$participante) {
            return response()->json(['mensaje' => 'Debes registrarte primero.'], 422);
        }

        $ofertaId = (int) $request->oferta_id;

        $inscripcion = ParticipanteOferta::where('participante_id', $participante->id)
            ->where('oferta_disciplina_id', $ofertaId)
            ->whereNull('deleted_at')
            ->first();

        if (!$inscripcion) {
            return response()->json(['mensaje' => 'No tienes una inscripción activa en esta oferta.'], 422);
        }

        try {
            $inscripcion->delete();
            return response()->json(['mensaje' => 'Inscripción cancelada correctamente.', 'oferta_id' => $ofertaId]);
        } catch (\Exception $e) {
            Log::error('Error al deseleccionar: ' . $e->getMessage());
            return response()->json(['mensaje' => 'Ocurrió un error al cancelar. Intenta de nuevo.'], 500);
        }
    }
}
