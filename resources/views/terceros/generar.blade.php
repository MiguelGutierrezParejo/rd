<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pdf.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <title>Listado de RD</title>
</head>
<body>
    <!--Establecer paginación -->
    <script type="text/php">
        if ( isset($pdf) ) {
            $text = "Página {PAGE_NUM} de {PAGE_COUNT}";
            $size = 10;
            $font = $fontMetrics->getFont("arial");
            $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
            $x = $pdf->get_width() - 90;
            $y = $pdf->get_height() - 25;
            $pdf->page_text($x, $y, $text, $font, $size);
        }
    </script>
    <div>
        <div class="flex">
            <div><img src='http://localhost/rd/public/Gmu_trans_Horizontal.png' width="20%" height="20%" />
            </div>
            <div>
                <h4 class="pdf text-right font-semibold">Listado de RD desde
                    {{ $request->Desde != '0000-00-00' ? date('d-m-Y', strtotime($request->Desde)) : 'siempre' }}
                    hasta el
                    {{ date('d-m-Y', strtotime($request->Hasta)) }}</h4>
            </div>
        </div>
        <div>
            <h2 class="text-2xl font-semibold">ICIO {{$request->Estado}}</h2>
            <table class="table-layoit:fixed border border-red-500 border-collapse mt-5">
                @if ($request->Estado != 'Todos')
                    <thead>
                        <tr>
                            <th style="text-align: left" class="border border-slate-300 px-2 font-semibold">RD</th>
                            <th style="text-align: left" class="border border-slate-300 px-2 font-semibold">Nombre</th>
                            <th style="text-align: left" class="border border-slate-300 px-2 font-semibold">DNI</th>
                            <th style="text-align: left" class="border border-slate-300 px-2 font-semibold">Expediente</th>
                            <th style="text-align: left" class="border border-slate-300 px-2 font-semibold">Importe</th>
                            <th style="text-align: left" class="border border-slate-300 px-2 font-semibold">Compensado</th>
                            <th style="text-align: left" class="border border-slate-300 px-2 font-semibold">Fraccionado</th>
                            <th style="text-align: left" class="border border-slate-300 px-2 font-semibold">Pendiente</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($terceros as $tercero)
                            <tr class="border border-slate-400">
                                <td class="border border-slate-300 px-2 ">{{ $tercero->RD }}</td>
                                <td class="border border-slate-300 px-2 ">{{ $tercero->Nombre }}</td>
                                <td class="border border-slate-300 px-2 ">{{ $tercero->DNI }}</td>
                                <td class="border border-slate-300 px-2 ">{{ $tercero->Expediente }}</td>
                                <td class="border border-slate-300 px-2 ">{{ $tercero->Importe }}</td>
                                <td class="border border-slate-300 px-2 ">{{ $tercero->Compensado }}</td>
                                <td class="border border-slate-300 px-2 ">{{ $tercero->Importe }}</td>
                                <td class="border border-slate-300 px-2 ">{{ $tercero->Importe }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                @else
                    <thead>
                        <tr>
                            <th style="text-align: left" class="border border-slate-300 px-2 font-semibold">RD</th>
                            <th style="text-align: left" class="border border-slate-300 px-2 font-semibold">Nombre</th>
                            <th style="text-align: left" class="border border-slate-300 px-2 font-semibold">DNI</th>
                            <th style="text-align: left" class="border border-slate-300 px-2 font-semibold">Expediente</th>
                            <th style="text-align: left" class="border border-slate-300 px-2 font-semibold">Importe</th>
                            <th style="text-align: left" class="border border-slate-300 px-2 font-semibold">Compensado</th>
                            <th style="text-align: left" class="border border-slate-300 px-2 font-semibold">Fraccionado</th>
                            <th style="text-align: left" class="border border-slate-300 px-2 font-semibold">Estado</th>
                            <th style="text-align: left" class="border border-slate-300 px-2 font-semibold">Pendiente</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tercerostodos as $tercerotodo)
                            <tr class="border border-slate-400">
                                <td class="border border-slate-300 px-2 ">{{ $tercerotodo->RD }}</td>
                                <td class="border border-slate-300 px-2 ">{{ $tercerotodo->Nombre }}</td>
                                <td class="border border-slate-300 px-2 ">{{ $tercerotodo->DNI }}</td>
                                <td class="border border-slate-300 px-2 ">{{ $tercerotodo->Expediente }}</td>
                                <td class="border border-slate-300 px-2 ">{{ $tercerotodo->Importe }}</td>
                                <td class="border border-slate-300 px-2 ">{{ $tercerotodo->Compensado }}</td>
                                <td class="border border-slate-300 px-2 ">{{ $tercerotodo->Importe }}</td>
                                <td class="border border-slate-300 px-2 ">{{ $tercerotodo->Estado }}</td>
                                <td class="border border-slate-300 px-2 ">{{ $tercerotodo->Importe }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                @endif
            </table>
        </div>
        <br>
    </div>
</body>
</html>
