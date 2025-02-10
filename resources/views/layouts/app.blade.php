<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tridjaya Merdeka Motor - Admin</title>
    <!-- Link to Bootstrap CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <!-- Link to custom styles -->
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet">
</head>
<body>
    <!-- Layout Wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Sidebar -->
            @include('layouts.partials.sidebar')

            <div class="layout-page">
                <!-- Navbar -->
                @include('layouts.partials.navbar')

                <!-- Content -->
                <div class="content-wrapper">
                    <div class="container-xxl">
                        @yield('content')
                    </div>
                </div>

                <!-- Footer -->
                @include('layouts.partials.footer')
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
<script>
    function confirmLogout(event) {
        event.preventDefault(); // Mencegah langsung logout
        if (confirm("Apakah Anda yakin ingin logout?")) {
            document.getElementById('logout-form').submit();
        }
    }
</script>
</html>
