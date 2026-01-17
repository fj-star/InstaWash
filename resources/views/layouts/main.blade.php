<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-LAUNDRY</title>
    <link rel="icon" href="{{ asset('assets/img/logo.jpg') }}" type="image/png">
    <!-- Fonts & Styles -->
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Tambahkan Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body id="page-top">
<div id="wrapper">
    {{-- Sidebar --}}
    @include('layouts.sidebar')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            {{-- Topbar --}}
            @include('layouts.topbar')
            <!-- Main Content -->
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
        {{-- Footer --}}
        @include('layouts.footer')
    </div>
</div>
<!-- Scroll to Top -->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>
<!-- Scripts -->
@include('layouts.script')
{{-- Global Alert --}}
@include('components.alert')
{{-- Tambahan untuk script per halaman --}}
@yield('scripts')
@stack('scripts')
@stack('styles')
</body>
</html>
