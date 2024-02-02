<?php
include('connect.php'); 

if(isset($_SESSION[SESS_PRE.'_SESS_USER_ID']) && $_SESSION[SESS_PRE.'_SESS_USER_ID']!="")
{
   $db->rplocation(SITEURL."index/");
}
$current_page = "Lost Password";
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
  <title><?=$current_page;?> | <?php echo SITETITLE; ?></title>
  <?php include('include_css.php'); ?>
  <meta name="robots" content="follow, index, max-snippet:-1, max-image-preview:large"/>
  <!-- meta tags site details -->
  <meta property="og:locale" content="en_US" />
  <meta property="og:type" content="website" />
  <meta property="og:title" content="Forget Password - Zilli Furniture" />
  <meta property="og:description" content="Forget your password for the zilli furniture account? Don’t worry just click on the forget password button and retrieve your password." />
  <meta property="og:url" content="<?=$actual_link;?>" />
  <meta property="og:site_name" content="<?php echo SITETITLE; ?>" />
  <meta property="og:image" content="<?=SITEURL?>common/images/logo.png" />
  <meta property="og:image:secure_url" content="<?= SITEURL?>common/images/logo.png" />
  <meta property="og:image:width" content="1282" />
  <meta property="og:image:height" content="676" />
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:description" content="Forget your password for the zilli furniture account? Don’t worry just click on the forget password button and retrieve your password." />
  <meta name="twitter:title" content="Forget Password - Zilli Furniture" />
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
        <div class="col-lg-3 col-md-12 col-sm-12"></div>
        <div class="col-lg-6 col-md-12 col-sm-12">
          <form name="loginfrm" id="loginfrm"  method="post" action="<?php echo SITEURL; ?>process-forget-password/">
            <div class="form-fields">
              <!-- <h2>Lost Password</h2> -->
              <p>Lost your password? Please enter your register email address. You will receive a link to create a new password via email.</p>
              <p>
                <label for="login-name" class="important">Email address </label>
                <input type="text" id="form_email" name="form_email">
              </p>
            </div>
            <div class="form-action">
              <button type="submit" name="submit">Send Mail</button>
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
            form_email:{required : true,email:true},
          },
          messages: {
            form_email:{required:"Please enter your email.",email:"Please enter valid email address."},
          }
        }); 
     });
  </script>
</body>
</html>