<?php
include('connect.php'); 
$current_page = "Page not found";

$page_r = $db->rpgetdata("page_no_found","*","","",0);

$page_d         = @mysqli_fetch_array($page_r);

$image          = $page_d['image'];
if(!empty($image) && file_exists(PAGENOTFOUND.$image))
{
    $image1 = SITEURL.PAGENOTFOUND.$image;
}
else
{
    $image1 = SITEURL."assets/img/pg.png";
}
?>

<!doctype html>
<html class="no-js" lang="en">

<head>
     <title><?=$current_page;?> | <?php echo SITETITLE; ?></title>
    <?php include('include_css.php'); ?>
    <meta name="robots" content="follow, index, max-snippet:-1, max-image-preview:large"/>
</head>

<body>
    <!-- Header Area Start -->
    <?php include('include_header.php'); ?>
    <!-- Header Area End -->
    <?php include('include_breadcrumb_area.php'); ?>
<!-- Breadcrumb Area End -->
<div class="page-not-found-section" style="background-image: url('<?php echo $image1; ?>');">
<!-- <div class="page-not-found">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-6 border-col">
                <div class="not-found-content">
                    <h1>404</h1>
                    <p>Oops...Looks like this page doesn't exist</p>
                    <div class="my-3 text-center">
                        <a href="<?= SITEURL?>store-details/" class="btn-black  text-uppercase mt-0">Go Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->
</div>
<div style="background-color: #f7f7f7;"> 
    <div class="row justify-content-center text-center">
        <div class="col-8">
                <a href="<?php echo SITEURL; ?>" style="font-size: 40px; color: #969696;text-decoration: underline;">Go Back</a>
        </div>
    </div>
</div>

    <!-- Footer Area Start -->
    <?php include('include_footer.php'); ?>
    <!-- Footer Area End -->

    <!-- all js here -->
    <?php include('include_js.php'); ?>
</body>

</html>