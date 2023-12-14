<x-layout>
    <div class="bg-white rounded-md max-w-4xl mx-auto p-4 space-y-4 shadow-lg">
        <div class="bg-white rounded-md max-w-4xl mx-auto p-4 space-y-4 shadow-lg">
            <div class="flex justify-between items-center">
                <strong class="text-2xl">Datos del registro</strong>
                <div class="flex space-x-2">
                    <a href="{{route('terceros.edit', ['id' => $tercero->Id])}}"
                        style="border-color:#0053D0; background-color: #0053D0"
                        class="text-white bg-blue-700 font-semibold rounded-lg text-sm px-5 py-1 mr-2 text-center">Editar</a>
                    <form action="/rd/public/terceros/delete/{{$tercero->Id}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('¿Estás seguro de borrar este registro?')" type="submit"
                            style="border-color:#7b241c; background-color: #7b241c"
                            class="text-white bg-blue-700 font-semibold rounded-lg text-sm px-5 py-1 mr-2 text-center">Borrar
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <h3 class="mb-2 pt-3 font-semibold">Nombre:
            <span class="font-thin">{{ $tercero->Nombre }}</span>
        </h3>
        <h3 class="border-t mb-2 pt-3 font-semibold">RD:
            <span class="font-thin">{{ $tercero->RD }}</span>
        </h3>
        <h3 class="border-t mb-2 pt-3 font-semibold">DNI:
            <span class="font-thin">{{ $tercero->DNI }}</span>
        </h3>
        <h3 class="border-t mb-2 pt-3 font-semibold">Número de Expediente:
            <span class="font-thin">{{ $tercero->Expediente }}</span>
        </h3>
        <h3 class="border-t mb-2 pt-3 font-semibold">Importe:
            <span class="font-thin"> {{ $tercero->Importe }}</span>
        </h3>
        <h3 class="border-t mb-2 pt-3 font-semibold">Fecha:
            <span class="font-thin">  {{date('d-m-Y', strtotime($tercero->Fecha))}}</span>
        </h3>
        <h3 class="border-t mb-2 pt-3 font-semibold">Observaciones:
            <span class="font-thin"> {{ $tercero->Texto }}</span>
        </h3>
        <h3 class="border-t mb-2 pt-3 font-semibold">Estado:
            <span class="font-thin"> {{ $tercero->Estado }}</span>
        </h3>
        <h3 class="border-t mb-2 pt-3 font-semibold">Año:
            <span class="font-thin"> {{ $tercero->Año }}</span>
        </h3>
        <h3 class="border-t mb-2 pt-3 font-semibold">Total:
            <span class="font-thin"> {{ $tercero->Total }}</span>
        </h3>
        <h3 class="border-t mb-2 pt-3 font-semibold">Fecha Pagado:
            <span class="font-thin">
                @if ($tercero->FechaPagado != null)
                    {{date('d-m-Y', strtotime($tercero->FechaPagado))}}
                @else
                    {{$tercero->FechaPagado}}
                @endif
            </span>
        </h3>
        <h3 class="border-t mb-2 pt-3 font-semibold">Fecha Ejecutiva:
            <span class="font-thin">
                @if ($tercero->FechaEjecutiva != null)
                    {{date('d-m-Y', strtotime($tercero->FechaEjecutiva))}}
                @else
                    {{$tercero->FechaEjecutiva}}
                @endif
            </span>
        </h3>
        <h3 class="border-t mb-2 pt-3 font-semibold">Fecha Notificación:
            <span class="font-thin">
                @if ($tercero->FechaNotificacion != null)
                    {{date('d-m-Y', strtotime($tercero->FechaNotificacion))}}
                @else
                    {{$tercero->FechaNotificacion}}
                @endif
            </span>
        </h3>
        <h3 class="border-t mb-2 pt-3 font-semibold">Motivo:
            <span class="font-thin"> {{ $tercero->Motivo }}</span>
        </h3>
        <h3 class="border-t mb-2 pt-3 font-semibold">Fecha Anulación:
            <span class="font-thin">
                @if ($tercero->FechaAnulacion != null)
                    {{date('d-m-Y', strtotime($tercero->FechaAnulacion))}}
                @else
                    {{$tercero->FechaAnulacion}}
                @endif
            </span>
        </h3>
    </div>

    <br>

    <div class="bg-white rounded-md max-w-4xl mx-auto p-4 space-y-4 shadow-lg">
        <strong class="text-2xl">Historial de pagos</strong>
        <table class="table-fixed border border-gray-500 border-collapse mt-14">
            <thead>
                <tr class="border-b-2 border-black">
                    <th class="w-2/12 bg-gray-300 text-left px-2">Fecha</th>
                    <th class="w-1/12 bg-gray-300 text-left px-2">Importe</th>
                    <th class="w-4/12 bg-gray-300 text-left px-2">Observaciones</th>
                </tr>
            </thead>
            @php
                $pagos = DB::select("SELECT pagos.Fecha, pagos.Importe, pagos.Texto FROM pagos WHERE pagos.IdRd = $tercero->RD");
            @endphp
            <tbody>
                @foreach ($pagos as $pago)
                    <tr class="border border-black">
                        <td class="text-left px-2 border border-black">{{ date('d-m-Y', strtotime($pago->Fecha)) }}</td>

                        <td class="px-2 border border-black">{{$pago->Importe}}</td>

                        <td class="px-2 border border-black">{{$pago->Texto}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <br>

    <div class="flex justify-end space-x-2 pt-3">
        <a href="{{url()->previous()}}" style="background-color: #0053D0"
            class="transition-colors rounded-[8px] px-[15px] py-[4px] text-white focus:ring-2">Volver</a>
    </div>
</x-layout>
