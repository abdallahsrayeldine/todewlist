# ToDewList 📝

A **full-stack task management (Todo List) web app** built with **Laravel (backend)** and **Vue.js (frontend)**.
Manage your tasks: add, view, edit, delete, and track what you need to do — styled and powered by modern tools like **Tailwind/Vite** and built for learning full-stack development. ([GitHub][1])

---

## 🚀 What It Is

ToDewList is a simple productivity application where users can keep track of daily tasks. It demonstrates a real-world web app workflow:

* Laravel backend API for data storage and business logic
* Vue.js frontend for reactive UI
* Tailwind + Vite for modern styling and build tooling
* RESTful task management features

This project is a great example of combining Laravel and Vue to build a responsive full-stack app. ([GitHub][1])

---

## 📁 Project Structure

```
todewlist/
├── app/                   # Laravel backend logic (models, controllers)
├── bootstrap/             # Laravel bootstrap files
├── config/                # Configuration files
├── database/              # Migrations & seeders
├── public/                # Public assets (JS, CSS, images)
├── resources/
│   ├── js/                # Vue components & frontend entry
│   ├── css/               # Styles (Tailwind)
│   └── views/             # Laravel blade templates
├── routes/                # API and web route files
├── storage/               # Logs & generated files
├── tests/                 # Automated tests
├── .env.example           # Environment config template
├── composer.json          # PHP dependencies
├── package.json           # Node & frontend dependencies
├── vite.config.js         # Vite build config
├── tailwind.config.js     # Tailwind CSS config
└── README.md              # This file
```

This follows a typical **Laravel + Vue.js SPA structure**: backend logic lives in Laravel folders, while the reactive UI lives under `resources/js`. ([GitHub][1])

---

## 🧠 Core Features

* Add new tasks
* List all tasks
* Mark tasks as complete/important
* Delete tasks
* Reactive UI without page reloads
  (Backend API + Vue frontend).

---

## 🔧 Tech Stack

* **Backend:** Laravel (PHP) — REST API & data handling
* **Frontend:** Vue.js — UI components & reactive state
* **Styling:** Tailwind CSS
* **Build Tool:** Vite
* **Database:** MySQL / SQLite / PostgreSQL (configurable via `.env`)
* **Server:** PHP built-in / Laravel Sail / Apache / Nginx

---

## 📦 Getting Started

### 1) Clone the repository

```bash
git clone https://github.com/abdallahsrayeldine/todewlist.git
cd todewlist
```

### 2) Install backend deps

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Update `.env` with your database credentials.

### 3) Run migrations

```bash
php artisan migrate
```

### 4) Install frontend deps

```bash
npm install
```

### 5) Build & start dev servers

```bash
npm run dev      # compile assets
php artisan serve      # start backend
```

Now open your browser:

```
http://localhost:8000
```

You should see the Todo list app running. ([GitHub][1])

---

## 🧩 How It Works

### Backend (Laravel)

* Route definitions in `routes/`
* Controllers handle task CRUD
* Eloquent models map to **tasks** table
* Migrations define schema

### Frontend (Vue.js)

* Main entry: `resources/js/app.js`
* Components manage:

  * Task input
  * Task list display
  * Action handlers (add/delete)
* Vite bundles assets for dev & production

---

## 📌 Tips

* Ensure your database is configured before migrating.
* Tailwind utility classes make styling fast and responsive.
* You can run Laravel with **Sail** if Docker is preferred.

---

## 📖 Learning Resources

* Laravel & Vue tutorial pattern — API + SPA flow using Vite and Tailwind. ([GitHub][2])
* Vue.js reactive UI basics
* Laravel REST API controllers & routing

[1]: https://github.com/abdallahsrayeldine/todewlist.git "GitHub - abdallahsrayeldine/todewlist"
[2]: https://github.com/kevinmulugu/laravel-vuejs-todolist?utm_source=chatgpt.com "A Simple Todolist application using Laravel and Vue.js"
