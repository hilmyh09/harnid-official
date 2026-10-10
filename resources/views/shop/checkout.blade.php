<x-layouts.shop title="Checkout">
    <section class="mx-auto max-w-6xl px-4 py-12 sm:px-6">
        <h1 class="font-display text-4xl font-medium">Checkout</h1>
        <p class="mt-2 text-sm text-noir-700">Isi data pengiriman. Setelah pesanan dibuat, Anda akan diarahkan ke WhatsApp untuk konfirmasi pembayaran dan ongkir.</p>

        <div class="mt-8 grid gap-10 lg:grid-cols-5">
            <form method="POST" action="{{ route('checkout.store') }}" class="space-y-5 lg:col-span-3" novalidate>
                @csrf
                <div class="grid gap-5 sm:grid-cols-2">
                    <div><label for="customer_name" class="label">Nama penerima</label><input id="customer_name" name="customer_name" class="input" value="{{ old('customer_name') }}" required autocomplete="name"><x-field-error for="customer_name" /></div>
                    <div><label for="customer_phone" class="label">Nomor WhatsApp</label><input id="customer_phone" name="customer_phone" type="tel" class="input" value="{{ old('customer_phone') }}" placeholder="08xxxxxxxxxx" required autocomplete="tel"><x-field-error for="customer_phone" /></div>
                </div>
                <div><label for="customer_email" class="label">Email <span class="font-normal normal-case tracking-normal text-noir-700/60">(opsional)</span></label><input id="customer_email" name="customer_email" type="email" class="input" value="{{ old('customer_email') }}" autocomplete="email"><x-field-error for="customer_email" /></div>
                <div><label for="address" class="label">Alamat lengkap</label><textarea id="address" name="address" rows="3" class="input" required autocomplete="street-address">{{ old('address') }}</textarea><x-field-error for="address" /></div>
                <div class="grid gap-5 sm:grid-cols-3">
                    <div><label for="city" class="label">Kota/Kabupaten</label><input id="city" name="city" class="input" value="{{ old('city') }}" required><x-field-error for="city" /></div>
                    <div><label for="province" class="label">Provinsi</label><input id="province" name="province" class="input" value="{{ old('province') }}" required><x-field-error for="province" /></div>
                    <div><label for="postal_code" class="label">Kode pos</label><input id="postal_code" name="postal_code" class="input" value="{{ old('postal_code') }}" autocomplete="postal-code"><x-field-error for="postal_code" /></div>
                </div>
                <div><label for="notes" class="label">Catatan <span class="font-normal normal-case tracking-normal text-noir-700/60">(opsional)</span></label><textarea id="notes" name="notes" rows="2" class="input">{{ old('notes') }}</textarea><x-field-error for="notes" /></div>
                <button type="submit" class="btn-primary w-full sm:w-auto">Buat pesanan &amp; lanjut ke WhatsApp</button>
            </form>

            <aside class="h-fit border border-ivory-200 bg-white p-6 lg:col-span-2">
                <p class="eyebrow">Pesanan Anda</p>
                <ul class="mt-4 divide-y divide-ivory-200 text-sm">
                    @foreach ($lines as $line)
                        <li class="flex justify-between gap-4 py-3">
                            <span>{{ $line['product']->name }}@if ($line['size']) ({{ $line['size'] }})@endif &times;{{ $line['quantity'] }}</span>
                            <span class="shrink-0">{{ rupiah($line['line_total']) }}</span>
                        </li>
                    @endforeach
                </ul>
                <dl class="mt-4 space-y-2 border-t border-ivory-200 pt-4 text-sm">
                    <div class="flex justify-between"><dt>Subtotal</dt><dd>{{ rupiah($subtotal) }}</dd></div>
                    <div class="flex justify-between text-noir-700/70"><dt>Ongkir</dt><dd>Dikonfirmasi via WhatsApp</dd></div>
                    <div class="flex justify-between text-base font-medium"><dt>Total sementara</dt><dd>{{ rupiah($subtotal) }}</dd></div>
                </dl>
                <a href="{{ route('cart.index') }}" class="btn-link mt-4">Ubah keranjang</a>
            </aside>
        </div>
    </section>
</x-layouts.shop>
