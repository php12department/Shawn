<?php
include("connect.php");

if((isset($_SESSION[SESS_PRE.'_ADMIN_SESS_ID']) && $_SESSION[SESS_PRE.'_ADMIN_SESS_ID']>0))
{
    $db->rplocation(ADMINURL."dashboard/");
}
?>
<!DOCTYPE html>
<html lang="en" >
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <head>
        <title>Set New Password | <?php echo ADMINTITLE; ?></title>
        <?php include('include_css.php'); ?>
    </head>
    <body  class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading"  >
        <!-- begin:: Page -->
        <div class="kt-grid kt-grid--ver kt-grid--root">
            <div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v1" id="kt_login">
                <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--desktop kt-grid--ver-desktop kt-grid--hor-tablet-and-mobile">
                    <!--begin::Aside-->
                    <div class="kt-grid__item kt-grid__item--order-tablet-and-mobile-2 kt-grid kt-grid--hor kt-login__aside" style="background-image: url(<?=SITEURL?>common/images/admin-login-bg.jpg);">
                        <div class="kt-grid__item">
                            <a href="javascript:void(0);" class="kt-login__logo">
                                <img class="cus-logo-class" src="<?php echo SITEURL; ?>common/images/logo.png">
                            </a>
                        </div>
                        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver">
                            <div class="kt-grid__item kt-grid__item--middle">
                                <h3 class="kt-login__title">Welcome to <?= ADMINTITLE ?>!</h3>
                                <!-- <h4 class="kt-login__subtitle"></h4> -->
                            </div>
                        </div>
                        <div class="kt-grid__item">
                            <div class="kt-login__info">
                                <div class="kt-login__copyright">
                                    &copy <?=date("Y");?> <?= SITENAME ?>
                                </div>
                                <!-- <div class="kt-login__menu">
                                    <a href="#" class="kt-link">Privacy</a>
                                    <a href="#" class="kt-link">Legal</a>
                                    <a href="#" class="kt-link">Contact</a>
                                </div> -->
                            </div>
                        </div>
                    </div>
                    <!--begin::Aside-->
                    <!--begin::Content-->
                    <div class="kt-grid__item kt-grid__item--fluid  kt-grid__item--order-tablet-and-mobile-1  kt-login__wrapper">
                        <!--begin::Body-->
                        <div class="kt-login__body">
                            <!--begin::Signin-->
                            <div class="kt-login__form">
                                <div class="kt-login__title">
                                    <h3>Set New Password</h3>
                                </div>
                                <!--begin::Form-->
                                <form class="kt-form" action="<?php echo ADMINURL."process-set-new-password/"; ?>" method="post" name="frm" id="frm">
                                    <div class="form-group">
                                        <input type="password" name="newpass" id="newpass" class="form-control" autocomplete="off" placeholder="Enter New Password" />
                                    </div>

                                    <div class="form-group">
                                        <input type="password" name="cnewpass" id="cnewpass" class="form-control" autocomplete="off" placeholder="Confirm New Password" />
                                    </div>
                                    <input type="hidden" name="slug" id="slug" value="<?php echo $_REQUEST['slug']; ?>" />
                                    <input type="hidden" name="id" id="id" value="<?php echo $_REQUEST['id']; ?>" />
                                    <!--begin::Action-->
                                    <div class="kt-login__actions">
                                        <a href="<?php echo ADMINURL;?>" class="kt-link kt-login__link-forgot">
                                        Sign In ?
                                        </a>
                                        <button id="kt_login_signin_submit" class="btn btn-primary btn-elevate kt-login__btn-primary">Submit</button>
                                    </div>
                                    <!--end::Action-->
                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Signin-->
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Content-->
                </div>
            </div>
        </div>
        <?php include('include_js.php'); ?>
        <script>        
            $(function(){
                $("#frm").validate({
                    rules: {
                        newpass:{required : true},
                        cnewpass:{required : true,equalTo: "#newpass"},
                    },
                    messages: {
                        newpass:{required:"Please enter password."},
                        cnewpass:{required:"Please enter confirm password.",equalTo:"Both password does not match."},
                    }
                });
            });
        </script>
    </body>
</html>