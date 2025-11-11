<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participante;
use App\Models\ParticipanteOferta;
use App\Models\OfertaDisciplina;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Mail\NotificacionInscripcion;
use Illuminate\Support\Facades\Mail;

class ValidacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (auth()->user()->rol !== 'Administrador') {
                abort(403, 'Acceso denegado.');
            }
            return $next($request);
        });
    }

    // Mostrar solicitudes
    public function index(Request $request)
    {
        $estado = $request->get('estado');
        $disciplina = $request->get('disciplina');

        $query = ParticipanteOferta::with(['participante', 'oferta.disciplina'])
            ->when($estado, fn($q) => $q->where('estado', $estado))
            ->when($disciplina, fn($q) =>
                $q->whereHas('oferta.disciplina', fn($d) =>
                    $d->where('nombre', $disciplina)
                )
            )
            ->orderBy('created_at', 'desc');

        $solicitudes = $query->get();

        return view('validaciones.index', compact('solicitudes'));
    }

    // ✅ Aprobar solicitud - CORREGIDO
    public function aprobar($id)
    {
        DB::beginTransaction();

        try {
            // Cargar todas las relaciones necesarias
            $solicitud = ParticipanteOferta::with([
                'oferta.disciplina', 
                'participante.user'
            ])->lockForUpdate()->findOrFail($id);

            $oferta = $solicitud->oferta;
            $cupos = $oferta->cuposDisponibles();

            if ($cupos <= 0) {
                DB::rollBack();
                $solicitud->delete();

                return response()->json([
                    'mensaje' => '⚠️ No hay cupos disponibles en esta disciplina. El participante deberá seleccionar otra.'
                ]);
            }

            $solicitud->update([
                'estado' => 'aprobada',
                'motivo_rechazo' => ''
            ]);

            DB::commit();

            // ENVÍO DE CORREO MEJORADO
            try {
                if ($solicitud->participante && $solicitud->participante->user) {
                    $correo = $solicitud->participante->user->email;
                    $titulo = 'Inscripción Aprobada';
                    
                    // Obtener el nombre de la disciplina correctamente
                    $nombreDisciplina = $oferta->disciplina ? $oferta->disciplina->nombre : 
                                    ($oferta->nombre ?? 'Disciplina no especificada');
                    
                    $mensaje = 'Tu inscripción en la disciplina "' . $nombreDisciplina . '" ha sido aprobada. ¡Felicidades!';
                    
                    Mail::to($correo)->send(new NotificacionInscripcion($titulo, $mensaje));
                    
                    \Log::info('Correo enviado exitosamente a: ' . $correo);
                    \Log::info('Disciplina en correo: ' . $nombreDisciplina);
                } else {
                    \Log::warning('No se pudo encontrar el usuario o email para la solicitud: ' . $id);
                }
            } catch (\Exception $emailException) {
                \Log::error('Error al enviar correo: ' . $emailException->getMessage());
            }

            return response()->json([
                'mensaje' => '✅ Inscripción aprobada correctamente. Cupos restantes: ' . ($cupos - 1)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error al aprobar solicitud: ' . $e->getMessage());
            return response()->json(['mensaje' => 'Error al aprobar: ' . $e->getMessage()], 500);
        }
    }

    // ❌ Rechazar solicitud - CORREGIDO
    public function rechazar(Request $request, $id)
    {
        try {
            $solicitud = ParticipanteOferta::with([
                'oferta.disciplina', 
                'participante.user'
            ])->findOrFail($id);
            
            $motivo = $request->motivo ?? 'Sin especificar';

            $solicitud->update([
                'estado' => 'rechazada',
                'motivo_rechazo' => $motivo
            ]);

            // ENVÍO DE CORREO MEJORADO
            try {
                if ($solicitud->participante && $solicitud->participante->user) {
                    $correo = $solicitud->participante->user->email;
                    $titulo = 'Inscripción Rechazada';
                    
                    // Obtener el nombre de la disciplina correctamente
                    $nombreDisciplina = $solicitud->oferta->disciplina ? 
                                    $solicitud->oferta->disciplina->nombre : 
                                    ($solicitud->oferta->nombre ?? 'Disciplina no especificada');
                    
                    $mensaje = 'Tu inscripción en la disciplina "' . $nombreDisciplina . '" ha sido rechazada. Motivo: ' . $motivo;
                    
                    Mail::to($correo)->send(new NotificacionInscripcion($titulo, $mensaje));
                    
                    \Log::info('Correo de rechazo enviado a: ' . $correo);
                    \Log::info('Disciplina en correo rechazo: ' . $nombreDisciplina);
                } else {
                    \Log::warning('No se pudo encontrar el usuario o email para la solicitud rechazada: ' . $id);
                }
            } catch (\Exception $emailException) {
                \Log::error('Error al enviar correo de rechazo: ' . $emailException->getMessage());
            }

            return response()->json([
                'mensaje' => '❌ La inscripción fue rechazada. Motivo: ' . $motivo
            ]);

        } catch (\Exception $e) {
            \Log::error('Error al rechazar solicitud: ' . $e->getMessage());
            return response()->json(['mensaje' => 'Error al rechazar: ' . $e->getMessage()], 500);
        }
    }

    // 📄 Ver documentos
    public function documentos($id)
    {
        $participante = Participante::findOrFail($id);

        return response()->json([
            'fotografia' => Storage::url($participante->fotografia_path),
            'constancia' => Storage::url($participante->constancia_laboral_path),
            'comprobante' => Storage::url($participante->comprobante_pago_path),
        ]);
    }
}
