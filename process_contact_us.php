<?php
include("connect.php");
include("include/notification.class.php");
//error_reporting(E_ALL);

$name 		= $db->clean($_POST['form_name']);
$email 		= $db->clean($_POST['form_email']);
$subject 	= $db->clean($_POST['form_subject']);
$message 	= $_POST['form_message'];

$ctable     = "contactus";

if($email!="" && $name!="" && $subject!="" && $message!="" && !filter_var($email, FILTER_VALIDATE_EMAIL) === false)
{
    
    if(!empty($_POST['g-recaptcha-response']))
    {
        $secret = '6LfGONEZAAAAAK1H4gTed2neDamLbD5FT4UWLle2';

        $data = array(
                'secret' =>$secret,
                'response' => $_REQUEST['g-recaptcha-response'],
            );
    
    	$verify = curl_init();
    	curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
    	curl_setopt($verify, CURLOPT_POST, true);
    	curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
    	curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
    	curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
    	$response = curl_exec($verify);
    	$responseData = json_decode($response);
        if($responseData->success)
        {
        	try 
        	{
                
            	$rows 	= array(
            			"name",
            			"email",
            			"subject",
            			"message",
            		);
            	$values = array(
            			$name,
            			$email,
            			$subject,
            			$message,
            		);
            
            	$last_id =  $db->rpinsert($ctable,$values,$rows);
            	
            	if($last_id!='')
            	{
            		if(ISMAIL)
            		{
            			$nt = new Notification();
            
            			$mail_subject = SITETITLE." Thank you for your inquiry";
            			include("mailbody/contactus_request_mail.php");
            			
            			$toemail = $email;
            			$nt->rpsendEmail($toemail,$mail_subject,$body);
            			
            			
            			$mail_subject = SITETITLE." received new inquiry from contact us";
            			include("mailbody/admin_contactus_request_mail.php");
            			
            			$nt->rpsendEmail(SITEMAIL,$mail_subject,$admin_body);
            		}
            		$_SESSION['MSG'] = "Success_Contactus_Request";
            		$db->rplocation(SITEURL."contact-us/");
            		exit;
            	}
        	}
        	catch (Exception $e) 
        	{
        	    $_SESSION['MSG'] = "recaptcha_error";
        	    $_SESSION['recaptcha_error_msg'] = $e->errorMessage();
        	    
        	    $db->rplocation(SITEURL."contact-us/");
        	}
        }
        else
        {
            $_SESSION['MSG'] = 'Something_Wrong';
	        $db->rplocation(SITEURL."contact-us/");
        }
    }
    else
    {
        $_SESSION['MSG'] = "recaptcha_error";
	    $_SESSION['recaptcha_error_msg'] = "Please check checkbox of recaptcha";
	    
	    $db->rplocation(SITEURL."contact-us/");
    }
}
else
{
	$_SESSION['MSG'] = 'Something_Wrong';
	$db->rplocation(SITEURL."contact-us/");
}
?>