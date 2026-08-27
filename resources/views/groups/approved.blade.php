<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserva Aprobada</title>

    <!-- Tailwind CSS (Carga inmediata de estilos para la demo) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js (Para el botón de copiar enlace) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-4xl mx-auto space-y-6 py-8 px-4">
        <!-- Main Approval Card -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-6 sm:p-10 shadow-sm text-center space-y-8">
            
            <!-- Status Badge & Icon -->
            <div class="space-y-4">
                <div class="w-20 h-20 bg-emerald-50 text-[#135860] rounded-full flex items-center justify-center mx-auto border border-emerald-100 shadow-sm">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                
                <div class="space-y-2">
                    <span class="px-3 py-1 text-xs font-bold tracking-wider uppercase rounded-full bg-[#135860]/10 text-[#135860] border border-[#135860]/20 inline-block">
                        Reservation Approved
                    </span>
                    <h1 class="text-3xl sm:text-4xl font-bold text-slate-900">
                        Your Group Has Been Successfully Approved!
                    </h1>
                    <p class="text-slate-600 max-w-xl mx-auto leading-relaxed text-sm sm:text-base">
                        Great news! After reviewing your request, we have confirmed availability for your dates and requested amenities for <span class="text-[#135860] font-semibold bg-[#135860]/10 px-2 py-0.5 rounded-lg">{{ $groupName }}</span>.
                    </p>
                </div>
            </div>

            <!-- Callout Box -->
            <div class="bg-gradient-to-br from-[#135860] to-[#0d434a] text-white rounded-2xl p-6 sm:p-8 shadow-md relative overflow-hidden text-left border border-[#135860]">
                <div class="relative z-10 space-y-4">
                    <div class="flex items-center gap-2 text-emerald-300 font-bold text-xs uppercase tracking-wider">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                        </svg>
                        Action Required
                    </div>

                    <h2 class="text-xl sm:text-2xl font-bold text-white leading-snug">
                        Help us by sharing this link with your friends so they can register individually!
                    </h2>

                    <!-- Shareable Link Box -->
                    <div class="flex flex-col sm:flex-row items-center gap-3 pt-2" x-data="{ copied: false }">
                        <div class="w-full bg-white/10 backdrop-blur-md border border-white/20 rounded-xl px-4 py-3 font-mono text-xs sm:text-sm text-slate-100 truncate">
                            {{ route('groups.register-individual') }}
                        </div>
                        <button 
                            @click="navigator.clipboard.writeText('{{ route('groups.register-individual') }}'); copied = true; setTimeout(() => copied = false, 2000)"
                            class="w-full sm:w-auto shrink-0 bg-white text-[#135860] hover:bg-slate-100 font-bold px-5 py-3 rounded-xl shadow-sm transition-all active:scale-95 text-xs sm:text-sm flex items-center justify-center gap-2 cursor-pointer"
                        >
                            <span x-show="!copied">Copy Link</span>
                            <span x-show="copied" class="text-emerald-700 flex items-center gap-1" style="display: none;">
                                ✓ Copied!
                            </span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Direct Form Action Button -->
            <div class="pt-2">
                <a href="{{ route('groups.register-individual') }}" class="inline-flex items-center justify-center w-full sm:w-auto px-10 py-4 rounded-2xl bg-[#135860] hover:bg-[#0d434a] text-white font-bold text-base shadow-md transition-all active:scale-[0.98] gap-2">
                    <span>Proceed to Individual Registration</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>

        </div>
    </div>

</body>
</html>