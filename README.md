# Maunabung - Aplikasi Keuangan Pribadi

Maunabung adalah aplikasi web manajemen keuangan pribadi yang modern, responsif, dan mudah digunakan. Dibangun dengan PHP murni (tanpa framework), MySQL, dan Bootstrap 5.

## Fitur Utama

*   **Manajemen Pengguna:** Registrasi, Login, dan Profil dengan preferensi mata uang.
*   **Dashboard Interaktif:** Ringkasan keuangan, grafik pengeluaran, dan aktivitas terbaru.
*   **Transaksi:** Catat pemasukan dan pengeluaran dengan mudah. Filter berdasarkan tanggal dan kategori.
*   **Sistem Akuntansi Terverifikasi:** Menggunakan logika *Double-Entry Lite* dengan kepatuhan ACID untuk mencegah kesalahan saldo.
*   **Audit Trail:** Mencatat setiap perubahan data secara forensik untuk keamanan dan transparansi.
*   **Kategori:** Kelola kategori pemasukan dan pengeluaran sesuai kebutuhan dengan label warna.
*   **Laporan:** Lihat ringkasan keuangan per periode dan ekspor data ke format CSV.
*   **Desain Modern:** Antarmuka yang bersih, responsif (mobile-friendly), dan estetis.

## Struktur Folder

```
maunabung/
├── app/
│   ├── Controllers/    # Logika aplikasi (Auth, Dashboard, Transaksi, dll)
│   ├── Core/           # Komponen inti (Database, Router, Model, View)
│   ├── Models/         # Interaksi database (User, Transaction, Category, Settings)
│   ├── Services/       # Logika Bisnis (AccountingService - The Brain)
│   └── Views/          # Template HTML (Auth, Dashboard, dll)
├── config/             # Konfigurasi database
├── db/                 # Skema database (SQL)
│   └── migrations/     # File migrasi perubahan database
├── public/             # Root direktori web
│   ├── assets/         # CSS, JS, Gambar
│   └── index.php       # Entry point aplikasi
└── README.md           # Dokumentasi ini
```

## Persyaratan Sistem

*   PHP >= 7.4 (Direkomendasikan 8.1+)
*   MySQL / MariaDB (InnoDB Engine Wajib)
*   Web Server (Apache/Nginx) atau PHP Built-in Server
*   Ekstensi PHP: `pdo`, `bcmath` (Wajib untuk akurasi uang)

## Instalasi

1.  **Clone atau Download** repositori ini.
2.  **Buat Database:**
    *   Buat database baru di MySQL bernama `maunabung`.
    *   Impor file `db/schema.sql` ke dalam database tersebut.
    *   **PENTING**: Jalankan juga file migrasi `db/migrations/001_accounting_hardening.sql` untuk menerapkan standar keamanan akuntansi terbaru.
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

## Keamanan & Integritas Data

*   **ACID Compliance**: Semua transaksi keuangan dibungkus dalam *Database Transaction* atomik.
*   **Soft Deletes**: Transaksi yang dihapus tidak hilang permanen, melainkan ditandai "Void" untuk keperluan audit.
*   **Lock Date**: Mencegah perubahan data pada periode akuntansi yang sudah tutup buku.
*   **Audit Logging**: Siapa melakukan apa, kapan, dan di mana, tercatat di `audit_logs`.
*   **Sanitasi**: Password di-hash (Bcrypt), Prepared Statements untuk SQL Injection, dan sanitasi XSS.
*   **Rekonsiliasi**: Sistem mampu mendeteksi dan memperbaiki anomali saldo secara otomatis dengan jejak audit yang jelas.

---
Dibuat dengan ❤️ untuk manajemen keuangan yang lebih baik.
