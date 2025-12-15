# 📰 Laravel Content Management System Blog Platform

A modern **Content Management System (CMS)** built with **Laravel 12**, designed with a clean frontend and a powerful role-based admin panel.

---

## 🚀 Features Overview

### 👥 User Roles & Permissions

- **Admin**
  - Full access to dashboard
  - Manage articles, categories, comments, and contact messages
- **Editor**
  - Manage articles only (create, edit, publish, archive)
- **User**
  - Browse articles
  - Comment on articles (when enabled)

### 📝 Articles

- Create, edit, delete articles
- Rich text editor (TinyMCE)
- Article status: `draft`, `published`, `archived`
- Enable / disable comments per article
- Many-to-many relationship with categories

### 🗂 Categories

- Create and manage categories
- Filter articles by category

### 💬 Comments

- Only authenticated users can comment
- Comment status: `pending`, `approved`
- Admin moderation panel

### 📩 Contact Messages

- Public contact form
- Admin inbox with:
  - Read / Unread status
  - Search & filters

### 🎨 UI / UX

- Tailwind CSS
- Clean admin sidebar
- Responsive frontend
- Modern authentication pages (Login / Register)

---

## ⚙️ System Requirements

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL / MariaDB

---

## 🛠 Installation & Setup

### 1️⃣ Clone the repository

```bash
git clone <repository-url>
cd cms-blog
```

### 2️⃣ Install dependencies

```bash
composer install
npm install
npm run dev
```

### 3️⃣ Environment setup

```bash
cp .env.example .env
php artisan key:generate
```

Update `.env` with your database credentials.

### 4️⃣ Run migrations & seeders

```bash
php artisan migrate --seed
```

This will create:

- Tables
- Default users (Admin, Editor, User)
- Sample data

### 5️⃣ Create Storage Symlink (Important)

```bash
php artisan storage:link
```

### 6️⃣ Run the application

```bash
php artisan serve
```

Visit:

```
http://127.0.0.1:8000
```

---

## 🔐 Default Login Credentials

After running the seeder, you can log in using:

### 👑 Admin

- **Email:** `admin@example.com`
- **Password:** `Admin@1234`
- **Access:** Full Admin Panel

### ✍️ Editor

- **Email:** `editor@example.com`
- **Password:** `Editor@1234`
- **Access:** Articles Management Only

### 👤 User

- **Email:** `user@example.com`
- **Password:** `User@1234`
- **Access:** Frontend + Comments

---

## 🔀 Login Redirection Logic

- **Admin** → `/admin`
- **Editor** → `/admin/articles`
- **User** → `/`

---

## ✅ Completed Milestones

- ✔ Role-based access control (Admin / Editor / User)
- ✔ Clean Admin Dashboard with Sidebar
- ✔ Article Management with Rich Editor
- ✔ Category & Comment Management
- ✔ Secure Authentication (Laravel Breeze)
- ✔ Modern UI with Tailwind CSS

---

## 📌 Notes

- Editors **cannot** access admin-only sections.
- Users must be logged in to comment.
- Comments can be disabled per article.
- Admin has full moderation control.

---

## 🧑‍💻 Author

Built with ❤️ **Ali Dakkak**

---

Happy Coding! 🚀
