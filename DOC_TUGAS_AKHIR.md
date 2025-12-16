# MAUNABUNG: Rancang Bangun Sistem Manajemen Aset Pribadi Berbasis Prinsip Akuntansi Double-Entry Lite

**Draf Laporan Tugas Akhir**

---

## 1. Latar Belakang dan Tujuan Pengembangan

### 1.1. Latar Belakang
Pengelolaan keuangan pribadi seringkali menjadi tantangan bagi individu di era digital. Banyak aplikasi pencatat keuangan yang beredar di pasaran hanya menawarkan fungsi pencatatan sederhana (*expense tracking*) berbasis CRUD (*Create, Read, Update, Delete*) tanpa menerapkan prinsip akuntansi yang baku. Hal ini seringkali menyebabkan ketidakakuratan data, kesulitan dalam rekonsiliasi saldo nyata dengan catatan aplikasi, dan kurangnya integritas data historis.

Kebutuhan akan sebuah sistem yang tidak hanya mencatat tetapi juga menjamin kebenaran finansial (*financial correctness*) menjadi dasar pengembangan aplikasi **Maunabung**. Sistem ini dirancang untuk mengisi celah antara aplikasi pencatat pengeluaran sederhana dan perangkat lunak akuntansi korporasi yang kompleks.

### 1.2. Tujuan
Tujuan utama dari pengembangan aplikasi ini adalah:
1.  **Membangun Sistem Manajemen Aset Pribadi** yang menerapkan prinsip akuntansi standar (Double-Entry Lite) untuk menjamin validitas dan integritas data keuangan.
2.  **Menyediakan Platform Aman dan Privat** yang menjamin kedaulatan data pengguna (*Data Sovereignty*) tanpa ketergantungan pada pihak ketiga atau pelacakan data (telemetri).
3.  **Mengimplementasikan Arsitektur Perangkat Lunak yang Robust** dengan meminimalkan dependensi eksternal (*Zero-Dependency Core*) untuk keamanan dan kinerja yang optimal.
4.  **Menyediakan Fitur Auditabilitas** melalui mekanisme *Audit Trail* forensik untuk melacak setiap perubahan data secara transparan dan aman.

---

## 2. Deskripsi Aplikasi dan Ruang Lingkup Fungsional

**Maunabung** adalah aplikasi berbasis web yang berfungsi sebagai Sistem Manajemen Aset Pribadi. Aplikasi ini memungkinkan pengguna untuk mengelola berbagai akun keuangan (Kas, Bank, E-Wallet, Investasi) dalam satu platform terintegrasi.

### 2.1. Ruang Lingkup Fungsional
*   **Manajemen Multi-Akun**: Mendukung berbagai tipe akun aset dengan pelacakan saldo *real-time*.
*   **Pencatatan Transaksi Komprehensif**: Mendukung Pemasukan, Pengeluaran, dan Transfer antar akun.
*   **Akuntansi & Rekonsiliasi**: Fitur deteksi anomali dan penyesuaian saldo otomatis yang tercatat (*non-destructive adjustment*).
*   **Pelaporan & Dashboard**: Visualisasi kondisi keuangan melalui grafik dan ringkasan eksekutif.
*   **Manajemen Anggaran (Budgeting)**: (Fitur dalam pengembangan) Penetapan batas pengeluaran per kategori.

---

## 3. Arsitektur Sistem dan Alur Kerja

Aplikasi ini dibangun di atas arsitektur **Micro-MVC (Model-View-Controller)** kustom yang dirancang untuk kecepatan dan keamanan tinggi.

### 3.1. Komponen Arsitektur
1.  **Routing Engine (`Router.php`)**: Bertugas menerjemahkan permintaan HTTP (URL) menjadi eksekusi logika aplikasi. Mendukung deteksi otomatis basis URL dan penanganan *error* 404.
2.  **Controller Layer**: Menangani input pengguna, validasi awal, dan memanggil layanan bisnis yang sesuai.
3.  **Service Layer (Business Logic)**: Memuat logika bisnis kompleks, terutama `AccountingService` yang menjadi "otak" dari integritas data keuangan.
4.  **Model Layer**: Abstraksi interaksi data dengan basis data menggunakan PDO (*PHP Data Objects*).
5.  **View Layer**: Antarmuka pengguna yang dibangun menggunakan HTML5 dan template PHP murni untuk performa maksimal.

