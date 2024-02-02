<?php
include('connect.php');
$current_page = "Home";
$curr_date_time = date("Y-m-d H:i:s");
$home_page_r = $db->rpgetData("home_page", "*", "isDelete=0 AND id='1'");
$home_page_d = @mysqli_fetch_array($home_page_r);

$hp_title_1_img 		= stripslashes($home_page_d['title_1_img']);
if (!empty($hp_title_1_img) && file_exists(HOME_PAGE . $hp_title_1_img)) {
	$hp_title_1_img = SITEURL . HOME_PAGE . $hp_title_1_img;
} else {
	$hp_title_1_img = SITEURL . "common/images/no_image.png";
}

$hp_title1 			= stripslashes($home_page_d['title1']);
$hp_title_2_img 		= stripslashes($home_page_d['title_2_img']);
if (!empty($hp_title_2_img) && file_exists(HOME_PAGE . $hp_title_2_img)) {
	$hp_title_2_img = SITEURL . HOME_PAGE . $hp_title_2_img;
} else {
	$hp_title_2_img = SITEURL . "common/images/no_image.png";
}

$hp_title2 			= stripslashes($home_page_d['title2']);
$hp_title_3_img 		= stripslashes($home_page_d['title_3_img']);
if (!empty($hp_title_3_img) && file_exists(HOME_PAGE . $hp_title_3_img)) {
	$hp_title_3_img = SITEURL . HOME_PAGE . $hp_title_3_img;
} else {
	$hp_title_3_img = SITEURL . "common/images/no_image.png";
}

$hp_title3 			= stripslashes($home_page_d['title3']);
$hp_image_path1 		= stripslashes($home_page_d['image_path1']);
if (!empty($hp_image_path1) && file_exists(HOME_PAGE . $hp_image_path1)) {
	$hp_image_path1 = SITEURL . HOME_PAGE . $hp_image_path1;
} else {
	$hp_image_path1 = SITEURL . "common/images/no_image.png";
}

$hp_description1 		= stripslashes($home_page_d['description1']);
$hp_button_name 		= stripslashes($home_page_d['button_name']);
$hp_button_link 		= stripslashes($home_page_d['button_link']);
$hp_sec3_title 			= stripslashes($home_page_d['sec3_title']);
$hp_sec3_desc 			= stripslashes($home_page_d['sec3_desc']);
$hp_sec3_button_name 	= stripslashes($home_page_d['sec3_button_name']);
$hp_sec3_button_link 	= stripslashes($home_page_d['sec3_button_link']);
$hp_sec4_title 			= stripslashes($home_page_d['sec4_title']);
$hp_sec5_title 			= stripslashes($home_page_d['sec5_title']);

$meta_title 			= stripslashes($home_page_d['meta_title']);
$meta_description 		= stripslashes($home_page_d['meta_description']);
$meta_keywords 			= stripslashes($home_page_d['meta_keywords']);

$home_page_pro_r = $db->rpgetData("product", "*", "isDelete=0 AND isDisplayHomePage=1", "id DESC");
$home_page_pro_c = @mysqli_num_rows($home_page_pro_r);
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
	<?php
	if ($meta_title != "") {
	?>
		<title> <?= $meta_title; ?> | <?php echo SITETITLE; ?></title>
		<meta name="title" content="<?= $meta_title; ?> | <?php echo SITETITLE; ?>">
	<?php
	} else {
	?>
		<title><?= $current_page; ?> | <?php echo SITETITLE; ?></title>
	<?php
	}

	if ($meta_description != "") {
	?>
		<meta name="description" content="<?= $meta_description; ?>">
	<?php
	}

	if ($meta_keywords != "") {
	?>
		<meta name="keywords" content="<?= $meta_keywords; ?>">
	<?php
	}
	?>
	<?php include('new_include_css.php'); ?>
	<meta name="robots" content="follow, index, max-snippet:-1, max-image-preview:large" />
	<!-- meta tags site details -->
	<meta property="og:locale" content="en_US" />
	<meta property="og:type" content="website" />
	<?php
	if ($meta_title != "") {
	?>
		<meta property="og:title" content="<?= $meta_title; ?> | <?php echo SITETITLE; ?>" />
	<?php
	} else {
	?>
		<meta property="og:title" content="<?= $meta_title; ?>" />
	<?php
	}
	?>
	<meta property="og:description" content="<?= $meta_description; ?>" />
	<meta property="og:url" content="<?= $actual_link; ?>" />
	<meta property="og:site_name" content="<?php echo SITETITLE; ?>" />
	<?php

	$metatag_home_slider_r = $db->rpgetData("banner", "*", "isDelete=0 AND start_date_time <= '" . $curr_date_time . "' AND expiration_date_time >= '" . $curr_date_time . "'", "display_order ASC");
	$metatag_home_slider_c = @mysqli_num_rows($metatag_home_slider_r);

	if ($metatag_home_slider_c > 0) {
		while ($metatag_home_slider_d = @mysqli_fetch_array($metatag_home_slider_r)) {
			$metatag_banner_image 	= stripslashes($metatag_home_slider_d['image']);
			if (!empty($metatag_banner_image) && file_exists(BANNER . $metatag_banner_image)) {
				$metatag_banner_image = SITEURL . BANNER . $metatag_banner_image;
			}
		}
	}
	if ($metatag_banner_image) {
		$metatag_image_width = "1350";
		$metatag_image_height = "496";
	?>
		<meta property="og:image" content="<?= $metatag_banner_image ?>" />
	<?php
	} else {
		$metatag_banner_image      = SITEURL . "common/images/logo.png";
		$metatag_image_width = "1282";
		$metatag_image_height = "676";
	?>
		<meta property="og:image" content="<?= $metatag_banner_image ?>" />
	<?php
	}
	?>
	<meta property="og:image:secure_url" content="<?= SITEURL ?>common/images/logo.png" />
	<meta property="og:image:width" content="<?= $metatag_image_width; ?>" />
	<meta property="og:image:height" content="<?= $metatag_image_height; ?>" />
	<meta name="twitter:card" content="summary_large_image" />
	<meta name="twitter:description" content="<?= $meta_description; ?>" />
	<?php
	if ($meta_title != "") {
	?>
		<meta name="twitter:title" content="<?= $meta_title; ?> | <?php echo SITETITLE; ?>" />
	<?php
	} else {
	?>
		<meta name="twitter:title" content="<?= $meta_title; ?>" />
	<?php
	}
	?>
	<meta name="twitter:image" content="<?= $metatag_banner_image ?>" />
	<!-- end meta tags site details -->
