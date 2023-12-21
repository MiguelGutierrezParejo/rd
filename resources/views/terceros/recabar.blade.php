<x-layout>
    <h1 class="text-2xl font-semibold">Generar listado</h1>
    <form action="{{ route('terceros.generar')}}" method="POST">
        @csrf

        <div class="mt-6 mb-6">
            <label for="Estado"
                class="text-sm font-medium text-gray-900 block mb-2 @error('Estado') text-red-500 @enderror">
                Listado
            </label>
            <select type="text" class="border border-slate-300 px-6 py-2" name="Estado" id="Estado" style="width: 250px">
                <option value="Pendiente" {{ old('Estado') === 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="Pagado" {{ old('Estado') === 'Pagado' ? 'selected' : '' }}>Pagado</option>
                <option value="Ejecutiva" {{ old('Estado') === 'Ejecutiva' ? 'selected' : '' }}>Ejecutiva</option>
                <option value="Anulado" {{ old('Estado') === 'Anulado' ? 'selected' : '' }}>Anulado</option>
                <option value="Todos">Todos (menos anulados)</option>
            </select>
            @error('Estado')
                <p class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="Desde" class="text-sm font-medium text-gray-900 block mb-2 @error('Desde') text-red-500 @enderror">
                Desde
            </label>
            <input type="date" name="Desde" id="Desde" value="{{ date('Y') }}-01-01"
                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 @error('desde') border-red-500 @enderror">
            @error('desde')
                <p class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="Hasta" class="text-sm font-medium text-gray-900 block mb-2 @error('Hasta') text-red-500 @enderror">
                Hasta
            </label>
            <input type="date" name="Hasta" id="Hasta"
                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 @error('Hasta') border-red-500 @enderror">
            @error('hasta')
                <p class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var hastaInput = document.getElementById('Hasta');
                var fechaActual = new Date().toISOString().split('T')[0]; // Obtener la fecha actual en formato 'YYYY-MM-DD'
                hastaInput.value = fechaActual;
            });
        </script>

        <button type="submit"
            class="text-white bg-green-700 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Aceptar</button>
        <a href="{{ url()->previous() }}"
            style="border-color: rgb(29 78 216); background-color: #0053D0"
            class="text-white border-blue-300 border-2 bg-blue-700 focus:ring-blue-300 font-medium rounded-lg text-sm px-6 py-2.5 text-center">Volver</a>
    </form>
</x-layout>
