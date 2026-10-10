<x-layouts.app title="Masuk">
    <div class="mx-auto max-w-md px-4 py-16 sm:px-6">
        <div class="rounded-2xl border border-gray-200 bg-white p-8 shadow-sm">
            <h1 class="text-2xl font-bold text-gray-900">Masuk</h1>
            <p class="mt-1 text-sm text-gray-600">Akses dashboard pengelola.</p>

            <form method="POST" action="{{ route('login.store') }}" class="mt-6 space-y-5">
                @csrf
                <div>
                    <label for="email" class="label">Email</label>
                    <input id="email" name="email" type="email" class="input" value="{{ old('email') }}" required autofocus autocomplete="username">
                    <x-field-error for="email" />
                </div>
                <div>
                    <label for="password" class="label">Password</label>
                    <input id="password" name="password" type="password" class="input" required autocomplete="current-password">
                    <x-field-error for="password" />
                </div>
                <label class="flex items-center gap-2 text-sm text-gray-700">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-brand-600 focus:ring-brand-500">
                    Ingat saya
                </label>
                <button type="submit" class="btn-primary w-full">Masuk</button>
            </form>
        </div>
    </div>
</x-layouts.app>