### 3.2. Alur Kerja Transaksi (Three-Phase Commit)
Setiap mutasi data keuangan melewati proses validasi tiga tahap untuk menjamin integritas ACID (*Atomicity, Consistency, Isolation, Durability*):

1.  **Fasa 1: Entry Ledger**: Data transaksi dicatat ke dalam tabel utama.
2.  **Fasa 2: Balance Adjustment**: Saldo akun terkait diperbarui secara atomik.
3.  **Fasa 3: Audit Logging**: Snapshot data sebelum dan sesudah perubahan disimpan dalam log audit terenkripsi.

Jika salah satu fasa gagal, seluruh operasi dibatalkan (*Rollback*) untuk mencegah data yang tidak konsisten.

---

## 4. Pemilihan Teknologi dan Alasannya

| Komponen | Teknologi | Alasan Pemilihan |
| :--- | :--- | :--- |
| **Backend** | PHP 7.4 / 8.1+ | Kematangan ekosistem, kemudahan deployment (*Write Once, Run Anywhere*), dan dukungan tipe data kuat pada versi terbaru. |
| **Database** | MySQL 5.7+ / MariaDB | Standar industri untuk basis data relasional, mendukung transaksi ACID (InnoDB) yang wajib untuk sistem keuangan. |
| **Server** | Apache / Nginx | Kompatibilitas luas dan ketersediaan di hampir semua penyedia hosting. |
| **Frontend** | Bootstrap 5, Vanilla JS | Pendekatan *no-build-tool* untuk kemudahan pemeliharaan, responsif, dan ringan tanpa *bloat* framework modern (React/Vue) yang tidak perlu untuk skala ini. |
| **Math Engine** | PHP BCMath | Menghindari kesalahan pembulatan *floating-point* yang fatal dalam perhitungan uang (presisi desimal arbitrer). |

---

## 5. Perancangan Basis Data dan Pengelolaan Data

Basis data dirancang menggunakan paradigma Relasional Ternormalisasi (3NF) untuk meminimalkan redundansi.

### 5.1. Skema Utama
*   **`users`**: Data identitas dan otentikasi pengguna.
*   **`accounts`**: Menyimpan entitas dompet/rekening dengan atribut `type` (Cash, Bank, dll) dan `balance` (saldo terhitung).
*   **`transactions`**: Buku besar utama yang mencatat setiap kejadian finansial. Memisahkan `created_at` (waktu input) dan `transaction_date` (waktu kejadian) untuk dukungan *backdating*.
*   **`audit_logs`**: Tabel forensik yang menyimpan log perubahan data sensitif.

### 5.2. Relasi dan Constraint
*   Relasi **One-to-Many** diterapkan antara User dan Akun/Transaksi.
*   **Foreign Key Constraints** dengan aksi `ON DELETE RESTRICT` diterapkan pada relasi Akun-Transaksi untuk mencegah penghapusan akun yang memiliki riwayat keuangan, menjaga integritas data historis.

---

## 6. Validasi dan Penerapan Prinsip Akuntansi

Aplikasi ini telah melalui proses validasi ketat berdasarkan standar akuntansi yang disesuaikan untuk personal finance (**Double-Entry Lite**).

### 6.1. Prinsip yang Diterapkan
1.  **Persamaan Dasar Akuntansi**: `Aset = Kewajiban + Ekuitas`. Setiap transaksi Pemasukan dan Pengeluaran secara implisit memengaruhi Ekuitas, sementara Transfer menjaga nilai Aset tetap seimbang (Net Change = 0).
2.  **Immutability (Kekekalan Data)**: Menerapkan fitur **"Lock Date"** (Tutup Buku) yang mencegah modifikasi atau penghapusan transaksi pada periode yang telah lewat/dilaporkan.
3.  **Non-Destructive Correction**: Koreksi saldo dilakukan melalui mekanisme **Rekonsiliasi**, bukan dengan mengubah data saldo secara langsung di database, melainkan dengan membuat transaksi penyesuaian (*Adjustment*) yang tercatat.

