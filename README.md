# Member Balance App

Project dibuat berdasarkan requirement tes teknis Fullstack Developer — Laravel + MySQL (MariaDB) dengan nilai tambah integrasi Redis untuk log/riwayat transaksi.

---

## 🚀 Features

### 🎯 Core Features

-   **Authentication (Login/Logout)**
-   **Member Management**
    -   Create member
    -   View member list
    -   Search member (name/email/phone)
    -   View member detail
-   **Balance Management**
    -   Topup saldo
    -   Deduction saldo (tidak boleh negatif)
    -   Protection against race-condition (SELECT FOR UPDATE)
-   **Transaction History**
    -   Riwayat transaksi resmi (topup/deduction)
    -   Pagination
    -   Filter by type
    -   Filter by date
-   **Redis-based Activity Logs**
    -   Disimpan di key `member:{id}:logs`
    -   Mencatat old_balance → new_balance
    -   Mencatat deskripsi, user admin, dan timestamp
    -   Dapat diakses dari halaman Member Detail
-   **Service Layer Architecture**
    -   `TransactionService` untuk business logic saldo
    -   `MemberService` untuk manajemen member

### 🔥 Bonus Features (Nilai Tambah)

-   **Modern UI**
    -   Basecoat UI + Tailwind CSS
    -   Custom responsive pagination
    -   Light/Dark mode toggle
    -   Dashboard-ready layout

---

## 🧱 Tech Stack

-   **Backend:** Laravel 12
-   **Database:** MariaDB / MySQL
-   **Cache / Logs:** Redis
-   **Frontend:** Blade + TailwindCSS + Basecoat UI + Alpine.js
-   **Auth:** Laravel Auth (session-based login)

---

## 🗂 Database Structure (ERD)

### **members**

| Field      | Type      | Description     |
| ---------- | --------- | --------------- |
| id         | BIGINT    | Primary key     |
| name       | VARCHAR   | Member name     |
| email      | VARCHAR   | Unique email    |
| phone      | VARCHAR   | Phone number    |
| balance    | BIGINT    | Current balance |
| created_at | TIMESTAMP |                 |
| updated_at | TIMESTAMP |                 |

### **transactions**

| Field       | Type                   | Description      |
| ----------- | ---------------------- | ---------------- |
| id          | BIGINT                 | Primary key      |
| member_id   | BIGINT                 | FK → members.id  |
| type        | ENUM(topup, deduction) | Transaction type |
| amount      | BIGINT                 | Amount           |
| description | TEXT                   | Optional note    |
| created_at  | TIMESTAMP              |                  |
| updated_at  | TIMESTAMP              |                  |

### Redis Keys

-   `member:{id}:logs` → audit trail per member
-   (opsional) `system:logs` → log global aplikasi

---

## 🔁 Transaction Flow

### **Topup Flow**

1. Lock member row (`SELECT FOR UPDATE`)
2. Hitung old_balance → new_balance
3. Update balance
4. Insert transaction SQL
5. Push log ke Redis list
6. Commit

### **Deduction Flow**

1. Lock member row
2. Validasi saldo cukup
3. Update balance
4. Insert transaction
5. Push log ke Redis

---

## 🧩 Project Structure (Simplified)

```
app/
 ├── Http/
 │    ├── Controllers/
 │    │     ├── DashboardController.php
 │    │     ├── MemberController.php
 │    │     └── TransactionController.php
 │    ├── Services/
 │    │     ├── MemberService.php
 │    │     └── TransactionService.php
 │    ├── Request/
 │    │     ├── LoginRequest.php
 │    │     ├── StoreMemberRequest.php
 │    │     ├── StoreDeductRequest.php
 │    │     └── StoreTopupRequest.php
 │
 │
 ├── Models/
 │    ├── Member.php
 │    └── Transaction.php
```

---

## 🛠 Installation

### 1. Clone repo

```
git clone <repo-url>
cd member-balance-app
```

### 2. Install dependencies

```
composer install
npm install
```

### 3. Setup environment

Copy `.env.example` ke `.env` lalu update:

```
DB_CONNECTION=mysql
DB_DATABASE=member_balance
DB_USERNAME=root
DB_PASSWORD=

REDIS_CLIENT=phpredis
```

### 4. Generate key

```
php artisan key:generate
```

### 5. Run migration & seed

```
php artisan migrate --seed
```

Seeder akan membuat 1 akun admin:

| Email              | Password     |
| ------------------ | ------------ |
| **admin@mail.com** | **password** |

Gunakan akun ini untuk login ke dashboard.

### 6. Run vite & server

```
npm run dev
php artisan serve
```

---

## 📚 Page Overview

| Page                      | Route                  | Description                     |
| ------------------------- | ---------------------- | ------------------------------- |
| Login                     | `/login`               | Login admin                     |
| Dashboard                 | `/dashboard`           | Overview (grafik bisa ditambah) |
| Member List               | `/members`             | List + search + pagination      |
| Member Detail             | `/members/{id}`        | Detail, transaksi, log          |
| Topup balance per member  | `/members/{id}/topup`  | Transaksi topup                 |
| Deduct balance per member | `/members/{id}/deduct` | Transaksi deduct                |
| Logs Per Member           | `/members/{id}/logs`   | Riwayat Redis saja              |

---

## 🔧 Service Layer

### **TransactionService**

-   Menangani topup/deduct
-   Menggunakan transaction DB
-   Sanitasi race-condition
-   Menulis log Redis lengkap

### **MemberService**

-   Buat member baru
-   Tuliskan “create_member” ke Redis

---

## 🧪 Example Redis Log

```json
{
    "action": "topup",
    "amount": 50000,
    "old_balance": 150000,
    "new_balance": 200000,
    "description": "Topup from admin",
    "transaction_id": 44,
    "by": "admin@mail.com",
    "time": "2025-11-21 16:30:55"
}
```

---

## 📌 Notes

-   Project ini dibuat sebagai implementasi dari studi kasus PDF.
-   Redis dipakai sebagai **nilai tambah**, bukan pengganti database utama.

---
