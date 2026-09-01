# Tema-filho Neon Cyberpunk Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Build a WordPress child theme, `leo-nunes-portfolio-neon`, that reskins the live `leo-nunes-portfolio-dinamico-v4` theme into the approved "Cyberpunk / Neon Dark" visual, activatable/reversible with one click in Appearance > Themes, with zero changes to the parent theme's PHP templates, ACF fields, or CPTs.

**Architecture:** A child theme inherits all PHP templates and the `leo_port_scripts()` enqueue call from the parent automatically. The child only ships a `style.css` header (WordPress requirement to register it as a child theme) and a `functions.php` that enqueues two new stylesheets — `theme-tokens.css` (CSS custom-property overrides) and `neon-theme.css` (component-level glow/gradient enhancements) — after the parent's `main` handle, using WordPress's dependency system so load order is guaranteed regardless of hook priority.

**Tech Stack:** WordPress child theme (PHP, CSS custom properties), Google Fonts (Space Grotesk, Inter, JetBrains Mono), existing parent-theme JS libraries (AOS, typed.js, GLightbox, Swiper, Isotope, PureCounter) — untouched.

**Spec:** `wp-content/themes/leo-nunes-portfolio-dinamico-v4/docs/superpowers/specs/2026-08-31-tema-neon-cyberpunk-design.md`

## Global Constraints

- Parent theme files (`*.php`, `inc/*.php`, `assets/css/main.css`) are never modified.
- ACF field groups, CPTs, and existing production data/media are never touched.
- Only ever escreve dentro de `wp-content/themes/leo-nunes-portfolio-neon/`.
- Dark mode only — no light/dark toggle.
- Animation level "Sutil": no particles, no heavy glitch, no custom cursor.
- Palette: `--accent-color: #00ffe0` (ciano), `--accent-color-alt: #ff2ee6` (magenta), backgrounds `#0a0a12` / `#12121c` / `#05050a`.
- Fonts: headings `Space Grotesk`, body `Inter`, code/mono accents `JetBrains Mono`.
- All work happens locally (XAMPP) first; nothing is uploaded to production as part of this plan.

---

## File Structure

```
wp-content/themes/leo-nunes-portfolio-neon/
├── style.css                    # Child-theme header (required by WordPress)
├── functions.php                # Enqueues parent deps + tokens.css + neon-theme.css + Google Fonts
└── assets/
    └── css/
        ├── theme-tokens.css     # :root variable overrides consumed by main.css's existing var()s
        └── neon-theme.css       # Component-specific glow/gradient rules, keyed to real selectors in main.css
```

**Interfaces this plan relies on (already present in the parent theme, verified by reading the files):**
- Parent's `functions.php` registers a style handle named `main` for `assets/css/main.css` and a style handle named `theme-style` for `get_stylesheet_uri()` (i.e., the active theme's own `style.css` — resolves to the child's when the child is active).
- `main.css` defines these `:root` custom properties consumed throughout the stylesheet via `var(...)`: `--default-font`, `--heading-font`, `--nav-font`, `--background-color`, `--default-color`, `--heading-color`, `--accent-color`, `--surface-color`, `--contrast-color`, `--nav-color`, `--nav-hover-color`, `--nav-mobile-background-color`, `--nav-dropdown-background-color`, `--nav-dropdown-color`, `--nav-dropdown-hover-color`. It also defines `.light-background` and `.dark-background` classes that locally override a subset of those variables — used on alternating sections (`#portfolio`, `#about`, `#skills`, `#testimonials`, `#footer` = `.light-background`; `#header`, `#hero` = `.dark-background`).
- Real section/component selectors confirmed in `front-page.php`, `header.php`, `footer.php`, `inc/portfolio-helpers.php`, and `assets/css/main.css` (used verbatim in Task 3 below — no invented class names).

---

### Task 1: Scaffold the child theme (style.css + functions.php)

**Files:**
- Create: `wp-content/themes/leo-nunes-portfolio-neon/style.css`
- Create: `wp-content/themes/leo-nunes-portfolio-neon/functions.php`
- Create: `wp-content/themes/leo-nunes-portfolio-neon/assets/css/theme-tokens.css` (stub, filled in Task 2)
- Create: `wp-content/themes/leo-nunes-portfolio-neon/assets/css/neon-theme.css` (stub, filled in Task 3)

