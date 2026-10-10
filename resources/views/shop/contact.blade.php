<x-layouts.shop title="Kontak">
    <section class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
        <p class="eyebrow">Customer care</p>
        <h1 class="mt-2 font-display text-4xl font-medium">Hubungi kami</h1>
        <div class="mt-8 grid gap-10 md:grid-cols-5">
            <form method="POST" action="{{ route('contact.store') }}" class="space-y-5 md:col-span-3" novalidate>
                @csrf
                <div class="grid gap-5 sm:grid-cols-2">
                    <div><label for="name" class="label">Nama</label><input id="name" name="name" class="input" value="{{ old('name') }}" required autocomplete="name"><x-field-error for="name" /></div>
                    <div><label for="email" class="label">Email</label><input id="email" name="email" type="email" class="input" value="{{ old('email') }}" required autocomplete="email"><x-field-error for="email" /></div>
                </div>
                <div class="grid gap-5 sm:grid-cols-2">
                    <div><label for="phone" class="label">Nomor telepon <span class="font-normal normal-case tracking-normal text-noir-700/60">(opsional)</span></label><input id="phone" name="phone" type="tel" class="input" value="{{ old('phone') }}" autocomplete="tel"><x-field-error for="phone" /></div>
                    <div><label for="subject" class="label">Subjek</label><input id="subject" name="subject" class="input" value="{{ old('subject') }}" required><x-field-error for="subject" /></div>
                </div>
                <div><label for="message" class="label">Pesan</label><textarea id="message" name="message" rows="6" class="input" required>{{ old('message') }}</textarea><x-field-error for="message" /></div>
                <div class="hidden" aria-hidden="true"><label for="website">Website</label><input id="website" name="website" type="text" tabindex="-1" autocomplete="off"></div>
                <button type="submit" class="btn-primary">Kirim pesan</button>
            </form>
            <aside class="space-y-4 text-sm md:col-span-2">
                <div class="border border-ivory-200 bg-white p-5"><p class="eyebrow">WhatsApp</p><p class="mt-2">{{ config('company.phone') }}</p><a class="btn-link mt-2" href="https://wa.me/{{ config('company.whatsapp') }}" target="_blank" rel="noopener">Chat sekarang</a></div>
                <div class="border border-ivory-200 bg-white p-5"><p class="eyebrow">Email</p><a class="mt-2 block hover:underline" href="mailto:{{ config('company.email') }}">{{ config('company.email') }}</a></div>
                <div class="border border-ivory-200 bg-white p-5"><p class="eyebrow">Kantor</p><p class="mt-2">{{ config('company.address') }}</p></div>
            </aside>
        </div>
    </section>
</x-layouts.shop>
