<?php
include("connect.php");
$ctable = 	"user";
$current_password 	= 	md5($db->clean($_POST['current_password']));

$check_dup = $db->rpgetData($ctable,'id',"(password = '".$current_password."' ) AND isDelete='0'","");	
if(@mysqli_num_rows($check_dup) > 0)
{
	echo 1;
}
else	
{
	echo 0;
}
?>
