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


---


# LAMPIRAN A: Analisis Kompetitor dan Strategi Pengembangan

## 1. Studi Komparatif
Analisis ini membandingkan **Maunabung** dengan aplikasi sejenis, baik yang fokus pada UMKM (BukuWarung, Majoo) maupun Keuangan Pribadi (Personal Finance).

| Aspek | BukuWarung / Majoo (UMKM) | Aplikasi Personal Finance Umum | **Maunabung (Target)** |
| :--- | :--- | :--- | :--- |
| **Fokus** | Pencatatan Usaha, Stok, Kasir | Penganggaran, Pelacakan Pengeluaran | **Keuangan Pribadi & Target Tabungan** |
| **Kompleksitas** | Tinggi (Banyak fitur jualan/CRM) | Sedang - Tinggi | **Simpel, Bersih, Fokus Tujuan** |
| **Monetisasi** | Iklan Pinjaman, Langganan, Biaya Transaksi | Freemium / Iklan | **Gratis / Host Sendiri / Privasi Utama** |
| **Kelebihan** | Ekosistem Pembayaran Lengkap | Integrasi Bank | **Ringan, Estetik, Tanpa Iklan** |
| **Kekurangan** | Bloatware (banyak iklan pinjaman) | UI seringkali kaku/jadul | **Belum ada Multi-Akun & Goals** |

## 2. Keunggulan Kompetitif (USP)
1.  **"No-Bloatware" / Anti-Ribet**: Fokus murni pada kesehatan finansial pengguna tanpa gangguan tawaran pinjaman atau fitur POS yang tidak perlu.
2.  **Data Privacy & Ownership**: Database lokal/host-sendiri memberikan ketenangan pikiran bagi pengguna yang peduli privasi.
3.  **Modern Aesthetic**: Desain antarmuka yang *vibrant*, modern, dan menyenangkan (menggunakan glassmorphism/gradient) untuk menarik demografi muda.
4.  **Recurring Transactions Free**: Fitur pencatatan otomatis gratis, yang biasanya berbayar di aplikasi lain.

## 3. Analisis Kesenjangan & Rencana Implementasi

### A. Fitur Multi-Akun (Dompet)
*   **Masalah**: Bunda transaksi tercampur. Tidak membedakan uang tunai, bank, atau e-wallet.
*   **Status**: *Terimplementasi* (Skema diperbarui untuk menyertakan `accounts`).
*   **Langkah Selanjutnya**: Integrasi penuh di UI Transaksi.

### B. Fitur Tabungan Impian (Savings Goals)
*   **Masalah**: Sesuai nama "Maunabung", aplikasi belum memfasilitasi target menabung.
*   **Status**: *Terimplementasi* (Skema diperbarui untuk menyertakan `savings_goals`).

### C. Validasi Akuntansi (Integritas Akuntansi)
> *Kesenjangan Kritis dibandingkan Kompetitor (BukuWarung/Accurate)*
*   **Kompetitor**: Menggunakan standar Akuntansi Entri Ganda, validasi saldo otomatis, dan rekonsiliasi.
*   **Maunabung Saat Ini**: Entri tunggal (hanya catat transaksi). Rawan ketidakcocokan saldo antar akun vs riwayat transaksi.
*   **Rencana Implementasi**:
    1.  **Layanan Akuntansi**: Layer logika khusus untuk memvalidasi setiap transaksi.
    2.  **Cek Saldo**: Mekanisme `Aset = Kewajiban + Ekuitas` (versi sederhana: Total Masuk - Keluar = Saldo Saat Ini).
    3.  **Rekonsiliasi**: Fitur "Sesuaikan Saldo" yang mencatat selisih sebagai "Penyesuaian Biaya/Pemasukan" secara otomatis.

