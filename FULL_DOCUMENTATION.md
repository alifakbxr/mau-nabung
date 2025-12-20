# Dokumentasi Lengkap Fitur Maunabung

Maunabung adalah aplikasi manajemen keuangan pribadi yang dirancang untuk kesederhanaan, transparansi, dan keamanan data. Dokumen ini merangkum seluruh fitur yang tersedia dalam aplikasi, termasuk modul-modul lanjutan terbaru.

---

## I. Fitur Inti (Core Features)

Fitur-fitur dasar yang membangun fondasi sistem Maunabung.

### 1. Manajemen Akun & Keamanan
*   **Registrasi & Login**: Sistem otentikasi aman dengan hashing password (Bcrypt).
*   **Profil Pengguna**: Pengaturan profil dasar dan preferensi mata uang (IDR, USD, dll).
*   **Keamanan Data**: Perlindungan terhadap serangan umum seperti CSRF, XSS, dan SQL Injection.

### 2. Dashboard Keuangan
*   **Ringkasan Cepat**: Kartu statistik yang menampilkan Saldo Total, Pemasukan Bulan Ini, dan Pengeluaran Bulan Ini.
*   **Grafik Visual**: Visualisasi tren pengeluaran dan pemasukan untuk analisis cepat.
*   **Aktivitas Terbaru**: Daftar transaksi yang baru saja dilakukan.

### 3. Manajemen Transaksi (Double-Entry Lite)
*   **Pencatatan Transaksi**: Form intuitif untuk mencatat Pemasukan, Pengeluaran, dan Transfer.
*   **Riwayat Transaksi**: Tabel pencarian dan filter canggih berdasarkan tanggal dan kategori.
*   **Integritas Data**: Menggunakan prinsip akuntansi *Double-Entry* di belakang layar untuk memastikan saldo selalu akurat (ACID Compliant).

### 4. Manajemen Kategori & Akun
*   **Multi-Akun**: Dukungan untuk berbagai jenis akun (Dompet Tunai, Bank, E-Wallet, Kartu Kredit).
*   **Kategori Kustom**: Pengguna dapat membuat kategori pemasukan dan pengeluaran sendiri dengan label warna.

### 5. Laporan Dasar
*   **Laporan Bulanan**: Ringkasan pemasukan vs pengeluaran per periode.
*   **Ekspor Data**: Kemampuan untuk mengunduh riwayat transaksi dalam format CSV untuk analisis di Excel.

---

## II. Fitur Lanjutan (Baru)

Modul-modul baru yang ditambahkan untuk meningkatkan kemampuan analisis dan perencanaan keuangan pengguna.

### 1. Savings Goals & Dream Simulator (New)
Fitur untuk membantu pengguna merencanakan dan mencapai target impian mereka.
*   **Manajemen Target**: Buat target tabungan spesifik (misal: "Beli Laptop", "Liburan").
*   **Visualisasi Progress**: Pantau kemajuan tabungan dengan progress bar dan indikator warna.
*   **Dream Simulator (Kalkulator Impian)**:
    *   Fitur interaktif di halaman pembuatan target.
    *   Pengguna memasukkan "Harga Barang" dan "Kemampuan Nabung per Bulan".
    *   Sistem menghitung **estimasi waktu** dan **tanggal tercapai** secara otomatis.
*   **Alokasi Dana (Nabung)**: Tombol "Nabung" khusus pada setiap kartu target untuk mengalokasikan saldo secara virtual tanpa perlu membuat transfer manual yang rumit.

### 2. Smart Salary Allocator (New)
Asisten cerdas untuk distribusi gaji bulanan menggunakan prinsip keuangan populer **50/30/20**.
*   **Salary Wizard**: Antarmuka khusus untuk mencatat gaji bulanan.
*   **Kalkulator Otomatis**:
    *   Secara otomatis memecah gaji menjadi **50% Kebutuhan (Needs)**, **30% Keinginan (Wants)**, dan **20% Tabungan (Savings)**.
    *   Angka diperbarui secara *real-time* saat pengguna mengetik nominal gaji.
*   **One-Click Action**:
    *   Menyimpan transaksi "Pemasukan Gaji" ke akun pilihan.
    *   Secara otomatis mengalokasikan porsi **20% Tabungan** langsung ke *Savings Goal* yang dipilih pengguna dalam satu klik.

### 3. Audit Log Viewer (Forensik) (New)
Fitur transparansi tingkat tinggi untuk keamanan dan pelacakan kesalahan.
*   **Jejak Digital Lengkap**: Setiap aksi (Create, Update, Delete) di sistem dicatat.
*   **Detail Forensik**:
    *   **Who**: Siapa yang mengubah (Nama User).
    *   **When**: Kapan perubahan terjadi (Timestamp presisi).
    *   **What**: Perbandingan nilai **Sebelum** (Old Values) dan **Sesudah** (New Values).
*   **Transparansi Penghapusan**: Transaksi yang dihapus tetap terlacak di sini, mencegah manipulasi data yang tidak terdeteksi.

---

## III. Spesifikasi Teknis

*   **Backend**: PHP 7.4+ (Native/Vanilla, tanpa Framework berat).
*   **Database**: MySQL/MariaDB dengan InnoDB engine (Wajib untuk Transaksi ACID).
*   **Frontend**: HTML5, Bootstrap 5, Vanilla JavaScript.
*   **Arsitektur**: MVC (Model-View-Controller) dengan Service Layer untuk logika akuntansi.

---
*Dokumen ini diperbarui terakhir pada: <?= date('d F Y') ?>*
