<?php 
include("connect.php"); 

$cart_id 		= $_SESSION[SESS_PRE.'_SESS_CART_ID'];
$cart_itemid 	= $_POST['cart_itemid'];
$new_qty 		= $_POST['new_qty'];

$unitprice 		= $db->rpgetValue("cartitems","unitprice"," id='".$cart_itemid."'");
$total_discount = $db->rpgetValue("cartitems","total_discount"," id='".$cart_itemid."'");


$totalprice		= ($new_qty * $unitprice);
$total_discount	= ($new_qty * $total_discount);
$finalprice 	= $totalprice - $total_discount;

$values = array(
	"qty"			=>	$new_qty,
	"unitprice"		=>	$unitprice,
	"totalprice"	=>	$totalprice,
	"finalprice"	=>	$finalprice,
);

$where = " id='".$cart_itemid."' AND cart_id='".$cart_id."'";
$db->rpupdate("cartitems",$values,$where);
?>