<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pago;
use App\Models\Tercero;
use DateTime;
use Illuminate\Support\Facades\DB;

class PagosController extends Controller
{
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
            'Fecha' => 'required|date_format:Y-m-d',
            'Importe' => 'required',
            'Compensado' => 'nullable',
            'Texto' => 'nullable|max:200',
        ]);

        return $validados;
    }

    public function create($IdRd)
    {
        $pago = new Pago();
        $tercero = DB::select("SELECT terceros.RD, terceros.Id FROM terceros WHERE terceros.RD = $IdRd");

        return view('pagos.create', [
            'pago' => $pago,
            'RD' => $tercero[0]->RD,
            'terceroId' => $tercero[0]->Id
        ]);
    }

    public function recabar()
    {
       return view('terceros.recabar');
    }


    public function store()
    {
        $validados = $this->validar();

        $pago = new Pago();

        // Buscar el Tercero asociado al pago
        $tercero = Tercero::where('RD', $validados['IdRd'])->first();

        // Calcula el Total de la tabla terceros
        $totalPagos = Pago::where('IdRd', $validados['IdRd'])->sum('Importe');
        $totalNuevoPago = $validados['Importe'] ? floatval(str_replace(['.', ',', '€'], ['', '.', ''], $validados['Importe'])) : 0;

        $saldoRestante = $tercero->Importe - ($totalPagos + $totalNuevoPago);

        // Verifica si el nuevo pago supera el importe
        if ($saldoRestante < 0) {
            return redirect()->back()->withInput()->withErrors(['Importe' => 'La cantidad introducida supera el importe pendiente.']);
        }

        $importeFormateado = $validados['Importe'] ? str_replace(['.', ',', '€'], ['', '.', ''], $validados['Importe']) : null;
        $importeFormateado = $importeFormateado ? preg_replace('/[^\d.]/', '', $importeFormateado) : null;

        $pago->IdRd = $validados['IdRd'];
        $pago->Fecha = $validados['Fecha'];
        $pago->Importe = $importeFormateado;

        // Verifica si la casilla de verificación Compensado está marcada
        if (isset($validados['Compensado'])) {
            $pago->Compensado = 1;
            $pago->Texto = 'Compensado';
        } else {
            $pago->Compensado = 0;
            $pago->Texto = $validados['Texto'];
        }

        $pago->save();


        // Calcula el Total de la tabla terceros después de agregar el nuevo pago
        $totalPagosDespues = Pago::where('IdRd', $validados['IdRd'])->sum('Importe');

        // Actualiza el campo FechaPagado y Estado si el Total es 0
        $Total = $tercero->Importe - $totalPagosDespues;

        if ($Total == 0) {
            Tercero::where('RD', $validados['IdRd'])->update(['FechaPagado' => $pago->Fecha, 'Estado' => 'Pagado']);
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

        $importeFormateado = $validados['Importe'] ? str_replace(['.', ',', '€'], ['', '.', ''], $validados['Importe']) : null;
        $importeFormateado = $importeFormateado ? preg_replace('/[^\d.]/', '', $importeFormateado) : null;

        // Verifica si la casilla de verificación Compensado está marcada
        $compensado = isset($validados['Compensado']) ? 1 : 0;
        $texto = $compensado ? 'Compensado' : $validados['Texto'];

        DB::table('pagos')
        ->where('id', $id)
        ->update([
            'Fecha' => date('Y-m-d', strtotime($validados['Fecha'])),
            'Importe' => $importeFormateado,
            'Compensado' => $compensado,
            'Texto' => $texto,
        ]);

        // Buscar el Tercero asociado al pago
        $tercero = Tercero::where('RD', $pago->IdRd)->first();

        // Calcula el Total de la tabla terceros
        $totalPagos = Pago::where('IdRd', $tercero->RD)->sum('Importe');
        $Total = $tercero->Importe - $totalPagos;

        if ($Total == 0) {
            Tercero::where('RD', $pago->IdRd)->update(['FechaPagado' => $validados['Fecha'], 'Estado' => 'Pagado']);
        } else {
            Tercero::where('RD', $pago->IdRd)->update(['FechaPagado' => null, 'Estado' => 'Pendiente']);
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

        if ($nuevoTotal == 0) {
            Tercero::where('RD', $terceroRD)->update(['FechaPagado' => new DateTime(), 'Estado' => 'Pagado']);
        } else {
            Tercero::where('RD', $terceroRD)->update(['FechaPagado' => null, 'Estado' => 'Pendiente']);
        }

        return redirect('terceros/' . $tercero->Id)->with('success', 'Pago borrado correctamente');
    }
}
