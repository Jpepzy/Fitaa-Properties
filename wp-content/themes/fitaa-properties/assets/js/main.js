/* Fitaa Properties — scroll choreography (GSAP + ScrollTrigger + Lenis). */
(function () {
	'use strict';

	var doc = document;
	var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	var $ = function (s, c) { return (c || doc).querySelector(s); };
	var $$ = function (s, c) { return Array.prototype.slice.call((c || doc).querySelectorAll(s)); };

	/* ---------- Nav (works without GSAP) ---------- */
	var header = $('[data-header]');
	var nav = $('#site-nav');
	var toggle = $('[data-nav-toggle]');
	if (toggle && nav) {
		toggle.addEventListener('click', function () {
			var open = toggle.getAttribute('aria-expanded') !== 'true';
			toggle.setAttribute('aria-expanded', String(open));
			nav.classList.toggle('is-open', open);
			doc.documentElement.classList.toggle('nav-open', open);
		});
		$$('a', nav).forEach(function (a) {
			a.addEventListener('click', function () {
				toggle.setAttribute('aria-expanded', 'false');
				nav.classList.remove('is-open');
			});
		});
	}

	/* ---------- Bed toggle (works without GSAP) ---------- */
	var bedToggle = $('[data-bed-toggle]');
	var bedStage = $('[data-bed-stage]');
	if (bedToggle && bedStage) {
		bedStage.setAttribute('data-mode', 'double');
		$$('.toggle__btn', bedToggle).forEach(function (btn) {
			btn.addEventListener('click', function () {
				$$('.toggle__btn', bedToggle).forEach(function (b) {
					var on = b === btn;
					b.classList.toggle('is-active', on);
					b.setAttribute('aria-pressed', String(on));
				});
				bedStage.setAttribute('data-mode', btn.getAttribute('data-mode'));
			});
		});
	}

	/* ---------- Header state (works without GSAP) ---------- */
	var lastY = 0;
	function onScroll(y) {
		if (!header) { return; }
		header.classList.toggle('is-scrolled', y > 40);
		var goingDown = y > lastY && y > 400;
		header.classList.toggle('is-hidden', goingDown && !doc.documentElement.classList.contains('nav-open'));
		lastY = y;
	}
	window.addEventListener('scroll', function () { onScroll(window.scrollY); }, { passive: true });
	onScroll(window.scrollY);

	if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') {
		doc.documentElement.classList.remove('js');
		return;
	}
	gsap.registerPlugin(ScrollTrigger);

	if (reduce) {
		doc.documentElement.classList.remove('js');
		return;
	}

	/* ---------- Smooth scroll ---------- */
	var lenis = null;
	if (typeof Lenis !== 'undefined') {
		lenis = new Lenis({ lerp: 0.085, wheelMultiplier: 0.95 });
		lenis.on('scroll', ScrollTrigger.update);
		gsap.ticker.add(function (t) { lenis.raf(t * 1000); });
		gsap.ticker.lagSmoothing(0);
		$$('a[href^="#"]').forEach(function (a) {
			a.addEventListener('click', function (e) {
				var id = a.getAttribute('href');
				var target = id.length > 1 ? $(id) : null;
				if (target) { e.preventDefault(); lenis.scrollTo(target, { offset: -20, duration: 1.4 }); }
			});
		});
	}

	/* ---------- Scroll progress ---------- */
	var bar = $('[data-progress]');
	if (bar) {
		gsap.to(bar, { scaleX: 1, ease: 'none', scrollTrigger: { start: 0, end: 'max', scrub: 0.2 } });
	}

	/* ---------- Hero intro ---------- */
	var lines = $$('[data-hero-line]');
	var heroIn = $$('[data-hero-in]');
	var tl = gsap.timeline({ defaults: { ease: 'power4.out' }, delay: 0.15 });
	gsap.set(lines, { yPercent: 110 });
	tl.to(lines, { yPercent: 0, duration: 1.3, stagger: 0.14 })
	  .fromTo(heroIn, { y: 28, opacity: 0 }, { y: 0, opacity: 1, duration: 1, stagger: 0.12 }, '-=0.9');

	var heroMedia = $('[data-hero-media]');
	var hero = $('[data-hero]');
	if (heroMedia && hero) {
		gsap.fromTo(heroMedia, { scale: 1.18 }, { scale: 1, duration: 2.4, ease: 'power3.out' });
		gsap.to(heroMedia, {
			yPercent: 12, ease: 'none',
			scrollTrigger: { trigger: hero, start: 'top top', end: 'bottom top', scrub: true }
		});
		gsap.to($('.hero__content', hero), {
			yPercent: -18, opacity: 0.1, ease: 'none',
			scrollTrigger: { trigger: hero, start: '40% top', end: 'bottom top', scrub: true }
		});
	}

	/* ---------- Sub-page orb ---------- */
	$$('[data-orb]').forEach(function (orb) {
		gsap.to(orb, { yPercent: 25, xPercent: -8, scale: 1.15, ease: 'none',
			scrollTrigger: { trigger: orb.parentNode, start: 'top top', end: 'bottom top', scrub: true } });
		gsap.to(orb, { rotate: 360, duration: 60, repeat: -1, ease: 'none' });
	});

	/* ---------- Text + element reveals ---------- */
	$$('[data-split]').forEach(function (el) {
		gsap.from($$('.w__i', el), {
			yPercent: 115, duration: 1.1, ease: 'power4.out', stagger: 0.045,
			scrollTrigger: { trigger: el, start: 'top 88%', once: true }
		});
	});
	$$('[data-reveal]').forEach(function (el) {
		gsap.fromTo(el, { y: 34, opacity: 0 }, {
			y: 0, opacity: 1, duration: 1.1, ease: 'power3.out',
			scrollTrigger: { trigger: el, start: 'top 90%', once: true }
		});
	});
	$$('[data-reveal-group]').forEach(function (group) {
		var kids = Array.prototype.slice.call(group.children);
		gsap.fromTo(kids, { y: 30, opacity: 0 }, {
			y: 0, opacity: 1, duration: 0.9, ease: 'power3.out', stagger: 0.07,
			scrollTrigger: { trigger: group, start: 'top 88%', once: true }
		});
	});

	/* ---------- Parallax images ---------- */
	$$('[data-parallax]').forEach(function (box) {
		var img = $('img', box);
		if (!img) { return; }
		gsap.fromTo(img, { yPercent: -7 }, {
			yPercent: 7, ease: 'none',
			scrollTrigger: { trigger: box, start: 'top bottom', end: 'bottom top', scrub: true }
		});
	});

	/* ---------- Detail gallery ---------- */
	$$('[data-detail]').forEach(function (fig) {
		var img = $('img', fig);
		gsap.fromTo(img, { scale: 1.18 }, {
			scale: 1, ease: 'none',
			scrollTrigger: { trigger: fig, start: 'top bottom', end: 'center center', scrub: true }
		});
		gsap.from(fig, { opacity: 0, y: 60, duration: 1, ease: 'power3.out',
			scrollTrigger: { trigger: fig, start: 'top 92%', once: true } });
	});

	/* ---------- Steps ---------- */
	$$('[data-step]').forEach(function (step) {
		ScrollTrigger.create({
			trigger: step, start: 'top 62%', end: 'bottom 38%',
			onToggle: function (self) { step.classList.toggle('is-active', self.isActive); }
		});
	});

	/* ---------- Tour: rooms on a spiral column that turns and descends as you scroll ---------- */
	var mm = gsap.matchMedia();
	mm.add('(min-width: 961px)', function () {
		var tour = $('[data-tour]');
		var sticky = $('[data-tour-sticky]');
		var track = $('[data-tour-track]');
		if (!tour || !sticky || !track) { return; }
		var current = $('[data-tour-current]');
		var barFill = $('[data-tour-bar]');
		var rooms = $$('[data-room]', track);
		var n = rooms.length;
		var STEP = 62;            /* degrees of turn between rooms */
		var RADIUS = 560;         /* column radius in px */
		var DROP = 70;            /* vertical descent per room in px */
		var state = { p: 0 };

		tour.classList.add('tour--helix');
		gsap.set(rooms, { xPercent: -50, yPercent: -50, transformOrigin: '50% 50% ' + (-RADIUS) + 'px' });

		function render() {
			var pos = state.p * (n - 1);
			rooms.forEach(function (room, i) {
				var a = i - pos;
				var abs = Math.abs(a);
				gsap.set(room, {
					rotationY: a * STEP,
					y: a * DROP,
					scale: 1 - Math.min(abs, 2) * 0.06,
					opacity: Math.max(0, 1 - abs * 0.42),
					autoAlpha: abs > 2.4 ? 0 : Math.max(0, 1 - abs * 0.42),
					zIndex: 100 - Math.round(abs * 10)
				});
				room.classList.toggle('is-front', abs < 0.5);
			});
			if (barFill) { barFill.style.transform = 'scaleX(' + state.p + ')'; }
			if (current) {
				var k = Math.min(n, Math.round(pos) + 1);
				current.textContent = (k < 10 ? '0' : '') + k;
			}
			tour.style.setProperty('--axis-shift', (-state.p * 240) + 'px');
		}
		render();

		ScrollTrigger.create({
			trigger: tour, start: 'top top', end: function () { return '+=' + (n * 0.75 * window.innerHeight); },
			pin: sticky, scrub: true, invalidateOnRefresh: true, anticipatePin: 1,
			snap: { snapTo: 1 / (n - 1), duration: { min: 0.3, max: 0.9 }, delay: 0.12, ease: 'power2.inOut' },
			onUpdate: function (self) {
				gsap.to(state, { p: self.progress, duration: 0.7, ease: 'power3.out', overwrite: true, onUpdate: render });
			}
		});

		return function () {
			tour.classList.remove('tour--helix');
			gsap.set(rooms, { clearProps: 'all' });
		};
	});

	/* Mobile tour: simple vertical reveals. */
	mm.add('(max-width: 960px)', function () {
		$$('[data-room]').forEach(function (room) {
			gsap.from(room, { y: 60, opacity: 0, duration: 1, ease: 'power3.out',
				scrollTrigger: { trigger: room, start: 'top 85%', once: true } });
		});
	});

	/* ---------- Bed stage entrance ---------- */
	if (bedStage) {
		gsap.from(bedStage, { clipPath: 'inset(12% 12% 12% 12% round 28px)', scale: 0.94, duration: 1.4, ease: 'power4.out',
			scrollTrigger: { trigger: bedStage, start: 'top 85%', once: true } });
	}

	/* ---------- Magnetic buttons ---------- */
	if (window.matchMedia('(hover: hover)').matches) {
		$$('.btn--solid').forEach(function (btn) {
			btn.addEventListener('mousemove', function (e) {
				var r = btn.getBoundingClientRect();
				gsap.to(btn, { x: (e.clientX - r.left - r.width / 2) * 0.18, y: (e.clientY - r.top - r.height / 2) * 0.25, duration: 0.4, ease: 'power3.out' });
			});
			btn.addEventListener('mouseleave', function () { gsap.to(btn, { x: 0, y: 0, duration: 0.7, ease: 'elastic.out(1,.4)' }); });
		});
	}

	window.addEventListener('load', function () { ScrollTrigger.refresh(); });
})();
