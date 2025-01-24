# Hospitect - Final Project Pemrograman Web Semester 3

Hospitect adalah sebuah aplikasi berbasis web yang dikembangkan sebagai proyek akhir praktikum Pemrograman Web Semester 3. Aplikasi ini dirancang untuk membantu pengelolaan rumah sakit dengan fitur-fitur yang mendukung efisiensi dan pengelolaan data.

## Overview Proyek
Sistem ini adalah solusi digitalisasi rumah sakit yang dirancang untuk mengelola operasional rumah sakit dengan lebih efisien melalui peran Admin, Dokter, dan Pasien. Berikut adalah deskripsi singkat setiap peran:
- **Admin**: Memiliki akses penuh untuk mengelola pengguna, data obat, jadwal, dan laporan operasional.
- **Dokter**: Dapat mengakses dan memperbarui rekam medis pasien, memberikan diagnosis, menuliskan resep, serta mengatur jadwal konsultasi.
- **Pasien**: Dapat melihat jadwal konsultasi, mengakses riwayat rekam medis, serta memeriksa status resep dan riwayat perawatan.

## Fitur Utama
### CMS Modules
1. **User Management**:
   - **List Users**: Menampilkan seluruh pengguna (Admin, Dokter, Pasien).
   - **Create User**: Tambah pengguna baru dengan validasi data (Username, Email, Password, Role).
   - **Edit User**: Ubah data pengguna dengan validasi.
   - **Delete User**: Admin dapat menghapus data pengguna.

2. **Medicine Management**:
   - **List Medicines**: Menampilkan daftar obat dengan status stok.
   - **Create Medicine**: Tambah data obat (Nama, Deskripsi, Tipe, Stok, Gambar).
   - **Edit Medicine**: Ubah informasi obat dengan validasi.
   - **Delete Medicine**: Admin dapat menghapus obat.

3. **Medical Records Management**:
   - **List Medical Records**: Dokter dapat melihat riwayat medis pasien.
   - **Create Medical Record**: Tambah rekam medis dengan data pasien, dokter, obat, tindakan medis, dan tanggal berobat.
   - **Edit Medical Record**: Ubah data rekam medis.
   - **Delete Medical Record**: Dokter hanya bisa menghapus rekam medis yang dibuat sendiri.

### Layout Requirements
1. **Login/Register Page**:
   - Login untuk Admin, Dokter, dan Pasien.
   - Register hanya untuk akun Pasien.
2. **Dashboard**:
   - **Admin**: Menampilkan total pengguna, daftar dokter yang bertugas.
   - **Dokter**: Menampilkan pasien terbaru yang diperiksa.
   - **Pasien**: Menampilkan tindakan medis dan obat yang diberikan.
3. **Profile Management**:
   - Admin, Dokter, dan Pasien dapat memperbarui informasi pribadi.

### Advanced Features (Optional Upgrades)
- **Appointment Scheduling System**: Penjadwalan konsultasi antara pasien dan dokter.
- **Feedback System**: Ulasan dan rating dari pasien.
- **Filter and Sorting**: Sorting nama dokter dan obat.

## Teknologi yang Digunakan
- **Framework**: Laravel 10
- **Database**: MySQL
- **Frontend**: Blade Template Engine, Bootstrap 5
- **Server Requirements**:
  - PHP >= 8.1
  - Composer
  - Web server (Apache/Nginx)

## Instalasi dan Penggunaan

### 1. Clone Repository
```bash
git clone https://github.com/xebec51/Hospitect-FinalProject-Pemrograman-Web.git
cd Hospitect-FinalProject-Pemrograman-Web
```

### 2. Jalankan XAMPP
Pastikan XAMPP dijalankan, dan aktifkan Apache serta MySQL. Pastikan database telah dibuat dengan nama `Hospitect`.

### 3. Install Dependencies
Pastikan Composer telah terinstall pada komputer Anda.
```bash
composer install
```

### 4. Setup Environment File
Buat file `.env` dari template `.env.example` dan sesuaikan konfigurasi database Anda:
```bash
cp .env.example .env
```
Lalu edit file `.env`:
```
DB_DATABASE=Hospitect
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Generate Key
```bash
php artisan key:generate
```

### 6. Migrasi dan Seed Database
Jalankan perintah berikut untuk membuat tabel dan mengisi data awal di database:
```bash
php artisan migrate
php artisan db:seed
```
**Catatan:** Setelah menjalankan seeder, Anda dapat menggunakan akun berikut untuk login sebagai Admin:
- **Email**: admin@hospitect.com
- **Password**: password123

Semua akun awal yang dibuat melalui seeder (Admin, Dokter, dan Pasien) memiliki password default: `password123`. Daftar lengkap akun dapat dilihat dengan login menggunakan akun Admin.

### 7. Menjalankan Aplikasi
Jalankan server development Laravel:
```bash
php artisan serve
```
Akses aplikasi di `http://localhost:8000`.

## Struktur Folder Utama
- **app/**: Berisi logika aplikasi.
- **resources/**: Berisi view dan aset frontend.
- **routes/**: Berisi file routing aplikasi.
- **database/**: Berisi migrasi dan seeder database.

## Kontributor
- **Nama**: Muh. Rinaldi Ruslan

## Lisensi
Proyek ini dilisensikan di bawah [MIT License](LICENSE).

## Kontak
Jika Anda memiliki pertanyaan atau masukan terkait proyek ini, silakan hubungi saya melalui:
- **Email**: rinaldi.ruslan51@gmail.com
- **LinkedIn**: [linkedin.com/in/rinaldiruslan](https://www.linkedin.com/in/rinaldiruslan)
- **GitHub**: [github.com/rinaldiruslan](https://github.com/rinaldiruslan)
- **Instagram**: [instagram.com/rinaldiruslan](https://www.instagram.com/rinaldiruslan)

---
Terima kasih telah mengunjungi repository ini!
