<x-layouts.shop :title="$product->name" :description="\Illuminate\Support\Str::limit($product->description, 150)">
    <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6">
        <nav class="text-xs text-noir-700/70" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:underline">Beranda</a> /
            <a href="{{ route('catalog.category', $product->category) }}" class="hover:underline">{{ $product->category->name }}</a> /
            <span>{{ $product->name }}</span>
        </nav>

        <div class="mt-6 grid gap-10 md:grid-cols-2">
            <div class="aspect-[3/4] overflow-hidden bg-ivory-200">
                @if ($product->imageUrl())
                    <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                @endif
            </div>

            <div>
                @if ($product->collection)
                    <a href="{{ route('catalog.collection', $product->collection) }}" class="eyebrow hover:underline">{{ $product->collection->name }}</a>
                @endif
                <h1 class="mt-2 font-display text-4xl font-medium">{{ $product->name }}</h1>
                <x-price :product="$product" class="mt-3 text-lg" />
                @if ($product->isOnSale())
                    <p class="mt-1 text-xs font-semibold uppercase tracking-widest text-gold-600">Hemat {{ $product->discountPercent() }}%</p>
                @endif

                <form method="POST" action="{{ route('cart.add', $product) }}" class="mt-8 space-y-6">
                    @csrf
                    @if ($product->color)
                        <div class="flex items-center gap-2 text-sm">
                            <span class="h-5 w-5 rounded-full border border-ivory-300" style="background: {{ $product->color_hex ?? '#ddd' }}"></span>
                            <span>Warna: <strong>{{ $product->color }}</strong></span>
                        </div>
                    @endif

                    @if ($product->hasSizes())
                        <fieldset>
                            <div class="flex items-center justify-between">
                                <legend class="label">Ukuran</legend>
                                <a href="{{ route('size-guide') }}" class="text-xs underline underline-offset-4">Panduan ukuran</a>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($product->sizes as $size)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="size" value="{{ $size }}" class="peer sr-only" @checked(old('size') === $size)>
                                        <span class="inline-flex min-w-12 items-center justify-center border border-ivory-300 px-3 py-2 text-sm peer-checked:border-noir-900 peer-checked:bg-noir-900 peer-checked:text-ivory-50 peer-focus-visible:ring-2 peer-focus-visible:ring-gold-500">{{ $size }}</span>
                                    </label>
                                @endforeach
                            </div>
                            <x-field-error for="size" />
                        </fieldset>
                    @endif

                    <div class="max-w-[8rem]">
                        <label for="quantity" class="label">Jumlah</label>
                        <input id="quantity" name="quantity" type="number" min="1" max="{{ max($product->stock, 1) }}" value="{{ old('quantity', 1) }}" class="input">
                        <x-field-error for="quantity" />
                    </div>

                    @if ($product->stock > 0)
                        <button type="submit" class="btn-primary w-full">Tambah ke Bag</button>
                        <p class="text-xs text-noir-700/70">{{ $product->stock <= 5 ? "Sisa {$product->stock} stok." : 'Stok tersedia.' }}</p>
                    @else
                        <button type="button" class="btn-primary w-full" disabled>Stok habis</button>
                        <a href="https://wa.me/{{ config('company.whatsapp') }}?text={{ rawurlencode('Halo, kapan '.$product->name.' restock?') }}" class="btn-link" target="_blank" rel="noopener">Tanya restock via WhatsApp</a>
                    @endif
                </form>

                <div class="mt-10 space-y-6 border-t border-ivory-200 pt-8 text-sm leading-relaxed text-noir-700">
                    <div>
                        <p class="eyebrow mb-2">Deskripsi</p>
                        <p>{{ $product->description }}</p>
                    </div>
                    <dl class="grid grid-cols-2 gap-3 text-xs">
                        <dt class="text-noir-700/60">SKU</dt><dd>{{ $product->sku }}</dd>
                        <dt class="text-noir-700/60">Kategori</dt><dd>{{ $product->category->name }}</dd>
                        <dt class="text-noir-700/60">Pengiriman</dt><dd>Seluruh Indonesia &amp; worldwide</dd>
                        <dt class="text-noir-700/60">Penukaran</dt><dd>Tukar ukuran 7 hari, syarat berlaku</dd>
                    </dl>
                </div>
            </div>
        </div>

        @if ($related->isNotEmpty())
            <div class="mt-20">
                <p class="eyebrow">Mungkin Anda suka</p>
                <h2 class="mt-2 font-display text-3xl font-medium">Produk serupa</h2>
                <div class="mt-8 grid grid-cols-2 gap-x-4 gap-y-10 md:grid-cols-4">
                    @foreach ($related as $item)
                        <x-product-card :product="$item" />
                    @endforeach
                </div>
            </div>
        @endif
    </section>
</x-layouts.shop>
