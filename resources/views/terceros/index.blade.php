<x-layout>
    <div class="flex flex-col text-center mt-4">
        <div>
            <div class="p-2 text-right">
                <a href="/rd/public/terceros" style="background-color: #0053D0"
                    class="text-white font-semibold rounded-lg text-sm px-5 py-1 text-center">Limpiar filtro
                </a>
                &nbsp; | &nbsp;
                <a href="{{ route("pagos.recabar") }}" style="background-color: #0053D0"
                    class="text-white font-semibold rounded-lg text-sm px-5 py-1 text-center">Listados
                </a>
                &nbsp; | &nbsp;
                <a href="/rd/public/terceros/create" style="background-color: #15803d"
                    class="text-white font-semibold rounded-lg text-sm px-5 py-1 text-center">Nuevo Registro
                </a>
            </div>
            <table width="100%" class="table-fixed border-collapse border border-slate-400 text-left">
                <thead class="bg-gray-100">
                    @php
                        $link = e('Nombre=' . request('Nombre') . '&DNI=' . request('DNI') . '&Expediente=' . request('Expediente') . '&Estado=' . request('Estado') . '&Importe=' . request('Importe') . '&RD=' . request('RD'));
                        $enlace = e('/rd/public/terceros')
                    @endphp

                    <tr>
                        <th class="border border-slate-300 px-6 py-2 font-semibold" style="width: 500px" align="center">
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
                        <th class="border border-slate-300 px-6 py-2 font-semibold" align="center">
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
                        <th class="border border-slate-300 px-6 py-2 font-semibold" align="center">
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
                        <th class="border border-slate-300 px-6 py-2 font-semibold" align="center">
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
                        <th class="border border-slate-300 px-6 py-2 font-semibold" align="center">
                            <a
                                href="{!! $enlace !!}?orden=Estado&dir={{ request('dir') == 'asc' ? 'desc' : 'asc' }}&{!! $link !!}">Estado
                                @if (request('orden') == 'Estado')
                                    @if (request('dir', 'asc') == 'asc')
                                        &darr;
                                    @else
                                        &uarr;
                                    @endif
                                @endif
                            </a>
                        </th>
                        <th class="border border-slate-300 px-6 py-2 font-semibold" align="center">
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
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <tr class="border border-slate-400 text-center  bg-gray-50 ">
                        <form action="{{ $enlace }}" method="GET">
                            <input type="hidden" name="orden" value="{{ old('orden') }}">
                            <input type="hidden" name="dir" value="{{ old('dir') }}">
                            <td class="border border-slate-300 px-6 py-2 font-semibold">
                                <input type="text" class="border border-slate-300" style="width: 350px"
                                name="Nombre" id="Nombre" value="{{ request()->query('Nombre') }}">
                            </td>
                            <td class="border border-slate-300 px-6 py-2 font-semibold">
                                <input type="text" class="border border-slate-300 px-6 py-2" style="width: 150px"
                                    name="RD" id="RD" value="{{ request()->query('RD') }}">
                            </td>
                            <td class="border border-slate-300 px-6 py-2 font-semibold">
                                <input type="text" class="border border-slate-300" style="width: 150px"
                                name="DNI" id="DNI" value="{{ request()->query('DNI') }}">
                            </td>
                            <td class="border border-slate-300 px-6 py-2 font-semibold">
                                <input type="text" class="border border-slate-300 px-6 py-2" style="width: 150px"
                                name="Expediente" id="Expediente" value="{{ request()->query('Expediente') }}">
                            </td>
                            <td class="border border-slate-300 px-6 py-2 font-semibold">
                                <input type="text" class="border border-slate-300 px-6 py-2" style="width: 150px"
                                name="Estado" id="Estado" value="{{ request()->query('Estado') }}">
                            </td>
                            <td class="border border-slate-300 px-6 py-2 font-semibold">
                                <input type="text" class="border border-slate-300 px-6 py-2" style="width: 150px"
                                name="Importe" id="Importe" value="{{ request()->query('Importe') }}">
                            </td>
                            <div class="hidden"><button type="submit"></button></div>
                        </form>
                    </tr>
                    @php
                function estadoColor($estado) {
                    switch ($estado) {
                        case 'Anulado':
                            return '#b91c1c'; // Clase para el color rojo
                        case 'Pagado':
                            return '#15803d'; // Clase para el color verde
                        case 'Ejecutiva':
                            return '#0057da'; // Clase para el color azul
                    }
                }
            @endphp
                    @foreach ($terceros as $tercero)

                        <tr class="border border-slate-400">
                            <td class="border border-slate-300 px-6 py-4">
                                <div class="text-sm text-gray-900">
                                   <a href="{{ route('terceros.show', ['id' => $tercero->Id]) }}">{{$tercero->Nombre}}</a>
                                </div>
                            </td>
                            <td class="border border-slate-300 px-6 py-4" style="width: 150px" align="center">
                                <div class="text-sm text-gray-900" style="width: 150px">
                                    <a href="{{ route('terceros.show', ['id' => $tercero->Id]) }}">{{$tercero->RD}}</a>
                                </div>
                            </td>
                            <td class="border border-slate-300 px-6 py-4" align="center">
                                <div class="text-sm text-gray-900">
                                    <a href="{{ route('terceros.show', ['id' => $tercero->Id]) }}">{{$tercero->DNI}}</a>
                                </div>
                            </td>
                            <td class="border border-slate-300 px-6 py-4" align="center">
                                <div class="text-sm text-gray-900">
                                    <a href="{{ route('terceros.show', ['id' => $tercero->Id]) }}">{{$tercero->Expediente}}</a>
                                </div>
                            </td>
                            <td class="border border-slate-300 px-6 py-4" align="center">
                                <div class="text-sm text-gray-900" style="color: {{estadoColor($tercero->Estado)}}">
                                    <a href="{{ route('terceros.show', ['id' => $tercero->Id]) }}">
                                        @if ($tercero->Estado != 'Pendiente')
                                            <strong>{{$tercero->Estado}}</strong>
                                        @else
                                            {{$tercero->Estado}}
                                        @endif
                                    </a>
                                </div>
                            </td>
                            <td class="border border-slate-300 px-6 py-4" align="right">
                                <div class="text-sm text-gray-900">
                                    <a href="{{ route('terceros.show', ['id' => $tercero->Id]) }}">{{ number_format($tercero->Importe, 2, ',', '.') }}€</a>
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
                {{ $terceros->appends(request()->query())->links() }}
            </ul>
          </nav>
    </div>
</x-layout>
