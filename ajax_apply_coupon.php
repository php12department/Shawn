<?php
include('connect.php');
$coupon 		= $_POST['coupon'];
// $uid        = $_SESSION[SESS_PRE.'_SESS_USER_ID'];

$response = array();

$response['error'] = 1;
$response['message'] = "Invalid Request";
$curr_dt = date('Y-m-d');


$cpn_f 		= $db->rpgetData("coupon","*"," code='".$coupon."' AND isDelete=0 ");
$coupon_no 	= mysqli_num_rows($cpn_f);

if($coupon_no > 0) 
{

	$coupon_d = mysqli_fetch_array($cpn_f);
	$coupon_id = $coupon_d['id'];
	$flag = true;

	if(strtotime($coupon_d['start_date']) > strtotime($curr_dt)) 
	{
		$response['message'] = "commin_soon";
		$flag = false;
	}

	if(strtotime($coupon_d['expiration_date']) < strtotime($curr_dt)) 
	{
		$response['message'] = "expire_too";
		$flag = false;
	}

	$cart_q = $db->rpgetData("cartitems","*","cart_id='".$_SESSION[SESS_PRE.'_SESS_CART_ID']."'");
	//$cart_q = "SELECT * FROM cart WHERE uid='".$uid."' AND IsDelete=0 AND orderstatus=0 ";

	$finalTotal = 0;
	$total_sell_product = 0;
	while($cart_d = mysqli_fetch_assoc($cart_q))
	{
		if($cart_d['product_type']!='w')
		{
			$is_sell_product = $db->rpgetTotalRecord("product","id='".$cart_d['pid']."' AND sell_price > 0");
			if($is_sell_product <= 0)
			{
				$finalTotal = $finalTotal + $db->rpnum($cart_d['finalprice']);
				$total_sell_product++;
			}
		}
	}

	if($finalTotal < $coupon_d['min_spend_amount']) 
	{
		$response['message'] = "min_spend_amount";
		$flag = false;
	}

	if($total_sell_product == 0)
	{
		$response['message'] = "regular_product_not_found"; //if all sell price product added in cart then return this error to user
		$flag = false;
	}

	if($flag == true) 
	{
		$values = array(
			"coupon_id" => $coupon_d['id'],
			"coupon_code" => $coupon_d['code'],
		);
		$wh = " cart_id='".$_SESSION[SESS_PRE.'_SESS_CART_ID']."' ";
		$db->rpupdate("cartdetails",$values,$wh);
		$response['message'] = "success";
	} 
	else 
	{
		$values = array(
			"coupon_id" => "",
			"coupon_code" => "",
		);
		$wh = " cart_id='".$_SESSION[SESS_PRE.'_SESS_CART_ID']."' ";
		$db->rpupdate("cartdetails",$values,$wh);

		$values_itm = array(
            "coupon_id"         => "",
            "coupon_discount"   => 0,
        );
        $itm_wh = " cart_id='".$_SESSION[SESS_PRE.'_SESS_CART_ID']."' ";
        $db->rpupdate("cartitems",$values_itm,$itm_wh);
	}


} 
else 
{
	$response['message'] = "not_available";
}

echo json_encode($response);
die();