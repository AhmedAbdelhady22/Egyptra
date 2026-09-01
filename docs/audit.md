# Egyptra — Implementation Audit

**Date:** 2026-08-31  
**Scope:** Full codebase inspection, log review, database review, route testing (no code changes)  
**Environment tested:** Laravel 13.29 / PHP 8.4.22 / Filament 5.7.6 / Livewire 4.4.2 / SQLite (local) / `composer dev` running

---

## Executive Summary

The project scaffold is substantial: migrations, models, Filament admin, multilingual routing, Livewire property listing, SEO components, and 18 passing PHPUnit tests. However, **most slug-based detail pages return HTTP 500 in the current local environment** due to MySQL-only JSON slug queries on SQLite. Seeded properties have **no images**, WhatsApp CTAs are **hidden by default**, and the public UI still reads as a generic template despite brand tokens being applied.

---

## CRITICAL

### 1. Slug route binding fails on SQLite (detail pages return 500)

| Field | Detail |
|-------|--------|
| **Problem** | Property, service, finishing package, project, and blog detail routes crash with `no such function: JSON_UNQUOTE`. |
| **Location** | `app/Support/Concerns/HasTranslatableSlug.php`; duplicate logic in `app/Models/BlogPost.php` (`resolveRouteBinding`) |
| **Why it happens** | Slug lookup uses MySQL-specific `JSON_UNQUOTE(JSON_EXTRACT(...))`. Local `.env` uses SQLite (`php artisan about` confirms). |
| **Recommended fix** | Replace raw SQL with a database-agnostic resolver (e.g. fetch candidates in PHP using Spatie translations, or use driver-specific JSON syntax for SQLite vs MySQL). Consolidate `BlogPost` onto the shared trait. |
| **Risk** | **High** — blocks all detail-page QA locally; tests do not cover these routes so regressions are invisible. On MySQL production this may work, but SQLite/tests/dev remain broken. |

**Verified HTTP status (local):**

| URL | Status |
|-----|--------|
| `/en` | 200 |
| `/en/properties` | 200 |
| `/en/about` | 200 |
| `/en/properties/cfc-furnished-chalet` | **500** |
| `/en/services/property-sales` | **500** |
| `/en/finishing-packages/luxury-ar` | **500** |
| `/en/projects/palm-residence-new-cairo` | **500** |
| `/en/blog/cairo-property-market-2026` | **500** |

Log evidence: `storage/logs/laravel.log` — repeated `SQLSTATE[HY000]: General error: 1 no such function: JSON_UNQUOTE`.

---

### 2. Test suite does not cover broken detail routes

| Field | Detail |
|-------|--------|
| **Problem** | 18 tests pass but none assert property/service/blog/project/package detail pages load. |
| **Location** | `tests/Feature/` — missing detail-route tests |
| **Why it happens** | Tests focus on filters, locale, leads, admin access, SEO service; slug binding never exercised. |
| **Recommended fix** | Add feature tests for at least one detail route per entity type after slug fix. |
| **Risk** | **High** — false confidence; critical breakage ships unnoticed. |

---

## HIGH

### 3. No property media in seeded/demo data

| Field | Detail |
|-------|--------|
| **Problem** | 0/12 properties have `featured_image`; `property_images` table has 0 rows. All listing cards show “No image”. |
| **Location** | `database/seeders/PropertySeeder.php`; `property_images` migration |
| **Why it happens** | Seeder creates text/metadata only, no image paths or gallery records. |
| **Recommended fix** | Add placeholder images to seeder (or copy sample assets to `storage/app/public/properties`) so QA reflects real UX. |
| **Risk** | **Medium** — demo site looks broken; client cannot evaluate photography-led design. |

---

### 4. `ImageOptimizer` service exists but is never used

| Field | Detail |
|-------|--------|
| **Problem** | Uploads go through Filament `FileUpload` directly; no WebP conversion or thumbnails. |
| **Location** | `app/Services/ImageOptimizer.php` (defined); Filament forms use raw `FileUpload` |
| **Why it happens** | Service was scaffolded per architecture doc but not wired to create/edit hooks or observers. |
| **Recommended fix** | Hook optimizer into Filament save pipeline or model observers; populate `thumbnail_path` on `property_images`. |
| **Risk** | **Medium** — large unoptimized uploads; missing thumbnails hurt listing performance. |

---

### 5. Property detail page is incomplete

