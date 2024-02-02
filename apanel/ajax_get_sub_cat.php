<?php
include("connect.php");
//print_r($_POST);
$mode = $_POST['mode'];

if( $mode == 'sub_cat' )
{
	$cate_id 		= $_POST["cate_id"];
	$sub_cate_id 	= $_POST["sub_cate_id"];

	$where 		= " cate_id = '".$cate_id."' AND isDelete=0 ";
	$ctable_r 	= $db->rpgetData("sub_category","*",$where,'name');
	if(@mysqli_num_rows($ctable_r)>0)
	{
	?>
		<option value="">Select Sub Category</option>
		<option value="0" >For All Sub Category</option>
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
}

if( $mode == 'sub_sub_cat' )
{
	// $cate_id 		= $_POST["cate_id"];
	$sub_cate_id 	= $_POST["sub_cate_id"];
	$sub_sub_cate_id 	= $_POST["sub_sub_cate_id"];

	$where 		= " sub_cate_id = '".$sub_cate_id."' AND isDelete=0 ";
	// $ctable_r 	= $db->rpgetData("sub_category","*",$where,'name');

	$ctable_r 	= $db->rpgetData("sub_sub_category","*",$where,'name');

	// echo "<pre>";
	// print_r($ctable_r);die;
	
	if(@mysqli_num_rows($ctable_r)>0)
	{
	?>
		<option value="">Select Sub Sub Category</option>
		<option value="0" >For All Sub Sub Category</option>
		<?php

		while($ctable_d = @mysqli_fetch_array($ctable_r))
		{
		?>
			<option value="<?php echo $ctable_d['id']; ?>" <?php if($ctable_d['id']==$sub_sub_cate_id){?> selected <?php } ?>><?php echo $ctable_d['name']; ?></option>

			
		<?php
		}
	}
	else
	{
	?>
		<option value="">Select Sub Sub Category</option>
	<?php
	}
}
?>
