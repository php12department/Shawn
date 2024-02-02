<?php
include('connect.php'); 
require_once 'common/css/pagination_style.php';

$db->rpcheckLogin();
$current_page = "My Orders";
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
    <!-- Account Area Start -->
    <div class="my-account-area ptb-80">
        <div class="container">
            <div class="row">
                <?php include('include_user_sidebar.php'); ?>
                <div class="col-lg-9 col-md-8 col-12">
                    <div class="wishlist-area my-order-data">
                        <div class="container">
                            <div class="wishlist-content">
                                <div class="front-loading-div" style="display:none;">
                                    <div><img style="width:10%" src="<?php echo SITEURL."common/images/loader.svg"?>" alt="<?php echo SITETITLE; ?>" /></div>
                                </div>
                                <div id="results"></div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Account Area End -->

    <!-- Footer Area Start -->
    <?php include('include_footer.php'); ?>
    <!-- Footer Area End -->

    <!-- all js here -->
    <?php include('include_js.php'); ?>
    <script type="text/javascript">
        $(document).ready(function() { 
            $("#results" ).load("<?php echo SITEURL; ?>ajax_get_myorders.php"); 

            $("#results").on( "click", ".pagination_my a", function (e){
              e.preventDefault();
              $(".front-loading-div").show(); 
              var page = $(this).attr("data-page"); 
              $("#results").load("<?php echo SITEURL; ?>ajax_get_myorders.php",{"page":page}, function(){ 
                $(".front-loading-div").hide(); 
              });
            });
        });
    </script>
</body>

</html>