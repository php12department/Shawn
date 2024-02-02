<?php
include('connect.php'); 

$orderBy 		= " id DESC";
$ctable_where 	= "";

$ctable_where.= "status='Y' AND isDelete=0";
$ctable_r = $db->rpgetData("submission","*",$ctable_where,$orderBy);
if(@mysqli_num_rows($ctable_r) >0)
{
	while($ctable_d = @mysqli_fetch_array($ctable_r))
	{
		$image_path     = $ctable_d['image'];

		if(!empty($image_path) && file_exists(SUBMISSION.$image_path))
		{
		    $image_url = SITEURL.SUBMISSION.$image_path;
		}
		else
		{
		    $image_url = SITEURL."common/images/no_image.png";
		}

		
		$comments 		= stripslashes($ctable_d['comments']);
		$fname 			= $db->rpgetValue("user","first_name","id='".$ctable_d['user_id']."'");
        $lname 			= $db->rpgetValue("user","last_name","id='".$ctable_d['user_id']."'");
		
		?>
		<!--<div class="col-sm-6 col-md-6 mb-5">-->
			<div class="od-section cg-box">
				<div class="gallary-left">
					<div class="left-image">
						<a href="<?php echo $image_url; ?>" target="_blank"><img src="<?php echo $image_url; ?>" alt="<?php echo SITETITLE; ?>" ></a>
					</div>
				</div>
				<div class="gallary-right">
					<div class="gallary-header">
						<h2><?php echo $fname." ".$lname; ?><span><?php echo date('M, d Y',strtotime($ctable_d['adate'])); ?></span></h2>
					</div>
					<div class="gallary-body">
						<p><?php echo $ctable_d['comments']; ?></p>
					</div>
				</div>
			</div>
		<!--</div>-->
		<?php
		
	}
}
else
{
?>
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<h3 class="text-center mt-30">No Record found.</h3>
</div>
<?php
}
?>