# Panduan Instalasi dan Menjalankan Proyek Laravel

## 📥 Clone Repository

Pertama, clone repository ini ke dalam komputer lokal:

```sh
git clone https://github.com/darfianardiansyah/Laritta2.git
cd Laritta2
```

## ⚙️ Instalasi Dependensi

Setelah clone, jalankan perintah berikut untuk mengunduh dependensi Laravel:

```sh
composer install
```

## 🔑 Konfigurasi Aplikasi

1. Buat file `.env` dari `.env.example`:

    ```sh
    cp .env.example .env
    ```

    Jika menggunakan Windows (PowerShell):

    ```sh
    copy .env.example .env
    ```

2. **Generate application key:**
    ```sh
    php artisan key:generate
    ```

## 🛢️ Konfigurasi Database

1. Buat database baru sesuai dengan konfigurasi di `.env`.
2. Sesuaikan pengaturan di `.env`, contohnya:
    ```env
    DB_DATABASE=nama_database
    DB_USERNAME=root
    DB_PASSWORD=
    ```
3. Jalankan migrasi database:
    ```sh
    php artisan migrate
    ```

## 🚀 Menjalankan Aplikasi

Optimalkan aplikasi sebelum dijalankan:

```sh
php artisan optimize
```

Kemudian jalankan server:

```sh
php artisan serve
```

Aplikasi akan berjalan di `http://127.0.0.1:8000`.

---

## ❗ Troubleshooting

Jika ada masalah seperti file `vendor/` hilang, jalankan ulang:

```sh
composer install
```

Jika ada error saat migrasi database, coba hapus database dan buat ulang.

---

🎉 **Selamat mencoba dan selamat coding!** 🚀
