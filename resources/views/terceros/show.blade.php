<x-layout>
    <div class="bg-white rounded-md max-w-4xl mx-auto p-4 space-y-4 shadow-lg">
        <div class="flex justify-between">
            <strong class="text-2xl">Datos del registro</strong>
            <div>
                <a href="{{route('terceros.edit', ['id' => $tercero->Id])}}"
                    style="border-color:#0053D0; background-color: #0053D0" class="text-white bg-blue-700 font-semibold rounded-lg text-sm px-5 py-1 mr-2 text-center">Editar</a>
            </div>
            <div>
                <form action="/rd/public/terceros/delete/{{$tercero->Id}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('¿Estás seguro de borrar este registro?')" type="submit"
                        style="border-color:#7b241c; background-color: #7b241c" class="text-white bg-blue-700 font-semibold rounded-lg text-sm px-5 py-1 mr-2 text-center">Borrar</button>
                </form>
            </div>
        </div>

        <h3 class="border-t mb-2 pt-3 font-semibold">Nombre:
            <span class="font-thin">{{ $tercero->Nombre }}</span>
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
        <h3 class="border-t mb-2 pt-3 font-semibold">Texto:
            <span class="font-thin"> {{ $tercero->Texto }}</span>
        </h3>
        <h3 class="border-t mb-2 pt-3 font-semibold">RD:
            <span class="font-thin">{{ $tercero->RD }}</span>
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
        <h3 class="border-t mb-2 pt-3 font-semibold">Fecha Notificacion:
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

    <div class="flex justify-end space-x-2 pt-3">
        <a href="/rd/public/terceros" style="background-color: #0053D0"
            class="transition-colors rounded-[8px] px-[15px] py-[4px] text-white focus:ring-2">Volver</a>
    </div>
</x-layout>
