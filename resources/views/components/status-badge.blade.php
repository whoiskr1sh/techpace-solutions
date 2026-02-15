@props(['status'])

@php
    $map = [
        'draft' => 'bg-gray-100 text-gray-800',
        'sent' => 'bg-blue-100 text-blue-800',
        'accepted' => 'bg-green-100 text-green-800',
        'rejected' => 'bg-red-100 text-red-800',
        'pending' => 'bg-yellow-100 text-yellow-800',
        'paid' => 'bg-green-100 text-green-800',
        'cancelled' => 'bg-red-100 text-red-800',
    ];
    $class = $map[$status] ?? 'bg-gray-100 text-gray-800';
@endphp

<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $class }}">{{ ucfirst($status) }}</span>
