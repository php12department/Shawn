<?php
include("connect.php");
$cate_id 		= $_POST["cate_id"];
$sub_cate_id 	= $_POST["sub_cate_id"];

$where 		= " cate_id = '".$cate_id."' AND isDelete=0 ";
$ctable_r 	= $db->rpgetData("sub_category","*",$where,'name');
if(@@mysqli_num_rows($ctable_r)>0)
{
?>
	<option value="">Select Sub Category</option>
	<?php

	while($ctable_d = @mysqli_fetch_array($ctable_r))
	{
	?>
		<option value="<?php echo $ctable_d['id']; ?>" <?php if($ctable_d['id']==$sub_cate_id){?> selected <?php } ?>><?php echo $ctable_d['name']; ?></option>

		
	<?php
	}
}
else
{
?>
	<option value="">Select Sub Category</option>
<?php
}
?>
