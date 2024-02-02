<?php
include('connect.php');
$adate = date("Y-m-d H:i:s");
// $uid        = $_SESSION[SESS_PRE.'_SESS_USER_ID'];

$discount_type 		= 0;
$discount_amount	= 0;
$total_discount 	= 0;

$qty = "1";
$pid = intval($_POST['productid']);

$response = array();

if (isset($_SESSION[SESS_PRE.'_SESS_USER_ID']) && !empty($_SESSION[SESS_PRE.'_SESS_USER_ID'])) {
	if(isset($_SESSION[SESS_PRE.'_SESS_CART_ID']) && $_SESSION[SESS_PRE.'_SESS_CART_ID']>0)
	{
		$cart_id = $_SESSION[SESS_PRE.'_SESS_CART_ID'];
	}
	else
	{
		//New cart
		/*
			Order Status :
			0=Cancelled,
			1=In Progress,
			2=Completed,
			3=Shipped,
			4=Delivered
		*/

		$orderstatus= "1";
		$uid = (isset($_SESSION[SESS_PRE.'_SESS_USER_ID']) && $_SESSION[SESS_PRE.'_SESS_USER_ID']>0)?$_SESSION[SESS_PRE.'_SESS_USER_ID']:0;
		$cdrows 	= array(
				"uid",
				"orderstatus",
				"adate",
			);
		$cdvalues = array(
				$uid,
				$orderstatus,
				$adate,
			);
		$cart_id = $db->rpinsert("cartdetails",$cdvalues,$cdrows);
		$_SESSION[SESS_PRE.'_SESS_CART_ID'] = $cart_id;
	}

	$pro_r 		= $db->rpgetData("product","*","id='".$pid."' AND isDelete=0");
	$pro_d 		= @mysqli_fetch_array($pro_r);
	$pro_id 	= $pro_d['id'];

	if($pro_id!='')
	{
		$name 				= stripslashes($pro_d['name']);
		$qty 				= $qty;
		$cate_id 			= $pro_d['cate_id'];
		$sub_cate_id 		= $pro_d['sub_cate_id'];

		$cate_name 			= $db->clean($db->rpgetValue("category","name"," id='".$cate_id."'"));
		$sub_cate_name 		= $db->clean($db->rpgetValue("sub_category","name"," id='".$sub_cate_id."'"));

		$unitprice  		= ($pro_d['sell_price'] > 0) ? $pro_d['sell_price'] : $pro_d['price']; 
		$totalprice			= $db->rpnum($qty * $unitprice);
		$finalprice			= $totalprice;
		
		if($unitprice>0)
		{
			$check_dup_pro_t = $db->rpgetTotalRecord("cartitems"," cart_id = '".$cart_id."' AND pid='".$pid."'");
			
			$uid = (isset($_SESSION[SESS_PRE.'_SESS_USER_ID']) && $_SESSION[SESS_PRE.'_SESS_USER_ID']>0)?$_SESSION[SESS_PRE.'_SESS_USER_ID']:0;
			
			if($check_dup_pro_t > 0)
			{
				$cqty = $db->rpgetValue("cartitems","qty","cart_id='".$cart_id."' AND pid = '".$pid."'");
				
				$qty 				= intval($cqty + $qty);
				$unitprice  		= ($pro_d['sell_price'] > 0) ? $pro_d['sell_price'] : $pro_d['price']; 
				$totalprice			= $db->rpnum($qty * $unitprice);

				$discount_type = 0;
				$discount_amount = 0;
				$total_discount = 0;
				
				$finalprice = $db->rpnum($totalprice - $total_discount);

				$cirows 	= array(
						"uid"					=> $uid,
						"name"					=> $name,
						"qty"					=> $qty,
						"cate_id"				=> $cate_id,
						"sub_cate_id"			=> $sub_cate_id,
						"cate_name"				=> $cate_name,
						"sub_cate_name"			=> $sub_cate_name,
						"unitprice"				=> $unitprice,
						"discount_type"			=> $discount_type,
						"discount_amount"		=> $discount_amount,
						"total_discount"		=> $total_discount,
						"totalprice"			=> $totalprice,
						"finalprice"			=> $finalprice,
					);
				$ciwhere	= " pid = '".$pid."' AND cart_id='".$cart_id."' ";
				$db->rpupdate("cartitems",$cirows,$ciwhere);
			}
			else
			{
				$discount_type 		= 0;
				$discount_amount 	= 0;
				$total_discount 	= 0;
							
				$finalprice = $db->rpnum($totalprice - $total_discount);
				
				$cirows = array(
						"cart_id",
						"uid",
						"pid",
						"name",
						"cate_id",
						"sub_cate_id",
						"cate_name",
						"sub_cate_name",
						"unitprice",
						"qty",
						"discount_type",
						"discount_amount",
						"total_discount",
						"totalprice",
						"finalprice",
						"orderstatus",
						"adate",
					);
				$civalues = array(
						$cart_id,
						$uid,
						$pid,
						$name,
						$cate_id,
						$sub_cate_id,
						$cate_name,
						$sub_cate_name,
						$unitprice,
						$qty,
						$discount_type,
						$discount_amount,
						$total_discount,
						$totalprice,
						$finalprice,
						"1",
						$adate,
					);
				$db->rpinsert("cartitems",$civalues,$cirows);
			}

			$cartdetails_finaltotal = 0;
			$cartitems_r = $db->rpgetData("cartitems","finalprice"," cart_id='".$_SESSION[SESS_PRE.'_SESS_CART_ID']."' ");
			while ($cartitems_d = mysqli_fetch_array($cartitems_r)) 
			{
				$cartdetails_finaltotal = $cartdetails_finaltotal + $cartitems_d['finalprice'];
			}

			$total_rows = array(
				"finaltotal" => $cartdetails_finaltotal,
			);
			$total_where	= " cart_id='".$_SESSION[SESS_PRE.'_SESS_CART_ID']."' ";
			$db->rpupdate("cartdetails",$total_rows,$total_where);

			//unset($_SESSION[SESS_PRE.'_backUrl']);
			$response['message'] = "add_to_cart_successfully";
		}
		else
		{
			$response['message'] = "not_available";
		}
	}
	else
	{
		$response['message'] = "not_available";
	}

}else{
	$response['message'] = "login_first";
}

echo json_encode($response);
die();