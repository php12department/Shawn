<?php
include("connect.php");

$subsub_cate_id 	= $_POST["subsub_cate_id"];

$where 		= " sub_sub_cate_id = '".$subsub_cate_id."' AND isDelete=0 ";
$ctable_r 	= $db->rpgetData("product","*",$where,'name');
if(@@mysqli_num_rows($ctable_r)>0)
{
	while($ctable_d = @mysqli_fetch_array($ctable_r))
	{
	?>
		<option value="<?php echo $ctable_d['id']; ?>" <?php if($ctable_d['id']==$sub_sub_cate_id){?> selected <?php } ?>><?php echo $ctable_d['name']; ?></option>
	<?php
	}
}
else
{
}
?>