</head>

<body>
	<!-- Header Area Start -->
	<?php include('new_include_header.php'); ?>
	<!-- Header Area End -->
	<?php
	$home_slider_r = $db->rpgetData("banner", "*", "isDelete=0 AND start_date_time <= '" . $curr_date_time . "' AND expiration_date_time >= '" . $curr_date_time . "'", "display_order ASC");
	$home_slider_c = @mysqli_num_rows($home_slider_r);

	if ($home_slider_c > 0) {
	?>
		<!-- Slider Area Start -->
		<div class="slider-area">
			<div class="slider-wrapper owl-carousel carousel-style-dot">
				<?php
				$slider_count = 1;
				while ($home_slider_d = @mysqli_fetch_array($home_slider_r)) {
					$dis_home_banner_class = "";
					if ($slider_count != 1) {
						$dis_home_banner_class = "slide-two";
					}

					$home_banner_image_path 	= stripslashes($home_slider_d['image']);
					if (!empty($home_banner_image_path) && file_exists(BANNER . $home_banner_image_path)) {
						$home_banner_image_path = SITEURL . BANNER . $home_banner_image_path;
					} else {
						$home_banner_image_path = SITEURL . "common/images/no_image.png";
					}

					$home_banner_title  = stripslashes($home_slider_d['title']);
					$home_banner_sub_title  = stripslashes($home_slider_d['sub_title']);
					$home_banner_button_text  = stripslashes($home_slider_d['button_text']);
					$home_banner_button_link  = ($home_slider_d['button_link']) ? stripslashes($home_slider_d['button_link']) : "javascript:void(0)";
					$home_banner_rectanglebox_banner  = stripslashes($home_slider_d['rectanglebox_banner']);
					$home_banner_rectanglebox_color  = stripslashes($home_slider_d['rectanglebox_color']);
					$bannerlink='';
					if ($home_banner_button_text == "" && $home_banner_button_link!='') {
						$bannerlink="href='".$home_banner_button_link."'";
					}

				?>
					<a class="single-slide <?= $dis_home_banner_class; ?>" <?= $bannerlink ?> style="background-image: url('<?= $home_banner_image_path; ?>');">
						<div class="overlay"></div>
						<div class="container">
							<?php
							$is_rectanglebox = "";
							if ($home_banner_rectanglebox_banner != 0 && $home_banner_rectanglebox_color != "") {
								$is_rectanglebox = "background: rgb(175 175 175 / 50%)";
								$is_rectanglebox_color = "background-color:" . $home_banner_rectanglebox_color . ";";
							} else {
								$is_rectanglebox_color = "";
							}
							?>

							<div class="slider-banner slide-banner small-font " style="<?= $is_rectanglebox_color; ?>" style="<?= $is_rectanglebox; ?>">
								<h2 class="text-white h1"><?= $home_banner_title; ?></h2>
								<p class="text-white"><?= $home_banner_sub_title; ?></p>
								<?php
								if ($home_banner_button_text != "") {
								?>
									<a href="<?= $home_banner_button_link; ?>" class="banner-btn hover-effect-span"><?= $home_banner_button_text; ?>
										<span class="icon">
											<svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid" fill='#fff' style="width:21px; height: 10px;" viewBox="0 0 21 10">
												<path d="M21.000,5.000 L15.000,10.000 L15.000,6.000 L-0.000,6.000 L-0.000,4.000 L15.000,4.000 L15.000,0.000 L21.000,5.000 Z"></path>
											</svg>
										</span>
									</a>
								<?php
								}
								?>
							</div>

						</div>
							</a>
				<?php
					$slider_count++;
				}
				?>
			</div>
		</div>
	<?php
	}
	?>

	<!-- Footer Area Start -->

	<!-- Footer Area End -->
	<!-- all js here -->
	<?php include('new_include_js.php'); ?>
	<?php include('new_include_footer.php'); ?>
</body>

</html>