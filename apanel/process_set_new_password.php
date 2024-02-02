<?php
include("connect.php");
$id 		= $db->clean($_POST['id']);
$slug 		= $db->clean($_POST['slug']);
$newpass 	= $db->clean($_POST['newpass']);

if($id != '' && $slug!="" && $newpass!="")
{
	$check_user = $db->rpgetData(CTABLE_ADMIN,"*","md5(id) = '".$id."' AND forgotpass_string='".$slug."'");
	if(@mysqli_num_rows($check_user) > 0)
	{
		$rows 	= array(
						"password"			=> md5($newpass),
						"forgotpass_string" =>"0"
					);
		$db->rpupdate(CTABLE_ADMIN,$rows,"md5(id)='".$id."'");
		
		$_SESSION['MSG'] = 'Update_Pass';
		$db->rplocation(ADMINURL."login/");
		
	}
	else
	{
		$_SESSION['MSG'] = 'Link_Expired';
		$db->rplocation(ADMINURL."forgetpassword/");
	}
}
else
{
	$_SESSION['MSG'] = "INVALID_DATA";
	$db->rplocation(ADMINURL."setnewpassword/".$id."/".$slug."/");
	exit;
}
?>