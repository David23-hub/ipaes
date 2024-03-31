<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">

	<!-- title -->
	<title>IPAES</title>

	<!-- favicon -->
	<link rel="shortcut icon" type="image/png" href="assets/img/icon-title.png">

	<!-- google font -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
	<!-- fontawesome -->
	<link rel="stylesheet" href="assets/css/all.min.css">
	<!-- bootstrap -->
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
	<!-- owl carousel -->
	<link rel="stylesheet" href="assets/css/owl.carousel.css">
	<!-- magnific popup -->
	<link rel="stylesheet" href="assets/css/magnific-popup.css">
	<!-- animate css -->
	<link rel="stylesheet" href="assets/css/animate.css">
	<!-- mean menu css -->
	<link rel="stylesheet" href="assets/css/meanmenu.min.css">
	<!-- main style -->
	<link rel="stylesheet" href="assets/css/main.css">
	<!-- responsive -->
	<link rel="stylesheet" href="assets/css/responsive.css">

	<style>
		html, body {
			width: 100vw; /* Set width to 100% of viewport width */
			overflow-x: hidden; /* Disable horizontal scrolling */
		}
	</style>
</head>
<body>
	
	<!--PreLoader-->
    <div class="loader">
        <div class="loader-inner">
            <div class="circle"></div>
        </div>
    </div>
    <!--PreLoader Ends-->
	
	<!-- header -->
	{{-- <div class="top-header-area" id="sticker"> --}}
	<div class="top-header-area">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-sm-12 text-center">
					<div class="main-menu-wrap">
						<!-- logo -->
						<div class="site-logo">
							<a href="">
								<img src="assets/img/logo.png" alt="">
							</a>
						</div>
						<!-- logo -->

						<!-- menu start -->
						<nav class="main-menu">
							<ul>
								
								<li>
									<div class="header-icons">
									
											@guest
												<a class="nav-link" href="{{ route('login') }}"><i class="fa fa-fw fa-power-off text-red"></i>{{ __('adminlte::adminlte.sign_in') }}</a>
											@else
												<a class="shopping-cart" href="{{route('homelist')}}"><i class="fa fa-fw fa-share"></i>{{ __('adminlte::adminlte.back_to_menu') }}</a>
											@endguest

									</div>
								</li>
								
							</ul>
						</nav>
						<div class="mobile-menu"></div>
						<!-- menu end -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end header -->
	
	
	<!-- hero area -->
	<div class="hero-area hero-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 offset-lg-2 text-center">
					<div class="hero-text">
						<div class="hero-text-tablecell">
							<p class="subtitle">Inti Persada Aestetic</p>
							<h1>The Best Beauty Product Seller</h1>
							{{-- <div class="hero-btns">
								<a href="#product-list" onclick="scrollToSection('product_list')" class="boxed-btn">Product Collection</a>
								<a href="contact.html" class="bordered-btn">Contact Us</a>
							</div> --}}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end hero area -->

	@yield('body')

	<!-- footer -->
	<div class="footer-area">
		<div class="container">
			<div class="row">
				<div class="col-lg-2 ">
					<p><img src="assets/img/logo.png" alt=""></p>
					<p style="font-weight: bold"><i class="fas fa-solid fa-phone" style="color: green;"></i> +62 878-2905-2023</p>
				</div>
				<div class="col-lg " style="text-align: right">
					<div class="footer-box get-in-touch">
						<h2 class="widget-title" style="font-weight: bold">Working Hours</h2>
							<span style=" font-weight: bold; font-size: 20px;color:black" >EVERYDAY</span>
							<p style="font-weight: bold; color:black"><i class="fas fa-solid fa-clock" style="color: green;"></i> 9AM - 9PM</p>
					</div>
				</div>
				
				
			</div>
		</div>
	</div>
	<!-- end footer -->
	
	<!-- copyright -->
	<div class="copyright">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-12">
					<p>Copyrights &copy; PT. Inti Pratama Aesthetic 2023
					</p>
				</div>
				{{-- <div class="col-lg-6 text-right col-md-12">
					<div class="social-icons">
						<ul>
							<li><a href="https://api.whatsapp.com/send?phone=6287829052023&text=Hi! i want to ask about Inti Pratama Aesthetic product" target="_blank"><i class="fab fa-whatsapp"></i></a></li>
						</ul>
					</div>
				</div> --}}
			</div>
		</div>
	</div>
	<!-- end copyright -->
	<div class="floating-btn">
		<a href="https://api.whatsapp.com/send?phone=6287829052023&text=Hi! i want to ask about Inti Pratama Aesthetic product" target="_blank" class="floating-btn"><i class="fab fa-whatsapp" style="margin-right: 10px"></i><span > Chat With The Agent</span></a>
	</div>


	<!-- jquery -->
	<script src="assets/js/jquery-1.11.3.min.js"></script>
	<!-- bootstrap -->
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
	<!-- count down -->
	<script src="assets/js/jquery.countdown.js"></script>
	<!-- isotope -->
	<script src="assets/js/jquery.isotope-3.0.6.min.js"></script>
	<!-- waypoints -->
	<script src="assets/js/waypoints.js"></script>
	<!-- owl carousel -->
	<script src="assets/js/owl.carousel.min.js"></script>
	<!-- magnific popup -->
	<script src="assets/js/jquery.magnific-popup.min.js"></script>
	<!-- mean menu -->
	<script src="assets/js/jquery.meanmenu.min.js"></script>
	<!-- sticker js -->
	<script src="assets/js/sticker.js"></script>
	<!-- main js -->
	<script src="assets/js/main.js"></script>

</body>
</html>