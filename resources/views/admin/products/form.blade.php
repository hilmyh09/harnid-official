<x-layouts.admin :title="$product->exists ? 'Edit produk' : 'Tambah produk'">
    <h1 class="font-display text-3xl font-medium">{{ $product->exists ? 'Edit produk' : 'Tambah produk' }}</h1>

    <form method="POST" action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}" enctype="multipart/form-data" class="mt-6 grid max-w-4xl gap-6 lg:grid-cols-3">
        @csrf
        @if ($product->exists) @method('PUT') @endif

        <div class="space-y-5 border border-ivory-200 bg-white p-6 lg:col-span-2">
            <div><label for="name" class="label">Nama produk</label><input id="name" name="name" class="input" value="{{ old('name', $product->name) }}" required><x-field-error for="name" /></div>
            <div class="grid gap-5 sm:grid-cols-2">
                <div><label for="slug" class="label">Slug URL <span class="font-normal normal-case tracking-normal text-noir-700/60">(kosongkan = otomatis)</span></label><input id="slug" name="slug" class="input" value="{{ old('slug', $product->slug) }}"><x-field-error for="slug" /></div>
                <div><label for="sku" class="label">SKU</label><input id="sku" name="sku" class="input" value="{{ old('sku', $product->sku) }}" required><x-field-error for="sku" /></div>
            </div>
            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="category_id" class="label">Kategori</label>
                    <select id="category_id" name="category_id" class="input" required>
                        <option value="">Pilih kategori</option>
                        @foreach ($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>@endforeach
                    </select>
                    <x-field-error for="category_id" />
                </div>
                <div>
                    <label for="collection_id" class="label">Koleksi</label>
                    <select id="collection_id" name="collection_id" class="input">
                        <option value="">Tanpa koleksi</option>
                        @foreach ($collections as $collection)<option value="{{ $collection->id }}" @selected(old('collection_id', $product->collection_id) == $collection->id)>{{ $collection->name }}</option>@endforeach
                    </select>
                    <x-field-error for="collection_id" />
                </div>
            </div>
            <div class="grid gap-5 sm:grid-cols-3">
                <div><label for="price" class="label">Harga (Rp)</label><input id="price" name="price" type="number" min="0" step="1000" class="input" value="{{ old('price', $product->price) }}" required><x-field-error for="price" /></div>
                <div><label for="compare_at_price" class="label">Harga coret (Rp)</label><input id="compare_at_price" name="compare_at_price" type="number" min="0" step="1000" class="input" value="{{ old('compare_at_price', $product->compare_at_price) }}"><x-field-error for="compare_at_price" /></div>
                <div><label for="stock" class="label">Stok</label><input id="stock" name="stock" type="number" min="0" class="input" value="{{ old('stock', $product->stock) }}" required><x-field-error for="stock" /></div>
            </div>
            <div class="grid gap-5 sm:grid-cols-3">
                <div><label for="color" class="label">Warna</label><input id="color" name="color" class="input" value="{{ old('color', $product->color) }}"><x-field-error for="color" /></div>
                <div><label for="color_hex" class="label">Kode warna</label><input id="color_hex" name="color_hex" class="input" placeholder="#1f1f1f" value="{{ old('color_hex', $product->color_hex) }}"><x-field-error for="color_hex" /></div>
                <div><label for="sizes" class="label">Ukuran <span class="font-normal normal-case tracking-normal text-noir-700/60">(pisah koma)</span></label><input id="sizes" name="sizes" class="input" placeholder="S, M, L, XL" value="{{ old('sizes') ? (is_array(old('sizes')) ? implode(', ', old('sizes')) : old('sizes')) : implode(', ', $product->sizes ?? []) }}"><x-field-error for="sizes" /></div>
            </div>
            <div><label for="description" class="label">Deskripsi</label><textarea id="description" name="description" rows="6" class="input">{{ old('description', $product->description) }}</textarea><x-field-error for="description" /></div>
        </div>

        <div class="space-y-5">
            <div class="border border-ivory-200 bg-white p-6">
                <p class="label">Gambar</p>
                <div class="aspect-[3/4] w-32 overflow-hidden bg-ivory-200">@if ($product->imageUrl())<img src="{{ $product->imageUrl() }}" alt="" class="h-full w-full object-cover">@endif</div>
                <input name="image" type="file" accept="image/*" class="mt-3 block w-full text-xs">
                <p class="mt-1 text-xs text-noir-700/60">JPG/PNG/WebP maks. 3 MB, rasio 3:4.</p>
                <x-field-error for="image" />
            </div>
            <div class="space-y-3 border border-ivory-200 bg-white p-6 text-sm">
                <label class="flex items-center gap-2"><input type="checkbox" name="published" value="1" @checked(old('published', $product->published_at !== null))> Tayang di toko</label>
                <label class="flex items-center gap-2"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active))> Aktif</label>
                <label class="flex items-center gap-2"><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $product->is_featured))> Tampilkan di Pilihan Harnid</label>
            </div>
            <button type="submit" class="btn-primary w-full">Simpan</button>
            <a href="{{ route('admin.products.index') }}" class="btn-link w-full justify-center">Batal</a>
        </div>
    </form>
</x-layouts.admin>
