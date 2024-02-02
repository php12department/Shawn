<?php
include('connect.php'); 
$current_page = "Product Details";

$cate_slug          = $db->clean($_REQUEST['cate_slug']);
$sub_cate_slug      = $db->clean($_REQUEST['sub_cate_slug']);
$sub_sub_cate_slug  = $db->clean($_REQUEST['sub_sub_cate_slug']);
$pro_slug           = $db->clean($_REQUEST['pro_slug']);

$cate_id            = "";
$sub_cate_id        = "";
$sub_sub_cate_id    = "";

$ctable_r   = $db->rpgetData("category","*","slug = '".$cate_slug."' AND isDelete=0");
if(@mysqli_num_rows($ctable_r)>0)
{
    $ctable_d           = @mysqli_fetch_array($ctable_r);
    $cate_name          = stripslashes($ctable_d['name']);
    $cate_id            = $ctable_d['id'];
    $dis_banner_title   = $cate_name;

    $pro_details_url = SITEURL."product/".$cate_slug."/".$pro_slug."/";

    if($sub_cate_slug!="")
    {
        $sub_cate_r = $db->rpgetData("sub_category","*","cate_id='".$cate_id."' AND slug='".$sub_cate_slug."' AND isDelete=0");
        $sub_cate_c          = @mysqli_num_rows($sub_cate_r);

        if($sub_cate_c > 0)
        {
            $sub_cate_d         = @mysqli_fetch_array($sub_cate_r);

            $sub_cate_name      = stripslashes($sub_cate_d['name']);
            $sub_cate_id        = $sub_cate_d['id'];

            $ctable_where.= " sub_cate_id='".$sub_cate_id."' AND ";
            $related_ctable_where.= " sub_cate_id='".$sub_cate_id."' AND ";
            $dis_banner_title.= " > ".$sub_cate_name;

            $pro_details_url = SITEURL."product/".$cate_slug."/".$sub_cate_slug."/".$pro_slug."/";

            
            $sub_sub_cate_r = $db->rpgetData("sub_sub_category","*","cate_id='".$cate_id."' AND sub_cate_id='".$sub_cate_id."' AND slug='".$sub_sub_cate_slug."' AND isDelete=0");
            $sub_sub_cate_c          = @mysqli_num_rows($sub_sub_cate_r);

            if($sub_sub_cate_c > 0)
            {
                $sub_sub_cate_d         = @mysqli_fetch_array($sub_sub_cate_r);

                $sub_sub_cate_name      = stripslashes($sub_sub_cate_d['name']);
                $sub_sub_cate_id        = $sub_sub_cate_d['id'];

                $ctable_where.= " sub_sub_cate_id='".$sub_sub_cate_id."' AND ";
                $related_ctable_where.= " sub_sub_cate_id='".$sub_sub_cate_id."' AND ";
                $dis_banner_title.= " > ".$sub_sub_cate_name;

                $pro_details_url = SITEURL."product/".$cate_slug."/".$sub_cate_slug."/".$sub_sub_cate_slug."/".$pro_slug."/";
            }
        }
    }

    $ctable_where.= "cate_id='".$cate_id."' AND slug='".$pro_slug."' AND isDelete=0";
    $pro_ctable_r = $db->rpgetData("product","*",$ctable_where);
    $pro_ctable_c = @mysqli_num_rows($pro_ctable_r);

    if($pro_ctable_c > 0)
    {
        $pro_ctable_d = @mysqli_fetch_array($pro_ctable_r);

        $pro_id                 = $pro_ctable_d['id'];
        $price                  = $pro_ctable_d['price'];
        $sell_price             = $pro_ctable_d['sell_price'];
        $cate_id                = $pro_ctable_d['cate_id'];
        $sub_cate_id            = $pro_ctable_d['sub_cate_id'];
        $sub_sub_cate_id        = $pro_ctable_d['sub_sub_cate_id'];
        $pro_group_id           = $pro_ctable_d['pro_group_id'];
        $image_path             = $pro_ctable_d['image'];
        $isImage                = $pro_ctable_d['isImage'];
        $pro_slug               = stripslashes($pro_ctable_d['slug']);  
        $pro_name               = stripslashes($pro_ctable_d['name']);  
        $pro_decs               = stripslashes($pro_ctable_d['decs']);  
        $variation_slug               = stripslashes($pro_ctable_d['variation_slug']);  
        $pro_feature_dimension  = stripslashes($pro_ctable_d['feature_dimension']);  
        $pro_additional_info    = stripslashes($pro_ctable_d['additional_info']);  
        $pro_cate_slug          = $db->rpgetValue("category","slug"," id='".$cate_id."'");
        $pro_sub_cate_slug      = $db->rpgetValue("sub_category","slug"," id='".$sub_cate_id."'");
        
        $meta_title             = stripslashes($pro_ctable_d['meta_title']);
        $meta_description       = stripslashes($pro_ctable_d['meta_description']);
        $meta_keywords          = stripslashes($pro_ctable_d['meta_keywords']);
        $pro_sub_cat          = stripslashes($pro_ctable_d['pro_sub_cat']);

        
        if(!empty($image_path) && file_exists(PRODUCT.$image_path))
        {
            $pro_url = SITEURL.PRODUCT.$image_path;
        }
        else
        {
            $pro_url = SITEURL."common/images/no_image.png";
        }

        if(!empty($image_path) && file_exists(PRODUCT_THUMB_F.$image_path))
        {
            $pro_thumb_url = SITEURL.PRODUCT_THUMB_F.$image_path;
        }
        else
        {
            $pro_thumb_url = SITEURL."common/images/no_image.png";
        }

        if($pro_ctable_d['status']==1)
        {
            $dis_status     = "In Stock";
        }
        
        if($pro_ctable_d['status']==2)
        {
            $dis_status     = "Out Of Stock";
        } 

        if($pro_ctable_d['status']==3)
        {
            $dis_status     = "Special Order";
        }       

        if($pro_ctable_d['status']==4)
        {
            $dis_status   = "Online Only";
        }
        
        if($pro_ctable_d['status']==5)
        {
            $dis_status     = "Coming Soon";
        }

        if($sell_price > 0)
        {
            $is_discount_product = $db->checkIsDiscountProduct($pro_id,$cate_id,$sub_cate_id,$sub_sub_cate_id,$sell_price);
            $dis_price = '<span class="p-d-price">'.CURR.($sell_price - $is_discount_product['total_discount']).'</span><span class="price-line-through">'.CURR.$price.'</span>';
        }
        else
        {
            $is_discount_product = $db->checkIsDiscountProduct($pro_id,$cate_id,$sub_cate_id,$sub_sub_cate_id,$price);
            $dis_price = '<span>'.CURR.($price - $is_discount_product['total_discount']).'</span>';
        }
        $dis_discount_desc = ($is_discount_product['discount_desc']) ? "<p>".$is_discount_product['discount_desc']."</p>" : "";

        $is_wish_listed = $db->rpgetTotalRecord("wishlist","product_id='".$pro_id."' AND user_id='".$_SESSION[SESS_PRE.'_SESS_USER_ID']."'");

        $dis_wishlist_tooltip = 'Add to Wishlist';
        if($is_wish_listed > 0)
        {
            $dis_wishlist_tooltip = 'Remove from Wishlist';
        }

        $dis_isImage_section = 0;
        if($isImage!=0)
        {
            $dis_isImage_section = 1;
        }

        $alt_isImage = $db->rpgetTotalRecord("alt_image","pid='".$pro_id."' AND isDelete=0 AND (isImage=1 OR isImage=2)");
        if($alt_isImage > 0)
        {
            $dis_isImage_section = 1;
        }
    }
    else
    {
        $db->rplocation(SITEURL);
    }
}
else
{
    $db->rplocation(SITEURL);
}