| Field | Detail |
|-------|--------|
| **Problem** | Controller loads `videos` but view never renders them. Features not shown. Map is external link only (lat/lng parsed in admin but not used). Gallery is basic grid, not premium. |
| **Location** | `app/Http/Controllers/PropertyController.php`; `resources/views/pages/properties/show.blade.php` |
| **Why it happens** | Partial implementation — backend relationships exist, frontend sections missing. |
| **Recommended fix** | Add video embed section, features list, map embed via `MapUrlParser::embedUrl()`, improved gallery (lightbox / hero + thumbs). |
| **Risk** | **Medium** — core conversion page under-delivers vs spec. |

---

### 6. No video rendering on any public detail page

| Field | Detail |
|-------|--------|
| **Problem** | Grep across `resources/views` finds zero video rendering. Admin supports property/service/package/project videos. |
| **Location** | All `resources/views/pages/*/show.blade.php` |
| **Why it happens** | Video repeaters added in Filament; public templates never completed. |
| **Recommended fix** | Shared `<x-video-gallery>` component for URL/file video types. |
| **Risk** | **Medium** — uploaded media invisible to visitors. |

---

### 7. WhatsApp CTAs inactive until manual settings save

| Field | Detail |
|-------|--------|
| **Problem** | Floating WhatsApp button and property inquiry links depend on `GeneralSettings::$whatsapp_number`, which defaults to `null`. Settings table has 0 rows; seeders do not set WhatsApp. |
| **Location** | `app/Settings/GeneralSettings.php`; `resources/views/components/whatsapp-button.blade.php`; `app/Services/WhatsAppLinkBuilder.php` |
| **Why it happens** | No default contact data in seeders or settings migration. |
| **Recommended fix** | Seed a placeholder WhatsApp number (clearly marked for dev) or document required first-run Settings step prominently. |
| **Risk** | **Medium** — primary CTA channel missing on fresh install. |

---

### 8. Russian public UI not translated

| Field | Detail |
|-------|--------|
| **Problem** | `/ru` routes work but all `__()` strings fall back to English. Only `lang/en/filament.php` and `lang/ar/filament.php` exist (admin only). |
| **Location** | Missing `lang/ru/`; all public Blade views use inline English keys |
| **Why it happens** | Multilingual content exists in DB (seed translatable fields) but UI chrome/strings are not localized. |
| **Recommended fix** | Add `lang/ru/*.php` (and ideally `lang/ar/*.php` for public strings); extract repeated labels. |
| **Risk** | **Medium** — RU locale is misleading; hurts trust for Russian visitors. |

---

### 9. hreflang / language switcher breaks on detail pages

| Field | Detail |
|-------|--------|
| **Problem** | Language switcher and `<x-seo-meta>` hreflang only swap the locale URL segment; they do not resolve the equivalent localized slug. |
| **Location** | `resources/views/layouts/app.blade.php` (`$switchLocale`); `resources/views/components/seo-meta.blade.php` |
| **Why it happens** | Simple segment replacement — e.g. `/en/properties/madinaty-standalone-villa` → `/ar/properties/madinaty-standalone-villa` instead of `...-ar` slug. |
| **Recommended fix** | On detail routes, generate alternate URLs using `localizedSlug($locale)` per model. |
| **Risk** | **Medium** — SEO duplicate/broken alternate URLs; language switch leads to 404/500. |

---

### 10. Property filter: floor type mismatch and missing UI control

| Field | Detail |
|-------|--------|
| **Problem** | DB column `floor` is `string`; Livewire property is `?int`; filter uses exact match. No floor filter shown in listing UI. |
| **Location** | `database/migrations/2026_08_30_204610_create_properties_table.php`; `app/Livewire/PropertyListing.php`; `resources/views/pages/properties/index.blade.php` |
| **Why it happens** | Incomplete filter implementation vs spec. |
| **Recommended fix** | Change Livewire `floor` to `?string`; add floor input to filter sidebar; decide match semantics (exact vs contains). |
| **Risk** | **Low–Medium** — filter spec not fully met; int casting may reject valid values like "Ground". |

---

### 11. Missing "Oldest" sort option

| Field | Detail |
|-------|--------|
| **Problem** | Sort options: newest, price asc/desc, area asc/desc. No oldest-first. |
| **Location** | `app/Livewire/PropertyListing.php` (`$sortOptions`) |
| **Why it happens** | Not implemented. |
| **Recommended fix** | Add `oldest` → `orderBy('published_at')`. |
| **Risk** | **Low** — spec gap. |

