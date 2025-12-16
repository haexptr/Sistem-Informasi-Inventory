# Sistem Informasi Inventory

## Panduan Push ke GitHub (Untuk Pemilik Project)
Jika ini pertama kali kamu mengupload project ini ke GitHub, ikuti langkah berikut:

1.  **Buat Repository Baru**: Buka GitHub, buat repository baru (pilih "Public" atau "Private"), jangan centang "Add a README".
2.  **Buka Terminal**: Buka CMD atau Git Bash di folder project ini.
3.  **Jalankan Perintah**:
    ```bash
    git init
    git add .
    git commit -m "Upload pertama sistem inventory"
    
    # Ganti URL di bawah dengan URL repository GitHub barumu
    git remote add origin https://github.com/USERNAME_GITHUB/NAMA_REPO.git
    
    git push -u origin main
    ```
    *Catatan: Folder `vendor`, `node_modules`, dan file `.env` otomatis DIBAIKAN oleh git (tidak akan terupload) agar repository tetap bersih dan aman.*

---

## Panduan Instalasi (Untuk Teman/Developer Baru)
Ikuti panduan ini jika kamu baru pertama kali menjalankan project ini di komputermu.

### 1. Prasyarat (Wajib Install Dulu)
Pastikan aplikasi berikut sudah terinstall di laptopmu:
*   [**XAMPP**](https://www.apachefriends.org/) (untuk Database MySQL & PHP).
*   [**Composer**](https://getcomposer.org/download/) (untuk install library PHP).
*   [**Node.js**](https://nodejs.org/) (untuk build tampilan/frontend).
*   [**Git**](https://git-scm.com/downloads) (untuk clone project).

### 2. Download Project
Arahkan terminal ke folder tujuan (misal `Desktop` atau `htdocs`), lalu clone:
```bash
git clone https://github.com/USERNAME_GITHUB/NAMA_REPO.git
cd sistem-informasi-inventory
```

### 3. Install Library
Install semua "bahan" yang diperlukan project ini.
```bash
# 1. Install Library PHP (tunggu sampai selesai)
composer install

# 2. Install Library Javascript
npm install
```

### 4. Setup File Environment
Copy file settingan default dan buat kunci keamanan baru.
```bash
# Copy file .env.example menjadi .env
copy .env.example .env

# Generate Application Key
php artisan key:generate
```

### 5. Setup Database
1.  Buka **XAMPP Control Panel**, Start **Apache** dan **MySQL**.
2.  Buka browser ke [http://localhost/phpmyadmin](http://localhost/phpmyadmin).
3.  Buat database baru dengan nama `inventory` (atau nama lain bebas).
4.  Buka file `.env` di folder project ini, edit bagian database:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=inventory  <-- Sesuaikan nama db yang tadi dibuat
    DB_USERNAME=root       <-- Default XAMPP biasanya root
    DB_PASSWORD=           <-- Default XAMPP biasanya kosong
    ```

### 6. Migrasi & Seed Data
Ini akan membuat tabel-tabel di database dan membuat akun login admin otomatis.
```bash
php artisan migrate --seed
```

### 7. Jalankan Aplikasi
Lakukan build tampilan dulu (wajib untuk Laravel dengan Vite):
```bash
npm run build
```
Kemudian jalankan server Laravel:
```bash
php artisan serve
```

### 8. Login
Buka browser dan akses alamat yang muncul (biasanya [http://127.0.0.1:8000](http://127.0.0.1:8000)).

**Akun Login Default:**
*   **Email:** `test@example.com`
*   **Password:** `password`
