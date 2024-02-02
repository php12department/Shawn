<?php
include('connect.php'); 
// $db->rpcheckLogin();

/*if(!isset($_SESSION[SESS_PRE.'_SESS_USER_ID']))
{
	$_SESSION['backUrl'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$db->rplocation(SITEURL."login/");
}*/

if(!isset($_SESSION[SESS_PRE.'_SESS_CART_ID']))
{
	$db->rplocation(SITEURL."shopping-cart/");
}

$current_page 	= "Transaction Process";

if($_POST['shipping_charge']==0 || $_POST['distance']==0 || $_POST['shipping_id']==0 || empty($_POST['shipping_id']) || empty($_POST['distance']) || empty($_POST['shipping_id']))
{
    $_SESSION['MSG'] = "shipping_not_available";
    //echo $_SESSION['MSG'];die();
    $db->rplocation(SITEURL."checkout/");
}

$data = serialize($_POST);
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
		<title><?=$current_page;?> | <?php echo SITETITLE; ?></title>
		<?php include('include_css.php'); ?>
</head>

<body>
		<!-- Header Area Start -->
		<?php include('include_header.php'); ?>
		<!-- Header Area End -->

		<!-- Breadcrumb Area Start -->
		<?php include('include_breadcrumb_area.php'); ?>
		<!-- Breadcrumb Area End -->
		
		<!-- Checkout Area Start -->
		<div class="checkout-area pt-80">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 col-md-12 mb-30">
						<h3 class="text-center">Please wait while your transaction is processing...</h3>
						<div class="text-center">
							<img src="<?php echo SITEURL; ?>common/images/processing.gif" alt="processing" />
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Checkout Area End -->  

		<!-- Footer Area Start -->
		<?php include('include_footer.php'); ?>
		<!-- Footer Area End -->

		<!-- all js here -->
		<?php include('include_js.php'); ?>
		<script type="text/javascript">
			$(document).ready(function(){
				setTimeout(function(){
					rpTP();
				},1000);
			});
			function rpTP(){
				$.ajax({
					type: "POST",
					url: "<?php echo SITEURL; ?>ajax_checkout_process.php",
					data: "data=<?php echo urlencode($data); ?>",
					dataType: 'json',
					success: function(res) 
					{ 
						//return false;
						if(res.msg=="psuccess")
						{
							location.href='<?php echo SITEURL; ?>paypal-checkout/';
						}
						else if(res.msg=="error")
						{
							location.href='<?php echo SITEURL; ?>shopping-cart/';
						}
						else if(res.msg=="pay_method_error")
						{
							location.href='<?php echo SITEURL; ?>checkout/';
						}
						else if(res.msg=="stripe_success")
        				{
        					<?php if(isset($_SESSION[SESS_PRE.'_SESS_USER_ID'])){?>
        						location.href='<?php echo SITEURL; ?>orders/';
        					<?php }else {?>
        						location.href='<?php echo SITEURL; ?>';
        					<?php }?>
        				}
        				else if(res.msg=="stripe_error")
        				{
        					location.href='<?php echo SITEURL; ?>checkout/';
        				}
        				else
        				{
        					location.href='<?php echo SITEURL; ?>shopping-cart/';
        				}
					}
				});
			}
		</script>
</body>

</html>