<?php
include('connect.php'); 

$cate_slug      = $db->clean($_REQUEST['cate_slug']);
$cate_id        = "";
$sub_cate_id    = "";

$ctable_r   = $db->rpgetData("category","*","slug = '".$cate_slug."' AND isDelete=0");
if(@mysqli_num_rows($ctable_r)>0)
{
    $ctable_d           = @mysqli_fetch_array($ctable_r);
    $cate_name          = stripslashes($ctable_d['name']);
    $cate_id            = $ctable_d['id'];
    $dis_banner_title   = ucwords($cate_name);

    $meta_title        = stripslashes($ctable_d['meta_title']);
    $meta_description  = stripslashes($ctable_d['meta_description']);
    $meta_keywords     = stripslashes($ctable_d['meta_keywords']);
    
    $isCategory_blinds      = stripslashes($ctable_d['isCategory_blinds']);
    $section1title			= stripslashes($ctable_d['section1title']);
    $section1_description	= stripslashes($ctable_d['section1_description']);
    $section1_pnumber   	= stripslashes($ctable_d['section1_pnumber']);
    $section2title			= stripslashes($ctable_d['section2title']);
    $section2_description	= stripslashes($ctable_d['section2_description']);
    $pnumber				= stripslashes($ctable_d['pnumber']);
    $section3title			= stripslashes($ctable_d['section3title']);
    $section3_description	= stripslashes($ctable_d['section3_description']);
    $section4title			= stripslashes($ctable_d['section4title']);
    $section4_description	= stripslashes($ctable_d['section4_description']);
    $section4_description2	= stripslashes($ctable_d['section4_description2']);
    $section5title			= stripslashes($ctable_d['section5title']);
    $section5_description	= stripslashes($ctable_d['section5_description']);
    $section5_description2	= stripslashes($ctable_d['section5_description2']);
    
    $rating_no	        = stripslashes($ctable_d['rating_no']);
    $from_review	    = stripslashes($ctable_d['from_review']);
    $revie_description	= stripslashes($ctable_d['revie_description']);
    $user_name	        = stripslashes($ctable_d['user_name']);
    $rating_no2	        = stripslashes($ctable_d['rating_no2']);
    $from_review2   	= stripslashes($ctable_d['from_review2']);
    $revie_description2	= stripslashes($ctable_d['revie_description2']);
    $user_name2	        = stripslashes($ctable_d['user_name2']);
}
else
{
      $db->rplocation(SITEURL);
}
$current_page = "Modern ".$dis_banner_title." Furniture";
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
    $metatag_sub_cate_r = $db->rpgetData("sub_category","*","cate_id='".$cate_id."' AND isDelete=0");
    $metatag_sub_cate_c = @mysqli_num_rows($metatag_sub_cate_r);
    if($metatag_sub_cate_c > 0)
    {
      while($metatag_sub_cate_d     = @mysqli_fetch_array($metatag_sub_cate_r))
      {
        $metatag_image_path     = $metatag_sub_cate_d['image'];
        if(!empty($metatag_image_path) && file_exists(SUB_CATEGORY.$metatag_image_path))
        {
            $metatag_image_preview_img_url = SITEURL.SUB_CATEGORY.$metatag_image_path;
        }
        else
        {
            $metatag_image_preview_img_url = SITEURL."common/images/no_image.png";
        }
      }
    }
    if($metatag_image_preview_img_url)
    {
        $metatag_image = $metatag_image_preview_img_url;
        $metatag_image_width = "370";
        $metatag_image_height = "242";
        ?>
        <meta property="og:image" content="<?=$metatag_image?>" />
        <?php
    }
    else
    {
        $metatag_image = SITEURL."common/images/logo.png";
        $metatag_image_width = "1282";
        $metatag_image_height = "676";
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

<body>
    <!-- Header Area Start -->
    <?php include('include_header.php'); ?>
    <!-- Header Area End -->

    <!-- Breadcrumb Area Start -->
    <?php include('include_breadcrumb_area.php'); ?>
    <!-- Breadcrumb Area End -->
    
    <section class="collection">
        <div class="container">
            <?php
												
			if($isCategory_blinds=="1")
			{
			?>
            <div class="row">
                <div class="col-12 mb-5">
                    <div class="category-header">
                        <h2 class="mb-3 pb-2"><?php echo $section1title; ?></h2>
                        <p class="fs-15"><?php echo $section1_description; ?> <a href="tel:<?= $pnumber;?>" class="red-text"><?php echo $section1_pnumber; ?>.</a></p>
                    </div>
                </div>
            </div>
            
            <?php } ?>
            
            <div class="row justify-content-center">
              <?php 
              $sub_cate_r = $db->rpgetData("sub_category","*","cate_id='".$cate_id."' AND isDelete=0");
              $sub_cate_c = @mysqli_num_rows($sub_cate_r);
              if($sub_cate_c > 0)
              {
                $count = 0;
                while($sub_cate_d     = @mysqli_fetch_array($sub_cate_r))
                {
                  $count++;
                  $sub_cate_name      = stripslashes($sub_cate_d['name']);
                  $sub_cate_slug      = $sub_cate_d['slug'];
                  $image_path     = $sub_cate_d['image'];

                  $dis_sub_menu_url = SITEURL."products/".$cate_slug."/".$sub_cate_slug."/";

                  if(!empty($image_path) && file_exists(SUB_CATEGORY.$image_path))
                  {
                      $preview_img_url = SITEURL.SUB_CATEGORY.$image_path;
                  }
                  else
                  {
                      $preview_img_url = SITEURL."common/images/no_image.png";
                  }
                  ?>
                  <div class="col-12 col-sm-6 col-lg-4 mb-5">
                    <div class="cat-pro-list">
                      <div class="collection-inner"  data-inview="left">
                        <a href="<?=$dis_sub_menu_url;?>">
                          <img src="<?=$preview_img_url;?>" alt="<?php echo SITETITLE; ?>">
                          <div class="overlay ov-<?=$count;?>">
                              <h2><?=$sub_cate_name;?></h2>
                          </div>
                        </a>
                      </div>
                    </div>
                  </div>
                  <?php
                  if($count == 6)
                  {
                    $count = 0;
                  }
                }
              }
              else
              {
              ?>
              <div class="col-md-12 mb-5">
                  <h3 class="text-center">No category details found.</h3>
              </div>
              <?php  
              }
              ?>
              <!-- <div class="col-md-4 mb-5">
                  <div class="collection-inner">
                      <img src="<?=SITEURL?>assets/img/product/mo-2.jpg" alt="">
                      <div class="overlay ov-1">
                          <h2>Living</h2>
                      </div>
                  </div>
              </div>
              <div class="col-md-4 mb-5">
                  <div class="collection-inner">
                      <img src="<?=SITEURL?>assets/img/banner/new2.jpg" alt="">
                      <div class="overlay ov-2">
                          <h2>Dining</h2>
                      </div>
                  </div>
              </div>
              <div class="col-md-4 mb-5">
                  <div class="collection-inner">
                      <img src="<?=SITEURL?>assets/img/banner/bed.jpg" alt="">
                      <div class="overlay ov-3">
                          <h2>Bedroom</h2>
                      </div>
                  </div>
              </div>
              <div class="col-md-4 mb-5">
                  <div class="collection-inner">
                      <img src="<?=SITEURL?>assets/img/product/office.jpg" alt="">
                      <div class="overlay ov-4">
                          <h2>Office</h2>
                      </div>
                  </div>
              </div>
              <div class="col-md-4 mb-5">
                  <div class="collection-inner">
                      <img src="<?=SITEURL?>assets/img/product/light.jpg" alt="">
                      <div class="overlay ov-5">
                          <h2>lighting</h2>
                      </div>
                  </div>
              </div>
              <div class="col-md-4 mb-5">
                  <div class="collection-inner">
                      <img src="<?=SITEURL?>assets/img/product/decor.png" alt="">
                      <div class="overlay ov-6">
                          <h2>home decor</h2>
                      </div>
                  </div>
              </div> -->
            </div>
            
            <?php
												
			if($isCategory_blinds=="1")
			{
			?>
            <div class="row">
                <div class="col-12 mb-5">
                    <div class="category-body row d-flex align-items-center">
                        <div class="col-12 col-md-6 col-left-s">
                            <h2><?php echo $section2title; ?></h2>
                            <p class="fs-15 pt-2"><?php echo $section2_description; ?></p>
                        </div>
                        <div class="col-12 col-md-6">
                            <h2 class="red-text"><a href="tel:<?= $pnumber;?>"><?php echo $pnumber; ?></a></h2>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-12 mb-5">
                    <div class="category-header">
                        <h3 class="mb-3 pb-2"><?php echo $section3title; ?></h3>
                        <p class="fs-15"><?php echo $section3_description; ?></p>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-12 col-sm-6 col-lg-6 mb-5">
                    <div class="col-side">
                        <h3 class="mb-3 pb-2"><?php echo $section4title; ?></h3>
                        <p class="fs-15"><?php echo $section4_description; ?></p>
                        <p class="mb-0 fs-15"><?php echo $section4_description2; ?></p>
                    </div>
                </div>
                
                <div class="col-12 col-sm-6 col-lg-6 mb-5">
                     <div class="col-side">
                        <h3 class="mb-3 pb-2"><?php echo $section5title; ?></h3>
                        <p class="fs-15"><?php echo $section5_description; ?></p>
                        <p class="mb-0 fs-15"><?php echo $section5_description2; ?></p>
                    </div>
                </div>
            </div>
            
            
            <div class="testie-row">
                <div class="row m-0">
                    <div class="col-12 col-sm-6 col-lg-6">
                        <div class="col-testie">
                            <p>
                                <!--<i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>-->
                                
                                <?php 
                                    
                                    for($i=1;$i<=$rating_no;$i++)
                                    {
                                        ?>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <?php
                                    }
                                ?>
                            </p>
                            <p><?php echo $from_review; ?></p>
                            <p><?php echo $revie_description; ?></p>
                            <p><?php echo $user_name; ?></p>
                        </div>
                    </div>
                    
                    <div class="col-12 col-sm-6 col-lg-6">
                         <div class="col-testie">
                             <p>
                                <!--<i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>-->
                                
                                <?php 
                                    
                                    for($i=1;$i<=$rating_no2;$i++)
                                    {
                                        ?>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <?php
                                    }
                                ?>
                            </p>
                            <p><?php echo $from_review2; ?></p>
                            <p><?php echo $revie_description2; ?></p>
                            <p><?php echo $user_name2; ?></p>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php } ?>
            
        </div>
  </section>
    <!-- Footer Area Start -->
  
	<?php include('include_footer.php'); ?>
   
	 <?php
       include('include_js.php'); 
	?>
   
</body>

</html>