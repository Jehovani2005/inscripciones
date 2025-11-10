<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Participante;
use App\Models\OfertaDisciplina;
use App\Models\ParticipanteOferta;

class ParticipanteOfertaController extends Controller
{
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
                ->whereNull('deleted_at')
                ->count();

            if ($ocupados >= $oferta->capacidad) {
                DB::rollBack();
                return response()->json(['mensaje' => 'No hay cupos disponibles.'], 422);
            }

            $yaInscrito = ParticipanteOferta::where('participante_id', $participante->id)
                ->where('oferta_disciplina_id', $oferta->id)
                ->whereNull('deleted_at')
                ->exists();

            if ($yaInscrito) {
                DB::rollBack();
                return response()->json(['mensaje' => 'Ya estás inscrito en esta disciplina.'], 422);
            }

            $totalInscritas = ParticipanteOferta::where('participante_id', $participante->id)
                ->whereNull('deleted_at')
                ->count();

            if ($totalInscritas >= 2) {
                DB::rollBack();
                return response()->json(['mensaje' => 'Solo puedes seleccionar hasta 2 disciplinas.'], 422);
            }

            ParticipanteOferta::create([
                'participante_id' => $participante->id,
                'oferta_disciplina_id' => $oferta->id,
            ]);

            DB::commit();
            return response()->json(['mensaje' => 'Te has inscrito correctamente.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => 'Error interno: ' . $e->getMessage()], 500);
        }
    }

    public function eliminar(Request $request)
    {
        $request->validate([
            'oferta_id' => 'required|integer|exists:ofertas_disciplinas,id'
        ]);

        $usuario = Auth::user();
        $participante = Participante::where('user_id', $usuario->id)->whereNull('deleted_at')->first();

        $inscripcion = ParticipanteOferta::where('participante_id', $participante->id)
            ->where('oferta_disciplina_id', $request->oferta_id)
            ->whereNull('deleted_at')
            ->first();

        if (!$inscripcion) {
            return response()->json(['mensaje' => 'No estás inscrito en esta disciplina.'], 422);
        }

        $inscripcion->delete();
        return response()->json(['mensaje' => 'Tu inscripción fue cancelada correctamente.']);
    }
}
