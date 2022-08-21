<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\UserRole;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // General
        if (Setting::where('key', 'app_url')->count() === 0) {
            $setting = new Setting();
            $setting->key = 'app_url';
            $setting->value = env('APP_URL', 'http://localhost');
            $setting->is_env = true;
            $setting->save();
        }
        if (Setting::where('key', 'app_name')->count() === 0) {
            $setting = new Setting();
            $setting->key = 'app_name';
            $setting->value = env('APP_NAME', 'Laradesk');
            $setting->is_env = true;
            $setting->save();
        }
        if (Setting::where('key', 'app_https')->count() === 0) {
            $setting = new Setting();
            $setting->key = 'app_https';
            $setting->value = env('APP_HTTPS', false);
            $setting->is_env = true;
            $setting->save();
        }
        // SEO
        if (Setting::where('key', 'meta_home_title')->count() === 0) {
            $setting = new Setting();
            $setting->key = 'meta_home_title';
            $setting->value = env('APP_NAME', 'Laradesk').' - Helpdesk ticketing system';
            $setting->save();
        }
        if (Setting::where('key', 'meta_keywords')->count() === 0) {
            $setting = new Setting();
            $setting->key = 'meta_keywords';
            $setting->value = 'dashboard,laravel,vue,tailwindcss,spa';
            $setting->save();
        }
        if (Setting::where('key', 'meta_description')->count() === 0) {
            $setting = new Setting();
            $setting->key = 'meta_description';
            $setting->value = 'A simple and clean platform that allows users to create tickets and get support from your staff';
            $setting->save();
        }
        // Appearance
        if (Setting::where('key', 'app_icon')->count() === 0) {
            $setting = new Setting();
            $setting->key = 'app_icon';
            $setting->value = 'default';
            $setting->save();
        }
        if (Setting::where('key', 'app_background')->count() === 0) {
            $setting = new Setting();
            $setting->key = 'app_background';
            $setting->value = 'default';
            $setting->save();
        }
        // Localization
        if (Setting::where('key', 'app_timezone')->count() === 0) {
            $setting = new Setting();
            $setting->key = 'app_timezone';
            $setting->value = 'UTC';
            $setting->is_env = true;
            $setting->save();
        }
        if (Setting::where('key', 'app_locale')->count() === 0) {
            $setting = new Setting();
            $setting->key = 'app_locale';
            $setting->value = env('APP_LOCALE', 'en');
            $setting->is_env = true;
            $setting->save();
        }
        if (Setting::where('key', 'app_date_locale')->count() === 0) {
            $setting = new Setting();
            $setting->key = 'app_date_locale';
            $setting->value = 'en';
            $setting->save();
        }
        if (Setting::where('key', 'app_date_format')->count() === 0) {
            $setting = new Setting();
            $setting->key = 'app_date_format';
            $setting->value = 'L';
            $setting->save();
        }
        // Authentication
        if (Setting::where('key', 'app_user_registration')->count() === 0) {
            $setting = new Setting();
            $setting->key = 'app_user_registration';
            $setting->value = false;
            $setting->save();
        }
        if (Setting::where('key', 'app_default_role')->count() === 0) {
            $setting = new Setting();
            $setting->key = 'app_default_role';
            $setting->value = UserRole::where([
                ['name', '=', 'Customer'],
                ['type', '=', '1'],
            ])->first()->id;
            $setting->save();
        }
        // Outgoing mail
        if (Setting::where('key', 'mail_from_address')->count() === 0) {
            $setting = new Setting();
            $setting->key = 'mail_from_address';
            $setting->value = env('MAIL_FROM_ADDRESS', null);
            $setting->is_env = true;
            $setting->save();
        }
        if (Setting::where('key', 'mail_from_name')->count() === 0) {
            $setting = new Setting();
            $setting->key = 'mail_from_name';
            $setting->value = env('MAIL_FROM_NAME', null);
            $setting->is_env = true;
            $setting->save();
        }
        if (Setting::where('key', 'mail_mailer')->count() === 0) {
            $setting = new Setting();
            $setting->key = 'mail_mailer';
            $setting->value = env('MAIL_MAILER', 'log');
            $setting->is_env = true;
            $setting->save();
        }
        if (Setting::where('key', 'mail_host')->count() === 0) {
            $setting = new Setting();
            $setting->key = 'mail_host';
            $setting->value = env('MAIL_HOST', null);
            $setting->is_env = true;
            $setting->save();
        }
        if (Setting::where('key', 'mail_port')->count() === 0) {
            $setting = new Setting();
            $setting->key = 'mail_port';
            $setting->value = env('MAIL_PORT', null);
            $setting->is_env = true;
            $setting->save();
        }
        if (Setting::where('key', 'mail_username')->count() === 0) {
            $setting = new Setting();
            $setting->key = 'mail_username';
            $setting->value = env('MAIL_USERNAME', null);
            $setting->is_env = true;
            $setting->save();
        }
        if (Setting::where('key', 'mail_password')->count() === 0) {
            $setting = new Setting();
            $setting->key = 'mail_password';
            $setting->value = env('MAIL_PASSWORD', null);
            $setting->is_env = true;
            $setting->save();
        }
        if (Setting::where('key', 'mail_encryption')->count() === 0) {
            $setting = new Setting();
            $setting->key = 'mail_encryption';
            $setting->value = env('MAIL_ENCRYPTION', null);
            $setting->is_env = true;
            $setting->save();
        }
        if (Setting::where('key', 'mailgun_domain')->count() === 0) {
            $setting = new Setting();
            $setting->key = 'mailgun_domain';
            $setting->value = env('MAILGUN_DOMAIN', null);
            $setting->is_env = true;
            $setting->save();
        }
        if (Setting::where('key', 'mailgun_secret')->count() === 0) {
            $setting = new Setting();
            $setting->key = 'mailgun_secret';
            $setting->value = env('MAILGUN_SECRET', null);
            $setting->is_env = true;
            $setting->save();
        }
        if (Setting::where('key', 'mailgun_endpoint')->count() === 0) {
            $setting = new Setting();
            $setting->key = 'mailgun_endpoint';
            $setting->value = env('MAILGUN_ENDPOINT', null);
            $setting->is_env = true;
            $setting->save();
        }
        if (Setting::where('key', 'sentry_dsn')->count() === 0) {
            $setting = new Setting();
            $setting->key = 'sentry_dsn';
            $setting->value = env('SENTRY_DSN', null);
            $setting->is_env = true;
            $setting->save();
        }
        if (Setting::where('key', 'recaptcha_enabled')->count() === 0) {
            $setting = new Setting();
            $setting->key = 'recaptcha_enabled';
            $setting->value = false;
            $setting->save();
        }
        if (Setting::where('key', 'recaptcha_public')->count() === 0) {
            $setting = new Setting();
            $setting->key = 'recaptcha_public';
            $setting->value = null;
            $setting->save();
        }
        if (Setting::where('key', 'recaptcha_private')->count() === 0) {
            $setting = new Setting();
            $setting->key = 'recaptcha_private';
            $setting->value = null;
            $setting->save();
        }
    }
}
