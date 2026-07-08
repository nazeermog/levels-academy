# Production / Pilot Go-Live Checklist

Do these on the **production server** before real users log in. (Code-level hardening
like login rate-limiting is already in the app; the items below are environment/ops.)

## 1. Turn off debug (critical — currently leaks `.env`)
In the production `.env`:
```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain
```
The Symfony/Ignition stack-trace error pages expose DB passwords and keys when
`APP_DEBUG=true`. Never run production with it on.

After editing `.env` on the server:
```
php artisan config:clear    # (or config:cache to re-cache)
```

## 2. HTTPS
Serve over TLS and force it (redirect http→https at the web server / load balancer).

## 3. Mail + queue (so emails actually send)
- Set real `MAIL_*` credentials.
- `QUEUE_CONNECTION=database` (or redis) and run a worker as a service:
  ```
  php artisan queue:work --tries=3 --sleep=3
  ```
  Run it under a supervisor (systemd / Supervisor / Windows service) so it restarts.
  The class-session and free-session invite emails rely on this.

## 4. Database backups
Schedule a nightly `mysqldump` (or managed-DB automatic backups). Verify you can restore.

## 5. Login rate-limiting — DONE (in code)
`POST /auth/login` is throttled to **10 attempts/minute per IP**
(`Modules/Auth/Routes/web.php`). Adjust the number there if needed.

## 6. Passwords
Ensure no real account keeps a seed password (e.g. `123456789`). Force a reset for
seeded/test accounts before launch.

## 7. Caching (recommended before scaling — not required for a small pilot)
`CACHE_DRIVER=redis`, `SESSION_DRIVER=redis` (also enables running multiple app
servers). On deploy: `php artisan config:cache route:cache view:cache`.

## 8. Storage
`php artisan storage:link` so uploaded photos/avatars are publicly served.

## 9. Data integrity note
Tables are **MyISAM**, which can't enforce foreign keys — dangling rows are possible.
Run the orphan cleanup periodically (safe, dry-run by default):
```
php artisan data:cleanup-orphans           # report only
php artisan data:cleanup-orphans --force   # delete orphaned rows
```
