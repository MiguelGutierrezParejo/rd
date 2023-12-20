<x-layout>
    <form action="{{ route('terceros.store') }}" method="POST">
        @csrf

        <h1 class="mb-4 text-2xl font-semibold">Crear registro</h1>
        <div class="flex">
            <div>
                <div class="mb-6">
                    <label for="Nombre"
                        class="text-sm font-medium text-gray-900 block mb-2 @error('Nombre') text-red-500 @enderror">
                        Nombre
                    </label>
                    <input type="text" name="Nombre" id="Nombre" style="width: 300px"
                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 @error('Nombre') border-red-500 @enderror"
                        value="{{ old('Nombre', $tercero->Nombre) }}">
                    @error('Nombre')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="Expediente"
                        class="text-sm font-medium text-gray-900 block mb-2 @error('Expediente') text-red-500 @enderror">
                        Número de Expediente
                    </label>
                    <input type="text" name="Expediente" id="Expediente"
                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-300 p-2.5 @error('Expediente') border-red-500 @enderror"
                        value="{{ old('Expediente', $tercero->Expediente) }}">
                    @error('Expediente')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="Importe"
                        class="text-sm font-medium text-gray-900 block mb-2 @error('Importe') text-red-500 @enderror">
                        Importe
                    </label>
                    <input type="text" name="Importe" id="Importe"
                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-300 p-2.5 @error('Importe') border-red-500 @enderror">
                    @error('Importe')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
            <div style="margin-left: 5%">
                <div class="mb-6">
                    <label for="DNI"
                        class="text-sm font-medium text-gray-900 block mb-2 @error('DNI') text-red-500 @enderror">
                        DNI
                    </label>
                    <input type="text" name="DNI" id="DNI"
                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-300 p-2.5 @error('DNI') border-red-500 @enderror"
                        value="{{ old('DNI', $tercero->DNI) }}">
                    @error('DNI')
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
                        value="{{ old('Fecha', optional($tercero->Fecha)->format('Y-m-d')) }}">
                    @error('tercero')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
        </div>
        <div class="mb-6">
            <label for="Texto"
                class="text-sm font-medium text-gray-900 block mb-2 @error('Texto') text-red-500 @enderror">
                Concepto
            </label>
            <input type="text" name="Texto" id="Texto"
                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('Texto') border-red-500 @enderror"
                value="{{ old('Texto', $tercero->Texto) }}">
            @error('Modelo')
                <p class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="Motivo"
                class="text-sm font-medium text-gray-900 block mb-2 @error('Motivo') text-red-500 @enderror">
                Motivo (Baja o Ejecutiva)
            </label>
            <input type="text" name="Motivo" id="Motivo"
                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('Motivo') border-red-500 @enderror"
                value="{{ old('Motivo', $tercero->Motivo) }}">
            @error('Modelo')
                <p class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var importeInput = document.getElementById('Importe');
                new AutoNumeric('#Importe', 'Spanish');
            });
        </script>

        <button type="submit"
            class="text-white bg-green-700 hover:bg-green-700 focus:ring-4 focus:ring-green-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Aceptar</button>
        <a href="/rd/public/terceros/{{ $tercero->Id }}" style="border-color:#0053D0; background-color: #0053D0"
            class="text-white border-green-700 border-2 bg-green-700 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Volver</a>
    </form>
</x-layout>
