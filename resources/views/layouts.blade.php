<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <title>Maps & Stats</title>

    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCXQRkRD6kfFvZvjemcqZ85G9VWBGowM_I">
    </script>
</head>
<body>
<div id="app">
    <!-- This example requires Tailwind CSS v2.0+ -->
    <nav class="bg-gray-800">
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
            <div class="relative flex items-center justify-between h-16">
                <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                    <!-- Mobile menu button-->
                    <button class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <!-- Icon when menu is closed. -->
                        <!--
                          Heroicon name: menu

                          Menu open: "hidden", Menu closed: "block"
                        -->
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <!-- Icon when menu is open. -->
                        <!--
                          Heroicon name: x

                          Menu open: "block", Menu closed: "hidden"
                        -->
                        <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="flex-shrink-0 flex items-center">
                        <img class="block lg:hidden h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-indigo-500.svg" alt="Workflow">
                        <img class="hidden lg:block h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-logo-indigo-500-mark-white-text.svg" alt="Workflow">
                    </div>
                    <div class="hidden sm:block sm:ml-6">
                        <div class="flex space-x-4">
                            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                            <a href="{{ route('stats') }}" class="@if(request()->route()->getName() === 'stats') bg-gray-900 @endif text-white px-3 py-2 rounded-md text-sm font-medium">Stats</a>
                            <a href="{{ route('maps') }}" class="@if(request()->route()->getName() === 'maps') bg-gray-900 @endif text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Maps</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--
          Mobile menu, toggle classes based on menu state.

          Menu open: "block", Menu closed: "hidden"
        -->
        <div class="hidden sm:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                <a href="{{ route('stats') }}" class="@if(request()->route()->getName() === 'stats') bg-gray-900 @endif text-white block px-3 py-2 rounded-md text-base font-medium">
                    Stats
                </a>
                <a href="{{ route('maps') }}" class="@if(request()->route()->getName() === 'maps') bg-gray-900 @endif text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Maps</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto">
    @yield('content')
    </div>
</div>
</body>
<script src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript">
    window.checkAndAttachMapScript = function (callback) {
        if (!!window.google) {  // If you're using vue cli, then directly checking
            // 'google' obj will throw an error at the time of transpiling.
            callback();
            return true;
        }

        window.mapApiInitialized = callback;
        let script = document.createElement('script');
        script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCXQRkRD6kfFvZvjemcqZ85G9VWBGowM_I';
        document.body.appendChild(script);
    }

</script>
</html>
