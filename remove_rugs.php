<?php
include('connect.php');
$product_list_r = $db->rpgetData("product", "*", "cate_id=13 AND sub_cate_id=75 AND pro_sub_cat IS NOT NULL","",0);
$product_list_c = @mysqli_num_rows($product_list_r);
$i=0;
while($product_list_d=mysqli_fetch_assoc($product_list_r))
{
    $sub_product_list_r = $db->rpgetData("sub_sub_category", "name", "id=".$product_list_d['sub_sub_cate_id']."");
    $sub_product_list_d=mysqli_fetch_assoc($sub_product_list_r);
    $s=substr_replace(substr($product_list_d['name'],0,3),$sub_product_list_d['name'],0,3);
    // echo $s."<br>";
    // echo substr($product_list_d['name'],3);
    $product_name=$s.substr($product_list_d['name'],3);
    $rows 	= array(
        "name"	            => $product_name,
        "sub_sub_cate_id"   => 0,
    );		
    if($db->rpupdate("product",$rows,"id=".$product_list_d['id']."",0))
    {

    }
    else
    {
        echo "Product : ".$product_list_d['id']."<br>";
    }
    $rows 	= array(
        "isDelete"	            => 1,
    );
    
    if($db->rpupdate("sub_sub_category",$rows,"id=".$product_list_d['sub_sub_cate_id']."",0))
    {

    }
    else
    {
        echo "sub_sub_category : ".$product_list_d['sub_sub_cate_id']."<br>";
    }
    $i++;
}
echo $i;
?>