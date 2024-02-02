<?php
include("connect.php");
$db->rpcheckAdminLogin();

$ctable             = "page_no_found";
$ctable1            = "Page not found";
$parent_page        = "page-no-found"; //for sidebar active menu
$main_page          = "add-page-not-found"; //for sidebar active menu
$page_title 		= ucwords($_REQUEST['mode'])." ".$ctable1;
$add_page_url 		= ADMINURL."add-page-not-found/add/";
$edit_page_url 		= ADMINURL."add-page-not-found/edit/".$_REQUEST['id']."/";

$IMAGEPATH_T 		= PAGENOTFOUND_T;
$IMAGEPATH_A 		= PAGENOTFOUND_A;
$IMAGEPATH 			= PAGENOTFOUND;

$image_path = "";

if(isset($_REQUEST['submit']))
{	

	if(isset($_SESSION['image_path']) && $_SESSION['image_path']!="")
	{
		copy($IMAGEPATH_T.$_SESSION['image_path'], $IMAGEPATH_A.$_SESSION['image_path']);
		$image_path = $_SESSION['image_path'];
		
		unlink($IMAGEPATH_T.$_SESSION['image_path']);
		unset($_SESSION['image_path']);
	}

 	if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="edit")
	{	
		if($_REQUEST['old_image_path']!="" && $image_path!="")
			{
				if(file_exists($IMAGEPATH_A.$_REQUEST['old_image_path']))
				{
					unlink($IMAGEPATH_A.$_REQUEST['old_image_path']);
				}
				if(file_exists($IMAGEPATH_THUMB_A.$_REQUEST['old_image_path']))
				{
					unlink($IMAGEPATH_THUMB_A.$_REQUEST['old_image_path']);
				}
			}
			else
			{
				if($image_path=="")
				{
					$image_path = $_REQUEST['old_image_path'];
					if($image_path == "")
					{
						$image_path = "";	
					}
				}
			}

		$rows 	= array(
				"image"						=> $image_path,
			);

		$where	= "id='".$_REQUEST['id']."'";
		$db->rpupdate($ctable,$rows,$where);

		$_SESSION['MSG'] = 'Updated';
		$db->rplocation($edit_page_url);
	}
}

if($_REQUEST['mode']=="edit")
{
	$where 		= " id=1";
	$ctable_r 	= $db->rpgetData($ctable,"*",$where,"");
	$ctable_d 	= @mysqli_fetch_array($ctable_r);

	$image_path 			= stripslashes($ctable_d['image']);

}
	
?>
<!DOCTYPE html>
<html lang="en" >
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <head>
        <title><?php echo $page_title?> | <?php echo ADMINTITLE; ?></title>
        <?php include('include_css.php'); ?>
    </head>
    <!-- end::Head -->
    <!-- begin::Body -->
    <body  class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading"  >
        <!-- begin:: Page -->
        <!-- begin:: Header Mobile -->
        <?php include("header_mobile.php");?>
        <!-- end:: Header Mobile -->    
        <div class="kt-grid kt-grid--hor kt-grid--root">
            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
                <!-- begin:: Aside -->
                <?php include("left.php"); ?>
                <!-- end:: Aside -->            
                <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
                    <!-- begin:: Header -->
                    <?php include("header.php");?>
                    <!-- end:: Header -->
                    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
                        <!-- begin:: Subheader -->
                        <div class="kt-subheader  kt-grid__item" id="kt_subheader">
                            <div class="kt-container  kt-container--fluid ">
                                <div class="kt-subheader__main">
                                    <h3 class="kt-subheader__title"><?php echo $page_title?></h3>
                                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                                </div>
                                <!-- <div class="kt-subheader__toolbar">
                                    <a href="javascript:void(0);" onClick="window.location.href='<?= $manage_page_url;?>'" class="btn btn-clean btn-icon-sm">
                                        <i class="la la-long-arrow-left"></i>
                                        Back
                                    </a>
                                </div> -->
                            </div>
                        </div>
                        <!-- end:: Subheader -->                    
                        <!-- begin:: Content -->
                        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                            <div class="row">
                                <div class="col-md-6">
                                    <!--begin::Portlet-->
                                    <div class="kt-portlet">
                                        <!--begin::Form-->
                                        <form class="kt-form" name="frm" id="frm" action="." method="post" enctype="multipart/form-data">
										    <div class="kt-portlet__body">

										    	<input type="hidden" name="mode" id="mode" value="<?php echo "edit"; ?>">
												<input type="hidden" name="id" id="id" value="<?php echo 1; ?>">

												<!-- <div class="form-group">
													<label for="website_schema">Main Text <code>*</code></label>
													<input class="form-control" id="main_text" name="main_text" value="<?php echo $main_text; ?>">
												</div>
												<div class="form-group">
													<label for="website_schema">Sub text <code>*</code></label>
													<textarea class="form-control" rows="2" id="sub_text" name="sub_text" style="min-height: 70px;"><?php echo $sub_text; ?></textarea>
												</div> -->
												<div class="form-group">
													<label for="image_path">Image <span class="text-danger">*</span>
													<input type="hidden" name="filename" id="filename" class="form-control" />
													</label>
													<small>minimum image size 800 x 600</small> 
													<div class="row">
														<div class="col-md-6">
															<div id="dropzone" class="dropzone custom-dropzone" data-width="800" data-height="600" data-ghost="false" data-originalsize="false" data-url="<?php echo ADMINURL?>crop_<?php echo $ctable; ?>.php" style="width: 400px;height:300px;">
																<input type="file" id="image_path" name="image_path">
																<input type="hidden" name="old_image_path" value="<?php echo $image_path; ?>" />
															</div>
														</div>
													</div>
													<div class="form-group">
														<?php
														if($image_path!="" && file_exists($IMAGEPATH_A.$image_path)){
														?>
															<img src="<?php echo SITEURL.$IMAGEPATH."/".$image_path;?>" width="400">
														<?php
														}
														?>
													</div>
												</div>

											</div>
										    <div class="kt-portlet__foot">
										        <div class="kt-form__actions">
										            <button type="submit" name="submit" id="submit" class="btn btn-primary">Submit</button>
										        </div>
										    </div>

										</form>
                                        <!--end::Form-->            
                                    </div>
                                    <!--end::Portlet-->
                                </div>
                            </div>
                        </div>
                        <!-- end:: Content -->              
                    </div>
                    <!-- begin:: Footer -->
                    <?php include("footer.php"); ?>
                    <!-- end:: Footer -->           
                </div>
            </div>
        </div>
        <!-- end:: Page -->
        <?php include('include_js.php'); ?>
       <script type="text/javascript">
       	var custom_img_width = '700';

            $('#dropzone').html5imageupload({
				onAfterProcessImage: function() {
					var imgName = $('#filename').val($(this.element).data('imageFileName'));
				},
				onAfterCancel: function() {
					$('#filename').val('');
				}
			});

       </script>
    </body>
</html>