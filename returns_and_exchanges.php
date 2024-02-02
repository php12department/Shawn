<?php
include('connect.php'); 
$current_page = "Returns & Exchanges";
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
    
    <div class="returns-banner">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-md-9">
                    <h1>Returns & Exchanges</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- financing Information section -->
    <div class="shipping-info-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-12 mb-5">
                            <p>All returns are subject to 30% restocking fee. The cost of shipping or delivery and return fees will be deducted from your refund. The returned item(s) are inspected immediately upon receipt. Any appropriate exchanges, credits and refunds will be issued for the purchase price of the item(s); taxes are refunded in accordance with applicable state law. With the exception of damaged or defective merchandise, shipping, delivery, and handling charges are nonrefundable, and return shipping or pickup fees may apply. Most refunds or credits are based on the payment method used at the time of purchase. Please allow 7-10 days following receipt of the return items for any credit or refund to display on your credit card statement.</p>
                        </div>

                        <div class="col-md-12 mb-5">
                            <h5>Non-Returnable Items</h5>
                            <p>Special purchases, including: special orders, specials of the week, clearance items, closeout items, floor models, etc. Any item that has been modified or used in any way, or that has been assembled or installed.</p>

                            <div class="sub-cat">
                                <h6>Back Orders</h6>
                                <p>If you are cancelling an order due to back order or special order, we recommend you first call our Customer Service department to verify the accuracy of the date before making your final decision, if the item is truly unavailable for an extended period, we sincerely apologize for the delay.</p>
                            </div>

                            <div class="sub-cat">
                                <h6>Special Order and Backorder Delays</h6>
                                <p>Delays in production and shipping may occur. If a delay occurs, don’t panic. We will work hard to get your purchase to you, but please keep in mind that we work with high-ticket and large items, which come from all over the world. We will make all efforts to quote accurate lead times and notify all our customers promptly. Please note that we are not responsible for product delays from the manufacturer. Due to increased security by governments, customs delay may also occur, which is beyond our control. In most cases, delays occur during busy seasons, holidays, production delays, port congestions or other factors not in our control. Zilli Furniture is not responsible for delays in stock replenishment, orders may not be cancelled or be eligible for a refund or rebate based on late merchandise arrival.</p>
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