<?php 
include('connect.php');

if(isset($_SESSION[SESS_PRE.'_SESS_CART_ID']))
{
	$user_id = 	($_SESSION[SESS_PRE.'_SESS_USER_ID'])?$_SESSION[SESS_PRE.'_SESS_USER_ID']:0;
	$cart_id = 	$_SESSION[SESS_PRE.'_SESS_CART_ID']; 
	
	$where_cd = "cart_id='".$cart_id."'";
	$subtotal = $db->rpgetValue("cartdetails","subtotal",$where_cd);
	
	$total_discount  = $db->rpgetValue("cartdetails","total_discount",$where_cd);
	$shipping_charge = $db->rpgetValue("cartdetails","shipping_charge",$where_cd);
	$tax_amount 	 = $db->rpgetValue("cartdetails","tax_amount",$where_cd);
	$finaltotal      = $db->rpgetValue("cartdetails","finaltotal",$where_cd);
	$email           = $db->rpgetValue("cartdetails","email",$where_cd);
	$total_purchased_item = $db->rpgetSumVal("cartitems","qty","cart_id='".$cart_id."'");

	$one_item_tax = 0;
	if($tax_amount!=0)
	{
		$one_item_tax = number_format(($tax_amount/$total_purchased_item),2);
	}
	
	$one_item_shipping_charge = 0;
	if($shipping_charge!=0)
	{
		$one_item_shipping_charge = number_format(($shipping_charge/$total_purchased_item),2);
	}

	$where_cartitems = "orderstatus=1 AND cart_id='".$cart_id."'";
	$cartitems_r     = $db->rpgetData("cartitems","*",$where_cartitems);
} 
?>
<div class="bag_loader">
	<img src="<?php echo SITEURL;?>common/images/loader.svg" style="margin-left:48%;margin-top:20%;width:120px;"><p class="text-center" style="text-align: center;font-size: 28px;font-family: Source Sans Pro, sans-serif">Please wait redirecting to paypal</p>
</div>

<form method="post" action="<?php echo PAYPAL_URL?>" name="frmPayPal" id="frmPayPal">

	<input type="hidden" name="cmd" value="_cart" />
	<input type="hidden" name="upload" value="1" />
	<input type="hidden" name="rm" value="1" />
	<input type="hidden" name="bn" value="ncm_cart" />
	<input type="hidden" name="no_note" value="1" />
	<input type="hidden" name="charset" value="utf-8" />
	<input type="hidden" name="paymentaction" value="sale" />
	
	<input type="hidden" name="no_shipping" value="1" />
	<input type="hidden" name="currency_code" value="<?php echo PAYPAL_CURRENCY_CODE; ?>">

	<input type="hidden" name="return" value="<?php echo SITEURL;?>pay-thankyou/">
	<input type="hidden" name="cancel_return" value="<?php echo SITEURL;?>shopping-cart/">
	<input type="hidden" name="notify_url" value="<?php echo SITEURL;?>notify.php">
	<input type="hidden" name="business" value="<?php echo PAYPAL_EMAIL?>">

	<?php
	$count = 1;
	$dis_pro = "";
	while($cartitems_d = @mysqli_fetch_array($cartitems_r))
	{
		$name 		= $cartitems_d['name'];
		$qty  		= $cartitems_d['qty'];
		$pro_id  	= $cartitems_d['pid'];

		$dis_item_tax = 0;
		if($one_item_tax!=0)
		{
			$dis_item_tax = ($qty * $one_item_tax);
		}

		$dis_item_shipping_charge = 0;
		if($one_item_shipping_charge!=0)
		{
			$dis_item_shipping_charge = ($qty * $one_item_shipping_charge);
		}

		$pro_final_price = round(($cartitems_d['finalprice'] + $dis_item_tax + $dis_item_shipping_charge) - $cartitems_d['coupon_discount'],2);
		?>
		<input type="hidden" name="item_name_<?php echo $count;?>" value="<?php echo $name;?>" />
		<input type="hidden" name="item_number_<?php echo $count;?>" value="<?=$qty;?>"/>
		<input type="hidden" name="amount_<?php echo $count;?>" value="<?php echo $pro_final_price; ?>" />
		<?php
		$dis_pro= $_SESSION[SESS_PRE.'_SESS_CART_ID']; 
		$count++;
	}				
	?>	
	<input type="hidden" name="custom" value="<?php echo $user_id.','.$cart_id.','.$finaltotal.','.$shipping_charge.','.$total_discount.','.$count.','.$email.'##'.$dis_pro; ?>">
</form>
<script type="text/javascript">
	document.onkeydown = function (e) {
        return false;
	}
	if (document.layers) {
    	
    	document.captureEvents(Event.MOUSEDOWN);
 		document.onmousedown = function () {
        	return false;
    	};
	}
	else {
    	document.onmouseup = function (e) {
        	if (e != null && e.type == "mouseup") {
            	if (e.which == 2 || e.which == 3) {
                	return false;
            	}
        	}
    	};
	}
  	document.oncontextmenu = function () {
    	return false;
	};
	document.onkeydown = function(e) {
		if(event.keyCode == 123) {
			return false;
		}
		if(e.ctrlKey && e.shiftKey && e.keyCode == "I".charCodeAt(0)){
			return false;
		}
		if(e.ctrlKey && e.shiftKey && e.keyCode == "J".charCodeAt(0)){
			return false;
		}
		if(e.ctrlKey && e.keyCode == "U".charCodeAt(0)){
			return false;
		}
	}
</script>
<script type="text/javascript">document.frmPayPal.submit();</script> 