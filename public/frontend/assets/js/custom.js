jQuery(function ($) {
	'use strict';

	// START MENU JS
	var scrollFrame = 0;
	window.addEventListener('scroll', function () {
		if (scrollFrame) return;
		scrollFrame = window.requestAnimationFrame(function () {
			scrollFrame = 0;
			var y = window.pageYOffset || document.documentElement.scrollTop || 0;
			var nav = document.querySelector('.main-nav');
			if (nav) nav.classList.toggle('menu-shrink', y > 50);
			var toTop = document.getElementById('toTop');
			if (toTop) toTop.classList.toggle('is-on', y > 200);
		});
	}, { passive: true });
	// END MENU JS

    // Mean Menu
	if ($.fn.meanmenu) {
		jQuery('.mean-menu').meanmenu({
			meanScreenWidth: "991"
		});
	}

	// Home Slider JS
	function revealSliderImage(el) {
		if (!el || !el.getAttribute('data-src')) return;
		el.src = el.getAttribute('data-src');
		el.removeAttribute('data-src');
		if (el.getAttribute('data-srcset')) {
			el.srcset = el.getAttribute('data-srcset');
			el.removeAttribute('data-srcset');
		}
	}

	function loadDeferredSliderImages() {
		var pending = document.querySelectorAll('.slider-bg[data-src], .slider-shape-img[data-src]');
		var index = 0;
		function next() {
			if (index >= pending.length) return;
			revealSliderImage(pending[index]);
			index += 1;
			if ('requestIdleCallback' in window) {
				window.requestIdleCallback(next, { timeout: 1000 });
			} else {
				window.setTimeout(next, 200);
			}
		}
		next();
	}

	if ($('.home-slider').length && $.fn.owlCarousel) {
		$('.home-slider').owlCarousel({
			items:1,
			loop:true,
			margin:0,
			nav: true,
			dots: true,
			smartSpeed: 400,
			checkVisibility: false,
			autoplay:true,
			autoplayTimeout:8000,
			autoplayHoverPause:true,
			navText: [
				"<i class='icofont-simple-left' aria-hidden='true'></i><span class='sr-only'>Previous slide</span>",
				"<i class='icofont-simple-right' aria-hidden='true'></i><span class='sr-only'>Next slide</span>"
			],
		});
		window.addEventListener('load', function () {
			setTimeout(loadDeferredSliderImages, 1500);
		});
	}

	// Testimonial Slider JS
	if ($('.testimonial-slider').length && $.fn.owlCarousel) {
		$('.testimonial-slider').owlCarousel({
			items:1,
			loop:true,
			margin:0,
			nav: true,
			dots: false,
			smartSpeed: 1000,
			animateOut: 'fadeOut',
			autoplay:false,
			autoplayTimeout:9000,
			autoplayHoverPause:true,
			navText: [
				"<i class='icofont-simple-left' aria-hidden='true'></i><span class='sr-only'>Previous</span>",
				"<i class='icofont-simple-right' aria-hidden='true'></i><span class='sr-only'>Next</span>"
			],
		});
	}

    // Search Box JS
    $('.search-toggle').addClass('closed');
    $('.search-toggle .search-icon').on('click', function(e) {
        if ($('.search-toggle').hasClass('closed')) {
        $('.search-toggle').removeClass('closed').addClass('opened');
        $('.search-toggle, .search-area').addClass('opened');
        $('#search-terms').focus();
        } else {
        $('.search-toggle').removeClass('opened').addClass('closed');
        $('.search-toggle, .search-area').removeClass('opened');
        }
	});

	// Slick Slider JS (only when plugin + markup exist)
	if ($.fn.slick && $('.slider-for').length) {
		$('.slider-for').slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			arrows: false,
			fade: true,
			asNavFor: '.slider-nav'
		});
		$('.slider-nav').slick({
			slidesToShow: 3,
			slidesToScroll: 1,
			asNavFor: '.slider-for',
			dots: true,
			focusOnSelect: true,
			prevArrow: false,
			nextArrow: false,
			centerMode: true,
			variableWidth: true,
			responsive: [
				{ breakpoint: 3000, setting: { slidesToShow: 3 } },
				{ breakpoint: 1400, setting: { slidesToShow: 2 } },
				{ breakpoint: 800, setting: { slidesToShow: 1 } }
			]
		});
	}

	// Odometer JS
	if ($.fn.appear && $('.odometer').length) {
		$('.odometer').appear(function() {
			$('.odometer').each(function() {
				var countNumber = $(this).attr('data-count');
				$(this).html(countNumber);
			});
		});
	}

	// Popup Video
	if ($.fn.magnificPopup && $('.popup-youtube').length) {
		$('.popup-youtube').magnificPopup({
			disableOn: 300,
			type: 'iframe',
			mainClass: 'mfp-fade',
			removalDelay: 160,
			preloader: false,
			fixedContentPos: false
		});
	}

	// Accordion JS
	if ($('.accordion').length) {
		$('.accordion > li:eq(0) .faq-head').addClass('active').next().slideDown();
		$('.accordion .faq-head').on('click', function(j) {
			var dropDown = $(this).closest('li').find('.faq-content');
			$(this).closest('.accordion').find('.faq-content').not(dropDown).slideUp(300);
			if ($(this).hasClass('active')) {
				$(this).removeClass('active');
			} else {
				$(this).closest('.accordion').find('.faq-head.active').removeClass('active');
				$(this).addClass('active');
			}
			dropDown.stop(false, true).slideToggle(300);
			j.preventDefault();
		});
	}

	// Timer JS
	let getDaysId = document.getElementById('days');
	if(getDaysId !== null){
		const second = 1000;
		const minute = second * 60;
		const hour = minute * 60;
		const day = hour * 24;

		let countDown = new Date('December 30, 2026 00:00:00').getTime();
		setInterval(function() {
			let now = new Date().getTime();
			let distance = countDown - now;

			document.getElementById('days').innerText = Math.floor(distance / (day));
			document.getElementById('hours').innerText = Math.floor((distance % (day)) / (hour));
			document.getElementById('minutes').innerText = Math.floor((distance % (hour)) / (minute));
			document.getElementById('seconds').innerText = Math.floor((distance % (minute)) / second);
		}, second);
	}

	// PRELOADER (also handled early in master layout)
	jQuery('.loader').addClass('is-hidden').removeClass('is-visible');

	// Wow JS
	if (typeof WOW !== 'undefined') {
		new WOW().init();
	}

	// Back to top
	$('body').append('<button type="button" id="toTop" class="back-to-top-btn" aria-label="Back to top"><i class="icofont-hand-drawn-up" aria-hidden="true"></i></button>');
	var toTopBtn = document.getElementById('toTop');
	if (toTopBtn && (window.pageYOffset || 0) > 200) {
		toTopBtn.classList.add('is-on');
	}
	$('#toTop').on('click', function(){
		window.scrollTo(0, 0);
		return false;
	});

	// Subscribe form (only when validator/ajaxChimp plugins exist)
	if ($.fn.validator && $(".newsletter-form").length) {
		$(".newsletter-form").validator().on("submit", function (event) {
			if (event.isDefaultPrevented()) {
				formErrorSub();
				submitMSGSub(false, "Please enter your email correctly.");
			} else {
				event.preventDefault();
			}
		});
	}
	function callbackFunction (resp) {
		if (resp.result === "success") {
			formSuccessSub();
		} else {
			formErrorSub();
		}
	}
	function formSuccessSub(){
		$(".newsletter-form")[0].reset();
		submitMSGSub(true, "Thank you for subscribing!");
		setTimeout(function() {
			$("#validator-newsletter").addClass('hide');
		}, 4000);
	}
	function formErrorSub(){
		$(".newsletter-form").addClass("animated shake");
		setTimeout(function() {
			$(".newsletter-form").removeClass("animated shake");
		}, 1000);
	}
	function submitMSGSub(valid, msg){
		var msgClasses = valid ? "validation-success" : "validation-danger";
		$("#validator-newsletter").removeClass().addClass(msgClasses).text(msg);
	}

	if ($.fn.ajaxChimp && $(".newsletter-form").length) {
		$(".newsletter-form").ajaxChimp({
			url: "https://hibootstrap.us20.list-manage.com/subscribe/post?u=60e1ffe2e8a68ce1204cd39a5&amp;id=42d6d188d9",
			callback: callbackFunction
		});
	}

	// Switch Btn
	$('body').append("<div class='switch-box'><label id='switch' class='switch' aria-label='Toggle dark mode'><input type='checkbox' onchange='toggleTheme()' id='slider' aria-label='Dark mode'><span class='slider round'></span></label></div>");

	// Apply saved theme after switch exists
	if (localStorage.getItem('medsev_theme') === 'theme-dark') {
		setTheme('theme-dark');
		var darkSlider = document.getElementById('slider');
		if (darkSlider) darkSlider.checked = false;
	} else {
		setTheme('theme-light');
		var lightSlider = document.getElementById('slider');
		if (lightSlider) lightSlider.checked = true;
	}
}(jQuery));


// function to set a given theme/color-scheme
function setTheme(themeName) {
    localStorage.setItem('medsev_theme', themeName);
    document.documentElement.className = themeName;
}

// function to toggle between light and dark theme
function toggleTheme() {
    if (localStorage.getItem('medsev_theme') === 'theme-dark') {
        setTheme('theme-light');
    } else {
        setTheme('theme-dark');
    }
}
