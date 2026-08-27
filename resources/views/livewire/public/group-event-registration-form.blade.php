<div class="w-full space-y-6">
    @if ($submitted)
        <!-- Confirmation Screen -->
        <div class="bg-white border border-emerald-100 rounded-2xl p-6 sm:p-10 shadow-md text-center space-y-6">
            <div class="w-16 h-16 bg-emerald-50 text-[#135860] rounded-full flex items-center justify-center mx-auto border border-emerald-100">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            </div>
            
            <div class="space-y-2">
                <h2 class="text-2xl sm:text-3xl font-heading font-bold text-slate-900">
                    {{ $isEditing ? 'Group Inquiry Updated!' : 'Group Event Inquiry Received!' }}
                </h2>
                <p class="text-slate-600 max-w-lg mx-auto leading-relaxed text-sm sm:text-base">
                    We have registered the inquiry for group <span class="text-[#135860] font-semibold bg-[#135860]/10 px-2 py-0.5 rounded-lg">{{ $group_name }}</span>. Our team will review availability and contact you shortly.
                </p>
            </div>
            
            <div class="bg-slate-50 rounded-2xl p-4 sm:p-5 border border-slate-200 max-w-md mx-auto space-y-2 text-left shadow-2xs">
                <span class="text-xs uppercase tracking-wider text-slate-500 font-bold block">Group Access Token</span>
                <code class="text-[#135860] bg-[#135860]/10 border border-[#135860]/20 rounded-xl px-3.5 py-2 font-mono text-xs sm:text-sm break-all block font-bold">{{ $event_token }}</code>
            </div>

            <div class="pt-2">
                <button type="button" wire:click="$set('submitted', false)" class="px-8 py-3.5 rounded-2xl bg-[#135860] hover:bg-[#0d434a] text-white font-heading font-bold text-sm shadow-md transition-all active:scale-[0.98]">
                    Submit Another Inquiry
                </button>
            </div>
        </div>
    @else
        <form wire:submit.prevent="submit" class="space-y-6">
            <!-- Header Section Banner -->
            <div class="bg-[#135860] text-white rounded-2xl p-5 sm:p-6 shadow-sm relative overflow-hidden">
                <div class="flex items-center gap-3 mb-2">
                    <span class="px-3 py-1 text-[11px] font-bold tracking-wider uppercase rounded-full bg-white/15 text-white border border-white/20">
                        {{ $isEditing ? 'Updating Group Inquiry' : 'Group Retreat Inquiry' }}
                    </span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-heading font-bold text-white">Group Event & Facility Request</h1>
                <p class="text-slate-200 mt-1 max-w-2xl text-xs sm:text-sm leading-relaxed">Schedule your church, school, or youth retreat, reserving lodging, dining options, and outdoor activity packages.</p>
            </div>

            @if (session()->has('warning'))
                <div class="p-4 bg-amber-50 border border-amber-200 text-amber-900 text-sm font-medium rounded-2xl">
                    {{ session('warning') }}
                </div>
            @endif

            <!-- Section 1: Host Group Details -->
            <div class="bg-white border border-slate-200/80 rounded-2xl p-5 sm:p-8 space-y-6 shadow-sm">
                <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                    <div class="w-8 h-8 rounded-2xl bg-[#135860]/10 text-[#135860] font-heading font-bold flex items-center justify-center text-sm border border-[#135860]/20">1</div>
                    <h2 class="text-xl font-heading font-bold text-[#135860]">Host Group & Primary Contact</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Group / Event Name *</label>
                        <input type="text" wire:model.defer="group_name" class="w-full rounded-2xl border-slate-300 text-slate-900 text-sm px-4 py-3 shadow-2xs focus:border-[#135860] focus:ring-2 focus:ring-[#135860]/20" placeholder="e.g. Grace Fellowship Youth Retreat">
                        @error('group_name') <span class="text-xs font-medium text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Organization / Company</label>
                        <input type="text" wire:model.defer="organization_name" class="w-full rounded-2xl border-slate-300 text-slate-900 text-sm px-4 py-3 shadow-2xs focus:border-[#135860] focus:ring-2 focus:ring-[#135860]/20" placeholder="e.g. Grace Community Church">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Primary Contact Name *</label>
                        <input type="text" wire:model.defer="primary_contact_name" class="w-full rounded-2xl border-slate-300 text-slate-900 text-sm px-4 py-3 shadow-2xs focus:border-[#135860] focus:ring-2 focus:ring-[#135860]/20" placeholder="e.g. Sarah Connor">
                        @error('primary_contact_name') <span class="text-xs font-medium text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Phone Number *</label>
                        <input type="tel" wire:model.defer="phone" class="w-full rounded-2xl border-slate-300 text-slate-900 text-sm px-4 py-3 shadow-2xs focus:border-[#135860] focus:ring-2 focus:ring-[#135860]/20" placeholder="e.g. 555-012-3456">
                        @error('phone') <span class="text-xs font-medium text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Email Address *</label>
                        <input type="email" wire:model.defer="email" class="w-full rounded-2xl border-slate-300 text-slate-900 text-sm px-4 py-3 shadow-2xs focus:border-[#135860] focus:ring-2 focus:ring-[#135860]/20" placeholder="contact@group.org">
                        @error('email') <span class="text-xs font-medium text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Full Address</label>
                        <input type="text" wire:model.defer="address" class="w-full rounded-2xl border-slate-300 text-slate-900 text-sm px-4 py-3 shadow-2xs focus:border-[#135860] focus:ring-2 focus:ring-[#135860]/20" placeholder="City, Province, Postal Code">
                    </div>
                </div>
            </div>

            <!-- Section 2: Dates & Attendance -->
            <div class="bg-white border border-slate-200/80 rounded-2xl p-5 sm:p-8 space-y-6 shadow-sm">
                <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                    <div class="w-8 h-8 rounded-2xl bg-[#135860]/10 text-[#135860] font-heading font-bold flex items-center justify-center text-sm border border-[#135860]/20">2</div>
                    <h2 class="text-xl font-heading font-bold text-[#135860]">Schedule & Attendance</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Start Date *</label>
                        <input type="date" wire:model.defer="start_date" class="w-full rounded-2xl border-slate-300 text-slate-900 text-sm px-4 py-3 shadow-2xs focus:border-[#135860] focus:ring-2 focus:ring-[#135860]/20">
                        @error('start_date') <span class="text-xs font-medium text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">End Date *</label>
                        <input type="date" wire:model.defer="end_date" class="w-full rounded-2xl border-slate-300 text-slate-900 text-sm px-4 py-3 shadow-2xs focus:border-[#135860] focus:ring-2 focus:ring-[#135860]/20">
                        @error('end_date') <span class="text-xs font-medium text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Expected Attendees *</label>
                        <input type="number" wire:model.defer="expected_attendees" min="1" class="w-full rounded-2xl border-slate-300 text-slate-900 text-sm px-4 py-3 shadow-2xs focus:border-[#135860] focus:ring-2 focus:ring-[#135860]/20">
                        @error('expected_attendees') <span class="text-xs font-medium text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="sm:col-span-3">
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Operational Notes & Special Requests</label>
                        <textarea wire:model.defer="special_activities" rows="3" class="w-full rounded-2xl border-slate-300 text-slate-900 text-sm px-4 py-3 shadow-2xs focus:border-[#135860] focus:ring-2 focus:ring-[#135860]/20" placeholder="Campfires, audio/visual equipment, zip line, team workshops..."></textarea>
                    </div>
                </div>
            </div>

            <!-- Section 3: Service Selection -->
            <div class="bg-white border border-slate-200/80 rounded-2xl p-5 sm:p-8 space-y-6 shadow-sm">
                <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                    <div class="w-8 h-8 rounded-2xl bg-[#135860]/10 text-[#135860] font-heading font-bold flex items-center justify-center text-sm border border-[#135860]/20">3</div>
                    <h2 class="text-xl font-heading font-bold text-[#135860]">Service Packages & Specifications</h2>
                </div>

                <!-- Dining / Meals -->
                <div class="space-y-3">
                    <h3 class="text-sm font-heading font-bold text-[#135860] border-b border-slate-100 pb-1.5 flex items-center gap-2">
                        <svg class="w-4 h-4 text-[#135860]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        Dining & Meal Options
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @forelse($mealOptions as $meal)
                            <div class="bg-slate-50/80 hover:bg-white p-4 rounded-2xl border border-slate-200 flex items-center justify-between gap-3 transition-all">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-slate-900 text-xs sm:text-sm">{{ $meal->name }}</h4>
                                    @if($meal->description)
                                        <p class="text-xs text-slate-500 mt-0.5 line-clamp-2">{{ $meal->description }}</p>
                                    @endif
                                    <p class="text-xs font-semibold text-[#135860] mt-1">${{ number_format($meal->price_per_person, 2) }} / person</p>
                                </div>
                                <div class="w-24 shrink-0">
                                    <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-0.5">Quantity</label>
                                    <input type="number" min="0" wire:model.defer="selected_meals.{{ $meal->id }}" placeholder="0" class="w-full rounded-2xl border-slate-300 text-slate-900 text-xs font-semibold px-3 py-2 shadow-2xs focus:border-[#135860] focus:ring-2 focus:ring-[#135860]/20">
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-slate-500 col-span-2 italic bg-slate-50 p-3 rounded-2xl border border-dashed border-slate-200">No dining options configured.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Lodging -->
                <div class="space-y-3 pt-2">
                    <h3 class="text-sm font-heading font-bold text-[#135860] border-b border-slate-100 pb-1.5 flex items-center gap-2">
                        <svg class="w-4 h-4 text-[#135860]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Lodging & Room Types
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @forelse($roomTypes as $room)
                            <div class="bg-slate-50/80 hover:bg-white p-4 rounded-2xl border border-slate-200 flex items-center justify-between gap-3 transition-all">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-slate-900 text-xs sm:text-sm">{{ $room->name }}</h4>
                                    @if($room->description)
                                        <p class="text-xs text-slate-500 mt-0.5 line-clamp-2">{{ $room->description }}</p>
                                    @endif
                                    <div class="flex items-center gap-2 mt-1 text-xs">
                                        <span class="font-semibold text-[#135860]">${{ number_format($room->price_per_night, 2) }} / night</span>
                                        <span class="text-slate-400">•</span>
                                        <span class="text-slate-500 font-medium">Cap: {{ $room->capacity }}</span>
                                    </div>
                                </div>
                                <div class="w-24 shrink-0">
                                    <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-0.5">Rooms</label>
                                    <input type="number" min="0" wire:model.defer="selected_rooms.{{ $room->id }}" placeholder="0" class="w-full rounded-2xl border-slate-300 text-slate-900 text-xs font-semibold px-3 py-2 shadow-2xs focus:border-[#135860] focus:ring-2 focus:ring-[#135860]/20">
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-slate-500 col-span-2 italic bg-slate-50 p-3 rounded-2xl border border-dashed border-slate-200">No room types configured.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Guided Activities -->
                <div class="space-y-3 pt-2">
                    <h3 class="text-sm font-heading font-bold text-[#135860] border-b border-slate-100 pb-1.5 flex items-center gap-2">
                        <svg class="w-4 h-4 text-[#135860]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Outdoor Activities & Workshops
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @forelse($activities as $activity)
                            <div class="bg-slate-50/80 hover:bg-white p-4 rounded-2xl border border-slate-200 flex items-center justify-between gap-3 transition-all">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-slate-900 text-xs sm:text-sm">{{ $activity->name }}</h4>
                                    @if($activity->description)
                                        <p class="text-xs text-slate-500 mt-0.5 line-clamp-2">{{ $activity->description }}</p>
                                    @endif
                                    <div class="flex items-center gap-2 mt-1 text-xs">
                                        <span class="font-semibold text-[#135860]">${{ number_format($activity->price_per_person, 2) }} / person</span>
                                        @if($activity->duration_minutes)
                                            <span class="text-slate-400">•</span>
                                            <span class="text-slate-500 font-medium">{{ $activity->duration_minutes }}m</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="w-24 shrink-0">
                                    <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-0.5">Guests</label>
                                    <input type="number" min="0" wire:model.defer="selected_activities.{{ $activity->id }}" placeholder="0" class="w-full rounded-2xl border-slate-300 text-slate-900 text-xs font-semibold px-3 py-2 shadow-2xs focus:border-[#135860] focus:ring-2 focus:ring-[#135860]/20">
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-slate-500 col-span-2 italic bg-slate-50 p-3 rounded-2xl border border-dashed border-slate-200">No activities configured.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Section 4: Document Uploads -->
            <div class="bg-white border border-slate-200/80 rounded-2xl p-5 sm:p-8 space-y-6 shadow-sm">
                <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                    <div class="w-8 h-8 rounded-2xl bg-[#135860]/10 text-[#135860] font-heading font-bold flex items-center justify-center text-sm border border-[#135860]/20">4</div>
                    <h2 class="text-xl font-heading font-bold text-[#135860]">Attach Documents (Optional)</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Insurance Policy Certificate</label>
                        <div class="relative border-2 border-dashed border-slate-300 hover:border-[#135860] rounded-2xl p-4 transition-all bg-slate-50/50 hover:bg-[#135860]/5 cursor-pointer">
                            <input type="file" wire:model="insurance_file" accept=".pdf,.jpg,.jpeg,.png" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-[#135860]/10 text-[#135860] rounded-xl">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <div class="truncate text-xs">
                                    @if($insurance_file)
                                        <p class="font-semibold text-[#135860] truncate">{{ $insurance_file->getClientOriginalName() }}</p>
                                        <p class="text-slate-500">File attached</p>
                                    @else
                                        <p class="font-medium text-slate-800">Select Insurance File</p>
                                        <p class="text-slate-500">PDF, PNG, JPG (max 10MB)</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @error('insurance_file') <span class="text-xs text-rose-600 block mt-1 font-medium">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Signed Contract / Agreements</label>
                        <div class="relative border-2 border-dashed border-slate-300 hover:border-[#135860] rounded-2xl p-4 transition-all bg-slate-50/50 hover:bg-[#135860]/5 cursor-pointer">
                            <input type="file" wire:model="contract_file" accept=".pdf,.doc,.docx" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-[#135860]/10 text-[#135860] rounded-xl">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <div class="truncate text-xs">
                                    @if($contract_file)
                                        <p class="font-semibold text-[#135860] truncate">{{ $contract_file->getClientOriginalName() }}</p>
                                        <p class="text-slate-500">File attached</p>
                                    @else
                                        <p class="font-medium text-slate-800">Select Contract File</p>
                                        <p class="text-slate-500">PDF, DOC, DOCX (max 10MB)</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @error('contract_file') <span class="text-xs text-rose-600 block mt-1 font-medium">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Submit Button Bar -->
            <div class="flex justify-end pt-2">
                <button type="submit" wire:loading.attr="disabled" class="w-full sm:w-auto bg-[#135860] hover:bg-[#0d434a] text-white font-heading font-bold py-3.5 px-10 rounded-2xl shadow-md transition-all active:scale-[0.98] inline-flex items-center justify-center">
                    <span wire:loading.remove>{{ $isEditing ? 'Update Group Inquiry' : 'Submit Group Inquiry' }}</span>
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