<?php
include('connect.php'); 
$current_page = "About Us";

$page_r = $db->rpgetdata("aboutus","*","isDelete=0","",0);

$page_d         = @mysqli_fetch_array($page_r);

$pid             = stripslashes($page_d['id']);
$title1          = stripslashes($page_d['title1']); 
$title2          = stripslashes($page_d['title2']); 
$title3          = stripslashes($page_d['title3']); 
$description1    = $page_d['description1'];
$description2    = $page_d['description2'];
$description3    = $page_d['description3'];
$image_path1     = $page_d['image_path1'];
$image_path2     = $page_d['image_path2'];
$image_path3     = $page_d['image_path3'];

if(!empty($image_path1) && file_exists(ABOUTUS.$image_path1))
{
    $image1 = SITEURL.ABOUTUS.$image_path1;
}
else
{
    $image1 = SITEURL."common/images/no_image.png";
}

if(!empty($image_path2) && file_exists(ABOUTUS.$image_path2))
{
    $image2 = SITEURL.ABOUTUS.$image_path2;
}
else
{
    $image2 = SITEURL."common/images/no_image.png";
}

if(!empty($image_path3) && file_exists(ABOUTUS.$image_path3))
{
    $image3 = SITEURL.ABOUTUS.$image_path3;
}
else
{
    $image3 = SITEURL."aboutus/images/no_image.png";
}

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
    <?php

    if(!empty($image_path1) && file_exists(ABOUTUS.$image_path1))
    {
        $meta_image1 = SITEURL.ABOUTUS.$image_path1;
   
        $metatag_image_width = "570";
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
    
    <div class="about-us-section">
        <div class="container">
            <div class="row new-row mx-0 d-flex flex-column flex-lg-row">
                <div class="col-12 col-lg-6 px-0 px-lg-2 pb-4 pb-lg-0">
                    <div class="about-image">
                        <img src="<?php echo $image1; ?>" alt="<?php echo SITETITLE; ?>">
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <h3><?php echo $title1; ?></h3>
                    <?php echo $description1; ?>
                </div>
            </div>
            <div class="row new-row mx-0 d-flex flex-column-reverse flex-lg-row">
                <!-- <div class="col-10 no-justify text-center mb-4">
                    <h1>Key Facts</h1>
                    <p>Zilli Furniture’s extensive product line offers selections that can accommodate a variety of styles and budgets. From high-end homes and commercial projects to typical homes, condominiums and apartments, we offer a selection for even the most discerning client while still keeping within their budget. Our talented staff can assist you in all aspects of decorating – from layout to delivery. In addition, we always strive to find you a perfect match and follow-up with great delivery and support after your purchase.</p>
                    
                </div> -->
                <div class="col-12 col-lg-6">
                    <h3><?php echo $title2; ?></h3>
                    <?php echo $description2; ?>
                </div>
                <div class="col-12 col-lg-6 px-0 px-lg-2 pb-4 pb-lg-0">
                    <div class="about-image">
                        <img src="<?php echo $image2; ?>" alt="<?php echo SITETITLE; ?>">
                    </div>
                </div>
                
            </div>
            <div class="row new-row mx-0 d-flex flex-column flex-lg-row">
                <div class="col-12 col-lg-6 px-0 px-lg-2 pb-4 pb-lg-0">
                    <div class="about-image">
                        <img src="<?php echo $image3; ?>" alt="<?php echo SITETITLE; ?>">
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <h3><?php echo $title3; ?></h3>
                    <?php echo $description3; ?>
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
    <script type="text/javascript">
        
    </script>
</body>

</html>