---

### 12. Local database driver mismatch with documentation

| Field | Detail |
|-------|--------|
| **Problem** | `.env.example` defaults to MySQL; running app uses SQLite. README/deployment docs assume MySQL. |
| **Location** | `.env.example` vs runtime (`php artisan about`) |
| **Why it happens** | Dev convenience (SQLite file) without documenting slug-query incompatibility. |
| **Recommended fix** | Align local `.env` with MySQL **or** fix slug queries for SQLite **and** document supported drivers. |
| **Risk** | **Medium** — developer confusion; environment-specific bugs. |

---

## MEDIUM

### 13. Conflicting font loading (brand vs Vite default)

| Field | Detail |
|-------|--------|
| **Problem** | `vite.config.js` bundles **Instrument Sans** via bunny fonts; layout loads **Jost / Playfair / DM Mono** from Google Fonts; `app.css` `@theme` sets Jost as `--font-sans`. |
| **Location** | `vite.config.js`; `resources/views/layouts/app.blade.php`; `resources/css/app.css` |
| **Why it happens** | Laravel 13 default Vite font plugin not removed when brand typography added. |
| **Recommended fix** | Remove Instrument Sans from Vite; load brand fonts once (prefer self-hosted or single CDN). |
| **Risk** | **Low** — extra ~60KB+ font payload; inconsistent rendering if Instrument Sans wins in some contexts. |

---

### 14. Homepage lacks property discovery / search block

| Field | Detail |
|-------|--------|
| **Problem** | Hero → featured cards → services → packages → projects. No inline search or filter shortcut. |
| **Location** | `resources/views/pages/home.blade.php`; `app/Http/Controllers/HomeController.php` |
| **Why it happens** | Template-style homepage structure. |
| **Recommended fix** | Add compact search (listing type, city, property type, CTA to `/properties` with query params). |
| **Risk** | **Low** — UX/conversion gap per spec. |

---

### 15. Property filters not mobile-optimized

| Field | Detail |
|-------|--------|
| **Problem** | Filter sidebar always visible; no collapsible drawer/modal on small screens. Long filter stack pushes results down. |
| **Location** | `resources/views/pages/properties/index.blade.php` |
| **Why it happens** | Desktop-first grid layout. |
| **Recommended fix** | Mobile filter toggle (Livewire/Alpine drawer); sticky sort bar. |
| **Risk** | **Low** — poor mobile browse experience. |

---

### 16. Property cards missing bathrooms; template-like card grid

| Field | Detail |
|-------|--------|
| **Problem** | Cards show beds + area but not baths. Homepage/sections use repetitive equal card grids. |
| **Location** | `resources/views/components/property-card.blade.php`; `resources/views/pages/home.blade.php` |
| **Why it happens** | Minimal card spec implementation; generic section rhythm. |
| **Recommended fix** | Add bathrooms; vary section layouts (asymmetric hero, featured strip, split sections). |
| **Risk** | **Low** — UI quality / spec alignment. |

---

### 17. Admin features field is a plain textarea for translatable content

| Field | Detail |
|-------|--------|
| **Problem** | `features` is translatable JSON array in model but admin uses textarea with “HTML or plain text” helper — awkward for non-technical client. |
| **Location** | `app/Filament/Resources/Properties/Schemas/PropertyForm.php` |
| **Why it happens** | Quick form scaffolding without structured repeater/tags input. |
| **Recommended fix** | Per-locale repeater or tag input; cast/store as string array; render as list on public site. |
| **Risk** | **Low** — admin UX/data consistency. |

---

### 18. Sitemap generation loads all records into memory

| Field | Detail |
|-------|--------|
| **Problem** | `SitemapController` calls `->get()` on all published entities × 3 locales — no chunking. |
| **Location** | `app/Http/Controllers/SitemapController.php` |
| **Why it happens** | Straightforward implementation fine for small catalogs. |
| **Recommended fix** | Use `chunk()` / `lazy()` when property count grows. |
| **Risk** | **Low now** — may become slow at scale. |

---

### 19. Retina logo asset is not actually 2× resolution

| Field | Detail |
|-------|--------|
| **Problem** | `egyptra-logo.png` and `egyptra-logo@2x.png` are both 9293 bytes (same file). |
| **Location** | `public/images/brand/` |
| **Why it happens** | Placeholder duplicate instead of true 2× export. |
| **Recommended fix** | Replace `@2x` with genuine high-res brand export from guidelines. |
| **Risk** | **Low** — soft logos on retina displays. |

