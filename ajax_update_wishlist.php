<?php
include("connect.php");
$pid 		= $_POST['pid'];
$adate 		= date("Y-m-d H:i:s");
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
			
			$response['msg'] 		= 'remove'; //echo "2";die;
			$response['content'] 	= '<i class="fa fa-heart-o" aria-hidden="true"></i>';
		}
		else
		{
			$rows 	= array(
						"product_id",
						"user_id",
						"adate",
					);

			$values = array(
						$pid,
						$uid,
						$adate,
					);

			$db->rpinsert("wishlist",$values,$rows);
			
			$response['msg'] 		= 'add'; //echo "1";die;
			$response['content'] 	= '<i class="fa fa-heart" aria-hidden="true"></i>';
		}
	}
	else
	{
		$_SESSION['MSG'] 		= "Something_Wrong"; //echo "3";die;
		$response['msg'] 		= 'error';
		$response['content'] 	= "";
	}
}
else
{
	$_SESSION['MSG'] = "LOGIN_REQUIRE"; //echo "0";die;
	$response['msg'] 		= 'login_error';
}

echo json_encode($response);
die();
?>