<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <!-- Helper -->
    <script>
        window.Laravel = {!! json_encode([
            'apiKey' => config('services.firebase.apiKey'),
            'authDomain' => config('services.firebase.authDomain'),
            'databaseURL' => config('services.firebase.databaseURL'),
            'projectId' => config('services.firebase.projectId'),
            'storageBucket' => config('services.firebase.storageBucket'),
            'messagingSenderId' => config('services.firebase.messagingSenderId'),
            'appId' => config('services.firebase.appId'),
            'measurementId' => config('services.firebase.measurementId'),
            'publicVapidKey' => config('services.firebase.publicVapidKey'),
        ]) !!};
    </script>

    <!-- Firebase -->
    <script src="https://www.gstatic.com/firebasejs/7.9.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.9.1/firebase-messaging.js"></script>
    <script>
        firebase.initializeApp({
            apiKey: window.Laravel.apiKey,
            authDomain: window.Laravel.authDomain,
            databaseURL: window.Laravel.databaseURL,
            projectId: window.Laravel.projectId,
            storageBucket: window.Laravel.storageBucket,
            messagingSenderId: window.Laravel.messagingSenderId,
            appId: window.Laravel.appId,
            measurementId: window.Laravel.measurementId,

        });

        const messaging = firebase.messaging();
    </script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
    @yield('scripts')
</body>

</html>