---

### 20. Contact form has no rate limiting

| Field | Detail |
|-------|--------|
| **Problem** | Livewire `ContactForm` can be spammed; only honeypot protection exists. |
| **Location** | `app/Livewire/ContactForm.php` |
| **Why it happens** | Honeypot added; throttle not configured. |
| **Recommended fix** | Add Livewire rate limit or Laravel `RateLimiter` on submit. |
| **Risk** | **Low–Medium** — lead spam / notification noise. |

---

### 21. Orphan Filament page class

| Field | Detail |
|-------|--------|
| **Problem** | `CreateLead.php` exists but `LeadResource::canCreate()` returns false and route is not registered. |
| **Location** | `app/Filament/Resources/Leads/Pages/CreateLead.php` |
| **Why it happens** | Resource generated then create disabled intentionally. |
| **Recommended fix** | Delete unused class or document why kept. |
| **Risk** | **Low** — maintenance clutter. |

---

### 22. Service/package/project detail pages incomplete vs property

| Field | Detail |
|-------|--------|
| **Problem** | Service show has images but no videos. Packages/projects likely same pattern (when reachable). |
| **Location** | `resources/views/pages/services/show.blade.php`; similar show templates |
| **Why it happens** | Uneven template completion. |
| **Recommended fix** | Align all detail templates with shared media/CTA patterns. |
| **Risk** | **Low** — inconsistent UX. |

---

## LOW

### 23. Default admin credentials in seeder

| Field | Detail |
|-------|--------|
| **Problem** | `admin@egyptra.com` / `password` unless env overrides. |
| **Location** | `database/seeders/AdminUserSeeder.php` |
| **Why it happens** | Standard dev seeder pattern. |
| **Recommended fix** | Document mandatory password change for production; require env vars in deployment checklist. |
| **Risk** | **High if deployed unchanged** — classify as deployment/process issue. |

---

### 24. `APP_DEBUG=true` in `.env.example`

| Field | Detail |
|-------|--------|
| **Problem** | Example env enables debug mode. |
| **Location** | `.env.example` |
| **Why it happens** | Laravel default for local. |
| **Recommended fix** | Add comment warning; deployment doc already should stress `APP_DEBUG=false`. |
| **Risk** | **Low** — operator error on deploy. |

---

### 25. Hero uses radial gradient overlays

| Field | Detail |
|-------|--------|
| **Problem** | Homepage hero uses dual radial gradients — slightly generic “AI template” feel despite brand colors. |
| **Location** | `resources/views/pages/home.blade.php` |
| **Why it happens** | Decorative background without photography. |
| **Recommended fix** | Replace with real hero photography or restrained solid/texture background per brand guidelines. |
| **Risk** | **Low** — visual polish. |

---

### 26. Settings table empty (defaults only)

| Field | Detail |
|-------|--------|
| **Problem** | `settings` table has 0 rows; Spatie settings use class defaults until admin saves. |
| **Location** | `app/Settings/GeneralSettings.php`; `app/Settings/SeoSettings.php` |
| **Why it happens** | No settings seeder/migration payloads (`database/settings/` directory absent). |
| **Recommended fix** | Optional settings seeder for dev demo values (site name, WhatsApp, SEO defaults). |
| **Risk** | **Low** — expected for Spatie until first save. |

---

### 27. Vite manifest errors during tests when build absent

| Field | Detail |
|-------|--------|
| **Problem** | Log shows `Vite manifest not found` during some test/error-page renders. |
| **Location** | `storage/logs/laravel.log` (testing channel) |
| **Why it happens** | Tests run without `npm run build` in CI unless scripted. |
| **Recommended fix** | Use `TestingWithoutVite` trait or ensure CI runs build. |
| **Risk** | **Low** — tests currently pass; error pages may fail in test env. |

---

## Verified Working

