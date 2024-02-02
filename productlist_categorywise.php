<?php
include('connect.php'); 
$current_page = "Product List";

$cate_slug          = $db->clean($_REQUEST['cate_slug']);
$sub_cate_slug      = $db->clean($_REQUEST['sub_cate_slug']);
$sub_sub_cate_slug  = $db->clean($_REQUEST['sub_sub_cate_slug']);
/*echo "<pre>";
print_r($_REQUEST);
die();*/
$cate_id            = "";
$sub_cate_id        = "";
$sub_sub_cate_id    = "";

$IMAGEPATH_BANNER   = CATE_BANNER;

$ctable_r   = $db->rpgetData("category","*","slug = '".$cate_slug."' AND isDelete=0","");
if(@mysqli_num_rows($ctable_r)>0)
{
	$ctable_d           = @mysqli_fetch_array($ctable_r);
	$cate_name          = stripslashes($ctable_d['name']);
	$cate_id            = $ctable_d['id'];

	$meta_title        = stripslashes($ctable_d['meta_title']);
	$meta_description  = stripslashes($ctable_d['meta_description']);
	$meta_keywords     = stripslashes($ctable_d['meta_keywords']);

	
	if (isset($ctable_d['banner_image']) && !empty($ctable_d['banner_image'])) {
		$banner_image      = SITEURL.$IMAGEPATH_BANNER.$ctable_d['banner_image'];
		//$extention_img_vid = "substring_index(banner_image,'.',-1) as AllFileExtension from category";
		$extention_img_vid = $db->rpgetData("category","substring_index(banner_image,'.',-1) as AllFileExtension","isDelete=0");
		//echo $extention_img_vid;die();
	}else{
		$banner_image      = SITEURL."assets/img/product/mo-2.jpg";
	}
	
	$dis_banner_title = $cate_name;
	$get_total_where.= "cate_id='".$cate_id."' AND ";

	if($sub_cate_slug!="")
	{
		$sub_cate_r = $db->rpgetData("sub_category","*","cate_id='".$cate_id."' AND slug='".$sub_cate_slug."' AND isDelete=0","");
		$sub_cate_c          = @mysqli_num_rows($sub_cate_r);

		if($sub_cate_c > 0)
		{ 
			$sub_cate_d         = @mysqli_fetch_array($sub_cate_r);

			$sub_cate_name      = stripslashes($sub_cate_d['name']);
			$sub_cate_id        = $sub_cate_d['id'];
			$dis_banner_title   = $sub_cate_name;

			$meta_title        = stripslashes($sub_cate_d['meta_title']);
			$meta_description  = stripslashes($sub_cate_d['meta_description']);
			$meta_keywords     = stripslashes($sub_cate_d['meta_keywords']);
			
			$is_video            = $sub_cate_d['is_video'];
	        //echo $iVideo;die();
		   
			if (isset($sub_cate_d['banner_image']) && !empty($sub_cate_d['banner_image'])) {
				$banner_image      = SITEURL.$IMAGEPATH_BANNER.$sub_cate_d['banner_image'];
			}else{
				$banner_image      = SITEURL."assets/img/product/mo-2.jpg";
			}
			
			$get_total_where.= "sub_cate_id='".$sub_cate_id."' AND ";

			if($sub_sub_cate_slug!="")
			{
				$sub_sub_cate_r = $db->rpgetData("sub_sub_category","*","cate_id='".$cate_id."' AND sub_cate_id='".$sub_cate_id."' AND slug='".$sub_sub_cate_slug."' AND isDelete=0");
				$sub_sub_cate_c          = @mysqli_num_rows($sub_sub_cate_r);

				if($sub_sub_cate_c > 0)
				{
					$sub_sub_cate_d         = @mysqli_fetch_array($sub_sub_cate_r);

					$sub_sub_cate_name      = stripslashes($sub_sub_cate_d['name']);
					$sub_sub_cate_id        = $sub_sub_cate_d['id'];
					$dis_banner_title       = $sub_sub_cate_name;

					$meta_title        = stripslashes($sub_sub_cate_d['meta_title']);
					$meta_description  = stripslashes($sub_sub_cate_d['meta_description']);
					$meta_keywords     = stripslashes($sub_sub_cate_d['meta_keywords']);
					
					if (isset($sub_sub_cate_d['banner_image']) && !empty($sub_sub_cate_d['banner_image'])) {
						$banner_image      = SITEURL.$IMAGEPATH_BANNER.$sub_sub_cate_d['banner_image'];
					}else{
						$banner_image      = SITEURL."assets/img/product/mo-2.jpg";
					}
					
					$get_total_where.= "sub_sub_cate_id='".$sub_sub_cate_id."' AND ";
				}
			}
		}
	}
}
else
{
	  $db->rplocation(SITEURL);
}
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
	
	<?php 
	include('include_css.php'); ?>
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

	if (isset($sub_cate_d['banner_image']) && !empty($sub_cate_d['banner_image'])) 
	{
		$metatag_image      = SITEURL.$IMAGEPATH_BANNER.$sub_cate_d['banner_image'];
		?>
		<meta property="og:image" content="<?=$metatag_image?>" />
		<?php
	}

	else
	{
	    $metatag_image      = SITEURL."assets/img/product/mo-2.jpg";
	    ?>
		<meta property="og:image" content="<?=$metatag_image?>" />
		<?php
	}
	?>
	<meta property="og:image:secure_url" content="<?= SITEURL?>common/images/logo.png" />
	<meta property="og:image:width" content="1920" />
	<meta property="og:image:height" content="1440" />
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
	<meta name="twitter:image" content="<?=$metatag_image?>" />
	<!-- end meta tags site details -->
