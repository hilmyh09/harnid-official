<x-layouts.app title="Kontak">
    <x-section title="Hubungi kami" subtitle="Isi formulir di bawah atau hubungi kami langsung.">
        <div class="grid gap-10 md:grid-cols-5">
            <form method="POST" action="{{ route('contact.store') }}" class="space-y-5 md:col-span-3" novalidate>
                @csrf
                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="name" class="label">Nama</label>
                        <input id="name" name="name" type="text" class="input" value="{{ old('name') }}" required autocomplete="name">
                        <x-field-error for="name" />
                    </div>
                    <div>
                        <label for="email" class="label">Email</label>
                        <input id="email" name="email" type="email" class="input" value="{{ old('email') }}" required autocomplete="email">
                        <x-field-error for="email" />
                    </div>
                </div>
                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="phone" class="label">Nomor telepon <span class="text-gray-400">(opsional)</span></label>
                        <input id="phone" name="phone" type="tel" class="input" value="{{ old('phone') }}" autocomplete="tel">
                        <x-field-error for="phone" />
                    </div>
                    <div>
                        <label for="subject" class="label">Subjek</label>
                        <input id="subject" name="subject" type="text" class="input" value="{{ old('subject') }}" required>
                        <x-field-error for="subject" />
                    </div>
                </div>
                <div>
                    <label for="message" class="label">Pesan</label>
                    <textarea id="message" name="message" rows="6" class="input" required>{{ old('message') }}</textarea>
                    <x-field-error for="message" />
                </div>
                {{-- Honeypot: dibiarkan kosong oleh manusia --}}
                <div class="hidden" aria-hidden="true">
                    <label for="website">Website</label>
                    <input id="website" name="website" type="text" tabindex="-1" autocomplete="off">
                </div>
                <button type="submit" class="btn-primary">Kirim pesan</button>
            </form>

            <aside class="space-y-4 text-sm text-gray-700 md:col-span-2">
                <div class="rounded-xl border border-gray-200 p-5">
                    <p class="font-semibold text-gray-900">Email</p>
                    <a class="text-brand-700 hover:underline" href="mailto:{{ config('company.email') }}">{{ config('company.email') }}</a>
                </div>
                <div class="rounded-xl border border-gray-200 p-5">
                    <p class="font-semibold text-gray-900">Telepon / WhatsApp</p>
                    <p>{{ config('company.phone') }}</p>
                    <a class="mt-2 inline-block text-brand-700 hover:underline" href="https://wa.me/{{ config('company.whatsapp') }}" target="_blank" rel="noopener">Chat via WhatsApp</a>
                </div>
                <div class="rounded-xl border border-gray-200 p-5">
                    <p class="font-semibold text-gray-900">Alamat</p>
                    <p>{{ config('company.address') }}</p>
                </div>
            </aside>
        </div>
    </x-section>
</x-layouts.app>
