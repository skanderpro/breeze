@extends('layouts.login')

@section('content')
	<style>
		header,
		footer{
			display: none!important;
		}
		main.py-4{
			padding: 0!important;
		}
		.login form{
			background: transparent;
			color: inherit;
			height: auto;
			padding: 0;
		}
	</style>
	<div class="header-block">
		<div class="header-row">
			<div class="header-logo" itemscope itemtype="http://schema.org/Organization">
				<img src="assets/img/icons/express-merchants-logo.svg?8017248" alt="Express Merchants">
			</div>
			<div class="header-menu-toggle"></div>
		</div>
	</div>
	<div class="sidebar">
		<div class="sidebar-content">
			<form method="POST" action="{{ route('login') }}">
				@csrf
				<div class="form-group form-group-email">
					<!-- <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label> -->
					<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" placeholder="email" required autofocus>

					@if ($errors->has('email'))
						<span class="invalid-feedback" role="alert">
							<strong>{{ $errors->first('email') }}</strong>
						</span>
					@endif
				</div>
				<div class="form-group form-group-password">
					<!-- <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label> -->
					<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>

					@if ($errors->has('password'))
						<span class="invalid-feedback" role="alert">
							<strong>{{ $errors->first('password') }}</strong>
						</span>
					@endif
				</div>
				<div class="form-group">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
						<label class="form-check-label" for="remember">
							{{ __('Remember Me') }}
						</label>
					</div>
				</div>
				<div class="form-group-submit">
					<button type="submit" class="btn btn-primary">
						{{ __('Login') }}
					</button>
				</div>
				<div class="form-group-links">
					<ul>
						@if (Route::has('password.request'))
							<li>
								<a href="{{ route('password.request') }}">
									{{ __('Forgot Your Password?') }}
								</a>
							</li>
						@endif
						<li class="form-group-separator"></li>
						<li><a href="mailto:helpdesk@expressmerchants.com?subject=Requesting a new account" target="_blank">Request New User Account.</a></li>
					</ul>
				</div>
			</form>
		</div>
		<div class="sidebar-copyright">&copy; 2023 Express Merchants</div>
	</div>
	<div class="main-page">
		<div class="main-section">
			<div class="swiper main-slider">
				<div class="swiper-wrapper">
					<div class="swiper-slide">
						<div class="main-slide intro-slide">
							<div class="intro-text">
								<h2>Millions of products, Thousands of locations, <strong>One supplier.</strong></h2>
							</div>
							<div class="intro-img" style="background-image: url('assets/img/app-graphic.jpg?8017248');">
								<div class="scroll-icon">
									<span>Scroll for more info</span>
									<svg xmlns="http://www.w3.org/2000/svg?8017248" viewBox="0 0 22 32" width="22" height="32"><line fill="none" stroke="currentColor" x1="11.2" y1="6.6" x2="11.2" y2="12.5"/><path fill="currentColor" d="M11,1a9.92,9.92,0,0,1,10,9.8V21.1a9.92,9.92,0,0,1-10,9.8A9.84,9.84,0,0,1,1,21.2V10.8A9.92,9.92,0,0,1,11,1m0-1A10.93,10.93,0,0,0,0,10.8V21.1A11,11,0,0,0,11,32,10.93,10.93,0,0,0,22,21.2V10.8A10.93,10.93,0,0,0,11,0Z"/></svg>
								</div>
							</div>
							<div class="intro-contact">
								<p>Do you want access to the largest network of suppliers in the UK & Ireland? Save time and money <strong>with Express Merchants</strong></p>
								<p><strong>Call us today to see how we can help your business.</strong></p>
								<div class="intro-phone-button">
									<a href="tel:+442838446170" class="phone-button">
										<svg xmlns="http://www.w3.org/2000/svg?8017248" viewBox="0 0 16 16" width="16" height="16"><path fill="currentColor" d="M15.2,10.4,12,9.8a1.08,1.08,0,0,0-.8.2l-1,1a.77.77,0,0,1-1,.1A10.57,10.57,0,0,1,6.6,9.4a7.53,7.53,0,0,1-1.7-3h0L6.2,4.7c.1-.1.1-.4.1-.7L5.4.7A.88.88,0,0,0,4.5,0,8.79,8.79,0,0,0,2.8.2,5.66,5.66,0,0,0,1,.5C.4.7,0,1.7,0,3.1A12.64,12.64,0,0,0,12.4,16h1a3.24,3.24,0,0,0,2.3-.8.91.91,0,0,0,.3-.7V11.3a.82.82,0,0,0-.8-.9"/></svg>
										<span>(+44) 28 3844 6170</span>
									</a>
								</div>
								<div class="intro-site-dev">
									<div class="site-dev"><a href="https://cornellstudios.com" target="_blank">Built By <strong>Cornell</strong></a></div>
								</div>
							</div>
						</div>
					</div>
					<div class="swiper-slide">
						<div class="main-slide locations-slide">
							<div class="locations-section">
								<div class="locations-row">
									<div class="location-map-col">
										<div class="location-map-placeholder"></div>
										<div class="location-map">
											<div id="map"></div>
											<div class="location-map-shape"></div>
										</div>
									</div>
									<div class="location-text-col">
										<div class="location-text-wrap">
											<div class="location-text">
												<h2>we have over <strong>6,000 locations</strong></h2>
												<p><span style="color: #5172B8;">Established in 2017, Express Merchants now has the</span> largest network of suppliers in the <strong>UK & Ireland.</strong></p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="clients-section">
								<div class="clients-container">
									<div class="clients-heading">Some of the <strong>well known brands</strong> we have on board</div>
									<div class="clients-row">
										<div class="client-col">
											<div class="client-logo">
												<img src="assets/img/clients/jewson-logo.jpg?8017248" alt="">
											</div>
										</div>
										<div class="client-col">
											<div class="client-logo">
												<img src="assets/img/clients/howdens-logo.jpg?8017248" alt="">
											</div>
										</div>
										<div class="client-col">
											<div class="client-logo">
												<img src="assets/img/clients/screwfix-logo-sm.jpg?8017248" alt="">
											</div>
										</div>
										<div class="client-col">
											<div class="client-logo">
												<img src="assets/img/clients/rexel-logo.jpg?8017248" alt="">
											</div>
										</div>
										<div class="client-col">
											<div class="client-logo">
												<img src="assets/img/clients/cef-logo.jpg?8017248" alt="">
											</div>
										</div>
										<div class="client-col">
											<div class="client-logo">
												<img src="assets/img/clients/bq-logo.jpg?8017248" alt="">
											</div>
										</div>
										<div class="client-col">
											<div class="client-logo">
												<img src="assets/img/clients/haldane-fisher-logo.jpg?8017248" alt="">
											</div>
										</div>
										<div class="client-col">
											<div class="client-logo">
												<img src="assets/img/clients/currys-logo.jpg?8017248" alt="">
											</div>
										</div>
										<div class="client-col">
											<div class="client-logo">
												<img src="assets/img/clients/speedy-logo.jpg?8017248" alt="">
											</div>
										</div>
										<div class="client-col">
											<div class="client-logo">
												<img src="assets/img/clients/chadwicks-logo.jpg?8017248" alt="">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="swiper-slide">
						<div class="main-slide video-slide">
							<div class="video-block">
								<div class="video-heading">
									<h2><strong>Centralising</strong> and <strong>connecting</strong> all of your procurement needs</h2>
								</div>
								<div class="video-wrap">
									<img src="assets/img/funnel-screens.jpg?8017248" alt="">
								</div>
							</div>
						</div>
					</div>
					<div class="swiper-slide">
						<div class="main-slide costs-slide">
							<div class="slide-container">
								<div class="costs-block">
									<div class="costs-icon">
										<img src="assets/img/engineers-icon.svg?8017248" alt="">
									</div>
									<div class="costs-text">
										<h2><strong>Track Spend</strong> <br>and <strong>Monitor Costs</strong></h2>
										<p>With our Express Merchants app, we have combined <br><strong>Technical knowledge | Business Expertise | Creativity</strong></p>
										<p>Putting our technology in the hands of our engineers will save time and resources allowing them to do amazing things, amazingly fast.</p>
									</div>
								</div>
							</div>
							<div class="costs-img" style="background-image: url('assets/img/track-spend.jpg?8017248');"></div>
						</div>
					</div>
					<div class="swiper-slide">
						<div class="main-slide choice-slide">
							<div class="choice-block">
								<div class="choice-text">
									<h2>Millions of products, Thousands of locations <strong>Your Choice</strong></h2>
									<p>We specialise in streamlining your procurement needs. In doing this we reduce your supplier lists while also increasing the number of supplier locations.</p>
								</div>
								<div class="choice-icon">
									<img src="assets/img/time-icon.svg?8017248" alt="">
								</div>
							</div>
							<div class="choice-bg" style="background-image: url('assets/img/trade-store-img.jpg?8017248');"></div>
						</div>
					</div>
					<div class="swiper-slide">
						<div class="main-slide analysis-slide">
							<div class="slide-container">
								<div class="analysis-block">
									<div class="analysis-icon">
										<img src="assets/img/analysis-icon.svg?8017248" alt="">
									</div>
									<div class="analysis-text">
										<p>We work hard to ensure that you benefit from:</p>
										<h2><strong>Reduced Costs <br>Cut Overheads <br>Lower Carbon Footprint Save Time</strong></h2>
									</div>
									<div class="analysis-testimonial">
										<div class="analysis-testimonial-text">
											<p>Our Site team love it! The ability to get the materials they need, when they need them without having to travel 20+ km saves us so much time & money (on Diesel alone)!</p>
											<p>Revolutionary for the delivery of services</p>
										</div>
										<div class="analysis-testimonial-author">Michael Quinn</div>
									</div>
								</div>
							</div>
							<div class="analysis-bg" style="background-image: url('assets/img/accountant-img.jpg?8017248');"></div>
						</div>
					</div>
					<div class="swiper-slide">
						<div class="main-slide expense-slide">
							<div class="expense-text-wrap">
								<div class="expense-text">
									<h2>No more <strong>expense <br>sheets from employees</strong></h2>
								</div>
							</div>
							<div class="expense-icon">
								<img src="assets/img/checklist-icon.svg?8017248" alt="">
							</div>
							<div class="expense-bg" style="background-image: url('assets/img/paper-work-img.jpg?8017248');"></div>
						</div>
					</div>
					<div class="swiper-slide">
						<div class="main-slide cards-slide">
							<div class="cards-slide-inner">
								<div class="cards-block">
									<div class="cards-heading">
										<div class="cards-heading-title">Access to Amazon Business</div>
										<div class="cards-heading-logo">
											<img src="assets/img/clients/amazon-logo.svg?8017248" alt="">
										</div>
									</div>
									<div class="cards-group">
										<div class="cards-subtitle">Trade cards for employees</div>
										<div class="cards-spacer-wrap">
											<div class="cards-spacer"></div>
										</div>
										<div class="cards-row">
											<div class="cards-logo-col">
												<div class="cards-logo">
													<img src="assets/img/clients/plumb-fix-logo.jpg?8017248" alt="">
												</div>
											</div>
											<div class="cards-logo-col">
												<div class="cards-logo">
													<img src="assets/img/clients/bq-logo.jpg?8017248" alt="">
												</div>
											</div>
											<div class="cards-logo-col">
												<div class="cards-logo">
													<img src="assets/img/clients/screwfix-logo.jpg?8017248" alt="">
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="quote-block">
									<div class="quote-text">
										<p>We started using Express Merchants to aid our engineers on a national Contract; the access to suppliers in some of the UK’s most remote areas has been a game changer for us to hit our clients’ expectations. The team at Express Merchants have been brilliant setting up accounts where we need them</p>
									</div>
									<div class="quote-author">Oliver Allen</div>
								</div>
							</div>
						</div>
					</div>
					<div class="swiper-slide">
						<div class="main-slide travel-slide">
							<div class="slide-container">
								<div class="travel-text">
									<h2>Direct access to <br><strong>worldwide travel</strong> <br>and <strong>accommodation</strong></h2>
									<p>Including: <br><strong>Hotel accommodation | Flights | Corporate rates</strong></p>
								</div>
							</div>
							<div class="travel-bottom">
								<div class="travel-img">
									<img src="assets/img/holiday-island.png?8017248" alt="">
								</div>
							</div>
						</div>
					</div>
					<div class="swiper-slide">
						<div class="main-slide contact-slide">
							<div class="slide-container">
								<div class="contact-form">
									<p>Want to find out more?</p>
									<h2>Get in touch</h2>
									<form id="contact-form" action="#">
										<div class="form-field"><input type="text" name="your-name" required placeholder="Name"></div>
										<div class="form-field"><input type="email" name="your-email" required placeholder="Email"></div>
										<div class="form-field"><input type="tel" name="your-phone" required placeholder="Phone"></div>
										<div class="form-field form-field-website"><input type="text" name="your-website" placeholder="Website"></div>
										<div class="form-field"><textarea name="your-message" required cols="30" rows="10" placeholder="Message"></textarea></div>
										<div class="form-field-submit"><input type="Submit" value="Submit"></div>
									</form>
									<div class="confirm-block">
										<p>Thank you for your request! <br>One of our specialists will be in touch soon to assist you.</p>
									</div>
								</div>
							</div>
							<div class="contact-bg" style="background-image: url('assets/img/contact-bg.jpg?8017248');"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="footer-block">
		<div class="footer-row">
			<div class="footer-copyright">&copy; 2023 Express Merchants</div>
			<div class="site-dev"><a href="https://cornellstudios.com" target="_blank">Built By <strong>Cornell</strong></a></div>
		</div>
	</div>

@endsection