if(isset($_POST['pro_review']))
{
    $user_id        = $_SESSION[SESS_PRE.'_SESS_USER_ID'];
    $cart_id        = $db->clean($_POST['cart_id']);
    $pro_rating     = $db->clean($_POST['pro_rating']);
    $review_desc    = $db->clean($_POST['review_desc']);

    $dup_where = "user_id = '".$user_id."' AND pid='".$pro_id."' and cart_id='".$cart_id."'";
    $r = $db->rpdupCheck("product_review",$dup_where);
    if($r)
    {
        $_SESSION['MSG'] = "Duplicate_Review";
        $db->rplocation($_SERVER['HTTP_REFERER']);
        die();
    }
    else
    {
        $rows   = array(
                "user_id",
                "cart_id",
                "pid",
                "cate_id",
                "sub_cate_id",
                "sub_sub_cate_id",
                "pro_rating",
                "review_desc",
                "status",
            );
        $values = array(
                $user_id,
                $cart_id,
                $pro_id,
                $cate_id,
                $sub_cate_id,
                $sub_sub_cate_id,
                $pro_rating,
                $review_desc,
                "Y",
            );
        $last_id =  $db->rpinsert("product_review",$values,$rows);

        $_SESSION['MSG'] = "Added_Review";
        $db->rplocation($_SERVER['HTTP_REFERER']);
        die();
    }
}

