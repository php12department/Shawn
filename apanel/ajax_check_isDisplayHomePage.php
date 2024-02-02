<?php
include("connect.php");
$id 				= $_POST["id"];
$isDisplayHomePage 	= $_POST["isDisplayHomePage"];

if($isDisplayHomePage == 1)
{
	if($id!="0")
	{
		$where = "isDelete=0 AND isDisplayHomePage=1 AND id!='".$id."'";
	}
	else
	{
		$where = "isDelete=0 AND isDisplayHomePage=1";
	}

	$total_record = $db->rpgetTotalRecord("product",$where);
	if($total_record >= 4)
	{
		echo json_encode("You have already selected 4 products. If you want to select this product, please unselect any one product from selected product.");
	}
	else
	{
		echo json_encode(true);
	}
}
else
{
	echo json_encode(true);
}
?>