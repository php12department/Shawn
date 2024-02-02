<?php
include("connect.php");
$db->rpcheckAdminLogin();

$ctable 			= "subscription";
$ctable1 			= "Subscriber";
$parent_page 		= "subscriber"; //for sidebar active menu
$main_page 			= "manag
e-subscriber"; //for sidebar active menu
$page_title 		= ucwords($_REQUEST['mode'])." ".$ctable1;
$manage_page_url 	= ADMINURL."manage-subscriber/";
$add_page_url 		= ADMINURL."add-subscriber/add/";
$edit_page_url 		= ADMINURL."add-subscriber/edit/".$_REQUEST['id']."/";

if(isset($_REQUEST['id']) && $_REQUEST['id']>0 && $_REQUEST['mode']=="delete")
{
	$id 	= $_REQUEST['id'];
	$rows 	= array("isDelete" => "1");
	
	$db->rpupdate($ctable,$rows,"id='".$id."'");
	
	$_SESSION['MSG'] = "Deleted";
	$db->rplocation($manage_page_url);
	exit;
}
?>