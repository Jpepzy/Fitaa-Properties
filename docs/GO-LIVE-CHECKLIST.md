# Fitaa Properties: go-live checklist

Tick items off as they are done (`- [x]`). Items marked **(owner)** need a decision or information from the owner. Items marked **(Claude)** can be done in a coding session.

## 0. Already done

- [x] WordPress theme built: Fitaa House Southampton homepage, SA Endeavours page, Stays & Rentals, Landlords
- [x] Spiral room tour (big photo + corner photo per step), details gallery, light plum/magenta brand
- [x] Date-picker booking requests with a Bookings admin screen and email notifications
- [x] Social icon support (shown only for links set in the Customizer)
- [x] Photos for both homes optimised (WebP) and watermark cropped
- [ ] Tested on a real WordPress site (so far only previewed through a PHP shim and screenshots)

## 1. Hosting and WordPress

- [ ] Choose hosting with PHP 8.1+ and HTTPS (WordPress-friendly managed host recommended)
- [ ] Register or point the domain; enable SSL and force HTTPS
- [ ] Install WordPress; set site title to **Fitaa Homes**, tagline, timezone (London) and date format
- [ ] Point fitaahomes.com at the site; redirect properties.fitaaglobal.com to it
- [ ] Upload `wp-content/themes/fitaa-properties` and activate it (this creates the pages and menu)
- [ ] Settings → Permalinks → "Post name", then save
- [ ] Settings → Reading → confirm "Fitaa House Southampton" is the homepage
- [ ] Install WooCommerce; create categories with slugs `short-stays` and `long-term-rentals`
- [ ] Set up a staging copy before changing anything live

## 2. Information I need from the owner (owner)

- [ ] Registered office address of Fitaa Properties Ltd for the footer (Customizer → "Registered office address"); a limited company's website must show it
- [x] Fitaa Creative website link for the footer credit: https://fitaacreative.com (set as the default; can be changed in the Customizer)

- [ ] Public email, phone and WhatsApp number
- [ ] Social profile links: Instagram, Facebook, TikTok, X, YouTube, LinkedIn (only the ones you use)
- [ ] Email address that should receive booking requests and landlord enquiries
- [ ] Rates, deposits and payment approach (the meeting notes in Drive are preliminary; confirm what can be published)
- [ ] Check-in and check-out times, house rules, cancellation policy
- [ ] Whether to show an address for either home (currently neither is shown; SA Endeavours stays name-only)
- [ ] Bed sizes and maximum guests for both homes
- [ ] Company name, registered number and registered office for the footer
- [ ] Transparent SVG of the Fitaa Homes logo (current logo is a raster on an off-white background)

## 3. Bookings

- [ ] Customizer → "Fitaa contact & social": fill in the booking recipient email
- [ ] Install an SMTP plugin (for example WP Mail SMTP) so booking emails reach inboxes, not spam
- [ ] Submit a test request on each home; check the admin email, the guest email and the Pending entry under Bookings
- [ ] Set the test to Confirmed and check the guest email and that the nights show as taken on the calendar
- [ ] Set up the Airbnb/Booking.com calendar sync (iCal links for both homes: **owner to send**; module to be built by Claude)
- [ ] Add existing future stays from other platforms as Confirmed bookings until iCal sync is live
- [ ] Decide on online payment (needs rates); if yes, connect WooCommerce payments and test a real transaction

## 4. Legal and privacy (check with an adviser where unsure)

- [ ] Privacy policy that covers booking and enquiry data
- [ ] Cookie notice if analytics or marketing scripts are added
- [ ] Terms and conditions for stays and cancellation terms
- [ ] Company details in the footer
- [ ] Check any short-let or licensing rules that apply to each property and its lease or tenancy
- [ ] Decide how long booking and enquiry records are kept, and who can see them

## 5. Content and photos

- [ ] Replace placeholder wording as real details arrive (rates, times, address)
- [ ] Fitaa House hero: swap in a wider, sharper exterior photo if available (current one is a portrait photo stretched wide)
- [ ] Review the blurry orange towel close-up in the SA Endeavours gallery; replace or remove
- [ ] Alt text for every photo (built in; re-read for accuracy)
- [ ] Landlord page: confirm every promise (guaranteed rent, void cover, maintenance, compliance) is something you will deliver, and add the real terms
- [ ] Proofread all pages on phone and desktop

## 6. SEO and discoverability

- [ ] Install an SEO plugin; set titles and meta descriptions for each page
- [ ] Add a social share image (Open Graph) using the logo and a hero photo
- [ ] Submit the sitemap to Google Search Console
- [ ] Claim and complete Google Business Profile
- [ ] Add analytics (with cookie notice if required)

## 7. Quality checks

- [ ] Phone, tablet and desktop in Safari, Chrome and Firefox
- [ ] Keyboard-only run through the menu, date picker and forms
- [ ] "Reduce motion" setting on: pages are readable and nothing is stuck hidden
- [ ] Spiral tour on desktop, vertical stack on phone
- [ ] Run Lighthouse; fix anything under 90 for performance or accessibility
- [ ] Spam test: forms use a hidden honeypot field and a security token; consider adding reCAPTCHA or Turnstile if spam appears

## 8. Security and backups

- [ ] Strong admin password and two-factor login
- [ ] Limit login attempts; remove the default `admin` user
- [ ] Automatic updates for WordPress, themes and plugins
- [ ] Daily offsite backups (files and database); test a restore once
- [ ] Rotate any password that was ever written in a document, and keep passwords in a password manager

## 9. Launch day

- [ ] Final staging review by the owner
- [ ] Point DNS to the live site; check SSL
- [ ] Re-run the booking test on the live site
- [ ] Confirm search engines are allowed to index (Settings → Reading)
- [ ] Tell Airbnb, Booking.com and social profiles the website address
- [ ] Take a manual backup

## 10. First two weeks

- [ ] Watch for booking emails landing in spam
- [ ] Check Bookings daily; confirm or decline within the time you promise guests
- [ ] Check Search Console for errors
- [ ] Review analytics and form entries; fix whatever confuses people
