<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/otro.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('js/otro.js') }}"></script>
    <link href="/rd/public/logoinformaticac.png" rel="icon" type="image/png">
    <link  href="{{ asset('css/lightbox.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/lightbox.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/autonumeric@4.8.1"></script>
    <title>RD</title>
</head>

<body class="antialiased"  style="background-color: pink">
    <div class="container px-4 mx-auto">
        <header class="bg-gray-100 rounded py-4 px-4 mt-5 flex flex-row justify-between items-center">
        <a style="width:17%;" class="pr-1 font-semibold" href="/rd/public/terceros"><img src="/rd/public/Gmu_trans_Horizontal.png" alt="GMU-Logo"></a>

            <b class="text-gi">Gestión de RD</b>

            <div>
                <nav>
                    <button class="px-3 py-1 rounded-sm items-center min-w-32">
                        <a class="pr-1 font-semibold" href="/rd/public/terceros">RD</a>
                    </button> |
                    <button class="px-3 py-1 rounded-sm items-center min-w-32">
                        <a class="pr-1 font-semibold" href="/rd/public/pagos/recabar">Listados</a>
                    </button> |
                    <!-- Settings Dropdown -->
                    <div class="group inline-block">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                    <div>{{ Auth::user()->name }}</div>

                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        {{ __('Cerrar sesión') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </nav>
            </div>
        </header>

        @if (session()->has('error'))
        <div class="bg-red-100 rounded-lg p-4 mt-4 mb-4 text-sm text-red-700" role="alert">
            <span class="font-semibold">Error:</span> {{ session('error') }}
        </div>
        @endif

        @if (session()->has('success'))
        <div class="bg-green-100 rounded-lg p-4 mt-4 mb-4 text-sm text-green-700" role="alert">
            {{ session('success') }}
        </div>
        @endif

        <div class="mt-4 mb-4">

            {{ $slot }}

        </div>

        <footer class="flex mt-4 sm:items-center justify-center bg-gray-100 rounded p-2">
            <div>
                <img src="/rd/public/logoinformaticae.png" alt="GMU-Informatica" width="50px" height="50px">
            </div>

            <div class="ml-4 text-center text-gray-500 sm:m2-0">
                Desarrollado por el área de informática de la Gerencia Municipal de Urbanismo - 2022
            </div>
        </footer>
    </div>
    <script>
        lightbox.option({
            'disableScrolling': true,
            'albumLabel': "%1 de %2",
            'wrapAround': true,
            'resizeDuration': 300,
            'imageFadeDuration': 400,
        });
    </script>
</body>
</html>
