<div class="max-w-4xl mx-auto">
    @if($submitted)
        <div class="bg-slate-900/90 border border-emerald-500/30 rounded-2xl p-8 backdrop-blur-xl shadow-2xl text-center space-y-6 animate-fadeIn">
            <div class="w-16 h-16 bg-emerald-500/20 text-emerald-400 rounded-full flex items-center justify-center mx-auto shadow-lg shadow-emerald-500/20">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <div class="space-y-2">
                <h2 class="text-3xl font-heading font-bold text-white">¡Registros Recibidos con Éxito!</h2>
                <p class="text-slate-300 max-w-lg mx-auto">
                    Se han procesado correctamente las inscripciones para la temporada <span class="text-emerald-400 font-semibold">{{ $session_year }}</span>.
                </p>
            </div>
            
            <div class="space-y-3 max-w-lg mx-auto text-left">
                <span class="text-xs uppercase tracking-wider text-slate-400 font-semibold block text-center">Códigos Únicos de Registro</span>
                @foreach($registered_tokens as $item)
                    <div class="bg-slate-950/90 p-4 rounded-xl border border-slate-800 flex items-center justify-between gap-4">
                        <div>
                            <span class="text-sm font-bold text-white block">{{ $item['name'] }}</span>
                            <code class="text-emerald-400 font-mono text-xs break-all block">{{ $item['token'] }}</code>
                        </div>
                        <a href="{{ route('public.medical.update', ['token' => $item['token']]) }}" class="px-3 py-1.5 rounded-lg bg-emerald-500/20 hover:bg-emerald-500/30 text-emerald-400 text-xs font-semibold border border-emerald-500/30 transition-all shrink-0">
                            Ficha Médica
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="pt-4">
                <button wire:click="$set('submitted', false)" class="px-6 py-3 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold transition-all">
                    Registrar Más Acampantes
                </button>
            </div>
        </div>
    @else
        <form wire:submit.prevent="submit" class="space-y-8">
            <!-- Header section -->
            <div class="bg-gradient-to-r from-emerald-900/40 via-slate-900/60 to-slate-900/80 border border-emerald-500/20 rounded-2xl p-6 sm:p-8 backdrop-blur-xl shadow-xl">
                <div class="flex items-center gap-3 mb-2">
                    <span class="px-3 py-1 text-xs font-bold tracking-wider uppercase rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">Formulario Público</span>
                    <span class="text-slate-400 text-sm">Temporada {{ $session_year }}</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-heading font-extrabold text-white">Inscripción de Acampantes</h1>
                <p class="text-slate-300 mt-2">Ingrese los datos del tutor responsable y agregue a uno o varios acampantes en una misma solicitud.</p>
                <div class="mt-4 flex items-center gap-3">
                    <label class="text-sm font-medium text-slate-300 whitespace-nowrap">Año de Sesión *</label>
                    <input type="text" wire:model.defer="session_year" class="w-32 bg-slate-950/80 border border-slate-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors">
                    @error('session_year') <span class="text-xs text-rose-400">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Section 1: Guardians / Tutores (dinámico) -->
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold">1</div>
                        <h2 class="text-xl font-heading font-bold text-white">Tutores / Responsables Legales ({{ count($guardians) }})</h2>
                    </div>
                    <button type="button" wire:click="addGuardian" class="px-4 py-2 rounded-xl bg-emerald-500/20 text-emerald-400 hover:bg-emerald-500/30 text-sm font-semibold border border-emerald-500/30 transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Agregar Tutor
                    </button>
                </div>

                @foreach($guardians as $gIndex => $guardian)
                    <div class="bg-slate-900/80 border border-slate-800 rounded-2xl p-6 sm:p-8 space-y-6 shadow-lg relative">
                        <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                            <span class="px-3 py-1 text-xs font-bold tracking-wider uppercase rounded-lg bg-slate-800 text-emerald-400">
                                Tutor #{{ $gIndex + 1 }}
                            </span>
                            @if(count($guardians) > 1)
                                <button type="button" wire:click="removeGuardian({{ $gIndex }})" class="text-slate-400 hover:text-rose-400 text-xs font-medium transition-colors flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Quitar Tutor
                                </button>
                            @endif
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">Nombre del Tutor *</label>
                                <input type="text" wire:model.defer="guardians.{{ $gIndex }}.first_name" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors" placeholder="Ej. Juan">
                                @error("guardians.{$gIndex}.first_name") <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">Apellido del Tutor *</label>
                                <input type="text" wire:model.defer="guardians.{{ $gIndex }}.last_name" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors" placeholder="Ej. Pérez">
                                @error("guardians.{$gIndex}.last_name") <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">Teléfono de Contacto *</label>
                                <input type="text" wire:model.defer="guardians.{{ $gIndex }}.phone" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors" placeholder="Ej. +1 555 123 4567">
                                @error("guardians.{$gIndex}.phone") <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">Correo Electrónico</label>
                                <input type="email" wire:model.defer="guardians.{{ $gIndex }}.email" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors" placeholder="ejemplo@correo.com">
                                @error("guardians.{$gIndex}.email") <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">Parentesco / Relación *</label>
                                <select wire:model.defer="guardians.{{ $gIndex }}.relationship_type" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors">
                                    <option value="father">Padre</option>
                                    <option value="mother">Madre</option>
                                    <option value="stepfather">Padrastro</option>
                                    <option value="stepmother">Madrastra</option>
                                    <option value="legal_guardian">Tutor Legal</option>
                                    <option value="emergency_contact">Contacto de Emergencia</option>
                                    <option value="other">Otro</option>
                                </select>
                                @error("guardians.{$gIndex}.relationship_type") <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-slate-300 mb-2">Dirección del Tutor</label>
                                <textarea wire:model.defer="guardians.{{ $gIndex }}.address" rows="2" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors" placeholder="Calle, número, ciudad..."></textarea>
                            </div>
                        </div>

                        <!-- Checkboxes del tutor -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2">
                            <label class="flex items-center gap-2 p-3 rounded-xl bg-slate-950 border border-slate-800 cursor-pointer hover:border-emerald-500/40 transition-colors">
                                <input type="checkbox" wire:model.defer="guardians.{{ $gIndex }}.has_custody" class="rounded bg-slate-900 border-slate-700 text-emerald-500 w-4 h-4">
                                <div>
                                    <span class="text-sm font-semibold text-white block">Tiene la Custodia</span>
                                    <span class="text-xs text-slate-400">Custodia legal del menor</span>
                                </div>
                            </label>

                            <label class="flex items-center gap-2 p-3 rounded-xl bg-slate-950 border border-slate-800 cursor-pointer hover:border-emerald-500/40 transition-colors">
                                <input type="checkbox" wire:model.defer="guardians.{{ $gIndex }}.is_primary_guardian" class="rounded bg-slate-900 border-slate-700 text-emerald-500 w-4 h-4">
                                <div>
                                    <span class="text-sm font-semibold text-white block">Tutor Primario</span>
                                    <span class="text-xs text-slate-400">Contacto principal</span>
                                </div>
                            </label>

                            <label class="flex items-center gap-2 p-3 rounded-xl bg-slate-950 border border-slate-800 cursor-pointer hover:border-emerald-500/40 transition-colors">
                                <input type="checkbox" wire:model.defer="guardians.{{ $gIndex }}.is_emergency_contact" class="rounded bg-slate-900 border-slate-700 text-emerald-500 w-4 h-4">
                                <div>
                                    <span class="text-sm font-semibold text-white block">Contacto de Emergencia</span>
                                    <span class="text-xs text-slate-400">Llamar en emergencias</span>
                                </div>
                            </label>
                        </div>
                    </div>
                @endforeach

                <div class="flex justify-center">
                    <button type="button" wire:click="addGuardian" class="px-6 py-3 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold transition-all flex items-center gap-2 border border-slate-700">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        + Agregar Otro Tutor
                    </button>
                </div>
            </div>


            <!-- Section 2: Dynamic Campers List -->
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold">2</div>
                        <h2 class="text-xl font-heading font-bold text-white">Acampantes a Inscribir ({{ count($campers) }})</h2>
                    </div>
                    <button type="button" wire:click="addCamper" class="px-4 py-2 rounded-xl bg-emerald-500/20 text-emerald-400 hover:bg-emerald-500/30 text-sm font-semibold border border-emerald-500/30 transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Agregar Otro Acampante
                    </button>
                </div>

                @foreach($campers as $index => $camper)
                    <div class="bg-slate-900/90 border border-slate-800 rounded-2xl p-6 sm:p-8 space-y-6 shadow-xl relative">
                        <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                            <span class="px-3 py-1 text-xs font-bold tracking-wider uppercase rounded-lg bg-slate-800 text-emerald-400">
                                Acampante #{{ $index + 1 }}
                            </span>
                            @if(count($campers) > 1)
                                <button type="button" wire:click="removeCamper({{ $index }})" class="text-slate-400 hover:text-rose-400 text-xs font-medium transition-colors flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Quitar Acampante
                                </button>
                            @endif
                        </div>

                        <!-- Personal Data -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">Nombre del Acampante *</label>
                                <input type="text" wire:model.defer="campers.{{ $index }}.first_name" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-emerald-500" placeholder="Ej. Mateo">
                                @error("campers.{$index}.first_name") <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">Apellido del Acampante *</label>
                                <input type="text" wire:model.defer="campers.{{ $index }}.last_name" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-emerald-500" placeholder="Ej. Pérez">
                                @error("campers.{$index}.last_name") <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">Género *</label>
                                <select wire:model.defer="campers.{{ $index }}.gender" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-emerald-500">
                                    <option value="male">Masculino</option>
                                    <option value="female">Femenino</option>
                                    <option value="other">Otro</option>
                                </select>
                                @error("campers.{$index}.gender") <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">Fecha de Nacimiento *</label>
                                <input type="date" wire:model.defer="campers.{{ $index }}.date_of_birth" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-emerald-500">
                                @error("campers.{$index}.date_of_birth") <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-slate-300 mb-2">Nº Seguro / Cartilla Médica</label>
                                <input type="text" wire:model.defer="campers.{{ $index }}.health_card_number" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-emerald-500" placeholder="Ej. NSS-987654321">
                            </div>
                        </div>

                        <!-- Medical info -->
                        <div class="pt-4 border-t border-slate-800 space-y-4">
                            <h3 class="text-sm font-bold text-emerald-400 uppercase tracking-wider">Ficha Médica</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-slate-400 mb-1">Alergias Conocidas</label>
                                    <textarea wire:model.defer="campers.{{ $index }}.allergies" rows="2" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-emerald-500" placeholder="Medicamentos, alimentos..."></textarea>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-400 mb-1">Medicamentos Actuales</label>
                                    <textarea wire:model.defer="campers.{{ $index }}.medications" rows="2" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-emerald-500" placeholder="Dosis y horario..."></textarea>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-400 mb-1">Restricciones Dietéticas</label>
                                    <textarea wire:model.defer="campers.{{ $index }}.dietary_restrictions" rows="2" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-emerald-500" placeholder="Vegetariano, celíaco..."></textarea>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-400 mb-1">Alertas Críticas</label>
                                    <textarea wire:model.defer="campers.{{ $index }}.critical_alerts" rows="2" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-emerald-500" placeholder="Inhalador, sonambulismo..."></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Consents -->
                        <div class="pt-4 border-t border-slate-800 space-y-3">
                            <h3 class="text-sm font-bold text-emerald-400 uppercase tracking-wider">Autorizaciones</h3>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                                <label class="flex items-center gap-2 p-2 rounded-lg bg-slate-950 border border-slate-800 cursor-pointer">
                                    <input type="checkbox" wire:model.defer="campers.{{ $index }}.photo_permission" class="rounded bg-slate-900 border-slate-700 text-emerald-500">
                                    <span class="text-slate-300">Permiso de Fotografía</span>
                                </label>

                                <label class="flex items-center gap-2 p-2 rounded-lg bg-slate-950 border border-slate-800 cursor-pointer">
                                    <input type="checkbox" wire:model.defer="campers.{{ $index }}.travel_permission" class="rounded bg-slate-900 border-slate-700 text-emerald-500">
                                    <span class="text-slate-300">Permiso de Traslados</span>
                                </label>
                            </div>

                            <label class="flex items-start gap-3 p-3 rounded-xl bg-emerald-950/30 border border-emerald-500/40 cursor-pointer">
                                <input type="checkbox" wire:model.defer="campers.{{ $index }}.medical_permission" class="mt-0.5 w-4 h-4 rounded bg-slate-900 border-emerald-500 text-emerald-500">
                                <div>
                                    <span class="font-bold text-emerald-400 text-xs">Autorización de Atención Médica de Emergencia *</span>
                                    @error("campers.{$index}.medical_permission") <span class="text-xs text-rose-400 mt-1 block font-semibold">{{ $message }}</span> @enderror
                                </div>
                            </label>
                        </div>
                    </div>
                @endforeach

                <div class="pt-2 flex justify-center">
                    <button type="button" wire:click="addCamper" class="px-6 py-3 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold transition-all flex items-center gap-2 border border-slate-700">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        + Agregar Otro Acampante
                    </button>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4 flex justify-end">
                <button type="submit" class="w-full sm:w-auto px-8 py-4 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-400 hover:from-emerald-400 hover:to-teal-300 text-slate-950 font-bold text-lg shadow-xl shadow-emerald-500/25 transition-all transform hover:-translate-y-0.5">
                    Completar Inscripciones ({{ count($campers) }})
                </button>
            </div>
        </form>
    @endif
</div>
