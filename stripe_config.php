<?php

//require 'stripe/Stripe.php';



require 'stripe_define.php';





if ($params['testmode'] == "on") {

	Stripe::setApiKey($params['private_test_key']);

	$pri_key = $params['private_test_key'];

	$pubkey = $params['public_test_key'];

} else {

	Stripe::setApiKey($params['private_live_key']);

	$pri_key = $params['private_live_key'];

	$pubkey = $params['public_live_key'];

}

 ?>