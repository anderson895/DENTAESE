# DentaEase

A web-based dental management system built with **Laravel**.

---

## Requirements

* PHP >= 8.1
* Composer
* MySQL / MariaDB
* Node.js & NPM (optional, for frontend assets)
* Web server (Apache / Nginx)

---

## Local Setup

1. Clone the repository

   ```bash
   git clone <repository-url>
   cd dentaease
   ```

2. Install dependencies

   ```bash
   composer install
   npm install && npm run build
   ```

3. Environment configuration

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Configure database in `.env`

5. Run migrations

   ```bash
   php artisan migrate
   ```

6. Create storage symlink

   ```bash
   php artisan storage:link
   ```

7. Run the application

   ```bash
   php artisan serve
   ```

The app will be available at:

```
http://127.0.0.1:8000
```

---

## Deployment (Shared Hosting / Hostinger)

> **Note:** Make sure Laravel is installed **outside** `public_html` for security.

### Storage Symlink Fix

If images/files are not loading, remove the existing storage folder and recreate the symlink manually.

```bash
rm -rf public/storage
ln -s ../storage/app/public public/storage
```

Verify symlink:

```bash
ls -l public | grep storage
```

Expected output:

```text
storage -> ../storage/app/public
```

---

## Common Issues

### 403 Forbidden Error

* Ensure `public_html` points to Laravel's `public` directory
* Check folder permissions:

  ```bash
  chmod -R 755 storage bootstrap/cache
  ```

### Images Not Showing

* Make sure `APP_URL` in `.env` is correct
* Verify storage symlink exists

---

## Tech Stack

* **Backend:** Laravel
* **Frontend:** Blade, Tailwind CSS
* **Database:** MySQL

---

## Author

**DentaEase Team**

---

## License

This project is for academic / internal use.
