<?php
include('connect.php'); 
$current_page = "Store Locations";

$store_r = $db->rpgetdata("store","*","id=1 AND isDelete=0","",0);
$store_d = @mysqli_fetch_array($store_r);


$text_title     = stripslashes($store_d['text_title']);
$text           = stripslashes($store_d['text']);
$address      	= stripslashes($store_d['address']);  
$description    = $store_d['description'];
$image_path     = $store_d['image_path'];

if(!empty($image_path) && file_exists(STORE.$image_path))
{
    $image1 = SITEURL.STORE.$image_path;
}
else
{
    $image1 = SITEURL."common/images/no_image.png";
}

$meta_title 			= stripslashes($store_d['meta_title']);
$meta_description 		= stripslashes($store_d['meta_description']);
$meta_keywords 			= stripslashes($store_d['meta_keywords']);
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
    <?php

    $meta_image_path     = $store_d['image_path'];

	if(!empty($meta_image_path) && file_exists(STORE.$meta_image_path))
	{
	    $meta_image1 = SITEURL.STORE.$meta_image_path;
   
        $metatag_image_width = "870";
        $metatag_image_height = "522";
        ?>
        <meta property="og:image" content="<?=$meta_image1?>" />
        <?php
    }
    else
    {
        $meta_image1      = SITEURL."common/images/logo.png";
        $metatag_image_width = "1282";
        $metatag_image_height = "676";
        ?>
        <meta property="og:image" content="<?=$meta_image1?>" />
        <?php
    }
    ?>
    <meta property="og:image:secure_url" content="<?= SITEURL?>common/images/logo.png" />
    <meta property="og:image:width" content="<?=$metatag_image_width;?>" />
    <meta property="og:image:height" content="<?=$metatag_image_height;?>" />
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
    <meta name="twitter:image" content="<?=$meta_image1?>" />
    <!-- end meta tags site details -->
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
								<img src="<?php echo $image1; ?>" class="img-fluid" alt="store locations Image">
							</a>
						</div>
					</div>
					<div class="col-12 col-md-5 pt-5 pt-md-0">
						<div class="row justify-content-center">
							<div class="col-12">
								<div class="store-title">
									<h3 class="store-h1 text-center letter-spacing-2 strong corpo-font store-locations-title"><?php echo $text_title; ?></h3>
									<p class="store-p pt-1"><?php echo $text; ?>
									</p>
								</div>
							</div>
							<div class="col-md-10 mb-3">
								<div class="address text-center">
									<h6 class="font-weight-bold fs-18 py-2">Address
									</h6>
									<address class="fs-15"><a href="https://www.google.com/maps?ll=33.072124,-96.688704&z=16&t=m&hl=en-US&gl=US&mapclient=embed&cid=3052341362603140637">
									<?php echo $address; ?></a>
									</address>
								</div>
							</div>
							<div class="col-md-10 mb-3">
								<div class="phone text-center">
									<h6 class="font-weight-bold fs-18 py-2">Phone
									</h6>
									<a href="tel:+469-543-0506" class="black-hover fs-15 text-black"><?php echo $telephone_number; ?>
									</a>
								</div>
							</div>
							<div class="col-md-12 my-3 text-center">
								<a href="<?=SITEURL?>store-details/" class="btn-black  text-uppercase mt-0">Get more details</a>
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