<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-900 text-slate-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Campamento - Portal Público') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS / Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        h1, h2, h3, h4, .font-heading {
            font-family: 'Outfit', sans-serif;
        }
        /* Rule for embeddable iframe */
        body.is-iframe header, 
        body.is-iframe footer { 
            display: none !important; 
        }
        body.is-iframe main {
            padding-top: 1rem !important;
            padding-bottom: 1rem !important;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (window.self !== window.top) {
                document.body.classList.add("is-iframe");
            }
        });
    </script>
</head>
<body class="min-h-screen flex flex-col bg-gradient-to-br from-slate-950 via-slate-900 to-emerald-950 text-slate-100 antialiased selection:bg-emerald-500 selection:text-white">

    <!-- Public Header with Camp Branding -->
    <header class="sticky top-0 z-50 backdrop-blur-md bg-slate-900/80 border-b border-slate-800/80 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="/" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-500 to-teal-400 flex items-center justify-center shadow-lg shadow-emerald-500/20 group-hover:scale-105 transition-transform">
                    <svg class="w-6 h-6 text-slate-950" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                    </svg>
                </div>
                <div>
                    <span class="font-heading font-bold text-xl tracking-tight text-white group-hover:text-emerald-400 transition-colors">Campamento Aventura</span>
                    <span class="block text-xs font-medium text-emerald-400/90 tracking-wider uppercase">Portal de Registros</span>
                </div>
            </a>

            <nav class="hidden md:flex items-center gap-6">
                <a href="{{ route('public.camper.register') }}" class="text-sm font-medium text-slate-300 hover:text-emerald-400 transition-colors">Inscripción Acampantes</a>
                <a href="{{ route('public.group.register') }}" class="text-sm font-medium text-slate-300 hover:text-emerald-400 transition-colors">Solicitudes de Grupos</a>
                <a href="/admin" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-emerald-500/10 text-emerald-400 text-sm font-semibold border border-emerald-500/20 hover:bg-emerald-500/20 transition-all">
                    <span>Acceso Admin</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </nav>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full">
        {{ $slot }}
    </main>

    <!-- Public Footer -->
    <footer class="bg-slate-950 border-t border-slate-800/80 mt-auto py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-4 text-sm text-slate-400">
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold text-xs">C</div>
                <span>&copy; {{ date('Y') }} Campamento Aventura. Todos los derechos reservados.</span>
            </div>
            <div class="flex items-center gap-6 text-xs text-slate-400">
                <span class="inline-flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Sistema Activo
                </span>
                <a href="#" class="hover:text-slate-200 transition-colors">Políticas de Privacidad</a>
                <a href="#" class="hover:text-slate-200 transition-colors">Términos del Servicio</a>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
