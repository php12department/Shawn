<?php
	include('connect.php');
	$product_r = $db->rpgetData("alt_image", "*");
	while($product_d = @mysqli_fetch_array($product_r))
	{
		$data = $product_d['image_path'];    
		$result = explode('.',$data);
		var_dump($result);
		$image = $result[0].".webp";
		echo "<br>".$image."<br>";
		$rows 	= array(
					"image_path"			=> $image,
				);

		$db->rpupdate("alt_image",$rows,"id=".$product_d['id'],0);
	}

?>