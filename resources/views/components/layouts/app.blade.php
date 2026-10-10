<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title.' — ' : '' }}{{ config('company.name') }}</title>
    <meta name="description" content="{{ $description ?? config('company.tagline') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white font-sans text-gray-900 antialiased">
    <x-site-header />

    @if (session('status'))
        <div class="mx-auto mt-6 max-w-6xl px-4 sm:px-6">
            <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800" role="status">
                {{ session('status') }}
            </div>
        </div>
    @endif

    <main>
        {{ $slot }}
    </main>

    <x-site-footer />
</body>
</html>
