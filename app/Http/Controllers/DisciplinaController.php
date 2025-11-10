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

        return view('disciplinas.index', [
            'participante' => $participante,
            'ofertas' => $ofertas,
            'selecciones' => $selecciones,
        ]);
    }

    public function seleccionar(Request $request)
    {
        $request->validate([
            'oferta_id' => 'required|integer|exists:ofertas_disciplinas,id'
        ]);

        $usuario = Auth::user();
        $participante = Participante::where('user_id', $usuario->id)->whereNull('deleted_at')->first();

        if (!$participante) {
            return response()->json(['mensaje' => 'Debes registrarte primero.'], 422);
        }

        DB::beginTransaction();
        try {
            $oferta = OfertaDisciplina::where('id', $request->oferta_id)->lockForUpdate()->first();
            $hoy = Carbon::today();

            if ($hoy->lt(Carbon::parse($oferta->inicio_inscripcion)) || $hoy->gt(Carbon::parse($oferta->fin_inscripcion))) {
                DB::rollBack();
                return response()->json(['mensaje' => 'La inscripción para esta disciplina no está disponible.'], 422);
            }

            $ocupados = ParticipanteOferta::where('oferta_disciplina_id', $oferta->id)
                ->where('estado', 'aprobada')
                ->count();

            if ($ocupados >= $oferta->capacidad) {
                DB::rollBack();
                return response()->json(['mensaje' => 'No hay cupos disponibles.'], 422);
            }

            $yaSolicitada = ParticipanteOferta::where('participante_id', $participante->id)
                ->where('oferta_disciplina_id', $oferta->id)
                ->exists();

            if ($yaSolicitada) {
                DB::rollBack();
                return response()->json(['mensaje' => 'Ya solicitaste esta disciplina. Espera la respuesta del comité.'], 422);
            }

            $totalSolicitadas = ParticipanteOferta::where('participante_id', $participante->id)
                ->whereNull('deleted_at')
                ->count();

            if ($totalSolicitadas >= 2) {
                DB::rollBack();
                return response()->json(['mensaje' => 'Solo puedes solicitar hasta 2 disciplinas.'], 422);
            }

            ParticipanteOferta::create([
                'participante_id' => $participante->id,
                'oferta_disciplina_id' => $oferta->id,
                'estado' => 'pendiente'
            ]);

            DB::commit();
            return response()->json(['mensaje' => 'Solicitud enviada correctamente. Espera la validación del comité.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => 'Error interno: ' . $e->getMessage()], 500);
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
