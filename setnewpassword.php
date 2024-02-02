<?php
include('connect.php'); 
if(isset($_SESSION[SESS_PRE.'_SESS_USER_ID']) && $_SESSION[SESS_PRE.'_SESS_USER_ID']!="")
{
   $db->rplocation(SITEURL."index/");
}
$current_page = "Set New Password";
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
                <div class="col-lg-3 col-md-12 col-sm-12"></div>
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <form name="loginfrm" id="loginfrm"  method="post" action="<?php echo SITEURL; ?>process-set-new-password/">
                        <div class="form-fields">
                            <h2>Set New Password</h2>
                            <p>
                                <label class="important">New Password</label>
                                <input type="password" name="password" id="password" value="" placeholder="Enter New Password">
                            </p>
                            <p>
                                <label class="important">Confirm Password</label>
                                <input type="password" name="confirm_password" id="confirm_password" value="" placeholder="Enter Confirm Password">
                            </p>
                            <input type="hidden" name="slug" id="slug" value="<?php echo $_REQUEST['slug']; ?>" />
                            <input type="hidden" name="id" id="id" value="<?php echo $_REQUEST['id']; ?>" />
                        </div>
                        <div class="form-action">
                            <button type="submit">Save Changes</button>
                        </div>
                    </form>
                </div>
                <div class="col-lg-3 col-md-12 col-sm-12"></div>
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
        $(function(){
         
            $("#loginfrm").validate({

                rules: {
                    password:{required : true},
                    confirm_password:{required : true,equalTo: "#password"},
                },
                messages: {
                    password:{required:"Please enter password."},
                    confirm_password:{required:"Please enter confirm password.",equalTo:"Both password does not match."},
                }
            }); 
        });
    </script>
</body>
</html>