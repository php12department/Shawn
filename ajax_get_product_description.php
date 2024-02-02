<?php
include("connect.php");
$pid 				= $_POST['pid'];
$response 			= array();

	if(isset($pid) && $pid > 0 )
	{
		$where = " id='".$pid."' AND isDelete=0";
		$ctable_r = $db->rpgetData("product","*",$where);
		$ctable_d = @mysqli_fetch_array($ctable_r);
        
        
		$pro_decs               = stripslashes($ctable_d['decs']);
		$pro_feature_dimension  = stripslashes($ctable_d['feature_dimension']);
		$pro_additional_info    = stripslashes($ctable_d['additional_info']); 
		$meta_title             = stripslashes($ctable_d['meta_title']);
        $meta_description       = stripslashes($ctable_d['meta_description']);
        $meta_keywords          = stripslashes($ctable_d['meta_keywords']);
        
		$response['msg'] 					= 'success';
        $response['decs'] 					= base64_encode($pro_decs);
        $response['feature_dimension'] 		= base64_encode($pro_feature_dimension);	
        $response['additional_info'] 		= base64_encode($pro_additional_info);	
        $response['meta_title'] 			= base64_encode($meta_title);	
        $response['meta_description'] 		= base64_encode($meta_description);	
        $response['meta_keywords'] 			= base64_encode($meta_keywords);	
	}
	else
	{
		$response['msg'] 					= 'error';
		$response['decs'] 					= "";
        $response['feature_dimension'] 		= "";	
        $response['additional_info'] 		= "";
        $response['meta_title'] 			= "";	
        $response['meta_description'] 		= "";	
        $response['meta_keywords'] 			= "";
	}

//print_r($response);die();
echo json_encode($response);
die();
?>