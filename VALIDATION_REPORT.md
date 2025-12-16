# Laporan Validasi Akuntansi: Proyek Maunabung

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
