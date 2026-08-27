<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Individual</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- JS Helper opcional para mostrar el nombre del archivo seleccionado -->
    <script>
        function updateFileName(input, targetId) {
            if (input.files && input.files[0]) {
                document.getElementById(targetId).textContent = input.files[0].name;
            }
        }
    </script>
</head>
<body class="bg-slate-50 min-h-screen py-8">

    <div class="w-full max-w-4xl mx-auto space-y-6 px-4">
        @if (session('success'))
            <!-- Success Confirmation Screen -->
            <div class="bg-white border border-emerald-100 rounded-2xl p-6 sm:p-10 shadow-md text-center space-y-6">
                <div class="w-16 h-16 bg-emerald-50 text-[#135860] rounded-full flex items-center justify-center mx-auto border border-emerald-100">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                
                <div class="space-y-2">
                    <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">
                        Registration Completed!
                    </h2>
                    <p class="text-slate-600 max-w-lg mx-auto leading-relaxed text-sm sm:text-base">
                        {{ session('success') }}
                    </p>
                </div>
            </div>
        @else
            <form action="{{ route('groups.store-individual') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Header Section Banner -->
                <div class="bg-[#135860] text-white rounded-2xl p-5 sm:p-6 shadow-sm relative overflow-hidden">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="px-3 py-1 text-[11px] font-bold tracking-wider uppercase rounded-full bg-white/15 text-white border border-white/20">
                            Individual Guest Registration
                        </span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-white">Group Member Information</h1>
                    <p class="text-slate-200 mt-1 max-w-2xl text-xs sm:text-sm leading-relaxed">
                        Complete your personal details and submit the required documentation for your upcoming event.
                    </p>
                </div>

                <!-- Section 1: Personal Contact Info -->
                <div class="bg-white border border-slate-200/80 rounded-2xl p-5 sm:p-8 space-y-6 shadow-sm">
                    <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                        <div class="w-8 h-8 rounded-2xl bg-[#135860]/10 text-[#135860] font-bold flex items-center justify-center text-sm border border-[#135860]/20">1</div>
                        <h2 class="text-xl font-bold text-[#135860]">Personal Details</h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Full Name *</label>
                            <input type="text" name="full_name" value="{{ old('full_name') }}" class="w-full rounded-2xl border border-slate-300 text-slate-900 text-sm px-4 py-3 focus:outline-none focus:border-[#135860] focus:ring-2 focus:ring-[#135860]/20" placeholder="e.g. John Doe" required>
                            @error('full_name') <span class="text-xs font-medium text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Email Address *</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-2xl border border-slate-300 text-slate-900 text-sm px-4 py-3 focus:outline-none focus:border-[#135860] focus:ring-2 focus:ring-[#135860]/20" placeholder="john@example.com" required>
                            @error('email') <span class="text-xs font-medium text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Phone Number *</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" class="w-full rounded-2xl border border-slate-300 text-slate-900 text-sm px-4 py-3 focus:outline-none focus:border-[#135860] focus:ring-2 focus:ring-[#135860]/20" placeholder="555-019-2831" required>
                            @error('phone') <span class="text-xs font-medium text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 2: Document Uploads -->
                <div class="bg-white border border-slate-200/80 rounded-2xl p-5 sm:p-8 space-y-6 shadow-sm">
                    <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                        <div class="w-8 h-8 rounded-2xl bg-[#135860]/10 text-[#135860] font-bold flex items-center justify-center text-sm border border-[#135860]/20">2</div>
                        <h2 class="text-xl font-bold text-[#135860]">Required Identification & Medical Forms</h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Upload 1: ID Document -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Identity Document (ID / Passport) *</label>
                            <div class="relative border-2 border-dashed border-slate-300 hover:border-[#135860] rounded-2xl p-4 transition-all bg-slate-50/50 hover:bg-[#135860]/5 cursor-pointer">
                                <input type="file" name="id_document" accept=".pdf,.jpg,.jpeg,.png" onchange="updateFileName(this, 'id-filename')" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" required>
                                <div class="flex items-center gap-3">
                                    <div class="p-2 bg-[#135860]/10 text-[#135860] rounded-xl shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 012-2h2a2 2 0 012 v1m-6 0h6"/>
                                        </svg>
                                    </div>
                                    <div class="truncate text-xs">
                                        <p id="id-filename" class="font-medium text-slate-800 truncate">Upload ID Document</p>
                                        <p class="text-slate-500">PDF, PNG, JPG (max 10MB)</p>
                                    </div>
                                </div>
                            </div>
                            @error('id_document') <span class="text-xs text-rose-600 block mt-1 font-medium">{{ $message }}</span> @enderror
                        </div>

                        <!-- Upload 2: Medical Release Form -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Medical Release / Waiver Form *</label>
                            <div class="relative border-2 border-dashed border-slate-300 hover:border-[#135860] rounded-2xl p-4 transition-all bg-slate-50/50 hover:bg-[#135860]/5 cursor-pointer">
                                <input type="file" name="medical_release" accept=".pdf,.doc,.docx,.jpg,.png" onchange="updateFileName(this, 'medical-filename')" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" required>
                                <div class="flex items-center gap-3">
                                    <div class="p-2 bg-[#135860]/10 text-[#135860] rounded-xl shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <div class="truncate text-xs">
                                        <p id="medical-filename" class="font-medium text-slate-800 truncate">Upload Medical Release</p>
                                        <p class="text-slate-500">PDF, DOC, JPG (max 10MB)</p>
                                    </div>
                                </div>
                            </div>
                            @error('medical_release') <span class="text-xs text-rose-600 block mt-1 font-medium">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Button Bar -->
                <div class="flex justify-end pt-2">
                    <button type="submit" class="w-full sm:w-auto bg-[#135860] hover:bg-[#0d434a] text-white font-bold py-3.5 px-10 rounded-2xl shadow-md transition-all active:scale-[0.98] inline-flex items-center justify-center cursor-pointer">
                        <span>Complete Registration</span>
                    </button>
                </div>
            </form>
        @endif
    </div>

</body>
</html>