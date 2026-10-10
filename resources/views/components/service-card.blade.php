@props(['title', 'description'])
<div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm transition hover:shadow-md">
    <div class="mb-4 flex h-10 w-10 items-center justify-center rounded-lg bg-brand-50 text-brand-600" aria-hidden="true">
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
    </div>
    <h3 class="text-lg font-semibold text-gray-900">{{ $title }}</h3>
    <p class="mt-2 text-sm leading-relaxed text-gray-600">{{ $description }}</p>
</div>
