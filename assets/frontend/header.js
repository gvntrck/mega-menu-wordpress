document.addEventListener('DOMContentLoaded', function() {
	const header = document.getElementById('mh-header');
	const logoImg = document.querySelector('.mh-logo-img');
	const mobileToggle = document.getElementById('mh-mobile-toggle');
	const nav = document.getElementById('mh-nav');
	const menuItems = document.querySelectorAll('.mh-has-dropdown');

	// 1. Sticky Header & Logo Swap
	if (header && logoImg) {
		const fixedSrc = logoImg.getAttribute('data-fixed');
		const scrollSrc = logoImg.getAttribute('data-scroll');

		window.addEventListener('scroll', function() {
			if (window.scrollY > 50) {
				header.classList.add('is-scrolled');
				if (scrollSrc && logoImg.src !== scrollSrc) {
					logoImg.src = scrollSrc;
				}
			} else {
				header.classList.remove('is-scrolled');
				if (fixedSrc && logoImg.src !== fixedSrc) {
					logoImg.src = fixedSrc;
				}
			}
		});
	}

	// 2. Swiper Initialization
	// We init Swiper for all dropdowns. Swiper handles responsiveness well.
	const swipers = document.querySelectorAll('.mh-swiper');
	swipers.forEach(function(swiperElement) {
		new Swiper(swiperElement, {
			slidesPerView: 1,
			spaceBetween: 20,
			loop: true,
			navigation: {
				nextEl: swiperElement.querySelector('.swiper-button-next'),
				prevEl: swiperElement.querySelector('.swiper-button-prev'),
			},
			breakpoints: {
				640: {
					slidesPerView: 2,
					spaceBetween: 20,
				},
				768: {
					slidesPerView: 3,
					spaceBetween: 30,
				},
				1024: {
					slidesPerView: 4,
					spaceBetween: 40,
				},
			}
		});
	});

	// 3. Mobile Toggle
	if (mobileToggle && nav) {
		mobileToggle.addEventListener('click', function() {
			mobileToggle.classList.toggle('is-active');
			nav.classList.toggle('is-open');
		});
	}

	// Handle window resize to clean up mobile states
	window.addEventListener('resize', function() {
		if (window.innerWidth >= 992) {
			nav.classList.remove('is-open');
			if(mobileToggle) mobileToggle.classList.remove('is-active');
			menuItems.forEach(function(item) {
				item.classList.remove('is-active');
			});
		}
	});
});
