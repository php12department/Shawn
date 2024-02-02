<?php
include('connect.php'); 
$current_page = "Financing";
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <title><?=$current_page;?> | <?php echo SITETITLE; ?></title>
    <?php include('include_css.php'); ?>
    <meta name="robots" content="follow, index, max-snippet:-1, max-image-preview:large"/>
    <!-- meta tags site details -->
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Financing - Zilli Furniture" />
    <meta property="og:description" content="Want to buy some new furniture for your home or office but thinking about your wallet? Don’t worry Zilli Furniture is giving you financing solutions so order now." />
    <meta property="og:url" content="<?=$actual_link;?>" />
    <meta property="og:site_name" content="<?php echo SITETITLE; ?>" />
    <meta property="og:image" content="<?=SITEURL?>common/images/logo.png" />
    <meta property="og:image:secure_url" content="<?= SITEURL?>common/images/logo.png" />
    <meta property="og:image:width" content="1282" />
    <meta property="og:image:height" content="676" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:description" content="Want to buy some new furniture for your home or office but thinking about your wallet? Don’t worry Zilli Furniture is giving you financing solutions so order now." />
    <meta name="twitter:title" content="Financing - Zilli Furniture" />
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
                    <h1>Financing</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- financing Information section -->
    <div class="financing-info-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-9 text-center">
                    <img src="<?= SITEURL?>assets/img/financing.jpg" alt="financing-logo" class="mb-3 text-center">
                    <p>Easy and Convenient way to pay for your purchases</p>
                    <p class="text-red">WELLS FARGO IN-STORE ONLY</p>
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