<?php
	include('connect.php');
	$product_r = $db->rpgetData("product", "*");
	while($product_d = @mysqli_fetch_array($product_r))
	{
		$data = $product_d['image'];    
		$result = explode('.',$data);
		var_dump($result);
		$image = $result[0].".webp";
		echo "<br>".$image."<br>";
		$rows 	= array(
					"image"			=> $image,
				);

		$db->rpupdate("product",$rows,"id=".$product_d['id'],0);
	}

?>