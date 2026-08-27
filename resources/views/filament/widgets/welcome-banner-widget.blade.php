<x-filament-widgets::widget>
    <div class="rounded-xl bg-[#15616d] p-6 text-white shadow-sm border border-[#104d57]">
        <div class="flex flex-col gap-6">
            <div class="flex flex-col gap-2">
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

            <div class="flex flex-wrap gap-3">
                @foreach($this->getQuickLinks() as $link)
                    <a href="{{ $link['url'] }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-white text-[#15616d] hover:bg-slate-100 active:bg-slate-200 text-sm font-semibold transition-colors duration-150 shadow-sm">
                        <span>{{ $link['label'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-filament-widgets::widget>
