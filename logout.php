<?php
include("connect.php");

if(isset($_SESSION[SESS_PRE.'_SESS_USER_ID']))
{
	unset($_SESSION[SESS_PRE.'_SESS_USER_ID']);
	unset($_SESSION[SESS_PRE.'_SESS_USER_NAME']);
	unset($_SESSION[SESS_PRE.'_SESS_CART_ID']);
}

$db->rplocation(SITEURL."login/");
?>