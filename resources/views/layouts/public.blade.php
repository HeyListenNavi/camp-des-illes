<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50 text-slate-800">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Camp des Iles' }}</title>

    <!-- Google Fonts: Jost & Libre Franklin -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&family=Libre+Franklin:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">

    <!-- Tailwind CSS / Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        body {
            font-family: 'Libre Franklin', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }
        h1, h2, h3, h4, h5, h6, .font-heading {
            font-family: 'Jost', sans-serif;
        }
    </style>
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 antialiased selection:bg-[#135860] selection:text-white py-4 sm:py-8 px-3 sm:px-6">

    <!-- Centered Form Container (No Header, No Footer for Seamless Embedding) -->
    <main class="w-full max-w-4xl mx-auto">
        {{ $slot }}
    </main>

    @livewireScripts
</body>
</html>