</head>

<body>
	<!-- Header Area Start -->

	<?php include('include_header.php'); ?>
	<!-- Header Area End -->
	<style type="text/css">
		li.breadcrumb-rightside {
			background-color: rgb(88 88 88 / 60%);
    		padding-left: 20px;
		}
		li.breadcrumb-leftside {
			background-color: rgb(88 88 88 / 60%);
    		padding-right: 20px;
		}
		.breadcrumb-item.active{
			color: #fff;
		}
	</style>

	<div class="product-list-section">
	    <div class="video-banner">
	    <?php
	    if($is_video == 1)
	    {
	        ?>
	        <video controls autoplay class="pro-video" disablepictureinpicture controlslist="nodownload">
              <source src="<?= $banner_image; ?>" type="video/mp4">
              
              Your browser does not support the video tag.
            </video>
            <!--<div class="video-play">-->
            <!--    <img src="/assets/img/play-button.svg" width="50" id="play">-->
            <!--    <img src="/assets/img/pause.svg" width="50" id="pause">-->
            <!--    </div>-->
	        <?php
	    }
	    else
	    {
	    ?>
	    
		<div class="banner" style="background-image: url('<?= $banner_image; ?>')">
		 <?php
	    }
		 ?>
		 
		
		 
		   </div>
		  <!--  <img class="primary-image" src="<?= SITEURL?>assets/img/product/mo-2.jpg" alt=""> -->
		  <div class="container">
			  <div class="row justify-content-center align-items-center">
				  <div class="col-md-12 text-center title-main">
					  <h1><span class="bg-red-span"><?=ucwords($dis_banner_title);?></span></h1>
					  <nav aria-label="breadcrumb">
							<ul class="breadcrumb justify-content-center" style="background-color: transparent !important;">
								<li class="breadcrumb-item breadcrumb-rightside"><a href="<?= SITEURL?>">Home</a></li>
								<li class="breadcrumb-item breadcrumb-leftside active" aria-current="page"><h3 style="all:unset">Shop</h3></li>
							</ul>
						</nav>
				  </div>
			  </div>
		  </div>
		</div>
		<div class="container-fluid">
			<div class="shop-area ptb-80">
				<div class="container-fluid">
					<div class="row">
						<div class="col-12 col-mb-4">
							<div class="shop-content-wrapper">
								<div class="shop-results d-flex justify-content-end">
									<span class="word-break white-space">Sort By :  </span>
									<select name="sortData" id="sortData" onChange="sortData();" class="float-right" style="width:250px">
										<option value="">Select option</option>
										<option value="price-ASC">Price Low to High</option>
										<option value="price-DESC">Price High to Low</option>
										<option value="name-ASC">A-Z</option>
										<option value="name-DESC">Z-A</option>
									</select>
								</div>
							</div>
						</div>
						<!-- <div class="col-md-6 justify-content-start">
							<h4>Living Room</h4>
						</div> -->
					</div>
					<div class="front-loading-div" style="display:none;">
						<div><img style="width:10%" src="<?php echo SITEURL."common/images/loader.svg"?>" alt="<?php echo SITETITLE; ?>" /></div>
					</div>
					<div class="row flex-lg-nowrap justify-content-lg-center">
						<!-- <div class="col-xl-3 col-lg-4 pt-30 pl-40">
						    <div class="collapse-sidebar-filter d-block d-lg-none text-center">
								<a class="btn btn-light-black text-uppercase" data-toggle="collapse" href="#collapse-filter-options" role="button" aria-expanded="false" aria-controls="collapseExample">
								    Filter By
								</a>
							</div>
							
							<div class="sidebar-widget widget-style-1 panel-group border-0 p-0" id="widget-parent" aria-multiselectable="true" role="tablist">
								<h4 class="d-none d-lg-block">Shop By</h4>
								<div class="collapse mt-3 border-filter" id="collapse-filter-options">
								    <form name="FillterColorData" id="FillterColorData" method="POST">
									<?php 
									$brand_r = $db->rpgetData("featured_brand","*","isDelete=0");
									$brand_c = @mysqli_num_rows($brand_r);
									if($brand_c > 0)
									{
									?>
									<div class="panel widget-option">
										<a data-toggle="collapse" href="#brand_section" data-parent="#widget-parent">Brand</a>
										<div class="collapse show" id="brand_section">
											<div class="collapse-content">
												<?php 
												while($brand_d = @mysqli_fetch_array($brand_r))
												{
												$total_brand = $db->rpgetTotalRecord("product",$get_total_where." pro_feature_brand='".$brand_d['id']."' AND isDelete=0");
												?>
												<div class="single-widget-opt">
													<input type="checkbox" name="pro_feature_brand[]" id="brand_<?=$brand_d['id'];?>" value="<?=$brand_d['id'];?>" onClick="sortData();">
													<label for="brand_<?=$brand_d['id'];?>"><?=ucwords($brand_d['name']);?> <span>(<?=$total_brand;?>)</span></label>
												</div>
												<?php
												}
												?>
											</div>
										</div>
									</div>
									<?php 
									}

									$add_sub_cate_id  = ($sub_cate_id!="") ? $sub_cate_id : 0;
									$add_sub_sub_cate_id  = ($sub_sub_cate_id!="") ? $sub_sub_cate_id : 0;

									$add_label_r = $db->rpgetData("product_additional_field_details","*","isDelete=0 AND cate_id='".$cate_id."' AND sub_cate_id='".$add_sub_cate_id."' AND sub_sub_cate_id='".$add_sub_sub_cate_id."'  group by additional_field_id","id DESC");
									while($add_label_d = @mysqli_fetch_array($add_label_r))
									{
									$add_label_nm = $db->rpgetValue("additional_field","name","id='".$add_label_d['additional_field_id']."'");
									?>
									<div class="panel widget-option">
										<a class="collapsed" data-toggle="collapse" href="#additional_<?=$add_label_d['id']?>_section" data-parent="#widget-parent"><?=ucwords($add_label_nm);?></a>
										<div class="collapse" id="additional_<?=$add_label_d['id']?>_section">
											<div class="collapse-content">
												<?php 
												$exp_add_field_val_ids = explode(",",$add_label_d['additional_field_val_ids']);
												foreach ($exp_add_field_val_ids as $key => $value) 
												{
												$add_field_val_nm = $db->rpgetValue("additional_field_value","name","id='".$value."'");
												$total_add_label = $db->rpgetTotalRecord("product_additional_field_details",$get_total_where." isDelete=0 AND additional_field_id='".$add_label_d['additional_field_id']."' AND FIND_IN_SET(".$value.",additional_field_val_ids)");
												?>
												<div class="single-widget-opt">
													<input type="checkbox" name="add_field_val[<?=$add_label_d['additional_field_id']?>][]" id="add_filed_label_<?=$value;?>" value="<?=$value;?>" onClick="sortData();">
													<label for="add_filed_label_<?=$value;?>"><?=ucwords($add_field_val_nm);?> <span>(<?=$total_add_label;?>)</span></label>
												</div>
												<?php
												}
												?>
											</div>
										</div>
									</div>
									<?php 
									}

									$color_r = $db->rpgetData("color","*","isDelete=0");
									$color_c = @mysqli_num_rows($color_r);
									if($color_c > 0)
									{
									?>
									<div class="panel widget-option">
										<a class="collapsed" data-toggle="collapse" href="#color_section" data-parent="#widget-parent">Color</a>
										<div class="collapse" id="color_section">
											<div class="collapse-content">
												<?php 
												while($color_d = @mysqli_fetch_array($color_r))
												{
												$total_color = $db->rpgetTotalRecord("product",$get_total_where." color_id='".$color_d['id']."' AND isDelete=0");
												?>
												<div class="single-widget-opt">
													<input type="checkbox" name="color_id[]" id="color_<?=$color_d['id'];?>" value="<?=$color_d['id'];?>"  onClick="sortData();">
													<label for="color_<?=$color_d['id'];?>"><?=ucwords($color_d['name']);?> <span>(<?=$total_color;?>)</span></label>
												</div>
												<?php
												} 
												?>
											</div>
										</div>
									</div>
									<?php 
									}

									$material_r = $db->rpgetData("material","*","isDelete=0");
									$material_c = @mysqli_num_rows($material_r);
									if($material_c > 0)
									{
									?>
									<div class="panel widget-option">
										<a class="collapsed" data-toggle="collapse" href="#material_section" data-parent="#widget-parent">Material</a>
										<div class="collapse" id="material_section">
											<div class="collapse-content">
												<?php 
												while($material_d = @mysqli_fetch_array($material_r))
												{
												$total_material = $db->rpgetTotalRecord("product",$get_total_where." material_id='".$material_d['id']."' AND isDelete=0");
												?>
												<div class="single-widget-opt">
													<input type="checkbox" name="material_id[]" id="material_<?=$material_d['id'];?>" value="<?=$material_d['id'];?>"  onClick="sortData();">
													<label for="material_<?=$material_d['id'];?>"><?=ucwords($material_d['name']);?> <span>(<?=$total_material;?>)</span></label>
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
									<div class="panel widget-option">
										<a class="collapsed" data-toggle="collapse" href="#price_section" data-parent="#widget-parent">Price</a>
										<div class="collapse" id="price_section">
											<div class="collapse-content">
												<?php 
												$price_array = range(0,3000,500);
												$count_price_array = count($price_array);
												foreach ($price_array as $key => $value) 
												{
													$last_price = " - ".$price_array[$key+1];
													if($key == ($count_price_array - 1))
													{
														$last_price = " And Above";
													}

													$price_range = explode(" - ",$value.$last_price);
													$price_range_0  = $price_range[0];
													$price_range_1  = $price_range[1];

													if($price_range_0 == "3000 And Above")
													{   
														$price_range    = explode(" And ",$price_range_0);
														$price_range_0  = $price_range[0];
														$price_range_1  = "1000000";
													}

													$total_price_range = $db->rpgetTotalRecord("product",$get_total_where." price BETWEEN '".$price_range_0."' AND '".$price_range_1."' AND isDelete=0");
												?>
												<div class="single-widget-opt">
													<input type="radio" id="price_<?=$value;?>" name="price_range" value="<?=$value.$last_price;?>"  onClick="sortData();">
													<label for="price_<?=$value;?>"><?php echo $value.$last_price;?> <span>(<?=$total_price_range;?>)</span></label>
												</div>
												<?php
												}
												?>
											</div>
										</div>
									</div>
								</form>
								</div>
							</div>
						</div> -->

						<div class="col-xl-12 col-lg-12 mt-5 p-0">
							<div class="ht-product-shop tab-content">
								<div class="tab-pane active show fade text-center" id="grid" role="tabpanel">
									<div class="row w-lg-100 mx-0" id="results">
										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- <section class="newsletter-section">
     <div class="container-fluid">
          <div class="row">
               <div class="left-chair-image-fix">
                    <img src="assets/img/home/left-chair.png">
               </div>
               <div class="offset-lg-5 col-lg-7">
                    <div class="newsletter-form-sec-fix">
                         <h2>Sign up for Our Newsletter</h2>
                         <form class="newsletter-form" action="javascript:;" name="frmsubscribe" id="frmsubscribe" method="post">
                              <div class="form-group"> 
                                    <input type="email" name="email" id="email" placeholder="ENTER YOUR EMAIL ADDRESS" class="form-control" required >
                               </div>
                               <div class="form-group"> 
                                   <button type="submit" name="subscribe" id="subscribe" class="btn subscribe-btn">Subscribe &nbsp;&nbsp; <svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0.999023 13.748L12.999 1.74805" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M0.999023 1.74805H12.999V13.748" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </button>
                              </div>
                         </form>
                    </div>
               </div>
          </div>
     </div>
</section> -->

	<?php include('include_footer.php'); ?>
    <?php include('include_js.php'); 
	?>
	 <?php 
	// sor
	?>
   
	<script type="text/javascript">
		$(document).ready(function(){
			view_product();
			
		});

		function view_product()
		{
			var FillterColorData    = $('#FillterColorData').serialize();
			var sortData            = $("#sortData").val();

			$.ajax({
				type: "POST",
				cache: false,
				url: "<?php echo SITEURL; ?>ajax_get_productlist_categorywise.php",
				data: "ajax=true&cate_id=<?=$cate_id;?>&sub_cate_id=<?=$sub_cate_id;?>&sub_sub_cate_id=<?=$sub_sub_cate_id;?>&sortData="+sortData+"&"+FillterColorData,
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

		function sortData()
		{
			$("#results").html("");
			view_product();
		}
	</script>

</body>
</html>