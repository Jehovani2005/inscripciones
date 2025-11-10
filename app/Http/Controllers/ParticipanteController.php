<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participante;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ParticipanteController extends Controller
{
    public function __construct(){
        
        // Aplicar middleware de autenticación a todas las rutas
        $this->middleware('auth');

        $this->middleware(function ($request, $next) {
            if (Auth::check() && Auth::user()->rol != "Participante") {
                abort(403, 'No tienes permiso para acceder a este módulo.');
            }
            return $next($request);
        });
        
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    // Mostrar formulario
    public function create()
    {
        return view('participantes.create'); // crea esta vista: resources/views/participantes/create.blade.php
    }

    /**
     * Store a newly created resource in storage.
     */
    // Guardar registro
    public function store(Request $request)
    {
        // Validación
        $validated = $request->validate([
            'numero_trabajador'    => 'required|string|max:50',
            'curp'                 => 'required|string|max:25',
            'nombre_completo'      => 'required|string|max:255',
            'fecha_nacimiento'     => 'required|date',
            'antiguedad'           => 'required|integer|min:0|max:50',
            'fotografia'           => 'required|file|mimes:jpg,jpeg,png|image|max:5120', // 5MB
            'constancia_laboral'   => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'comprobante_pago'     => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            // Mensajes personalizados opcionales en español
            'fotografia.mimes' => 'La fotografía debe ser JPG o PNG.',
            'constancia_laboral.mimes' => 'La constancia debe ser PDF/JPG/PNG.',
            'comprobante_pago.mimes' => 'El comprobante debe ser PDF/JPG/PNG.',
            'max' => 'El archivo no puede superar los 5MB.',
        ]);

        // Preparar ruta base en disk 'public' (public/storage/...)
        $disk = 'public';

        // Guardar archivos (nombres únicos)
        $fotografiaPath = $request->file('fotografia')->storeAs(
            'participantes/' . date('Y') . '/fotografias',
            Str::uuid() . '.' . $request->file('fotografia')->getClientOriginalExtension(),
            $disk
        );

        $constanciaPath = $request->file('constancia_laboral')->storeAs(
            'participantes/' . date('Y') . '/constancias',
            Str::uuid() . '.' . $request->file('constancia_laboral')->getClientOriginalExtension(),
            $disk
        );

        $comprobantePath = $request->file('comprobante_pago')->storeAs(
            'participantes/' . date('Y') . '/comprobantes',
            Str::uuid() . '.' . $request->file('comprobante_pago')->getClientOriginalExtension(),
            $disk
        );

        // Crear el participante
        $participant = Participante::create([
            'user_id' => Auth::id(),
            'numero_trabajador' => $validated['numero_trabajador'],
            'curp' => $validated['curp'],
            'nombre_completo' => $validated['nombre_completo'],
            'fecha_nacimiento' => $validated['fecha_nacimiento'],
            'antiguedad' => $validated['antiguedad'],
            'fotografia_path' => $fotografiaPath,
            'constancia_laboral_path' => $constanciaPath,
            'comprobante_pago_path' => $comprobantePath,
        ]);

        return redirect()->route('participantes.create')->with('success', 'Registro guardado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
