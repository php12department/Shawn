<?php 
include("connect.php");
$db->rpcheckAdminLogin();

$id = $db->clean($_POST['id']);
$status = $db->clean($_POST['status']);
$table_name = base64_decode( $db->clean($_POST['td']) );
$field = base64_decode( $db->clean($_POST['i']) );

$rows 	= array(
		"status" => $status
	);

$where	= $field." = ".$id;
$result = $db->rpupdate($table_name,$rows,$where);

if ($result > 0) 
{
    echo(json_encode(array('status'=>TRUE))); 
}
else 
{ 
    echo(json_encode(array('status'=>FALSE))); 
}
?>