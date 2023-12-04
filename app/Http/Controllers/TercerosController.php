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

    }

    public function create()
    {

    }

}
