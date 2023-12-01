<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tercero;

class TercerosController extends Controller
{
    public function index()
    {
        $terceros = Tercero::paginate(20);

        return view('terceros.index', [
            'terceros' => $terceros,
        ]);
    }

}
