<?php 
$page = "shopping-cart";
include("connect.php"); 

if(isset($_SESSION[SESS_PRE.'_SESS_CART_ID']) && isset($_POST['cl']) && $_POST['cl']>0)
{
	$where = " cart_id='".$_SESSION[SESS_PRE.'_SESS_CART_ID']."'";
	if($db->rpgetTotalRecord("cartitems",$where)>0)
	{	
		$db->rpdelete("cartitems",$where);
	}
}
else
{
	if(isset($_SESSION[SESS_PRE.'_SESS_CART_ID']) && isset($_POST['val1']) && isset($_POST['val2']) && $_POST['val1']>0 && $_POST['val2']>0)
	{
		$where = " id='".$_POST['val1']."' AND pid='".$_POST['val2']."' AND cart_id='".$_SESSION[SESS_PRE.'_SESS_CART_ID']."'";
		$db->rpdelete("cartitems",$where); 
	}
}
?>