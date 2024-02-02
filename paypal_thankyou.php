<?php
include('connect.php'); 
$current_page = "Thank you";

unset($_SESSION[SESS_PRE.'_SESS_CART_ID']);

$user_id = 	($_SESSION[SESS_PRE.'_SESS_USER_ID'])?$_SESSION[SESS_PRE.'_SESS_USER_ID']:0;

if($user_id > 0)
{
    $return_url = SITEURL."orders/";
    $return_btn_text = "GO TO MY ORDERS";
}
else
{
    $return_url = SITEURL;
    $return_btn_text = "CONTINUE SHOPPING";
}
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
	<title> <?=$current_page;?> | <?php echo SITETITLE; ?></title>
	<?php include('include_css.php'); ?>
</head>

<body>
	<!-- Header Area Start -->
	<?php include('include_header.php'); ?>
	<!-- Header Area End -->

  <div class="gallary-section upload-gallary-section thank-you-section">
    <div class="container h-100">
      <div class="row text-center justify-content-center align-items-center h-100">
        <!-- <div class="col-6 p-0">
          <img src="<?= SITEURL?>assets/img/thank2.png">
        </div> -->
        <div class="col-12 col-md-8">
          <img src="<?= SITEURL?>assets/img/thank2.png">
          <h2>Thank You for Shopping With Us.</h2>
          <div><span class="right-arrow"><i class="fa fa-check"></i></span></div>
          <p>Your payment has been processed successfully, Please check your email inbox for more details.</p>
          <a href="<?= $return_url?>" class="banner-btn hover-effect-span left-arrow"><?=$return_btn_text;?>
              <span class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
width="21" height="10"
viewBox="0 0 172 172"
style=" fill:#000000;"><g fill="#ffffff"><path d="M40.02135,51.54401c-1.48951,0.04438 -2.90324,0.6669 -3.94167,1.73568l-28.16276,28.16276c-1.41918,1.08154 -2.25398,2.76211 -2.25837,4.54643c-0.00439,1.78431 0.82213,3.46898 2.23597,4.55748c0.01117,0.0075 0.02237,0.01497 0.03359,0.02239l28.15156,28.15156c1.43802,1.49776 3.57339,2.1011 5.58258,1.57732c2.00919,-0.52378 3.57824,-2.09283 4.10202,-4.10202c0.52378,-2.00919 -0.07955,-4.14456 -1.57731,-5.58258l-18.87969,-18.87969h135.22604c2.06765,0.02924 3.99087,-1.05709 5.03322,-2.843c1.04236,-1.78592 1.04236,-3.99474 0,-5.78066c-1.04236,-1.78592 -2.96558,-2.87225 -5.03322,-2.843h-135.22604l18.87969,-18.87969c1.69569,-1.64828 2.20555,-4.16851 1.28389,-6.3463c-0.92166,-2.17779 -3.08576,-3.56638 -5.44951,-3.49667z"></path></g></g></svg>
                <!-- <svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid" fill='#fff' style="width:21px; height: 10px;" viewBox="0 0 21 10"><path d="M21.000,5.000 L15.000,10.000 L15.000,6.000 L-0.000,6.000 L-0.000,4.000 L15.000,4.000 L15.000,0.000 L21.000,5.000 Z"></path></svg> -->
              </span>
            </a>
        </div>
      </div>
    </div>
  </div>



	<!-- Footer Area Start -->
	<?php include('include_footer.php'); ?>
	<!-- Footer Area End -->
	<!-- all js here -->
	<?php include('include_js.php'); ?>
</body>
</html>