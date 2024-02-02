<?php
include('connect.php'); 
$current_page = "Product Category";
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
    
    <section class="collection">
        <div class="container">
            <div class="row justify-content-center">
              <div class="col-md-4 mb-5">
                  <div class="collection-inner">
                      <img src="assets/img/product/mo-2.jpg" alt="">
                      <div class="overlay ov-1">
                          <h2>Living</h2>
                      </div>
                  </div>
              </div>
              <div class="col-md-4 mb-5">
                  <div class="collection-inner">
                      <img src="assets/img/banner/new2.jpg" alt="">
                      <div class="overlay ov-2">
                          <h2>Dining</h2>
                      </div>
                  </div>
              </div>
              <div class="col-md-4 mb-5">
                  <div class="collection-inner">
                      <img src="assets/img/banner/bed.jpg" alt="">
                      <div class="overlay ov-3">
                          <h2>Bedroom</h2>
                      </div>
                  </div>
              </div>
              <div class="col-md-4 mb-5">
                  <div class="collection-inner">
                      <img src="assets/img/product/office.jpg" alt="">
                      <div class="overlay ov-4">
                          <h2>Office</h2>
                      </div>
                  </div>
              </div>
              <div class="col-md-4 mb-5">
                  <div class="collection-inner">
                      <img src="assets/img/product/light.jpg" alt="">
                      <div class="overlay ov-5">
                          <h2>lighting</h2>
                      </div>
                  </div>
              </div>
              <div class="col-md-4 mb-5">
                  <div class="collection-inner">
                      <img src="assets/img/product/decor.png" alt="">
                      <div class="overlay ov-6">
                          <h2>home decor</h2>
                      </div>
                  </div>
              </div>
            </div>
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