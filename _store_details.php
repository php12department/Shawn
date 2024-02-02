<?php
include('connect.php'); 
$current_page = "Store Location Details";
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
		
		<!-- store locations details section start-->
		<div class="store-details-section">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-md-12">
						<div class="row justify-content-between">
							<div class="col-md-12">
								<div class="store-map">
									<section class="map">
						        <div class="map-inner">
						        	<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d6686.81031514634!2d-96.688704!3d33.072124!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x2a5c184c1b31261d!2sZilli%20Furniture!5e0!3m2!1sen!2sus!4v1583903515898!5m2!1sen!2sus"width="600" height="600"  frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
						        </div>
						    </section>
								</div>
							</div>
							<div class="col-md-6 mt-4 mb-0 my-md-5">
								<h5>Zilli Furniture – Plano, Texas Modern Furniture Store</h5>
								<p class="mb-3">On N Central Expy heading north, take exit 32 for Legacy Drive. Turn left onto Legacy Drive crossing over N Central Expy. Turn right onto Chase Oaks Blvd and continue back to Central Expy. Turn right on Central Expy heading south and make an immediate right into the Zilli Furniture parking area.</p>
								<p class="mb-3">Heading south on Central Expy, use the right 2 lanes to tak exit 32a toward Frontage Road, continue past Chase Oaks Blvd and make an immediate right in the Zilli Furniture parking area.</p>
								<p class="mb-3">At the Zilli Furniture Plano North location you will find a large selection of quality modern contemporary furniture. Visit our new North Plano showroom to find complete rooms or individual pieces including fine Italian leather furniture, modern sofas, sectionals, modern dining tables, chairs, beds, nightstands, rugs and more. A wide array of styles and colors are available including modern and contemporary. Also, while in the store take time to visit our in-store custom blinds and shades showcase where you will find a large selection of fabric and styles for creating custom shades, roller shades, sheer blinds and more. This location also offers furniture delivery.</p>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-12 col-md-12 mt-3 mb-3 mt-md-5">
										<h5>Store Address</h5>
										<p>Zilli Furniture<br>
											7265 Central Expressway<br>
											Plano, Texas 75025<br>
											United States (US)<br>
											Email: info@zillifurniture.com</p>
									</div>
									<div class="col-md-12 mt-3 mb-2">
										<h5>Store Hours</h5>
											<table class="table time-table">
												<tr>
													<td>Monday</td>
													<td>10:00 AM - 8:00 PM</td>
												</tr>
												<tr>
													<td>Tuesday</td>
													<td>10:00 AM - 8:00 PM</td>
												</tr>
												<tr>
													<td>Wednesday</td>
													<td>10:00 AM - 8:00 PM</td>
												</tr>
												<tr>
													<td>Thursday</td>
													<td>10:00 AM - 8:00 PM</td>
												</tr>
												<tr>
													<td>Friday</td>
													<td>10:00 AM - 8:00 PM</td>
												</tr>
												<tr>
													<td>Saturday</td>
													<td>10:00 AM - 8:00 PM</td>
												</tr>
												<tr>
													<td>Sunday</td>
													<td>12:00 AM - 6:00 PM</td>
												</tr>
											</table>
										</div>
									</div>
								</div>
							
							<!-- <div class="col-md-6 my-5">
								<h5>Store Address</h5>
								<p>Zilli Furniture<br>
									7265 Central Expressway<br>
									Plano, Texas75025<br>
									United States (US)<br>
									Email: info@zillifurniture.com</p>
							</div>
							<div class="col-md-6 my-5">
								<h5>Store Hours</h5>
								<p>Monday: 10:00 AM - 8:00 PM</p>
								<p>Tuesday: 10:00 AM - 8:00 PM</p>
								<p>Wednesday: 10:00 AM - 8:00 PM</p>
								<p>Thursday: 10:00 AM - 8:00 PM</p>
								<p>Friday: 10:00 AM - 8:00 PM</p>
								<p>Saturday: 10:00 AM - 8:00 PM</p>
								<p>Sunday: 12:00 AM - 6:00 PM</p>
							</div> -->
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- store locations details section end-->

		<!-- Footer Area Start -->
		<?php include('include_footer.php'); ?>
		<!-- Footer Area End -->

		<!-- all js here -->
		<?php include('include_js.php'); ?>
		<script type="text/javascript">
				
		</script>
</body>

</html>