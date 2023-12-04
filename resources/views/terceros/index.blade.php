<x-layout>
    <div class="flex flex-col text-center mt-4">
        <h1 class="mb-4 text-2xl font-semibold">RD</h1>
        <div>
            <div class="p-2 text-right">
                <a href="/rd/public/terceros" style="background-color: #0053D0"
                    class="text-white font-semibold rounded-lg text-sm px-5 py-1 text-center">Limpiar filtro
                </a>
                &nbsp; | &nbsp;
                <a href="/rd/public/terceros/create" style="background-color: #0053D0"
                    class="text-white font-semibold rounded-lg text-sm px-5 py-1 text-center">Nuevo Registro
                </a>
            </div>
            <table width="100%" class="table-fixed border-collapse border border-slate-400 text-left">
                <thead class="bg-gray-100">
                    @php
                        $link = e('Nombre=' . request('Nombre') . '&DNI=' . request('DNI') . '&Expediente=' . request('Expediente') . '&Importe=' . request('Importe') . '&RD=' . request('RD'));
                        $enlace = e('/rd/public/terceros')
                    @endphp

                    <tr>
                        <th class="border border-slate-300 px-6 py-2 font-semibold">
                            <a
                                href="{!! $enlace !!}?orden=Nombre&dir={{ request('dir') == 'asc' ? 'desc' : 'asc' }}&{!! $link !!}">Nombre
                                @if (request('orden') == 'Nombre')
                                    @if (request('dir', 'asc') == 'asc')
                                        &darr;
                                    @else
                                        &uarr;
                                    @endif
                                @endif
                            </a>
                        </th>
                        <th class="border border-slate-300 px-6 py-2 font-semibold">
                            <a
                                href="{!! $enlace !!}?orden=DNI&dir={{ request('dir') == 'asc' ? 'desc' : 'asc' }}&{!! $link !!}">DNI
                                @if (request('orden') == 'DNI')
                                    @if (request('dir', 'asc') == 'asc')
                                        &darr;
                                    @else
                                        &uarr;
                                    @endif
                                @endif
                            </a>
                        </th>
                        <th class="border border-slate-300 px-6 py-2 font-semibold">
                            <a
                                href="{!! $enlace !!}?orden=Expediente&dir={{ request('dir') == 'asc' ? 'desc' : 'asc' }}&{!! $link !!}">Expediente
                                @if (request('orden') == 'Expediente')
                                    @if (request('dir', 'asc') == 'asc')
                                        &darr;
                                    @else
                                        &uarr;
                                    @endif
                                @endif
                            </a>
                        </th>
                        <th class="border border-slate-300 px-6 py-2 font-semibold">
                            <a
                                href="{!! $enlace !!}?orden=Importe&dir={{ request('dir') == 'asc' ? 'desc' : 'asc' }}&{!! $link !!}">Importe
                                @if (request('orden') == 'Importe')
                                    @if (request('dir', 'asc') == 'asc')
                                        &darr;
                                    @else
                                        &uarr;
                                    @endif
                                @endif
                            </a>
                        </th>
                        <th class="border border-slate-300 px-6 py-2 font-semibold">
                            <a
                                href="{!! $enlace !!}?orden=RD&dir={{ request('dir') == 'asc' ? 'desc' : 'asc' }}&{!! $link !!}">RD
                                @if (request('orden') == 'RD')
                                    @if (request('dir', 'asc') == 'asc')
                                        &darr;
                                    @else
                                        &uarr;
                                    @endif
                                @endif
                            </a>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <tr class="border border-slate-400 text-center  bg-gray-50 ">
                        <form action="{{ $enlace }}" method="GET">
                            <input type="hidden" name="orden" value="{{ old('orden') }}">
                            <input type="hidden" name="dir" value="{{ old('dir') }}">
                            <td class="w-3/12 border border-slate-300 px-6 py-2 font-semibold">
                                <input type="text" class="border border-slate-300 px-6 py-2"
                                name="Nombre" id="Nombre" value="{{ request()->query('Nombre') }}">
                            </td>
                            <td class="w-2/12 border border-slate-300 px-6 py-2 font-semibold">
                                <input type="text" class="border border-slate-300 px-6 py-2"
                                name="DNI" id="DNI" value="{{ request()->query('DNI') }}">
                            </td>
                            <td class="w-1/12 border border-slate-300 px-6 py-2 font-semibold">
                                <input type="text" class="border border-slate-300 px-6 py-2"
                                name="Expediente" id="Expediente" value="{{ request()->query('Expediente') }}">
                            </td>
                            <td class="w-2/12 border border-slate-300 px-6 py-2 font-semibold">
                                <input type="text" class="border border-slate-300 px-6 py-2"
                                name="Importe" id="Importe" value="{{ request()->query('Importe') }}">
                            </td>
                            <td class="w-2/12 border border-slate-300 px-6 py-2 font-semibold">
                                <input type="text" class="border border-slate-300 px-6 py-2"
                                    name="RD" id="RD" value="{{ request()->query('RD') }}">
                            </td>
                            <div class="hidden"><button type="submit"></button></div>
                        </form>
                    </tr>
                    @foreach ($terceros as $tercero)

                        <tr class="border border-slate-400">
                            <td class="border border-slate-300 px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    {{$tercero->Nombre}}
                                </div>
                            </td>
                            <td class="border border-slate-300 px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    {{$tercero->DNI}}
                                </div>
                            </td>
                            <td class="border border-slate-300 px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    {{$tercero->Expediente}}
                                </div>
                            </td>
                            <td class="border border-slate-300 px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    {{$tercero->Importe}}
                                </div>
                            </td>
                            <td class="border border-slate-300 px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    {{$tercero->RD}}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4 flex justify-center">
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                {{ $terceros->links() }}
            </ul>
          </nav>
    </div>
</x-layout>
