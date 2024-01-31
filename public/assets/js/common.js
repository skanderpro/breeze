(function ($, root, undefined) {
	
	$(document).ready(function() {
	
		'use strict';

		var touch = $('.header-menu-toggle');
		var menu = $('.sidebar');

		$('.header-menu-toggle').click(function() {
			$(this).toggleClass('active');
			$('body').toggleClass('login-open');
			$('.sidebar').fadeToggle(100);
		});


		$(window).resize(function(){
			var w = $(window).width();
			if($(window).width() > 1020) {
				menu.removeAttr('style');
			}
		});

		var mapAnimation = bodymovin.loadAnimation({
			container: document.getElementById('map'),
			path: 'assets/animation/location-map.json?8017248',
			renderer: 'svg',
			loop: false,
			autoplay: false,
			name: "Map",
		});


		var rocketAnimation = bodymovin.loadAnimation({
			container: document.getElementById('analysis-rocket'),
			path: 'assets/animation/rocket-graph.json',
			renderer: 'svg',
			loop: false,
			autoplay: false,
			name: "Roket",
		});

		const breakpoint = window.matchMedia( '(max-width:991px)' );
		let mainSlider;

		const breakpointChecker = function() {
			if ( breakpoint.matches === true ) {
				mapAnimation.play();
				rocketAnimation.goToAndStop(100, true);
				if ( mainSlider !== undefined ) mainSlider.destroy( true, true );
				return;
			} else if ( breakpoint.matches === false ) {
				return enableSwiper();
			}
		};

		const enableSwiper = function() {
			mainSlider = new Swiper('.main-slider', {
				loop: false,
				speed: 500,
				autoplay: false,
				effect: 'fade',
				preventInteractionOnTransition: true,
				mousewheel: true,
				keyboard: {
					enabled: true,
					onlyInViewport: true,
					pageUpDown: true,
				},
				on : {
					beforeSlideChangeStart: function (){},
					slideChange: function (){
						mainSlider.disable();
						setTimeout(function(){mainSlider.enable()}, 2000);
					},
					slideNextTransitionStart: function (){
						$('.swiper-slide-active').addClass('animated');
						
					},
					slideNextTransitionEnd: function (){
						if(mainSlider.activeIndex === 1){
							mapAnimation.play();
						};
						if(mainSlider.activeIndex === 5){
							rocketAnimation.play();
							setTimeout(function(){rocketAnimation.pause()}, 3000);
						};
					},
					slidePrevTransitionEnd: function (){
						//mainSlider.params.speed = 0;
						rocketAnimation.stop();
					},
				}
			});
		};

		breakpoint.addListener(breakpointChecker);
		breakpointChecker();

		if($("#contact-form").length) {
			$("#contact-form").validate({
				submitHandler : function (form) {
					$.ajax({
						type: "POST",
						url: 'assets/mail/mail-contact.php',
						data: $(form).serialize(),
					}).done(function(data) {
						$(form).find(".form-item").val("");
						$('#contact-form').css("display", "none").next(".confirm-block").fadeIn();
					});
					return false;
				}
			});
		};



	});

})(jQuery, this);