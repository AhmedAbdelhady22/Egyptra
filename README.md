# Egyptra

Egyptra is a multilingual real estate platform for Egypt, built with Laravel. It provides a public website for browsing properties, services, projects, and blog content in English, Arabic, and Russian, plus a Filament admin panel for managing listings, leads, and site settings.

## Stack

- **PHP 8.3+** / **Laravel 13**
- **Filament 5** admin panel
- **Livewire 4** interactive components
- **Tailwind CSS 4** + Vite
- **MySQL** (production) / SQLite (local testing)
- **Spatie packages**: Translatable, Settings, Sitemap

## Features

- Property listings with advanced filters (type, location, price, area, bedrooms, etc.)
- Multilingual routes (`/en`, `/ar`, `/ru`) with RTL support for Arabic
- Contact and property inquiry forms with lead capture and admin notifications
- SEO metadata service with translatable titles and descriptions
- Blog, services, finishing packages, and project showcases
- Super-admin Filament dashboard for content and lead management

## Installation

### Prerequisites

- PHP 8.3+ with required extensions
- Composer 2.x
- Node.js 20+ and npm
- MySQL 8+ (or SQLite for quick local setup)

### Setup

```bash
git clone git@github.com:your-org/egyptra.git
cd egyptra
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
npm install
npm run build
php artisan storage:link
```

Configure your database and admin credentials in `.env`:

```env
APP_NAME=Egyptra
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=egyptra
DB_USERNAME=root
DB_PASSWORD=

ADMIN_EMAIL=admin@egyptra.com
ADMIN_PASSWORD=password
```

## Local development

Start the development server and Vite asset watcher:

```bash
composer dev
```

Or run services individually:

```bash
php artisan serve
npm run dev
```

- Public site: `http://localhost:8000/en`
- Admin panel: `http://localhost:8000/admin`

## Testing

Tests use PHPUnit with an in-memory SQLite database and the `RefreshDatabase` trait.

```bash
php artisan test
```

Run a specific test class:

```bash
php artisan test --filter=PropertyFilterTest
```

## Deployment

See the full [VPS deployment guide](docs/deployment.md) for production setup including PHP extensions, Nginx/Apache, SSL, queue workers, caching, and backups.

## License

Proprietary. All rights reserved.
