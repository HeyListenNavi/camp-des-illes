<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    @php
        $url = $field->getUrl();
        $svg = $field->getQrSvg();
        $caption = $field->getCaption();
    @endphp

    @if ($url && $svg)
        <div class="inline-flex flex-col items-center justify-center p-3.5 bg-white border border-gray-200 rounded-xl shadow-xs dark:bg-gray-800 dark:border-gray-700">
            {!! $svg !!}

            @if ($caption)
                <span class="mt-2 text-[11px] font-medium text-gray-500 dark:text-gray-400 text-center">
                    {{ $caption }}
                </span>
            @endif
        </div>
    @else
        <div class="p-3 text-xs text-gray-400 border border-dashed rounded-lg">
            Save record to generate QR code
        </div>
    @endif
</x-dynamic-component>
