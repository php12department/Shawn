<?php

include("connect.php");
include("include/notification.class.php");  

$ename          = 	$db->clean($_POST['ename']);
$eemail  	    =	$db->clean($_POST['eemail']);
$esubject 	    = 	$db->clean($_POST['esubject']);
$eletter 	    = 	$db->clean($_POST['eletter']);
$pid    	    = 	$db->clean($_POST['pid']);
$user_id    	= 	$db->clean($_POST['user_id']);
$product_url    = 	$db->clean($_POST['product_url']);


if($ename !='' && $eemail !='' && $esubject !='' && $eletter!="" && !filter_var($eemail, FILTER_VALIDATE_EMAIL) === false)
{
		$dup_where = "eemail = '".$eemail."'";
		$r = $db->rpdupCheck("product_enquiry",$dup_where);
		if($r)
		{
			$_SESSION['MSG'] = "Duplicate_User";
			$db->rplocation($product_url);
			exit;
		}
		else
		{
			$rows 	= array(
					"ename",
					"eemail",
					"esubject",
					"eletter",
					"pid",
					"user_id",
				);
			$values = array(
					$ename,
					$eemail,
					$esubject,
					$eletter,
					$pid,
					$user_id,
				);
			$uid =  $db->rpinsert("product_enquiry",$values,$rows);
		
			if($uid!='')
			{
				$subject = SITETITLE." Product Enquiry";
				$nt = new Notification();
				include("mailbody/signup_str.php");
				$toemail = $eemail;
				$nt->rpsendEmail($toemail,$subject,$body);

				$_SESSION['MSG'] = "Success_product_enquiry";
				$db->rplocation($product_url);
				//exit;
				
			}
			
		}
	
}
else
{
	$_SESSION['MSG'] = 'FILL_ALL_DATA';
	$db->rplocation($product_url);
}
?>