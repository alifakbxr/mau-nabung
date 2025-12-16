# Dokumentasi Teknis Master - Maunabung

**Dokumen Referensi Pengembangan Perangkat Lunak**  
**Versi:** 2.1 (Revisi Besar - Detail Teknis Granular)  
**Status:** Alpha / Active Development  
**Audience:** Developer, System Architect, Maintainer

---

## Daftar Isi
1.  [Pendahuluan & Filosofi](#1-pendahuluan--filosofi)
2.  [Spesifikasi Teknis](#2-spesifikasi-teknis)
3.  [Arsitektur Kernel Aplikasi (Core)](#3-arsitektur-kernel-aplikasi-core)
4.  [Struktur Direktori & Penjelasan Modul](#4-struktur-direktori--penjelasan-modul)
5.  [Protokol Integritas Data (Accounting Engine)](#5-protokol-integritas-data-accounting-engine)
6.  [Manajemen Keamanan (Security)](#6-manajemen-keamanan-security)
7.  [Database Blueprint (Schema)](#7-database-blueprint-schema)
8.  [Frontend & UX Architecture](#8-frontend--ux-architecture)
9.  [Manual Deployment & DevOps](#9-manual-deployment--devops)

---

## 1. Pendahuluan & Filosofi
**Maunabung** bukan sekadar pencatat pengeluaran. Ini adalah *Sistem Manajemen Aset Pribadi* yang dibangun dengan ketelitian setara perangkat lunak korporasi kecil.

**Prinsip Desain:**
1.  **Zero-Dependency Core**: Mengurangi penggunaan library pihak ketiga (vendor) untuk meminimalkan *supply-chain attacks* dan *bloat*.
2.  **Explicit over Implicit**: Kode ditulis secara eksplisit. Tidak ada "sihir" (magic methods) framework yang menyembunyikan alur logika.
3.  **Data Sovereignty**: Pengguna memiliki 100% data mereka. Tidak ada telemetri keluar.
4.  **Financial Correctness**: Mengadopsi prinsip akuntansi *Double-Entry (Lite)* di mana setiap debit/kredit tervalidasi.

---

## 2. Spesifikasi Teknis

### Server Environment (Requirements)
*   **OS**: Cross-platform (Linux/Ubuntu 20.04+, Windows 10/11, macOS).
*   **Web Server**:
    *   **Apache 2.4+**: Wajib mengaktifkan `mod_rewrite` untuk *pretty URLs*.
    *   **Nginx**: Memerlukan konfigurasi `try_files` di blok server.
    *   **PHP Built-in Sever**: Didukung untuk development (`php -S`).
*   **Runtime (PHP)**:
    *   Versi Minimum: **7.4**. Direkomendasikan: **8.1+**.
    *   Extensions Wajib: `pdo`, `pdo_mysql`, `openssl`, `json`, `mbstring`.
*   **Database**:
    *   MySQL 5.7+ atau MariaDB 10.4+.
    *   Storage Engine: **InnoDB** (Wajib untuk Transaction support).

---

## 3. Arsitektur Kernel Aplikasi (Core)
Aplikasi ini berjalan di atas framework kustom "Micro-MVC" (`app/Core`).

### 3.1. Routing Engine (`Router.php`)
Bertugas menerjemahkan URL menjadi panggilan fungsi.
*   **Mekanisme**: Membaca `$_SERVER['REQUEST_URI']`.
*   **Auto-Base Detection**: Secara cerdas mendeteksi apakah aplikasi berjalan di root domain (`example.com`) atau subfolder (`example.com/apps/maunabung`) tanpa konfigurasi manual.
*   **Dispatcher**: Melakukan instansiasi Controller dan mengeksekusi Method yang sesuai.
*   **Fallback**: Mengembalikan tampilan 404 jika rute tidak terdaftar.

### 3.2. Database Abstraction (`Database.php`)
*   **Pattern**: Singleton. Memastikan hanya ada satu koneksi database terbuka per request lifecycle.
*   **Driver**: PDO (PHP Data Objects).
*   **Error Mode**: Exception (melempar error keras jika query gagal).

### 3.3. Base Model (`Model.php`)
*   Menyediakan metode CRUD dasar: `findAll()`, `findById($id)`, `delete($id)`.
*   Memberikan akses properti `$this->db` ke semua child model.

### 3.4. Security Kernel (`Security.php`)
*   **Encryption**: Menggunakan `openssl_encrypt` dangan algoritma `AES-256-CBC`. IV (Initialization Vector) digenerate random setiap enkripsi dan disimpan bersama cipher text (format: `base64(ciphertext::iv)`).
*   **CSRF**: Token based protection. Token digenerate per sesi login (atau rotasi per request, configurable).
*   **XSS**: `esc()` wrapper memastikan semua output HTML ter-escape.

---

## 4. Struktur Direktori & Penjelasan Modul

```bash
maunabung/
├── app/                  # Logic Source Code
│   ├── Controllers/      # [Controller Layer] - Handling Input HTTP
│   │   ├── AuthController.php        # Otentikasi User
│   │   ├── TransactionController.php # CRUD (via AccountingService)
│   │   ├── DashboardController.php   # Agregasi Data Homepage
│   │   └── ...
│   ├── Core/             # [Kernel Layer] - Jangan diubah kecuali paham
│   ├── Models/           # [Data Layer] - Representasi Tabel DB
│   │   ├── Account.php   # Logika Saldo (Balance Logic)
│   │   ├── Transaction.php # Logika History
│   │   └── ...
│   ├── Services/         # [Business Logic Layer] - Kompleksitas Tinggi
│   │   └── AccountingService.php # "Otak" sistem akuntansi
│   └── Views/            # [Presentation Layer] - HTML/PHP Templates
│       ├── layouts/      # Header, Footer, Sidebar
│       ├── transactions/ # Folder per modul
│       └── ...
├── config/               # Konfigurasi Environment (DB Creds)
├── db/                   # Artefak Database (SQL Schema)
├── public/               # Publicly Accessible (Web Root)
│   ├── assets/           # Statics (CSS/JS/Img)
│   └── index.php         # Entry Point (Bootstrap)
├── utils/                # Script CLI (Backup, Maintenance)
└── backups/              # (Auto-generated) Folder hasil backup
```

---

## 5. Protokol Integritas Data (Accounting Engine)
Ini adalah modul paling kritis di `app/Services/AccountingService.php`.

### 5.1. Three-Phase Commit
Setiap mutasi data transaksi melewati 3 fasa:
1.  **Phase 1: Ledger Entry**
    *   Data transaksi dicatat di tabel `transactions`.
2.  **Phase 2: Balance Adjustment**
    *   Tabel `accounts` diperbarui (`balance = balance +/- amount`).
    *   Logika *Reversal* diterapkan jika ini adalah operasi Update/Delete (transaksi lama dibatalkan dulu efeknya).
3.  **Phase 3: Audit Logging**
    *   Snapshot data sebelum dan sesudah disimpan di `audit_logs` dalam format terenkripsi.

**Garansi ACID**: Ketiga fasa dibungkus `DB->beginTransaction()`. Kegagalan di tahap manapun memicu `rollBack()`.

### 5.2. Anomaly Detection
Metode `validateConfiguration($accountId)`:
*   Melakukan *Replay* seluruh transaksi historical.
*   Membandingkan `TOTAL(transactions)` vs `accounts.balance`.
*   Jika `delta != 0`, flag integritas merah diangkat (perlu rekonsiliasi).

---

## 6. Manajemen Keamanan (Security)

### 6.1. Audit Trail Forensik
Maunabung mencatat "Siapa melakukan Apa, Dimana, dan Kapan".
*   **Storage**: Tabel `audit_logs`.
*   **Observed Events**: Create, Update, Delete pada Transaksi dan Akun.
*   **Payload Encryption**: Kolom `old_values` dan `new_values` disimpan terenkripsi. DB Admin tidak bisa mengintip detail keuangan user tanpa kunci aplikasi.

### 6.2. Backup Strategy
Script `utils/backup.php` dirancang untuk ketahanan bencana.
*   **Dump**: Menggunakan binary `mysqldump` sistem.
*   **Encrypt-then-Store**: File .sql tidak pernah menyentuh disk lebih dari beberapa detik. Langsung dienkripsi dan .sql asli di-*shred*.
*   **Rotation**: Menjaga 5 backup terakhir (FIFO).

---

## 7. Database Blueprint (Schema)

### Relational Diagram (Textual)
*   `users` (1) <---> (N) `accounts` (Cascade Delete)
*   `users` (1) <---> (N) `transactions`
*   `categories` (1) <---> (N) `transactions` (Set Null on Delete)
*   `accounts` (1) <---> (N) `transactions` (Set Null on Delete)

### Tabel Kunci
*   **accounts**:
    *   `type`: ENUM('cash', 'bank', 'ewallet', 'investment'). Pembedaan tipe penting untuk masa depan (misal: investasi tidak likuid).
    *   `is_default`: Flag untuk akun utama saat transaksi cepat.
*   **transactions**:
    *   `transaction_date`: DATE. Terpisah dari `created_at` (TIMESTAMP) untuk memungkinkan input transaksi masa lalu (backdate).

---

## 8. Frontend & UX Architecture

### 8.1. Design System
*   **Framework**: Bootstrap 5 (CDN/Local).
*   **Custom CSS**: `assets/css/style.css` (jika ada) menimpa variabel Bootstrap.
*   **Icons**: Bootstrap Icons (BI) atau FontAwesome.

### 8.2. Struktur View
*   **Layouts**: `header.php` memuat meta tags, CSS link, dan Navbar. `footer.php` memuat Scripts dan Copyright.
*   **Partials**: View utama meng-include header/footer.
*   **Flash Messages**: Notifikasi sukses/gagal disimpan di `$_SESSION` dan dirender di `header.php` lalu dihapus (One-time read).

---

## 9. Manual Deployment & DevOps

### 9.1. Fresh Install
1.  Siapkan Database MySQL.
2.  Import `db/schema.sql`.
3.  Rename `config/database.example.php` -> `database.php`. Isi kredensial.
4.  Pastikan folder `backups/` memiliki permission Write (`chmod 755` atau `777` jika perlu).

### 9.2. Troubleshooting
*   **Error 500 / Blank Page**:
    *   Cek `display_errors` di php.ini.
    *   Pastikan driver mysql terinstall.
*   **404 Not Found pada Sub-halaman**:
    *   Pastikan `.htaccess` aktif jika pakai Apache.
    *   Jika Nginx, cek konfigurasi routing.
*   **Waktu/Jam Salah**:
    *   Set `date_default_timezone_set()` di `index.php` atau `php.ini`.

---
*End of Master Documentation*
