<div class="max-w-5xl mx-auto px-4 py-8">
    @if ($submitted)
        <!-- Pantalla de Éxito / Confirmación -->
        <div class="bg-white shadow-xl rounded-2xl p-8 border border-green-100 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 text-green-600 rounded-full mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-gray-900 mb-2">¡Inscripción Completada con Éxito!</h2>
            <p class="text-gray-800 mb-6">Se han registrado los siguientes acampantes para el evento <strong>{{ $activeEvent->name ?? '' }}</strong>:</p>

            <div class="max-w-md mx-auto space-y-3 mb-8">
                @foreach ($registered_tokens as $reg)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-200">
                        <span class="font-semibold text-gray-900">{{ $reg['name'] }}</span>
                        <span class="font-mono text-sm bg-blue-100 text-blue-900 px-3 py-1 rounded-md font-bold">Token: {{ $reg['token'] }}</span>
                    </div>
                @endforeach
            </div>

            <button type="button" onclick="window.location.reload()" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-lg transition">
                Registrar otra familia
            </button>
        </div>
    @elseif (!$activeEvent)
        <!-- Sin Evento Activo -->
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-r-xl">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-bold text-yellow-900">Inscripciones No Disponibles</h3>
                    <p class="text-sm text-yellow-900 mt-1">Actualmente no hay ningún evento de campamento activo configurado en el sistema.</p>
                </div>
            </div>
        </div>
    @else
        <!-- Formulario Principal -->
        <form wire:submit.prevent="submit" class="space-y-8">
            <!-- Header Evento -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white rounded-2xl p-6 shadow-lg flex flex-col md:flex-row justify-between items-start md:items-center">
                <div>
                    <span class="text-xs uppercase tracking-widest bg-blue-500/30 px-3 py-1 rounded-full border border-blue-400/30 font-semibold">Evento Activo</span>
                    <h1 class="text-2xl md:text-3xl font-extrabold mt-2">{{ $activeEvent->name }}</h1>
                </div>
                <div class="mt-4 md:mt-0 bg-white/10 backdrop-blur-md px-4 py-2 rounded-xl border border-white/20">
                    <span class="text-sm block text-blue-100">Año lectivo</span>
                    <span class="text-xl font-bold">{{ $activeEvent->year }}</span>
                </div>
            </div>

            @if (session()->has('error'))
                <div class="p-4 bg-red-100 border border-red-400 text-red-900 font-medium rounded-xl">
                    {{ session('error') }}
                </div>
            @endif

            <!-- SECCIÓN TUTORES -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">1. Datos del Tutor / Apoderado</h2>
                        <p class="text-sm text-gray-800 font-medium">Agrega al menos un tutor legal o contacto principal</p>
                    </div>
                    <button type="button" wire:click="addGuardian" class="inline-flex items-center text-sm font-semibold text-blue-700 hover:text-blue-900">
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Agregar Tutor
                    </button>
                </div>

                <div class="p-6 space-y-6">
                    @foreach ($guardians as $index => $guardian)
                        <div class="p-5 rounded-xl border border-gray-200 bg-white relative {{ $loop->first ? '' : 'mt-4' }}">
                            <div class="flex justify-between items-center mb-4 pb-2 border-b border-gray-100">
                                <span class="text-sm font-bold text-gray-900 uppercase tracking-wider">Tutor #{{ $index + 1 }}</span>
                                @if (count($guardians) > 1)
                                    <button type="button" wire:click="removeGuardian({{ $index }})" class="text-red-600 hover:text-red-800 text-sm font-semibold">
                                        Eliminar
                                    </button>
                                @endif
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-900">Nombre *</label>
                                    <input type="text" wire:model.defer="guardians.{{ $index }}.first_name" class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error("guardians.{$index}.first_name") <span class="text-xs text-red-600 font-semibold">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-900">Apellido *</label>
                                    <input type="text" wire:model.defer="guardians.{{ $index }}.last_name" class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error("guardians.{$index}.last_name") <span class="text-xs text-red-600 font-semibold">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-900">Teléfono *</label>
                                    <input type="text" wire:model.defer="guardians.{{ $index }}.phone" class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error("guardians.{$index}.phone") <span class="text-xs text-red-600 font-semibold">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-900">Correo Electrónico</label>
                                    <input type="email" wire:model.defer="guardians.{{ $index }}.email" class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error("guardians.{$index}.email") <span class="text-xs text-red-600 font-semibold">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-900">Parentesco *</label>
                                    <select wire:model.defer="guardians.{{ $index }}.relationship_type" class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="father">Padre</option>
                                        <option value="mother">Madre</option>
                                        <option value="stepfather">Padrastro</option>
                                        <option value="stepmother">Madrastra</option>
                                        <option value="legal_guardian">Tutor Legal</option>
                                        <option value="emergency_contact">Contacto Emergencia</option>
                                        <option value="other">Otro</option>
                                    </select>
                                    @error("guardians.{$index}.relationship_type") <span class="text-xs text-red-600 font-semibold">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-900">Dirección</label>
                                    <input type="text" wire:model.defer="guardians.{{ $index }}.address" class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>

                            <div class="mt-4 flex flex-wrap gap-6 pt-3 border-t border-gray-100">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" wire:model.defer="guardians.{{ $index }}.is_primary_guardian" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-900 font-medium">Tutor Principal</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" wire:model.defer="guardians.{{ $index }}.is_emergency_contact" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-900 font-medium">Contacto de Emergencia</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" wire:model.defer="guardians.{{ $index }}.has_custody" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-900 font-medium">Tiene Custodia Legal</span>
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- SECCIÓN ACAMPANTES -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">2. Datos de los Acampantes</h2>
                        <p class="text-sm text-gray-800 font-medium">Registra uno o varios acampantes en la misma inscripción</p>
                    </div>
                    <button type="button" wire:click="addCamper" class="inline-flex items-center text-sm font-semibold text-blue-700 hover:text-blue-900">
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Agregar Acampante
                    </button>
                </div>

                <div class="p-6 space-y-8">
                    @foreach ($campers as $index => $camper)
                        <div class="p-6 rounded-xl border border-gray-200 bg-gray-50/50 relative">
                            <div class="flex justify-between items-center mb-4 pb-2 border-b border-gray-200">
                                <span class="text-sm font-bold text-blue-900 uppercase tracking-wider">Acampante #{{ $index + 1 }}</span>
                                @if (count($campers) > 1)
                                    <button type="button" wire:click="removeCamper({{ $index }})" class="text-red-600 hover:text-red-800 text-sm font-semibold">
                                        Eliminar
                                    </button>
                                @endif
                            </div>

                            <!-- Información Personal -->
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-900">Nombre *</label>
                                    <input type="text" wire:model.defer="campers.{{ $index }}.first_name" class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error("campers.{$index}.first_name") <span class="text-xs text-red-600 font-semibold">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-900">Apellido *</label>
                                    <input type="text" wire:model.defer="campers.{{ $index }}.last_name" class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error("campers.{$index}.last_name") <span class="text-xs text-red-600 font-semibold">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-900">Género *</label>
                                    <select wire:model.defer="campers.{{ $index }}.gender" class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="male">Masculino</option>
                                        <option value="female">Femenino</option>
                                        <option value="other">Otro</option>
                                    </select>
                                    @error("campers.{$index}.gender") <span class="text-xs text-red-600 font-semibold">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-900">Fecha Nacimiento *</label>
                                    <input type="date" wire:model.defer="campers.{{ $index }}.date_of_birth" class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error("campers.{$index}.date_of_birth") <span class="text-xs text-red-600 font-semibold">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-900">Nº Seguro / Ficha Médica</label>
                                    <input type="text" wire:model.defer="campers.{{ $index }}.health_card_number" class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>

                                <div class="md:col-span-3">
                                    <label class="block text-sm font-semibold text-gray-900">Dirección Residencial</label>
                                    <input type="text" wire:model.defer="campers.{{ $index }}.address" class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>

                            <!-- Información Médica -->
                            <div class="bg-white p-4 rounded-xl border border-gray-200 mb-6 space-y-4">
                                <h3 class="text-md font-bold text-gray-900 border-b border-gray-100 pb-2">Ficha Médica y Cuidados</h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-900">Alergias</label>
                                        <textarea rows="2" wire:model.defer="campers.{{ $index }}.allergies" placeholder="Medicamentos, alimentos, picaduras..." class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 placeholder-gray-400"></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-900">Medicamentos de Uso Diario</label>
                                        <textarea rows="2" wire:model.defer="campers.{{ $index }}.medications" placeholder="Nombre, dosis y horario..." class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 placeholder-gray-400"></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-900">Restricciones Alimentarias</label>
                                        <textarea rows="2" wire:model.defer="campers.{{ $index }}.dietary_restrictions" placeholder="Vegetariano, celiaco, intolerancias..." class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 placeholder-gray-400"></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-900">Alertas Críticas / Condiciones Médicas</label>
                                        <textarea rows="2" wire:model.defer="campers.{{ $index }}.critical_alerts" placeholder="Asma, diabetes, epilepsia, etc..." class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 placeholder-gray-400"></textarea>
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-900">Detalles de Custodia Legal (si aplica)</label>
                                        <input type="text" wire:model.defer="campers.{{ $index }}.custody_details" class="mt-1 w-full rounded-lg border-gray-300 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                </div>
                            </div>

                            <!-- Permisos / Autorizaciones -->
                            <div class="bg-blue-50/50 p-4 rounded-xl border border-blue-100 space-y-3">
                                <h3 class="text-md font-bold text-blue-950 mb-2">Autorizaciones y Consentimiento</h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <label class="flex items-center space-x-3">
                                        <input type="checkbox" wire:model.defer="campers.{{ $index }}.photo_permission" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span class="text-sm text-gray-900 font-medium">Autorizo uso de imágenes / fotografías</span>
                                    </label>

                                    <label class="flex items-center space-x-3">
                                        <input type="checkbox" wire:model.defer="campers.{{ $index }}.travel_permission" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span class="text-sm text-gray-900 font-medium">Autorizo traslado/traslado de excursión</span>
                                    </label>

                                    <label class="flex items-center space-x-3">
                                        <input type="checkbox" wire:model.defer="campers.{{ $index }}.contact_permission" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span class="text-sm text-gray-900 font-medium">Autorizo contacto directo de la organización</span>
                                    </label>

                                    <label class="flex items-center space-x-3">
                                        <input type="checkbox" wire:model.defer="campers.{{ $index }}.medical_permission" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span class="text-sm text-gray-900 font-bold">Autorizo atención médica de emergencia *</span>
                                    </label>
                                </div>
                                @error("campers.{$index}.medical_permission")
                                    <span class="text-xs text-red-600 block mt-1 font-semibold">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Botón Guardar -->
            <div class="flex justify-end pt-4">
                <button type="submit" wire:loading.attr="disabled" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transition duration-150 inline-flex items-center">
                    <span wire:loading.remove>Completar Inscripción</span>
                    <span wire:loading class="inline-flex items-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Procesando...
                    </span>
                </button>
            </div>
        </form>
    @endif
</div>