<?php
include("connect.php");
include("include/notification.class.php");

$email 		= $db->clean($_POST['form_email']);
$password 	= $db->clean($_POST['form_password']);

if($email!="" && $password!="" && !filter_var($email, FILTER_VALIDATE_EMAIL) === false)
{
	$check_user_r = $db->rpgetData("user","id,first_name,isActive,status","email = '".$email."' AND  password = '".md5($password)."' AND isDelete=0 ");
	
	if(@mysqli_num_rows($check_user_r)>0)
	{
        
		$check_user_d = @mysqli_fetch_array($check_user_r);
		
		if($check_user_d['isActive']==1)
		{
			if($check_user_d['status']=="N")
            {
                $_SESSION['MSG'] = 'Acc_Suspended';
				$db->rplocation(SITEURL."login/");
            }
            else
            {
            	$id 			=  $check_user_d['id'];
				$first_name 	=  $check_user_d['first_name'];
				
				$_SESSION[SESS_PRE.'_SESS_USER_ID'] 	= 	$id;
				$_SESSION[SESS_PRE.'_SESS_USER_NAME'] 	= 	$first_name;
				$last_login 							= 	date('Y-m-d H:i:s');

				$rows= array(
						"last_login"=> $last_login,
					);
				$where			= "id='".$id."' AND isDelete=0 ";
				$update_record 	=$db->rpupdate("user",$rows,$where);
				
				$db->rplocation(SITEURL."my-account/");
            }
		}
		else
		{
		    
		    
			$uid 				=  	$check_user_d['id'];
			$activation_code	= 	$db->generateRandomString(8);
            
			$rows 	= array(
				"activation_code" => $activation_code,
			);

			$where	= "id = '".$uid."' AND isDelete=0";
			$details_update = $db->rpupdate("user",$rows,$where);

			if($details_update)
			{	
				$subject = SITETITLE."Activate Your Account";
				$nt = new Notification();
				include("mailbody/signup_str.php");
				$toemail = $email;
				$nt->rpsendEmail($toemail,$subject,$body);
			}

			$_SESSION['MSG'] = 'Acc_Not_Verified';
			$db->rplocation(SITEURL."login/");
		}
	}
	else
	{
		$_SESSION['MSG'] = 'Invalid_Email_Password';
		$db->rplocation(SITEURL."login/");
	}
}
else
{
	$_SESSION['MSG'] = 'Something_Wrong';
	$db->rplocation(SITEURL."login/");
}
?>