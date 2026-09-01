# Egyptra Design System

Implementation reference derived from the **Egyptra Brand Identity System** and **Test Page** prototype. The production site must express this system faithfully — not reinterpret it as generic real-estate UI.

## Source of truth

| Reference | Role |
|-----------|------|
| Brand Identity System | Colors, typography, tone |
| Test Page prototype | Layout rhythm, section patterns, component behavior |
| `resources/css/app.css` | Canonical tokens and component classes |
| `docs/frontend-design-system.md` | Quick token lookup for developers |

## Colors

Use only the official palette. Do not introduce arbitrary blues, gold, purple gradients, or SaaS-style neutrals.

| Token | Hex | Tailwind | Usage |
|-------|-----|----------|--------|
| Lavender | `#DADFF7` | `lavender`, `lavender-200` | Page sections, search surfaces, borders |
| Ink | `#232C33` | `ink` | Hero backgrounds, footer, headings, navigation |
| Sky | `#A0C1D1` | `sky` | CTA bands, accents, footer text on ink |
| Ash | `#B5B2C2` | `ash` | Secondary text, muted metadata |
| Teal | `#5A7D7C` | `teal` | Primary buttons, links, filter labels |
| Label | `#E8614A` | `accent` | DM Mono labels, section metadata (`.brand-label`) |

Neutral variants (`ink-700`, `lavender-50`) exist only for borders, overlays, and accessibility — not as alternate brand colors.

## Typography

| Role | Font | CSS variable | Tailwind |
|------|------|--------------|----------|
| Display | Playfair Display | `--font-display` | `font-display` |
| Body | Jost | `--font-sans` | default / `font-sans` |
| Mono | DM Mono | `--font-mono` | `font-mono` |

### Type scale

| Style | Font | Size | Line height |
|-------|------|------|-------------|
| H1 | Playfair | 60px (clamp down on mobile) | 1.05 |
| H2 | Playfair | 36px | 1.15 |
| H3 | Playfair | 24px | 1.3 |
| Body large | Jost | 18px | 1.6 |
| Body | Jost | 16px | 1.6 |
| Caption | Jost | 12px | 1.5 |
| Label | DM Mono | 11px | 1.4 |

Headings use `font-display`. Labels and metadata use `.brand-label` (DM Mono, uppercase, accent color).

## Layout

| Token | Value |
|-------|-------|
| Max content width | **1180px** (`.brand-container`) |
| Horizontal padding | `1rem` mobile → `1.5rem` sm → `2rem` lg |
| Section spacing | `.brand-section` — `4rem` vertical padding |
| Grid gap | `1.5rem` cards, `2rem` major grids |

Spatial language from the test page: generous whitespace, wide containers, strong horizontal rhythm, restrained shadows.

## Radius & elevation

- **Prefer square or `rounded-sm`** (2–4px). Avoid `rounded-2xl`, pills, and glassmorphism.
- Shadows: minimal — `shadow-sm` at most; no hover lift on cards.
- Borders: `border-lavender-200` on light surfaces; `border-ink-700` on ink surfaces.

## Components

### Buttons

| Class | Use |
|-------|-----|
| `.btn-primary` | Teal fill, ink/white text, square corners |
| `.btn-secondary` | Ink border on lavender/white |
| `.btn-sky` | Sky fill for CTA bands on ink backgrounds |
| `.btn-whatsapp` | WhatsApp green — only for WhatsApp actions |

Generous horizontal padding, clear typography, restrained hover (color shift only).

### Cards

| Class | Use |
|-------|-----|
| `.card-brand` | Generic content card — square, border, no heavy shadow |
| `.card-property` | Editorial property listing card — image-led |

Property card hierarchy: **Image → metadata → location → title → price → specs**.

### Forms

| Class | Use |
|-------|-----|
| `.input-brand` | Text inputs and selects |
| `.search-panel` | Homepage / hero property search block |

Search UI: lavender surface, ink text, teal/mono labels, minimal radius.

### Sections

| Class | Use |
|-------|-----|
| `.brand-section` | Standard vertical section padding |
| `.brand-section--lavender` | Lavender background band |
| `.brand-section--ink` | Dark ink hero/footer bands |
| `.brand-section--sky` | Sky CTA band |

### Navigation

Ink header on public site: understated links, sky/teal active state, square locale switcher, no pill UI.

## Motion

- Subtle fade/slide on scroll via `.reveal` (respects `prefers-reduced-motion`).
- Duration ~300ms. No parallax, floating gradients, or excessive animation.

## RTL (Arabic)

- Layout uses logical properties (`start`/`end`, `border-s`, `ps`/`pe`) where possible.
- Typography hierarchy unchanged; spacing mirrored intentionally, not blindly flipped.

## Accessibility

- Maintain contrast on ink + sky/lavender combinations.
- Visible focus rings (`focus-visible:ring-sky`).
- Semantic headings, form labels, alt text on images.

## Do not

- Substitute Inter, Roboto, Poppins, or system fonts for brand fonts.
- Replace ink/lavender heroes with navy/white or gradient overlays.
- Use identical card grids for every section — vary composition while keeping tokens.
- Break Livewire, routes, translations, or SEO when styling.

## File map

| Area | Files |
|------|-------|
| Tokens & components | `resources/css/app.css` |
| Layout | `resources/views/layouts/app.blade.php` |
| Property card | `resources/views/components/property-card.blade.php` |
| Filters | `resources/views/components/property-filters.blade.php` |
| Homepage | `resources/views/pages/home.blade.php` |
| Page chrome | `resources/views/components/page-header.blade.php` |
