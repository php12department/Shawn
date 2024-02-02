<?php
ob_start();
error_reporting(0);
// error_reporting(E_ALL);
session_start();

include("include/define.php");
include("include/function.class.php");

$db = new Cart();
//$db1 = new Admin();

$site_setting_r = $db->rpgetData("site_setting","*","id=1");
$site_setting_d = @mysqli_fetch_array($site_setting_r);

$address                    = nl2br($site_setting_d['address']);
$email_address              = stripslashes($site_setting_d['email_address']);
$telephone_number           = stripslashes($site_setting_d['telephone_number']);
$store_hours_monday         = stripslashes($site_setting_d['store_hours_monday']);
$store_hours_tuesday        = stripslashes($site_setting_d['store_hours_tuesday']);
$store_hours_wednesday      = stripslashes($site_setting_d['store_hours_wednesday']);
$store_hours_thursday       = stripslashes($site_setting_d['store_hours_thursday']);
$store_hours_friday         = stripslashes($site_setting_d['store_hours_friday']);
$store_hours_saturday       = stripslashes($site_setting_d['store_hours_saturday']);
$store_hours_sunday         = stripslashes($site_setting_d['store_hours_sunday']);
$map_embed_iframe           = stripslashes($site_setting_d['map_embed_iframe']);
$facebook_link           	= stripslashes($site_setting_d['facebook_link']);
$twitter_link           	= stripslashes($site_setting_d['twitter_link']);
$instagram_link           	= stripslashes($site_setting_d['instagram_link']);
$website_schema           	= stripslashes($site_setting_d['website_schema']);
$local_scheme           	= stripslashes($site_setting_d['local_scheme']);
$ecommerce_scheme           = stripslashes($site_setting_d['ecommerce_scheme']);
$breadcrumb_scheme          = stripslashes($site_setting_d['breadcrumb_scheme']);
$google_analytics           = stripslashes($site_setting_d['google_analytics']);
$google_tag_manager         = stripslashes($site_setting_d['google_tag_manager']);
$custom_tracking           	= stripslashes($site_setting_d['custom_tracking']);
$other_cus_tracking_num     = stripslashes($site_setting_d['other_cus_tracking_num']);

$curr_date_header = date('d-m-Y');
$today_day = date("D",strtotime($curr_date_header));

if($today_day == "Mon")
{
	$header_store_hours = "Monday: ".$store_hours_monday;
} 
else if($today_day == "Tue")
{
	$header_store_hours = "Tuesday: ".$store_hours_tuesday;
}
else if($today_day == "Wed")
{
	$header_store_hours = "Wednesday: ".$store_hours_wednesday;
}
else if($today_day == "Thu")
{
	$header_store_hours = "Thursday: ".$store_hours_thursday;
}
else if($today_day == "Fri")
{
	$header_store_hours = "Friday: ".$store_hours_friday;
}
else if($today_day == "Sat")
{
	$header_store_hours = "Saturday: ".$store_hours_saturday;
}
else if($today_day == "Sun")
{
	$header_store_hours = "Sunday: ".$store_hours_sunday;
}
?>