@props([
    'title' => null,
    'subtitle' => null,
    'icon' => null,
    'variant' => 'default', // default, success, warning, info
    'hoverable' => true,
    'color' => null
])

<div style="background : {{ $color }}" {{ $attributes->merge([
    'class' => 'rounded-xl shadow-soft p-6 transition-all duration-300 ' . 
               ($hoverable ? 'hover:shadow-medium hover:-translate-y-1' : '')
]) }}>
    @if($title || $icon)
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center space-x-3">
                @if($icon)
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center
                        {{ $variant === 'success' ? 'bg-green-100 text-green-600' : '' }}
                        {{ $variant === 'warning' ? 'bg-orange-100 text-orange-600' : '' }}
                        {{ $variant === 'info' ? 'bg-blue-100 text-blue-600' : '' }}
                        {{ $variant === 'default' ? 'bg-[#2E7D32]/10 text-[#2E7D32]' : '' }}
                    ">
                        {!! $icon !!}
                    </div>
                @endif
                <div>
                    @if($title)
                        <h3 class="text-lg font-semibold text-[#37474F] font-poppins">{{ $title }}</h3>
                    @endif
                    @if($subtitle)
                        <p class="text-sm text-[#37474F]/60">{{ $subtitle }}</p>
                    @endif
                </div>
            </div>
        </div>
    @endif
    
    {{ $slot }}
</div>