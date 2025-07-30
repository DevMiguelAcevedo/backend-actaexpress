<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Acta;
use Illuminate\Http\Request;

class ActaController extends Controller
{
    public function index()
    {
        $actas = Acta::all();
        return response()->json($actas, 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo'        => 'required|string|max:255',
            'fecha'         => 'required|date',
            'hora_inicio'   => 'required',
            'hora_fin'      => 'required',
            'lugar'         => 'nullable|string|max:255',
            'orden_dia'     => 'nullable|string',
            'desarrollo'    => 'nullable|string',
            'acuerdos'      => 'nullable|string',
            'responsable'   => 'nullable|string|max:255',
            'asistentes'    => 'nullable|array',
            'firmas'        => 'nullable|array',
            'objetivos'     => 'nullable|string',
            'compromisos'   => 'nullable|string',
            'minuta'        => 'nullable|string',
            'conclusiones'  => 'nullable|string',
            'notas'         => 'nullable|string',
            'estado'        => 'nullable|string'
        ]);

        $acta = Acta::create($data);

        return response()->json([
            'message' => 'Acta creada exitosamente',
            'acta'    => $acta,
        ], 201);
    }

    public function show($id)
    {
        $acta = Acta::find($id);
        if (!$acta) {
            return response()->json(['error' => 'Acta no encontrada'], 404);
        }
        return response()->json($acta, 200);
    }

    public function update(Request $request, $id)
    {
        $acta = Acta::find($id);
        if (!$acta) {
            return response()->json(['error' => 'Acta no encontrada'], 404);
        }

        $data = $request->validate([
            'titulo'        => 'sometimes|string|max:255',
            'fecha'         => 'sometimes|date',
            'hora_inicio'   => 'sometimes',
            'hora_fin'      => 'sometimes',
            'lugar'         => 'nullable|string|max:255',
            'orden_dia'     => 'nullable|string',
            'desarrollo'    => 'nullable|string',
            'acuerdos'      => 'nullable|string',
            'responsable'   => 'nullable|string|max:255',
            'asistentes'    => 'nullable|array',
            'firmas'        => 'nullable|array',
            'objetivos'     => 'nullable|string',
            'compromisos'   => 'nullable|string',
            'minuta'        => 'nullable|string',
            'conclusiones'  => 'nullable|string',
            'notas'         => 'nullable|string',
            'estado'        => 'nullable|string'
        ]);

        $acta->update($data);

        return response()->json([
            'message' => 'Acta actualizada correctamente',
            'acta'    => $acta,
        ]);
    }

    public function destroy($id)
    {
        $acta = Acta::find($id);
        if (!$acta) {
            return response()->json(['error' => 'Acta no encontrada'], 404);
        }
        $acta->delete();
        return response()->json(['message' => 'Acta eliminada correctamente']);
    }
}
