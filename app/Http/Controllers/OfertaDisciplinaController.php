<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OfertaDisciplina;
use App\Models\ParticipanteOferta;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class OfertaDisciplinaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        // Sólo administradores pueden administrar ofertas
        $this->middleware(function ($request, $next) {
            if (auth()->user()->rol !== 'Administrador') {
                abort(403, 'Acceso denegado.');
            }
            return $next($request);
        });
    }

    // Mostrar listado de ofertas (para administrar)
    public function index(Request $request)
    {
        $ofertas = OfertaDisciplina::with('disciplina')->orderBy('inicio_inscripcion', 'desc')->get();
        return view('ofertas.index', compact('ofertas'));
    }

    // Crear nueva disciplina con oferta
public function store(Request $request)
{
    $rules = [
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string|max:2000',
        'inicio_inscripcion' => 'required|date',
        'fin_inscripcion' => 'required|date|after_or_equal:inicio_inscripcion',
        'capacidad' => 'required|integer|min:1',
    ];

    $validated = $request->validate($rules);

    DB::beginTransaction();
    try {
        // Crear la disciplina primero
        $disciplina = \App\Models\Disciplina::create([
            'nombre' => $validated['nombre'],
            'descripcion' => $validated['descripcion'] ?? null,
        ]);

        // Luego crear la oferta asociada
        OfertaDisciplina::create([
            'disciplina_id' => $disciplina->id,
            'capacidad' => $validated['capacidad'],
            'inicio_inscripcion' => $validated['inicio_inscripcion'],
            'fin_inscripcion' => $validated['fin_inscripcion'],
        ]);

        DB::commit();
        return response()->json(['mensaje' => '✅ Disciplina y oferta registradas correctamente.']);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['mensaje' => '❌ Error al registrar: ' . $e->getMessage()], 500);
    }
}


    // Actualizar oferta
    public function update(Request $request, $id)
    {
        $oferta = OfertaDisciplina::findOrFail($id);

        $rules = [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:2000',
            'inicio_inscripcion' => 'required|date',
            'fin_inscripcion' => 'required|date|after_or_equal:inicio_inscripcion',
            'capacidad' => 'required|integer|min:1',
        ];

        $validated = $request->validate($rules);

        DB::beginTransaction();
        try {
            // Si el nombre/descripcion están en tabla Disciplina relacionada,
            // actualiza la disciplina también (si aplicable).
            // Asumimos que OfertaDisciplina tiene disciplina relacionada con fields en otra tabla.
            // Aquí sólo actualizamos campos de la oferta
            $oferta->update([
                'inicio_inscripcion' => Carbon::parse($validated['inicio_inscripcion'])->toDateString(),
                'fin_inscripcion' => Carbon::parse($validated['fin_inscripcion'])->toDateString(),
                'capacidad' => (int) $validated['capacidad'],
            ]);

            // Si quieres actualizar nombre/descripcion en tabla Disciplina:
            if (!empty($validated['nombre']) || array_key_exists('descripcion', $validated)) {
                $disc = $oferta->disciplina;
                if ($disc) {
                    $disc->nombre = $validated['nombre'];
                    $disc->descripcion = $validated['descripcion'] ?? $disc->descripcion;
                    $disc->save();
                }
            }

            DB::commit();

            return response()->json(['mensaje' => 'Oferta actualizada correctamente.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => 'Error al actualizar: ' . $e->getMessage()], 500);
        }
    }

    // Eliminar oferta (solo si fin_inscripcion ya pasó)
    public function destroy($id)
    {
        $oferta = OfertaDisciplina::with('inscripciones')->findOrFail($id);
        $hoy = Carbon::today();

        // Si la fecha fin no ha pasado aún -> prohibir eliminar
        if ($hoy->lte(Carbon::parse($oferta->fin_inscripcion))) {
            return response()->json(['mensaje' => 'No se puede eliminar esta oferta hasta que termine el periodo de inscripciones.'], 422);
        }

        DB::beginTransaction();
        try {
            // Eliminar inscripciones asociadas (puedes usar delete() o softDeletes)
            // Si ParticipanteOferta usa SoftDeletes, usa delete() para soft-delete
            ParticipanteOferta::where('oferta_disciplina_id', $oferta->id)->delete();

            // Finalmente eliminar la oferta
            $oferta->delete();

            DB::commit();

            return response()->json(['mensaje' => 'Oferta eliminada correctamente, y se eliminaron las inscripciones relacionadas.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => 'Error al eliminar: ' . $e->getMessage()], 500);
        }
    }
}
