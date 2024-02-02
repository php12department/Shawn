<?php
include('connect.php'); 

if($_REQUEST['page_slug'] !="") 
{
    $page_r = $db->rpgetdata("static_pages","*","page_slug='".$_REQUEST['page_slug']."' AND isDelete=0","",0);
    $page_c = @mysqli_num_rows($page_r);

    if($page_c == 0)
    {
       $db->rplocation(SITEURL); 
    }
}
else
{
    $db->rplocation(SITEURL);
}

$page_d         = @mysqli_fetch_array($page_r);

$pid            = stripslashes($page_d['id']);
$page_name      = stripslashes($page_d['page_name']); 
$description    = $page_d['description'];

$meta_title        = stripslashes($page_d['meta_title']);
$meta_description  = stripslashes($page_d['meta_description']);
$meta_keywords     = stripslashes($page_d['meta_keywords']);

$current_page = $page_name;
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
    
    <div class="financing-banner">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-md-9">
                    <h3 class="custom-orders-title"><?php echo ucfirst($page_name); ?></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- financing Information section -->
    <div class="financing-info-section">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-md-9">
                    <?php echo $description; ?>
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
        
    </script>
</body>

</html>