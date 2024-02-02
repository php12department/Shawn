<?php
include("connect.php");
$db->rpcheckAdminLogin();

$ctable 			= "submission";
$ctable1 			= "Submission";
$parent_page 		= "submission"; //for sidebar active menu
$main_page 			= "manage-customer-gallary"; //for sidebar active menu
$page_title 		= ucwords($_REQUEST['mode'])." ".$ctable1;
$manage_page_url 	= ADMINURL."manage-customer-gallary/";

if(isset($_REQUEST['id']) && $_REQUEST['id']>0 && $_REQUEST['mode']=="delete")
{
	$id 	= $_REQUEST['id'];
	$rows 	= array("isDelete" => "1");
	$db->rpupdate($ctable,$rows,"id='".$id."'");

	$_SESSION['MSG'] = 'Deleted';
	$db->rplocation($manage_page_url);	
}		
?>