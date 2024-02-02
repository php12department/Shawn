<?php
include('connect.php'); 
if(isset($_SESSION[SESS_PRE.'_SESS_USER_ID']) && $_SESSION[SESS_PRE.'_SESS_USER_ID']!="")
{
   $db->rplocation(SITEURL."index/");
}
$current_page = "Login / Register";
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
   <title> <?=$current_page;?> | <?php echo SITETITLE; ?></title>
   <?php include('include_css.php'); ?>
    <meta name="robots" content="follow, index, max-snippet:-1, max-image-preview:large"/>
    <!-- meta tags site details -->
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Login - Zilli Furniture" />
    <meta property="og:description" content="Buy home and office furniture from Zilli Furniture by creating an account. Login at Zilli Furniture now to get some amazing rewards." />
    <meta property="og:url" content="<?=$actual_link;?>" />
    <meta property="og:site_name" content="<?php echo SITETITLE; ?>" />
    <meta property="og:image" content="<?=SITEURL?>common/images/logo.png" />
    <meta property="og:image:secure_url" content="<?= SITEURL?>common/images/logo.png" />
    <meta property="og:image:width" content="1282" />
    <meta property="og:image:height" content="676" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:description" content="Buy home and office furniture from Zilli Furniture by creating an account. Login at Zilli Furniture now to get some amazing rewards." />
    <meta name="twitter:title" content="Login - Zilli Furniture" />
    <meta name="twitter:image" content="<?= SITEURL?>common/images/logo.png" />
    <!-- end meta tags site details -->
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
            <div class="col-lg-6 col-md-12 col-sm-12">
               <form name="loginfrm" id="loginfrm"  method="post" action="<?php echo SITEURL; ?>process-login/">
                  <div class="form-fields">
                     <h2>Login</h2>
                     <p>
                        <label class="important">Email address </label>
                        <input type="text" name="form_email" id="form_email" value="">
                     </p>
                     <p>
                        <label class="important">Password</label>
                        <input type="password" id="form_password" value="" name="form_password">
                     </p>
                  </div>
                  <div class="form-action">
                     <p class="lost_password"><a href="<?php echo SITEURL; ?>forgetpassword/">Lost your password?</a></p>
                     <button type="submit" name="submit">Login</button>
                  </div>
               </form>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12">
               <form method="post" action="<?php echo SITEURL; ?>process-signup/" id="contact_form" name="contact_form">
                  <div class="form-fields">
                     <h3 class="form-field-register">Register</h3>
                     <p>
                        <label class="important">First Name</label>
                        <input type="text" id="form_name" value="" name="form_name">
                     </p>
                     <p>
                        <label class="important">Last Name</label>
                        <input type="text" id="form_last_name" value="" name="form_last_name">
                     </p>
                     <p>
                        <label class="important">Phone Number</label>
                        <input type="text" id="form_phone" value="" name="form_phone">
                     </p>
                     <p>
                        <label class="important">Email address</label>
                        <input type="text" name="email" id="email" value="">
                     </p>
                     <p>
                        <label class="important">Password</label>
                        <input type="password" name="password" id="password" value="">
                     </p>
                     <p>
                        <label class="important">Re-enter Password</label>
                        <input type="password" name="confirm_password" id="confirm_password" value="">
                     </p>
                     <p class="d-flex">
                        <input type="checkbox" class="checkbox" name="agree_newsletter_email" id="agree_newsletter_email" value="1">
                        <label class="lable-check">Sign Up for Newsletter</label>
                     </p>
                     <p class="d-flex">
                        <input type="checkbox" class="checkbox" name="agree_term" id="agree_term" value="1">
                        <label class="lable-check terms_checkbox">I accept to <a href="javascript:void(0);"><?= SITETITLE; ?> Terms and Conditions</a></label>
                     </p>
                  </div>
                  <div class="form-action">
                     <button type="submit" name="submit">Register</button>
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
   <script>
      $(function(){
         $("#loginfrm").validate({
            rules: {
               form_email:{required : true,email:true},
               form_password:{required : true}
            },
            messages: {
               form_email:{required:"Please enter your email.",email:"Please enter valid email address."},
               form_password:{required:"Please enter your password."}
            }
         }); 
      });

      $("#contact_form").validate({
         ignore : [],
         rules: 
         {
           form_name:{required : true},
           form_last_name:{required : true},
           form_phone:{required : true, number : true},
           email:{required : true,email: true},
           password:{required : true},
           confirm_password:{required : true,equalTo: "#password"},
           agree_term:{required : true},
         },
         messages: {
           form_name:{required:"Please enter your first name."},
           form_last_name:{required:"Please enter your last name."},
           form_phone:{required:"Please enter your phone number.", number : "Please enter valid phone number."},
           email:{required:"Please enter your email address.", email : "Please enter valid email address."},
           password:{required:"Please enter your password."},
           confirm_password:{required:"Please enter confirm password.", equalTo:"Password and confirm  password not matched."},
           agree_term:{required:"You must agree to the terms and conditions before submitting the details."},
         }, 
         errorPlacement: function (error, element) 
         {
            if (element.attr('name') == 'agree_term')
            {
               error.insertAfter(".terms_checkbox");
            }
            else 
            {
               error.insertAfter(element);
            }
         }
      });
</script>
</body>

</html>