<div class="w-100">
    <form action="{{ route('equipos') }}" method="GET" class="flex">
        <input type="hidden" name="orden" value="{{ old('orden') }}">
        <input type="hidden" name="dir" value="{{ old('dir') }}">
        <div class="mb-3">
            <label for="IdTipo"
                class="text-sm font-medium text-gray-900 block mb-2">
                Tipo
            </label>
            <select type="text" name="IdTipo" id="IdTipo"
                class="border border-slate-300 px-6 py-2 text-gray-500"
                value="{{ request()->query('IdTipo') }}">
                <option selected></option>
                @foreach ($tipos as $tipo) 
                <option value="{{ $tipo->Id }}">{{ $tipo->Denominacion }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="Fabricante"
                class="text-sm font-medium text-gray-900 block mb-2">
                Fabricante
            </label>
            <input type="text" name="Fabricante" id="Fabricante"
                class="border border-slate-300 px-6 py-2 text-gray-500"
                value="{{ request()->query('Fabricante') }}">
        </div>
        <div class="mb-3">
            <label for="Modelo"
                class="text-sm font-medium text-gray-900 block mb-2">
                Modelo
            </label>
            <input type="text" name="Modelo" id="Modelo"
                class="border border-slate-300 px-6 py-2 text-gray-500"
                value="{{ request()->query('Modelo') }}">
        </div>
        <div class="mb-3">
            <label for="NumSerie"
                class="text-sm font-medium text-gray-900 block mb-2">
                NumSerie
            </label>
            <input type="text" name="NumSerie" id="NumSerie"
                class="border border-slate-300 px-6 py-2 text-gray-500"
                value="{{ request()->query('NumSerie') }}">
        </div>
        <div class="mb-3">
            <label for="FechaAlta"
                class="text-sm font-medium text-gray-900 block mb-2">
                FechaAlta
            </label>
            <input type="date" name="FechaAlta" id="FechaAlta"
                class="border border-slate-300 px-6 py-2 text-gray-500"
                value="{{ request()->query('FechaAlta') }}">
        </div>
        <button type="submit"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-1 text-center">Buscar</button>
        <a href="/inventario/public/equipos"
            class="text-white border-green-700 border-2 bg-green-700 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-1 text-center">Limpiar</a>
    </form>
</div>