**Interfaces:**
- Consumes: parent style handle `main` (registered by `leo_port_scripts()` in `wp-content/themes/leo-nunes-portfolio-dinamico-v4/functions.php`).
- Produces: style handles `leo-neon-tokens` and `leo-neon-theme`, and `google-fonts-neon` — later tasks (and QA) reference these handle names.

- [ ] **Step 1: Create `style.css` with the required child-theme header**

```css
/*
Theme Name: Léo Nunes Portfólio - Neon Cyberpunk
Template: leo-nunes-portfolio-dinamico-v4
Description: Reskin visual "Cyberpunk / Neon Dark" do tema Léo Nunes Portfólio. Herda templates, campos ACF e CPTs do tema original sem alterá-los. Ative para testar; reative o tema original em Aparência > Temas para reverter instantaneamente.
Author: Léo Nunes
Version: 1.0.0
Text Domain: leo-nunes-portfolio-neon
*/
```

`Template:` must match the parent theme's folder name exactly (`leo-nunes-portfolio-dinamico-v4`) — this is the line that makes WordPress treat this as a child theme instead of a broken standalone one.

- [ ] **Step 2: Create the two (empty-but-valid) CSS stub files**

`wp-content/themes/leo-nunes-portfolio-neon/assets/css/theme-tokens.css`:

```css
/* Léo Nunes Portfólio Neon — Design Tokens (preenchido na Task 2) */
```

`wp-content/themes/leo-nunes-portfolio-neon/assets/css/neon-theme.css`:

```css
/* Léo Nunes Portfólio Neon — Estilos de componente (preenchido na Task 3) */
```

- [ ] **Step 3: Create `functions.php` with the enqueue logic**

```php
<?php
/**
 * Enfileira os estilos do tema-filho Neon Cyberpunk por cima do tema pai.
 * Prioridade 20 (o pai usa a padrão, 10) garante que rode depois, e a
 * dependência explícita em "main" garante a ordem de saída no <head>
 * independentemente da prioridade do hook.
 */
function leo_neon_enqueue_assets() {
	$ver = wp_get_environment_type() === 'production' ? '1.0.0' : (string) time();

	wp_enqueue_style(
		'google-fonts-neon',
		'https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;700;800&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500&display=swap',
		[],
		null
	);

	wp_enqueue_style(
		'leo-neon-tokens',
		get_stylesheet_directory_uri() . '/assets/css/theme-tokens.css',
		[ 'main', 'google-fonts-neon' ],
		$ver
	);

	wp_enqueue_style(
		'leo-neon-theme',
		get_stylesheet_directory_uri() . '/assets/css/neon-theme.css',
		[ 'leo-neon-tokens' ],
		$ver
	);
}
add_action( 'wp_enqueue_scripts', 'leo_neon_enqueue_assets', 20 );
```

- [ ] **Step 4: Verify PHP syntax**

Run:
```bash
php -l "C:\xampp\htdocs\portfolio\wp-content\themes\leo-nunes-portfolio-neon\functions.php"
```
Expected: `No syntax errors detected in ...functions.php`

- [ ] **Step 5: Commit**

```bash
git add wp-content/themes/leo-nunes-portfolio-neon
git commit -m "Scaffold leo-nunes-portfolio-neon child theme"
```

---

### Task 2: Design tokens (`theme-tokens.css`)

**Files:**
- Modify: `wp-content/themes/leo-nunes-portfolio-neon/assets/css/theme-tokens.css`

**Interfaces:**
- Consumes: the exact `:root` variable names listed in "File Structure" above (must match `main.css` verbatim or the override has no effect).
- Produces: the same variable names, redefined — every later CSS rule in Task 3 that uses `var(--accent-color)`, `var(--neon-gradient)`, `var(--neon-glow-cyan)`, etc. depends on this file loading first (already guaranteed by the `leo-neon-tokens` dependency in Task 1).

- [ ] **Step 1: Write the token overrides**

