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
Kekurangan utama yang harus segera dipenuhi untuk bersaing:

### A. Fitur Multi-Akun (Wallets)
*   **Masalah**: Semua transaksi tercampur. Tidak membedakan uang tunai, bank, atau e-wallet.
*   **Implementasi**: 
    - Tambah tabel `accounts`.
    - Update tabel `transactions` untuk memiliki relasi ke `account_id`.
    - Fitur transfer antar akun.

### B. Fitur Tabungan Impian (Savings Goals)
*   **Masalah**: Sesuai nama "Maunabung", aplikasi belum memfasilitasi target menabung.
*   **Implementasi**:
    - Tambah tabel `savings_goals`.
    - Visualisasi progress bar untuk setiap goal.
    - Alokasi dana dari transaksi ke goal.

### C. Dashboard Informatif
*   **Masalah**: Halaman depan masih daftar transaksi biasa.
*   **Implementasi**:
    - Ringkasan total aset (Net Worth).
    - Grafik trend pengeluaran.
    - Status pencapaian goals.
