@props(['type' => 'info', 'message'])

@php
    $colors = [
        'info' => 'bg-blue-50 border-blue-400 text-blue-700',
        'success' => 'bg-green-50 border-green-400 text-green-800',
        'error' => 'bg-red-50 border-red-400 text-red-800'
    ];
    $class = $colors[$type] ?? $colors['info'];
@endphp

<div class="mb-4 p-4 border-l-4 rounded {{ $class }}">
    {{ $message }}
</div>
