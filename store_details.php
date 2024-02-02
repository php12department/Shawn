<?php
include('connect.php'); 
$current_page = "Store Location Details";

$store_r = $db->rpgetdata("store","*","id=1 AND isDelete=0","",0);
$store_d = @mysqli_fetch_array($store_r);

$description    		= $store_d['description'];
$description_title      = $store_d['description_title'];

$meta_title 			= stripslashes($store_d['details_page_meta_title']);
$meta_description 		= stripslashes($store_d['details_page_meta_description']);
$meta_keywords 			= stripslashes($store_d['details_page_meta_keywords']);
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
	<?php 
	if($meta_title!="")
	{
	?>
	<title><?=$meta_title;?> | <?php echo SITETITLE; ?></title>
    <meta name="title" content="<?=$meta_title;?> | <?php echo SITETITLE; ?>">
	<?php
	}
	else
	{
	?>
	<title><?=$current_page;?> | <?php echo SITETITLE; ?></title>
	<?php
	}

	if($meta_description!="")
	{
	?>
	<meta name="description" content="<?=$meta_description;?>">
	<?php
	}

	if($meta_keywords!="")
	{
	?>
	<meta name="keywords" content="<?=$meta_keywords;?>">
	<?php
	}
	?>
	<?php include('include_css.php'); ?>
	<meta name="robots" content="follow, index, max-snippet:-1, max-image-preview:large"/>
	<!-- meta tags site details -->
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="website" />
    <?php 
    if($meta_title!="")
    {
    ?>
    <meta property="og:title" content="<?=$meta_title;?> | <?php echo SITETITLE; ?>" />
    <?php
    }
    else
    {
    ?>
    <meta property="og:title" content="<?=$meta_title;?>" />
    <?php
    }
    ?>
    <meta property="og:description" content="<?=$meta_description;?>" />
    <meta property="og:url" content="<?=$actual_link;?>" />
    <meta property="og:site_name" content="<?php echo SITETITLE; ?>" />
    <meta property="og:image" content="<?=SITEURL?>common/images/logo.png" />
    <meta property="og:image:secure_url" content="<?= SITEURL?>common/images/logo.png" />
    <meta property="og:image:width" content="1282" />
    <meta property="og:image:height" content="676" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:description" content="<?=$meta_description;?>" />
    <?php 
    if($meta_title!="")
    {
    ?>
    <meta name="twitter:title" content="<?=$meta_title;?> | <?php echo SITETITLE; ?>" />
    <?php
    }
    else
    {
    ?>
    <meta name="twitter:title" content="<?=$meta_title;?>" />
    <?php
    }
    ?>
    <meta name="twitter:image" content="<?= SITEURL?>common/images/logo.png" />
    <!-- end meta tags site details -->
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
						        	<iframe src="<?php echo $map_embed_iframe; ?>"width="600" height="600"  frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
						        </div>
						    </section>
								</div>
							</div>
							<div class="col-md-6 mt-4 mb-0 my-md-5">
								<h3 class="store-description-title"><?php echo $description_title; ?></h3>
								<?php echo $description; ?>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-12 col-md-12 mt-3 mb-3 mt-md-5">
										<h3 class="store-address">Store Address</h3>
										<p><?php echo SITENAME; ?><br>
										<?php echo $address; ?>
									</div>
									<div class="col-md-12 mt-3 mb-2">
										<h5>Store Hours</h5>
											<table class="table time-table">
												<tr>
													<td>Monday</td>
													<td><?php echo $store_hours_monday; ?></td>
												</tr>
												<tr>
													<td>Tuesday</td>
													<td><?php echo $store_hours_tuesday; ?></td>
												</tr>
												<tr>
													<td>Wednesday</td>
													<td><?php echo $store_hours_wednesday; ?></td>
												</tr>
												<tr>
													<td>Thursday</td>
													<td><?php echo $store_hours_thursday; ?></td>
												</tr>
												<tr>
													<td>Friday</td>
													<td><?php echo $store_hours_friday; ?></td>
												</tr>
												<tr>
													<td>Saturday</td>
													<td><?php echo $store_hours_saturday; ?></td>
												</tr>
												<tr>
													<td>Sunday</td>
													<td><?php echo $store_hours_sunday; ?></td>
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