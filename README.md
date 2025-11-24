# Maunabung - Aplikasi Keuangan Pribadi

Maunabung adalah aplikasi web manajemen keuangan pribadi yang modern, responsif, dan mudah digunakan. Dibangun dengan PHP murni (tanpa framework), MySQL, dan Bootstrap 5.

## Fitur Utama

*   **Manajemen Pengguna:** Registrasi, Login, dan Profil dengan preferensi mata uang.
*   **Dashboard Interaktif:** Ringkasan keuangan, grafik pengeluaran, dan aktivitas terbaru.
*   **Transaksi:** Catat pemasukan dan pengeluaran dengan mudah. Filter berdasarkan tanggal dan kategori.
*   **Kategori:** Kelola kategori pemasukan dan pengeluaran sesuai kebutuhan dengan label warna.
*   **Laporan:** Lihat ringkasan keuangan per periode dan ekspor data ke format CSV.
*   **Desain Modern:** Antarmuka yang bersih, responsif (mobile-friendly), dan estetis.

## Struktur Folder

```
maunabung/
├── app/
│   ├── Controllers/    # Logika aplikasi (Auth, Dashboard, Transaksi, dll)
│   ├── Core/           # Komponen inti (Database, Router, Model, View)
│   ├── Models/         # Interaksi database (User, Transaction, Category)
│   └── Views/          # Template HTML (Auth, Dashboard, dll)
├── config/             # Konfigurasi database
├── db/                 # Skema database (SQL)
├── public/             # Root direktori web
│   ├── assets/         # CSS, JS, Gambar
│   └── index.php       # Entry point aplikasi
└── README.md           # Dokumentasi ini
```

## Persyaratan Sistem

*   PHP >= 7.4
*   MySQL / MariaDB
*   Web Server (Apache/Nginx) atau PHP Built-in Server

## Instalasi

1.  **Clone atau Download** repositori ini.
2.  **Buat Database:**
    *   Buat database baru di MySQL bernama `maunabung`.
    *   Impor file `db/schema.sql` ke dalam database tersebut.
3.  **Konfigurasi Database:**
    *   Buka file `config/database.php`.
    *   Sesuaikan `username`, `password`, dan `dbname` jika berbeda.
4.  **Jalankan Aplikasi:**
    *   Buka terminal di folder root proyek.
    *   Jalankan perintah:
        ```bash
        php -S localhost:8000 -t public
        ```
    *   Buka browser dan akses `http://localhost:8000`.

## Prinsip Pengembangan (DRY & KISS)

*   **DRY (Don't Repeat Yourself):**
    *   Menggunakan kelas `Database` Singleton untuk koneksi database yang efisien.
    *   Kelas `View` helper untuk merender template dan menghindari duplikasi `include`.
    *   Layouts (`header.php`, `footer.php`) dipisahkan untuk digunakan kembali di setiap halaman.
    *   Logika validasi dan query database terpusat di Model.

*   **KISS (Keep It Simple, Stupid):**
    *   Routing sederhana tanpa library eksternal yang kompleks.
    *   Struktur MVC yang minimalis dan mudah dipahami.
    *   Penggunaan PHP murni untuk performa maksimal tanpa overhead framework.
    *   Desain UI menggunakan Bootstrap 5 untuk kecepatan pengembangan dan konsistensi.

## Keamanan

*   Password di-hash menggunakan `password_hash()` (Bcrypt).
*   Semua query database menggunakan **Prepared Statements** (PDO) untuk mencegah SQL Injection.
*   Validasi sesi di setiap controller yang membutuhkan otentikasi.
*   Sanitasi output menggunakan `htmlspecialchars()` untuk mencegah XSS.

---
Dibuat dengan ❤️ untuk manajemen keuangan yang lebih baik.
