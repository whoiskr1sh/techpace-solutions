Techpace Solutions — CRM (Production Deployment Guide)
===============================================

This repository contains the Techpace CRM Laravel application. The document below helps prepare the app for production, including environment configuration, optimization, queue setup, storage linking, error handling, UI build steps, and deployment guides for shared hosting and VPS.

**Files added**
- [README.md](README.md) — this file
- [.env.example](.env.example) — production-ready env template
- [deploy/nginx.conf](deploy/nginx.conf) — example Nginx site config
- [deploy/supervisor-worker.conf](deploy/supervisor-worker.conf) — example Supervisor program
- [deploy/worker.service](deploy/worker.service) — example systemd service for queue worker

Quick start (production)
-------------------------
1. Copy the example env and edit values:

```bash
cp .env.example .env
# edit .env with secure values (APP_KEY, DB credentials, mail, redis, etc.)
```

2. Install composer dependencies and build assets:

```bash
composer install --no-dev --optimize-autoloader
npm ci
npm run build    # or yarn build
```

3. Run migrations (force in production) and seed carefully:

```bash
php artisan migrate --force
php artisan db:seed --class=SomeSeedClass --force   # optional
```

4. Storage link and permissions:

```bash
php artisan storage:link
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

5. App optimization:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

6. Start queue workers (see deploy configs below) and web server (Nginx + PHP-FPM recommended).

Environment configuration
-------------------------
Use [`.env.example`](.env.example) as the base. Critical settings for production:
- `APP_ENV=production`, `APP_DEBUG=false`
- Set secure `APP_KEY`
- `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
- `CACHE_DRIVER=redis`, `QUEUE_CONNECTION=redis` (recommended), `SESSION_DRIVER=redis`
- Mail settings (SMTP) for notifications and password resets
- `SENTRY_DSN` or other monitoring DSN (optional)

App optimization
----------------
- Use `composer install --no-dev --optimize-autoloader`.
- Cache configs and routes (`php artisan config:cache`, `route:cache`, `view:cache`).
- Ensure PHP OPcache is enabled in php.ini for production.
- Use `php artisan optimize` after deploy.

Queue setup
-----------
Recommended: Redis for queue backend and Supervisor or systemd for workers.

- Example Supervisor config: [deploy/supervisor-worker.conf](deploy/supervisor-worker.conf)
- Example systemd service: [deploy/worker.service](deploy/worker.service)
- Start workers with `supervisorctl reread && supervisorctl update && supervisorctl start techpace-worker:*` or `systemctl start techpace-worker.service`.

Storage linking
---------------
Create public symlink to storage and ensure permissions:

```bash
php artisan storage:link
chown -R www-data:www-data public/storage storage bootstrap/cache
chmod -R 775 public/storage storage bootstrap/cache
```

Error handling and monitoring
-----------------------------
- Set `APP_DEBUG=false` in production.
- Configure and enable a monitoring/error reporting service (Sentry, Bugsnag). Add DSN to `.env` and set up the SDK in `config/logging.php` or a service provider.
- Use daily logging with rotation; tune `config/logging.php` (daily, max_files).
- Provide custom error pages in `resources/views/errors/` (404.blade.php, 500.blade.php).

Final UI polish
---------------
- Build production assets with `npm run build`.
- Use CSS purging and asset versioning (Vite or Mix `mix.version()` or Vite cache-busting).
- Test on smaller screens and ensure forms and modals degrade gracefully.

Deployment (shared hosting)
--------------------------
If on shared hosting with limited shell access:
- Upload code to a folder accessible by your host or use FTP/SFTP.
- Ensure `public` is served as the webroot; if you cannot set webroot, move index.php and .htaccess carefully (prefer not to).
- Set `APP_ENV=production` and `APP_DEBUG=false`.
- Use database tools from host (phpMyAdmin) to run migrations SQL if you can't run artisan. Export/Import SQL from local migration run.

Deployment (VPS) — recommended setup
-----------------------------------
1. Provision server (Ubuntu LTS recommended). Install Nginx, PHP-FPM (matching project PHP version), Redis, MySQL/Postgres, Composer, Node.
2. Clone repo into `/var/www/techpace` and set correct ownership (`www-data` or relevant user).
3. Create `.env` from `.env.example` and secure credentials.
4. Install dependencies and build assets (see Quick start).
5. Configure Nginx with [deploy/nginx.conf](deploy/nginx.conf) as a site file and enable it.
6. Configure Supervisor with [deploy/supervisor-worker.conf](deploy/supervisor-worker.conf) or systemd unit [deploy/worker.service].
7. Start/reload services: `systemctl restart php8.1-fpm`, `systemctl restart nginx`, `supervisorctl reread && supervisorctl update`.

Templates and examples
----------------------
- [deploy/nginx.conf](deploy/nginx.conf) — Example Nginx site for Techpace
- [deploy/supervisor-worker.conf](deploy/supervisor-worker.conf) — Supervisor program for queue workers
- [deploy/worker.service](deploy/worker.service) — systemd worker service alternative

Production checklist
--------------------
- [ ] Set `APP_ENV=production` and `APP_DEBUG=false` in `.env`
- [ ] Generate `APP_KEY` and set secure DB credentials
- [ ] Configure mail provider and test password reset flow
- [ ] Configure cache, session, and queue drivers (Redis recommended)
- [ ] Install composer deps without dev and run `composer dump-autoload -o`
- [ ] Build front-end assets (`npm run build`)
- [ ] Run `php artisan migrate --force` and seed selectively
- [ ] Run `php artisan storage:link` and set proper permissions
- [ ] Configure Supervisor/systemd for queue workers and start them
- [ ] Set up monitoring (Sentry) and alerts
- [ ] Configure daily log rotation and DB backups
- [ ] Disable directory listing and secure web server headers (CSP, HSTS)

Need help applying this? I can:
- Generate environment values from the current `.env` to a `.env.example` copy
- Run `php artisan migrate --force` for you (confirm first)
- Create a minimal deployment script (deploy.sh)
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
