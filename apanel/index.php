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
        <title>Login | <?php echo ADMINTITLE; ?></title>
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
                                    <h3>Sign In</h3>
                                </div>
                                <!--begin::Form-->
                                <form class="kt-form" action="<?php echo ADMINURL."process-login/"; ?>" method="post" name="frm" id="frm">
                                    <div class="form-group">
                                        <input class="form-control" type="email" placeholder="Email" name="email" id="email" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" type="password" placeholder="Password" name="password" id="password">
                                    </div>
                                    <!--begin::Action-->
                                    <div class="kt-login__actions">
                                        <a href="<?php echo ADMINURL.'forgot-password/';?>" class="kt-link kt-login__link-forgot">
                                        Forgot Password ?
                                        </a>
                                        <button id="kt_login_signin_submit" class="btn btn-primary btn-elevate kt-login__btn-primary">Sign In</button>
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
                        email:{required : true,email:true},
                        password:{required : true},
                    },
                    messages: {
                        email:{required:"Please enter your email address.",email:"Please enter valid email address."},
                        password:{required:"Please enter your password."},
                    }
                });
            });
        </script>
    </body>
</html>