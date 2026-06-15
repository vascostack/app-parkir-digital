# Sistem Informasi Manajemen Parkir Digital (CodeIgniter 4)

## Progres
Setup Project CodeIgniter 4 selesai
  Setup database & migration selesai
  Sistem autentikasi (Login & Register) selesai
  Multi role user (Admin & Petugas) sudah diterapkan
  Session login berhasil dibuat
  Redirect berdasarkan role user sudah berjalan
  Dashboard Admin & Petugas sudah tersedia (basic UI)

---

## Anggota Kelompok

1. Tegar Ananda  
2. Rani Salma Hakim  
3. Zahra Syafa Salsabila  
4. Habibah  
5. M. Vasco Al Ghazi  

---

## Teknologi yang Digunakan

- PHP 8.2+
- CodeIgniter 4
- MySQL / MariaDB
- Bootstrap 5
- SB Admin 2 Template
- JavaScript (Chart.js)
- Git & GitHub

---

## CARA MENJALANKAN PROJECT 

### 1. Clone Repository
```bash
git clone https://github.com/username/parkir-digital.git
cd parkir-digital

### 2. Install Dependency
```bash
composer install

### 3. Setup Environment
```bash
cp env .env

### 4. Konfigurasi Database di .env
```bash
database.default.hostname = localhost
database.default.database = parkir_digital
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi

### 5. Buat Database
```bash
CREATE DATABASE parkir_digital;

### 6. Jalankan Migration
```bash
php spark migrate

### 8. Jalankan Project
```bash
php spark serve
