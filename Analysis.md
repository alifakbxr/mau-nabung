# Analisis Kompetitor dan Strategi Pengembangan Aplikasi "Maunabung"

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
