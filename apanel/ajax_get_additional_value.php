<?php
include("connect.php");
$additional_field_id 	= $_POST["additional_field_id"];
$curr_pos 				= $_POST["curr_pos"];

$ctable_r = $db->rpgetData("additional_field_value","*","isDelete=0 AND additional_field_id='".$additional_field_id."'");
?>
<div class="kt-checkbox-inline">
	<?php
	while($ctable_d = @mysqli_fetch_array($ctable_r))
	{
	?>
	<label class="kt-checkbox kt-checkbox--bold kt-checkbox--success">
		<input type="checkbox" name="additional_field_value[<?=$curr_pos;?>][]" value="<?=$ctable_d['id']?>"> <?=$ctable_d['name']?>
		<span></span>
	</label>
	<?php 
	}
	?>
</div>