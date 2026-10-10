<x-layouts.shop title="Keranjang">
    <section class="mx-auto max-w-5xl px-4 py-12 sm:px-6">
        <h1 class="font-display text-4xl font-medium">Shopping Bag</h1>

        @if ($lines->isEmpty())
            <div class="mt-10 border border-ivory-200 bg-white p-10 text-center">
                <p class="text-sm text-noir-700">Keranjang Anda masih kosong.</p>
                <a href="{{ route('catalog.index') }}" class="btn-primary mt-6">Mulai belanja</a>
            </div>
        @else
            <div class="mt-8 grid gap-10 lg:grid-cols-3">
                <div class="space-y-6 lg:col-span-2">
                    @foreach ($lines as $line)
                        <div class="flex gap-4 border-b border-ivory-200 pb-6">
                            <a href="{{ route('product.show', $line['product']) }}" class="block w-24 shrink-0 overflow-hidden bg-ivory-200 sm:w-28">
                                @if ($line['product']->imageUrl())
                                    <img src="{{ $line['product']->imageUrl() }}" alt="{{ $line['product']->name }}" class="aspect-[3/4] w-full object-cover">
                                @endif
                            </a>
                            <div class="flex flex-1 flex-col">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <h2 class="font-sans text-sm font-medium"><a href="{{ route('product.show', $line['product']) }}" class="hover:underline">{{ $line['product']->name }}</a></h2>
                                        <p class="mt-1 text-xs text-noir-700/70">
                                            {{ $line['product']->color }}@if ($line['size']) &middot; Ukuran {{ $line['size'] }}@endif
                                        </p>
                                        <p class="mt-1 text-sm">{{ rupiah($line['product']->price) }}</p>
                                    </div>
                                    <p class="text-sm font-medium">{{ rupiah($line['line_total']) }}</p>
                                </div>
                                <div class="mt-auto flex items-center gap-3 pt-3">
                                    <form method="POST" action="{{ route('cart.update', $line['key']) }}" class="flex items-center gap-2">
                                        @csrf @method('PATCH')
                                        <label for="qty-{{ $loop->index }}" class="sr-only">Jumlah</label>
                                        <input id="qty-{{ $loop->index }}" name="quantity" type="number" min="0" max="99" value="{{ $line['quantity'] }}" class="input w-20 py-1.5">
                                        <button type="submit" class="btn-link">Perbarui</button>
                                    </form>
                                    <form method="POST" action="{{ route('cart.remove', $line['key']) }}">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-xs text-noir-700/70 underline-offset-4 hover:underline">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <aside class="h-fit border border-ivory-200 bg-white p-6">
                    <p class="eyebrow">Ringkasan</p>
                    <dl class="mt-4 space-y-2 text-sm">
                        <div class="flex justify-between"><dt>Subtotal</dt><dd>{{ rupiah($subtotal) }}</dd></div>
                        <div class="flex justify-between text-noir-700/70"><dt>Ongkir</dt><dd>Dihitung saat konfirmasi</dd></div>
                        <div class="flex justify-between border-t border-ivory-200 pt-3 text-base font-medium"><dt>Total</dt><dd>{{ rupiah($subtotal) }}</dd></div>
                    </dl>
                    <a href="{{ route('checkout.show') }}" class="btn-primary mt-6 w-full">Checkout</a>
                    <a href="{{ route('catalog.index') }}" class="btn-link mt-4 w-full justify-center">Lanjut belanja</a>
                </aside>
            </div>
        @endif
    </section>
</x-layouts.shop>
