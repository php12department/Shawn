<?php
include('connect.php'); 
$current_page = "Shipping Information";
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
                    <h1>Shipping Information</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Shipping Information section -->
    <div class="shipping-info-section">
        <div class="container">
            <div class="row justify-content-center text-left">
                <div class="col-md-9">
                    <div class="row justify-content-center text-left">
                        <div class="col-md-12 mb-5">
                            <h5>Fast & safe delivery!</h5>
                            <p>Your furniture will be delivered on time and in perfect condition just the way you ordered it. You’ll get the same great experience whether you choose full-service white glove delivery, standard curbside service, or upgrade your standard service to Room-of-Choice.</p>
                        </div>

                        <div class="col-md-12 mb-5">
                            <h5>Delivery Information</h5>
                            <p class="mb-2">An estimated time can be requested and we do try to comply, however, the delivery department controls the routing and timing and they will contact you for an appointment. We do offer instant delivery at an up-charge cost depending on where the delivery is located.</p>
                            <p>We will begin processing your delivery two (2) days prior to the delivery date. Because of this no cancellations or changes can be accepted during this two (2) day period. Prior to this time, changes can be made by calling <span class="text-red">(469) 543-0506</span>.</p>
                        </div>

                        <div class="col-md-12 mb-5">
                            <h5>Local Delivery:</h5>
                            <p>If your purchase is to be delivered, it must be paid in full or financing arrangements made by 2:00p.m. two (2) days before delivery.</p>
                        </div>

                        <div class="col-md-12 mb-5">
                            <h5>Out-of-Town Delivery:</h5>
                            <p>If your purchase is to be delivered, it must be paid in full or financing arrangements made by 2:00p.m. two (2) days before delivery. PLEASE, do not call the day of delivery; your ticket is out of file and being processed. Don’t worry; the delivery service will call by 12:00p.m. At this time you will be given approximate delivery time. We primarily deliver in Dallas Metroplex area and the boarding cities. Deliveries which are further require special pricing and must be scheduled by our deliver department.</p>
                        </div>

                        <div class="col-md-12 mb-5">
                            <h5>Customer Pick-Up Guidelines</h5>
                            <p>Pick-ups can be scheduled Monday through Friday from 11:00p.m. to 5:00p.m. Customers must clear pickup through the office. We provide packaging and loading service at the warehouse, but it is YOUR RESPONSIBILITY TO INSPECT MERCHANDISE prior to loading in vehicle. Zilli Furniture is not responsible for any damage that occurs to merchandise, vehicle, person(s) or property during loading/unloading or in transit.</p>
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