```css
/* Léo Nunes Portfólio Neon — Design Tokens */

:root {
  /* Fontes */
  --default-font: "Inter", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
  --heading-font: "Space Grotesk", sans-serif;
  --nav-font: "Space Grotesk", sans-serif;
  --code-font: "JetBrains Mono", monospace;

  /* Cores globais (sobrescreve main.css) */
  --background-color: #0a0a12;
  --default-color: #f5f5fa;
  --heading-color: #ffffff;
  --accent-color: #00ffe0;
  --accent-color-alt: #ff2ee6;
  --surface-color: #12121c;
  --contrast-color: #0a0a12;

  /* Tokens novos, exclusivos do tema neon */
  --neon-gradient: linear-gradient(90deg, #00ffe0, #ff2ee6);
  --neon-glow-cyan: 0 0 10px rgba(0, 255, 224, 0.6);
  --neon-glow-magenta: 0 0 10px rgba(255, 46, 230, 0.55);
}

:root {
  --nav-color: #9aa0b4;
  --nav-hover-color: #00ffe0;
  --nav-mobile-background-color: #0a0a12;
  --nav-dropdown-background-color: #0a0a12;
  --nav-dropdown-color: #9aa0b4;
  --nav-dropdown-hover-color: #00ffe0;
}

.light-background {
  --background-color: #12121c;
  --surface-color: #171727;
}

.dark-background {
  --background-color: #05050a;
  --default-color: #f5f5fa;
  --heading-color: #ffffff;
  --surface-color: #12121c;
  --contrast-color: #0a0a12;
}
```

- [ ] **Step 2: Verify the file is valid CSS (no unclosed braces)**

Run:
```bash
node -e "require('fs').readFileSync('C:/xampp/htdocs/portfolio/wp-content/themes/leo-nunes-portfolio-neon/assets/css/theme-tokens.css','utf8').split('{').length === require('fs').readFileSync('C:/xampp/htdocs/portfolio/wp-content/themes/leo-nunes-portfolio-neon/assets/css/theme-tokens.css','utf8').split('}').length ? console.log('OK: braces balanced') : (()=>{throw new Error('Unbalanced braces')})()"
```
Expected: `OK: braces balanced`

