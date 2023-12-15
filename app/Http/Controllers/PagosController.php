<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pago;
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
        $pago->Fecha = new DateTime($validados['Fecha']);
        $pago->Importe = $validados['Importe'];
        $pago->Texto = $validados['Texto'];

        $pago->save();

        return redirect('/pagos')->with('success', 'Pago creado con éxito.');
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

        return redirect('pagos/'. $pago->Id)->with('success', 'Pago editado con éxito.');
    }

    public function destroy($id)
    {
        $pago = Pago::findOrFail($id);

        $pago->delete();

        DB::select('DELETE FROM pagos WHERE id = ?', [$pago->Id]);

        return redirect('/pagos')->with('success', 'Pago borrado correctamente');
    }
}
