<?php
include("connect.php");
$db->rpcheckAdminLogin();

$ctable 			= "product_review";
$ctable1 			= "Product Review";
$parent_page 		= "product-master"; //for sidebar active menu
$main_page 			= "manage-product"; //for sidebar active menu
$page_title 		= ucwords($_REQUEST['mode'])." ".$ctable1;
$manage_page_url 	= ADMINURL."manage-product-review/".$_REQUEST['pid']."/";

if(isset($_REQUEST['id']) && $_REQUEST['id']>0 && $_REQUEST['mode']=="delete")
{
	$where = " id='".$_REQUEST['id']."' AND pid='".$_REQUEST['pid']."'";
	$rows 	= array("isDelete" => "1");
	$db->rpupdate($ctable,$rows,$where);

	$_SESSION['MSG'] = 'Deleted';
	$db->rplocation($manage_page_url);	
}	
?>