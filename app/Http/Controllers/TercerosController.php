<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tercero;

class TercerosController extends Controller
{
    public function index()
    {
        $terceros = Tercero::all();

        return view('terceros.index', [
            'terceros' => $terceros,
        ]);
    }

}
