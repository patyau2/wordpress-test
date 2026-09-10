(() => {
	'use strict';

	const menuButton = document.querySelector('.menu-toggle');
	const navigation = document.querySelector('.primary-nav');

	if (menuButton && navigation) {
		const closeMenu = (restoreFocus = false) => {
			menuButton.setAttribute('aria-expanded', 'false');
			navigation.classList.remove('is-open');
			document.body.classList.remove('menu-open');
			if (restoreFocus) menuButton.focus();
		};

		menuButton.addEventListener('click', () => {
			const willOpen = menuButton.getAttribute('aria-expanded') !== 'true';
			menuButton.setAttribute('aria-expanded', String(willOpen));
			navigation.classList.toggle('is-open', willOpen);
			document.body.classList.toggle('menu-open', willOpen);
		});

		navigation.addEventListener('click', (event) => {
			if (event.target.closest('a')) closeMenu();
		});

		document.addEventListener('keydown', (event) => {
			if (event.key === 'Escape' && menuButton.getAttribute('aria-expanded') === 'true') {
				closeMenu(true);
			}
		});

		document.addEventListener('click', (event) => {
			if (menuButton.getAttribute('aria-expanded') === 'true' && !event.target.closest('.site-header')) {
				closeMenu();
			}
		});

		window.addEventListener('resize', () => {
			if (window.innerWidth > 1024) closeMenu();
		});
	}

	const hero = document.querySelector('[data-hero-slider]');
	if (hero) {
		const slides = [...hero.querySelectorAll('[data-hero-slide]')];
		const dots = [...hero.querySelectorAll('[data-hero-dot]')];
		const prev = hero.querySelector('[data-hero-prev]');
		const next = hero.querySelector('[data-hero-next]');
		let activeIndex = slides.findIndex((slide) => slide.classList.contains('is-active'));
		let autoplay;

		if (activeIndex < 0) activeIndex = 0;

		const activateSlide = (index) => {
			if (!slides.length) return;

			activeIndex = (index + slides.length) % slides.length;

			slides.forEach((slide, slideIndex) => {
				const active = slideIndex === activeIndex;
				slide.classList.toggle('is-active', active);
				slide.setAttribute('aria-hidden', String(!active));
				if (active) {
					slide.removeAttribute('tabindex');
				} else {
					slide.setAttribute('tabindex', '-1');
				}
			});

			dots.forEach((dot, dotIndex) => {
				const active = dotIndex === activeIndex;
				dot.classList.toggle('is-active', active);
				dot.setAttribute('aria-current', active ? 'true' : 'false');
			});
		};

		const stopAutoplay = () => window.clearInterval(autoplay);
		const startAutoplay = () => {
			stopAutoplay();
			if (slides.length > 1 && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
				autoplay = window.setInterval(() => activateSlide(activeIndex + 1), 7000);
			}
		};

		prev?.addEventListener('click', () => {
			activateSlide(activeIndex - 1);
			startAutoplay();
		});
		next?.addEventListener('click', () => {
			activateSlide(activeIndex + 1);
			startAutoplay();
		});
		dots.forEach((dot) => {
			dot.addEventListener('click', () => {
				activateSlide(Number(dot.dataset.heroDot || 0));
				startAutoplay();
			});
		});
		hero.addEventListener('mouseenter', stopAutoplay);
		hero.addEventListener('mouseleave', startAutoplay);
		hero.addEventListener('focusin', stopAutoplay);
		hero.addEventListener('focusout', startAutoplay);
		hero.addEventListener('keydown', (event) => {
			if (event.key === 'ArrowLeft') activateSlide(activeIndex - 1);
			if (event.key === 'ArrowRight') activateSlide(activeIndex + 1);
		});
		activateSlide(activeIndex);
		startAutoplay();
	}

	const tabs = [...document.querySelectorAll('[data-story-tab]')];
	const panels = [...document.querySelectorAll('[data-story-panel]')];

	tabs.forEach((tab) => {
		tab.addEventListener('click', () => {
			const selected = tab.dataset.storyTab;

			tabs.forEach((item) => {
				const active = item === tab;
				item.classList.toggle('is-active', active);
				item.setAttribute('aria-selected', String(active));
				item.setAttribute('tabindex', active ? '0' : '-1');
			});

			panels.forEach((panel) => {
				const active = panel.dataset.storyPanel === selected;
				panel.classList.toggle('is-active', active);
				panel.hidden = !active;
			});
		});

		tab.addEventListener('keydown', (event) => {
			if (!['ArrowLeft', 'ArrowRight', 'Home', 'End'].includes(event.key)) return;
			event.preventDefault();
			const current = tabs.indexOf(tab);
			const nextIndex = event.key === 'Home' ? 0 : event.key === 'End' ? tabs.length - 1 : (current + (event.key === 'ArrowRight' ? 1 : -1) + tabs.length) % tabs.length;
			tabs[nextIndex].focus();
			tabs[nextIndex].click();
		});
	});
})();
