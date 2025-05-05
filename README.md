# 🏷️ Laravel Gudang App

![Build](https://img.shields.io/github/actions/workflow/status/username/nama-proyek/laravel.yml?branch=main)
![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)
![License](https://img.shields.io/github/license/username/nama-proyek)

Aplikasi manajemen gudang sederhana menggunakan Laravel 12 dengan dukungan UUID, relasi kategori-produk, dan seeder database otomatis.

---

## 🚀 Setup Proyek

### 1. Clone Repository

```bash
buat folder-dengan-nama-proyek-anda
masuk ke terminal
git clone https://github.com/miftahulmunir08/sistem-gudang.git
cd nama-proyek-anda
```

## 🔹 Part 2: Install Dependency
```bash
composer install
```

## 🔹 Part 3: Setting Key
```bash
php artisan key:generate
```

## 🔹 Part 4: Setting env
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gudang
DB_USERNAME=root
DB_PASSWORD=
```


## 🔹 Part 5: Setting env dan Konfigusai DB
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gudang
DB_USERNAME=root
DB_PASSWORD=
```

## 🔹 Part 6: Jalankan Migrasi dan Seeder
```bash
php artisan migrate
php artisan db::seed
```
## 🔹 Part 7: Jalankan Server Laravel
```bash
php artisan serve
```