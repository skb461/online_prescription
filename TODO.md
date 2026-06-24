# TODO - Fix 404 Not Found

## Step 1

- Update `routes/web.php` to add landing route `GET /` -> redirect/point to `prescriptions.create`.

## Step 2

- Add missing patient routes (`GET /patients`, `GET /patients/create`) so sidebar links don’t 404.

## Step 3

- (If needed) run `php artisan route:clear` and `php artisan optimize:clear` to ensure new routes are picked up.

## Step 4

- Quick manual test: open `/`, `/patients`, `/patients/create`, `/prescriptions/create` in browser; verify no 404s.