### D. Keamanan & Kepatuhan (Security & Compliance)
> *Kesenjangan Kritis untuk Kepercayan Pengguna*
*   **Masalah**: Data sensitif (deskripsi transaksi, PII) tersimpan *plain-text*. Backup manual dan tidak terenkripsi.
*   **Rencana Implementasi**:
    1.  **Enkripsi saat Diam**: Menggunakan AES-256 untuk kolom sensitif (misal: deskripsi transaksi privat, catatan audit).
    2.  **Audit Trail**: Mencatat *who, what, when, where* untuk setiap perubahan data (Anti-Fraud).
    3.  **Secure Backup**: Script otomatis untuk dump database + enkripsi arsip ZIP.
    4.  **Vulnerability Patching**: Implementasi strict CSP (Content Security Policy) dan validasi input berlapis.


---


# LAMPIRAN B: Laporan Validasi Akuntansi: Proyek Maunabung

**Tanggal:** 2025-12-16  
**Auditor:** Sistem Validasi Akuntansi Otomatis  
**Subjek:** Tinjauan Teknis & Logika Akuntansi  

---

## 1. Ringkasan Eksekutif

Aplikasi **Maunabung** menunjukkan tingkat kepatuhan yang tinggi terhadap logika akuntansi yang sesuai untuk sistem keuangan pribadi. Berbeda dengan aplikasi pencatat biasa berbasis CRUD, sistem ini menerapkan **Layer Layanan Akuntansi** khusus yang menegakkan properti AC (Atomicity dan Consistency) melalui transaksi database dan logika perhitungan yang ketat.

Sistem ini mengadopsi pendekatan **"Double-Entry Lite"**:
- **Transfer**: Secara fungsional entri ganda (Kredit Sumber, Debit Tujuan).
- **Pemasukan/Pengeluaran**: Secara fungsional entri tunggal di sisi buku besar, namun secara implisit entri ganda terkait persamaan Ekuitas (`Aset = Kewajiban + Ekuitas`).

**Peringkat Keseluruhan:** **A- (Sangat Baik)**  
Penggunaan `BCMath` untuk presisi, transaksi ACID untuk integritas, dan Jalur Audit (Audit Trail) menjadikan proyek ini unggul dibandingkan proyek hobi standar.

---

## 2. Verifikasi Kepatuhan & Logika

### 2.1. Integritas Entri Ganda (Persamaan Akuntansi)
Persamaan dasar `Aset = Kewajiban + Ekuitas` dipatuhi dengan baik.

| Jenis Transaksi | Implementasi Logika | Pelanggaran Akuntansi? | Catatan |
| :--- | :--- | :--- | :--- |
| **Pemasukan** | Menambah `Aset` (Saldo Akun). | **TIDAK** | Penambahan implisit pada Ekuitas. |
| **Pengeluaran** | Mengurangi `Aset` (Saldo Akun). | **TIDAK** | Pengurangan implisit pada Ekuitas. |
| **Transfer** | Mengurangi `Aset A`, Menambah `Aset B`. Perubahan Bersih = 0. | **TIDAK** | Transaksi seimbang sempurna. |
| **Penyesuaian** | Modifikasi langsung nilai `Aset`. | **Terverifikasi** | Ditangani via `reconcileBalance` yang membuat entri penyeimbang, bukan menimpa data secara destruktif. |

### 2.2. Presisi & Pembulatan
**Status:** **LULUS**  
Sistem saat ini menggunakan ekstensi PHP `BCMath` (contoh: `bcsub`, `bcmul`) untuk semua perhitungan moneter. Ini sepenuhnya menghilangkan kesalahan aritmatika floating-point yang umum ditemukan dalam implementasi JavaScript/PHP biasa (contoh: `0.1 + 0.2 != 0.3`).

### 2.3. Kepatuhan ACID (Integritas Data)
**Status:** **LULUS**  
Semua operasi debit/kredit dibungkus dalam `DB::beginTransaction()` dan `DB::commit()`.
- **Skenario:** Jika Transfer mengkredit Akun A tetapi gagal mendebit Akun B (misal: crash DB), seluruh transaksi akan dibatalkan (rollback). Sistem mencegah bug "mencetak uang" atau "uang hilang".

---

## 3. Analisis Kode (Temuan Spesifik)

