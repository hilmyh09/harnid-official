@props(['title' => 'Admin'])
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex">
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" type="image/png" sizes="64x64" href="/images/brand/favicon-64.png">
    <link rel="apple-touch-icon" href="/images/brand/apple-touch-icon.png">
    <title>{{ $title }} — Admin {{ config('company.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-ivory-100 font-sans antialiased">
    <div class="flex min-h-screen">
        <aside class="hidden w-60 shrink-0 bg-noir-900 p-4 text-ivory-200 md:block">
            <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2"><x-brand-logo size="sm" :light="true" /></a>
            <nav class="mt-6 space-y-1" aria-label="Menu admin">
                <a href="{{ route('admin.dashboard') }}" @class(['admin-link', 'admin-link-active' => request()->routeIs('admin.dashboard')])>Dashboard</a>
                <a href="{{ route('admin.products.index') }}" @class(['admin-link', 'admin-link-active' => request()->routeIs('admin.products.*')])>Produk</a>
                <a href="{{ route('admin.orders.index') }}" @class(['admin-link', 'admin-link-active' => request()->routeIs('admin.orders.*')])>Pesanan</a>
                <a href="{{ route('admin.messages.index') }}" @class(['admin-link', 'admin-link-active' => request()->routeIs('admin.messages.*')])>Pesan masuk</a>
                <a href="{{ route('home') }}" class="admin-link" target="_blank" rel="noopener">Lihat toko ↗</a>
            </nav>
            <form method="POST" action="{{ route('admin.logout') }}" class="mt-10 px-3">
                @csrf
                <p class="text-xs text-ivory-200/60">{{ auth()->user()->name }}</p>
                <button type="submit" class="mt-1 text-sm underline underline-offset-4 hover:text-white">Keluar</button>
            </form>
        </aside>

        <div class="flex-1">
            <header class="flex items-center justify-between border-b border-ivory-200 bg-white px-4 py-3 md:hidden">
                <a href="{{ route('admin.dashboard') }}"><x-brand-logo size="sm" /></a>
                <details class="relative">
                    <summary class="cursor-pointer list-none text-xs font-semibold uppercase tracking-widest">Menu</summary>
                    <div class="absolute right-0 z-20 mt-2 w-48 border border-ivory-200 bg-white p-2 shadow-lg">
                        <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 text-sm">Dashboard</a>
                        <a href="{{ route('admin.products.index') }}" class="block px-3 py-2 text-sm">Produk</a>
                        <a href="{{ route('admin.orders.index') }}" class="block px-3 py-2 text-sm">Pesanan</a>
                        <a href="{{ route('admin.messages.index') }}" class="block px-3 py-2 text-sm">Pesan masuk</a>
                        <form method="POST" action="{{ route('admin.logout') }}">@csrf<button type="submit" class="block w-full px-3 py-2 text-left text-sm">Keluar</button></form>
                    </div>
                </details>
            </header>

            <main class="p-4 sm:p-8">
                @if (session('status'))
                    <div class="mb-6 border border-gold-400 bg-ivory-50 px-4 py-3 text-sm" role="status">{{ session('status') }}</div>
                @endif
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
