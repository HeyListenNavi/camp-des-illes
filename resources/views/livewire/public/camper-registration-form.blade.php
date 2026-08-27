@use('App\Enums\GuardianRelationship')
@use('App\Enums\Gender')

<div class="w-full space-y-6">
    @if ($submitted)
        <!-- Success Confirmation -->
        <div class="bg-white shadow-md rounded-2xl p-6 sm:p-10 border border-emerald-100 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-emerald-100 text-[#135860] rounded-full mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h2 class="text-2xl sm:text-3xl font-heading font-bold text-slate-900 mb-2">
                {{ $isEditing ? 'Registration Updated Successfully!' : 'Registration Submitted Successfully!' }}
            </h2>
            <p class="text-slate-600 mb-6">
                Registered campers for session <strong>{{ $activeEvent->name ?? '' }}</strong>:
            </p>

            <div class="max-w-md mx-auto space-y-3 mb-8">
                @foreach ($registered_tokens as $reg)
                    <div class="flex flex-col sm:flex-row items-center justify-between p-4 bg-slate-50 rounded-2xl border border-slate-200 gap-2">
                        <span class="font-semibold text-slate-900">{{ $reg['name'] }}</span>
                        <span class="font-mono text-xs bg-[#135860]/10 text-[#135860] px-3.5 py-1.5 rounded-xl font-bold">Access Token: {{ $reg['token'] }}</span>
                    </div>
                @endforeach
            </div>

            <button type="button" onclick="window.location.reload()" class="bg-[#135860] hover:bg-[#0d434a] text-white font-heading font-bold px-8 py-3.5 rounded-2xl transition-all shadow-md active:scale-[0.98]">
                Register Another Family
            </button>
        </div>
    @elseif (!$activeEvent)
        <!-- Inactive Event Banner -->
        <div class="bg-amber-50 border-l-4 border-amber-500 p-6 rounded-r-2xl">
            <div class="flex items-start">
                <svg class="h-6 w-6 text-amber-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <div class="ml-3">
                    <h3 class="text-lg font-heading font-bold text-amber-900">Registration Not Available</h3>
                    <p class="text-sm text-amber-800 mt-1">There is currently no active camp session configured in the system.</p>
                </div>
            </div>
        </div>
    @else
        <!-- Main Form -->
        <form wire:submit.prevent="submit" class="space-y-6">
            <!-- Event Header Banner -->
            <div class="bg-[#135860] text-white rounded-2xl p-5 sm:p-6 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <span class="text-[11px] uppercase tracking-wider bg-white/15 px-3 py-1 rounded-full border border-white/20 font-semibold">
                        {{ $isEditing ? 'Updating Registration' : 'Active Camp Session' }}
                    </span>
                    <h1 class="text-2xl sm:text-3xl font-heading font-bold mt-2 text-white">{{ $activeEvent->name }}</h1>
                </div>
                <div class="bg-white/10 backdrop-blur-md px-4 py-2 rounded-2xl border border-white/20 shrink-0">
                    <span class="text-xs block text-slate-200">Camp Year</span>
                    <span class="text-xl font-bold font-heading">{{ $activeEvent->year }}</span>
                </div>
            </div>

            @if (session()->has('warning'))
                <div class="p-4 bg-amber-50 border border-amber-200 text-amber-900 text-sm font-medium rounded-2xl">
                    {{ session('warning') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="p-4 bg-rose-50 border border-rose-200 text-rose-900 text-sm font-medium rounded-2xl">
                    {{ session('error') }}
                </div>
            @endif

            <!-- GUARDIANS SECTION -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
                <div class="p-5 sm:p-6 bg-slate-50/80 border-b border-slate-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                    <div>
                        <h2 class="text-xl font-heading font-bold text-[#135860]">1. Parent / Guardian Information</h2>
                        <p class="text-xs sm:text-sm text-slate-500">Provide contact details for legal guardians or emergency contacts.</p>
                    </div>
                    <button type="button" wire:click="addGuardian" class="inline-flex items-center text-sm font-semibold text-[#135860] hover:text-[#0d434a] transition-colors">
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        Add Guardian
                    </button>
                </div>

                <div class="p-5 sm:p-6 space-y-6">
                    @foreach ($guardians as $index => $guardian)
                        <div class="p-4 sm:p-5 rounded-2xl border border-slate-200 bg-white relative">
                            <div class="flex justify-between items-center mb-4 pb-2 border-b border-slate-100">
                                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Guardian #{{ $index + 1 }}</span>
                                @if (count($guardians) > 1)
                                    <button type="button" wire:click="removeGuardian({{ $index }})" class="text-rose-600 hover:text-rose-800 text-xs font-semibold">
                                        Remove
                                    </button>
                                @endif
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">First Name *</label>
                                    <input type="text" wire:model.defer="guardians.{{ $index }}.first_name" placeholder="First Name" class="w-full rounded-2xl border-slate-300 text-slate-900 text-sm px-4 py-3 shadow-2xs focus:border-[#135860] focus:ring-2 focus:ring-[#135860]/20">
                                    @error("guardians.{$index}.first_name") <span class="text-xs text-rose-600 mt-1 block font-medium">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">Last Name *</label>
                                    <input type="text" wire:model.defer="guardians.{{ $index }}.last_name" placeholder="Last Name" class="w-full rounded-2xl border-slate-300 text-slate-900 text-sm px-4 py-3 shadow-2xs focus:border-[#135860] focus:ring-2 focus:ring-[#135860]/20">
                                    @error("guardians.{$index}.last_name") <span class="text-xs text-rose-600 mt-1 block font-medium">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">Phone Number *</label>
                                    <input type="tel" wire:model.defer="guardians.{{ $index }}.phone" placeholder="Phone Number" class="w-full rounded-2xl border-slate-300 text-slate-900 text-sm px-4 py-3 shadow-2xs focus:border-[#135860] focus:ring-2 focus:ring-[#135860]/20">
                                    @error("guardians.{$index}.phone") <span class="text-xs text-rose-600 mt-1 block font-medium">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">Email Address</label>
                                    <input type="email" wire:model.defer="guardians.{{ $index }}.email" placeholder="Email" class="w-full rounded-2xl border-slate-300 text-slate-900 text-sm px-4 py-3 shadow-2xs focus:border-[#135860] focus:ring-2 focus:ring-[#135860]/20">
                                    @error("guardians.{$index}.email") <span class="text-xs text-rose-600 mt-1 block font-medium">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">Relationship *</label>
                                    <select wire:model.defer="guardians.{{ $index }}.relationship_type" class="w-full rounded-2xl border-slate-300 text-slate-900 text-sm px-4 py-3 shadow-2xs focus:border-[#135860] focus:ring-2 focus:ring-[#135860]/20">
                                        @foreach (GuardianRelationship::cases() as $rel)
                                            <option value="{{ $rel->value }}">{{ $rel->getLabel() }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">Home Address</label>
                                    <input type="text" wire:model.defer="guardians.{{ $index }}.address" placeholder="Address" class="w-full rounded-2xl border-slate-300 text-slate-900 text-sm px-4 py-3 shadow-2xs focus:border-[#135860] focus:ring-2 focus:ring-[#135860]/20">
                                </div>
                            </div>

                            <div class="mt-4 flex flex-wrap gap-4 sm:gap-6 pt-3 border-t border-slate-100 text-xs">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" wire:model.defer="guardians.{{ $index }}.is_primary_guardian" class="rounded border-slate-300 text-[#135860] focus:ring-[#135860]">
                                    <span class="ml-2 text-slate-700 font-medium">Primary Guardian</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" wire:model.defer="guardians.{{ $index }}.is_emergency_contact" class="rounded border-slate-300 text-[#135860] focus:ring-[#135860]">
                                    <span class="ml-2 text-slate-700 font-medium">Emergency Contact</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" wire:model.defer="guardians.{{ $index }}.has_custody" class="rounded border-slate-300 text-[#135860] focus:ring-[#135860]">
                                    <span class="ml-2 text-slate-700 font-medium">Legal Custody</span>
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- CAMPERS SECTION -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
                <div class="p-5 sm:p-6 bg-slate-50/80 border-b border-slate-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                    <div>
                        <h2 class="text-xl font-heading font-bold text-[#135860]">2. Camper Information</h2>
                        <p class="text-xs sm:text-sm text-slate-500">Register one or more campers under this family record.</p>
                    </div>
                    <button type="button" wire:click="addCamper" class="inline-flex items-center text-sm font-semibold text-[#135860] hover:text-[#0d434a] transition-colors">
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        Add Camper
                    </button>
                </div>

                <div class="p-5 sm:p-6 space-y-6">
                    @foreach ($campers as $index => $camper)
                        <div class="p-4 sm:p-5 rounded-2xl border border-slate-200 bg-slate-50/50 relative">
                            <div class="flex justify-between items-center mb-4 pb-2 border-b border-slate-200">
                                <span class="text-xs font-bold text-[#135860] uppercase tracking-wider">Camper #{{ $index + 1 }}</span>
                                @if (count($campers) > 1)
                                    <button type="button" wire:click="removeCamper({{ $index }})" class="text-rose-600 hover:text-rose-800 text-xs font-semibold">
                                        Remove
                                    </button>
                                @endif
                            </div>

                            <!-- Personal Info Grid -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-5">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">First Name *</label>
                                    <input type="text" wire:model.defer="campers.{{ $index }}.first_name" placeholder="First Name" class="w-full rounded-2xl border-slate-300 text-slate-900 text-sm px-4 py-3 shadow-2xs focus:border-[#135860] focus:ring-2 focus:ring-[#135860]/20">
                                    @error("campers.{$index}.first_name") <span class="text-xs text-rose-600 mt-1 block font-medium">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">Last Name *</label>
                                    <input type="text" wire:model.defer="campers.{{ $index }}.last_name" placeholder="Last Name" class="w-full rounded-2xl border-slate-300 text-slate-900 text-sm px-4 py-3 shadow-2xs focus:border-[#135860] focus:ring-2 focus:ring-[#135860]/20">
                                    @error("campers.{$index}.last_name") <span class="text-xs text-rose-600 mt-1 block font-medium">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">Gender *</label>
                                    <select wire:model.defer="campers.{{ $index }}.gender" class="w-full rounded-2xl border-slate-300 text-slate-900 text-sm px-4 py-3 shadow-2xs focus:border-[#135860] focus:ring-2 focus:ring-[#135860]/20">
                                        @foreach (Gender::cases() as $gender)
                                            <option value="{{ $gender->value }}">{{ $gender->getLabel() }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">Date of Birth *</label>
                                    <input type="date" wire:model.defer="campers.{{ $index }}.date_of_birth" class="w-full rounded-2xl border-slate-300 text-slate-900 text-sm px-4 py-3 shadow-2xs focus:border-[#135860] focus:ring-2 focus:ring-[#135860]/20">
                                    @error("campers.{$index}.date_of_birth") <span class="text-xs text-rose-600 mt-1 block font-medium">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">Health Card / Insurance No.</label>
                                    <input type="text" wire:model.defer="campers.{{ $index }}.health_card_number" placeholder="Insurance No." class="w-full rounded-2xl border-slate-300 text-slate-900 text-sm px-4 py-3 shadow-2xs focus:border-[#135860] focus:ring-2 focus:ring-[#135860]/20">
                                </div>

                                <div class="sm:col-span-3">
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">Residencial Address</label>
                                    <input type="text" wire:model.defer="campers.{{ $index }}.address" placeholder="Residential Address" class="w-full rounded-2xl border-slate-300 text-slate-900 text-sm px-4 py-3 shadow-2xs focus:border-[#135860] focus:ring-2 focus:ring-[#135860]/20">
                                </div>
                            </div>

                            <!-- Medical Record Subcard -->
                            <div class="bg-white p-4 rounded-2xl border border-slate-200 mb-5 space-y-4">
                                <h3 class="text-sm font-heading font-bold text-slate-900 border-b border-slate-100 pb-2">Medical Profile & Health Considerations</h3>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                                    <div>
                                        <label class="block font-semibold text-slate-700 mb-1">Known Allergies</label>
                                        <textarea rows="2" wire:model.defer="campers.{{ $index }}.allergies" placeholder="Peanuts, bee stings, penicillin..." class="w-full rounded-2xl border-slate-300 text-slate-900 text-xs px-4 py-3 shadow-2xs focus:border-[#135860] focus:ring-2 focus:ring-[#135860]/20"></textarea>
                                    </div>
                                    <div>
                                        <label class="block font-semibold text-slate-700 mb-1">Current Medications</label>
                                        <textarea rows="2" wire:model.defer="campers.{{ $index }}.medications" placeholder="Medication name, dosage, schedule..." class="w-full rounded-2xl border-slate-300 text-slate-900 text-xs px-4 py-3 shadow-2xs focus:border-[#135860] focus:ring-2 focus:ring-[#135860]/20"></textarea>
                                    </div>
                                    <div>
                                        <label class="block font-semibold text-slate-700 mb-1">Dietary Restrictions</label>
                                        <textarea rows="2" wire:model.defer="campers.{{ $index }}.dietary_restrictions" placeholder="Vegetarian, gluten-free, dairy-free..." class="w-full rounded-2xl border-slate-300 text-slate-900 text-xs px-4 py-3 shadow-2xs focus:border-[#135860] focus:ring-2 focus:ring-[#135860]/20"></textarea>
                                    </div>
                                    <div>
                                        <label class="block font-semibold text-slate-700 mb-1">Critical Medical Alerts</label>
                                        <textarea rows="2" wire:model.defer="campers.{{ $index }}.critical_alerts" placeholder="Asthma, diabetes, epilepsy..." class="w-full rounded-2xl border-slate-300 text-slate-900 text-xs px-4 py-3 shadow-2xs focus:border-[#135860] focus:ring-2 focus:ring-[#135860]/20"></textarea>
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label class="block font-semibold text-slate-700 mb-1">Custody Restrictions & Legal Notes</label>
                                        <input type="text" wire:model.defer="campers.{{ $index }}.custody_details" placeholder="Custody notes" class="w-full rounded-2xl border-slate-300 text-slate-900 text-xs px-4 py-3 shadow-2xs focus:border-[#135860] focus:ring-2 focus:ring-[#135860]/20">
                                    </div>
                                </div>
                            </div>

                            <!-- Permissions & Consents Subcard -->
                            <div class="bg-[#135860]/5 p-4 rounded-2xl border border-[#135860]/15 space-y-3">
                                <h3 class="text-sm font-heading font-bold text-[#135860]">Permissions & Authorizations</h3>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                                    <label class="flex items-center space-x-2.5">
                                        <input type="checkbox" wire:model.defer="campers.{{ $index }}.photo_permission" class="rounded border-slate-300 text-[#135860] focus:ring-[#135860]">
                                        <span class="text-slate-700 font-medium">Photo & media permission</span>
                                    </label>

                                    <label class="flex items-center space-x-2.5">
                                        <input type="checkbox" wire:model.defer="campers.{{ $index }}.travel_permission" class="rounded border-slate-300 text-[#135860] focus:ring-[#135860]">
                                        <span class="text-slate-700 font-medium">Trip & activity transport permission</span>
                                    </label>

                                    <label class="flex items-center space-x-2.5">
                                        <input type="checkbox" wire:model.defer="campers.{{ $index }}.contact_permission" class="rounded border-slate-300 text-[#135860] focus:ring-[#135860]">
                                        <span class="text-slate-700 font-medium">Direct camp updates permission</span>
                                    </label>

                                    <label class="flex items-center space-x-2.5">
                                        <input type="checkbox" wire:model.defer="campers.{{ $index }}.medical_permission" class="rounded border-slate-300 text-[#135860] focus:ring-[#135860]">
                                        <span class="text-slate-900 font-bold">Emergency medical authorization *</span>
                                    </label>
                                </div>
                                @error("campers.{$index}.medical_permission")
                                    <span class="text-xs text-rose-600 block mt-1 font-semibold">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end pt-2">
                <button type="submit" wire:loading.attr="disabled" class="w-full sm:w-auto bg-[#135860] hover:bg-[#0d434a] text-white font-heading font-bold py-3.5 px-10 rounded-2xl shadow-md transition-all active:scale-[0.98] inline-flex items-center justify-center">
                    <span wire:loading.remove>{{ $isEditing ? 'Update Registration' : 'Submit Registration' }}</span>
                    <span wire:loading class="inline-flex items-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Processing...
                    </span>
                </button>
            </div>
        </form>
    @endif
</div>