<?php
include("connect.php");
include("include/notification.class.php");

$first_name 				= 	$db->clean($_POST['form_name']);
$last_name  				=	$db->clean($_POST['form_last_name']);
$phone  					=	$db->clean($_POST['form_phone']);
$email 						= 	$db->clean($_POST['email']);
$password 					= 	md5($db->clean($_POST['password']));
$confirm_password 			= 	md5($db->clean($_POST['confirm_password']));
$agree_newsletter_email 	= 	$db->clean($_POST['agree_newsletter_email']);
$reg_ip						= 	$db->rpget_client_ip();
$activation_code			= 	$db->generateRandomString(8);


if($first_name !='' && $last_name !='' && $phone !='' && $email!="" && $password!="" && !filter_var($email, FILTER_VALIDATE_EMAIL) === false)
{
	if($password != $confirm_password)
	{
		$_SESSION['MSG'] = "CONFORM_PASS";
		$db->rplocation(SITEURL."login/");
		exit;
	}
	else
	{
		$dup_where = "email = '".$email."'";
		$r = $db->rpdupCheck("user",$dup_where);
		if($r)
		{
			$_SESSION['MSG'] = "Duplicate_User";
			$db->rplocation(SITEURL."login/");
			exit;
		}
		else
		{
			$rows 	= array(
					"first_name",
					"last_name",
					"email",
					"password",
					"agree_newsletter_email",
					"reg_ip",
					"activation_code",
					"status",
				);
			$values = array(
					$first_name,
					$last_name,
					$email,
					$password,
					$agree_newsletter_email,
					$reg_ip,
					$activation_code,
					"Y",
				);

			$uid =  $db->rpinsert("user",$values,$rows);
		
			if($uid!='')
			{
				$subject = SITETITLE." Activate Your Account";
				$nt = new Notification();
				include("mailbody/signup_str.php");
				$toemail = $email;
				$nt->rpsendEmail($toemail,$subject,$body);

				$_SESSION['MSG'] = "Success_Signup";
				//$db->rplocation(SITEURL."login/");
				//exit;
				?>
				<script>
				location.href = '<?php echo SITEURL."login/"; ?>';
				</script>
				<?php
			}
			
		}
	}
}
else
{
	$_SESSION['MSG'] = 'FILL_ALL_DATA';
	$db->rplocation(SITEURL."login/");
}
?>