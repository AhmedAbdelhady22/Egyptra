# Egyptra Frontend Design System

Quick reference for developers. Full specification: **[design-system.md](./design-system.md)**.

## Brand assets

| Asset | Path |
|-------|------|
| Logo (default) | `public/images/brand/egyptra-logo.png` |
| Favicon | `public/favicon.png` |
| Admin override | Upload via Settings → Logo / Favicon |

## Color palette

| Token | Hex | Usage |
|-------|-----|--------|
| `ink` | `#232C33` | Headings, footer, hero backgrounds |
| `sky` | `#A0C1D1` | Accents, borders, footer labels |
| `lavender` | `#DADFF7` | Light backgrounds, borders, chips |
| `ash` | `#B5B2C2` | Muted text, secondary labels |
| `teal` | `#5A7D7C` | Primary buttons, links, Filament primary |
| `accent` | `#E8614A` | Labels, highlights, favorites |
| `cream` | `#F7F5F0` | Page background |

Tailwind classes: `bg-ink`, `text-teal`, `border-lavender-200`, etc. Defined in `resources/css/app.css` `@theme`.

## Typography

| Role | Font | Tailwind |
|------|------|----------|
| Display / headings | Playfair Display | `font-display` |
| Body | Jost | `font-sans` (default) |
| Labels / metadata | DM Mono | `font-mono`, `.brand-label` |

## Components

| Class / component | Purpose |
|-------------------|---------|
| `<x-brand-logo>` | Logo + site name (retina `srcset` on default asset) |
| `<x-breadcrumb>` | Page breadcrumb trail |
| `<x-page-header>` | Section label, title, description |
| `.btn-primary` | Teal CTA button |
| `.btn-secondary` | Outlined secondary action |
| `.card-brand` | Property/content cards |
| `.brand-label` | Section labels (DM Mono, accent color) |

## Admin panel

Filament uses **teal** (`#5A7D7C`) as primary. Logo from `public/images/brand/egyptra-logo.png` unless overridden in Settings.
