<x-filament-widgets::widget>
    <div
        class="flex flex-col items-start gap-2 rounded-xl border border-[#104d57] bg-[#15616d] p-6 text-white shadow-sm">
        <div class="flex flex-col items-start gap-6 md:flex-row md:items-center">
            <img
                class="h-36 w-auto shrink-0 rounded-xl"
                src="{{ asset('images/camp-des-iles-logo.webp') }}"
                alt="Camp Des Îles Logo"
            />
            <div class="flex flex-1 flex-col gap-4">
                <div class="flex flex-col gap-1">
                    <p class="text-xs font-semibold uppercase tracking-wider text-teal-200">
                        Camp Des Îles • {{ date('Y') }} Season
                    </p>
                    <h2 class="text-2xl font-bold tracking-tight text-white">
                        Welcome back, {{ auth()->user()->name }}! 👋
                    </h2>
                    <p class="text-sm text-teal-100">
                        Overview of active registrations, camp events, and group retreats.
                    </p>
                </div>

                <div class="flex flex-wrap gap-3 pt-1">
                    @foreach ($this->getQuickLinks() as $link)
                        <a
                            class="inline-flex items-center gap-2 rounded-lg bg-white px-4 py-2 text-sm font-semibold text-[#15616d] shadow-sm transition-colors duration-150 hover:bg-slate-100 active:bg-slate-200"
                            href="{{ $link['url'] }}"
                        >
                            <span>{{ $link['label'] }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-filament-widgets::widget>