(If `node` isn't available, open the file and manually confirm every `{` has a matching `}` — there are 5 rule blocks in this file.)

- [ ] **Step 3: Commit**

```bash
git add wp-content/themes/leo-nunes-portfolio-neon/assets/css/theme-tokens.css
git commit -m "Add Neon Cyberpunk design tokens"
```

---

### Task 3: Component styling (`neon-theme.css`)

**Files:**
- Modify: `wp-content/themes/leo-nunes-portfolio-neon/assets/css/neon-theme.css`

**Interfaces:**
- Consumes: `var(--accent-color)`, `var(--accent-color-alt)`, `var(--contrast-color)`, `var(--code-font)`, `var(--heading-font)`, `var(--neon-gradient)`, `var(--neon-glow-cyan)`, `var(--neon-glow-magenta)` from Task 2's `theme-tokens.css`.
- Produces: final visual output — verified in Task 4.

Every selector below was confirmed against the real markup in `header.php`, `front-page.php`, `footer.php`, `inc/portfolio-helpers.php`, and the existing rules in `assets/css/main.css` (parent theme) — none are guessed.

- [ ] **Step 1: Write the component styles**

```css
/* Léo Nunes Portfólio Neon — Estilos de componente */

/* ===== Header / Sidebar Nav ===== */
#header.header {
  border-right: 1px solid rgba(0, 255, 224, 0.15);
}

.header .logo .sitename {
  font-family: var(--heading-font);
  text-shadow: var(--neon-glow-cyan);
}

.header .profile-img img {
  box-shadow: 0 0 16px rgba(0, 255, 224, 0.35);
}

.navmenu a:hover,
.navmenu .active,
.navmenu .active:focus {
  text-shadow: var(--neon-glow-cyan);
}

.navmenu .active {
  border-left: 2px solid var(--accent-color);
}

/* ===== Hero ===== */
.hero::after {
  content: "";
  position: absolute;
  inset: 0;
  z-index: 2;
  pointer-events: none;
  background-image:
    linear-gradient(90deg, rgba(0, 255, 224, 0.05) 1px, transparent 1px),
    linear-gradient(rgba(0, 255, 224, 0.05) 1px, transparent 1px);
  background-size: 40px 40px;
}

.hero h2 {
  font-family: var(--heading-font);
  text-shadow: var(--neon-glow-cyan);
}

.hero p .typed {
  font-family: var(--code-font);
  color: var(--accent-color);
}

.hero .typed-cursor {
  color: var(--accent-color);
}

/* ===== Títulos de seção (global) ===== */
.section-title h2 {
  font-family: var(--heading-font);
  text-shadow: var(--neon-glow-cyan);
}

.section-title h2:after {
  background: var(--neon-gradient) !important;
}

/* ===== Portfólio ===== */
.portfolio .portfolio-filters li.filter-active,
.portfolio .portfolio-filters li:hover {
  text-shadow: var(--neon-glow-cyan);
}

.portfolio .portfolio-content {
  border: 1px solid rgba(0, 255, 224, 0.12);
  border-radius: 8px;
  transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.portfolio .portfolio-content:hover {
  border-color: var(--accent-color);
  box-shadow: var(--neon-glow-cyan);
}

.portfolio .portfolio-content .portfolio-info h4 {
  background: var(--neon-gradient);
  color: var(--contrast-color);
}

.portfolio .btn-load-more {
  background: var(--neon-gradient);
  color: var(--contrast-color);
  box-shadow: var(--neon-glow-cyan);
}

/* ===== Serviços ===== */
.services .service-item {
  border: 1px solid rgba(0, 255, 224, 0.12);
  border-radius: 8px;
  padding: 20px;
  transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.services .service-item:hover {
  border-color: var(--accent-color);
  box-shadow: var(--neon-glow-cyan);
}

.services .service-item .icon i {
  color: var(--accent-color);
  text-shadow: var(--neon-glow-cyan);
}

/* ===== Sobre mim ===== */
.about img {
  box-shadow: 0 0 24px rgba(0, 255, 224, 0.25);
}

.about .content ul li i.bi-chevron-right {
  color: var(--accent-color);
}

/* ===== Resumo / Timeline ===== */
.resume .resume-item h4,
.resume .timeline-swiper .resume-item h4 {
  font-family: var(--heading-font);
  color: var(--accent-color);
}

.resume .resume-item::before,
.resume .timeline-swiper .resume-item::before {
  background-color: var(--accent-color);
  box-shadow: var(--neon-glow-cyan);
}

.resume .timeline-swiper .swiper-pagination .swiper-pagination-bullet-active {
  background: var(--accent-color);
}

/* ===== Skills ===== */
.skills .progress-bar-wrap {
  background-color: rgba(255, 255, 255, 0.08);
}

.skills .progress-bar {
  background: var(--neon-gradient);
  box-shadow: var(--neon-glow-cyan);
}

.skills .skill .val {
  color: var(--accent-color);
  font-family: var(--code-font);
}

/* ===== Estatísticas ===== */
.stats .stats-item i {
  color: var(--accent-color);
  text-shadow: var(--neon-glow-cyan);
}

.stats .stats-item .purecounter {
  font-family: var(--heading-font);
  text-shadow: var(--neon-glow-cyan);
}

/* ===== Depoimentos ===== */
.testimonials .testimonial-item {
  border: 1px solid rgba(0, 255, 224, 0.12);
  border-radius: 8px;
}

.testimonials .testimonial-item .quote-icon-left,
.testimonials .testimonial-item .quote-icon-right {
  color: var(--accent-color-alt);
}

.testimonials .testimonial-item .testimonial-img {
  border: 2px solid var(--accent-color);
}

.testimonials .swiper-pagination .swiper-pagination-bullet-active {
  background-color: var(--accent-color);
}

/* ===== Contato ===== */
.contact .info-item i {
  color: var(--accent-color);
  text-shadow: var(--neon-glow-cyan);
}

.contact .php-email-form input[type=text],
.contact .php-email-form input[type=email],
.contact .php-email-form textarea {
  background-color: rgba(255, 255, 255, 0.04);
  border: 1px solid rgba(0, 255, 224, 0.2);
  color: var(--default-color);
}

.contact .php-email-form input[type=text]:focus,
.contact .php-email-form input[type=email]:focus,
.contact .php-email-form textarea:focus {
  border-color: var(--accent-color);
  box-shadow: var(--neon-glow-cyan);
}

.contact .php-email-form button[type=submit] {
  background: var(--neon-gradient);
  color: var(--contrast-color);
  border: none;
}

.contact .php-email-form button[type=submit]:hover {
  box-shadow: var(--neon-glow-cyan);
}

/* ===== Footer ===== */
#footer.footer {
  border-top: 1px solid rgba(0, 255, 224, 0.12);
}

.footer .copyright .sitename {
  font-family: var(--code-font);
  color: var(--accent-color);
}

#whatsapp-float {
  box-shadow: var(--neon-glow-cyan);
}

.scroll-top:hover {
  box-shadow: var(--neon-glow-cyan);
}
```

- [ ] **Step 2: Verify the file is valid CSS (no unclosed braces)**

Run:
```bash
node -e "const s=require('fs').readFileSync('C:/xampp/htdocs/portfolio/wp-content/themes/leo-nunes-portfolio-neon/assets/css/neon-theme.css','utf8'); s.split('{').length === s.split('}').length ? console.log('OK: braces balanced') : (()=>{throw new Error('Unbalanced braces')})()"
```
Expected: `OK: braces balanced`

- [ ] **Step 3: Commit**

```bash
git add wp-content/themes/leo-nunes-portfolio-neon/assets/css/neon-theme.css
git commit -m "Add Neon Cyberpunk component styling"
```

---

### Task 4: Activate locally, run the spec's QA pass, and package the zip

**Files:**
- No new files — this task activates and verifies the theme built in Tasks 1–3, then produces a distributable zip.

**Interfaces:**
- Consumes: the fully-built `leo-nunes-portfolio-neon` theme from Tasks 1–3.
- Produces: `leo-nunes-portfolio-neon.zip`, delivered to the user for local browser testing and later FTP upload to production.

- [ ] **Step 1: Activate the child theme on the local database**

The local site has no WP-CLI installed, so activate directly via the same two `wp_options` rows WordPress's own "Activate" button writes (`template` = parent folder, `stylesheet` = child folder):

```bash
"/c/xampp/mysql/bin/mysql.exe" -u root -e "UPDATE portfolio.wp_options SET option_value='leo-nunes-portfolio-dinamico-v4' WHERE option_name='template'; UPDATE portfolio.wp_options SET option_value='leo-nunes-portfolio-neon' WHERE option_name='stylesheet';"
```

- [ ] **Step 2: Confirm the new stylesheets are actually being served**

```bash
curl -s http://localhost/portfolio/ | grep -o "leo-neon-tokens-css\|leo-neon-theme-css\|fonts.googleapis.com"
```
Expected: all three markers present in the output (WordPress appends `-css` to style handles in the generated `<link>` `id` attribute).

- [ ] **Step 3: Visual QA pass in the browser**

Open `http://localhost/portfolio/` and, per the spec's test plan, check:
- Every section renders with the dark neon palette (Header/sidebar, Hero, Portfólio, Serviços, Sobre mim, Resumo, Skills, Estatísticas, Depoimentos, Contato, Footer).
- Text stays readable (no low-contrast ciano/magenta-on-dark combinations).
- Portfolio filter clicks (Isotope) and the lightbox (GLightbox) still work.
- The testimonials carousel (Swiper) still auto-plays and paginates.
- The contact form still submits (or shows its validation states).
- Open one single item of each CPT (`portfolio`, `depoimento`, `servico`, `formacao`, `experiencia`) if it has a dedicated `single.php` view, to confirm header/footer/typography reskin applies site-wide.
- Resize to mobile/tablet widths and confirm the layout still works (Bootstrap grid untouched, so this should already hold).

If anything looks wrong, fix it in `neon-theme.css` (Task 3's file) and re-run Step 2.

- [ ] **Step 4: Package the theme as a zip for the user**

```powershell
Compress-Archive -Path "C:\xampp\htdocs\portfolio\wp-content\themes\leo-nunes-portfolio-neon" -DestinationPath "$env:LOCALAPPDATA\Temp\claude\C--xampp-htdocs-portfolio-wp-content-themes-leo-nunes-portfolio-dinamico-v4\d936c8cc-cd57-4673-91d3-079350acde95\scratchpad\deploy\leo-nunes-portfolio-neon.zip" -Force
```

Send the resulting zip to the user (they already have the "activate/deactivate in Appearance > Themes" instructions from the spec for testing in production once approved locally).

- [ ] **Step 5: Commit**

```bash
git add wp-content/themes/leo-nunes-portfolio-neon
git commit -m "Finish Neon Cyberpunk child theme v1.0.0"
```