### 6.2. Soft Deletes
Penghapusan data transaksi menggunakan mekanisme **Soft Delete**. Data tidak benar-benar hilang dari basis data, melainkan hanya ditandai sebagai `deleted` dan dikecualikan dari perhitungan saldo aktif. Hal ini memungkinkan pemulihan data dan audit di masa depan.

---

## 7. Keamanan Sistem dan Pengendalian Data

Keamanan menjadi prioritas utama mengingat sensitivitas data keuangan.

### 7.1. Enkripsi dan Proteksi
*   **Enkripsi Data Diam (*At-Rest*)**: Data sensitif pada log audit (`old_values`, `new_values`) disimpan dalam format terenkripsi menggunakan algoritma **AES-256-CBC** dengan IV (*Initialization Vector*) yang unik per entri.
*   **Proteksi Web**: Implementasi token **CSRF** (*Cross-Site Request Forgery*) pada setiap formulir dan escaping output otomatis (`XSS Protection`) untuk mencegah serangan injeksi kode.

### 7.2. Strategi Cadangan (Backup)
Sistem dilengkapi modul *Backup & Disaster Recovery* mandiri:
*   Ekspor basis data otomatis menggunakan `mysqldump`.
*   File cadangan (.sql) langsung dienkripsi sebelum disimpan ke disk.
*   Mekanisme rotasi (retensi 5 file terakhir) untuk efisiensi penyimpanan.

---

## 8. Pengujian Sistem dan Hasil

Pengujian dilakukan menggunakan metode *White-Box Testing* (analisis logika kode) dan *Black-Box Testing* (validasi fungsional).

### 8.1. Hasil Validasi Akuntansi
Berdasarkan "Laporan Validasi Akuntansi (16 Des 2025)", sistem mendapatkan predikat **Sangat Baik (A-)** dengan poin validasi:
*   **Kepatuhan ACID**: **LULUS**. Sistem berhasil melakukan *rollback* total saat terjadi simulasi kegagalan di tengah proses transaksi.
*   **Presisi Aritmatika**: **LULUS**. Penggunaan `BCMath` terbukti menghilangkan anomali desimal pada perhitungan saldo.
*   **Audit Trail**: **LULUS**. Setiap perubahan data berhasil terlacak dengan detail forensik yang lengkap.

### 8.2. Pengujian Fungsional
Seluruh fitur utama (CRUD Transaksi, Manajemen Akun, Pelaporan) berjalan sesuai spesifikasi. Mekanisme pencegahan *human error* seperti validasi input negatif dan pencegahan transfer ke akun yang sama berjalan efektif.

---

## 9. Kesimpulan dan Saran

### 9.1. Kesimpulan
Aplikasi **Maunabung** berhasil dikembangkan sebagai solusi manajemen aset pribadi yang tidak hanya fungsional tetapi juga akuntabel. Dengan menerapkan arsitektur *Zero-Dependency* dan prinsip akuntansi *Double-Entry Lite*, aplikasi ini menawarkan keandalan data (*data integrity*) yang jauh di atas rata-rata aplikasi sejenis. Sistem ini siap digunakan sebagai alat bantu pengambilan keputusan finansial yang valid.

### 9.2. Saran Pengembangan Lanjutan
1.  **Modul Anggaran Lanjutan**: Mengembangkan fitur *budgeting* dengan notifikasi cerdas saat mendekati batas anggaran.
2.  **API untuk Integrasi Bank**: Menjajaki kemungkinan integrasi dengan *Open Banking API* untuk mutasi rekening otomatis (perlu kajian keamanan mendalam).
3.  **Aplikasi Seluler**: Mengembangkan antarmuka *Progressive Web App* (PWA) yang lebih matang agar terasa seperti aplikasi *native* di perangkat seluler.

---
*Dokumen ini disusun untuk memenuhi syarat Tugas Akhir.*
