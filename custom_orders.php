<?php
include('connect.php'); 
$current_page = "Custom Orders";
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

    <!-- Breadcrumb Area Start -->
    <?php include('include_breadcrumb_area.php'); ?>
    <!-- Breadcrumb Area End -->
    
    <div class="shipping-banner">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-md-9">
                    <h1>Custom Orders</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Shipping Information section -->
    <div class="shipping-info-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-9">
                    <div class="row justify-content-center">
                        <div class="col-md-12 mb-5">
                            <h3>Furniture Custom Orders</h3>
                            <div class="sub-cat">
                                <h6>Customize Your Color</h6>
                                <p>Love our products, but want a different color of leather? Our Custom Orders are just for you! Zilli Furniture can provide you with customized choices on many of our leather sofas, sectionals, chairs and beds. Our designers will be happy to work with you to create the contemporary room that is your very own.</p>
                            </div>

                            <div class="sub-cat">
                                <h6>How It Works</h6>
                                <p>Simply contact Zilli Furniture at<span class="text-red"> (469) 543-0506 </span>and speak with one of our Design Consultants. We will be happy to send pictures or samples of leather swatches to create the beautiful sectionals, sofas and beds that will give your home that one of a kind look. Once your order is placed, it takes between 12 and 22 weeks for us to receive it. We then ship it to you according to your shipping choice. Your design consultant will give you a more specific lead time at time of order.</p>
                            </div>

                            <div class="sub-cat">
                                <h6>More Information</h6>
                                <p>For more information on pricing and availability, give us a call at <span class="text-red">(469) 543-0506</span>, stop by one of our showrooms, or email us at info@zillifurniture.com with your contact information. We usually are in touch within 24 hours.</p>
                            </div>

                            <div class="sub-cat">
                                <h6>Can I Cancel My Order?</h6>
                                <p>We want you to fully understand our policies before you place your order. Because your order is custom made just for you, it cannot be cancelled once it is placed into production with our factories.</p>
                            </div>
                        </div>

                        <div class="col-md-12 mb-5">
                            <h3>Custom Blinds & Shades</h3>

                            <div class="sub-cat">
                                <h6>Order Processing & Production Time</h6>
                                <p>All of our custom blinds and custom shades products are custom made to order and production will not begin before your payment is received. Your credit card will be charged at the time your order is placed. To prevent common mistakes and ensure accuracy, we review every order prior to production. If we have questions or concerns, your order will be placed on hold and a representative will contact you right away. Production normally begins the day after your order is placed and production times vary from 2-12 business days. A current production time estimate is provided for every product.</p>
                            </div>

                            <div class="sub-cat">
                                <h6>Can I Cancel My Order?</h6>
                                <p>We want you to fully understand our policies before you place your order. Because your custom blinds or custom shades order is custom made just for you, it cannot be cancelled once it is placed into production.</p>
                            </div>
                        </div>
                    </div>
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