<?php
include("connect.php");
$zip 		= $_POST['zip'];
$response 	= array();

	if(isset($zip) && $zip > 0)
	{
		$charges = $db->calculate_distance($zip);
		

		if ($charges['msg']=="success") {
		    $response['msg'] 			= 'success';
			$response['content'] 		= "";
			$response['charges'] 		= $charges['shipping_charges'];
			$response['shipping_id'] 	= $charges['shipping_id'];
			$response['distance'] 		= $charges['distance'];
		}else{
		    $response['msg'] 			= 'error';
			$response['content'] 		= "Please contact to admin ".$telephone_number." for shipping charge details";
			$response['shipping_id'] 	= $charges['shipping_id'];
			$response['charges'] 		= "0";
			$response['distance'] 		= "0";
		}
	}
	else
	{
		$response['msg'] 			= 'enter_zip';
		$response['content'] 		= "Please enter zipcode";
		$response['shipping_id'] 	= "0";
		$response['charges'] 		= "0";
		$response['distance'] 		= "0";
	}

echo json_encode($response);
die();
?>