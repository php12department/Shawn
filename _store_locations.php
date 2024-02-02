<?php
include('connect.php'); 
$current_page = "Store Locations";
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
		<title><?=$current_page;?> | <?php echo SITETITLE; ?></title>
		<?php include('include_css.php'); ?>
</head>

<body>
		<!-- Header Area Start -->
		<?php include('include_header.php'); ?>
		<!-- Header Area End -->

		<!-- Breadcrumb Area Start -->
		<?php include('include_breadcrumb_area.php'); ?>
		<!-- Breadcrumb Area End -->
		
		<!-- store locations section start-->
		<div class="new-store-loction">
			<div class="container">
				<div class="row justify-content-between align-items-center">
					<div class="col-md-6">
						<div class="image-container position-relative">
							<a href="javascript:void(0);" class="">
								<img src="<?= SITEURL?>assets/img/store.jpg" class="img-fluid" alt="store locations Image">
							</a>
						</div>
					</div>
					<div class="col-12 col-md-5 pt-5 pt-md-0">
						<div class="row justify-content-center">
							<div class="col-12">
								<div class="store-title">
									<h1 class="store-h1 text-center letter-spacing-2 strong corpo-font">Plano, Texas</h1>
									<p class="store-p pt-1">We Love to meet You, Lets Get In Touch!
									</p>
								</div>
							</div>
							<div class="col-md-10 mb-5">
								<div class="address text-center">
									<h6 class="font-weight-bold py-2">Address
									</h6>
									<address class="fs-15">
										<a href="https://www.google.com/maps?ll=33.072124,-96.688704&z=16&t=m&hl=en-US&gl=US&mapclient=embed&cid=3052341362603140637">
									7265 Central Expressway,
									<br>
									Plano, Texas 75025</a>
									</address>
								</div>
							</div>
							<div class="col-md-10 mb-5">
								<div class="phone text-center">
									<h6 class="font-weight-bold py-2">Phone
									</h6>
									<a href="tel:+469-543-0506" class="black-hover fs-15 text-black">(469) 543-0506
									</a>
								</div>
							</div>
							<div class="col-md-12 my-3 text-center">
								<a href="<?= SITEURL?>store-details/" class="btn-black  text-uppercase mt-0">get more details</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- store locations section end-->

		<!-- Footer Area Start -->
		<?php include('include_footer.php'); ?>
		<!-- Footer Area End -->

		<!-- all js here -->
		<?php include('include_js.php'); ?>
		<script type="text/javascript">
				
		</script>
</body>

</html>