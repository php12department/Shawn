<?php
include('connect.php'); 
$ctable = "subscription";
$return_data = array();
if(!empty($_REQUEST['action'] && $_REQUEST['action'] =="Addsubscription"))
{
	$email 		= $_REQUEST['email'];
	$ipaddress 	=  $db->rpget_client_ip();
    
    $dup_where = "email = '".$email."' AND isDelete=0";
	$r = $db->rpdupCheck($ctable,$dup_where);
	if($r)
	{
		$return_data['msg']     = "duplicate_subscribe";
	}
	else
	{
		$rows       =   array('email',"ipaddress");
		$values     =   array($email,$ipaddress);
		$data = $db->rpinsert($ctable,$values,$rows);

		$return_data['msg']  = "success_subscribe";   
	}
	
	echo json_encode($return_data);
	exit;
}
?>