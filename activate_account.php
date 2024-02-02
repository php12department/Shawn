<?php 
include('connect.php');

if(isset($_REQUEST['code']))
{

	$ctable_where = "activation_code = '".$_REQUEST['code']."' AND md5(id) = '".$_REQUEST['uid']."' AND isDelete=0 AND isActive = 0";

	$id = $db->rpgetValue("user",'id',$ctable_where);

	if($id > 0)

	{

		$rows 	= array(

			"isActive" => 1,

			"activation_code" => '',

		);

		$where	= "id = '".$id."' AND isDelete=0 AND isActive = 0 AND activation_code ='".$_REQUEST['code']."'";
		$db->rpupdate("user",$rows,$where);

		

		$_SESSION['MSG'] =  "ACC_CODE_SUCCESS";

		$db->rplocation(SITEURL."login/");

		exit;

	}

	else

	{

		$_SESSION['MSG'] =  "CODE_LINK_EXPIRE";

		$db->rplocation(SITEURL."login/");

		exit;

	}

}

else

{

	$_SESSION['MSG'] =  "CODE_LINK_EXPIRE";

	$db->rplocation(SITEURL."login/");

	exit;

}

?>