# Sassa Support (XAMPP MVP)

## Why you were seeing "Index of /newsaas"
If Apache shows directory listing, your app entrypoint is not being executed.
This project now includes a root `index.php` fallback, so it can still boot even if rewrite rules are not active.

---

## Quick Start on XAMPP (Windows)

### 1) Put project in htdocs
Copy the folder to:
`C:\xampp\htdocs\newsaas`

### 2) Start Apache + MySQL
Open XAMPP Control Panel and start:
- Apache
- MySQL

### 3) Create database
Open phpMyAdmin:
`http://localhost/phpmyadmin`

Create DB:
`newsaas_support` (or keep `sassa_support`, just match config)

### 4) Import schema + seed
In phpMyAdmin, import in order:
1. `database/schema.sql`
2. `database/seed.sql`

### 5) Configure DB credentials
Edit:
`config/config.php`

Set DB block to match local MySQL:
```php
'db' => [
  'host' => '127.0.0.1',
  'port' => 3306,
  'name' => 'sassa_support',
  'user' => 'root',
  'pass' => '',
  'charset' => 'utf8mb4',
],
```

### 6) Open the app
Use one of these URLs:
- `http://localhost/newsaas/` ✅ recommended
- `http://localhost/newsaas/index.php`

The root route will auto-redirect:
- logged out -> `/login`
- logged in -> `/dashboard`

---

## Demo login
- Email: `admin@sassa.local`
- Password: `password123`

---

## If it still shows directory listing
1. Ensure `index.php` exists in project root (it does in this repo now).
2. In Apache config, ensure `DirectoryIndex index.php` includes php index.
3. Ensure `mod_rewrite` is enabled and `AllowOverride All` is set for `htdocs` if you want clean rewrites.
4. Restart Apache from XAMPP panel.

---

## Future channel integrations (ready endpoints)
- `/webhooks/whatsapp`
- `/webhooks/messenger`
- `/webhooks/instagram`
- `/webhooks/telegram`
- `/webhooks/email-parser`

These currently log payloads into `webhooks_log`. Later, add signature verification + normalization + provider-specific handlers in `WebhookController`.
