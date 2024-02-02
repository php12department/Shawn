<?php
include('connect.php'); 
$current_page = "Brand";
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
	<title> <?=$current_page;?> | <?php echo SITETITLE; ?></title>
	<?php include('include_css.php'); ?>
	<meta name="robots" content="follow, index, max-snippet:-1, max-image-preview:large"/>
</head>

<body>
	<!-- Header Area Start -->
	<?php include('include_header.php'); ?>
	<!-- Header Area End -->

	<div class="gallary-section">
		<div class="upload-gallary-section">
			<div class="container">
				<div class="row justify-content-center text-center">
					<div class="col-12">
						<h3>Our Vendors</h3>
					</div>
				</div>
			</div>
		</div>
		<div class="gallary-list-section brand-section">
			<section class="my-gallary-details">
				<div class="container">
					<div class="row">
						<div class="col-md-6 col-lg-4 mb-5">
							<div class="od-section">
								<div class="gallary-left">
									<div class="left-image">
										<a href="https://www.incantoitalia.com/"><img src="<?=SITEURL?>assets/img/vendors/Logo-Incanto.png"></a>
									</div>
								</div>
								<div class="gallary-right">
									<div class="gallary-body">
										<p>Incanto is a brand completely thought and realized in Italy</p>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-lg-4 mb-5">
							<div class="od-section">
								<div class="gallary-left">
									<div class="left-image">
										<a href="http://www.vigfurniture.com/"><img src="<?=SITEURL?>assets/img/vendors/viglogo.png"></a>
									</div>
								</div>
								<div class="gallary-right">
									<div class="gallary-body">
										<p>VIG Furniture, Inc. is a wholesale center for home furniture inspired by European design</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
	<!-- Footer Area Start -->
	<?php include('include_footer.php'); ?>
	<!-- Footer Area End -->
	<!-- all js here -->
	<?php include('include_js.php'); ?>
</body>
</html>