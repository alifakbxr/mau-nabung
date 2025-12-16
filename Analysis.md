# Analisis Kompetitor dan Strategi Pengembangan Aplikasi "Maunabung"

## 1. Studi Komparatif
Analisis ini membandingkan **Maunabung** dengan aplikasi sejenis, baik yang fokus pada UMKM (BukuWarung, Majoo)maupun Personal Finance.

| Aspek | BukuWarung / Majoo (UMKM) | Aplikasi Personal Finance Umum | **Maunabung (Target)** |
| :--- | :--- | :--- | :--- |
| **Fokus** | Pencatatan Usaha, Stok, Kasir | Budgeting, Expense Tracking | **Personal Finance & Savings Goal** |
| **Kompleksitas** | Tinggi (Banyak fitur jualan/CRM) | Sedang - Tinggi | **Simpel, Bersih, Fokus Tujuan** |
| **Monetisasi** | Iklan Pinjaman, Langganan, Fee Transaksi | Freemium / Iklan | **Free / Self-Hosted / Privacy First** |
| **Kelebihan** | Ekosistem Pembayaran Lengkap | Integrasi Bank | **Ringan, Estetik, Tanpa Iklan** |
| **Kekurangan** | Bloatware (banyak iklan pinjaman) | UI seringkali kaku/jadul | **Belum ada Multi-Akun & Goals** |

## 2. Keunggulan Kompetitif (USP)
1.  **"No-Bloatware" / Anti-Ribet**: Fokus murni pada kesehatan finansial pengguna tanpa gangguan tawaran pinjaman atau fitur POS yang tidak perlu.
2.  **Data Privacy & Ownership**: Database lokal/self-hosted memberikan ketenangan pikiran bagi pengguna yang peduli privasi.
3.  **Modern Aesthetic**: Desain antarmuka yang *vibrant*, modern, dan menyenangkan (menggunakan glassmorphism/gradient) untuk menarik demografi muda.
4.  **Recurring Transactions Free**: Fitur pencatatan otomatis gratis, yang biasanya berbayar di aplikasi lain.

## 3. Analisis Gap & Rencana Implementasi

### A. Fitur Multi-Akun (Wallets)
*   **Masalah**: Semua transaksi tercampur. Tidak membedakan uang tunai, bank, atau e-wallet.
*   **Status**: *Implemented* (Schema updated to include `accounts`).
*   **Next Step**: Integrasi penuh di UI Transaction.

### B. Fitur Tabungan Impian (Savings Goals)
*   **Masalah**: Sesuai nama "Maunabung", aplikasi belum memfasilitasi target menabung.
*   **Status**: *Implemented* (Schema updated to include `savings_goals`).

### C. Validasi Akuntansi (Accounting Integrity)
> *Gap Kritis dibandingkan Kompetitor (BukuWarung/Accurate)*
*   **Kompetitor**: Menggunakan Double-Entry Accounting standard, validasi saldo otomatis, dan rekonsiliasi.
*   **Maunabung Saat Ini**: Single-entry (hanya catat transaksi). Rawan ketidakcocokan saldo antar akun vs riwayat transaksi.
*   **Rencana Implementasi**:
    1.  **AccountingService**: Layer logika khusus untuk memvalidasi setiap transaksi.
    2.  **Balance Check**: Mekanisme `Assets = Liability + Equity` (versi sederhana: Total Inflow - Outflow = Current Balance).
    3.  **Reconciliation**: Fitur "Adjust Balance" yang mencatat selisih sebagai "Adjustment Expense/Income" secara otomatis.

### D. Keamanan & Kepatuhan (Security & Compliance)
> *Gap Kritis untuk Kepercayan Pengguna*
*   **Masalah**: Data sensitif (deskripsi transaksi, PII) tersimpan *plain-text*. Backup manual dan tidak terenkripsi.
*   **Rencana Implementasi**:
    1.  **Encryption at Rest**: Menggunakan AES-256 untuk kolom sensitif (misal: deskripsi transaksi privat, catatan audit).
    2.  **Audit Trail**: Mencatat *who, what, when, where* untuk setiap perubahan data (Anti-Fraud).
    3.  **Secure Backup**: Script otomatis untuk dump database + enkripsi arsip ZIP.
    4.  **Vulnerability Patching**: Implementasi strict CSP (Content Security Policy) dan validasi input berlapis.
