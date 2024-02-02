<?php 
if($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == 'pc-50' || $_SERVER['HTTP_HOST'] == '192.168.0.101')
{
    $ISMAIL = false;
    $ISACTIVE_FORTEST_PAYPAL_RESPONSE = false;
}
else 
{
    $ISMAIL = true;	
    $ISACTIVE_FORTEST_PAYPAL_RESPONSE = true;	
}       

$PROJECTURL = ($_SERVER['SERVER_PORT'] == 443 ? 'https' : 'http') . "://{$_SERVER['SERVER_NAME']}".str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
$SITEURL 	= str_replace("apanel/", "", $PROJECTURL);
$ADMINURL 	= $PROJECTURL;

//echo $SITEURL."--".$ADMINURL;die();

define('SITEURL', $SITEURL);

define('ADMINURL', $ADMINURL);

define('SITENAME','Zilli Furniture');

define('SITETITLE','Zilli Furniture');

define('ADMINTITLE','Zilli Furniture Apanel');
			
define('CURR','&dollar;');	
			
define("ISMAIL",$ISMAIL);

define("ISACTIVE_FORTEST_PAYPAL_RESPONSE",$ISACTIVE_FORTEST_PAYPAL_RESPONSE);

define('SITEPHONE','(469) 543-0506');

define('SITEADDRESS','7265 Central Expressway Plano, Texas 75025, United States (US)');
?>