# Sassa Support (XAMPP MVP)

## Default Login
- Email: `admin@sassa.local`
- Password: `password123`

## XAMPP Setup
1. Copy project into `htdocs/sassa`.
2. Create database `sassa_support` in phpMyAdmin.
3. Import `database/schema.sql` then `database/seed.sql`.
4. Update `config/config.php` DB credentials.
5. Enable Apache `mod_rewrite` and ensure `.htaccess` is allowed.
6. Open `http://localhost/sassa/login`.

## Future channel integrations
Use webhook endpoints:
- `/webhooks/whatsapp`
- `/webhooks/messenger`
- `/webhooks/instagram`
- `/webhooks/telegram`
- `/webhooks/email-parser`

Each currently stores payload in `webhooks_log`. Replace `WebhookController` placeholder handlers with channel-specific verification, signature validation, message normalization and enqueue workers.
