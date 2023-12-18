<x-layout>
    <form action="{{ route('terceros.ejecutiva', ['id' => $tercero->Id]) }}" method="POST">
        @csrf
        @method('PUT')

        <h1 class="mb-4 text-2xl font-semibold">Editar Fecha Ejecutiva</h1>

        <div class="mb-6">
            <label for="FechaEjecutiva"
                class="text-sm font-medium text-gray-900 block mb-2 @error('FechaEjecutiva') text-red-500 @enderror">
                Fecha Ejecutiva
            </label>
            <input type="date" name="FechaEjecutiva" id="FechaEjecutiva"
                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/3 p-2.5 @error('FechaEjecutiva') border-red-500 @enderror"
                value="{{ old('FechaEjecutiva', optional($tercero->FechaEjecutiva)->format('Y-m-d')) ?: now()->format('Y-m-d') }}">
            @error('FechaEjecutiva')
                <p class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <button type="submit"
            class="text-white bg-green-700 hover:bg-green-700 focus:ring-4 focus:ring-green-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Aceptar</button>
        <a href="/rd/public/terceros/{{ $tercero->Id }}" style="border-color:#0053D0; background-color: #0053D0"
            class="text-white border-green-700 border-2 bg-green-700 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Volver</a>
    </form>
</x-layout>
