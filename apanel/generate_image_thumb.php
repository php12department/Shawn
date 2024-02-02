<?php
include("connect.php");
$db->rpcheckAdminLogin();
include('../include/resize_image.php');
$image = new SimpleImage(); 


//code for create alter product thumb

$ALT_IMAGEPATH_T 			= PRODUCT_ALT_T;
$ALT_IMAGEPATH_A 			= PRODUCT_ALT_A;
$ALT_IMAGEPATH 				= PRODUCT_ALT;
$ALT_IMAGEPATH_THUMB_A  	= PRODUCT_ALT_THUMB_A;
$ALT_IMAGEPATH_LIST_THUMB_A = PRODUCT_ALT_LIST_THUMB_A;

$alt_pro_r = $db->rpgetData("alt_image","image_path","isDelete = 0","id ASC LIMIT 0,50");
$count = 1;
echo "process start"."<br>";
while($alt_prod_d = @mysqli_fetch_array($alt_pro_r))
{
	$alt_image_path = stripslashes($alt_prod_d['image_path']);

	if($alt_image_path!="" && file_exists($ALT_IMAGEPATH_A.$alt_image_path))
	{
		$image->createThumbnail($alt_image_path,154,106,$ALT_IMAGEPATH_A.$alt_image_path,$ALT_IMAGEPATH_THUMB_A.$alt_image_path);

		$image->createThumbnail($alt_image_path,270,200,$ALT_IMAGEPATH_A.$alt_image_path,$ALT_IMAGEPATH_LIST_THUMB_A.$alt_image_path);
	}
	$count++;
}

echo $count."=&nbsp=".date("h:i A");



//code for create product thumb

/*$IMAGEPATH_T 				= PRODUCT_T;
$IMAGEPATH_A 				= PRODUCT_A;
$IMAGEPATH 					= PRODUCT;
$IMAGEPATH_THUMB_A 			= PRODUCT_THUMB_A;
$IMAGEPATH_LIST_THUMB_A 	= PRODUCT_LIST_THUMB_A;

$pro_r = $db->rpgetData("product","image","isDelete = 0","id ASC LIMIT 350,50");
$count = 1;
echo "process start"."<br>";
while($prod_d = @mysqli_fetch_array($pro_r))
{
	$image_path = stripslashes($prod_d['image']);

	if($image_path!="" && file_exists($IMAGEPATH_A.$image_path))
	{
		$image->createThumbnail($image_path,154,106,$IMAGEPATH_A.$image_path,$IMAGEPATH_THUMB_A.$image_path);

		$image->createThumbnail($image_path,270,200,$IMAGEPATH_A.$image_path,$IMAGEPATH_LIST_THUMB_A.$image_path);
	}
	$count++;
}

echo $count."=&nbsp=".date("h:i A");*/
?>