# Fitaa Properties

WordPress + WooCommerce site for **Fitaa Properties**, a property company that:

1. runs **Fitaa Homes** — furnished short stays (two homes so far: **Fitaa House Southampton** and **SA Endeavours**),
2. offers **long-term rentals**, and
3. recruits **landlords** with a guaranteed-rent and full-management proposition to grow the portfolio.

Git workflow: commit straight to `main` (the default branch). No PRs unless asked.

## Brand

- **Look:** black and purple. Near-black backgrounds, vivid violet accents, soft lilac for emphasis. Dark, calm, premium; lots of space.
- **Palette** (CSS variables in `assets/css/main.css`): `--black #08050d`, `--ink #0f0a18`, `--panel #160e24`, `--purple #8b3dff`, `--purple-2 #a96bff`, `--lilac #d9c4ff`, `--white #f6f1ff`, `--muted #a79bbd`.
- **Type:** Fraunces (light serif, italics for emphasis words) for display; Manrope for body and UI.
- **Voice:** warm, confident, plain English, British spelling. Short sentences. No hype or invented numbers.
- **Motion:** scroll-driven and smooth (GSAP + ScrollTrigger + Lenis), always with a `prefers-reduced-motion` fallback and a vertical fallback for the pinned tour on screens under 961px.

## Content rules

- Only state facts we know. Do **not** invent prices, rent percentages, guarantee lengths, capacity numbers, awards, addresses or contact details.
- Contact details (email, phone, WhatsApp, Instagram, booking URL, landlord-lead email) come from **Appearance → Customize → Fitaa contact & social**; never hard-code them.
- Fitaa House Southampton facts live in `images/fitaa-house-southampton/README.md` (Flat 1, Ibex House, 7 The Carronades; one bedroom with zip-and-link bed; sofa bed; full kitchen; bath with rainfall shower; no smoking). SA Endeavours facts live in `images/sa-endeavours/README.md` (only what the photos show). Check them before writing copy.
- No rates, deposits, check-in times or street addresses are published yet. Meeting notes in Google Drive mention rates and partner commercial terms but they are preliminary; get the owner's go-ahead before publishing any of it.
- Never copy credentials from Drive notes into the repo or the site.

## Layout

```
CLAUDE.md
images/fitaa-house-southampton/     original photos + README with layout facts (source of truth)
images/sa-endeavours/               JPEG exports (watermark cropped, duplicates dropped) + README with layout facts
wp-content/themes/fitaa-properties/
  style.css                         theme header only
  functions.php                     loads inc/*
  inc/                              setup, enqueue, customizer, helpers, landlord-form, pages, woocommerce
  header.php / footer.php
  front-page.php                    Fitaa House Southampton homepage (exterior hero -> pinned spiral-column room tour -> bed toggle -> details -> booking -> SA Endeavours link -> landlord band)
  page-sa-endeavours.php            template "SA Endeavours": same flow for the second home
  inc/properties.php                registry of properties: name, photo folder, tour rooms (big + corner photo), detail shots
  inc/booking.php                   "Bookings" post type, request handler, blocked-date logic, admin meta box, emails
  template-parts/property-tour.php, property-details.php, booking-widget.php   shared sections driven by the registry
  assets/js/booking.js              vanilla range date picker (blocked nights, same-day turnover)
  page-landlords.php                template "Landlords": benefits, how it works, comparison, FAQ, enquiry form
  page-stays.php                    template "Stays & Rentals": short stays + long-term rentals, WooCommerce product lists, enquiry form
  woocommerce.php                   single wrapper for all WooCommerce views
  template-parts/enquiry-form.php   shared form (admin-post handler in inc/landlord-form.php)
  assets/css/main.css, woocommerce.css
  assets/js/main.js                 all scroll choreography
  assets/js/vendor/                 GSAP 3.12.5, ScrollTrigger, Lenis 1.1.20 (vendored, see README there)
  assets/img/southampton/, assets/img/sa-endeavours/   WebP copies (max 1600px) of the originals
```

## Setup in WordPress

1. Copy `wp-content/themes/fitaa-properties` into the site's `wp-content/themes/` and activate it. Activation creates the **Fitaa House Southampton** (front page), **Landlords** and **Stays & Rentals** pages and a primary menu.
2. Install WooCommerce. Create product categories with slugs `short-stays` and `long-term-rentals`; products in them are listed on the Stays page automatically.
3. Fill in the Customizer contact section so footer links and the enquiry/booking email recipient work.
4. Bookings: guests send a request from the date picker (no online payment). It appears under **Bookings** as Pending and emails the team; set it to **Confirmed** (or Declined) to email the guest. Only Confirmed bookings block dates. To block dates for an Airbnb stay or owner use, add a booking with status Confirmed.

## Conventions

- PHP: WordPress coding standards, escape on output, nonce + honeypot on forms. Lint with `php -l`.
- Images: add originals under `images/<property>/`, then export a max-1600px WebP into the theme's `assets/img/` and reference via `fitaa_photo()` / `fitaa_img()`.
- Animations hook into `data-*` attributes (`data-reveal`, `data-split`, `data-parallax`, `data-tour*`, `data-bed*`, `data-step`); add new behaviour in `assets/js/main.js`, not inline.
- Adding a property: add photos under `images/<slug>/` and `assets/img/<slug>/`, add an entry to `fitaa_properties()` (rooms with `img`/`img2` = big + corner photo), copy `page-sa-endeavours.php`, and add it to the page list in `inc/pages.php`.
- Keep `.claude/settings.json` plugin list (Three.js, GSAP, Locomotive Scroll, meta-skills, animation-components) in sync with what the team uses.

## Verifying changes

WordPress itself is not available in the cloud container, so templates were previewed by rendering them through a small PHP shim and screenshotting with Playwright. Real WordPress/WooCommerce behaviour (activation hook, menus, forms, product lists) has **not** been tested here — check it on a staging site.
