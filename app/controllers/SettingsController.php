<?php
class SettingsController
{
    public function index(): void
    {
        AuthMiddleware::handle(['Admin']);
        App::view('settings/index', ['settings' => (new Setting())->allKeyed()]);
    }

    public function save(): void
    {
        AuthMiddleware::handle(['Admin']);
        verify_csrf();

        $allowed = ['system_name', 'logo_path', 'timezone', 'default_language', 'theme'];
        $setting = new Setting();
        foreach ($allowed as $key) {
            $setting->upsert($key, trim((string)($_POST[$key] ?? '')));
        }

        (new AuditLog())->add((int)$_SESSION['user']['id'], 'update_settings', 'settings');
        flash('success', 'Settings updated.');
        App::redirect('settings');
    }
}
