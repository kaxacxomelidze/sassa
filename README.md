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


## Fix for "Page not found"
If you renamed project folder (example `newsaas`) but config URL still points to another path (example `/sassa`), routes can mismatch.

Do this:
1. Open `config/config.php`
2. Set:
   - `'app' => ['url' => 'http://localhost/newsaas', ...]`
3. Restart Apache
4. Open `http://localhost/newsaas/`

This project now also auto-detects base path from the running script, so it works even when folder name changes.


## Invalid credentials on fresh install
If login shows **Invalid credentials** right after setup, your `users` rows likely came from an older seed hash.

Run this SQL in phpMyAdmin to reset demo users to `password123`:

```sql
UPDATE users
SET password_hash = '$2y$12$ZDT05TrZgvY1UvGaqCkh3O/DTLX5vBRO6222N9wl9.3Ki6HzOCabi'
WHERE email IN ('admin@sassa.local','lead@sassa.local','agent@sassa.local');
```

Then login with:
- `admin@sassa.local` / `password123`

You can also drop database and re-import `database/schema.sql` then updated `database/seed.sql`.


## API Integrations system
A full **Integrations** module is available in admin panel:
- Open: `/integrations`
- Create integration profiles for: WhatsApp, Messenger, Instagram, Telegram, Email, Website Chat
- Save API base URL, API key, secret, access token, webhook verify token, webhook URL, and extra JSON config
- Link an integration to an inbox

### If your DB was created before this feature
Run this SQL once:
```sql
CREATE TABLE channel_integrations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  channel_type VARCHAR(50) NOT NULL,
  name VARCHAR(120) NOT NULL,
  inbox_id INT NULL,
  api_base_url VARCHAR(255) NULL,
  api_key VARCHAR(255) NULL,
  api_secret VARCHAR(255) NULL,
  access_token TEXT NULL,
  webhook_verify_token VARCHAR(255) NULL,
  webhook_url VARCHAR(255) NULL,
  config_json JSON NULL,
  is_active TINYINT(1) DEFAULT 1,
  last_test_status VARCHAR(20) NULL,
  last_test_message VARCHAR(255) NULL,
  last_test_at TIMESTAMP NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (inbox_id) REFERENCES inboxes(id)
);
```

If table already exists from old version, run:
```sql
ALTER TABLE channel_integrations
  ADD COLUMN last_test_status VARCHAR(20) NULL,
  ADD COLUMN last_test_message VARCHAR(255) NULL,
  ADD COLUMN last_test_at TIMESTAMP NULL;
```


### Where to get API credentials
Use this mapping when filling `/integrations`:

- **WhatsApp Cloud API (Meta Developers)**
  - API Key/App ID: Meta App ID
  - API Secret: Meta App Secret
  - Access Token: WhatsApp token
  - Webhook URL: `https://your-domain.com/webhooks/whatsapp`
  - Config JSON example: `{"phone_number_id":"123456"}`

- **Facebook Messenger (Meta Developers)**
  - API Key/App ID: Meta App ID
  - API Secret: Meta App Secret
  - Access Token: Page Access Token
  - Webhook URL: `https://your-domain.com/webhooks/messenger`
  - Config JSON example: `{"page_id":"987654"}`

- **Instagram Messaging (Meta Developers)**
  - API Key/App ID: Meta App ID
  - API Secret: Meta App Secret
  - Access Token: Instagram Graph token
  - Webhook URL: `https://your-domain.com/webhooks/instagram`

- **Telegram (BotFather)**
  - Access Token: bot token from BotFather
  - API Base URL: `https://api.telegram.org`
  - Webhook URL: `https://your-domain.com/webhooks/telegram`

- **Email provider (Mailgun/SendGrid/Postmark)**
  - API Key / Access Token from provider dashboard
  - Webhook URL: `https://your-domain.com/webhooks/email-parser`

> Note: provider webhooks require a public HTTPS URL (use ngrok/cloudflare tunnel for local testing).


## Management modules
New admin management pages:
- `/users` (Admin only): create users, assign roles, activate/deactivate accounts
- `/settings` (Admin only): update system name, logo path, timezone, language, and theme
- `/integrations` (Admin/Supervisor): manage API credentials/webhooks and run readiness tests


## Production readiness checklist (real server)
Before connecting real provider APIs:

1. **Set app key for encryption** in `config/config.php`:
   - `app.key = base64:<32-byte-random-base64>`
2. Force HTTPS on your domain and use HTTPS webhook URLs.
3. Restrict DB user permissions (no root in production).
4. Set firewall rules so only required ports are open.
5. Run `/health` for uptime monitoring.
6. Backup DB daily and rotate API tokens regularly.

### Generate a strong app key
Run:
```bash
php -r "echo 'base64:' . base64_encode(random_bytes(32)) . PHP_EOL;"
```
Paste into:
```php
'app' => [
  // ...
  'key' => 'base64:YOUR_GENERATED_KEY'
]
```

## Webhook verification support
For Meta channels (WhatsApp/Messenger/Instagram), the app now supports GET verification challenge:
- `GET /webhooks/whatsapp`
- `GET /webhooks/messenger`
- `GET /webhooks/instagram`

The verify token is matched against Integration `webhook_verify_token`.

## Security note for integration secrets
`api_secret` and `access_token` are encrypted at rest before storing in database.
If you change `app.key`, previously stored secrets cannot be decrypted, so rotate/re-save credentials after key change.


## Facebook/Messenger app review URLs
Use these public URLs in Meta App Dashboard:
- Privacy Policy URL: `https://your-domain.com/privacy-policy`
- Terms of Service URL: `https://your-domain.com/terms-of-service`

For local testing only:
- `http://localhost/sassa/privacy-policy`
- `http://localhost/sassa/terms-of-service`
