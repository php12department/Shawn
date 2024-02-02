<?php
include('connect.php'); 
$current_page = "Page not found";
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
		<title><?=$current_page;?> | <?php echo SITETITLE; ?></title>
		<?php include('include_css.php'); ?>
		<meta name="robots" content="follow, index, max-snippet:-1, max-image-preview:large"/>
</head>

<body>
		<!-- Header Area Start -->
		<?php include('include_header.php'); ?>
		<!-- Header Area End -->

		<!-- Breadcrumb Area Start -->
		<?php include('include_breadcrumb_area.php'); ?>
		<!-- Breadcrumb Area End -->
		<div class="page-not-found-section">
			<div class="container">
				<div class="row justify-content-center text-center">
					<div class="col-12 col-md-8">
						<div class="whoops-image">
							<img src="<?= SITEURL?>assets/img/notfound.png" class="img-fluid mx-auto text-center">
						</div>
						<div class="cound-not-found">
							<h2 class="not-h2">We couldn't find the page you<br>were looking for.</h2>
						</div>
						<div> 
							<div class="row justify-content-center text-center">
								<div class="col-8">
									<a href="javascript:void(0)" style="font-size: 40px; color: #969696;text-decoration: underline;">Go Back
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Footer Area Start -->
		<?php include('include_footer.php'); ?>
		<!-- Footer Area End -->

		<!-- all js here -->
		<?php include('include_js.php'); ?>
		<script type="text/javascript">
				
		</script>
</body>

</html>