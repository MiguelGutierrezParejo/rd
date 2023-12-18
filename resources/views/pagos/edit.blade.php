<x-layout>
    <form action="{{ route('pagos.update', ['id' => $pago->Id]) }}" method="POST">
        @csrf
        @method('PUT')

        <h1 class="mb-4 text-2xl font-semibold">Editar pago</h1>

        <div class="mb-6">
            <label for="Importe"
                class="text-sm font-medium text-gray-900 block mb-2 @error('Importe') text-red-500 @enderror">
                Importe
            </label>
            <input type="text" name="Importe" id="Importe"
                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-300 p-2.5 @error('Importe') border-red-500 @enderror"
                value="{{ old('Importe', $pago->Importe) }}">
            @error('Modelo')
                <p class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="Fecha"
                class="text-sm font-medium text-gray-900 block mb-2 @error('Fecha') text-red-500 @enderror">
                Fecha
            </label>
            <input type="date" name="Fecha" id="Fecha"
                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/3 p-2.5 @error('Fecha') border-red-500 @enderror"
                value="{{ old('Fecha', optional($pago->Fecha)->format('Y-m-d')) }}">
            @error('Fecha')
                <p class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="Texto"
                class="text-sm font-medium text-gray-900 block mb-2 @error('Texto') text-red-500 @enderror">
                Observaciones
            </label>
            <input type="text" name="Texto" id="Texto"
                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('Texto') border-red-500 @enderror"
                value="{{ old('Texto', $pago->Texto) }}">
            @error('Modelo')
                <p class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <button type="submit"
            class="text-white bg-green-700 hover:bg-green-700 focus:ring-4 focus:ring-green-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Aceptar</button>
        <a href="/rd/public/pagos/{{ $pago->Id }}" style="border-color:#0053D0; background-color: #0053D0"
            class="text-white border-green-700 border-2 bg-green-700 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Volver</a>
    </form>
</x-layout>
