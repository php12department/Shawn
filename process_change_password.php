<?php
include("connect.php");

$password 	= md5($db->clean($_POST['new_password']));

$ctable="user";


	$rows 	= array(
			"password" 	=>$password,
		);
	
	
	$where	= "id='".$_SESSION[SESS_PRE.'_SESS_USER_ID']."' AND isDelete=0";
	$last_id=  $db->rpupdate($ctable,$rows,$where);
	
	if($last_id!='')
	{
		$_SESSION['MSG'] = "password_change";
		$db->rplocation(SITEURL."change-password/");
		exit;
	}
	else
	{
		$_SESSION['MSG'] = "Something_Wrong";
		$db->rplocation(SITEURL."change-password/");
		exit;
	}

?>