@props([
    'title',
    'value',
    'icon',
    'color' => 'indigo', // indigo, green, yellow, red, blue, etc.
    'description' => null,
])

<div
    {{ $attributes->merge(['class' => "bg-white p-5 rounded-xl shadow-lg border-t-4 border-{$color}-500 transition duration-300 hover:shadow-xl transform hover:scale-[1.01]"]) }}>
    <div class="flex items-center">
        <div class="flex-shrink-0 bg-{{ $color }}-100 p-3 rounded-full">
            <!-- Icône -->
            <svg class="h-6 w-6 text-{{ $color }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                {!! $icon !!}
            </svg>
        </div>
        <div class="ml-5 w-0 flex-1">
            <dl>
                <dt class="text-sm font-medium text-gray-500 truncate">{{ $title }}</dt>
                <dd class="flex items-baseline">
                    <div class="text-3xl font-extrabold text-gray-900">
                        {{ $value }}
                    </div>
                </dd>
            </dl>
        </div>
    </div>
    @if ($description)
        <div class="mt-4">
            <p class="text-xs text-gray-400 border-t pt-2 mt-2">
                {{ $description }}
            </p>
        </div>
    @endif
</div>
