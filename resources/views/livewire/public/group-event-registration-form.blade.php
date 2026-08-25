<div class="max-w-4xl mx-auto">
    @if($submitted)
        <div class="bg-slate-900/90 border border-emerald-500/30 rounded-2xl p-8 backdrop-blur-xl shadow-2xl text-center space-y-6 animate-fadeIn">
            <div class="w-16 h-16 bg-emerald-500/20 text-emerald-400 rounded-full flex items-center justify-center mx-auto shadow-lg shadow-emerald-500/20">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <div class="space-y-2">
                <h2 class="text-3xl font-heading font-bold text-white">¡Solicitud de Evento Recibida!</h2>
                <p class="text-slate-300 max-w-lg mx-auto">
                    Hemos registrado la solicitud para el grupo <span class="text-emerald-400 font-semibold">{{ $group_name }}</span>. Nuestro equipo operativo evaluará la disponibilidad y se pondrá en contacto a la brevedad.
                </p>
            </div>
            
            <div class="bg-slate-950/80 rounded-xl p-4 border border-slate-800 max-w-md mx-auto space-y-2 text-left">
                <span class="text-xs uppercase tracking-wider text-slate-500 font-semibold block">Código de Seguimiento de Evento</span>
                <code class="text-emerald-400 font-mono text-sm break-all block selection:bg-emerald-500/30">{{ $event_token }}</code>
            </div>

            <div class="pt-4">
                <button wire:click="$set('submitted', false)" class="px-6 py-3 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold transition-all">
                    Enviar Otra Solicitud
                </button>
            </div>
        </div>
    @else
        <form wire:submit.prevent="submit" class="space-y-8">
            <!-- Header section -->
            <div class="bg-gradient-to-r from-teal-900/40 via-slate-900/60 to-slate-900/80 border border-teal-500/20 rounded-2xl p-6 sm:p-8 backdrop-blur-xl shadow-xl">
                <div class="flex items-center gap-3 mb-2">
                    <span class="px-3 py-1 text-xs font-bold tracking-wider uppercase rounded-full bg-teal-500/20 text-teal-400 border border-teal-500/30">Reservación de Grupos</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-heading font-extrabold text-white">Solicitud de Eventos y Grupos</h1>
                <p class="text-slate-300 mt-2">Gestione la estancia de su grupo, escuela o empresa reservando servicios de alimentación, hospedaje y actividades guiadas.</p>
            </div>

            <!-- Section 1: Group Contact Details -->
            <div class="bg-slate-900/80 border border-slate-800 rounded-2xl p-6 sm:p-8 space-y-6 shadow-lg">
                <div class="flex items-center gap-3 border-b border-slate-800 pb-4">
                    <div class="w-8 h-8 rounded-lg bg-teal-500/20 text-teal-400 flex items-center justify-center font-bold">1</div>
                    <h2 class="text-xl font-heading font-bold text-white">Información de la Organización / Grupo</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Nombre del Grupo *</label>
                        <input type="text" wire:model.defer="group_name" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-colors" placeholder="Ej. Scout Grupo 14">
                        @error('group_name') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Institución / Empresa</label>
                        <input type="text" wire:model.defer="organization_name" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-colors" placeholder="Ej. Colegio San José">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Contacto Principal *</label>
                        <input type="text" wire:model.defer="primary_contact_name" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-colors" placeholder="Ej. Laura Gómez">
                        @error('primary_contact_name') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Teléfono *</label>
                        <input type="text" wire:model.defer="phone" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-colors" placeholder="Ej. +52 55 9876 5432">
                        @error('phone') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Correo Electrónico *</label>
                        <input type="email" wire:model.defer="email" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-colors" placeholder="contacto@grupo.org">
                        @error('email') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Dirección Fiscal / Ciudad</label>
                        <input type="text" wire:model.defer="address" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-colors" placeholder="Ciudad, Estado">
                    </div>
                </div>
            </div>

            <!-- Section 2: Event Parameters -->
            <div class="bg-slate-900/80 border border-slate-800 rounded-2xl p-6 sm:p-8 space-y-6 shadow-lg">
                <div class="flex items-center gap-3 border-b border-slate-800 pb-4">
                    <div class="w-8 h-8 rounded-lg bg-teal-500/20 text-teal-400 flex items-center justify-center font-bold">2</div>
                    <h2 class="text-xl font-heading font-bold text-white">Detalles de las Fechas y Asistencia</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Fecha de Llegada *</label>
                        <input type="date" wire:model.defer="start_date" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-colors">
                        @error('start_date') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Fecha de Salida *</label>
                        <input type="date" wire:model.defer="end_date" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-colors">
                        @error('end_date') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Asistentes Estimados *</label>
                        <input type="number" wire:model.defer="expected_attendees" min="1" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-colors">
                        @error('expected_attendees') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="sm:col-span-3">
                        <label class="block text-sm font-medium text-slate-300 mb-2">Actividades Especiales Solicitadas</label>
                        <textarea wire:model.defer="special_activities" rows="2" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-colors" placeholder="Fogatas, tirolesa, talleres de integración, etc."></textarea>
                    </div>
                </div>
            </div>

            <!-- Section 3: Dynamic Service Requests -->
            <div class="bg-slate-900/80 border border-slate-800 rounded-2xl p-6 sm:p-8 space-y-6 shadow-lg">
                <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-teal-500/20 text-teal-400 flex items-center justify-center font-bold">3</div>
                        <h2 class="text-xl font-heading font-bold text-white">Solicitud de Servicios Específicos</h2>
                    </div>
                    <button type="button" wire:click="addService" class="px-3 py-1.5 rounded-lg bg-teal-500/20 text-teal-400 hover:bg-teal-500/30 text-xs font-semibold border border-teal-500/30 transition-all flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Agregar Servicio
                    </button>
                </div>

                <div class="space-y-4">
                    @foreach($services as $index => $service)
                        <div class="bg-slate-950 p-4 rounded-xl border border-slate-800 grid grid-cols-1 sm:grid-cols-12 gap-4 items-start relative">
                            <div class="sm:col-span-3">
                                <label class="block text-xs font-medium text-slate-400 mb-1">Categoría</label>
                                <select wire:model.defer="services.{{ $index }}.service_category" class="w-full bg-slate-900 border border-slate-800 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-teal-500">
                                    <option value="meal">Alimentación</option>
                                    <option value="lodging">Hospedaje</option>
                                    <option value="activity">Actividad / Taller</option>
                                </select>
                            </div>

                            <div class="sm:col-span-4">
                                <label class="block text-xs font-medium text-slate-400 mb-1">Nombre del Servicio *</label>
                                <input type="text" wire:model.defer="services.{{ $index }}.service_name" class="w-full bg-slate-900 border border-slate-800 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-teal-500" placeholder="Ej. Desayuno buffet">
                                @error("services.{$index}.service_name") <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-xs font-medium text-slate-400 mb-1">Cantidad *</label>
                                <input type="number" wire:model.defer="services.{{ $index }}.quantity" min="1" class="w-full bg-slate-900 border border-slate-800 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-teal-500">
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-xs font-medium text-slate-400 mb-1">Notas</label>
                                <input type="text" wire:model.defer="services.{{ $index }}.notes" class="w-full bg-slate-900 border border-slate-800 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-teal-500" placeholder="Opcional">
                            </div>

                            <div class="sm:col-span-1 flex items-center justify-end pt-5">
                                @if(count($services) > 1)
                                    <button type="button" wire:click="removeService({{ $index }})" class="p-2 text-slate-400 hover:text-rose-400 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Section 4: Document Uploads -->
            <div class="bg-slate-900/80 border border-slate-800 rounded-2xl p-6 sm:p-8 space-y-6 shadow-lg">
                <div class="flex items-center gap-3 border-b border-slate-800 pb-4">
                    <div class="w-8 h-8 rounded-lg bg-teal-500/20 text-teal-400 flex items-center justify-center font-bold">4</div>
                    <h2 class="text-xl font-heading font-bold text-white">Documentación Adjunta (Opcional)</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Insurance File -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-slate-300">Póliza o Constancia de Seguro</label>
                        <div class="relative border-2 border-dashed border-slate-800 hover:border-teal-500/50 rounded-xl p-4 transition-colors bg-slate-950">
                            <input type="file" wire:model="insurance_file" accept=".pdf,.jpg,.jpeg,.png" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-teal-500/10 text-teal-400 rounded-lg">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <div class="truncate">
                                    @if($insurance_file)
                                        <p class="text-sm font-medium text-teal-400 truncate">{{ $insurance_file->getClientOriginalName() }}</p>
                                        <p class="text-xs text-slate-500">Archivo seleccionado</p>
                                    @else
                                        <p class="text-sm text-slate-300">Seleccionar Póliza de Seguro</p>
                                        <p class="text-xs text-slate-500">PDF, PNG o JPG (máx. 10MB)</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @error('insurance_file') <span class="text-xs text-rose-400 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Contract File -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-slate-300">Contrato Firmado / Acuerdos</label>
                        <div class="relative border-2 border-dashed border-slate-800 hover:border-teal-500/50 rounded-xl p-4 transition-colors bg-slate-950">
                            <input type="file" wire:model="contract_file" accept=".pdf,.doc,.docx" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-teal-500/10 text-teal-400 rounded-lg">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <div class="truncate">
                                    @if($contract_file)
                                        <p class="text-sm font-medium text-teal-400 truncate">{{ $contract_file->getClientOriginalName() }}</p>
                                        <p class="text-xs text-slate-500">Archivo seleccionado</p>
                                    @else
                                        <p class="text-sm text-slate-300">Seleccionar Contrato</p>
                                        <p class="text-xs text-slate-500">PDF, DOC o DOCX (máx. 10MB)</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @error('contract_file') <span class="text-xs text-rose-400 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4 flex justify-end">
                <button type="submit" class="w-full sm:w-auto px-8 py-4 rounded-xl bg-gradient-to-r from-teal-500 to-emerald-400 hover:from-teal-400 hover:to-emerald-300 text-slate-950 font-bold text-lg shadow-xl shadow-teal-500/25 transition-all transform hover:-translate-y-0.5">
                    Enviar Solicitud de Grupo
                </button>
            </div>
        </form>
    @endif
</div>