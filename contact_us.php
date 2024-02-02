<?php
include('connect.php'); 

$ctable_r = $db->rpgetData("contactus_page","*","isDelete=0 AND id=1");
$ctable_d = @mysqli_fetch_array($ctable_r);

$main_title				= stripslashes($ctable_d['main_title']);
$image_path1 			= stripslashes($ctable_d['image_path1']);
if(!empty($image_path1) && file_exists(CONTACTUS_PAGE.$image_path1))
{
    $image_path1 = SITEURL.CONTACTUS_PAGE.$image_path1;
}
else
{
    $image_path1 = SITEURL."common/images/no_image.png";
}

$sec1_title				= stripslashes($ctable_d['sec1_title']);
$sec2_title				= stripslashes($ctable_d['sec2_title']);
$sec2_button_name		= stripslashes($ctable_d['sec2_button_name']);

$meta_title        = stripslashes($ctable_d['meta_title']);
$meta_description  = stripslashes($ctable_d['meta_description']);
$meta_keywords     = stripslashes($ctable_d['meta_keywords']);

$current_page 			= $main_title;
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

    $meta_image_path1 			= stripslashes($ctable_d['image_path1']);
    if(!empty($meta_image_path1) && file_exists(CONTACTUS_PAGE.$meta_image_path1))
    {
        $meta_image1 = SITEURL.CONTACTUS_PAGE.$meta_image_path1;
   
        $metatag_image_width = "1250";
        $metatag_image_height = "400";
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
		
		<div class="contact-us-banner-section text-center" style="background-image: url(<?=$image_path1;?>)">
			<div class="container h-100">
				<div class="row justify-content-center align-items-center h-100">
					<div class="col-md-12">
						<h3 class="contact-banner-title"><?=$current_page;?></h3><!-- 
						<p>get in touch with us</p> -->
					</div>
				</div>
			</div>
		</div>

		<div class="contact-from-section">
			<div class="contact-form">
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-md-10">
							<div class="row justify-content-center">
								<div class="col-md-6 custom-col-md-6">
									<div class="row" style="padding-top:50px;">
										<!-- <h5 class="h5-style">We would love to talk with our great customer</h5> -->
										<h4 class="text-uppercase h5-style contact-uppercase-title"><?=$sec1_title;?></h4>
										<div class="col-md-12 mb-4">
											<div class="row">
												<div class="col-1 pl-0">
													<span><i class="fa fa-globe"></i></span>
												</div>
												<div class="col-11">
													<h3 class="h6-style">ADDRESS DETAILS</h3>
													<p class="p-style"><a href="https://www.google.com/maps?ll=33.072124,-96.688704&z=16&t=m&hl=en-US&gl=US&mapclient=embed&cid=3052341362603140637"><?=$address;?></a>
													</p>
												</div>
											</div>
										</div>
										<div class="col-md-12 mb-4">
											<div class="row">
												<div class="col-1 pl-0">
													<span><i class="fa fa-envelope"></i></span>
												</div>
												<div class="col-11">
													<h6 class="h6-style">EMAIL ADDRESS</h6>
													<p class="p-style"><a href="mailto:<?=$email_address;?>"><?=$email_address;?></a></p>
												</div>
											</div>
										</div>
										<div class="col-md-12 mb-4">
											<div class="row">
												<div class="col-1 pl-0">
													<span><i class="fa fa-phone"></i></span>
												</div>
												<div class="col-11">
													<h6 class="h6-style">TELEPHONE NUMBER</h6>
													<p class="p-style"><a href="tel:<?=$telephone_number;?>"><?=$telephone_number;?></a></p>
												</div>
											</div>
										</div>
										<div class="col-md-12 mb-4">
											<div class="row">
												<div class="col-1 pl-0">
													<span><i class="fa fa-clock-o"></i></span>
												</div>
												<!-- <div class="col-11">
													<h6 class="h6-style">HOURS OF OPERATION</h6>
													<p class="p-style mb-0">Monday - Saturday: 10:00 AM - 8:00 PM</p>
													<p class="p-style">Sunday: 12:00 PM - 6:00 PM</p>
												</div> -->
												<div class="col-11">
													<h6 class="h6-style">HOURS OF OPERATION</h6>
													<table class="table time-table contact-time-table">
        												<tbody>
            												<tr>
            													<td>Monday</td>
            													<td><?=$store_hours_monday;?></td>
            												</tr>
            												<tr>
            													<td>Tuesday</td>
            													<td><?=$store_hours_tuesday;?></td>
            												</tr>
            												<tr>
            													<td>Wednesday</td>
            													<td><?=$store_hours_wednesday;?></td>
            												</tr>
            												<tr>
            													<td>Thursday</td>
            													<td><?=$store_hours_thursday;?></td>
            												</tr>
            												<tr>
            													<td>Friday</td>
            													<td><?=$store_hours_friday;?></td>
            												</tr>
            												<tr>
            													<td>Saturday</td>
            													<td><?=$store_hours_saturday;?></td>
            												</tr>
            												<tr>
            													<td>Sunday</td>
            													<td><?=$store_hours_sunday;?></td>
            												</tr>
            											</tbody>
    											    </table>
													<!--<p class="p-style mb-0">Monday : <?=$store_hours_monday;?></p>-->
													<!--<p class="p-style mb-0">Tuesday : <?=$store_hours_tuesday;?></p>-->
													<!--<p class="p-style mb-0">Wednesday : <?=$store_hours_wednesday;?></p>-->
													<!--<p class="p-style mb-0">Thursday : <?=$store_hours_thursday;?></p>-->
													<!--<p class="p-style mb-0">Friday : <?=$store_hours_friday;?></p>-->
													<!--<p class="p-style mb-0">Saturday : <?=$store_hours_saturday;?></p>-->
													<!--<p class="p-style">Sunday: <?=$store_hours_sunday;?></p>-->
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<form class="form-contact" method="post" action="<?php echo SITEURL; ?>process-contact-us/" id="contact_form" name="contact_form">
										<h4><?=$sec2_title;?></h4>
										<div class="row">
											<div class="col-md-12">
													<input type="text" name="form_name" id="form_name" placeholder="Your Name*">
											</div>
											<div class="col-md-12">
													<input type="text" name="form_email" id="form_email" placeholder="E-Mail*">
											</div>
										</div>
										<input type="text" name="form_subject" id="form_subject" placeholder="Subject*">
										<textarea name="form_message" id="form_message" cols="30" rows="10" placeholder="Type Your Message......."></textarea>
										<br>
										<!-- <div class="g-recaptcha" data-sitekey="6LfGONEZAAAAAF70awrtWovCZuxZyM7d2jJHk0pX"></div> -->
                                        <br/>
										<button type="submit" name="submit" class="default-btn"><?=$sec2_button_name;?></button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<section class="map">
			<div class="map-inner">
				<iframe src="<?=$map_embed_iframe;?>"width="600" height="600"  frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
			</div>
		</section>

		<!-- Footer Area Start -->
		<?php include('include_footer.php'); ?>
		<!-- Footer Area End -->

		<!-- all js here -->
		<?php include('include_js.php'); ?>
		<script src="https://www.google.com/recaptcha/api.js" async defer></script>
		<script type="text/javascript">
			$("#contact_form").validate({
				rules: {
					form_name:{required : true},
					form_email:{required : true,email: true},
					form_subject:{required : true},
					form_message:{required : true},
				},
				messages: {
					form_name:{required:"Please enter your name."},
					form_email:{required:"Please enter your email address.", email : "Please enter valid email address."},
					form_subject:{required:"Please enter your subject."},
					form_message:{required:"Please enter your message."},
				}, 
				errorPlacement: function (error, element) 
				{
					error.insertAfter(element);
				}
			});	
		</script>
</body>
</html>