### 3.1. `App\Services\AccountingService.php`
"Otak" dari sistem ini.
- **Kekuatan:**
    - **Pencatatan Audit**: Setiap mutasi mencatat `old_values` (nilai lama) dan `new_values` (nilai baru) secara terenkripsi. Sangat baik untuk akuntansi forensik.
    - **Logika Rekonsiliasi**: Fungsi `reconcileBalance` mendeteksi ketidakcocokan antara "Saldo Tersimpan" dan "Riwayat Transaksi" dengan benar. Ia menyelesaikannya dengan membuat **transaksi penyesuaian non-destruktif**, menjaga keaslian data historis pengguna.
    - **Validasi Input**: Transfer mewajibkan adanya akun Sumber dan Tujuan.

- **Pengamatan Minor:**
    - Logika tipe `Adjustment` menghitung selisih dan memasukkan transaksi agar *Riwayat* cocok dengan *Saldo Tersimpan* (atau sebaliknya tergantung perspektif). Ini adalah perilaku yang benar untuk aplikasi keuangan pribadi di mana laporan bank adalah "Sumber Kebenaran".

### 3.2. `App\Models\Transaction.php`
- **Pengamatan:**
    - Metode `getTotals` melakukan agregasi SQL mentah. Ini efisien namun terpisah dari logika `AccountingService`. Ini bertindak sebagai "View" data dan tidak mempengaruhi integritas.

---

## 4. Perbaikan Isu yang Terdeteksi (Update Status)

### 4.1. Integritas "Akun Terkait" (Risiko Constraint)
- **Isu Awal**: `SET NULL` saat penghapusan dapat merusak riwayat transfer.
- **Perbaikan Terimplementasi**: **YA**
- **Detail**: Membuat migrasi `001_accounting_hardening.sql` untuk menerapkan constraint foreign key `ON DELETE RESTRICT`. Pengguna kini dicegah menghapus akun yang memiliki riwayat transaksi aktif, memaksa pelestarian data.

### 4.2. Ketiadaan "Lock Date" (Tutup Buku)
- **Isu Awal**: Pengguna dapat mengubah tahun fiskal lalu, membatalkan validitas laporan.
- **Perbaikan Terimplementasi**: **YA** (via model `Settings`)
- **Detail**: Mengimplementasikan `checkLockDate` di `AccountingService`. Setiap upaya untuk `Create`, `Update`, atau `Delete` transaksi pada atau sebelum `lock_date` yang dikonfigurasi sekarang akan memicu pengecualian "Periode Akuntansi Ditutup".

### 4.3. Auditabilitas Penghapusan
- **Isu Awal**: Penghapusan keras (hard delete) menghapus sejarah.
- **Perbaikan Terimplementasi**: **YA** (Soft Deletes)
- **Detail**: 
    - Timestamp `deleted_at` ditambahkan ke skema.
    - Penghapusan Transaksi sekarang melakukan **Soft Delete** (catatan tetap ada di DB, dikecualikan dari query).
    - Saldo tetap dikembalikan (reverted) untuk menjaga kebenaran, tetapi transaksi yang "Dibatalkan" tetap ada untuk admin DB/audit.

---

## 5. Rekomendasi Akhir & Status Implementasi

| Rekomendasi | Status | Detail Implementasi |
| :--- | :--- | :--- |
| **Kebijakan Penghapusan Ketat** | ✅ **Terimplementasi** | Soft Deletes + Penegakan Lock Date. |
| **Pengerasan Skema** | ✅ **Terimplementasi** | `ON DELETE RESTRICT` diterapkan dalam skrip migrasi. |
| **Umpan Balik UI** | ✅ **Terimplementasi** | Rekonsiliasi otomatis sekarang menandai transaksi dengan prefiks `[SYSTEM CORRECTION]`. |

**Status Validasi**: **SEPENUHNYA PATUH**
*Sistem sekarang memenuhi standar akuntansi yang ketat untuk auditabilitas, integritas, dan konsistensi temporal.*
