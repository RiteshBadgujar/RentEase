<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') | RentEase</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- DataTables Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

    <!-- Responsive DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Vite -->
    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <style>
        body {

            font-family: 'Poppins', sans-serif;

            background: #f5f7fb;

            overflow-x: hidden;

        }

        .sidebar {

            width: 260px;

            height: 100vh;

            overflow-y: auto;

            background: #212529;

            position: fixed;

            top: 0;

            left: 0;

            z-index: 1050;

            transition: all .3s ease;

        }

        .sidebar.show {

            left: 0;

        }

        .sidebar.hide {

            left: -260px;

        }

        .sidebar .nav-link {

            color: #adb5bd;

            padding: 12px 20px;

            margin: 5px 10px;

            border-radius: 8px;

            transition: .3s;

        }

        .sidebar .nav-link:hover {

            background: #0d6efd;

            color: #fff;

            transform: translateX(5px);

        }

        .sidebar .nav-link.active {

            background: #0d6efd;

            color: #fff;

            font-weight: 600;

        }

        .content {

            margin-left: 260px;

            min-height: 100vh;

            transition: .3s;

        }

        .topbar {

            background: #fff;

            border-bottom: 1px solid #dee2e6;

        }

        .footer {

            background: #fff;

            border-top: 1px solid #dee2e6;

        }

        .card {

            border: none;

            border-radius: 12px;

            transition: .3s;

        }

        .card:hover {

            transform: translateY(-5px);

            box-shadow: 0 10px 25px rgba(0, 0, 0, .12);

        }

        @media(max-width:992px) {

            .sidebar {

                left: -260px;

            }

            .sidebar.show {

                left: 0;

            }

            .content {

                margin-left: 0;

            }

        }
    </style>

    @stack('styles')

</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">

        @include('partials.admin.sidebar')

    </div>

    <!-- Content -->
    <div class="content">

        @include('partials.admin.navbar')

        <main class="container-fluid py-4">

            @yield('content')

        </main>

        @include('partials.admin.footer')

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

    <!-- Responsive DataTables -->
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <!-- DataTables Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
    <!-- Export Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <!-- Export Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

    <!-- Toast Success -->
    @if(session('success'))

        <script>

            Swal.fire({

                toast: true,

                position: 'top-end',

                icon: 'success',

                title: '{{ session('success') }}',

                showConfirmButton: false,

                timer: 3000

            });

        </script>

    @endif

    <!-- Toast Error -->
    @if(session('error'))

        <script>

            Swal.fire({

                toast: true,

                position: 'top-end',

                icon: 'error',

                title: '{{ session('error') }}',

                showConfirmButton: false,

                timer: 3000

            });

        </script>

    @endif

    @stack('scripts')
    <!-- Global JavaScript -->
    <script>

        document.addEventListener('DOMContentLoaded', function () {

            /*
            |--------------------------------------------------------------------------
            | Mobile Sidebar Toggle
            |--------------------------------------------------------------------------
            */

            const menuToggle = document.getElementById('menu-toggle');
            const sidebar = document.querySelector('.sidebar');

            if (menuToggle && sidebar) {

                menuToggle.addEventListener('click', function () {

                    sidebar.classList.toggle('show');

                });

            }

            /*
            |--------------------------------------------------------------------------
            | SweetAlert Delete Confirmation
            |--------------------------------------------------------------------------
            */

            document.querySelectorAll('.delete-form').forEach(function (form) {

                form.addEventListener('submit', function (e) {

                    e.preventDefault();

                    Swal.fire({

                        title: 'Delete Record?',

                        text: 'This action cannot be undone.',

                        icon: 'warning',

                        showCancelButton: true,

                        confirmButtonColor: '#dc3545',

                        cancelButtonColor: '#6c757d',

                        confirmButtonText: 'Yes, Delete',

                        cancelButtonText: 'Cancel'

                    }).then((result) => {

                        if (result.isConfirmed) {

                            form.submit();

                        }

                    });

                });

            });

            /*
            |--------------------------------------------------------------------------
            | DataTables Initialization
            |--------------------------------------------------------------------------
            */
            $('.datatable').DataTable({

                responsive: true,

                pageLength: 10,

                lengthMenu: [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ],

                ordering: true,

                searching: true,

                paging: true,

                info: true,

                autoWidth: false,

                language: {
                    search: "Search :",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ records",
                    zeroRecords: "No data available",
                    paginate: {
                        previous: "Previous",
                        next: "Next"
                    }
                },

                dom:
                    "<'row mb-3'<'col-md-6'B><'col-md-6'f>>" +
                    "<'row'<'col-12'tr>>" +
                    "<'row mt-3'<'col-md-5'i><'col-md-7'p>>",

                buttons: [

                    {
                        extend: 'copy',
                        className: 'btn btn-secondary btn-sm'
                    },

                    {
                        extend: 'csv',
                        className: 'btn btn-success btn-sm'
                    },

                    {
                        extend: 'excel',
                        className: 'btn btn-success btn-sm'
                    },

                    {
                        extend: 'pdf',
                        className: 'btn btn-danger btn-sm'
                    },

                    {
                        extend: 'print',
                        className: 'btn btn-primary btn-sm'
                    },

                    {
                        extend: 'colvis',
                        className: 'btn btn-dark btn-sm'
                    }

                ]

            });

        }

        });

    </script>

</body>

</html>