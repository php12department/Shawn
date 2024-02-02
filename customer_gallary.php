<?php
include('connect.php'); 
$current_page = "Customer Gallary";
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
	<title> <?=$current_page;?> | <?php echo SITETITLE; ?></title>
	<?php include('include_css.php'); ?>
	<meta name="robots" content="follow, index, max-snippet:-1, max-image-preview:large"/>
	<!-- meta tags site details -->
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Customer Gallary - Zilli Furniture" />
    <meta property="og:description" content="See our customer’s photo collection of the latest furniture items. The Customer gallery of Zilli furniture is always a special place for our new customers." />
    <meta property="og:url" content="<?=$actual_link;?>" />
    <meta property="og:site_name" content="<?php echo SITETITLE; ?>" />
    <meta property="og:image" content="<?=SITEURL?>common/images/logo.png" />
    <meta property="og:image:secure_url" content="<?= SITEURL?>common/images/logo.png" />
    <meta property="og:image:width" content="1282" />
    <meta property="og:image:height" content="676" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:description" content="See our customer’s photo collection of the latest furniture items. The Customer gallery of Zilli furniture is always a special place for our new customers." />
    <meta name="twitter:title" content="Customer Gallary - Zilli Furniture" />
    <meta name="twitter:image" content="<?= SITEURL?>common/images/logo.png" />
    <!-- end meta tags site details -->
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
						<!--<h3>CUSTOMER PHOTO GALLERY</h3>-->
					    <h1 class="text-uppercase customer-photo-collection">customer photo collection</h1>	
						<!--<p>SPREAD THE WORD AND SHARE WITH US! SIMPLY FILL OUT YOUR INFO AND UPLOAD PHOTOS!</p>-->
						<h3 class="text-uppercase customer-photo-desc">Create beautiful memories with us,Just fill the form and upload your photos!</h3>
						<a href="<?= SITEURL?>upload-photos/" class="banner-btn
						 hover-effect-span">UPLOAD YOUR PHOTOS
							<span class="icon">
								<svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid" fill='#fff' style="width:21px; height: 10px;" viewBox="0 0 21 10"><path d="M21.000,5.000 L15.000,10.000 L15.000,6.000 L-0.000,6.000 L-0.000,4.000 L15.000,4.000 L15.000,0.000 L21.000,5.000 Z"></path></svg>
							</span>
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="gallary-list-section">
			<section class="my-gallary-details">
				<div class="container-fluid">
					<div class="front-loading-div" style="display:none;">
                        <div><img style="width:10%" src="<?php echo SITEURL."common/images/loader.svg"?>" alt="<?php echo SITETITLE; ?>" /></div>
                    </div>
					<div class="row justify-content-center" id="results">
						
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

	<script type="text/javascript">
		$(document).ready(function(){
            view_result();
        });

        function view_result()
        {
            $.ajax({
                type: "POST",
                cache: false,
                url: "<?php echo SITEURL; ?>ajax_get_submission.php",
                data: "ajax=true&action=submission_data",
                beforeSend: function(){
                    $(".front-loading-div").show();
                },
                success: function(html) 
                {
                    setTimeout(function(){
                        $(".front-loading-div").hide();
                        $("#results").empty();
                        $("#results").html(html);
                    },1500);
                }
            });
        }
	</script>
</body>
</html>