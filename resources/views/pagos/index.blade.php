<x-layout>
    <div class="flex flex-col text-center mt-4">
        <h1 class="mb-4 text-2xl font-semibold">Pagos</h1>
        <div>
            <div class="p-2 text-right">
                <a href="/rd/public/pagos" style="background-color: #0053D0"
                    class="text-white font-semibold rounded-lg text-sm px-5 py-1 text-center">Limpiar filtro
                </a>
                &nbsp; | &nbsp;
                <a href="/rd/public/pagos/create" style="background-color: #0053D0"
                    class="text-white font-semibold rounded-lg text-sm px-5 py-1 text-center">Nuevo Pago
                </a>
            </div>
            <table width="100%" class="table-fixed border-collapse border border-slate-400 text-left">
                <thead class="bg-gray-100">
                    @php
                        $link = e('IdRd=' . request('IdRd') . '&Fecha=' . request('Fecha') . '&Importe=' . request('Importe'));
                        $enlace = e('/rd/public/pagos')
                    @endphp

                    <tr>
                        <th class="border border-slate-300 px-6 py-2 font-semibold">
                            <a
                                href="{!! $enlace !!}?orden=Nombre&dir={{ request('dir') == 'asc' ? 'desc' : 'asc' }}&{!! $link !!}">Usuario
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
                                href="{!! $enlace !!}?orden=IdRd&dir={{ request('dir') == 'asc' ? 'desc' : 'asc' }}&{!! $link !!}">RD
                                @if (request('orden') == 'IdRd')
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
                                href="{!! $enlace !!}?orden=Fecha&dir={{ request('dir') == 'asc' ? 'desc' : 'asc' }}&{!! $link !!}">Fecha
                                @if (request('orden') == 'Fecha')
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
                           Observaciones
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
                            <td class="w-3/12 border border-slate-300 px-6 py-2 font-semibold">
                                <input type="text" class="border border-slate-300 px-6 py-2"
                                name="IdRd" id="IdRd" value="{{ request()->query('IdRd') }}">
                            </td>
                            <td class="w-2/12 border border-slate-300 px-6 py-2 font-semibold">
                                <input type="text" class="border border-slate-300 px-6 py-2"
                                name="Fecha" id="Fecha" value="{{ request()->query('Fecha') }}">
                            </td>
                            <td class="w-2/12 border border-slate-300 px-6 py-2 font-semibold">
                                <input type="text" class="border border-slate-300 px-6 py-2"
                                name="Importe" id="Importe" value="{{ request()->query('Importe') }}">
                            </td>
                            <td class="w-2/12 border border-slate-300 px-6 py-2 font-semibold">
                                <input type="hidden" class="border border-slate-300 px-6 py-2">
                            </td>
                            <div class="hidden"><button type="submit"></button></div>
                        </form>
                    </tr>
                    @foreach ($pagos as $pago)

                        <tr class="border border-slate-400">
                            @php
                                $nombres = DB::select("SELECT terceros.Nombre, terceros.Id FROM terceros WHERE terceros.RD = $pago->IdRd");
                            @endphp
                            <td class="border border-slate-300 px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    @foreach ( $nombres as $nombre )
                                    <a href="{{ route('terceros.show', ['id' => $nombre->Id]) }}">{{ $nombre->Nombre }}</a>
                                    @endforeach
                                </div>
                            </td>
                            <td class="border border-slate-300 px-6 py-4">
                                <div class="text-sm text-gray-900">
                                   <a href="{{ route('pagos.show', ['id' => $pago->Id]) }}">{{$pago->IdRd}}</a>
                                </div>
                            </td>
                            <td class="border border-slate-300 px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    {{ date('d-m-Y', strtotime($pago->Fecha)) }}
                                </div>
                            </td>
                            <td class="border border-slate-300 px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    {{$pago->Importe}}
                                </div>
                            </td>
                            <td class="border border-slate-300 px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    {{$pago->Texto}}
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
                {{ $pagos->appends(request()->query())->links() }}
            </ul>
          </nav>
    </div>
</x-layout>
