<?php
include('connect.php'); 
require_once 'common/css/pagination_style.php';

$db->rpcheckLogin();
$current_page = "Wishlist";
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
                    <div class="wishlist-area">
                        <div class="container">
                            <div class="wishlist-content only-wishlist">
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
            $("#results" ).load("<?php echo SITEURL; ?>ajax_get_wishlist.php"); 

            $("#results").on( "click", ".pagination_my a", function (e){
              e.preventDefault();
              $(".front-loading-div").show(); 
              var page = $(this).attr("data-page"); 
              $("#results").load("<?php echo SITEURL; ?>ajax_get_wishlist.php",{"page":page}, function(){ 
                $(".front-loading-div").hide(); 
              });
              
            });
        });

        function remove_wishList(pid){
            
            $.ajax({
                type: "POST",
                url: "<?php echo SITEURL; ?>ajax_remove_wishlist.php",
                data: "pid=" + pid,
                dataType: "json",
                success: function(result) 
                {
                    if(result['msg']=='remove')
                    {
                      window.location.href='<?php echo SITEURL?>wishlist/';
                    }
                    else if(result['msg']=="error")
                    {
                      window.location.href='<?php echo SITEURL?>wishlist/';
                    }
                }
            });
        }
    </script>
</body>

</html>