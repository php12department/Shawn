<?php
include("connect.php");
$country_id 		= $_POST['country_id'];
$response 			= array();
$response['html'] 	= "";

if(isset($country_id) && $country_id > 0)
{
	$html = '<option value="">Please select option</option>';
	$state_r = $db->rpgetData("state","*","country_id='".$country_id."' AND isDelete=0","name ASC");
    if(@mysqli_num_rows($state_r)>0)
    {
        while($state_d = @mysqli_fetch_array($state_r))
        {
        $html.='<option value="'.$state_d['id'].'">'.$state_d['name'].'</option>';
        }
    }
	$response['msg'] 	= 'success';
	$response['html'] 	= $html;
}

echo json_encode($response);
die();
?>