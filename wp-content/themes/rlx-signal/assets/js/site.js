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
			});

			panels.forEach((panel) => {
				const active = panel.dataset.storyPanel === selected;
				panel.classList.toggle('is-active', active);
				panel.hidden = !active;
			});
		});
	});
})();
