<?php
include('connect.php'); 
$db->rpcheckLogin();
$current_page = "Change Password";
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
                        <form name="frm" id="frm" action="<?php echo SITEURL; ?>process-change-password/" method="post">
                            <div class="form-fields">
                                <h2>Change Password</h2>
                                <p>
                                    <label for="login-name" class="important">Current Password</label>
                                    <input type="password" id="current_password" name="current_password">
                                    <input type="hidden" name="old_password" id="old_password">
                                </p>
                                <p>
                                    <label for="login-name" class="important">New Password</label>
                                    <input type="password" name="new_password"  id="new_password">
                                </p>
                                <p>
                                    <label for="login-name" class="important">Confirm Password</label>
                                    <input type="password" name="confirm_password"  id="confirm_password">
                                </p>
                            </div>
                            <div class="form-action">
                                <button type="submit" name="submit" id="submit">Save Changes</button>
                            </div>
                        </form>
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
            /* Form Validation Start */
            $(function(){
                $("#frm").validate({
                    rules: {
                        current_password:{
                            required : true,
                            remote: {
                                url: "<?php echo SITEURL?>ajax_check_current_password.php",
                                type: "post",
                                dataFilter: function(data) 
                                {
                                    if(data == 1)
                                    {
                                        return true;
                                    }
                                    else
                                    {
                                        return false;
                                    }
                                }
                            }
                        },
                        new_password:{required : true},
                        confirm_password:{required : true,equalTo: "#new_password"},
                    },
                    messages: {
                        current_password:{required:"Please enter your current password.",
                                          remote:"This password is not matched with current password."},
                        new_password:{required:"Please enter your new password."},
                        confirm_password:{required:"Please enter confirm password.", equalTo:"New Password and confirm  password not matched."},
                    },
                    
                });
            });

            /* Form Validation End */
        </script>
</body>

</html>