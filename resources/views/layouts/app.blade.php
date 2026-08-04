<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'RentEase') }}</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')

</head>

<body class="font-sans antialiased bg-gray-100">

    <div class="min-h-screen">

        @include('layouts.navigation')

        @isset($header)

            <header class="bg-white shadow">

                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

                    {{ $header }}

                </div>

            </header>

        @endisset

        {{-- Global Flash Messages --}}
        @if(session('success'))

            <div class="max-w-7xl mx-auto mt-4 px-4">

                <div class="alert alert-success">

                    {{ session('success') }}

                </div>

            </div>

        @endif

        @if(session('error'))

            <div class="max-w-7xl mx-auto mt-4 px-4">

                <div class="alert alert-danger">

                    {{ session('error') }}

                </div>

            </div>

        @endif

        <main>

            {{ $slot }}

        </main>

    </div>

    @stack('scripts')

</body>

</html>