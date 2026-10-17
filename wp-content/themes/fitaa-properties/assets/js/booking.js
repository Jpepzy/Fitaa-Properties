/* Fitaa booking date picker: vanilla range calendar with blocked nights. No dependencies. */
(function () {
	'use strict';

	var cfg = window.FITAA_BOOKING;
	var root = document.querySelector('[data-booking]');
	if (!cfg || !root) { return; }

	var cal = root.querySelector('[data-cal]');
	var form = root.querySelector('[data-booking-form]');
	var inEl = root.querySelector('[data-in]');
	var outEl = root.querySelector('[data-out]');
	var summary = root.querySelector('[data-summary]');
	var submit = root.querySelector('[data-submit]');
	var select = root.querySelector('[data-property-select]');
	var DAY = 86400000;
	var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
	var WEEK = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

	/* Dates are handled as 'YYYY-MM-DD' strings and UTC day numbers, so time zones never shift a day. */
	function toNum(s) { var p = s.split('-'); return Math.round(Date.UTC(+p[0], +p[1] - 1, +p[2]) / DAY); }
	function toStr(n) { var d = new Date(n * DAY); return d.getUTCFullYear() + '-' + pad(d.getUTCMonth() + 1) + '-' + pad(d.getUTCDate()); }
	function pad(n) { return (n < 10 ? '0' : '') + n; }
	function pretty(n) { var d = new Date(n * DAY); return ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'][d.getUTCDay()] + ' ' + d.getUTCDate() + ' ' + MONTHS[d.getUTCMonth()].slice(0, 3); }

	var today = toNum(cfg.today);
	var state = { property: root.getAttribute('data-property'), start: null, end: null, hover: null, view: null };
	var occupied = {};

	function loadBlocked() {
		occupied = {};
		var p = cfg.properties[state.property];
		((p && p.blocked) || []).forEach(function (r) {
			for (var n = toNum(r[0]); n < toNum(r[1]); n++) { occupied[n] = true; }
		});
	}

	/* A range [start, end) is free when none of its nights are occupied. The end day itself may be occupied (same-day turnover). */
	function rangeFree(a, b) { for (var n = a; n < b; n++) { if (occupied[n]) { return false; } } return true; }

	function firstOfMonth(n) { var d = new Date(n * DAY); return Date.UTC(d.getUTCFullYear(), d.getUTCMonth(), 1) / DAY; }
	function addMonths(n, k) { var d = new Date(n * DAY); return Date.UTC(d.getUTCFullYear(), d.getUTCMonth() + k, 1) / DAY; }

	function pick(n) {
		if (state.start === null || state.end !== null) {
			state.start = n; state.end = null;
		} else if (n <= state.start || !rangeFree(state.start, n)) {
			state.start = n; state.end = null;
		} else {
			state.end = n;
		}
		state.hover = null;
		sync();
		render();
	}

	function sync() {
		var ok = state.start !== null && state.end !== null;
		inEl.value = state.start !== null ? toStr(state.start) : '';
		outEl.value = ok ? toStr(state.end) : '';
		submit.disabled = !ok;
		if (ok) {
			var nights = state.end - state.start;
			summary.textContent = pretty(state.start) + ' to ' + pretty(state.end) + ' · ' + nights + (nights === 1 ? ' night' : ' nights');
			summary.classList.add('is-set');
		} else if (state.start !== null) {
			summary.textContent = 'Check-in ' + pretty(state.start) + '. Now choose your check-out day.';
			summary.classList.remove('is-set');
		} else {
			summary.textContent = 'Select your check-in day, then your check-out day.';
			summary.classList.remove('is-set');
		}
	}

	function monthHtml(first) {
		var d = new Date(first * DAY);
		var y = d.getUTCFullYear(), m = d.getUTCMonth();
		var lead = (d.getUTCDay() + 6) % 7;
		var days = new Date(Date.UTC(y, m + 1, 0)).getUTCDate();
		var html = '<div class="cal__month"><h3 class="cal__title">' + MONTHS[m] + ' ' + y + '</h3><div class="cal__grid" role="grid">';
		WEEK.forEach(function (w) { html += '<span class="cal__dow" role="columnheader">' + w + '</span>'; });
		for (var i = 0; i < lead; i++) { html += '<span class="cal__pad"></span>'; }
		var lastNight = state.end !== null ? state.end : state.hover;
		for (var day = 1; day <= days; day++) {
			var n = first + day - 1;
			var past = n < today;
			var taken = !!occupied[n];
			var selectingEnd = state.start !== null && state.end === null;
			var disabled = past;
			if (!past && !selectingEnd && taken) { disabled = true; }
			if (!past && selectingEnd) {
				if (n > state.start) { disabled = !rangeFree(state.start, n); }
				else { disabled = taken; }
			}
			var cls = 'cal__day';
			if (taken) { cls += ' is-taken'; }
			if (past) { cls += ' is-past'; }
			if (state.start === n) { cls += ' is-start'; }
			if (state.end === n) { cls += ' is-end'; }
			if (state.start !== null && lastNight !== null && n > state.start && n < lastNight) { cls += ' is-range'; }
			if (state.start !== null && state.end === null && state.hover === n && n > state.start && !disabled) { cls += ' is-hover-end'; }
			var label = pretty(n) + ' ' + y + (taken ? ', taken' : '') + (state.start === n ? ', check-in' : '') + (state.end === n ? ', check-out' : '');
			html += '<button type="button" class="' + cls + '" data-n="' + n + '"' + (disabled ? ' disabled' : '') + ' aria-label="' + label + '"' + (state.start === n || state.end === n ? ' aria-pressed="true"' : '') + '>' + day + '</button>';
		}
		return html + '</div></div>';
	}

	function render() {
		var months = window.matchMedia('(min-width: 720px)').matches ? 2 : 1;
		if (state.view === null) { state.view = firstOfMonth(today); }
		var html = '<div class="cal__nav"><button type="button" class="cal__btn" data-nav="-1" aria-label="Previous month"' + (state.view <= firstOfMonth(today) ? ' disabled' : '') + '>&larr;</button><button type="button" class="cal__btn" data-nav="1" aria-label="Next month">&rarr;</button></div><div class="cal__months">';
		for (var i = 0; i < months; i++) { html += monthHtml(addMonths(state.view, i)); }
		cal.innerHTML = html + '</div>';
	}

	cal.addEventListener('click', function (e) {
		var nav = e.target.closest('[data-nav]');
		if (nav) { state.view = addMonths(state.view, +nav.getAttribute('data-nav')); render(); var b = cal.querySelector('[data-nav="' + nav.getAttribute('data-nav') + '"]'); if (b && !b.disabled) { b.focus(); } return; }
		var day = e.target.closest('.cal__day');
		if (day && !day.disabled) {
			pick(+day.getAttribute('data-n'));
			var again = cal.querySelector('[data-n="' + day.getAttribute('data-n') + '"]');
			if (again) { again.focus(); }
		}
	});
	cal.addEventListener('mouseover', function (e) {
		var day = e.target.closest('.cal__day');
		if (!day || day.disabled || state.start === null || state.end !== null) { return; }
		var n = +day.getAttribute('data-n');
		if (n !== state.hover) {
			state.hover = n;
			var days = cal.querySelectorAll('.cal__day');
			Array.prototype.forEach.call(days, function (el) {
				var v = +el.getAttribute('data-n');
				el.classList.toggle('is-range', v > state.start && v < n);
				el.classList.toggle('is-hover-end', v === n && n > state.start);
			});
		}
	});

	if (select) {
		select.addEventListener('change', function () {
			state.property = select.value;
			state.start = state.end = state.hover = null;
			loadBlocked(); sync(); render();
		});
	}
	window.addEventListener('resize', (function () { var t; return function () { clearTimeout(t); t = setTimeout(render, 150); }; })());

	form.addEventListener('submit', function (e) {
		if (state.start === null || state.end === null) { e.preventDefault(); summary.textContent = 'Please choose your check-in and check-out days first.'; }
	});

	root.classList.add('has-cal');
	loadBlocked(); sync(); render();
})();
