<?php
include("connect.php");
$state 		        = $_POST['state'];
$response_data 		= array();

if(isset($state) && $state > 0)
{
	$state_r = $db->rpgetData("state","*","id='".$state."' AND isDelete=0");
    $state_d = @mysqli_fetch_array($state_r);

    $cartdetails_r = $db->rpgetData("cartdetails","*","cart_id='".$_SESSION[SESS_PRE.'_SESS_CART_ID']."'");
	$cartdetails_d = @mysqli_fetch_array($cartdetails_r);
	
	$tax_amount 			= $cartdetails_d['tax_amount'];
	$shipping_charge 		= $cartdetails_d['shipping_charge'];
	$finaltotal 			= $cartdetails_d['finaltotal'];

	$finaltotal = ($finaltotal - $shipping_charge - $tax_amount);

    if($state_d['is_taxable'] == 1)
    {
		$tax_percentage = $state_d['sales_tax'];
		$tax_amount 	= number_format((($finaltotal*$tax_percentage)/100),2);
    }
    else
    {
    	$tax_percentage = 0;
		$tax_amount 	= 0;
    }
    
    //update tax amount and tax percentage on final amount
    /*$rows 	= array(
		"tax_percentage"	=> $tax_percentage,
		"tax_amount"		=> $tax_amount,
	);
			
	$where	= "cart_id='".$_SESSION[SESS_PRE.'_SESS_CART_ID']."'";
	$db->rpupdate("cartdetails",$rows,$where);*/
		
	$response_data['msg'] 				= 'success';
	$response_data['tax_amount'] 		= $tax_amount;
	$response_data['tax_percentage'] 	= $tax_percentage;
}

echo json_encode($response_data);
//die();
?>