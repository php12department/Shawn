<?php 
include("connect.php");
include("include/notification.class.php");
//error_reporting(E_ALL);

//$paypal_response = @file_get_contents("php://input"); 
$paypal_encode_response = json_encode($_REQUEST); 

/*if(ISACTIVE_FORTEST_PAYPAL_RESPONSE)
{
	@mail(FORTEST_PAYPAL_RESPONSE_EMAIL, SITETITLE." Paypal Response ", $paypal_encode_response);

	$file_name = "newfile-".rand(111,999).".txt";
	$myfile = fopen("paypal-response-files/".$file_name, "w") or die("Unable to open file!");
	$txt = "Paypal Response Start\n".$paypal_encode_response;
	fwrite($myfile, $txt);
	$txt = "Paypal Response End\n";
	fwrite($myfile, $txt);
	fclose($myfile);
}*/


$data = json_decode($paypal_encode_response,true);

//print_r($data);
if(isset($data))
{
	if($data['payment_status'] == 'Completed')
	{
		$dis_pro	 		= explode("##", $data['custom']);
		$custom_arr  	 	= explode(",", $dis_pro[0]);
		$pro_arr  	 		= explode(",", $dis_pro[1]);
           
		$user_id 			= $custom_arr[0];
		$cart_id 			= $custom_arr[1];
		$finaltotal 		= $custom_arr[2];
		$shipping_charge 	= $custom_arr[3];
		$total_discount 	= $custom_arr[4];
		$count 				= $custom_arr[5];
		$email 		        = $custom_arr[6];
        
		if(isset($user_id) && isset($cart_id) && $cart_id > 0 )
		{			
			$total_amount 		= $data['mc_gross'];
			$txn_id 			= $data['txn_id'];

			$adate	=	date('Y-m-d H:i:s');
			$row1  	=  array(
							"orderstatus"	=>	2,
							"orderdate"		=>	$adate,
						);
			$db->rpupdate("cartdetails",$row1,"cart_id='".$cart_id."' AND uid='".$user_id."'");
			
			$row2  =  array("orderstatus" => 2);
			$db->rpupdate("cartitems",$row2,"cart_id='".$cart_id."' AND uid='".$user_id."'");

			$title = "";
			$rows = array(
				"user_id",
				"cart_id",
				"payment_type",
				"price",
				"title",
				"payment_status",
				"payment_date",
				"response",
				"txn_id",
			);
			$values = array(
				$user_id,
				$cart_id,
				"1",
				$total_amount,
				$title,
				1,
				$adate,
				addslashes($paypal_encode_response),
				$txn_id,
			); 
            
			$db->rpinsert("payment_history",$values,$rows);
			
			$cartdetails_r = $db->rpgetData("cartdetails","*","cart_id='".$cart_id."'");
	        $cartdetails_d = mysqli_fetch_array($cartdetails_r);
	       
	        $payment_r  = $db->rpgetData("payment_history","*","cart_id='".$cart_id."' AND user_id='".$user_id."'","cart_id desc");
            $payment_d  = @mysqli_fetch_array($payment_r);
           
           
			$mail = new Notification();
			include("mailbody/order_placed_invoice.php");
			
		    $toemail = $email;
			$subject = "Order #".$cart_id." was placed successfully";
			
			$mail->rpsendEmail($toemail,$subject,$body);
			
			$nt = new Notification();
			include("mailbody/order_placed_invoice_admin.php");
			
			$toemail_admin = SITEMAIL;
			$subject_admin = "Received New Order #".$cart_id;
			$nt->rpsendEmail($toemail_admin,$subject_admin,$body_admin);
		}
	}
}
?>