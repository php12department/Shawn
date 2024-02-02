<?php
include('connect.php'); 
$current_page = "Home";
$curr_date_time = date("Y-m-d H:i:s");
$home_page_r = $db->rpgetData("home_page","*","isDelete=0 AND id='1'");
$home_page_d = @mysqli_fetch_array($home_page_r);

$hp_title_1_img 		= stripslashes($home_page_d['title_1_img']);
if(!empty($hp_title_1_img) && file_exists(HOME_PAGE.$hp_title_1_img))
{
    $hp_title_1_img = SITEURL.HOME_PAGE.$hp_title_1_img;
}
else
{
    $hp_title_1_img = SITEURL."common/images/no_image.png";
}

$hp_title1 			= stripslashes($home_page_d['title1']);
$hp_title_2_img 		= stripslashes($home_page_d['title_2_img']);
if(!empty($hp_title_2_img) && file_exists(HOME_PAGE.$hp_title_2_img))
{
    $hp_title_2_img = SITEURL.HOME_PAGE.$hp_title_2_img;
}
else
{
    $hp_title_2_img = SITEURL."common/images/no_image.png";
}

$hp_title2 			= stripslashes($home_page_d['title2']);
$hp_title_3_img 		= stripslashes($home_page_d['title_3_img']);
if(!empty($hp_title_3_img) && file_exists(HOME_PAGE.$hp_title_3_img))
{
    $hp_title_3_img = SITEURL.HOME_PAGE.$hp_title_3_img;
}
else
{
    $hp_title_3_img = SITEURL."common/images/no_image.png";
}

