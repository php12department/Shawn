<?php
include("connect.php");

$first_name 	= $db->clean($_POST['first_name']);
$last_name 		= $db->clean($_POST['last_name']);
$email 			= $db->clean($_POST['email']);
$phone 			= $db->clean($_POST['phone']);
$address 		= $db->clean($_POST['address']);
$city 			= $db->clean($_POST['city']);
$state 			= $db->clean($_POST['state']);
$country 		= $db->clean($_POST['country']);
$zipcode 		= $db->clean($_POST['zipcode']);

$ctable="user";


	$rows 	= array(
			"first_name" 	=>$first_name,
			"last_name"		=>$last_name,
			"email"			=>$email,
			"phone"			=>$phone,
			"address"		=>$address,
			"city"			=>$city,
			"state"			=>$state,
			"country"		=>$country,
			"zipcode"		=>$zipcode,
		);
	
	
	$where	= "id='".$_SESSION[SESS_PRE.'_SESS_USER_ID']."' AND isDelete=0";
	$last_id=	$db->rpupdate($ctable,$rows,$where);
	
	if($last_id!='')
	{
		$_SESSION['MSG'] = "changes_saved";
		$db->rplocation(SITEURL."my-account/");
		exit;
	}
	else
	{
		$_SESSION['MSG'] = "Something_Wrong";
		$db->rplocation(SITEURL."my-account/");
		exit;
	}

?>