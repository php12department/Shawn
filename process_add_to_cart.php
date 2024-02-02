<?php
include("connect.php");
// $db->rpcheckLogin();
$adate = date("Y-m-d H:i:s");

// echo "<pre>"; print_r($_POST); die;
$qty = intval($_POST['qty']);
$pid = intval($_POST['product_id']);
$product_type = (isset($_POST['product_type'])&& !empty($_POST['product_type'])) ? $_POST['product_type'] : "p";

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

// Add Item To Cart
if (!empty($product_type) && $product_type=="w") {
	$pro_r   = $db->rpgetData("warranty","*","id='".$pid."' AND isDelete=0");
	$pro_d   = @mysqli_fetch_array($pro_r);
	$pro_id  = $pro_d['id'];

	$name 				= stripslashes($pro_d['title']);
	$qty 				= $qty;
	$cate_id 			= "";
	$sub_cate_id 		= "";
	$sub_sub_cate_id 	= "";

	$cate_name 			= "";
	$sub_cate_name 		= "";
	$sub_sub_cate_name 	= "";

	$unitprice  		= $pro_d['amount']; 
	$totalprice			= $db->rpnum($qty * $unitprice);
	$finalprice			= $totalprice;
	
	$discount_desc 		= "";
	$discount_type 		= "";
	$discount_amount 	= "";
	$total_discount 	= "";


}else{
	$pro_r  = $db->rpgetData("product","*","id='".$pid."' AND isDelete=0");
	$pro_d  = @mysqli_fetch_array($pro_r);
	$pro_id = $pro_d['id'];

	$name 				= stripslashes($pro_d['name']);
	$qty 				= $qty;
	$cate_id 			= $pro_d['cate_id'];
	$sub_cate_id 		= $pro_d['sub_cate_id'];
	$sub_sub_cate_id 	= $pro_d['sub_sub_cate_id'];

	$cate_name 			= $db->clean($db->rpgetValue("category","name"," id='".$cate_id."'"));
	$sub_cate_name 		= $db->clean($db->rpgetValue("sub_category","name"," id='".$sub_cate_id."'"));
	$sub_sub_cate_name 	= $db->clean($db->rpgetValue("sub_sub_category","name"," id='".$sub_sub_cate_id."'"));

	$unitprice  		= ($pro_d['sell_price'] > 0) ? $pro_d['sell_price'] : $pro_d['price']; 
	$totalprice			= $db->rpnum($qty * $unitprice);
	$finalprice			= $totalprice;
	
	$is_discount_product = $db->checkIsDiscountProduct($pro_id,$cate_id,$sub_cate_id,$sub_sub_cate_id,$unitprice);

	$discount_desc 		= $is_discount_product['discount_desc'];
	$discount_type 		= $is_discount_product['discount_type'];
	$discount_amount 	= $is_discount_product['discount_amount'];
	$total_discount 	= $is_discount_product['total_discount'];
}


if($pro_id!='')
{
	if($unitprice>0)
	{
		//check for duplication
		$check_dup_pro_t = $db->rpgetTotalRecord("cartitems"," cart_id = '".$cart_id."' AND pid='".$pid."' AND product_type='".$product_type."'");
		
		$uid = (isset($_SESSION[SESS_PRE.'_SESS_USER_ID']) && $_SESSION[SESS_PRE.'_SESS_USER_ID']>0)?$_SESSION[SESS_PRE.'_SESS_USER_ID']:0;
		
		if($check_dup_pro_t > 0)
		{
			$cqty = $db->rpgetValue("cartitems","qty","cart_id='".$cart_id."' AND pid = '".$pid."' AND product_type='".$product_type."'");
			
			$qty 				= intval($cqty + $qty);
			$totalprice			= $db->rpnum($qty * $unitprice);
			
			$finalprice = $db->rpnum($totalprice - $total_discount);

			$cirows 	= array(
					"uid"					=> $uid,
					"name"					=> $name,
					"qty"					=> $qty,
					"product_type"			=> $product_type,
					"cate_id"				=> $cate_id,
					"sub_cate_id"			=> $sub_cate_id,
					"sub_sub_cate_id"		=> $sub_sub_cate_id,
					"cate_name"				=> $cate_name,
					"sub_cate_name"			=> $sub_cate_name,
					"sub_sub_cate_name"		=> $sub_sub_cate_name,
					"unitprice"				=> $unitprice,
					"discount_desc"			=> $discount_desc,
					"discount_type"			=> $discount_type,
					"discount_amount"		=> $discount_amount,
					"total_discount"		=> $total_discount,
					"totalprice"			=> $totalprice,
					"finalprice"			=> $finalprice,
				);
			$ciwhere	= " pid = '".$pid."' AND cart_id='".$cart_id."' AND product_type='".$product_type."' ";
			$db->rpupdate("cartitems",$cirows,$ciwhere);
		}
		else
		{
			$finalprice = $db->rpnum($totalprice - $total_discount);
			
			$cirows = array(
					"cart_id",
					"uid",
					"pid",
					"product_type",
					"name",
					"cate_id",
					"sub_cate_id",
					"sub_sub_cate_id",
					"cate_name",
					"sub_cate_name",
					"sub_sub_cate_name",
					"unitprice",
					"qty",
					"discount_desc",
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
					$product_type,
					$db->clean($name),
					$cate_id,
					$sub_cate_id,
					$sub_sub_cate_id,
					$cate_name,
					$sub_cate_name,
					$sub_sub_cate_name,
					$unitprice,
					$qty,
					$discount_desc,
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
		$db->rplocation(SITEURL."shopping-cart/");
	}
	else
	{
		$_SESSION['MSG'] = "NOT_AVAILABLE";
		?>
		<script type="text/javascript">
			window.location.href='<?php echo $_SERVER['HTTP_REFERER']; ?>';
		</script>
		<?php
		die;
	}
}
else
{
	$_SESSION['MSG'] = "NOT_AVAILABLE";
	?>
	<script type="text/javascript">
		window.location.href='<?php echo $_SERVER['HTTP_REFERER']; ?>';
	</script>
	<?php
	die;
}
?>