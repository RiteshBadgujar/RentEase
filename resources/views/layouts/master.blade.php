<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'RentEase')</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}">

    <!-- Google Font -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')

    <style>

        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f9fa;
        }

        section {
            padding: 70px 0;
        }

        .section-title {
            font-weight: 700;
            margin-bottom: 40px;
        }

    </style>

</head>


<body>

    {{-- ==========================================================
         NAVBAR
    =========================================================== --}}

    @include('partials.navbar')


    {{-- ==========================================================
         GLOBAL FLASH MESSAGES
    =========================================================== --}}

    @if(session('success'))

        <div class="container mt-3">

            <div
                class="alert alert-success alert-dismissible fade show"
                role="alert">

                <i class="bi bi-check-circle-fill me-2"></i>

                {{ session('success') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>

            </div>

        </div>

    @endif


    @if(session('error'))

        <div class="container mt-3">

            <div
                class="alert alert-danger alert-dismissible fade show"
                role="alert">

                <i class="bi bi-exclamation-triangle-fill me-2"></i>

                {{ session('error') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>

            </div>

        </div>

    @endif


    {{-- ==========================================================
         VALIDATION ERRORS
    =========================================================== --}}

    @if($errors->any())

        <div class="container mt-3">

            <div
                class="alert alert-danger alert-dismissible fade show"
                role="alert">

                <strong>
                    Please correct the following errors:
                </strong>

                <ul class="mb-0 mt-2">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>

            </div>

        </div>

    @endif


    {{-- ==========================================================
         MAIN CONTENT
    =========================================================== --}}

    <main>

        @yield('content')

    </main>


    {{-- ==========================================================
         FOOTER
    =========================================================== --}}

    @include('partials.footer')


    {{-- ==========================================================
         BOOTSTRAP JAVASCRIPT
    =========================================================== --}}

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js">
    </script>


    {{-- ==========================================================
         PAGE SPECIFIC SCRIPTS
    =========================================================== --}}

    @stack('scripts')

</body>

</html>