<?php 
include("connect.php"); 

$values = array(
	"coupon_id" 		=> "",
	"coupon_code" 		=> "",
	"coupon_type" 		=> "",
	"total_discount" 	=> 0,
);

$cartid 	= $_SESSION[SESS_PRE.'_SESS_CART_ID'];
$where 		= " cart_id='".$cartid."' ";
echo $res = $db->rpupdate("cartdetails",$values,$where);
?>