# Budget

Aplikasi Budget adalah aplikasi manajemen keuangan berbasis web yang dibuat dengan Laravel. Aplikasi ini membantu Anda mencatat pemasukan, pengeluaran, mengelola budget bulanan/tahunan, memantau utang/piutang, serta menghasilkan laporan keuangan sederhana.

## Fitur Utama
- Manajemen akun/rekening
- Pencatatan transaksi pemasukan & pengeluaran
- Pengelolaan budget bulanan dan tahunan (pemasukan & pengeluaran)
- Monitoring sisa budget, sisa utang/piutang
- Notifikasi budget hampir habis & utang/piutang jatuh tempo
- Grafik tren pemasukan & pengeluaran
- Ekspor data ke Excel

## Cara Install (Windows/Laragon)
1. **Clone repository**
   ```bash
   git clone https://github.com/k21wangz/Budget.git
   cd Budget
   ```
2. **Install dependency PHP**
   ```bash
   composer install
   ```
3. **Copy file environment**
   ```bash
   copy .env.example .env
   ```
4. **Generate app key**
   ```bash
   php artisan key:generate
   ```
5. **Buat database**
   - Pastikan database SQLite sudah tersedia di `database/database.sqlite` (bisa buat file kosong jika belum ada)
6. **Jalankan migrasi dan seeder**
   ```bash
   php artisan migrate --seed
   ```
7. **Jalankan aplikasi**
   ```bash
   php artisan serve
   ```
   Akses aplikasi di http://localhost:8000

## Credit
Aplikasi ini dibuat oleh **Wawang Kurniawan**.

---

Aplikasi ini dibangun menggunakan [Laravel](https://laravel.com/) dan open source di bawah lisensi MIT.
