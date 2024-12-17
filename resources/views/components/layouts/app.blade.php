<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'QuickLabBook' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    @livewireStyles
    <style>
        body {
            /* font-family: Arial, Helvetica, sans-serif; */
            line-height: 1.6;
            overflow-x: hidden;
            background-image:  url({{ asset('assets/fptv.jpg')}});
            background-repeat: no-repeat; /* Prevents image tiling */
        }
       
        .background-slider {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            animation: slide 20s infinite;
            z-index: -1; /* Make sure the slider is in the background */
        }
           /* Slide Animation */
        /* @keyframes slide {
            0% { background-image:  url({{ asset('assets/gambar3.jpeg')}}) }
            33% { background-image: url({{ asset('assets/gambar2.jpeg')}}) }
            66% { background-image: url({{ asset('assets/gambar1.png')}}) }
            100% { background-image: url({{ asset('assets/gambar4.jpeg')}}) }
        } */
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <div class="background-slider"></div>
    <!-- Navbar -->
    @livewire('partials.navbar')

    <!-- Main Wrapper -->
    <div class="d-flex flex-grow-1">
        <!-- Sidebar -->
        @livewire('partials.sidebar')
        <!-- Main Content -->
        <main class="flex-fill pt-5 pe-4 pb-3">
            {{ $slot }}
        </main>
    </div>

    <!-- Footer -->
    @livewire('partials.footer')

    @livewireStyles
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
</body>


</html>
