<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pago;
use App\Models\Tercero;
use DateTime;
use Illuminate\Support\Facades\DB;

class PagosController extends Controller
{
    public function index()
    {
        $ordenes = ['IdRd', 'Fecha', 'Importe', 'Nombre'];
        $orden = request()->query('orden') ?: 'Nombre';
        abort_unless(in_array($orden, $ordenes), 404);

        $searchParams = [
            'IdRd' => request('IdRd'),
            'Fecha' => request('Fecha'),
            'Importe' => request('Importe'),
            'Nombre' => request('Nombre'),
        ];

        $pagos = DB::table('pagos')
            ->leftJoin('terceros', 'terceros.RD', '=', 'pagos.IdRd')
            ->select('pagos.*', 'terceros.Nombre')
            ->where('Nombre', 'LIKE', '%'.request('Nombre').'%')
            ->where('IdRd', 'LIKE', '%' . request('IdRd') . '%')
            ->where('pagos.Fecha', 'LIKE', '%' . request('Fecha') . '%')
            ->where('pagos.Importe', 'LIKE', '%' . request('Importe') . '%');

        if (request('dir') == 'desc') {
            $pagos->orderByDesc($orden);
        } else {
            $pagos->orderBy($orden);
        }

        $pagos = $pagos->paginate(20)->appends($searchParams);

        return view('pagos.index', [
            'pagos' => $pagos,
        ]);
    }

    public function show($id)
    {
        $pago = Pago::findOrFail($id);

        return view('pagos.show', [
            'pago' => $pago,
        ]);
    }

    private function validar()
    {
        $validados = request()->validate([
            'IdRd' => 'nullable',
            'Fecha' => 'nullable|date_format:Y-m-d',
            'Importe' => 'nullable',
            'Texto' => 'nullable|max:200',
        ]);

        return $validados;
    }

    public function create($IdRd)
    {
        $pago = new Pago();
        $IdRd = DB::select("SELECT terceros.RD FROM terceros WHERE terceros.RD = $IdRd");

        return view('pagos.create', [
            'pago' => $pago,
            'IdRd' => $IdRd[0]->RD,
        ]);
    }

    public function store()
    {
        $validados = $this->validar();

        $pago = new Pago();

        $pago->IdRd = $validados['IdRd'];
        $pago->Fecha = new DateTime();
        $pago->Importe = $validados['Importe'];
        $pago->Texto = $validados['Texto'];

        $pago->save();

        // Buscar el Tercero asociado al pago
        $tercero = Tercero::where('RD', $validados['IdRd'])->first();

        // Actualizar el campo Total en la tabla de terceros
        $totalPagos = Pago::where('IdRd', $validados['IdRd'])->sum('Importe');
        $Total = $tercero->Importe - $totalPagos;

        Tercero::where('RD', $validados['IdRd'])->update(['Total' => $Total]);

        if ($Total == 0) {
            Tercero::where('RD', $validados['IdRd'])->update(['FechaPagado' => $validados['Fecha'], 'Estado' => 'Pagado']);
        }

        return redirect('/terceros' . '/' . $tercero->Id)->with('success', 'Pago creado con éxito.');
    }

    public function edit($id)
    {
        $pago = Pago::findOrFail($id);

        return view('pagos.edit', [
            'pago' => $pago,
        ]);
    }

    public function update($id)
    {
        $validados = $this->validar();
        $pago = Pago::findOrFail($id);

        DB::table('pagos')
        ->where('id', $id)
        ->update([
            'IdRd' => $validados['IdRd'],
            'Fecha' => date('Y-m-d', strtotime($validados['Fecha'])),
            'Importe' => $validados['Importe'],
            'Texto' => $validados['Texto'],
        ]);

        // Buscar el Tercero asociado al pago
        $tercero = Tercero::where('RD', $validados['IdRd'])->first();

        // Actualizar el campo Total en la tabla de terceros
        $totalPagos = Pago::where('IdRd', $validados['IdRd'])->sum('Importe');
        $Total = $tercero->Importe - $totalPagos;

        Tercero::where('RD', $validados['IdRd'])->update(['Total' => $Total]);

        if ($Total == 0) {
            Tercero::where('RD', $validados['IdRd'])->update(['FechaPagado' => new DateTime(), 'Estado' => 'Pagado']);
        } else {
            Tercero::where('RD', $validados['IdRd'])->update(['FechaPagado' => null, 'Estado' => 'Pendiente']);
        }

        return redirect('pagos/'. $pago->Id)->with('success', 'Pago editado con éxito.');
    }

    public function destroy($id)
    {
        $pago = Pago::findOrFail($id);
        $terceroRD = $pago->IdRd;
        $tercero = Tercero::where('RD', $terceroRD)->first();

        // Borrar el pago
        $pago->delete();

        DB::select('DELETE FROM pagos WHERE id = ?', [$pago->Id]);

        // Recalcular el total
        $nuevoTotal = DB::table('terceros')
            ->where('RD', $terceroRD)
            ->selectRaw('Importe - COALESCE((SELECT SUM(Importe) FROM pagos WHERE IdRd = ?), 0) AS nuevoTotal', [$terceroRD])
            ->value('nuevoTotal');

        // Actualizar el total en la tabla terceros
        DB::table('terceros')
            ->where('RD', $terceroRD)
            ->update(['Total' => $nuevoTotal]);

        if ($nuevoTotal == 0) {
            Tercero::where('RD', $terceroRD)->update(['FechaPagado' => new DateTime(), 'Estado' => 'Pagado']);
        } else {
            Tercero::where('RD', $terceroRD)->update(['FechaPagado' => null, 'Estado' => 'Pendiente']);

        }

        return redirect('terceros/' . $tercero->Id)->with('success', 'Pago borrado correctamente');
    }
}