| Area | Status |
|------|--------|
| Laravel 13 + Filament 5 + Livewire 4 installed | ✅ |
| 25 migrations applied | ✅ |
| `public/storage` symlink | ✅ |
| Locale routing `/en`, `/ar`, `/ru` (static pages) | ✅ |
| RTL on `/ar` (tests + layout `dir`) | ✅ |
| Property listing + Livewire filters (listing page) | ✅ |
| Contact form validation + lead storage + admin notification (tests) | ✅ |
| Filament admin auth (super admin gate) | ✅ |
| Lead create disabled in admin (leads from forms only) | ✅ |
| `npm run build` | ✅ |
| PHPUnit (18 tests) | ✅ |
| Sitemap + robots routes registered | ✅ |
| Brand tokens in CSS + logo component | ✅ |
| Map URL parser wired on property create/edit | ✅ |

---

## Recommended Fix Order

1. **Fix translatable slug resolution** (SQLite + MySQL) — unblocks all detail pages  
2. **Add detail-route feature tests** — prevent regression  
3. **Seed demo media + WhatsApp settings** — makes QA meaningful  
4. **Complete property detail page** (videos, features, map embed, gallery)  
5. **Wire `ImageOptimizer`** to upload pipeline  
6. **Fix hreflang + language switcher** on detail pages  
7. **Complete filters** (floor UI/type, oldest sort, mobile filter UX)  
8. **Add Russian (and Arabic) public lang files**  
9. **Remove font conflict; fix retina logo**  
10. **Filament admin UX** (features repeater, clearer sections)  
11. **Homepage + card UI overhaul** (search block, layout rhythm, photography)  
12. **Performance pass** (sitemap chunking, N+1 review, image sizes)  
13. **Security hardening** (rate limits, production credential checklist)

---

*End of audit. No code changes were made during this inspection.*

---

## Repair Log (2026-08-31)

Phased repairs completed after audit approval. **27/27 PHPUnit tests passing.** Live HTTP 200 on homepage, property, and service detail pages.

| Audit # | Issue | Status |
|---------|-------|--------|
| 1 | Slug binding SQLite/MySQL | ✅ Fixed — Laravel JSON path in `HasTranslatableSlug` |
| 2 | Detail route tests | ✅ Added `DetailRouteTest` (6 tests) |
| 3 | No property media in seed | ✅ `PropertySeeder` + placeholder WebP images |
| 4 | ImageOptimizer unused | ✅ Observers + `UploadedImageProcessor` wired for all entities |
| 5 | Property detail incomplete | ✅ Videos, features, map embed, gallery |
| 6 | No video rendering | ✅ `x-video-embed` on all detail pages |
| 7 | WhatsApp inactive | ✅ Settings migrations + `SettingsSeeder` |
| 8 | Russian UI untranslated | ✅ `lang/ar.json`, `lang/ru.json` (public strings) |
| 9 | hreflang / language switcher | ✅ `LocalizedUrlGenerator` |
| 10 | Floor filter type/UI | ✅ `?string` + filter input |
| 11 | Missing oldest sort | ✅ Added |
| 12 | SQLite vs MySQL docs | ⚠️ Slug queries fixed; `.env.example` still MySQL |
| 13 | Font conflict | ✅ Instrument Sans removed from Vite |
| 14 | Homepage search | ✅ Hero search block |
| 15 | Mobile filters | ✅ Alpine drawer component |
| 16 | Property cards | ✅ Bathrooms + thumbnails |
| 17 | Admin features textarea | ✅ Per-locale repeater |
| 18 | Sitemap memory | ✅ Chunked queries (100) |
| 19 | Retina logo | ✅ Generated 256×256 `@2x` from 128×128 source |
| 20 | Contact rate limiting | ✅ 5/min per IP + test |
| 21 | Orphan CreateLead | ✅ Deleted |
| 22 | Service/package/project detail | ✅ Aligned with property template |
| 25 | Hero radial gradients | ✅ Replaced with clean 2-column layout |
| 26 | Empty settings | ✅ Seeded (15 rows) |

### Post-repair fixes (2026-08-31, session 2)

| Item | Status |
|------|--------|
| Duplicate service/package seed copy | ✅ Unique descriptions per entity |
| ImageOptimizer API (`decodePath`) | ✅ Fixed Intervention Image v4 calls |
| Filament dashboard | ✅ Stat cards link to resources; AccountWidget removed |
| Retina logo | ✅ `egyptra-logo@2x.png` at 256×256 |
| RU/AR detail routes 404 | ✅ Slug binding reads route locale; routes use `{property}` not `{property:slug}` |
| Deployment doc | ✅ Settings seeder + go-live checklist items |

### Remaining (low priority)

- Replace `@2x` logo with vector/high-res brand export when available
- CI: `TestingWithoutVite` trait for test runs without build
