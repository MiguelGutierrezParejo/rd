<x-layout>
    <div class="flex flex-col text-center mt-4">
        <h1 class="mb-4 text-2xl font-semibold">RD</h1>
        <div>
            <div class="p-2 text-right">
            </div>
            <table width="100%" class="table-fixed border-collapse border border-slate-400 text-left">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="w-3/12 border border-slate-300 px-6 py-2 font-semibold">
                            <a href="">Nombre</a>
                        </th>
                        <th class="w-2/12 border border-slate-300 px-6 py-2 font-semibold">
                            <a href="">DNI</a>
                        </th>
                        <th class="w-1/12 border border-slate-300 px-6 py-2 font-semibold">
                            <a href="">Expediente</a>
                        </th>
                        <th class="w-2/12 border border-slate-300 px-6 py-2 font-semibold">
                            <a href="">Importe</a>
                        </th>
                        <th class="w-2/12 border border-slate-300 px-6 py-2 font-semibold">
                            <a href="">RD</a>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white">
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
