<?php
include("connect.php");
include("include/notification.class.php");

$ctable		= "user";
$email 		= $db->clean($_POST['form_email']);

if($email!="" && !filter_var($email, FILTER_VALIDATE_EMAIL) === false)
{
	$check_user_r = $db->rpgetData($ctable,"*","email = '".$email."' AND isDelete=0 ");
	if(@mysqli_num_rows($check_user_r)>0)
	{

		$check_user_d = @mysqli_fetch_array($check_user_r);
		$id 		=  $check_user_d['id'];
		$fname 		=  $check_user_d['first_name'];
		$email 		=  $check_user_d['email'];
		
		$random1 	= substr(md5(rand()), 0, rand(1,6));
		$random2 	= substr(md5(rand()), 0, rand(1,7));
		$random3 	= substr(md5(rand()), 0, rand(1,6));
		$random4 	= substr(md5(rand()), 0, rand(1,8));
		$fps		= rand(0,2).$random1.rand(0,3).$random2.rand(0,1).$random3.rand(0,3).$random4;
		
		$where		= "id='".$id."'";
		$rows 		= array("forgot_pass_string"=>$fps);
		$db->rpupdate("user",$rows,$where);
		
		if(ISMAIL)
		{
			$nt = new Notification();
			include("mailbody/forget_pass_str.php");
			$subject	= SITETITLE." Password Recovery";
			
			$toemail = $email;
			$nt->rpsendEmail($toemail,$subject,$body); 
		}
		
		$_SESSION['MSG'] = 'Success_Fsent';
		//$db->rplocation(SITEURL."login/");
		?>
		<script>
		location.href = '<?php echo SITEURL."login/"; ?>';
		</script>
		<?php
	}
	else
	{
		$_SESSION['MSG'] = 'No_Data_Found';
		$db->rplocation(SITEURL."forgetpassword/");
	}
}
else
{
	$_SESSION['MSG'] = 'Valid_Email';
	$db->rplocation(SITEURL."forgetpassword/");
}
?>