# Prodi

Company site for [Prodi](https://prodi.se), a small web studio in Märsta. Swedish is the default language at `/`. Polish is at `/pl`.

The site is a Laravel application with Blade, Tailwind CSS and Vite. Visitors can read the packages, look at two labelled example designs, and send a quote request. Requests are validated, rate limited, stored in the database and emailed to `PRODI_CONTACT_EMAIL`.

## Requirements

- PHP 8.3 or newer
- Composer
- Node.js 20 or newer and npm
- [Laravel Herd](https://herd.laravel.com/) on macOS, or another way to run PHP

## Run it with Herd

From the project directory:

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
npm install
npm run build
```

Link the site if the folder is not already inside Herd’s parked directory:

```bash
herd link prodi
```

Open `http://prodi.test` (or `http://<folder-name>.test` if Herd parked the directory). Set `APP_URL` in `.env` to that same address.

For day-to-day CSS changes, use `npm run dev` instead of `npm run build`.

`MAIL_MAILER=log` is the local default. Quote emails are written to `storage/logs/laravel.log` until a real mailbox exists. Submissions are still stored in the `contact_inquiries` table.

Run the tests with:

```bash
php artisan test
```

## Placeholders to fill in

Do not invent these. Leave them empty until they are known.

| Variable | What to put |
| --- | --- |
| `PRODI_CONTACT_EMAIL` | `filip@prodi.se`. Quote requests are emailed here. An address at example.com, example.org or example.net is not shown on the site. |
| `PRODI_ORG_NUMBER` | `559214-9370`. Prodi is an AB. Shown in the footer and on the privacy policy. |
| `PRODI_STREET_ADDRESS` | `Tegelbrukets väg 41`. Shown in the footer, on the contact page and in the privacy policy. |
| `PRODI_POSTAL_CODE` | `195 59`. Shown with the city as `195 59 Märsta`. |
| `PRODI_PHONE` | Empty on purpose. A call link and a WhatsApp link appear only after a real number is set. Do not invent one. |
| `MAIL_FROM_ADDRESS` | `filip@prodi.se`. |
| `APP_URL` | `http://prodi.test` locally, `https://prodi.se` in production. |

`PRODI_NAME`, `PRODI_OWNER` and `PRODI_CITY` already match the studio. Prices are exkl. moms: Start 4 900 kr, Firma 7 900 kr, Opieka 299 kr/month, Individuellt from 9 900 kr, individual quote.

## Add another language

1. Copy `lang/sv/site.php` to `lang/<code>/site.php` and translate it.
2. Add the language to `App\Support\Locales::DEFINITIONS` (URL prefix, hreflang, Open Graph locale, label).
3. Add a path for every key in `App\Support\Locales::PATHS`.

Swedish stays at `/` because its prefix is empty. A new language gets its own prefix, the same way Polish uses `/pl`.

## Deploy

Build the assets on a machine that has Node, then deploy the PHP app. The web root must be the `public/` directory. `npm run build` writes to `public/build`, which is not committed.

```bash
composer install --no-dev --optimize-autoloader
npm ci
npm run build
```

Production `.env` for [prodi.se](https://prodi.se):

```dotenv
APP_ENV=production
APP_DEBUG=false
APP_URL=https://prodi.se

MAIL_MAILER=postmark
POSTMARK_API_KEY=
MAIL_FROM_ADDRESS=filip@prodi.se
MAIL_FROM_NAME=Prodi

PRODI_CONTACT_EMAIL=filip@prodi.se
PRODI_ORG_NUMBER=559214-9370
PRODI_STREET_ADDRESS="Tegelbrukets väg 41"
PRODI_POSTAL_CODE="195 59"

QUEUE_CONNECTION=sync
```

Set `POSTMARK_API_KEY` to the Postmark server API token. `POSTMARK_TOKEN` is read when `POSTMARK_API_KEY` is empty, so either name in the server `.env` works. `filip@prodi.se` must be a confirmed sender, or the domain a verified signature, in that Postmark server. An empty `PRODI_STREET_ADDRESS` or `PRODI_POSTAL_CODE` still falls back to Tegelbrukets väg 41, 195 59 Märsta. Quote mail is sent inside the web request (`ContactInquiryReceived` is not queued), so `QUEUE_CONNECTION=sync` is enough and no queue worker is required. If Postmark rejects the message, the inquiry stays in `contact_inquiries` and the form shows an error instead of a 500.

```bash
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

`storage/` and `bootstrap/cache/` must be writable by PHP.

SQLite is enough to start (`DB_CONNECTION=sqlite`). MySQL or MariaDB works too: set `DB_CONNECTION=mysql` and the `DB_*` values, create the database, then migrate.

### Shared hosting

Prefer a host that lets you set the document root to `public/`. If the document root has to be `public_html`:

1. Put the Laravel project outside `public_html` (or in a folder that is not public).
2. Copy the contents of `public/` into `public_html`, including the `build/` directory from `npm run build`.
3. Edit `public_html/index.php` so the `require` and maintenance-file paths point at the real project directory.
4. Run `composer install` and `php artisan migrate` over SSH. If there is no SSH, run Composer locally with `--no-dev` and upload the `vendor/` directory as well.

Do not leave `.env` inside the public document root.

### Production VPS

The live site runs on a VPS at `70.34.219.109`, with GitHub autodeploy, and Cloudflare in front of the origin.

DNS for `prodi.se` and `www.prodi.se` is proxied (orange cloud) to `70.34.219.109`. Use SSL mode **Full (strict)** and Always Use HTTPS. `APP_URL` must be `https://prodi.se`, including the scheme. Sitemap and canonical URLs are built from `APP_URL`. Redirect `www` to the apex and keep both names on that same `APP_URL`.

`bootstrap/app.php` calls `trustProxies(at: '*')`. Cloudflare sends `X-Forwarded-For` and `X-Forwarded-Proto`, and Laravel uses those so `$request->ip()` is the visitor, not a Cloudflare address. The quote form rate limit keys on that IP. Trusting every proxy is safe only while the origin firewall allows ports 80 and 443 from [Cloudflare’s IP ranges](https://www.cloudflare.com/ips/) and from nowhere else. If the origin is open to the whole internet, a client can spoof `X-Forwarded-For`.

The app does not ship a static `public/robots.txt`. `/sitemap.xml` and `/robots.txt` are Laravel routes, so the document root must fall through to `index.php`.

Privacy policy URLs for Meta lead ads:

- Swedish: `https://prodi.se/integritetspolicy`
- Polish: `https://prodi.se/pl/polityka-prywatnosci`

The policy names Prodi AB, org.nr `559214-9370`, Tegelbrukets väg 41, 195 59 Märsta, and covers the quote form and Meta lead forms.

On each push, the autodeploy hook on the VPS should run from the project directory:

```bash
git pull --ff-only
composer install --no-dev --optimize-autoloader
npm ci
npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
sudo systemctl reload php8.3-fpm
```

Nginx, PHP 8.3-FPM and the origin certificate (Full strict needs a certificate on the VPS, for example from Certbot or a Cloudflare origin certificate):

```nginx
server {
    listen 443 ssl;
    server_name prodi.se www.prodi.se;
    root /var/www/prodi/public;
    index index.php;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

There is no queue worker, scheduler or websocket to keep running.
