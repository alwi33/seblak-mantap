# Seblak Mantap — Sistem Pemesanan & Kasir Seblak (Laravel 13 + MySQL)

Paket file ini **bukan** project Laravel yang utuh (tidak ada folder `vendor/`, `bootstrap/cache`,
dsb). Ini adalah **file-file custom** yang tinggal kamu salin ke atas project Laravel baru yang kamu
buat sendiri lewat `composer create-project`. Ikuti langkah lengkap di chat/jawaban Claude untuk
urutan instalasi dari nol di Laragon.

## Isi paket ini

```
app/
  Http/Controllers/            -> controller pelanggan (menu, keranjang, checkout, pembayaran, cek status)
  Http/Controllers/Admin/      -> controller admin (login, dashboard, CRUD paket & kondimen, pesanan, pengaturan)
  Models/                      -> Paket, Kondimen, Pengaturan, Pemesanan, DetailPemesanan,
                                   DetailPemesananKondimen, Pembayaran
database/
  migrations/                  -> 7 migration tabel baru (pakets, kondimens, pengaturans, pemesanans,
                                   detail_pemesanans, detail_pemesanan_kondimen, pembayarans)
  seeders/                     -> data contoh: 1 akun admin, 6 paket seblak, 10 kondimen, 1 pengaturan toko
resources/views/
  layouts/                     -> layout pelanggan (app.blade.php) & admin (admin.blade.php)
  partials/                    -> navbar, footer, sidebar admin
  customer/                    -> halaman menu, keranjang, pembayaran QRIS, cek status
  auth/login.blade.php         -> halaman login admin
  admin/                       -> dashboard, CRUD paket, CRUD kondimen, pesanan masuk, pengaturan toko
routes/web.php                 -> SEMUA route (timpa file routes/web.php bawaan Laravel dengan ini)
public/css/style.css           -> tema warna merah-oranye di atas putih
public/images/no-image.svg     -> gambar placeholder kalau menu belum ada foto
```

## Cara pasang (ringkas)

1. Buat project baru: `composer create-project laravel/laravel nama-project`
2. Salin **isi** folder `app/`, `database/`, `resources/`, `routes/`, `public/` dari paket ini ke
   folder project barumu — **timpa** file `routes/web.php` bawaan, dan gabungkan (merge) folder
   lainnya (jangan hapus file bawaan Laravel yang lain seperti `app/Providers`, dst).
3. Atur `.env` supaya koneksi ke MySQL Laragon (lihat instruksi lengkap di chat).
4. `php artisan migrate`
5. `php artisan db:seed`
6. `php artisan storage:link` (wajib, supaya foto upload dari admin bisa tampil)
7. Buka project via Laragon (`http://nama-project.test`) atau `php artisan serve`.

## Akun admin default (dari seeder)

- Email: `admin@seblak.test`
- Password: `admin123`
- Login di: `/admin/login`

**Segera ganti password ini** lewat tabel `users` di phpMyAdmin/HeidiSQL setelah aplikasi jalan
(atau buat fitur ganti password sendiri sebagai pengembangan lanjutan).

## Menambahkan gambar menu lewat MySQL

Kolom `gambar` di tabel `pakets` / `kondimens` menyimpan **path relatif** terhadap
`storage/app/public/`. Dua cara mengisinya:

- **Lewat panel admin** (paling gampang): buka Kelola Paket / Kelola Kondimen → Edit → upload foto.
- **Manual lewat MySQL**: taruh file gambar di folder `storage/app/public/pakets/namafile.jpg`,
  lalu di phpMyAdmin/HeidiSQL isi kolom `gambar` pada baris terkait dengan nilai
  `pakets/namafile.jpg` (tanpa `storage/app/public/` di depannya). Pastikan sudah menjalankan
  `php artisan storage:link` supaya file itu bisa diakses lewat browser.

## Tentang QRIS

Pembayaran QRIS di sini bersifat **statis**: admin mengunggah satu gambar QRIS (dari GoPay/DANA/
OVO/ShopeePay/m-banking) lewat menu **Pengaturan Toko**, lalu pelanggan yang sudah scan & transfer
mengunggah bukti pembayaran, dan admin mengonfirmasi manual lewat menu **Pesanan Masuk**. Ini paling
cocok untuk UMKM tanpa akun payment gateway.

Kalau nanti mau QRIS otomatis-terverifikasi (dinamis, real-time), itu perlu integrasi terpisah ke
payment gateway seperti Midtrans / Xendit (perlu akun merchant + API key sendiri) — di luar cakupan
file ini, tapi struktur tabel `pembayarans` sudah bisa dikembangkan ke arah itu.
