<div {{ $attributes->merge(['class' => 'bg-white p-4 rounded-lg shadow-sm']) }}>
    @if(isset($title))
        <div class="flex items-center justify-between mb-2">
            <h3 class="text-sm font-medium text-gray-700">{{ $title }}</h3>
            @if(isset($actions))
                <div class="text-sm text-gray-500">{{ $actions }}</div>
            @endif
        </div>
    @endif
    <div class="text-2xl font-semibold">{{ $slot }}</div>
    @if(isset($meta))
        <div class="text-xs text-gray-500 mt-2">{{ $meta }}</div>
    @endif
</div>
