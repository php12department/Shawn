<?php
include("connect.php");
$db->rpcheckAdminLogin();

$ctable 			= "user";
$ctable1 			= "User";
$parent_page 		= "user-master"; //for sidebar active menu
$main_page 			= "manage-user"; //for sidebar active menu
$page_title 		= ucwords($_REQUEST['mode'])." ".$ctable1;
$manage_page_url 	= ADMINURL."manage-user/";
$add_page_url 		= ADMINURL."add-user/add/";
$edit_page_url 		= ADMINURL."add-user/edit/".$_REQUEST['id']."/";

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