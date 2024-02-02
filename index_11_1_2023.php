<?php
include('connect.php');

$current_page = "Home";
$curr_date_time = date("Y-m-d H:i:s");
$home_page_r = $db->rpgetData("home_page", "*", "isDelete=0 AND id='1'");
$home_page_d = @mysqli_fetch_array($home_page_r);

$hp_title_1_img         = stripslashes($home_page_d['title_1_img']);
if (!empty($hp_title_1_img) && file_exists(HOME_PAGE . $hp_title_1_img)) {
    $hp_title_1_img = SITEURL . HOME_PAGE . $hp_title_1_img;
} else {
    $hp_title_1_img = SITEURL . "common/images/no_image.png";
}

$hp_title1             = stripslashes($home_page_d['title1']);
$words = explode(" ", $hp_title1);
array_splice( $words, 1, 0, '<br>' );
$hp_title1 = join(" ",$words);
$hp_title_2_img         = stripslashes($home_page_d['title_2_img']);
if (!empty($hp_title_2_img) && file_exists(HOME_PAGE . $hp_title_2_img)) {
    $hp_title_2_img = SITEURL . HOME_PAGE . $hp_title_2_img;
} else {
    $hp_title_2_img = SITEURL . "common/images/no_image.png";
}

$hp_title2             = stripslashes($home_page_d['title2']);
$words = explode(" ", $hp_title2);
array_splice( $words, 1, 0, '<br>' );
$hp_title2 = join(" ",$words);
$hp_title_3_img         = stripslashes($home_page_d['title_3_img']);
if (!empty($hp_title_3_img) && file_exists(HOME_PAGE . $hp_title_3_img)) {
    $hp_title_3_img = SITEURL . HOME_PAGE . $hp_title_3_img;
} else {
    $hp_title_3_img = SITEURL . "common/images/no_image.png";
}

$hp_title3             = stripslashes($home_page_d['title3']);
$words = explode(" ", $hp_title3);
array_splice( $words, 1, 0, '<br>' );
$hp_title3 = join(" ",$words);
// $hp_image_path1         = stripslashes($home_page_d['image_path1']);
// if (!empty($hp_image_path1) && file_exists(HOME_PAGE . $hp_image_path1)) {
//     $hp_image_path1 = SITEURL . HOME_PAGE . $hp_image_path1;
// } else {
//     $hp_image_path1 = SITEURL . "common/images/no_image.png";
// }

$hp_description1         = stripslashes($home_page_d['description1']);
$hp_button_name         = stripslashes($home_page_d['button_name']);
$hp_button_link         = stripslashes($home_page_d['button_link']);
$hp_sec3_title             = stripslashes($home_page_d['sec3_title']);
$hp_sec3_desc             = stripslashes($home_page_d['sec3_desc']);
//$hp_sec3_button_name     = stripslashes($home_page_d['sec3_button_name']);
//$hp_sec3_button_link     = stripslashes($home_page_d['sec3_button_link']);
$hp_sec4_title             = stripslashes($home_page_d['sec4_title']);
$hp_sec5_title             = stripslashes($home_page_d['sec5_title']);

$meta_title             = stripslashes($home_page_d['meta_title']);
$meta_description         = stripslashes($home_page_d['meta_description']);
$meta_keywords             = stripslashes($home_page_d['meta_keywords']);

