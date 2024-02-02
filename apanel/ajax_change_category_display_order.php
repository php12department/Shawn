<?php
$ctable 	= "category";
include("connect.php");

//echo "<pre>"; print_r($_POST["page_id_array"]); exit;
for($i=0; $i<count($_POST["page_id_array"]); $i++)
{
	$rows 	= array(
			"display_order"	=> $i,
		);

	$where	= "id=".$_POST["page_id_array"][$i];
	$db->rpupdate($ctable,$rows,$where);
}
//echo 'Display Order has been updated'; 
?>