<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tercero;
use Illuminate\Support\Facades\DB;

class TercerosController extends Controller
{
    public function index()
    {
        $ordenes = ['Nombre', 'DNI', 'Expediente', 'Importe', 'RD'];
        $orden = request()->query('orden') ?: 'Nombre';
        abort_unless(in_array($orden, $ordenes), 404);

        if (request('dir') == 'desc'){
            $terceros = DB::table('terceros')
            ->select('terceros.*')
            ->where('Nombre', 'LIKE', '%'.request('Nombre').'%')
            ->where('DNI', 'LIKE', '%'.request('DNI').'%')
            ->where('Expediente', 'LIKE', '%'.request('Expediente').'%')
            ->where('Importe', 'LIKE', '%'.request('Importe').'%')
            ->where('RD', 'LIKE', '%'.request('RD').'%')
            ->orderByDesc($orden)->paginate(20);
        } else {
            $terceros = DB::table('terceros')
            ->select('terceros.*')
            ->where('Nombre', 'LIKE', '%'.request('Nombre').'%')
            ->where('DNI', 'LIKE', '%'.request('DNI').'%')
            ->where('Expediente', 'LIKE', '%'.request('Expediente').'%')
            ->where('Importe', 'LIKE', '%'.request('Importe').'%')
            ->where('RD', 'LIKE', '%'.request('RD').'%')
            ->orderBy($orden)->paginate(20);
        }

        return view('terceros.index', [
            'terceros' => $terceros,
        ]);
    }

    public function show($id)
    {
        $tercero = Tercero::findOrFail($id);

        return view('terceros.show', [
            'tercero' => $tercero,
        ]);
    }

    private function validar()
    {
        $validados = request()->validate([
            'Nombre' => 'nullable',
            'DNI' => 'nullable|max:50',
            'Expediente' => 'nullable|max:50',
            'Importe' => 'nullable',
            'Fecha' => 'nullable|date_format:Y-m-d',
            'Texto' => 'nullable|max:200',
            'RD' => 'required',
            'Estado' => 'nullable|max:50',
            'Año' => 'nullable',
            'Total' => 'nullable',
            'FechaPagado' => 'nullable|date_format:Y-m-d',
            'FechaEjecutiva' => 'nullable|date_format:Y-m-d',
            'FechaNotificacion' => 'nullable|date_format:Y-m-d',
            'Motivo' => 'nullable',
            'FechaAnulacion' => 'nullable|date_format:Y-m-d',
        ]);

        return $validados;
    }

    public function edit($id)
    {
        $tercero = Tercero::findOrFail($id);

        return view('terceros.edit', [
            'tercero' => $tercero,
        ]);
    }

    public function update($id)
    {
        $validados = $this->validar();
        $tercero = Tercero::findOrFail($id);

        DB::table('terceros')
        ->where('id', $id)
        ->update([
            'Nombre' => $validados['Nombre'],
            'DNI' => $validados['DNI'],
            'Expediente' => $validados['Expediente'],
            'Importe' => $validados['Importe'],
            'Fecha' => date('Y-m-d', strtotime($validados['Fecha'])),
            'Texto' => $validados['Texto'],
            'RD' => $validados['RD'],
            'Estado' => $validados['Estado'],
            'Año' => $validados['Año'],
            'Total' => $validados['Total'],
            'FechaPagado' => $validados['FechaPagado'],
            'FechaEjecutiva' => $validados['FechaEjecutiva'],
            'FechaNotificacion' => $validados['FechaNotificacion'],
            'Motivo' => $validados['Motivo'],
            'FechaAnulacion' => $validados['FechaAnulacion'],
        ]);

        return redirect('terceros/'. $tercero->Id)->with('success', 'Registro editado con éxito.');
    }

}
