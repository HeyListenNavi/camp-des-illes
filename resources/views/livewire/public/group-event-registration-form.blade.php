<div class="max-w-4xl mx-auto pb-28">
    @if($submitted)
        <!-- Pantalla de confirmación con tarjeta elevadas y acento verde de éxito -->
        <div class="bg-white border border-gray-100 rounded-2xl p-8 sm:p-10 shadow-xl text-center space-y-6 animate-fadeIn">
            <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center mx-auto shadow-inner border border-emerald-100">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            
            <div class="space-y-2">
                <h2 class="text-3xl font-bold text-gray-900 tracking-tight">¡Solicitud de Evento Recibida!</h2>
                <p class="text-gray-600 max-w-lg mx-auto leading-relaxed">
                    Hemos registrado la solicitud para el grupo <span class="text-emerald-700 font-semibold bg-emerald-50 px-2 py-0.5 rounded">{{ $group_name }}</span>. Nuestro equipo operativo evaluará la disponibilidad y se pondrá en contacto a la brevedad.
                </p>
            </div>
            
            <div class="bg-gray-50 rounded-xl p-5 border border-gray-200/80 max-w-md mx-auto space-y-2 text-left shadow-sm">
                <span class="text-xs uppercase tracking-wider text-gray-500 font-bold block">Código de Seguimiento de Evento</span>
                <code class="text-indigo-900 bg-indigo-50 border border-indigo-100 rounded-lg px-3 py-1.5 font-mono text-sm break-all block font-semibold selection:bg-indigo-100">{{ $event_token }}</code>
            </div>

            <div class="pt-4">
                <button wire:click="$set('submitted', false)" class="px-6 py-3 rounded-xl bg-gray-900 hover:bg-gray-800 text-white font-medium shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                    Enviar Otra Solicitud
                </button>
            </div>
        </div>
    @else
        <form wire:submit.prevent="submit" class="space-y-8">
            <!-- Header Section (Gradiente moderno + Insignia SaaS) -->
            <div class="bg-gradient-to-r from-blue-900 via-indigo-900 to-slate-900 border border-indigo-800/40 rounded-2xl p-6 sm:p-8 shadow-xl text-white relative overflow-hidden">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 text-xs font-bold tracking-wider uppercase rounded-full bg-blue-500/20 text-blue-200 border border-blue-400/30 backdrop-blur-md">Reservación de Grupos</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-white">Solicitud de Eventos y Grupos</h1>
                <p class="text-blue-100/90 mt-2 max-w-2xl leading-relaxed text-sm sm:text-base">Gestione la estancia de su grupo, escuela o empresa reservando servicios de alimentación, hospedaje y actividades guiadas.</p>
            </div>

            <!-- Sección 1: Información de la Organización -->
            <div class="bg-white border border-gray-200/80 rounded-2xl p-6 sm:p-8 space-y-6 shadow-sm">
                <div class="flex items-center gap-3 border-b border-gray-100 pb-4">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 font-bold flex items-center justify-center text-sm border border-blue-100">1</div>
                    <h2 class="text-xl font-bold text-gray-900">Información de la Organización / Grupo</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nombre del Grupo *</label>
                        <input type="text" wire:model.defer="group_name" class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-gray-900 focus:bg-white focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 transition-all placeholder:text-gray-400" placeholder="Ej. Scout Grupo 14">
                        @error('group_name') <span class="text-xs font-medium text-rose-600 mt-1.5 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Institución / Empresa</label>
                        <input type="text" wire:model.defer="organization_name" class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-gray-900 focus:bg-white focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 transition-all placeholder:text-gray-400" placeholder="Ej. Colegio San José">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Contacto Principal *</label>
                        <input type="text" wire:model.defer="primary_contact_name" class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-gray-900 focus:bg-white focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 transition-all placeholder:text-gray-400" placeholder="Ej. Laura Gómez">
                        @error('primary_contact_name') <span class="text-xs font-medium text-rose-600 mt-1.5 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Teléfono *</label>
                        <input type="text" wire:model.defer="phone" class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-gray-900 focus:bg-white focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 transition-all placeholder:text-gray-400" placeholder="Ej. +52 55 9876 5432">
                        @error('phone') <span class="text-xs font-medium text-rose-600 mt-1.5 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Correo Electrónico *</label>
                        <input type="email" wire:model.defer="email" class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-gray-900 focus:bg-white focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 transition-all placeholder:text-gray-400" placeholder="contacto@grupo.org">
                        @error('email') <span class="text-xs font-medium text-rose-600 mt-1.5 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Dirección Fiscal / Ciudad</label>
                        <input type="text" wire:model.defer="address" class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-gray-900 focus:bg-white focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 transition-all placeholder:text-gray-400" placeholder="Ciudad, Estado">
                    </div>
                </div>
            </div>

            <!-- Sección 2: Detalles de Fechas y Asistencia -->
            <div class="bg-white border border-gray-200/80 rounded-2xl p-6 sm:p-8 space-y-6 shadow-sm">
                <div class="flex items-center gap-3 border-b border-gray-100 pb-4">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 font-bold flex items-center justify-center text-sm border border-blue-100">2</div>
                    <h2 class="text-xl font-bold text-gray-900">Detalles de las Fechas y Asistencia</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Fecha de Llegada *</label>
                        <input type="date" wire:model.defer="start_date" class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-gray-900 focus:bg-white focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 transition-all">
                        @error('start_date') <span class="text-xs font-medium text-rose-600 mt-1.5 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Fecha de Salida *</label>
                        <input type="date" wire:model.defer="end_date" class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-gray-900 focus:bg-white focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 transition-all">
                        @error('end_date') <span class="text-xs font-medium text-rose-600 mt-1.5 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Asistentes Estimados *</label>
                        <input type="number" wire:model.defer="expected_attendees" min="1" class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-gray-900 focus:bg-white focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 transition-all">
                        @error('expected_attendees') <span class="text-xs font-medium text-rose-600 mt-1.5 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="sm:col-span-3">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Actividades Especiales Solicitadas</label>
                        <textarea wire:model.defer="special_activities" rows="3" class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-gray-900 focus:bg-white focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 transition-all placeholder:text-gray-400" placeholder="Fogatas, tirolesa, talleres de integración, etc."></textarea>
                    </div>
                </div>
            </div>

            <!-- Sección 3: Selección de Servicios -->
            <div class="bg-white border border-gray-200/80 rounded-2xl p-6 sm:p-8 space-y-8 shadow-sm">
                <div class="flex items-center gap-3 border-b border-gray-100 pb-4">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 font-bold flex items-center justify-center text-sm border border-blue-100">3</div>
                    <h2 class="text-xl font-bold text-gray-900">Selección de Servicios</h2>
                </div>

                <!-- 3.1: Alimentación -->
                <div class="space-y-4">
                    <h3 class="text-md font-bold text-blue-900 border-b border-gray-100 pb-2 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        Opciones de Alimentación
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($mealOptions as $meal)
                            <div class="bg-gray-50/70 hover:bg-white p-4 rounded-xl border border-gray-200 flex items-center justify-between gap-4 transition-all hover:shadow-sm">
                                <div class="flex-1">
                                    <h4 class="font-bold text-gray-900 text-sm">{{ $meal->name }}</h4>
                                    @if($meal->description)
                                        <p class="text-xs text-gray-500 mt-0.5 line-clamp-2 leading-relaxed">{{ $meal->description }}</p>
                                    @endif
                                    <p class="text-xs font-semibold text-blue-700 mt-1">${{ number_format($meal->price_per_person, 2) }} / persona</p>
                                </div>
                                <div class="w-24">
                                    <label class="block text-[10px] font-bold uppercase tracking-wider text-gray-400 mb-1">Cantidad</label>
                                    <input type="number" min="0" wire:model.defer="selected_meals.{{ $meal->id }}" placeholder="0" class="w-full bg-white border border-gray-300 rounded-lg px-3 py-1.5 text-sm font-semibold text-gray-900 focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600">
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 col-span-2 italic bg-gray-50 p-4 rounded-xl border border-dashed border-gray-200">No hay opciones de alimentación disponibles actualmente.</p>
                        @endforelse
                    </div>
                </div>

                <!-- 3.2: Hospedaje -->
                <div class="space-y-4">
                    <h3 class="text-md font-bold text-blue-900 border-b border-gray-100 pb-2 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Tipos de Habitación / Hospedaje
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($roomTypes as $room)
                            <div class="bg-gray-50/70 hover:bg-white p-4 rounded-xl border border-gray-200 flex items-center justify-between gap-4 transition-all hover:shadow-sm">
                                <div class="flex-1">
                                    <h4 class="font-bold text-gray-900 text-sm">{{ $room->name }}</h4>
                                    @if($room->description)
                                        <p class="text-xs text-gray-500 mt-0.5 line-clamp-2 leading-relaxed">{{ $room->description }}</p>
                                    @endif
                                    <div class="flex items-center gap-3 mt-1.5 text-xs">
                                        <span class="font-semibold text-blue-700">${{ number_format($room->price_per_night, 2) }} / noche</span>
                                        <span class="text-gray-400">•</span>
                                        <span class="text-gray-500 font-medium">Capacidad: {{ $room->capacity }} pers.</span>
                                    </div>
                                </div>
                                <div class="w-24">
                                    <label class="block text-[10px] font-bold uppercase tracking-wider text-gray-400 mb-1">Habitaciones</label>
                                    <input type="number" min="0" wire:model.defer="selected_rooms.{{ $room->id }}" placeholder="0" class="w-full bg-white border border-gray-300 rounded-lg px-3 py-1.5 text-sm font-semibold text-gray-900 focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600">
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 col-span-2 italic bg-gray-50 p-4 rounded-xl border border-dashed border-gray-200">No hay tipos de habitación disponibles actualmente.</p>
                        @endforelse
                    </div>
                </div>

                <!-- 3.3: Actividades Guiadas -->
                <div class="space-y-4">
                    <h3 class="text-md font-bold text-blue-900 border-b border-gray-100 pb-2 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Actividades Guiadas / Talleres
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($activities as $activity)
                            <div class="bg-gray-50/70 hover:bg-white p-4 rounded-xl border border-gray-200 flex items-center justify-between gap-4 transition-all hover:shadow-sm">
                                <div class="flex-1">
                                    <h4 class="font-bold text-gray-900 text-sm">{{ $activity->name }}</h4>
                                    @if($activity->description)
                                        <p class="text-xs text-gray-500 mt-0.5 line-clamp-2 leading-relaxed">{{ $activity->description }}</p>
                                    @endif
                                    <div class="flex items-center gap-3 mt-1.5 text-xs">
                                        <span class="font-semibold text-blue-700">${{ number_format($activity->price_per_person, 2) }} / persona</span>
                                        @if($activity->duration_minutes)
                                            <span class="text-gray-400">•</span>
                                            <span class="text-gray-500 font-medium">{{ $activity->duration_minutes }} min</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="w-24">
                                    <label class="block text-[10px] font-bold uppercase tracking-wider text-gray-400 mb-1">Participantes</label>
                                    <input type="number" min="0" wire:model.defer="selected_activities.{{ $activity->id }}" placeholder="0" class="w-full bg-white border border-gray-300 rounded-lg px-3 py-1.5 text-sm font-semibold text-gray-900 focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600">
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 col-span-2 italic bg-gray-50 p-4 rounded-xl border border-dashed border-gray-200">No hay actividades disponibles actualmente.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Sección 4: Carga de Documentos -->
            <div class="bg-white border border-gray-200/80 rounded-2xl p-6 sm:p-8 space-y-6 shadow-sm">
                <div class="flex items-center gap-3 border-b border-gray-100 pb-4">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 font-bold flex items-center justify-center text-sm border border-blue-100">4</div>
                    <h2 class="text-xl font-bold text-gray-900">Documentación Adjunta (Opcional)</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Archivo de Seguro -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Póliza o Constancia de Seguro</label>
                        <div class="relative border-2 border-dashed border-gray-300 hover:border-blue-500 rounded-xl p-4 transition-all bg-gray-50/50 hover:bg-blue-50/20 group cursor-pointer">
                            <input type="file" wire:model="insurance_file" accept=".pdf,.jpg,.jpeg,.png" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="flex items-center gap-3">
                                <div class="p-2.5 bg-blue-50 text-blue-600 rounded-lg group-hover:bg-blue-100 transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <div class="truncate">
                                    @if($insurance_file)
                                        <p class="text-sm font-semibold text-blue-600 truncate">{{ $insurance_file->getClientOriginalName() }}</p>
                                        <p class="text-xs text-gray-500 font-medium">Archivo seleccionado</p>
                                    @else
                                        <p class="text-sm font-medium text-gray-800">Seleccionar Póliza de Seguro</p>
                                        <p class="text-xs text-gray-500">PDF, PNG o JPG (máx. 10MB)</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @error('insurance_file') <span class="text-xs font-medium text-rose-600 block mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Archivo de Contrato -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Contrato Firmado / Acuerdos</label>
                        <div class="relative border-2 border-dashed border-gray-300 hover:border-blue-500 rounded-xl p-4 transition-all bg-gray-50/50 hover:bg-blue-50/20 group cursor-pointer">
                            <input type="file" wire:model="contract_file" accept=".pdf,.doc,.docx" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="flex items-center gap-3">
                                <div class="p-2.5 bg-blue-50 text-blue-600 rounded-lg group-hover:bg-blue-100 transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <div class="truncate">
                                    @if($contract_file)
                                        <p class="text-sm font-semibold text-blue-600 truncate">{{ $contract_file->getClientOriginalName() }}</p>
                                        <p class="text-xs text-gray-500 font-medium">Archivo seleccionado</p>
                                    @else
                                        <p class="text-sm font-medium text-gray-800">Seleccionar Contrato</p>
                                        <p class="text-xs text-gray-500">PDF, DOC o DOCX (máx. 10MB)</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @error('contract_file') <span class="text-xs font-medium text-rose-600 block mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Sticky Submit Bar con Blur SaaS -->
            <div class="fixed bottom-0 left-0 right-0 z-40 bg-white/80 border-t border-gray-200 backdrop-blur-md py-3.5 px-4 shadow-lg">
                <div class="max-w-4xl mx-auto flex items-center justify-end">
                    <button type="submit" class="w-full sm:w-auto px-8 py-3 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white font-semibold text-sm shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5 active:translate-y-0">
                        Enviar Solicitud
                    </button>
                </div>
            </div>
        </form>
    @endif
</div>