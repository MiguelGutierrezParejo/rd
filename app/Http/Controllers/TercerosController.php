<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tercero;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TercerosController extends Controller
{
    public function index()
    {
        $ordenes = ['Nombre', 'DNI', 'Expediente', 'Estado', 'Importe', 'RD'];
        $orden = request()->query('orden') ?: 'RD';
        abort_unless(in_array($orden, $ordenes), 404);

        $searchParams = [
            'Nombre' => request('Nombre'),
            'DNI' => request('DNI'),
            'Expediente' => request('Expediente'),
            'Estado' => request('Estado'),
            'Importe' => request('Importe'),
            'RD' => request('RD'),
        ];

        $terceros = DB::table('terceros')
            ->select('terceros.*')
            ->where('Nombre', 'LIKE', '%' . request('Nombre') . '%')
            ->where('DNI', 'LIKE', '%' . request('DNI') . '%')
            ->where('Expediente', 'LIKE', '%' . request('Expediente') . '%')
            ->where('Estado', 'LIKE', '%' . request('Estado') . '%')
            ->where('Importe', 'LIKE', '%' . request('Importe') . '%')
            ->where('RD', 'LIKE', '%' . request('RD') . '%');

        if (request('dir') == 'asc') {
            $terceros->orderBy($orden);
        } else {
            $terceros->orderByDesc($orden);
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

    public function recabar()
    {
        return view('terceros.recabar');
    }

    public function generar(Request $request)
    {
        if ($request->Hasta == null) {
            $request->Hasta = Carbon::now();
        }

        if ($request->Desde == null) {
            $request->Desde = '0000-00-00';
        }

        if ($request->Estado != 'Todos') {
            $terceros = Tercero::select(
                'terceros.Nombre',
                'terceros.RD',
                'terceros.DNI',
                'terceros.Importe',
                'terceros.Expediente',
                DB::raw('SUM(CASE WHEN pagos.Compensado = 1 OR pagos.Texto = "Compensado" THEN pagos.Importe ELSE 0 END) as sumaCompensados'),
                DB::raw('SUM(CASE WHEN pagos.Compensado = 0 THEN pagos.Importe ELSE 0 END) as sumaNoCompensados'),
                DB::raw('CASE WHEN SUM(pagos.Importe) IS NULL THEN terceros.Importe ELSE terceros.Importe - SUM(pagos.Importe) END as diferencia')
            )
                ->leftJoin('pagos', 'terceros.RD', '=', 'pagos.IdRd')
                ->where('terceros.Fecha', '>=', $request->Desde)
                ->where('terceros.Fecha', '<=', $request->Hasta)
                ->where('Estado', $request->Estado)
                ->groupBy('terceros.Nombre', 'terceros.RD', 'terceros.DNI', 'terceros.Importe', 'terceros.Expediente', 'terceros.Fecha') // Agrupa por el campo que identifica a cada persona
                ->orderBy('terceros.Fecha')
                ->get();

            // Calcular total
            $totales = $terceros->groupBy(function ($tercero) {
                return Carbon::parse($tercero->Fecha)->year;
            })->map(function ($items, $year) {
                return [
                    'year' => $year,
                    'totalImporte' => $items->sum('Importe'),
                    'totalCompensados' => $items->sum('sumaCompensados'),
                    'totalNoCompensados' => $items->sum('sumaNoCompensados'),
                    'totalDiferencia' => $items->sum('diferencia'),
                ];
            })->values();
        } else {
            $terceros = Tercero::select(
                'terceros.Nombre',
                'terceros.RD',
                'terceros.DNI',
                'terceros.Importe',
                'terceros.Expediente',
                'terceros.Estado',
                DB::raw('SUM(CASE WHEN pagos.Compensado = 1 THEN pagos.Importe ELSE 0 END) as sumaCompensados'),
                DB::raw('SUM(CASE WHEN pagos.Compensado = 0 THEN pagos.Importe ELSE 0 END) as sumaNoCompensados'),
                DB::raw('CASE WHEN SUM(pagos.Importe) IS NULL THEN terceros.Importe ELSE terceros.Importe - SUM(pagos.Importe) END as diferencia')
            )
                ->leftJoin('pagos', 'terceros.RD', '=', 'pagos.IdRd')
                ->where('Terceros.Fecha', '>=', $request->Desde)
                ->where('Terceros.Fecha', '<=', $request->Hasta)
                ->where('Estado', '!=', 'Anulado')
                ->groupBy('terceros.Nombre', 'terceros.RD', 'terceros.DNI', 'terceros.Importe', 'terceros.Expediente', 'terceros.Estado', 'terceros.Fecha') // Agrupa por el campo que identifica a cada persona
                ->orderBy('terceros.Fecha')
                ->get();

            // Calcular total
            $totales = $terceros->groupBy(function ($tercero) {
                return Carbon::parse($tercero->Fecha)->year;
            })->map(function ($items, $year) {
                return [
                    'year' => $year,
                    'totalImporte' => $items->sum('Importe'),
                    'totalCompensados' => $items->sum('sumaCompensados'),
                    'totalNoCompensados' => $items->sum('sumaNoCompensados'),
                    'totalDiferencia' => $items->sum('diferencia'),
                ];
            })->values();
        }

        $pdf = Pdf::loadView('terceros.generar', [
            'terceros' => $terceros,
            'totales' => $totales,
            'request' => $request,
        ])->setPaper('a4', 'landscape');
        return $pdf->stream();
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
            'RD' => 'nullable',
            'Estado' => 'nullable|max:50',
            'FechaPagado' => 'nullable|date_format:Y-m-d',
            'FechaEjecutiva' => 'nullable|date_format:Y-m-d',
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

        $importeFormateado = $validados['Importe'] ? str_replace(['.', ',', '€'], ['', '.', ''], $validados['Importe']) : null;
        $importeFormateado = $importeFormateado ? preg_replace('/[^\d.]/', '', $importeFormateado) : null;

        $tercero->Importe = $importeFormateado;
        $tercero->Fecha = new DateTime($validados['Fecha']);
        $tercero->Texto = $validados['Texto'];
        $tercero->Estado = 'Pendiente';
        $tercero->Total = $importeFormateado;
        $tercero->FechaPagado = null;
        $tercero->FechaEjecutiva = null;
        $tercero->FechaAnulacion = null;

        // Crear RD
        $año = $tercero->Fecha->format('Y');
        $numeroRegistros = Tercero::whereYear('Fecha', $año)->count();
        $tercero->RD = $año . str_pad($numeroRegistros + 1, 4, '0', STR_PAD_LEFT);

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

        $importeFormateado = $validados['Importe'] ? str_replace(['.', ',', '€'], ['', '.', ''], $validados['Importe']) : null;
        $importeFormateado = $importeFormateado ? preg_replace('/[^\d.]/', '', $importeFormateado) : null;

        DB::table('terceros')
            ->where('id', $id)
            ->update([
                'Nombre' => $validados['Nombre'],
                'DNI' => $validados['DNI'],
                'Expediente' => $validados['Expediente'],
                'Importe' => $importeFormateado,
                'Fecha' => date('Y-m-d', strtotime($validados['Fecha'])),
                'Texto' => $validados['Texto'],
            ]);

        return redirect('terceros/' . $tercero->Id)->with('success', 'Registro editado con éxito.');
    }

    public function fechaanular($id)
    {
        $tercero = Tercero::findOrFail($id);

        return view('terceros.fechaanular', [
            'tercero' => $tercero,
        ]);
    }

    public function anular($id)
    {
        $tercero = Tercero::findOrFail($id);
        $validados = $this->validar();

        // Obtener el usuario autenticado
        $usuarioAutenticado = auth()->user();

        // Verificar la contraseña
        if (!Hash::check(request()->input('Contraseña'), $usuarioAutenticado->password)) {
            return redirect()->back()->withErrors(['Contraseña' => 'La contraseña no es correcta'])->with('error', 'Verifique los datos introducidos');
        }

        DB::table('terceros')
            ->where('id', $id)
            ->update([
                'FechaAnulacion' => $validados['FechaAnulacion'],
                'Motivo' => $validados['Motivo'],
                'Estado' => 'Anulado',
            ]);

        return redirect('terceros/' . $tercero->Id)->with('success', 'Fecha de anulación añadida correctamente');
    }

    public function reactivar($id)
    {
        $tercero = Tercero::findOrFail($id);

        DB::table('terceros')
            ->where('id', $id)
            ->update([
                'FechaAnulacion' => null,
                'Estado' => 'Pendiente',
            ]);

        return redirect('terceros/' . $tercero->Id)->with('success', 'Registro dado de alta correctamente');
    }

    public function fechaejecutiva($id)
    {
        $tercero = Tercero::findOrFail($id);

        return view('terceros.fechaejecutiva', [
            'tercero' => $tercero,
        ]);
    }

    public function ejecutiva($id)
    {
        $tercero = Tercero::findOrFail($id);
        $validados = $this->validar();

        DB::table('terceros')
            ->where('id', $id)
            ->update([
                'FechaEjecutiva' => $validados['FechaEjecutiva'],
                'Motivo' => $validados['Motivo'],
                'Estado' => 'Ejecutiva',
            ]);

        return redirect('terceros/' . $tercero->Id)->with('success', 'Fecha de ejecutiva añadida correctamente');
    }

    public function noejecutiva($id)
    {
        $tercero = Tercero::findOrFail($id);

        DB::table('terceros')
            ->where('id', $id)
            ->update([
                'FechaEjecutiva' => null,
                'Estado' => 'Pendiente',
            ]);

        return redirect('terceros/' . $tercero->Id)->with('success', 'Registro modificado correctamente');
    }
}
