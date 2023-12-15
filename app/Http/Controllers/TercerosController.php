<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tercero;
use DateTime;
use Illuminate\Support\Facades\DB;

class TercerosController extends Controller
{
    public function index()
    {
        $ordenes = ['Nombre', 'DNI', 'Expediente', 'Importe', 'RD'];
        $orden = request()->query('orden') ?: 'Nombre';
        abort_unless(in_array($orden, $ordenes), 404);

        $searchParams = [
            'Nombre' => request('Nombre'),
            'DNI' => request('DNI'),
            'Expediente' => request('Expediente'),
            'Importe' => request('Importe'),
            'RD' => request('RD'),
        ];

        $terceros = DB::table('terceros')
            ->select('terceros.*')
            ->where('Nombre', 'LIKE', '%' . request('Nombre') . '%')
            ->where('DNI', 'LIKE', '%' . request('DNI') . '%')
            ->where('Expediente', 'LIKE', '%' . request('Expediente') . '%')
            ->where('Importe', 'LIKE', '%' . request('Importe') . '%')
            ->where('RD', 'LIKE', '%' . request('RD') . '%');

        if (request('dir') == 'desc') {
            $terceros->orderByDesc($orden);
        } else {
            $terceros->orderBy($orden);
        }

        $terceros = $terceros->paginate(20)->appends($searchParams);

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

    public function create()
    {
        $tercero = new Tercero();

        return view('terceros.create', [
            'tercero' => $tercero,
        ]);
    }

    public function store()
    {
        $validados = $this->validar();

        $tercero = new Tercero();

        $tercero->Nombre = $validados['Nombre'];
        $tercero->DNI = $validados['DNI'];
        $tercero->Expediente = $validados['Expediente'];
        $tercero->Importe = $validados['Importe'];
        $tercero->Fecha = new DateTime($validados['Fecha']);
        $tercero->Texto = $validados['Texto'];
        $tercero->RD = $validados['RD'];
        $tercero->Estado = $validados['Estado'];
        $tercero->Año = $validados['Año'];
        $tercero->Total = $validados['Importe'];
        $tercero->FechaPagado = new DateTime($validados['FechaPagado']);
        $tercero->FechaEjecutiva = new DateTime($validados['FechaEjecutiva']);
        $tercero->FechaNotificacion = new DateTime($validados['FechaNotificacion']);
        $tercero->Motivo = $validados['Motivo'];
        $tercero->FechaAnulacion = new DateTime($validados['FechaAnulacion']);

        $tercero->save();

        return redirect('/terceros')->with('success', 'Registro creado con éxito.');
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
            'FechaPagado' => $validados['FechaPagado'],
            'FechaEjecutiva' => $validados['FechaEjecutiva'],
            'FechaNotificacion' => $validados['FechaNotificacion'],
            'Motivo' => $validados['Motivo'],
            'FechaAnulacion' => $validados['FechaAnulacion'],
        ]);

        // Recalcula el campo Total de la misma manera que al actualizar pagos
        $totalPagos = DB::table('pagos')->where('IdRd', $validados['RD'])->sum('Importe');
        $nuevoTotal = $validados['Importe'] - $totalPagos;

        Tercero::where('id', $id)->update(['Total' => $nuevoTotal]);
        
        return redirect('terceros/'. $tercero->Id)->with('success', 'Registro editado con éxito.');
    }

    public function destroy($id)
    {
        $tercero = Tercero::findOrFail($id);

        $tercero->delete();

        DB::select('DELETE FROM terceros WHERE id = ?', [$tercero->Id]);

        return redirect('/terceros')->with('success', 'Registro borrado correctamente');
    }
}
