@props(['title' => null, 'description' => null])
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ? $title.' — ' : '' }}{{ config('company.name') }}</title>
    <meta name="description" content="{{ $description ?? config('company.tagline') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-sans antialiased">
    <x-shop.header />

    @if (session('status'))
        <div class="mx-auto mt-4 max-w-7xl px-4 sm:px-6">
            <div class="border border-gold-400 bg-ivory-100 px-4 py-3 text-sm text-noir-800" role="status">{{ session('status') }}</div>
        </div>
    @endif
    @error('cart')
        <div class="mx-auto mt-4 max-w-7xl px-4 sm:px-6">
            <div class="border border-red-300 bg-red-50 px-4 py-3 text-sm text-red-800" role="alert">{{ $message }}</div>
        </div>
    @enderror

    <main>{{ $slot }}</main>

    <x-shop.footer />
</body>
</html>
