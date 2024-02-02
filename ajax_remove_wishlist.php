<?php
include("connect.php");
$pid 		= $_POST['pid'];
$uid 		= $_SESSION[SESS_PRE.'_SESS_USER_ID'];	
$response 	= array();
	
if(isset($_SESSION[SESS_PRE.'_SESS_USER_ID']) && $_SESSION[SESS_PRE.'_SESS_USER_ID']!="")
{
	if(isset($pid) && $pid > 0)
	{
		$where = " product_id='".$pid."' AND user_id = '".$_SESSION[SESS_PRE.'_SESS_USER_ID']."'";
		if($db->rpgetTotalRecord("wishlist",$where) > 0)
		{
			$db->rpdelete("wishlist",$where);
			
			$get_wishlist_icon = $db->rpgetWishList($pid);

			$response['msg'] 		= 'remove'; //echo "2";die;
			$response['content'] 	= '';
		}
		else
		{
			$_SESSION['MSG'] 		= "Something_Wrong"; 
			$response['msg'] 		= 'error';
			$response['content'] 	= "";
		}
	}
	else
	{
			$_SESSION['MSG'] 		= "Something_Wrong"; 
			$response['msg'] 		= 'error';
			$response['content'] 	= "";
	}
	
}
else
{
	$_SESSION['MSG'] = "LOGIN_REQUIRE"; 
	$db->rplocation(SITEURL."login/");
	exit;
}

echo json_encode($response);
?>