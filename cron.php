<?php
include('connect.php');
$where = "pro_feature_brand = 5";
$related_pro_r = $db->rpgetData("product","*",$where," id DESC",0);

$count = 0;
while($related_pro_c = @mysqli_fetch_assoc($related_pro_r))
{
	$count++;
	echo "<br>".$count."_".$related_pro_c['id']."<br>";
	$m_title= trim(str_replace('| Zilli Furniture','',$related_pro_c['meta_title']));
	echo $related_pro_c['meta_title']."<br>";
	echo $m_title."<br>";
	$rows 	= array(
					"meta_title"			=> $m_title,
				);

	$where1	= "id='".$related_pro_c['id']."'";
	$db->rpupdate("product",$rows,$where1,0);
}
?>