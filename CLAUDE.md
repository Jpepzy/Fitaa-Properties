# Fitaa Properties

WordPress + WooCommerce site for **Fitaa Properties**, a property company that:

1. runs **Fitaa Homes** — furnished short stays (Fitaa House Southampton is the first listing),
2. offers **long-term rentals**, and
3. recruits **landlords** with a guaranteed-rent and full-management proposition to grow the portfolio.

Git workflow: commit straight to `main` (the default branch). No PRs unless asked.

## Brand

- **Look:** light and warm, coloured from the Fitaa Homes logo. Warm-white pages, plum and magenta accents, near-black text like the logo's house outline. The photo hero, the room tour and the landlord band stay dark for contrast.
- **Palette** (CSS variables in `assets/css/main.css`): `--bg #fbf8fb`, `--surface #f4eef5`, `--panel #ffffff`, `--text #1a1220`, `--text-2 #43384a`, `--muted #6e6275`, `--accent #5a0a6a` (logo plum), `--accent-2 #8e1fa8` (logo magenta), `--btn` (magenta to plum gradient). Dark sections (`.hero`, `.tour`, `.landlord-band`, the header over the homepage hero) redefine the same variables, so components just use the variables. Every text colour has been checked for at least 4.5:1 contrast on its background.
- **Type:** Fraunces (light serif, italics for emphasis words) for display; Manrope for body and UI.
- **Logo:** the real Fitaa Homes logo (purple Gye Nyame in a black house outline) lives in `images/brand/` (original as supplied) and the theme's `assets/img/brand/` (header mark, footer lockup, favicon). Never redraw or recolour the mark. It is a raster on an off-white background: in the header it sits on a small white tile (`.brand__mark`), in the light footer it sits straight on the page (`mix-blend-mode: multiply`). Never put it directly on a dark section. A transparent SVG is still to come.
- **Voice:** warm, confident, plain English, British spelling. Short sentences. No hype or invented numbers.
- **Motion:** scroll-driven and smooth (GSAP + ScrollTrigger + Lenis), always with a `prefers-reduced-motion` fallback and a vertical fallback for the pinned tour on screens under 961px.

## Content rules

- Only state facts we know. Do **not** invent prices, rent percentages, guarantee lengths, capacity numbers, awards, addresses or contact details.
- Contact details (email, phone, WhatsApp, Instagram, booking URL, landlord-lead email) come from **Appearance → Customize → Fitaa contact & social**; never hard-code them.
- Fitaa House Southampton facts live in `images/fitaa-house-southampton/README.md` (Flat 1, Ibex House, 7 The Carronades; one bedroom with zip-and-link bed; sofa bed; full kitchen; bath with rainfall shower; no smoking). Check it before writing copy.

## Layout

```
CLAUDE.md
images/fitaa-house-southampton/     original photos + README with layout facts (source of truth)
wp-content/themes/fitaa-properties/
  style.css                         theme header only
  functions.php                     loads inc/*
  inc/                              setup, enqueue, customizer, helpers, landlord-form, pages, woocommerce
  header.php / footer.php
  front-page.php                    Fitaa House Southampton homepage (exterior hero -> pinned spiral-column room tour -> bed toggle -> details -> CTA -> landlord band)
  page-landlords.php                template "Landlords": benefits, how it works, comparison, FAQ, enquiry form
  page-stays.php                    template "Stays & Rentals": short stays + long-term rentals, WooCommerce product lists, enquiry form
  woocommerce.php                   single wrapper for all WooCommerce views
  template-parts/enquiry-form.php   shared form (admin-post handler in inc/landlord-form.php)
  assets/css/main.css, woocommerce.css
  assets/js/main.js                 all scroll choreography
  assets/js/vendor/                 GSAP 3.12.5, ScrollTrigger, Lenis 1.1.20 (vendored, see README there)
  assets/img/southampton/           WebP copies (max 1600px) of the originals
```

## Setup in WordPress

1. Copy `wp-content/themes/fitaa-properties` into the site's `wp-content/themes/` and activate it. Activation creates the **Fitaa House Southampton** (front page), **Landlords** and **Stays & Rentals** pages and a primary menu.
2. Install WooCommerce. Create product categories with slugs `short-stays` and `long-term-rentals`; products in them are listed on the Stays page automatically.
3. Fill in the Customizer contact section so footer links, the enquiry form recipient and the Book buttons work.

## Conventions

- PHP: WordPress coding standards, escape on output, nonce + honeypot on forms. Lint with `php -l`.
- Images: add originals under `images/<property>/`, then export a max-1600px WebP into the theme's `assets/img/` and reference via `fitaa_photo()` / `fitaa_img()`.
- Animations hook into `data-*` attributes (`data-reveal`, `data-split`, `data-parallax`, `data-tour*`, `data-bed*`, `data-step`); add new behaviour in `assets/js/main.js`, not inline.
- Keep `.claude/settings.json` plugin list (Three.js, GSAP, Locomotive Scroll, meta-skills, animation-components) in sync with what the team uses.

## Verifying changes

WordPress itself is not available in the cloud container, so templates were previewed by rendering them through a small PHP shim and screenshotting with Playwright. Real WordPress/WooCommerce behaviour (activation hook, menus, forms, product lists) has **not** been tested here — check it on a staging site.
