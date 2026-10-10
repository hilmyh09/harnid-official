@props(['status'])
@php($classes = match ($status) {
    'pending' => 'bg-amber-100 text-amber-800',
    'confirmed' => 'bg-blue-100 text-blue-800',
    'shipped' => 'bg-indigo-100 text-indigo-800',
    'completed' => 'bg-green-100 text-green-800',
    'cancelled' => 'bg-gray-200 text-gray-700',
    default => 'bg-gray-100 text-gray-700',
})
<span {{ $attributes->class(['badge', $classes]) }}>{{ \App\Models\Order::STATUSES[$status] ?? $status }}</span>
