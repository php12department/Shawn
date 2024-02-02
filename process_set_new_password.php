<?php
include("connect.php");

$id 		= $db->clean($_POST['id']);
$slug 		= $db->clean($_POST['slug']);
$password 	= $db->clean($_POST['password']);

if($id != '' && $slug!="" && $password!="")
{
	$check_user = $db->rpgetData("user","*","md5(id) = '".$id."' AND forgot_pass_string='".$slug."' AND isDelete=0");
	if(@mysqli_num_rows($check_user) > 0)
	{
		$rows 	= array(
						"password"			=> md5($password),
						"forgot_pass_string" => ""
					);
		$db->rpupdate("user",$rows,"md5(id)='".$id."' AND isDelete=0");
		
		$_SESSION['MSG'] = 'Update_Pass';
		$db->rplocation(SITEURL."login");
	}
	else
	{
		$_SESSION['MSG'] = 'Link_Expired';
		$db->rplocation(SITEURL."forgetpassword/");
	}
}
else
{
	$_SESSION['MSG'] = "INVALID_DATA";
	$db->rplocation(SITEURL."set-new-password/".$id."/".$slug."/");
	exit;
}
?>