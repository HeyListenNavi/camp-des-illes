<div class="max-w-4xl mx-auto space-y-8">
    <!-- Header section -->
    <div class="bg-gradient-to-r from-blue-900/40 via-slate-900/60 to-slate-900/80 border border-blue-500/20 rounded-2xl p-6 sm:p-8 backdrop-blur-xl shadow-xl">
        <div class="flex items-center justify-between">
            <span class="px-3 py-1 text-xs font-bold tracking-wider uppercase rounded-full bg-blue-500/20 text-blue-400 border border-blue-500/30">Acceso Seguro por Token</span>
            <span class="text-xs text-slate-400 font-mono">{{ $registration->token }}</span>
        </div>
        <h1 class="text-3xl font-heading font-extrabold text-white mt-2">Ficha Médica y Autorizaciones</h1>
        <p class="text-slate-300 mt-1">
            Acampante: <span class="text-blue-400 font-bold">{{ $registration->camper->first_name }} {{ $registration->camper->last_name }}</span> 
            (Temporada {{ $registration->session_year }})
        </p>
    </div>

    @if($saved)
        <div class="bg-emerald-950/50 border border-emerald-500/40 rounded-xl p-4 text-emerald-300 text-sm flex items-center gap-3">
            <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span>La información médica y autorizaciones se han actualizado correctamente.</span>
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-8">
        <!-- Medical Info -->
        <div class="bg-slate-900/80 border border-slate-800 rounded-2xl p-6 sm:p-8 space-y-6 shadow-lg">
            <h2 class="text-xl font-heading font-bold text-white border-b border-slate-800 pb-3">Antecedentes Médicos</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Alergias Conocidas</label>
                    <textarea wire:model.defer="allergies" rows="3" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Medicamentos Actuales</label>
                    <textarea wire:model.defer="medications" rows="3" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Restricciones Dietéticas</label>
                    <textarea wire:model.defer="dietary_restrictions" rows="3" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Alertas Críticas</label>
                    <textarea wire:model.defer="critical_alerts" rows="3" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500"></textarea>
                </div>
            </div>
        </div>

        <!-- Consents -->
        <div class="bg-slate-900/80 border border-slate-800 rounded-2xl p-6 sm:p-8 space-y-6 shadow-lg">
            <h2 class="text-xl font-heading font-bold text-white border-b border-slate-800 pb-3">Autorizaciones Firma Digital</h2>

            <div class="space-y-4">
                <label class="flex items-start gap-3 p-3 rounded-xl bg-slate-950 border border-slate-800 cursor-pointer">
                    <input type="checkbox" wire:model.defer="photo_permission" class="mt-1 w-5 h-5 rounded bg-slate-900 text-blue-500 focus:ring-blue-500">
                    <span class="text-slate-200 text-sm">Permiso de Fotografía y Video</span>
                </label>

                <label class="flex items-start gap-3 p-3 rounded-xl bg-slate-950 border border-slate-800 cursor-pointer">
                    <input type="checkbox" wire:model.defer="travel_permission" class="mt-1 w-5 h-5 rounded bg-slate-900 text-blue-500 focus:ring-blue-500">
                    <span class="text-slate-200 text-sm">Permiso de Traslados y Excursiones</span>
                </label>

                <label class="flex items-start gap-3 p-3 rounded-xl bg-slate-950 border border-slate-800 cursor-pointer">
                    <input type="checkbox" wire:model.defer="contact_permission" class="mt-1 w-5 h-5 rounded bg-slate-900 text-blue-500 focus:ring-blue-500">
                    <span class="text-slate-200 text-sm">Contacto Directo e Información</span>
                </label>

                <label class="flex items-start gap-3 p-4 rounded-xl bg-blue-950/30 border border-blue-500/40 cursor-pointer">
                    <input type="checkbox" wire:model.defer="medical_permission" class="mt-1 w-5 h-5 rounded bg-slate-900 text-blue-500 focus:ring-blue-500">
                    <div>
                        <span class="font-bold text-blue-400 text-sm">Autorización de Atención Médica de Emergencia *</span>
                        @error('medical_permission') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </label>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-8 py-4 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-lg shadow-xl shadow-blue-500/25 transition-all">
                Guardar Cambios
            </button>
        </div>
    </form>
</div>