$total_review = $db->rpgetTotalRecord("product_review"," isDelete = 0 AND status='Y' AND pid='".$pro_id."'");
?>
<!doctype html>
<html class="no-js" lang="en">
<head>

    <?php 
    if($meta_title!="")
    {
        if(strlen($meta_title)>= 45)
        {
            ?>
            <title><?=$meta_title;?></title>
            <?php
        }
        else
        { 
            ?>
           <meta name="title" content="<?=$meta_title;?> | <?php echo SITETITLE; ?>">
            <?php
        }
    }
    else
    {
    ?>
    <title><?=$current_page;?> | <?php echo SITETITLE; ?></title>
    <?php
    }
    ?>

    <meta name="description" content="<?=$meta_description;?>">
    
    <meta name="keywords" content="<?=$meta_keywords;?>">

   
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

    if(!empty($image_path) && file_exists(PRODUCT.$image_path))
    {
        $metatag_image = SITEURL.PRODUCT.$image_path;
        $metatag_image_width = "750";
        $metatag_image_height = "450";
        ?>
        <meta property="og:image" content="<?=$metatag_image?>" />
        <?php
    }
    else
    {
        $metatag_image = SITEURL."common/images/no_image.png";
        $metatag_image_width = "224";
        $metatag_image_height = "224";
        ?>
        <meta property="og:image" content="<?=$metatag_image?>" />
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
    <meta name="twitter:image" content="<?=$metatag_image?>" />
    <!-- end meta tags site details -->
</head>

<body class="position-relative">
    <!-- Header Area Start -->
    <?php include('include_header.php'); ?>
    <!-- Header Area End -->

    <!-- Breadcrumb Area Start -->
    <?php include('include_breadcrumb_area.php'); ?>
    <!-- Breadcrumb Area End -->

    <div class="product-details-area pt-80 pb-75">
        <div class="container">
            <div id="loader" style="" class="catProLoader"></div>
            <div class="row w-100 mx-0">
                <div class="col-lg-8 col-md-7 col-sm-12" id="pro_images">
                    
                </div>
               
                <div class="col-lg-4 col-md-5 col-sm-12" id="pro_details">
                    
                </div>
            </div>
        </div>
        <!-- <div class="container scroll-area content-product-main position-relative"> -->
        <!-- <div class="loading-div0 inner_section_loader"></div> -->
            <!-- <div class="p-d-tab-container">
                <div class="p-tab-btn">
                    <div class="nav" role="tablist">
                        <a class="active" href="#tab1" data-toggle="tab" role="tab" aria-selected="true" aria-controls="tab1">DESCRIPTION</a>
                        
                        <a href="#tab4" data-toggle="tab" role="tab" aria-selected="false" aria-controls="tab4" class="hide feature_and_dimension">FEATURES & DIMENSIONS</a>
                        
                        <a href="#tab2" data-toggle="tab" role="tab" aria-selected="false" aria-controls="tab2" class="hide additional_information">ADDITIONAL INFORMATION</a>
                        
                        <a href="#tab3" data-toggle="tab" role="tab" aria-selected="false" aria-controls="tab3" class="customer_reviews">CUSTOMER REVIEWS</a>
                    </div>
                </div>
                
                <div class="p-d-tab tab-content">
                    <div class="tab-pane active show fade" id="tab1" role="tabpanel">
                        <div class="tab-items">
                            <div class="row m-0">
                                <div class="col-12 col-md-12" id="pro_description">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tab-pane fade" id="tab4" role="tabpanel">
                        <div class="tab-items" id="pro_feature_dimension">
                            
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab2" role="tabpanel">
                        <div class="tab-items" id="pro_additional_info">
                            
                        </div>
                    </div>
                   
                    <div class="tab-pane fade scroll-area p-0" id="tab3" role="tabpanel">
                        <div class="tab-items">
                            <div class="p-review-wrapper">
                                <div id="comment_history"></div>
                
                                <div class="col-12 text-center" id="comment_button" style="display: none;"> 
                                    <button type="button" id="load_more" data-val="0" class="btn btn-warning">View more</button>
                                </div>
                            </div>
                            <?php 
                            if(isset($_SESSION[SESS_PRE.'_SESS_USER_ID']) && $_SESSION[SESS_PRE.'_SESS_USER_ID'] > 0)
                            { 
                                $review_cart_r = $db->rpgetData("cartitems","cart_id","orderstatus = '2' AND uid='".$_SESSION[SESS_PRE.'_SESS_USER_ID']."' AND pid='".$pro_id."' AND cart_id NOT IN (select cart_id from product_review where user_id = '".$_SESSION[SESS_PRE.'_SESS_USER_ID']."' AND pid='".$pro_id."')");

                                $review_cart_c = @mysqli_num_rows($review_cart_r);
                                if($review_cart_c > 0)
                                {
                                    $review_cart_d = @mysqli_fetch_array($review_cart_r);
                                    ?>
                                    <div class="submit-review-wrapper mt-5">
                                        <h3>Add A Review</h3>
                                        <small>Required fields are marked *</small> 
                                        <form action="." method="post" name="proreviewForm" id="proreviewForm" class="rating-form">
                                            <div class="row m-0 mt-3 no-gutters">
                                                <div class="col-md-12">
                                                    <div class="rating-form-box d-flex flex-column">
                                                        <label for="r-summary" class="important pb-3 float-left">Your rating<span class="required pl-2">*</span></label>
                                                        <fieldset class="rating dis_error_pro_rating">
                                                            <input type="radio" id="star1" name="pro_rating" value="1" /><label class = "full" for="star1"></label>
                                                            <input type="radio" id="star2" name="pro_rating" value="2" /><label class = "full" for="star2"></label>
                                                            <input type="radio" id="star3" name="pro_rating" value="3" /><label class = "full" for="star3"></label>
                                                            <input type="radio" id="star4" name="pro_rating" value="4" /><label class = "full" for="star4"></label>
                                                            <input type="radio" id="star5" name="pro_rating" value="5" />
                                                            <label class = "full" for="star5"></label>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="rating-form-box">
                                                        <label for="r-review" class="important">Review<span class="required pl-2">*</span></label>
                                                        <textarea name="review_desc" id="review_desc" style="min-height: 100px;"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" id="cart_id" name="cart_id" value="<?=$review_cart_d['cart_id']?>">
                                            <button type="submit" name="pro_review" id="pro_review">Submit Review</button>
                                        </form>
                                    </div>
                                    <?php 
                                }
                            }
                            else
                            {
                            ?>
                                <div class="submit-review-wrapper mt-5">
                                    <h3><center>Please <a href="<?=SITEURL?>login/">Login</a> To View Reviews</center></h3>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div> -->
        <!-- </div> -->
    </div>

    <!-- Related Products Area Start -->
    <?php
    $related_pro_c = 0;
    if($pro_group_id!=0)
    {
        if($pro_sub_cat!='' && $pro_sub_cat!=null){
            $related_ctable_where1 = "pro_group_id='".$pro_group_id."' AND id!='".$pro_id."' AND isDisplayCategoryPage=1  AND isDelete=0";
            $related_pro_r = $db->rpgetData("product","*",$related_ctable_where1," id DESC");
            $related_pro_c = @mysqli_num_rows($related_pro_r);
        }
        else{
            $related_ctable_where1 = "pro_group_id='".$pro_group_id."' AND id!='".$pro_id."' AND (variation_slug IS NULL OR variation_slug='' )  AND isDelete=0";
            $related_pro_r = $db->rpgetData("product","*",$related_ctable_where1," id DESC");
            $related_pro_c = @mysqli_num_rows($related_pro_r);
        }
      
    }

    /*if($related_pro_c == 0)
    {
        $related_ctable_where.= "cate_id='".$cate_id."' AND id!='".$pro_id."' AND isDelete=0";
        $related_pro_r = $db->rpgetData("product","*",$related_ctable_where," id DESC");
        $related_pro_c = @mysqli_num_rows($related_pro_r);
    }*/

    if($related_pro_c > 0)
    {
    ?>
    <div class="related-product-carouseld-products-area text-center">
        <div class="container">
            <div class="section-title title-style-2">
                <h2><span>Related Products</span></h2>
            </div>
        </div>
        <div class="container">
            <div class="custom-row">
                <div class="related-product-carousel owl-carousel carousel-style-one">
                    <?php 
                    while($related_pro_d = @mysqli_fetch_array($related_pro_r))
                    {
                        $related_pro_id             = $related_pro_d['id'];
                        $related_price              = $related_pro_d['price'];
                        $related_sell_price         = $related_pro_d['sell_price'];
                        $related_cate_id            = $related_pro_d['cate_id'];
                        $related_sub_cate_id        = $related_pro_d['sub_cate_id'];
                        $related_sub_sub_cate_id    = $related_pro_d['sub_sub_cate_id'];
                        $related_image_path         = $related_pro_d['image'];
                        $related_pro_slug           = stripslashes($related_pro_d['slug']);  
                        $related_pro_name           = stripslashes($related_pro_d['name']);  
                        $related_pro_feature_dimension  = stripslashes($related_pro_d['feature_dimension']);

                        $related_pro_cate_slug      = $db->rpgetValue("category","slug"," id='".$related_cate_id."'");
                        $related_pro_sub_cate_slug  = $db->rpgetValue("sub_category","slug"," id='".$related_sub_cate_id."'");
                        $related_pro_sub_sub_cate_slug  = $db->rpgetValue("sub_sub_category","slug"," id='".$related_sub_sub_cate_id."'");

                        if(!empty($related_image_path) && file_exists(PRODUCT.$related_image_path))
                        {
                            $related_pro_url = SITEURL.PRODUCT.$related_image_path;
                        }
                        else
                        {
                            $related_pro_url = SITEURL."common/images/no_image.png";
                        }

                        if($related_sell_price > 0)
                        {
                            $is_discount_product = $db->checkIsDiscountProduct($pro_id,$cate_id,$sub_cate_id,$sub_sub_cate_id,$related_sell_price);
                            $related_dis_price = CURR.number_format(($related_sell_price - $is_discount_product['total_discount']));
                        }
                        else
                        {
                            $is_discount_product = $db->checkIsDiscountProduct($pro_id,$cate_id,$sub_cate_id,$sub_sub_cate_id,$related_price);
                            $related_dis_price = CURR.number_format(($related_price - $is_discount_product['total_discount']));
                        }
                        $dis_discount_desc = ($is_discount_product['discount_desc']) ? "<p>".$is_discount_product['discount_desc']."</p>" : "";

                        $related_pro_details_url = SITEURL."product/".$related_pro_cate_slug."/".$related_pro_slug."/";
                        if($related_sub_cate_id!=0 && $related_sub_cate_id!="")
                        {
                            $related_pro_details_url = SITEURL."product/".$related_pro_cate_slug."/".$related_pro_sub_cate_slug."/".$related_pro_slug."/";
                        }

                        if($related_sub_sub_cate_id!=0 && $related_sub_sub_cate_id!="")
                        {
                            $related_pro_details_url = SITEURL."product/".$related_pro_cate_slug."/".$related_pro_sub_cate_slug."/".$related_pro_sub_sub_cate_slug."/".$related_pro_slug."/";
                        }

                        $related_wishlist_tooltip = 'Add to Wishlist';
                        $related_wishlist_icon = '<i class="fa fa-heart-o" aria-hidden="true"></i>';
                        if($is_wish_listed > 0)
                        {
                            $related_wishlist_tooltip = 'Remove from Wishlist';
                            $related_wishlist_icon = '<i class="fa fa-heart" aria-hidden="true"></i>';
                        }
                        ?>
                        <div class="custom-col">
                            <div class="product-item">
                                <div class="product-image-hover">
                                    <a href="<?=$related_pro_details_url;?>">
                                        <img class="primary-image" src="<?= $related_pro_url;?>" alt="<?php echo SITETITLE; ?>">
                                        <!-- <img class="hover-image" src="<?= SITEURL?>assets/img/product/2.jpg" alt=""> -->
                                        <?php echo $db->proBadge($related_pro_d['isProduct']);?>
                                    </a>
                                    <div class="product-hover">
                                        <a href="javascript:;" tooltip="Add to Cart"><i class="icon-basket" title="" data-placement="top" id="addtocart" data-id="<?php echo $related_pro_id; ?>" data-original-title="Add to cart"></i></a>
                                        <a href="javascript:void(0)" class="pro_wishlist" tooltip="<?=$related_wishlist_tooltip;?>" data-proid="<?php echo $related_pro_id;?>">
                                            <?=$related_wishlist_icon;?>
                                        </a>
                                        <!-- <a href="javscript:void(0)" class="last" tooltip="Compare"><i class="icon icon-Files"></i></a> -->
                                    </div>
                                </div>
                                <div class="product-text">
                                    <?php 
                                    echo $db->get_single_rating($related_pro_id);
                                    ?>
                                    <h4><a href="<?=$related_pro_details_url;?>"><?php echo $db->rplimitChar($related_pro_name,30,""); ?></a></h4>
                                    <?=$dis_discount_desc;?>
                                    <p class="pro-dim"><?=nl2br($related_pro_feature_dimension);?></p>
                                    <!--<p class="pro-dim"><?=strip_tags(nl2br($related_pro_feature_dimension));?></p>-->
                                    <div class="product-price"><span><?=$related_dis_price;?></span></div>
                                </div>
                            </div>
                        </div>
                        <?php 
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php 
    }
    ?>
    <!-- Related Products Area End -->
     <div class="modal product-zoom-modal fade" id="zoomImage" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered opacity-animate3">
            <div class="modal-content">
                <div class="modal-body" id ="setimage">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <img id="" src="" width="410px" height="410px" class="images_dynamic" alt="<?php echo SITETITLE; ?>">
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
        
        
        function image_Fun(src,id) { 
            /*alert(id);
            alert(src);*/
            $('.images_dynamic').prop('src', "");
            $('.images_dynamic').prop('id', "");
            $('.images_dynamic').prop('src', src);
            $('.images_dynamic').prop('id', id);
            // $("#setimage").append('<img id="'+id+'" src="'+src+'" width="410px" height="410px" class="images_dynamic">');
        } 

        function product_details(pid){          
            $.ajax({
                type: "POST",
                cache: false,
                url: "<?php echo SITEURL; ?>ajax_get_product_details.php",
                data: "pid="+pid,
                success: function(html) 
                {
                    if (html!="") 
                    {
                        $("#pro_details").html(html);
                        getDescription(pid);
                        view_comment(0,pid,"1");
                    }
                    $(".loading-div1").hide();
                }
            });
        }

        function getDescription(pid){
            // $(".loading-div0").show();
            $.ajax({
                type: "POST",
                cache: false,
                url: "<?php echo SITEURL; ?>ajax_get_product_description.php",
                data: "pid="+pid,
                dataType: 'json',
                success: function(html) 
                {
                    // $(".loading-div0").hide();
                    if (html['msg']=="success") 
                    {
                        var decs = atob(html['decs']);
                        $("#pro_description").html(decs.replace("Â®", "®"));
                        if (html['feature_dimension']!="") {
                            $("#pro_feature_dimension").html(atob(html['feature_dimension']));
                            $(".feature_and_dimension").removeClass('hide');
                        }
                        
                        if(html['additional_info']!=""){
                            var additional_info = atob(html['additional_info']);
                            $("#pro_additional_info").html(additional_info.replace("Â®", "®"));
                            $(".additional_information").removeClass('hide');
                        }
                        $(document).attr("title", atob(html['meta_title']));
                        $("meta").each(function() {
                            // console.log($(this).attr("name"));
                            if($(this).attr("name")=="description") {
                                $(this).attr("content" , atob(html['meta_description']));
                            };
                            if($(this).attr("name")=="title") {
                                $(this).attr("content" , atob(html['meta_title']));
                            };
                            if($(this).attr("name")=="keywords") {
                                $(this).attr("content" , atob(html['meta_keywords']));
                            };
                        });
                    }
                }
            });
        }

        $(document).ready(function(){
            product_details('<?php echo $pro_id; ?>');
            <?php 
            if(isset($_SESSION[SESS_PRE.'_SESS_USER_ID']) && $_SESSION[SESS_PRE.'_SESS_USER_ID'] > 0)
            { 
            ?>
            // view_comment(0);
            <?php 
            }
            ?>
            $("#load_more").on("click",function(e){
                e.preventDefault();
                var page = $(this).attr('data-val');
                var pro_id  = $("#product_id").val();
                view_comment(page,pro_id,"0");
            });
        });

        function view_comment(page,pro_id,flag)
        {
            $.ajax({
                type: "POST",
                cache: false,
                url: "<?php echo SITEURL; ?>ajax_get_product_comments.php",
                data: "pro_id="+pro_id+"&page="+page,
                dataType: 'json',
                success: function(result) 
                {
                    if(result['msg']=="Something_Wrong")
                    {
                        var dis_html = "<h4 style=' margin: 10px 0;   text-align: center;    font-weight: 100;'>You can give your review only after purchase of this product.</h4>"
                        $("#comment_button").hide();
                        if (flag==0) {
                            $('#comment_history').append(dis_html); 
                        }else{
                            $('#comment_history').html(dis_html); 
                            $('#load_more').attr('data-val' , '0');
                        }
                        
                    }
                    else if(result['msg']=="")
                    {
                        $("#comment_button").hide();
                    }
                    else if(result!=null && result!='')
                    {
                        var dis_html= "";
                        var total_count     = result[0]['tot_count'];
                        for (i = 0; i < result.length; ++i) 
                        {
                            var nm          = result[i].nm;
                            var dt          = result[i].dt;
                            var msg         = result[i].msg;
                            var rating      = result[i].rating;
                            var dis_img     = "<?php echo SITEURL.'common/images/no_user.png'?>";

                            dis_html+= '<div class="media border-media"><img class="mr-3" src="'+dis_img+'" class="img-fluid" alt=""><div class="media-body"><h5 class="mt-0">'+nm+' – <small>'+dt+'</small></h5>'+msg+'<div class="rating-number">'+rating+'</div></div></div>';
                        }

                        // $('#comment_history').append(dis_html);
                        if (flag==0) {
                            $('#comment_history').append(dis_html); 
                        }else{
                            $('#comment_history').html(dis_html); 
                            $('#load_more').attr('data-val' , '0');
                        }
                        $("#comment_button").show();
                        var new_count = parseInt($('#load_more').attr('data-val')) + parseInt(1);
                        $('#load_more').attr('data-val',new_count);

                        var displayed_record = parseInt(new_count) * 5;

                        if(total_count <= displayed_record)
                        {
                            $('#load_more').hide();
                        }
                    }
                    else
                    {
                        dis_html = '';
                    }
         
                    
                }
            });

            var curr_pro_url = $("#product_url").val();

            if (curr_pro_url!="" || curr_pro_url!=undefined || curr_pro_url!=null) 
            {
                console.log(curr_pro_url);
                window.history.pushState("Details", "Title",curr_pro_url);
            }
        }

        $(function(){
         $("#proreviewForm").validate({
            ignore : [],
            rules: {
               pro_rating:{required : true},
               review_desc:{required : true}
            },
            messages: {
               pro_rating:{required:"Rating is required."},
               review_desc:{required:"Review is required."}
            }, 
             errorPlacement: function (error, element) 
             {
                if (element.attr('name') == 'pro_rating')
                {
                   error.insertAfter(".dis_error_pro_rating");
                }
                else 
                {
                   error.insertAfter(element);
                }
             }
         }); 
    });

    $('.right-and-left-pro').change(function(){
        if($(this).is(":checked")) 
        {
            $(this).parent().addClass('bblack').siblings().removeClass('bblack');
            product_slider_img(); 
        }
    });
    $(document).on("change","#variation",function() {
        var pslug  = $(this).val();
        console.log(pslug);
        $(".loading-div1").show();
        if (pslug!="") {
            $.ajax({
                type: "POST",
                cache: false,
                url: "<?php echo SITEURL; ?>ajax_get_variation.php",
                data: "pid=<?php echo $pro_id; ?>&pro_group_id=<?php echo $pro_group_id; ?>&pro_sub_cat=<?php echo $pro_sub_cat; ?>&pro_cate_id=<?php echo $cate_id; ?>&pro_sub_cat_id=<?php echo $sub_cate_id; ?>&variation_slug="+pslug,
                dataType: 'json',
                success: function(result) 
                {
                    $(".loading-div1").hide();
                    if(result['msg']=="redirect"){
                        // location.href =result['content'];
                        product_details(result['pid']);
                        product_slider_img(result['pid']);
                    }else if(result['msg']=="dropdown_added"){
                        var product_id = $('#sub-variation-div').find(':selected').data('id');
                        // product_details(product_id);
                        $('#sub-variation-div').html(result['content']);
                    }else{
                        setTimeout(function(){
                            $.notify({message: 'Something went worng.'},{ type: 'danger'});
                        },1000);
                    }
                }
            });
        } 
    });
    $(document).on("change","#sub-variation-div",function() {
        var product_id  = $(this).data('id');
        var product_id = $('#sub-variation-div').find(':selected').data('id');
        // console.log(product_id);
         
        if (product_id!="" && product_id!="undefined" && product_id!=undefined) {
            $(".loading-div1").show();
            product_details(product_id);
        } 
    });
    function pcs_reset_selection()
    {
        $(".slider_image_type_label").html('SELECT');
        $('.bblack').removeClass('bblack');
        $("input[name='slider_image_type']").prop('checked', false);
        product_slider_img();
    }

    product_slider_img();
    function product_slider_img(pid=0)
    {
        var slider_image_type = $("input[name='slider_image_type']:checked").val();
        if(slider_image_type == 1)
        {
            $(".slider_image_type_label").html('Left Chaise <a href="javascript:void(0);" onclick="pcs_reset_selection();">[<small>Reset Configuration</small>]</a>');
        }
        else if(slider_image_type == 2)
        {
            $(".slider_image_type_label").html('Right Chaise <a href="javascript:void(0);" onclick="pcs_reset_selection();">[<small>Reset Configuration</small>]</a>');
        }
        if(pid==0){
            pid=<?=$pro_id;?>
        }

        $.ajax({
            data: 'ajax=true&action=pro_images&pro_id='+pid+'&slider_image_type='+slider_image_type,
            url: SITEURL+'ajax_get_product_slider.php',
            type:'POST',
            beforeSend: function() {
                $('#loader').html('<img src="<?php echo SITEURL; ?>common/images/loader.svg" alt="<?php echo SITETITLE; ?>">').fadeIn(500);
            },
            success:function(data)
            {
                console.log(data);

                $("#pro_images").html(data);
                
                $('.product-thumbnail-slider').slick({
                    autoplay: false,
                    infinite: true,
                    centerPadding: '0px',
                    focusOnSelect: true,
                    slidesToShow: 5,
                    slidesToScroll: 1,
                    asNavFor: '.product-image-slider',
                    arrows: false,
                });
                $('.product-image-slider').slick({
                    prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
                    nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
                    autoplay: false,
                    infinite: true,
                    slidesToShow: 1,
                    asNavFor: '.product-thumbnail-slider',
                });

                $('#loader').fadeOut();
                
            }
        });
    }
    </script>
</body>

</html>