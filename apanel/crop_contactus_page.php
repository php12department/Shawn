<?php
header('Content-Type: application/json');
include("connect.php"); 

$IMAGENM_SLUG 		= "-contactus-";
$IMAGEPATH_T        = CONTACTUS_PAGE_T;
$IMAGEPATH_A        = CONTACTUS_PAGE_A; 

$error					= false;
$absolutedir			= dirname(__FILE__);
$dir					= $IMAGEPATH_A;
$serverdir				= $absolutedir.$dir;
$tmp					= explode(',',$_POST['data']);
$imgdata 				= base64_decode($tmp[1]);
$extension				= strtolower(end(explode('.',$_POST['name'])));


if(isset($_SESSION['image_path1']) && $_SESSION['image_path1']!="")
{
	unlink($IMAGEPATH_T.$_SESSION['image_path1']);
}

$filename				= time()."_".rand(1,9999999).$IMAGENM_SLUG.".".$extension;

if ($_POST['name'] != "") {
	
	$_SESSION['image_path1']=$filename;
	
	$handle					= fopen($IMAGEPATH_T.$filename,'w');
	fwrite($handle, $imgdata);
	fclose($handle);
	$response = array(
			"status" 		=> "success",
			"url" 			=> $IMAGEPATH_T.$filename.'?'.time(),
			"filename" 		=> $filename
	);
}
print json_encode($response);