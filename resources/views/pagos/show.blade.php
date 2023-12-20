<x-layout>
    <div class="bg-white rounded-md max-w-4xl mx-auto p-4 space-y-4 shadow-lg">
        <div class="bg-white rounded-md max-w-4xl mx-auto p-4 space-y-4 shadow-lg">
            <div class="flex justify-between items-center">
                <strong class="text-2xl">Datos del pago</strong>
                <div class="flex space-x-2">
                    <a href="{{route('pagos.edit', ['id' => $pago->Id])}}"
                        style="border-color:#0053D0; background-color: #0053D0"
                        class="text-white bg-blue-700 font-semibold rounded-lg text-sm px-5 py-1 mr-2 text-center">Editar</a>
                    <form action="/rd/public/pagos/delete/{{$pago->Id}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('¿Estás seguro de borrar este pago?')" type="submit"
                            style="border-color:#7b241c; background-color: #7b241c"
                            class="text-white bg-blue-700 font-semibold rounded-lg text-sm px-5 py-1 mr-2 text-center">Borrar
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @php
           $nombres = DB::select("SELECT terceros.Nombre, terceros.Id FROM terceros WHERE terceros.RD = $pago->IdRd");
        @endphp
        <h3 class="mb-2 pt-3 font-semibold">Nombre:
            @foreach ( $nombres as $nombre )
                <span class="font-thin"> {{ $nombre->Nombre }}</span>
            @endforeach
        </h3>
        <h3 class="border-t mb-2 pt-3 font-semibold">RD:
            <span class="font-thin">{{ $pago->IdRd }}</span>
        </h3>
        <h3 class="border-t mb-2 pt-3 font-semibold">Importe:
            <span class="font-thin"> {{ number_format($pago->Importe, 2, ',', '.') }}€</span>
        </h3>
        <h3 class="border-t mb-2 pt-3 font-semibold">Fecha:
            <span class="font-thin">  {{date('d-m-Y', strtotime($pago->Fecha))}}</span>
        </h3>
        <h3 class="border-t mb-2 pt-3 font-semibold">Observaciones:
            <span class="font-thin"> {{ $pago->Texto }}</span>
        </h3>
    </div>

    <br>

    <div class="flex justify-end space-x-2 pt-3">
        <a href="/rd/public/terceros/{{ $nombre->Id }}" style="background-color: #0053D0"
            class="transition-colors rounded-[8px] px-[15px] py-[4px] text-white focus:ring-2">Volver</a>
    </div>
</x-layout>
