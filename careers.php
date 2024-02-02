<?php
include('connect.php'); 
$current_page = "Careers";

$page_r = $db->rpgetdata("careers","*"," isDelete=0","",0);

$page_d         = @mysqli_fetch_array($page_r);

$pid             = stripslashes($page_d['id']);
$title      	 = stripslashes($page_d['title']); 
$description1    = $page_d['description1'];
$description2    = $page_d['description2'];
$description3    = $page_d['description3'];
$description4    = $page_d['description4'];

$meta_title        = stripslashes($page_d['meta_title']);
$meta_description  = stripslashes($page_d['meta_description']);
$meta_keywords     = stripslashes($page_d['meta_keywords']);
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
		
		<!-- Careers section -->
		<div class="careers-section">
				<div class="container">
					<div class="row mb justify-content-center text-center">
						<div class="col-md-10">
							<h3 class="h1-heading h3-heading"><?php echo $title; ?></h3>
							<p class="p-paragraph"><?php echo $description1; ?></p>
						</div>
					</div>
					<div class="row mb d-flex justify-content-center careers-row">
						<div class="col-md-10">
							<div class="row">
								<div class="col-12 col-sm-6 pb-4 pb-sm-0">
									<div class="card h-100">
										<div class="card-body d-flex flex-column">
											<?php echo $description2; ?>
										</div>
									</div>
								</div>
								<div class="col-12 col-sm-6">
									<div class="card h-100">
										<div class="card-body d-flex flex-column">
											<?php echo $description3; ?>
										</div>
									</div>
								</div>
							</div>  
						</div>
					</div>
					<?php echo $description4; ?>
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