<x-layouts.shop title="Masuk">
    <div class="mx-auto max-w-md px-4 py-16 sm:px-6">
        <div class="border border-ivory-200 bg-white p-8">
            <p class="eyebrow">Admin</p>
            <h1 class="mt-2 font-display text-3xl font-medium">Masuk</h1>
            <form method="POST" action="{{ route('login.store') }}" class="mt-6 space-y-5">
                @csrf
                <div><label for="email" class="label">Email</label><input id="email" name="email" type="email" class="input" value="{{ old('email') }}" required autofocus autocomplete="username"><x-field-error for="email" /></div>
                <div><label for="password" class="label">Password</label><input id="password" name="password" type="password" class="input" required autocomplete="current-password"><x-field-error for="password" /></div>
                <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="remember" class="border-ivory-300"> Ingat saya</label>
                <button type="submit" class="btn-primary w-full">Masuk</button>
            </form>
        </div>
    </div>
</x-layouts.shop>
