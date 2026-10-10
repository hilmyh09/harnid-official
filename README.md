# Hilmy Web

Website profil perusahaan, landing page, dan aplikasi web dengan login dalam satu aplikasi.
Dibangun dengan **Laravel 13**, **Blade**, **Tailwind CSS 4**, dan **PostgreSQL**.

## Fitur saat ini

- Halaman publik: Beranda (landing), Tentang, Layanan, Kontak.
- Formulir kontak tersimpan di database, dengan validasi, honeypot anti-spam, dan pembatasan laju (10 kiriman/menit per IP).
- Login dengan email dan password, pembatasan 5 kali percobaan gagal, serta logout.
- Dashboard terproteksi: ringkasan pesan masuk, daftar pesan dengan pagination, tandai sudah dibaca.
- Profil perusahaan (nama, tagline, email, telepon, alamat, WhatsApp) diatur lewat `.env`, tanpa mengubah kode.

## Kebutuhan

- PHP 8.3+ dengan ekstensi `pdo_pgsql`, `mbstring`, `intl`.
- Composer 2.
- Node.js 22+ dan npm.
- PostgreSQL 16 (versi lain kemungkinan besar juga bisa).

## Menjalankan di lokal

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
```

Buat database PostgreSQL lalu isi `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` di `.env`. Setelah itu:

```bash
php artisan migrate
php artisan db:seed --class=DemoSeeder   # opsional: akun dan pesan DEMO untuk lokal
npm run build                             # atau `npm run dev` saat mengembangkan tampilan
php artisan serve
```

Buka http://localhost:8000.

Akun DEMO (hanya dibuat oleh `DemoSeeder`, ditolak di lingkungan produksi):

| Email | Password |
|---|---|
| demo@example.com | password |

Ganti password ini sebelum dipakai di luar lokal.

## Mengubah isi website

- Identitas perusahaan: variabel `COMPANY_*` di `.env` (lihat `.env.example`).
- Teks halaman: `resources/views/pages/*.blade.php`.
- Daftar layanan: `App\Http\Controllers\PageController::serviceList()`.
- Warna dan gaya dasar: `resources/css/app.css`.

## Pemeriksaan

```bash
php artisan test        # tes fitur (halaman publik, form kontak, login, dashboard)
vendor/bin/pint --test  # gaya kode
npm run build           # build aset
```

GitHub Actions (`.github/workflows/tests.yml`) menjalankan ketiganya dengan PostgreSQL pada setiap push dan pull request.

## Struktur singkat

```
app/Http/Controllers/   PageController, ContactController, DashboardController, Auth/LoginController
app/Http/Requests/      ContactRequest, LoginRequest
app/Models/             User, ContactMessage
config/company.php      Profil perusahaan dari .env
database/migrations/    users, cache, jobs, contact_messages
database/seeders/       DatabaseSeeder (kosong), DemoSeeder (data DEMO)
resources/views/        components/ (layout, header, footer, kartu), pages/, auth/, dashboard/
tests/Feature/          PublicPagesTest, ContactFormTest, AuthTest
```

## Rencana berikutnya

- Registrasi/kelola pengguna dan reset password.
- Konten halaman dan layanan dikelola dari dashboard (CMS ringan).
- Upload logo dan gambar.
- Deployment (hosting belum dipilih).
