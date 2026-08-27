<div class="w-full space-y-6">
    <!-- Header Banner -->
    <div class="bg-[#135860] text-white rounded-2xl p-5 sm:p-6 shadow-sm">
        <div class="flex items-center justify-between gap-3 mb-2">
            <span class="px-3 py-1 text-[11px] font-bold tracking-wider uppercase rounded-full bg-white/15 text-white border border-white/20">Secure Token Access</span>
            @if($registration?->token)
                <span class="text-xs text-slate-200 font-mono hidden sm:inline-block">{{ $registration->token }}</span>
            @endif
        </div>
        <h1 class="text-2xl sm:text-3xl font-heading font-bold text-white">Medical Record & Consents Update</h1>
        @if ($registration && $registration->camper)
            <p class="text-slate-200 mt-1 text-xs sm:text-sm">
                Camper: <span class="text-white font-bold">{{ $registration->camper->first_name }} {{ $registration->camper->last_name }}</span> 
                (Session Year {{ $registration->campEvent->year ?? '' }})
            </p>
        @endif
    </div>

    @if(session()->has('warning'))
        <div class="p-4 bg-amber-50 border border-amber-200 text-amber-900 text-sm font-medium rounded-2xl">
            {{ session('warning') }}
        </div>
    @endif

    @if($saved)
        <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-4 text-[#135860] text-sm flex items-center gap-3">
            <svg class="w-5 h-5 text-[#135860] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            <span class="font-semibold">Medical record and consents updated successfully.</span>
        </div>
    @endif

    @if ($registration)
        <form wire:submit.prevent="save" class="space-y-6">
            <!-- Medical Record Card -->
            <div class="bg-white border border-slate-200/80 rounded-2xl p-5 sm:p-8 space-y-6 shadow-sm">
                <h2 class="text-xl font-heading font-bold text-[#135860] border-b border-slate-100 pb-3">Clinical Profile & Health Needs</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Known Allergies</label>
                        <textarea wire:model.defer="allergies" rows="3" placeholder="Peanuts, bee stings, penicillin..." class="w-full rounded-2xl border-slate-300 text-slate-900 text-sm px-4 py-3 shadow-2xs focus:border-[#135860] focus:ring-2 focus:ring-[#135860]/20"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Current Medications</label>
                        <textarea wire:model.defer="medications" rows="3" placeholder="Medication name, dosage, schedule..." class="w-full rounded-2xl border-slate-300 text-slate-900 text-sm px-4 py-3 shadow-2xs focus:border-[#135860] focus:ring-2 focus:ring-[#135860]/20"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Dietary Restrictions</label>
                        <textarea wire:model.defer="dietary_restrictions" rows="3" placeholder="Vegetarian, gluten-free, dairy-free..." class="w-full rounded-2xl border-slate-300 text-slate-900 text-sm px-4 py-3 shadow-2xs focus:border-[#135860] focus:ring-2 focus:ring-[#135860]/20"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Critical Medical Flags</label>
                        <textarea wire:model.defer="critical_alerts" rows="3" placeholder="Asthma, diabetes, severe allergies..." class="w-full rounded-2xl border-slate-300 text-slate-900 text-sm px-4 py-3 shadow-2xs focus:border-[#135860] focus:ring-2 focus:ring-[#135860]/20"></textarea>
                    </div>
                </div>
            </div>

            <!-- Consents Card -->
            <div class="bg-white border border-slate-200/80 rounded-2xl p-5 sm:p-8 space-y-6 shadow-sm">
                <h2 class="text-xl font-heading font-bold text-[#135860] border-b border-slate-100 pb-3">Permissions & Digital Signature</h2>

                <div class="space-y-3">
                    <label class="flex items-start gap-3 p-3.5 rounded-2xl bg-slate-50 border border-slate-200 cursor-pointer">
                        <input type="checkbox" wire:model.defer="photo_permission" class="mt-0.5 w-4 h-4 rounded border-slate-300 text-[#135860] focus:ring-[#135860]">
                        <span class="text-slate-800 text-xs sm:text-sm font-medium">Photo & media permission for promotional use</span>
                    </label>

                    <label class="flex items-start gap-3 p-3.5 rounded-2xl bg-slate-50 border border-slate-200 cursor-pointer">
                        <input type="checkbox" wire:model.defer="travel_permission" class="mt-0.5 w-4 h-4 rounded border-slate-300 text-[#135860] focus:ring-[#135860]">
                        <span class="text-slate-800 text-xs sm:text-sm font-medium">Trip & field excursion transport permission</span>
                    </label>

                    <label class="flex items-start gap-3 p-3.5 rounded-2xl bg-slate-50 border border-slate-200 cursor-pointer">
                        <input type="checkbox" wire:model.defer="contact_permission" class="mt-0.5 w-4 h-4 rounded border-slate-300 text-[#135860] focus:ring-[#135860]">
                        <span class="text-slate-800 text-xs sm:text-sm font-medium">Direct communication & camp updates permission</span>
                    </label>

                    <label class="flex items-start gap-3 p-4 rounded-2xl bg-[#135860]/10 border border-[#135860]/20 cursor-pointer">
                        <input type="checkbox" wire:model.defer="medical_permission" class="mt-0.5 w-4 h-4 rounded border-slate-300 text-[#135860] focus:ring-[#135860]">
                        <div>
                            <span class="font-bold text-[#135860] text-xs sm:text-sm">Emergency Medical Attention Authorization *</span>
                            @error('medical_permission') <span class="text-xs text-rose-600 font-semibold mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </label>
                </div>
            </div>

            <!-- Submit Button Bar -->
            <div class="flex justify-end pt-2">
                <button type="submit" wire:loading.attr="disabled" class="w-full sm:w-auto bg-[#135860] hover:bg-[#0d434a] text-white font-heading font-bold py-3.5 px-10 rounded-2xl shadow-md transition-all active:scale-[0.98] inline-flex items-center justify-center">
                    <span wire:loading.remove>Save Medical & Consent Changes</span>
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
