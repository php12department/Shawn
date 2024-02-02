<?php
include("connect.php");
$db->rpcheckAdminLogin();

$ctable 			= "events_comment";
$ctable1 			= "Event/News Comment";
$parent_page 		= "news-events"; //for sidebar active menu
$main_page 			= "manage-news-events"; //for sidebar active menu
$page_title 		= ucwords($_REQUEST['mode'])." ".$ctable1;
$manage_page_url 	= ADMINURL."manage-events-comment/".$_REQUEST['event_id']."/";

if(isset($_REQUEST['id']) && $_REQUEST['id']>0 && $_REQUEST['mode']=="delete")
{
	$where = " id='".$_REQUEST['id']."' AND event_id='".$_REQUEST['event_id']."'";
	$rows 	= array("isDelete" => "1");
	$db->rpupdate($ctable,$rows,$where);

	$_SESSION['MSG'] = 'Deleted';
	$db->rplocation($manage_page_url);	
}	
?>