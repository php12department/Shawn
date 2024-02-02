<?php
include("connect.php");
//$db->rpcheckLogin();

include("include/notification.class.php");
include("stripe_define.php");
require 'stripe_new/init.php';

$response_data = array();
$dataArr = @unserialize($_POST['data']);
$uid	 = ($_SESSION[SESS_PRE.'_SESS_USER_ID'])?$_SESSION[SESS_PRE.'_SESS_USER_ID']:0; 

if(isset($_SESSION[SESS_PRE.'_SESS_CART_ID']))
{
	$fname				= $db->clean($dataArr['fname']);
	$lname				= $db->clean($dataArr['lname']);
	$email				= $dataArr['email'];
	$phone				= $db->clean($dataArr['phone']) ;
	$address1			= $db->clean($dataArr['address']);
	$city				= $db->clean($dataArr['city']);
	$state				= $db->clean($dataArr['state']);
	$country			= $db->clean($dataArr['country']);
	$shipping_charge 	= addslashes(trim($dataArr['shipping_charge']));
	$shipping_id 		= addslashes(trim($dataArr['shipping_id']));
	$distance 			= addslashes(trim($dataArr['distance']));
	$final_total 		= addslashes(trim($dataArr['finaltotal']));
    $tax_amount         = addslashes(trim($dataArr['tax_amount']));
    $tax_percentage     = addslashes(trim($dataArr['tax_percentage']));
	$zip 				= addslashes(trim($dataArr['zipcode']));
	
	//$name_on_card 	    = $db->clean($dataArr['name_on_card']);
	$card_no 			= $db->clean($dataArr['card_number']);
	$card_exp_month 	= $db->clean($dataArr['mm']);
	$card_exp_year 		= $db->clean($dataArr['yy']);
	$card_cvv 			= $db->clean($dataArr['cvv']);
	
	$Reference 			= mt_rand(100000, 999999);
	$reg_ip				= $db->rpget_client_ip();

	$cartdetails_r = $db->rpgetData("cartdetails","*","cart_id='".$_SESSION[SESS_PRE.'_SESS_CART_ID']."'");
	$cartdetails_d = mysqli_fetch_array($cartdetails_r);
	
	$finaltotal 		= $cartdetails_d['finaltotal'];
	
	//echo "<pre>";print_r($dataArr);die();
	if(isset($dataArr['place_order']) && isset($dataArr['pay_method']))
	{
		if($dataArr['pay_method'] == "paypal")
		{
			$adate	= date("Y-m-d H:i:s");
			$rows 	= array(
						"uid"				=> $uid,
						"fname"				=> $fname,
						"lname"				=> $lname,
						"email"				=> $email,
						"phone"				=> $phone,
						"address1"			=> $address1,
						"zip"				=> $zip,
						"city"				=> $city,
						"state"				=> $state,
						"country"			=> $country,
						"finaltotal"		=> $final_total,
						"shipping_charge"	=> $shipping_charge,
                        "tax_percentage"    => $tax_percentage,
                        "tax_amount"        => $tax_amount,
						"shipping_id"		=> $shipping_id,
						"distance"			=> $distance,
						"orderdate"			=> $adate,
					);
			
			$where	= "cart_id='".$_SESSION[SESS_PRE.'_SESS_CART_ID']."'";
			$db->rpupdate("cartdetails",$rows,$where);
		
			$response_data['msg'] = "psuccess";
			
		}
        else if($dataArr['pay_method'] == "credit_card")
        {
            $key = \Stripe\Stripe::setApiKey($pri_key);
            $amount_cents = $final_total * 100;  // Chargeble amount
    
            try 
            {
    
                $token = \Stripe\PaymentMethod::create([
                        'type' => 'card',
                        'card' => [
                            'number'    => $card_no,
                            'exp_month' => $card_exp_month,
                            'exp_year'  => $card_exp_year,
                            'cvc'       => $card_cvv
                        ]
                    ]);
    
                $intent = \Stripe\PaymentIntent::create([
                        'amount'                => $amount_cents,
                        'currency'              => STRIPE_CURRENCY_CODE,
                        //"description"           => $description,
                        'payment_method_types'  => ['card'],
                        "receipt_email"         =>  $email,
                        "metadata"              => array(
                                                    "first_name"    => $fname,
                                                    "last_name"     => $lname,
                                                    "email"         => $email,
                                                    "phone"         => $phone,
                                                    "address1"      => $address1,
                                                    /*"address_other"   => $address_other,*/
                                                    "zip"           => $zip,
                                                    "city"          => $city,
                                                    "state"      => $state,
                                                    "country"       => $country
                                                ),
                        'payment_method' => $token->id,
                        'confirm' => true,
                    ]);
    
    
                $stripe_transaction_id  = $intent->charges['data'][0]['balance_transaction'];
                $stripe_charge_id       = $intent->charges['data'][0]['id'];
                $result                 =   "success";
    
                
            }
    
            catch(\Stripe\CardError $e) {   
    
            $error = $e->getMessage();
    
            $result = $error;
    
    
    
            } catch (\Stripe\InvalidRequestError $e) {
    
                $error = $e->getMessage();
    
                $result = $error;  
    
            } catch (\Stripe\AuthenticationError $e) {
    
                $error = $e->getMessage();
    
                $result = $error;
    
            } catch (\Stripe\ApiConnectionError $e) {
    
                $error = $e->getMessage();
    
                $result = $error;
    
            } catch (\Stripe\Error $e) {
    
                $error = $e->getMessage();
    
                $result = $error;
    
            } catch (Exception $e) {
    
            
    
                if ($e->getMessage() == "zip_check_invalid") {
    
                    $result = "declined1";
    
                } else if ($e->getMessage() == "address_check_invalid") {
    
                    $result = "decline2d";
    
                } else if ($e->getMessage() == "cvc_check_invalid") {
    
                    $result = "declined3";
    
                } else {
    
                    $result = $e->getMessage();
    
                }
    
            }
    
            //echo $result; die();
    
            if($result=="success")
            {
    
                $adate  = date("Y-m-d H:i:s");
    
                $rows   = array(
    
                            "uid"               => $uid,
    
                            "fname"             => $fname,
    
                            "lname"             => $lname,
    
                            "email"             => $email,
    
                            "phone"             => $phone,
    
                            "address1"          => $address1,
    
                            /*"address_other"       => $address_other,*/
    
                            "zip"               => $zip,
    
                            "city"              => $city,
    
                            "state"              => $state,
    
                            "country"           => $country,
                            "finaltotal"        => $final_total,
                            "shipping_charge"   => $shipping_charge,
                            "tax_percentage"    => $tax_percentage,
                            "tax_amount"        => $tax_amount,
                            "shipping_id"       => $shipping_id,
                            "distance"          => $distance,
                            "orderdate"         => $adate,
                            "orderstatus"       => "2",
                        );
                    
                $where  = "cart_id='".$_SESSION[SESS_PRE.'_SESS_CART_ID']."'";
                $db->rpupdate("cartdetails",$rows,$where);
    
                $row2  =  array("orderstatus" => 2);
                $db->rpupdate("cartitems",$row2,"cart_id='".$_SESSION[SESS_PRE.'_SESS_CART_ID']."'");

                $title = "";
                $pay_history_rows = array(
                    "user_id",
                    "cart_id",
                    "payment_type",
                    "price",
                    "title",
                    "payment_status",
                    "payment_date",
                    "response",
                    "txn_id",
                    "stripe_charge_id",
                    "stripe_transaction_id",
                );
                $pay_history_values = array(
                    $uid,
                    $_SESSION[SESS_PRE.'_SESS_CART_ID'],
                    "2",
                    $final_total,
                    $title,
                    1,
                    $adate,
                    "",
                    "",
                    $stripe_charge_id,
                    $stripe_transaction_id,
                ); 
                
                $db->rpinsert("payment_history",$pay_history_values,$pay_history_rows);


                $cartdetails_r = $db->rpgetData("cartdetails","*","cart_id='".$_SESSION[SESS_PRE.'_SESS_CART_ID']."'");
                $cartdetails_d = mysqli_fetch_array($cartdetails_r);
               
                $payment_r  = $db->rpgetData("payment_history","*","cart_id='".$_SESSION[SESS_PRE.'_SESS_CART_ID']."' AND user_id='".$uid."'","cart_id desc");
                $payment_d  = @mysqli_fetch_array($payment_r);
               
               
                $mail = new Notification();
                include("mailbody/order_placed_invoice.php");
                
                $toemail = $email;
                $subject = "Order #".$_SESSION[SESS_PRE.'_SESS_CART_ID']." was placed successfully";
                
                $mail->rpsendEmail($toemail,$subject,$body);
                
                $nt = new Notification();
                include("mailbody/order_placed_invoice_admin.php");
                
                $toemail_admin = SITEMAIL;
                $subject_admin = "Received New Order #".$_SESSION[SESS_PRE.'_SESS_CART_ID'];
                $nt->rpsendEmail($toemail_admin,$subject_admin,$body_admin);


                unset($_SESSION[SESS_PRE.'_SESS_CART_ID']);
                $_SESSION['MSG']      = "PLACE_ORDER";
                $response_data['msg'] = "stripe_success";
            }
    
            else
    
            {
    
                $_SESSION['MSG']            = "STRIPE_ERROR";
    
                $_SESSION['STRIPE_ERROR']   = $result;
    
                $response_data['msg']       = "stripe_error";
    
            }
    
        }
		else
		{
			$response_data['msg'] = "pay_method_error";
		}
		
	}
	else
	{
		$response_data['msg'] = "pay_method_error";
	}
}
else
{
	$response_data['msg'] = "error";
}

echo json_encode($response_data); 
exit;
?>