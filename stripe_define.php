<?php
$params = array(
	"testmode"   => "on",// live OR on 
	"private_live_key" => "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",
	"public_live_key"  => "pk_live_51HObeaDOSrAs9UGjUlhzPbdj0KqBxQ7TeZOLBEJQUAjmQ8Q3ZUbCeoiRy3ZCE3E8q4o6DiGeXykYnZc2tRUFrYOL001KUSxx4d",
	"public_test_key"  => "pk_test_51HObeaDOSrAs9UGjU7GahYljll9hyGsY8FbIDrESl7pg7ZdobzsmOODWbUCv5Y4QTw5G4tb5sRdBz4TJm108dkA600X3xH7ooI",
	"private_test_key" => "sk_test_51HObeaDOSrAs9UGjkez7OpJQoexuyQvArKl862YuT9MtnuwNIoBXHztlRZNLw7tE4xwP2PY9SKWT4QZvjIbbzVde00cbcW7boK",
);

if ($params['testmode'] == "on") {
	$pri_key = $params['private_test_key'];
	$pub_key = $params['public_test_key'];
} else {
	$pri_key = $params['private_live_key'];
	$pub_key = $params['public_live_key'];
}
?>