// $home_page_pro_r = $db->rpgetData("product", "*", "isDelete=0 AND price !=0 AND  image IS NOT NULL GROUP by cate_id", " id DESC limit 10",0);
$home_page_pro_r = $db->rpgetData("product", "id,cate_id,sub_cate_id,sub_sub_cate_id,name,price,sell_price,slug,image,isImage,pro_sub_cat", "isDelete=0 AND isDisplayHomePage=1", "id DESC");
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
            $metatag_banner_image     = stripslashes($metatag_home_slider_d['image']);
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
    $home_slider_r = $db->rpgetData("banner", "*", "isDelete=0 AND start_date_time <= '" . $curr_date_time . "' AND expiration_date_time >= '" . $curr_date_time . "'", "display_order ASC",0);
    $home_slider_c = @mysqli_num_rows($home_slider_r);

    if ($home_slider_c > 0) {
    ?>

        <!-- banner section start -->

        <section class="banner-section-main">
            <div class="banner-carousel slick">
               <?php
               while ($home_slider_d = @mysqli_fetch_array($home_slider_r)) 
               {
                         $home_banner_image_path 	= stripslashes($home_slider_d['image']);
					if (!empty($home_banner_image_path) && file_exists(BANNER . $home_banner_image_path)) {
						$home_banner_image_path = SITEURL . BANNER . $home_banner_image_path;
					} else {
						$home_banner_image_path = SITEURL . "common/images/no_image.png";
					}
                         $is_rectanglebox = "";
                         if ($home_banner_rectanglebox_banner != 0 && $home_banner_rectanglebox_color != "") {
                              $is_rectanglebox = "background: rgb(175 175 175 / 50%)";
                              $is_rectanglebox_color = "background-color:" . $home_banner_rectanglebox_color . ";";
                         } else {
                              $is_rectanglebox_color = "";
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
                       <?php 
                              if ($home_banner_button_text == "" || empty($home_banner_button_text))
                               {
                                   ?>
                                   <a href="<?= $home_banner_button_link; ?>">
                                   <?php
                               }
                         ?>
                         <div class="slick-slide">
                              <div class="images-item">
                              <img src="<?= $home_banner_image_path; ?>">
                              </div>
                              <div class="banner-caption">
                              <!-- <h5>Welcome to Zilli Furniture & Blinds</h5>  -->
                               <!-- <h2>BLACK FRIDAY<span>SALE</span></h2> -->
                              <h2><span><?= $home_banner_title; ?></span></h2>
                              <p><?= $home_banner_sub_title; ?></p>
                               <?php
                              if ($home_banner_button_text != "") {
                              ?>
                              <a href="<?= $home_banner_button_link; ?>" class="btn btn-shop"><?= $home_banner_button_text; ?></a>
                              <?php
                              }
                              ?>
                              </div>
                              <!-- <div class="bottom-text-highlight">
                              <h1>zilli Furniture</h1>
                              </div> -->
                         </div> 
                         <?php 
                              if ($home_banner_button_text == "" || empty($home_banner_button_text))
                               {
                                   ?>
                                   </a>
                                   <?php
                               }
                         ?>
                    <?php
               }
               ?>
                 
                   
                </div> 
            </div>
        </section>

        <!-- banner section end -->
       
    <?php
     }
     ?>
    <!-- Service Section Start -->

<section class="service-section-main">
       <div class="container">
             <div class="row">
                  <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                       <div class="service-sec-box-fix">
                            <div class="left-icon">
                                 <!-- <img src="assets/img/home/Frame(18).svg"> -->
                                 <img src="<?= $hp_title_1_img; ?>" alt="<?php echo SITETITLE; ?>">
                            </div>  
                            <div class="service-content">
                                  <h5><?= $hp_title1; ?></h5>
                            </div>
                       </div>
                  </div>
                  <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                    <div class="service-sec-box-fix">
                         <div class="left-icon">
                              <!-- <img src="assets/img/home/Frame(19).svg"> -->
                              <img src="<?= $hp_title_2_img; ?>" alt="<?php echo SITETITLE; ?>">
                         </div>  
                         <div class="service-content">
                              <h5><?= $hp_title2; ?></h5>
                         </div>
                    </div>
                  </div>
                  <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                    <div class="service-sec-box-fix border-0">
                        <div class="left-icon">
                              <!-- <img src="assets/img/home/Frame(20).svg"> -->
                              <img src="<?= $hp_title_3_img; ?>" alt="<?php echo SITETITLE; ?>">
                        </div>  
                        <div class="service-content">
                              <h5><?= $hp_title3; ?></h5>
                        </div>
                    </div>
                  </div>
             </div>
       </div>  
</section>

<!-- Service Section End -->

<!-- product section start -->

<section class="product-show-section-main">
     <div class="container-fluid px-0">
          <div class="row mx-0">
                <div class="col-lg-6">
                    <div class="product-show-left-sec">
                         <div role="tabpanel">
                              <!-- Nav tabs -->
                              <ul class="nav nav-tabs" role="tablist">
                                   <li role="presentation" class="active"><a class="active" href="#home" aria-controls="home" role="tab" data-toggle="tab">New Arrivals</a>

                                   </li>
                                   <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">On Sale</a>

                                   </li>
                                   <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Best Seller</a>

                                   </li>
                              </ul>
                              <div class="tab-content">
                                   <?php
                                        $new_arrival_r = $db->rpgetData("product", "id,cate_id,sub_cate_id,sub_sub_cate_id,name,price,sell_price,slug,image,isImage,pro_sub_cat", "isDelete=0  AND  price !=0 AND image IS NOT NULL and id IN (1872,264,1855,395,1777)","",0);
                                        // $new_arrival_r = $db->rpgetData("product", "*", "isDelete=0  AND isDisplayCategoryPage = 1 AND price !=0 AND image IS NOT NULL GROUP by cate_id", "display_order DESC limit 10",0);
                                        //$new_arrival_c = @mysqli_num_rows($new_arrival_r);
                                        //$best_sell_product_image_r="select pid from cartitems WHERE cart_id in(SELECT cart_id from payment_history)";
                                        // echo $best_sell_product_image_r;
                                        // die();
                                        /*$best_sell_product_image_r=mysqli_query($GLOBALS['myconn'],$best_sell_product_image_r);
                                        $pid=[];
                                        while($best_sell_product_image_d = @mysqli_fetch_array($best_sell_product_image_r))
                                        {
                                            // var_dump($best_sell_product_image_d);
                                            // exit;
                                             $best_sell_r=$db->rpgetData("product","id","isDelete=0 and image IS NOT NULL and id='".$best_sell_product_image_d['pid']."'");
                                             $best_sell_c=mysqli_num_rows($best_sell_r);
                                             if($best_sell_c>0)
                                             {
                                                  $pid[]=$best_sell_product_image_d['pid'];
                                                  
                                             }
                                             
                                        }
                                        $pid = implode(',',$pid);*/
                                        //var_dump($pid);
                                   
                                        // $best_sell_r=$db->rpgetData("product","*","isDelete=0 AND price !=0 and image IS NOT NULL and id IN (".$pid.") ","price DESC",0);
                                       
                                   ?>
                                   <div role="tabpanel" class="tab-pane active show" id="home">
                                        <div class="owl-carousel" id="owl1">
                                             <?php
                                             while($new_arrival_d = @mysqli_fetch_array($new_arrival_r))
                                             {
                                                  $pro_cate_slug_new_arrival= $db->rpgetValue("category", "slug", " id='" . $new_arrival_d['cate_id'] . "' ",0);
                                                  $pro_sub_cate_slug_new_arrival = $db->rpgetValue("sub_category", "slug", " id='" . $new_arrival_d['sub_cate_id'] . "' ",0);
                                                  $pro_sub_sub_cate_slug_new_arrival = $db->rpgetValue("sub_sub_category", "slug", " id='" . $new_arrival_d['sub_sub_cate_id'] . "' ");
                                                  $new_arrival_d_slug 			= stripslashes($new_arrival_d['slug']);
                                                  $new_arrival_d_cate_id     		= $new_arrival_d['cate_id'];
                                                  $new_arrival_d_sub_cate_id    	= $new_arrival_d['sub_cate_id'];
                                                  $new_arrival_d_sub_sub_cate_id 	= $new_arrival_d['sub_sub_cate_id'];
                                                  
                                                  if ($new_arrival_d['sell_price'] > 0) {
                                        
                                                       $is_discount_product_new_arrival = $db->checkIsDiscountProduct($new_arrival_d['id'], $new_arrival_d['cate_id'], $new_arrival_d['sub_cat_id'], $new_arrival_d['sub_sub_cat_id'], $new_arrival_d['sell_price']);
                                                       $dis_price_new_arraival = '<span>'.CURR.number_format(($new_arrival_d['sell_price'] - $is_discount_product_new_arrival['total_discount'])).'</span> <del style="color:gray;"> '.CURR.number_format($new_arrival_d['price']).'</del>';
                                                  } else {
                                                       $is_discount_product_new_arrival = $db->checkIsDiscountProduct($new_arrival_d['id'], $new_arrival_d['cate_id'], $new_arrival_d['sub_cate_id'], $new_arrival_d['sub_sub_cat_id'], $new_arrival_d['price']);
                                                       if($is_discount_product_new_arrival['is_discount_pro'] == 1)
                                                       {
                                                            $dis_price_new_arraival = '<span >'.CURR.number_format(($new_arrival_d['price'] - $is_discount_product_new_arrival['total_discount'])).'</span> <del style="color:gray;"> '.CURR.number_format($new_arrival_d['price']).'</del>'; 
                                                       }
                                                       else
                                                       {
                                                            $dis_price_new_arraival = '<span>'.CURR.number_format(($new_arrival_d['price'] - $is_discount_product_new_arrivaldiscount_product['total_discount'])).'</span>';
                                                       }
                                                  }
          
						
                                                  $pro_details_new_arrival = SITEURL . "product/" . $pro_cate_slug_new_arrival . "/" . $new_arrival_d_slug;
                                                  if ($new_arrival_d_sub_cate_id != 0 && $new_arrival_d_sub_cate_id != "") {
                                                  $pro_details_new_arrival = SITEURL . "product/" . $pro_cate_slug_new_arrival . "/" . $pro_sub_cate_slug_new_arrival . "/" . $new_arrival_d_slug . "/";
                                                  }
                                             
                                                  if ($new_arrival_d_sub_sub_cate_id != 0 && $new_arrival_d_sub_sub_cate_id != "") {
                                                  $pro_details_new_arrival = SITEURL . "product/" . $pro_cate_slug_new_arrival . "/" . $pro_sub_cate_slug_new_arrival . "/" . $pro_sub_sub_cate_slug_new_arrival . "/" . $new_arrival_d_slug . "/";
                                                  }
                                                  ?>
                                                  <a href="<?= $pro_details_new_arrival; ?>" style="color:black;">
                                                       <img src="<?= SITEURL . PRODUCT . $new_arrival_d['image']; ?>" alt="<?php echo SITEURL; ?>">
                                                       <div class="product-info">
                                                                 <p><?= substr($new_arrival_d['name'],0,17)."..."; ?></p>
                                                                 <h5><?= $dis_price_new_arraival; ?></h5>
                                                                 
                                                       </div>
                                                  </a>
                                                  <?php
                                             }
                                             
                                             
                                             ?>
                                        </div>
                                   </div>
                                   <div role="tabpanel" class="tab-pane" id="profile">
                                        <div class="owl-carousel" id="owl2">
                                             <?php 
                                             $onsale=[];
                                             // $i = 0;
                                             while ($home_page_pro_d = @mysqli_fetch_array($home_page_pro_r)) {
                                                  $home_page_pro_id         		= $home_page_pro_d['id'];
                                                  $home_page_pro_price          	= $home_page_pro_d['price'];
                                                  $home_page_pro_sell_price     	= $home_page_pro_d['sell_price'];
                                                  $home_page_pro_cate_id     		= $home_page_pro_d['cate_id'];
                                                  $home_page_pro_sub_cate_id    	= $home_page_pro_d['sub_cate_id'];
                                                  $home_page_pro_sub_sub_cate_id 	= $home_page_pro_d['sub_sub_cate_id'];
                                                  $home_page_pro_image_path   	= $home_page_pro_d['image'];
                                                  $home_page_pro_slug 			= stripslashes($home_page_pro_d['slug']);
                                                  $home_page_pro_name 			= stripslashes($home_page_pro_d['name']);
                    
                                                  $pro_cate_slug = $db->rpgetValue("category", "slug", " id='" . $home_page_pro_cate_id . "' ");
                                                  $pro_sub_cate_slug = $db->rpgetValue("sub_category", "slug", " id='" . $home_page_pro_sub_cate_id . "' ");
                                                  $pro_sub_sub_cate_slug = $db->rpgetValue("sub_sub_category", "slug", " id='" . $home_page_pro_sub_sub_cate_id . "' ");
                    
                                                  if (!empty($home_page_pro_image_path) && file_exists(PRODUCT . $home_page_pro_image_path)) {
                                                       $home_page_pro_url = SITEURL . PRODUCT . $home_page_pro_image_path;
                                                  } else {
                                                       $home_page_pro_url = SITEURL . "common/images/no_image.png";
                                                  }
                    
                                                  if ($home_page_pro_sell_price > 0) {
                    
                                                       $is_discount_product = $db->checkIsDiscountProduct($home_page_pro_id, $home_page_pro_cate_id, $home_page_pro_sub_cate_id, $home_page_pro_sub_sub_cate_id, $home_page_pro_sell_price);
                                                       // $dis_price = '<span>' . CURR . ($home_page_pro_sell_price - $is_discount_product['total_discount']) . '</span><span class="price-line-through">' . CURR . $home_page_pro_price . '</span>';
                                                       $dis_price = '<span>' . CURR . ($home_page_pro_sell_price - $is_discount_product['total_discount']) . '</span> <del style="color:gray;"> '. CURR . $home_page_pro_price . '</del>';
                                                  } else {
                                                       $is_discount_product = $db->checkIsDiscountProduct($home_page_pro_id, $home_page_pro_cate_id, $home_page_pro_sub_cate_id, $home_page_pro_sub_sub_cate_id, $price);
                                                       $dis_price = '<span>' . CURR . ($home_page_pro_price - $is_discount_product['total_discount']) . '</span>';
                                                  }
                                                  $dis_discount_desc = ($is_discount_product['discount_desc']) ? "<p>" . $is_discount_product['discount_desc'] . "</p>" : "";
                    
                                                  $pro_details_url = SITEURL . "product/" . $pro_cate_slug . "/" . $home_page_pro_slug . "/";
                                                  if ($home_page_pro_sub_cate_id != 0 && $home_page_pro_sub_cate_id != "") {
                                                       $pro_details_url = SITEURL . "product/" . $pro_cate_slug . "/" . $pro_sub_cate_slug . "/" . $home_page_pro_slug . "/";
                                                  }
                    
                                                  if ($home_page_pro_sub_sub_cate_id != 0 && $home_page_pro_sub_sub_cate_id != "") {
                                                       $pro_details_url = SITEURL . "product/" . $pro_cate_slug . "/" . $pro_sub_cate_slug . "/" . $pro_sub_sub_cate_slug . "/" . $home_page_pro_slug . "/";
                                                  }
                                                  ?>
                                             <a href="<?= $pro_details_url; ?>" style="color:black;">
                                                  <img src="<?= $home_page_pro_url; ?>" alt="<?php echo SITEURL; ?>">
                                                  <div class="product-info">
                                                            <p><?= substr($home_page_pro_name,0,17)."..."; ?></p>
                                                            <h5><?= $dis_price; ?></h5>
                                                  </div>
                                             </a>
                                             <?php
                                              }
                                             
                                             ?>
                                        </div>
                                   </div>
                                   <div role="tabpanel" class="tab-pane" id="messages">
                                        <div class="owl-carousel" id="owl3">
                                             <?php
                                                  $best_sell_r=$db->rpgetData("product","id,cate_id,sub_cate_id,sub_sub_cate_id,name,price,sell_price,slug,image,isImage,pro_sub_cat","isDelete=0 AND price !=0 and image IS NOT NULL and id IN (1869,1824,650,657,427,755,1943) ","price DESC",0);
                                                  while($best_sell_d = @mysqli_fetch_assoc($best_sell_r))
                                                  {

                                                       $best_sell_d_id         		= $best_sell_d['id'];
                                                       $best_sell_d_price          	= $best_sell_d['price'];
                                                       $best_sell_d_sell_price     	= $best_sell_d['sell_price'];
                                                       $best_sell_d_cate_id     	= $best_sell_d['cate_id'];
                                                       $best_sell_d_sub_cate_id    	= $best_sell_d['sub_cate_id'];
                                                       $best_sell_d_sub_sub_cate_id 	= $best_sell_d['sub_sub_cate_id'];
                                                       $best_sell_d_image_path   	= $best_sell_d['image'];
                                                       $best_sell_d_slug 			= stripslashes($best_sell_d['slug']);
                                                       $best_sell_d_name 			= stripslashes($best_sell_d['name']);
                                                       $pro_cate_slug = $db->rpgetValue("category", "slug", " id='" . $best_sell_d_cate_id . "' ");
                                                       $pro_sub_cate_slug = $db->rpgetValue("sub_category", "slug", " id='" . $best_sell_d_sub_cate_id . "' ");
                                                       $pro_sub_sub_cate_slug = $db->rpgetValue("sub_sub_category", "slug", " id='" . $best_sell_d_sub_sub_cate_id . "' ");
                                                  
                                                       if (!empty($best_sell_d_image_path) && file_exists(PRODUCT . $best_sell_d_image_path)) {
                                                       $best_sell_d_url = SITEURL . PRODUCT . $best_sell_d_image_path;
                                                       } else {
                                                       $best_sell_d_url = SITEURL . "common/images/no_image.png";
                                                       }
                                                  
                                                       if ($best_sell_d_sell_price > 0) {
                                                  
                                                       $is_discount_product1 = $db->checkIsDiscountProduct($best_sell_d_id, $best_sell_d_cate_id, $best_sell_d_sub_cate_id, $best_sell_d_sub_sub_cate_id, $best_sell_d_sell_price);
                                                       $dis_price1 = '' . CURR . ($best_sell_d_sell_price - $is_discount_product1['total_discount']) . ' <del style="color:gray;"> ' . CURR . $best_sell_d_price . '</del>';
                                                       } else {
                                                       $is_discount_product1 = $db->checkIsDiscountProduct($best_sell_d_id, $best_sell_d_cate_id, $best_sell_d_sub_cate_id, $best_sell_d_sub_sub_cate_id, $price);
                                                       $dis_price1 = '<span>' . CURR . ($best_sell_d_price - $is_discount_product1['total_discount']) . '</span>';
                                                       }
                                                       $dis_discount_desc = ($is_discount_product['discount_desc']) ? "<p>" . $is_discount_product['discount_desc'] . "</p>" : "";
                                                  
                                                       $pro_details_url_best_sell = SITEURL . "product/" . $pro_cate_slug . "/" . $best_sell_d_slug . "/";
                                                       if ($best_sell_d_sub_cate_id != 0 && $best_sell_d_sub_cate_id != "") {
                                                       $pro_details_url_best_sell = SITEURL . "product/" . $pro_cate_slug . "/" . $pro_sub_cate_slug . "/" . $best_sell_d_slug . "/";
                                                       }
                                                  
                                                       if ($best_sell_d_sub_sub_cate_id != 0 && $best_sell_d_sub_sub_cate_id != "") {
                                                       $pro_details_url_best_sell = SITEURL . "product/" . $pro_cate_slug . "/" . $pro_sub_cate_slug . "/" . $pro_sub_sub_cate_slug . "/" . $home_page_pro_slug . "/";
                                                       }
                                             ?>
                                                   <a href="<?= $pro_details_url_best_sell; ?>" style="color:black;">
                                                        <img src="<?= SITEURL . PRODUCT . $best_sell_d['image']; ?>" alt="<?php echo SITETITLE; ?>">
                                                        <div class="product-info">
                                                            <p><?= substr($best_sell_d['name'],0,17)."..."; ?></p>
                                                            <h5><?= $dis_price1; ?></h5>
                                                       </div>
                                                  </a>
                                             
                                                       <?php 
                                                  } 
                                             ?>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
                <div class="col-lg-6 px-0">
                     <div class="product-show-right-image">
                           <img src="assets/img/home/highlight-image.png">
                           <a class="play-btn popup-youtube" href="#video-01"><i class="fa-solid fa-play"></i></a>
                         <div id="video-01" class="video-popup mfp-hide">
                              <video preload="none">
                                   <source src="https://www.zillifurniture.com//assets/video/Claire%20Bedroom%20-%20AlfItalia.mp4" type="video/mp4">
                              </video>
                         </div> <!-- /#video-01 -->
                     </div>
                 </div>
          </div> 
     </div>
     <div class="highlight-product-section-main"> 
          <div class="container">
               <div class="row">
                    <?php $onsale = implode(',',$onsale); 
                    // $onsale_image_r = $db->rpgetData("product", "*", "isDelete=0 AND isDisplayHomePage=1 AND image IS NOT NULL AND id not in (".$onsale.")", "id DESC limit 1",0);
                    $onsale_image_r = $db->rpgetData("product", "id,cate_id,sub_cate_id,sub_sub_cate_id,name,price,sell_price,slug,image,isImage,pro_sub_cat", "isDelete=0 AND isDisplayHomePage=1 AND image IS NOT NULL AND id=618",0);
                    $onsale_image_c = @mysqli_num_rows($onsale_image_r);
                    $onsale_image_d= @mysqli_fetch_array($onsale_image_r);
                    $pro_cate_slug_on_sale = $db->rpgetValue("category", "slug", " id='" . $onsale_image_d['cate_id'] . "' ");
                    $pro_sub_cate_slug_on_sale = $db->rpgetValue("sub_category", "slug", " id='" . $onsale_image_d['cate_id'] . "' ");
                    $pro_sub_sub_cate_slug_on_sale = $db->rpgetValue("sub_sub_category", "slug", " id='" . $onsale_image_d['cate_id'] . "' ");
                    $on_sale_image_path   	= $onsale_image_d['image'];
                    $onsale_price    = $onsale_image_d['sell_price'];
                    
                    if (!empty($on_sale_image_path) && file_exists(PRODUCT . $on_sale_image_path)) {
                         $on_sale_image = SITEURL . PRODUCT . $on_sale_image_path;
                     } else {
                         $on_sale_image = SITEURL . "common/images/no_image.png";
                     }
                    
                    
                     $dis_discount_desc = ($is_onsale_product['discount_desc']) ? "<p>" . $is_onsale_product['discount_desc'] . "</p>" : "";
                 
                     $pro_details_url = SITEURL . "product/" . $pro_cate_slug_on_sale . "/" . $onsale_image_d['slug'] . "/";
                     if ($ $onsale_image_d['sub_cate_id'] != 0 &&  $onsale_image_d['sub_cate_id'] != "") {
                         $pro_details_url = SITEURL . "product/" . $pro_cate_slug_on_sale . "/" . $pro_sub_cate_slug_on_sale . "/" . $onsale_image_d['slug'] . "/";
                     }
                 
                     if ($onsale_image_d['sub_sub_cate_id'] != 0 && $onsale_image_d['sub_sub_cate_id'] != "") {
                         $pro_details_url = SITEURL . "product/" . $pro_cate_slug_on_sale . "/" . $pro_sub_cate_slug_on_sale . "/" . $pro_sub_sub_cate_slug_on_sale . "/" . $onsale_image_d['slug'] . "/";
                     }
                     if ($onsale_price > 0) {
                                    
                         $is_onsale_product = $db->checkIsDiscountProduct($onsale_image_d['id'], $onsale_image_d['cate_id'], $onsale_image_d['sub_cate_id'], $onsale_image_d['sub_sub_cate_id'], $onsale_price);
                         $dis_price = '<a href="'.$pro_details_url.'" class="price" style="color:black;"><b>' . CURR . ($onsale_price - $is_onsale_product['total_discount']) . '</b><del> ' . CURR . $onsale_image_d['price'] . '</del></a>';
                     } else {
                         $is_onsale_product = $db->checkIsDiscountProduct($onsale_image_d['id'], $onsale_image_d['cate_id'], $onsale_image_d['sub_cate_id'], $onsale_image_d['sub_sub_cate_id'], $onsale_image_d['price']);
                         $dis_price = '<a href="'.$pro_details_url.'" class="price" style="color:black;"><b>' . CURR . ($onsale_price - $is_onsale_product['total_discount']) . '</b></a>';
                     }
                     ?>
                    <div class="col-lg-6 px-0">
                         <div class="highlight-product-sec">
                              <img src="<?= $on_sale_image; ?>" alt="<?= SITEURL; ?>">
                         </div>
                    </div>    
                    <div class="offset-lg-1 col-lg-5">
                         
                         <div class="product-content-sec">
                         <a href="<?= $pro_details_url; ?>" style="color:black;">
                              <h2><?= $onsale_image_d['name'];  ?></h2></a>
                              <!-- <a href="#" class="price">$2715.75<del>$3195</del></a> -->
                              <span><?= $dis_price; ?></span>
                         </div>
                         
                    </div> 
               </div>
          </div>
     </div>
</section>

<!-- product section end -->

<!-- Project carousel section start -->

<section class="project-carousel-section">
     <div class="container">
          <div class="project-carousel slick">
               <div class="slick-slide">
                    <!--<img src="assets/img/home/project-carousel-slide.png">-->
                    <img src="assets/new_home/img/home/new_home_cus_blind.png" alt="<?php echo SITETITLE; ?>">
               </div>
               <!-- <div class="slick-slide">
                    <img src="assets/img/home/project-carousel-slide.png">
               </div>
               <div class="slick-slide">
                    <img src="assets/img/home/project-carousel-slide.png">
               </div> -->
          </div>

          <div class="see-project-sec-fix">
               <div class="row">
                     <div class="col-lg-9">
                         <div class="see-left-project-sec">
                              <p>Custom Blinds Projects</p>
                              <h4><?= $hp_sec4_title; ?></h4>
                             
                         </div>
                     </div>
                     <div class="col-lg-3">
                         <a href="<?= SITEURL ?>products/blinds-shades/our-projects/" class="btn btn-see">See Projects</a>
                    </div>
               </div>
          </div>

     </div>
</section>

<!-- Project carousel section end -->


<!-- discount offer section start -->

<section class="discount-offer-section">
     <div class="container">
           <div class="row">
                <div class="col-lg-6">
                     <div class="discount-offer-left-fix">
                           <img src="assets/img/home/custom_blind.jpg" alt="<?php echo SITETITLE; ?>">
                           <div class="discount-offer-left-content">
                               <h2>Custom Blinds</h2>
                               <p>Custom blinds and shades to match your modern contemporary style 
                                   and budget. Decorate with confidence at Zilli Furniture.</p>
                           </div>
                     </div>
                </div>
                <div class="col-lg-6">
                    <div class="discount-offer-right-fix">
                         <!-- <h2>Save Up to <span>30%</span> off</h2> -->
                         <h2><?= $hp_description1; ?></h2>
                         <!-- <h4>On Window Shades</h4>  -->
                         <?php
                              if ($hp_button_link != "" || $hp_button_name != "") {
                                   if ($hp_button_link == "") {
                                        $hp_button_link = "javascript:void(0)";
                                   }
                              ?> 
                              <center>   
                         <div class="col-lg-4" style="background: #B61F1F;color: #ffffff;border-radius: 0;padding: 10px 24px;">
                         <a href="<?= $hp_button_link; ?>" style="color:white"><?= $hp_button_name; ?></a>
                         </div>
                              </center>
                         <?php } ?>
                         <!--<img src="assets/img/home/discount2.png">-->
                          <img src="assets/new_home/img/home/new_home_Window_Shades.png" alt="<?php echo SITETITLE; ?>">
                         
                              
                         
                    </div>
                 </div>
           </div>
     </div>
</section>

<!-- discount offer section end -->

<!-- Shop by Room section Start -->

<section class="shop-room-section">
     <div class="container">
          <div class="section-header mb-5">
               <h2><?= $hp_sec3_title; ?></h2>
               <p><?= $hp_sec3_desc; ?></p>
          </div>
          <div class="row">
               <?php
                         $home_category_r = $db->rpgetData("category", "*", "isDelete=0", "display_order ASC");
                         $home_category_c = @mysqli_num_rows($home_category_r);
                         if ($home_category_c > 0) {
                              while ($home_category_d = @mysqli_fetch_array($home_category_r)) {
                                   $cate_name  = ucwords($home_category_d['name']);
                                   $image_path     = $home_category_d['image'];

                                   if (!empty($image_path) && file_exists(CATEGORY . $image_path)) {
                                        $cate_img_url = SITEURL . CATEGORY . $image_path;
                                   } else {
                                        $cate_img_url = SITEURL . "common/images/no_image.png";
                                   }

                                   $home_sub_cate_c = $db->rpgetTotalRecord("sub_category", "cate_id='" . $home_category_d['id'] . "' AND isDelete=0");

                                   $dis_home_cate_url 		= "javascript:void(0)";
                                   if ($home_sub_cate_c > 0) {
                                        $dis_home_cate_url = SITEURL . "product-category/" . $home_category_d['slug'] . "/";
                                   } else {
                                        $dis_home_cate_url = SITEURL . "products/" . $home_category_d['slug'] . "/";
                                   }
               ?>
                              
                                   <div class="col-lg-4 col-md-6">
                                        <div class="shop-room-box-sec">
                                             <img class="item-img" src="<?= $cate_img_url; ?>" alt="<?php echo SITETITLE; ?>" />
                                             <h4><?php
                                                  if ($cate_name == "Sale") {
                                                       echo str_replace("Sale", "Clearance", $cate_name);
                                                  } else {
                                                       echo $cate_name;
                                                  }
                                                  ?>
                                                  <span><a href="<?= $dis_home_cate_url; ?>"><i class="fa-light fa-arrow-right-long"></i></a></span></h4>
                                        </div>
                                   </div>
                         
                         <?php } } ?>
          </div> 
     </div>
</section>

<!-- Shop by Room section End -->

<!-- Our Brand section start -->

<section class="our-brand-section">
     <div class="container">
          <div class="section-header mb-3">
               <h2><?= $hp_sec5_title; ?></h2>
          </div>

          <div class="brand-carousel slick">
          <?php
			$home_featured_brand_r = $db->rpgetData("featured_brand", "*", "isDelete=0");
			$home_featured_brand_c = @mysqli_num_rows($home_featured_brand_r);
			if ($home_featured_brand_c > 0) 
               {
                    
                    while ($home_featured_brand_d = @mysqli_fetch_array($home_featured_brand_r)) {
                         $brand_name  = ucwords($home_featured_brand_d['name']);
                         $image_path     = $home_featured_brand_d['image'];

                         if (!empty($image_path) && file_exists(FEATURED_BRAND . $image_path)) {
                              $brand_img_url = SITEURL . FEATURED_BRAND . $image_path;
                         } else {
                              $brand_img_url = SITEURL . "common/images/no_image.png";
                         }

                         $brand_pro_url = SITEURL . "brand-product/" . $home_featured_brand_d['slug'] . "/";
			?>
                    <div class="slick-item">
                    <a href="<?= $brand_pro_url; ?>" title="<?= $brand_name; ?>"><img src="<?= $brand_img_url; ?>" alt="<?php echo SITETITLE; ?>" ></a>
                    </div>

               <?php }} ?>
               
          </div>
     </div>
</section>

<!-- Our Brand section end -->

<!-- Newsletter section start -->

<section class="newsletter-section">
     <div class="container-fluid">
          <div class="row">
               <div class="left-chair-image-fix">
                    <img src="assets/img/home/left-chair.png" alt="<?php echo SITETITLE; ?>">
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
</section>

<!-- Newsletter section end -->


    <!-- Footer Area Start -->

    <!-- Footer Area End -->
    <!-- all js here -->
    <?php include('new_include_footer.php'); ?>
    <?php include('new_include_js.php'); ?>
    
    <script>
     $(document).ready(function () {
  initialize_owl($('#owl1'));
  
  let tabs = [
    { target: '#home', owl: '#owl1' },
    { target: '#profile', owl: '#owl2' },
    { target: '#messages', owl: '#owl3' },
//     { target: '#settings', owl: '#owl4' },
  ];

   
});


$(document).ready(function () {
  initialize_owl($('#owl1'));
  
  let tabs = [
    { target: '#home', owl: '#owl1' },
    { target: '#profile', owl: '#owl2' },
    { target: '#messages', owl: '#owl3' },
//     { target: '#settings', owl: '#owl4' },
  ];

  // Setup 'bs.tab' event listeners for each tab
  tabs.forEach((tab) => {
    $(`a[href="${ tab.target }"]`)
      .on('shown.bs.tab', () => initialize_owl($(tab.owl)));
     //  .on('hide.bs.tab', () => destroy_owl($(tab.owl)));
  });    
});

function initialize_owl(el) {
  el.owlCarousel({
    loop: true,
    margin: 15,
    infinite: true,
    autoplay:true,
    autoplayTimeout:1500,
    responsiveClass: true,
    dots: true,
    navText : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
    responsive: {
      0: {
        items: 1,
        nav: true
      },
      600: {
        items: 2,
        nav: true
      },
     //  1000: {
     //    items: 3,
     //    nav: true,
     //  }
    }
  });
}

   </script>
    
    
</body>

</html>