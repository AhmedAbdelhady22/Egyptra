# Egyptra VPS Deployment Guide

This guide covers deploying the Egyptra Laravel application to a production VPS running Ubuntu 22.04+ (or similar Linux distribution).

## Requirements

- **PHP 8.3+** with extensions:
  - `bcmath`, `ctype`, `curl`, `dom`, `fileinfo`, `gd` or `imagick`, `intl`, `mbstring`, `openssl`, `pdo`, `pdo_mysql`, `tokenizer`, `xml`, `zip`
- **Composer 2.x**
- **Node.js 20+** and **npm**
- **MySQL 8.0+** or **MariaDB 10.6+**
- **Nginx** or **Apache**
- **Redis** (optional, recommended for cache/queues)
- **Supervisor** (for queue workers)
- **Certbot** (for SSL)

## 1. Server preparation

```bash
sudo apt update && sudo apt upgrade -y
sudo apt install -y git curl unzip nginx mysql-server redis-server supervisor certbot python3-certbot-nginx
```

### Install PHP 8.3

```bash
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update
sudo apt install -y php8.3-fpm php8.3-cli php8.3-mysql php8.3-mbstring php8.3-xml \
  php8.3-curl php8.3-zip php8.3-gd php8.3-intl php8.3-bcmath php8.3-tokenizer php8.3-dom
```

### Install Composer

```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

### Install Node.js

```bash
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt install -y nodejs
```

## 2. Database setup

```bash
sudo mysql -e "CREATE DATABASE egyptra CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
sudo mysql -e "CREATE USER 'egyptra'@'localhost' IDENTIFIED BY 'strong-password-here';"
sudo mysql -e "GRANT ALL PRIVILEGES ON egyptra.* TO 'egyptra'@'localhost';"
sudo mysql -e "FLUSH PRIVILEGES;"
```

## 3. Deploy application code

```bash
sudo adduser --disabled-password --gecos "" deploy
sudo mkdir -p /var/www/egyptra
sudo chown deploy:www-data /var/www/egyptra

sudo -u deploy git clone git@github.com:your-org/egyptra.git /var/www/egyptra
cd /var/www/egyptra
```

## 4. Install dependencies

```bash
composer install --no-dev --optimize-autoloader
npm ci
npm run build
```

## 5. Environment configuration

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` for production:

```env
APP_NAME=Egyptra
APP_ENV=production
APP_DEBUG=false
APP_URL=https://egyptra.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=egyptra
DB_USERNAME=egyptra
DB_PASSWORD=strong-password-here

CACHE_STORE=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis

MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_FROM_ADDRESS=hello@egyptra.com
MAIL_FROM_NAME="${APP_NAME}"

ADMIN_EMAIL=admin@egyptra.com
ADMIN_PASSWORD=change-me-on-first-login
```

## 6. Laravel setup commands

```bash
php artisan migrate --force
php artisan migrate --path=database/settings --force
php artisan storage:link
php artisan db:seed --class=SettingsSeeder --force
php artisan db:seed --class=AdminUserSeeder --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
php artisan icons:cache
php artisan filament:cache-components
```

Set directory permissions:

```bash
sudo chown -R deploy:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

## 7. Nginx configuration

Create `/etc/nginx/sites-available/egyptra`:

```nginx
server {
    listen 80;
    server_name egyptra.com www.egyptra.com;
    root /var/www/egyptra/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    client_max_body_size 20M;
}
```

Enable the site:

```bash
sudo ln -s /etc/nginx/sites-available/egyptra /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

## 8. Apache alternative

Enable required modules:

```bash
sudo a2enmod rewrite ssl headers
```

Virtual host example (`/etc/apache2/sites-available/egyptra.conf`):

```apache
<VirtualHost *:80>
    ServerName egyptra.com
    DocumentRoot /var/www/egyptra/public

    <Directory /var/www/egyptra/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/egyptra-error.log
    CustomLog ${APACHE_LOG_DIR}/egyptra-access.log combined
</VirtualHost>
```

Ensure `public/.htaccess` is present (included with Laravel).

```bash
sudo a2ensite egyptra
sudo systemctl reload apache2
```

## 9. SSL with Let's Encrypt

```bash
sudo certbot --nginx -d egyptra.com -d www.egyptra.com
```

For Apache:

```bash
sudo certbot --apache -d egyptra.com -d www.egyptra.com
```

Certbot installs a cron job for automatic renewal. Verify with:

```bash
sudo certbot renew --dry-run
```

## 10. Queue worker (Supervisor)

Create `/etc/supervisor/conf.d/egyptra-worker.conf`:

```ini
[program:egyptra-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/egyptra/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=deploy
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/egyptra/storage/logs/worker.log
stopwaitsecs=3600
```

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start egyptra-worker:*
```

## 11. Scheduled tasks (cron)

```bash
sudo crontab -u deploy -e
```

Add:

```cron
* * * * * cd /var/www/egyptra && php artisan schedule:run >> /dev/null 2>&1
```

## 12. Deployment updates

For subsequent releases:

```bash
cd /var/www/egyptra
git pull origin main
composer install --no-dev --optimize-autoloader
npm ci && npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
php artisan queue:restart
sudo supervisorctl restart egyptra-worker:*
```

## 13. Backups

### Database

Daily MySQL dump via cron:

```bash
0 2 * * * mysqldump -u egyptra -p'strong-password-here' egyptra | gzip > /backups/egyptra-$(date +\%F).sql.gz
```

Retain 14 days:

```bash
find /backups -name "egyptra-*.sql.gz" -mtime +14 -delete
```

### Storage files

```bash
tar -czf /backups/egyptra-storage-$(date +%F).tar.gz -C /var/www/egyptra/storage/app/public .
```

### Off-site copies

Sync backups to S3 or another server:

```bash
aws s3 sync /backups s3://your-bucket/egyptra-backups/
```

## 14. Health checks

- Public health endpoint: `GET /up`
- Admin panel: `https://egyptra.com/admin`
- Verify sitemap: `https://egyptra.com/sitemap.xml`

## 15. Security checklist

- Set `APP_DEBUG=false` in production
- Change default admin password immediately after first login (seeder uses `ADMIN_PASSWORD` from env)
- Configure WhatsApp, phone, and email in **Admin → Settings** before go-live
- Restrict SSH to key-based authentication
- Configure UFW: allow 22, 80, 443 only
- Keep PHP, OS packages, and Composer dependencies updated
- Never commit `.env` to version control
- Run `php artisan test` and smoke-test detail routes after each deploy
- Verify `/sitemap.xml` and hreflang alternates for EN/AR/RU