$hp_title3 			= stripslashes($home_page_d['title3']);
$hp_image_path1 		= stripslashes($home_page_d['image_path1']);
if(!empty($hp_image_path1) && file_exists(HOME_PAGE.$hp_image_path1))
{
    $hp_image_path1 = SITEURL.HOME_PAGE.$hp_image_path1;
}
else
{
    $hp_image_path1 = SITEURL."common/images/no_image.png";
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

$home_page_pro_r = $db->rpgetData("product","*","isDelete=0 AND isDisplayHomePage=1","id DESC limit 2");
$home_page_pro_c = @mysqli_num_rows($home_page_pro_r);
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
	<title> <?=$current_page;?> | <?php echo SITETITLE; ?></title>
	<?php 
	if($meta_title!="")
	{
	?>
	<meta name="title" content="<?=$meta_title;?>">
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
</head>

<body>
	<!-- Header Area Start -->
	<?php include('include_header.php'); ?>
	<!-- Header Area End -->
	<?php 
	$home_slider_r = $db->rpgetData("banner","*","isDelete=0 AND start_date_time <= '".$curr_date_time."' AND expiration_date_time >= '".$curr_date_time."'","display_order ASC");
	$home_slider_c = @mysqli_num_rows($home_slider_r);

	if($home_slider_c > 0)
	{
	?>
	<!-- Slider Area Start -->
	<div class="slider-area">
		<div class="slider-wrapper owl-carousel carousel-style-dot">
			<?php 
			$slider_count = 1;
			while($home_slider_d = @mysqli_fetch_array($home_slider_r))
			{
				$dis_home_banner_class = "";
				if($slider_count!=1)
				{
					$dis_home_banner_class = "slide-two";
				}

				$home_banner_image_path 	= stripslashes($home_slider_d['image']);
				if(!empty($home_banner_image_path) && file_exists(BANNER.$home_banner_image_path))
				{
				    $home_banner_image_path = SITEURL.BANNER.$home_banner_image_path;
				}
				else
				{
				    $home_banner_image_path = SITEURL."common/images/no_image.png";
				}

				$home_banner_title  = stripslashes($home_slider_d['title']);
				$home_banner_sub_title  = stripslashes($home_slider_d['sub_title']);
				$home_banner_button_text  = stripslashes($home_slider_d['button_text']);
				$home_banner_button_link  = ($home_slider_d['button_link']) ? stripslashes($home_slider_d['button_link']) : "javascript:void(0)";
			?>
			<div class="single-slide <?=$dis_home_banner_class;?>" style="background-image: url('<?=$home_banner_image_path;?>');">
				<div class="overlay"></div>
				<div class="container">
					<div class="slider-banner slide-banner small-font">
						<h1 class="text-white h1"><?=$home_banner_title;?></h1>
						<p class="text-white"><?=$home_banner_sub_title;?></p>
						<?php 
						if($home_banner_button_text!= "")
						{
						?>
						<a href="<?=$home_banner_button_link;?>" class="banner-btn hover-effect-span"><?=$home_banner_button_text;?>
							<span class="icon">
								<svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid" fill='#fff' style="width:21px; height: 10px;" viewBox="0 0 21 10"><path d="M21.000,5.000 L15.000,10.000 L15.000,6.000 L-0.000,6.000 L-0.000,4.000 L15.000,4.000 L15.000,0.000 L21.000,5.000 Z"></path></svg>
							</span>
						</a>
						<?php 
						}
						?>
					</div>
				</div>
			</div>
			<?php 
			$slider_count++;
			}
			?>
		</div>
	</div>
	<?php 
	}
	?>
	
	<div class="information-area">
		<div class="container">
			<div class="information-wrapper">
				<div class="row">
					<div class="col-md-4 mb-3 mb-md-0">
						<div class="single-information">
							<div class="col-3 col-md-4 col-lg-2">
								<div class="s-info-img">
									<img class="red-img" src="<?=$hp_title_1_img;?>">
								</div>
							</div>
							<div class="col-9 co-md-8">
								<div class="s-info-text">
									<h3><?=$hp_title1;?></h3>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4 mb-3 mb-md-0">
						<div class="single-information">
							<div class="col-3 col-md-4 col-lg-2">
								<div class="s-info-img"><img class="red-img" src="<?=$hp_title_2_img;?>"></div>
							</div>
							<div class="col-9 co-md-8">
								<div class="s-info-text">
									<h3><?=$hp_title2;?></h3>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4 mb-3 mb-md-0">
						<div class="single-information">
							<div class="col-3 col-md-4 col-lg-2">
								<div class="s-info-img img3"><img class="red-img" src="<?=$hp_title_3_img;?>"></div>
							</div>
							<div class="col-9 co-md-8">
								<div class="s-info-text">
									<h3><?=$hp_title3;?></h3>
									<!-- <span>Knowledgeable design consultants available for assistance</span> -->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Information Area End -->

	<!-- Banner Area Start -->
	<?php 
	if($home_page_pro_c > 0)
	{
	?>
	<div class="banner-area">
		<div class="row m-0 w-100">
			<?php 
			while($home_page_pro_d = @mysqli_fetch_array($home_page_pro_r))
			{
				$home_page_pro_id         		= $home_page_pro_d['id'];
				$home_page_pro_price          	= $home_page_pro_d['price'];
				$home_page_pro_sell_price     	= $home_page_pro_d['sell_price'];
				$home_page_pro_cate_id     		= $home_page_pro_d['cate_id'];
				$home_page_pro_sub_cate_id    	= $home_page_pro_d['sub_cate_id'];
				$home_page_pro_sub_sub_cate_id 	= $home_page_pro_d['sub_sub_cate_id'];
				$home_page_pro_image_path   	= $home_page_pro_d['image'];
				$home_page_pro_slug 			= stripslashes($home_page_pro_d['slug']);	
				$home_page_pro_name 			= stripslashes($home_page_pro_d['name']);	

				$pro_cate_slug = $db->rpgetValue("category","slug"," id='".$home_page_pro_cate_id."' ");
				$pro_sub_cate_slug = $db->rpgetValue("sub_category","slug"," id='".$home_page_pro_sub_cate_id."' ");
				$pro_sub_sub_cate_slug = $db->rpgetValue("sub_sub_category","slug"," id='".$home_page_pro_sub_sub_cate_id."' ");

				if(!empty($home_page_pro_image_path) && file_exists(PRODUCT.$home_page_pro_image_path))
				{
				    $home_page_pro_url = SITEURL.PRODUCT.$home_page_pro_image_path;
				}
				else
				{
				    $home_page_pro_url = SITEURL."common/images/no_image.png";
				}

				if($home_page_pro_sell_price > 0)
				{

					$is_discount_product = $db->checkIsDiscountProduct($home_page_pro_id,$home_page_pro_cate_id,$home_page_pro_sub_cate_id,$home_page_pro_sub_sub_cate_id,$home_page_pro_sell_price);
					$dis_price = '<span>'.CURR.($home_page_pro_sell_price - $is_discount_product['total_discount']).'</span><span class="price-line-through">'.CURR.$home_page_pro_price.'</span>';
				}
				else
				{
					$is_discount_product = $db->checkIsDiscountProduct($home_page_pro_id,$home_page_pro_cate_id,$home_page_pro_sub_cate_id,$home_page_pro_sub_sub_cate_id,$price);
					$dis_price = '<span>'.CURR.($home_page_pro_price - $is_discount_product['total_discount']).'</span>';
				}
				$dis_discount_desc = ($is_discount_product['discount_desc']) ? "<p>".$is_discount_product['discount_desc']."</p>" : "";

				$pro_details_url = SITEURL."product/".$pro_cate_slug."/".$home_page_pro_slug."/";
				if($home_page_pro_sub_cate_id!=0 && $home_page_pro_sub_cate_id!="")
				{
					$pro_details_url = SITEURL."product/".$pro_cate_slug."/".$pro_sub_cate_slug."/".$home_page_pro_slug."/";
				}

				if($home_page_pro_sub_sub_cate_id!=0 && $home_page_pro_sub_sub_cate_id!="")
				{
					$pro_details_url = SITEURL."product/".$pro_cate_slug."/".$pro_sub_cate_slug."/".$pro_sub_sub_cate_slug."/".$home_page_pro_slug."/";
				}
			?>
			<div class="col-lg-6 col-md-6 col-sm-6 col-relative p-2">
			    <div class="ov"></div>
			    <div class="fix-width-height-col-relative">
    				<a class="banner-image" href="<?=$pro_details_url;?>">
    					<img src="<?=$home_page_pro_url;?>" alt="<?=$home_page_pro_name;?>">
    				</a>
    				<div class="text">
    					<h4><?=$home_page_pro_name;?></h4>
    					<span><?=$dis_price;?></span>
    				</div>
    			</div>
			</div>
			<?php 
			}
			?>
		</div>
	</div>
	<?php 
	} 
	?>
	<!-- Banner Area End -->

	<!-- Ourdoor section start -->
	<div class="outdoor-section">
		<div class="row align-items-start align-items-center align-items-lg-center w-100 m-0">
			<div class="col-md-8 pl-col-1">
				<img src="<?=$hp_image_path1;?>" class="img-fluid w-100 img-responsive">
			</div>
			<div class="col-md-3 text-center text-md-left pl-col">
				<?=$hp_description1;?>
				<?php 
				if($hp_button_link!="" || $hp_button_name!="")
				{
					if($hp_button_link == "")
					{
						$hp_button_link = "javascript:void(0)";
					}
				?>
				<a href="<?=$hp_button_link;?>" class="banner-btn hover-effect-span"><?=$hp_button_name;?>
					<span class="icon">
						<svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid" fill='#fff' style="width:21px; height: 10px;" viewBox="0 0 21 10"><path d="M21.000,5.000 L15.000,10.000 L15.000,6.000 L-0.000,6.000 L-0.000,4.000 L15.000,4.000 L15.000,0.000 L21.000,5.000 Z"></path></svg>
					</span>
				</a>
				<?php 
				} 
				?>
			</div>
		</div>
	</div>	
	<!-- Ourdoor section end -->

	<div class="new-category-collection">
		<div class="row justify-content-center text-center w-100 m-0">
			<div class="col-12">
				<div class="cat-col-6">
					<h2 class="h3-span-style"><?=$hp_sec3_title;?></h2>
					<p><?=$hp_sec3_desc;?></p>
					<?php 
					if($hp_sec3_button_link!="" || $hp_sec3_button_name!="")
					{
						if($hp_sec3_button_link == "")
						{
							$hp_sec3_button_link = "javascript:void(0)";
						}
					?>
					<a href="<?=$hp_sec3_button_link;?>" class="banner-btn hover-effect-span"><?=$hp_sec3_button_name;?>
						<span class="icon">
							<svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid" fill='#fff' style="width:21px; height: 10px;" viewBox="0 0 21 10"><path d="M21.000,5.000 L15.000,10.000 L15.000,6.000 L-0.000,6.000 L-0.000,4.000 L15.000,4.000 L15.000,0.000 L21.000,5.000 Z"></path></svg>
						</span>
					</a>
					<?php 
					} 
					?>
				</div>
			</div>
			<?php 
			$home_category_r = $db->rpgetData("category","*","isDelete=0","display_order ASC");
			$home_category_c = @mysqli_num_rows($home_category_r);
			if($home_category_c > 0)
			{
			?>
			<div class="container">
				<div class="row custom-row pt-5">
						
						<?php 
						while($home_category_d = @mysqli_fetch_array($home_category_r))
						{
						$cate_name  = ucwords($home_category_d['name']);
						$image_path     = $home_category_d['image'];

						if(!empty($image_path) && file_exists(CATEGORY.$image_path))
						{
						    $cate_img_url = SITEURL.CATEGORY.$image_path;
						}
						else
						{
						    $cate_img_url = SITEURL."common/images/no_image.png";
						}

						$home_sub_cate_c = $db->rpgetTotalRecord("sub_category","cate_id='".$home_category_d['id']."' AND isDelete=0");	

						$dis_home_cate_url 		= "javascript:void(0)";
						if($home_sub_cate_c > 0)
						{
							$dis_home_cate_url = SITEURL."product-category/".$home_category_d['slug']."/";
						}
						else
						{
							$dis_home_cate_url = SITEURL."products/".$home_category_d['slug']."/";
						}
						?>
						<div class="col-12 col-sm-6 col-lg-4 carousel-style-one new-style-one d-flex justify-content-center">
    						<a href="<?=$dis_home_cate_url;?>" class="w-sm-100 w-xs-fix">
    							<div class="grid w-sm-100 w-xs-fix">
    								<figure class="effect-hover w-sm-100 w-xs-fix">
    									<img src="<?=$cate_img_url;?>"/>
    									<figcaption>
    										<h2><?=$cate_name;?></h2>
    									</figcaption>			
    								</figure>
    							</div>
    						</a>
    						</div>
						<?php 
						}
						?>

				</div>
			</div>
			<?php 
			}
			?>
		</div>
	</div>

	<div class="just-information-section outdoor-section">
		<div class="container h-100">
			<div class="row justify-content-center align-items-center h-100">
				<div class="col-12">
					<div class="dark-col">
						<div class="dark-sun-div text-center">
							<a href="<?=SITEURL?>customer-gallary/" class=" hover-effect-span"><?=$hp_sec4_title;?>
							<!-- <span class="icon">
								<svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid" fill='#fff' style="width:21px; height: 10px;" viewBox="0 0 21 10"><path d="M21.000,5.000 L15.000,10.000 L15.000,6.000 L-0.000,6.000 L-0.000,4.000 L15.000,4.000 L15.000,0.000 L21.000,5.000 Z"></path></svg>
							</span> -->
						</a>
						</div>
					</div>
				</div>
			</div>	
		</div>
	</div>

	<div class="new-category-collection brand-section">
		<div class="row justify-content-center text-center w-100 m-0">
			<div class="col-12">
				<div class="cat-col-6">
					<h3 class="h3-span-style"><?=$hp_sec5_title;?></h3>
					<!-- <p>We’ve gone to great lengths to bring you some fabulous furniture ranges to create your perfect bedroom.</p> -->
				<!-- 	<a href="product-list.html" class="banner-btn hover-effect-span">Shop now
							<span class="icon">
								<svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid" fill='#fff' style="width:21px; height: 10px;" viewBox="0 0 21 10"><path d="M21.000,5.000 L15.000,10.000 L15.000,6.000 L-0.000,6.000 L-0.000,4.000 L15.000,4.000 L15.000,0.000 L21.000,5.000 Z"></path></svg>
							</span>
						</a> -->
				</div>
			</div>
			<?php 
			$home_featured_brand_r = $db->rpgetData("featured_brand","*","isDelete=0");
			$home_featured_brand_c = @mysqli_num_rows($home_featured_brand_r);
			if($home_featured_brand_c > 0)
			{
			?>
			<div class="container">
				<div class="custom-row">
					<div class="brand-carousel owl-carousel carousel-style-one new-style-one">
						<?php 
						while($home_featured_brand_d = @mysqli_fetch_array($home_featured_brand_r))
						{
						$brand_name  = ucwords($home_featured_brand_d['name']);
						$image_path     = $home_featured_brand_d['image'];

						if(!empty($image_path) && file_exists(FEATURED_BRAND.$image_path))
						{
						    $brand_img_url = SITEURL.FEATURED_BRAND.$image_path;
						}
						else
						{
						    $brand_img_url = SITEURL."common/images/no_image.png";
						}
						
						$brand_pro_url = SITEURL."brand-product/".$home_featured_brand_d['slug']."/";
						?>
						<div class="grid">
							<figure class="effect-hover">
								<a href="<?=$brand_pro_url;?>" title="<?=$brand_name;?>"><img src="<?=$brand_img_url;?>"/></a>
								<figcaption>
									<!-- <h2>Brand Name</h2> -->
								</figcaption>			
							</figure>
						</div>
						<?php 
						}
						?>
					</div>
				</div>
			</div>
			<?php 
			}
			?>
		</div>
	</div>
	<!-- Footer Area Start -->
	
	<!-- Footer Area End -->
	<!-- all js here -->
	<?php include('include_js.php'); ?>
	<?php include('include_footer.php'); ?>
</body>
</html>