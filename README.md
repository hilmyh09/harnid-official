# Harnid Official

Website toko online brand modest fashion **Harnid Official**: landing page, katalog produk, keranjang, checkout dengan konfirmasi WhatsApp, lokasi toko, dan admin untuk mengelola produk, pesanan, serta pesan masuk.
Dibangun dengan **Laravel 13**, **Blade**, **Tailwind CSS 4**, dan **PostgreSQL**.

## Fitur

**Toko (publik)**
- Beranda: hero, kategori (Scarves, Dresses, Tops, Outerwear, Bottoms, Sets), New Arrivals, lini signature (Harnid Noir), Pilihan Harnid, info toko.
- Katalog: semua produk, per kategori, per koleksi, New Arrivals (60 hari), Sale, pencarian, urutan harga, pagination.
- Halaman produk: gambar, harga dan harga coret, warna, pilihan ukuran, stok, produk serupa, tautan panduan ukuran.
- Keranjang berbasis session: baris per produk+ukuran, ubah jumlah, hapus.
- Checkout: form pengiriman, pesanan dibuat atomik dengan pengurangan stok (lock baris), nomor pesanan unik, lalu tombol konfirmasi ke WhatsApp berisi ringkasan pesanan.
- Halaman Tentang, Lokasi toko (dikelompokkan per kota), Panduan ukuran, Kontak (form tersimpan + honeypot + rate limit).

**Admin** (`/admin`, butuh login)
- Dashboard: pesanan menunggu, omzet bulan ini, produk tayang, stok menipis, pesan belum dibaca.
- Produk: daftar + pencarian, tambah/edit (gambar, harga, ukuran, koleksi, status tayang), nonaktifkan.
- Pesanan: daftar dengan filter status, detail, ubah status, tautan WhatsApp pelanggan.
- Pesan masuk: daftar dan tandai dibaca.

Belum ada: pembayaran online, perhitungan ongkir otomatis, akun pelanggan, wishlist, blog, multi gambar per produk.

## Kebutuhan

- PHP 8.3+ (`pdo_pgsql`, `mbstring`, `intl`, `gd`), Composer 2.
- Node.js 22+ dan npm.
- PostgreSQL 16.

## Menjalankan di lokal

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
```

Buat database PostgreSQL, isi `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` di `.env`, lalu:

```bash
php artisan migrate
php artisan db:seed                       # katalog awal (kategori, koleksi, 16 produk contoh, 5 toko)
php artisan db:seed --class=DemoSeeder    # opsional: akun admin DEMO + pesanan/pesan contoh (ditolak di produksi)
php artisan storage:link                  # untuk gambar produk yang diunggah lewat admin
npm run build                             # atau `npm run dev` saat mengembangkan tampilan
php artisan serve
```

Buka http://localhost:8000. Admin di http://localhost:8000/admin.

Akun DEMO (hanya dari `DemoSeeder`):

| Email | Password |
|---|---|
| demo@example.com | password |

Ganti password ini sebelum dipakai di luar lokal. Untuk produksi, buat akun admin lewat `php artisan tinker` atau seeder khusus.

## Mengubah isi website

- Identitas brand (nama, tagline, email, telepon, WhatsApp, Instagram, tahun berdiri, nama lini signature): variabel `COMPANY_*` di `.env`.
- Produk, stok, harga, gambar: lewat admin. Gambar contoh di `public/images/products/*.svg` tinggal diganti.
- Kategori, koleksi, toko: saat ini lewat `database/seeders/CatalogSeeder.php` (admin untuk ini belum dibuat).
- Teks halaman Tentang, Panduan ukuran, hero: `resources/views/shop/*.blade.php`.
- Warna dan font: `resources/css/app.css`. Font Cormorant Garamond dan Inter dimuat dari Google Fonts.

## Pemeriksaan

```bash
php artisan test        # 32 tes fitur: katalog, keranjang, checkout, stok, admin, login
vendor/bin/pint --test  # gaya kode
npm run build           # build aset
```

Tes lokal memakai SQLite in-memory (`phpunit.xml`). GitHub Actions (`.github/workflows/tests.yml`) menjalankannya dengan PostgreSQL 16.

## Struktur singkat

```
app/Http/Controllers/Shop/    HomeController, CatalogController, CartController, CheckoutController, PageController, ContactController
app/Http/Controllers/Admin/   DashboardController, ProductController, OrderController, MessageController
app/Http/Controllers/Auth/    LoginController
app/Http/Requests/            AddToCartRequest, CheckoutRequest, ProductRequest, ContactRequest, LoginRequest
app/Models/                   Category, Collection, Product, Store, Order, OrderItem, ContactMessage, User
app/Services/                 Cart (session), OrderService (transaksi pesanan, pesan WhatsApp)
app/Support/                  Rupiah + helper rupiah()
config/company.php            Identitas brand dari .env
database/seeders/             CatalogSeeder (katalog awal), DemoSeeder (data DEMO)
resources/views/shop/         Halaman toko
resources/views/admin/        Halaman admin
resources/views/components/   layouts/shop, layouts/admin, product-card, price, status-badge, dll.
resources/views/components/sections/  Section homepage: hero, featured-products, categories, new-arrivals, signature, lookbook, benefits
tests/Feature/                ShopPagesTest, CartCheckoutTest, AdminTest, AuthTest, ContactFormTest
```

## Rencana berikutnya

- Pembayaran online (Midtrans/Xendit) dan ongkir otomatis (RajaOngkir/Biteship).
- Admin kategori, koleksi, dan toko; multi gambar per produk.
- Akun pelanggan, riwayat pesanan, wishlist.
- Deployment (hosting belum dipilih).
