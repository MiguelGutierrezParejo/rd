<x-layout>
    <div class="bg-white rounded-md max-w-4xl mx-auto p-4 space-y-4 shadow-lg">
        <div class="bg-white rounded-md max-w-4xl mx-auto p-4 space-y-4 shadow-lg">
            <div class="flex justify-between items-center">
                <strong class="text-2xl">Datos del registro</strong>
                <div class="flex space-x-2">
                    @if ($tercero->FechaAnulacion == null)
                        <a href="{{route('terceros.edit', ['id' => $tercero->Id])}}"
                            style="border-color:#0053D0; background-color: #0053D0"
                            class="text-white bg-blue-700 font-semibold rounded-lg text-sm px-5 py-1 mr-2 text-center">Editar</a>
                        <a href="{{route('terceros.fechaejecutiva', ['id' => $tercero->Id])}}"
                            class="text-white bg-green-700 font-semibold rounded-lg text-sm px-5 py-1 mr-2 text-center">Ejecutiva</a>
                        <a href="{{route('terceros.fechaanular', ['id' => $tercero->Id])}}"
                            class="text-white bg-red-700 font-semibold rounded-lg text-sm px-5 py-1 mr-2 text-center">Anular</a>
                    @else
                    <a href="{{route('terceros.fechaanular', ['id' => $tercero->Id])}}"
                        class="text-white bg-red-700 font-semibold rounded-lg text-sm px-5 py-1 mr-2 text-center">Reactivar</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="flex justify-between items-center" style="margin-bottom: -0.5rem;">
            <h3 class="mb-2 pt-3 font-semibold" >Nombre:
                <span class="font-thin" style="font-size: 22px">{{ $tercero->Nombre }}</span>
            </h3>
            <h3 class="mb-2 pt-3 font-semibold" style="background-color: rgb(219, 217, 217); padding:10px">Estado:
                <span class="font-thin"> {{ $tercero->Estado }}</span>
            </h3>
        </div>
        <div class="border-t flex items-center" style="gap: 2rem; margin-bottom: -0.5rem;">
            <h3 class="mb-2 pt-3 font-semibold">RD:
                <span class="font-thin" style="color: #0053D0">{{ $tercero->RD }}</span>
            </h3>
            <h3 class="mb-2 pt-3 font-semibold">DNI:
                <span class="font-thin">{{ $tercero->DNI }}</span>
            </h3>
            <h3 class="mb-2 pt-3 font-semibold">Número de Expediente:
                <span class="font-thin">{{ $tercero->Expediente }}</span>
            </h3>
            <h3 class="mb-2 pt-3 font-semibold">Fecha:
                <span class="font-thin">  {{date('d-m-Y', strtotime($tercero->Fecha))}}</span>
            </h3>
        </div>
        <div class="border-t flex items-center" style="margin-bottom: -0.5rem; gap: 2rem;">
            <h3 class="mb-2 pt-3 font-semibold">IMPORTE:
                <span class="font-semibold" style="color: green"> {{ $tercero->Importe }} €</span>
            </h3>
            <h3 class="mb-2 pt-3 font-semibold">PENDIENTE:
                <span class="font-semibold" style="color: red">{{ $tercero->Total }} €</span>
            </h3>
        </div>
        @if ($tercero->FechaPagado != null || $tercero->FechaEjecutiva != null || $tercero->FechaNotificacion != null || $tercero->FechaAnulacion != null)
            <div class="flex items-center" style="margin-bottom: -0.5rem; gap: 2rem;">

                @if ($tercero->FechaPagado != null)
                    <h3 class="border-t mb-2 pt-3 font-semibold">Fecha Pagado:
                        <span class="font-thin">
                            {{date('d-m-Y', strtotime($tercero->FechaPagado))}}
                        </span>
                    </h3>
                @endif
                @if ($tercero->FechaEjecutiva != null)
                    <h3 class="border-t mb-2 pt-3 font-semibold">Fecha Ejecutiva:
                        <span class="font-thin">
                            {{date('d-m-Y', strtotime($tercero->FechaEjecutiva))}}
                        </span>
                    </h3>
                @endif
                @if ($tercero->FechaNotificacion != null)
                    <h3 class="border-t mb-2 pt-3 font-semibold">Fecha Notificación:
                        <span class="font-thin">
                            {{date('d-m-Y', strtotime($tercero->FechaNotificacion))}}
                        </span>
                    </h3>
                @endif
                @if ($tercero->FechaAnulacion != null)
                    <h3 class="border-t mb-2 pt-3 font-semibold">Fecha Anulación:
                        <span class="font-thin">
                            {{date('d-m-Y', strtotime($tercero->FechaAnulacion))}}
                        </span>
                    </h3>
                @endif
            </div>
        @endif
        @if ($tercero->FechaAnulacion != null)
            <h3 class="border-t mb-2 pt-3 font-semibold">Motivo de la anulación:
                <span class="font-thin"> {{ $tercero->Motivo }}</span>
            </h3>
        @elseif ( $tercero->FechaEjecutiva != null)
            <h3 class="border-t mb-2 pt-3 font-semibold">Motivo:
                <span class="font-thin"> {{ $tercero->Motivo }}</span>
            </h3>
        @endif
        <h3 class="border-t mb-2 pt-3 font-semibold">Observaciones:
            <span class="font-thin"> {{ $tercero->Texto }}</span>
        </h3>
    </div>

    <br>

    <div class="bg-white rounded-md max-w-4xl mx-auto p-4 space-y-4 shadow-lg">
        <div class="flex justify-between">
            <strong class="text-2xl">Historial de pagos</strong>
            @if ($tercero->FechaAnulacion == null)
                <a href="{{ route('pagos.create', ['IdRd' => $tercero->RD]) }}"
                    class="text-white bg-green-700 font-semibold rounded-lg text-sm px-5 py-1 mr-2 text-center">Añadir Pago</a>
            @endif
        </div>
        <table class="table-fixed border border-gray-500 border-collapse mt-14">
            <thead>
                <tr class="border-b-2 border-black">
                    <th class="w-2/12 bg-gray-300 text-left px-2">Fecha</th>
                    <th class="w-1/12 bg-gray-300 text-left px-2">Importe</th>
                    <th class="w-4/12 bg-gray-300 text-left px-2">Observaciones</th>
                </tr>
            </thead>
            @php
                $pagos = DB::select("SELECT pagos.Id, pagos.Fecha, pagos.Importe, pagos.Texto FROM pagos WHERE pagos.IdRd = $tercero->RD");
            @endphp
            <tbody>
                @foreach ($pagos as $pago)
                    <tr class="border border-black">
                        <td class="text-left px-2 border border-black">
                            <a href="{{ route('pagos.show', ['id' => $pago->Id]) }}">
                                {{ date('d-m-Y', strtotime($pago->Fecha)) }}
                            </a>
                        </td>

                        <td class="px-2 border border-black">{{$pago->Importe}}</td>

                        <td class="px-2 border border-black">{{$pago->Texto}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <br>

    <div class="flex justify-end space-x-2 pt-3">
        <a href="/rd/public/terceros" style="background-color: #0053D0"
            class="transition-colors rounded-[8px] px-[15px] py-[4px] text-white focus:ring-2">Volver</a>
    </div>
</x-layout>
