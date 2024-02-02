<?php
include("connect.php");
$db->rpcheckAdminLogin();

$ctable 			= "contactus_page"; 
$ctable1 			= "Contact Us Page";
$parent_page 		= "static-pages"; //for sidebar active menu
$main_page 			= "manage-contactus-page"; //for sidebar active menu
$page_title 		= ucwords($_REQUEST['mode'])." ".$ctable1;
$manage_page_url 	= ADMINURL."manage-contactus-page/";
$add_page_url 		= ADMINURL."add-contactus-page/add/";
$edit_page_url 		= ADMINURL."add-contactus-page/edit/".$_REQUEST['id']."/";

$IMAGEPATH_T        = CONTACTUS_PAGE_T;
$IMAGEPATH_A        = CONTACTUS_PAGE_A; 
$IMAGEPATH          = CONTACTUS_PAGE;

$main_title 		= "";
$image_path1 		= "";
$sec1_title 		= "";
$sec2_title 		= "";
$sec2_button_name 	= "";
$meta_title 		= "";
$meta_description 	= "";
$meta_keywords 		= "";

if(isset($_REQUEST['submit']))
{
	$main_title				= $db->clean($_REQUEST['main_title']);
	$sec1_title				= $db->clean($_REQUEST['sec1_title']);	
	$sec2_title				= $db->clean($_REQUEST['sec2_title']);	
	$sec2_button_name		= $db->clean($_REQUEST['sec2_button_name']);	

	$meta_title				= $db->clean($_REQUEST['meta_title']);
	$meta_description		= $db->clean($_REQUEST['meta_description']);
	$meta_keywords			= $db->clean($_REQUEST['meta_keywords']);


	if(isset($_SESSION['image_path1']) && $_SESSION['image_path1']!="")
	{
		copy($IMAGEPATH_T.$_SESSION['image_path1'], $IMAGEPATH_A.$_SESSION['image_path1']);
		$image_path1 = $_SESSION['image_path1'];
		
		unlink($IMAGEPATH_T.$_SESSION['image_path1']);
		unset($_SESSION['image_path1']);
	}

	if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="edit")
	{
	 
	 	if($_REQUEST['old_image_path1']!="" && $image_path1!="")
		{
			if(file_exists($IMAGEPATH_A.$_REQUEST['old_image_path1']))
			{
				unlink($IMAGEPATH_A.$_REQUEST['old_image_path1']);
			}
		}
		else
		{
			if($image_path1=="")
			{
				$image_path1 = $_REQUEST['old_image_path1'];
				if($image_path1 == "")
				{
					$image_path1 = "";	
				}
			}
		}
			
		$rows 	= array(
				"main_title"			=> $main_title,
				"image_path1"			=> $image_path1,
				"sec1_title"			=> $sec1_title,
				"sec2_title"			=> $sec2_title,
				"sec2_button_name"		=> $sec2_button_name,
				"meta_title"			=> $meta_title,
				"meta_description"		=> $meta_description,
				"meta_keywords"			=> $meta_keywords,
			);

		$where	= "id='".$_REQUEST['id']."' AND isDelete=0";
		$db->rpupdate($ctable,$rows,$where);

		$_SESSION['MSG'] = 'Updated';
		$db->rplocation($manage_page_url);
	}
}

if(isset($_REQUEST['id']) && $_REQUEST['id']>0 && $_REQUEST['mode']=="edit")
{
	$where 		= " id='".$_REQUEST['id']."' AND isDelete=0";
	$ctable_r 	= $db->rpgetData($ctable,"*",$where);
	$ctable_d 	= @mysqli_fetch_array($ctable_r);
	
	$main_title				= stripslashes($ctable_d['main_title']);
	$image_path1 			= stripslashes($ctable_d['image_path1']);
	$sec1_title				= stripslashes($ctable_d['sec1_title']);
	$sec2_title				= stripslashes($ctable_d['sec2_title']);
	$sec2_button_name		= stripslashes($ctable_d['sec2_button_name']);

	$meta_title				= stripslashes($ctable_d['meta_title']);
	$meta_description		= stripslashes($ctable_d['meta_description']);
	$meta_keywords			= stripslashes($ctable_d['meta_keywords']);
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
                                <div class="kt-subheader__toolbar">
                                    <a href="javascript:void(0);" onClick="window.location.href='<?= $manage_page_url;?>'" class="btn btn-clean btn-icon-sm">
                                        <i class="la la-long-arrow-left"></i>
                                        Back
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- end:: Subheader -->                    
                        <!-- begin:: Content -->
                        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <!--begin::Portlet-->
                                    <div class="kt-portlet">
                                        <!--begin::Form-->
                                        <form class="kt-form" name="frm" id="frm" action="." method="post" enctype="multipart/form-data">
                                        	<input type="hidden" name="mode" id="mode" value="<?php echo $_REQUEST['mode']; ?>">
											<input type="hidden" name="id" id="id" value="<?php echo $_REQUEST['id']; ?>">
                                        	
										    <div class="kt-portlet__body">
												<div class="form-group col-md-6">
													<label for="main_title">Main Title<code>*</code></label>
													<input type="text" class="form-control" value="<?php echo $main_title; ?>" id="main_title" name="main_title">
												</div>
												<div class="form-group col-md-6 form-group-last">
													<label for="image_path1">Image <code>*</code>
													<input type="hidden" name="filename1" id="filename1" class="form-control" />
													</label>
													<small>minimum image size 1250 x 400</small> 
													<div class="row">
														<div class="col-md-6">
															<div id="dropzone" class="dropzone custom-dropzone" data-width="1250" data-height="400" data-ghost="false" data-originalsize="false" data-url="<?php echo ADMINURL?>crop_<?php echo $ctable; ?>.php" style="width: 625px;height:200px;">
																<input type="file" id="image_path1" name="image_path1">
																<input type="hidden" name="old_image_path1" value="<?php echo $image_path1; ?>" />
															</div>
														</div>
													</div>
													<div class="form-group col-md-6">
														<?php
														if($image_path1!="" && file_exists($IMAGEPATH_A.$image_path1)){
														?>
															<img src="<?php echo SITEURL.$IMAGEPATH.$image_path1;?>" width="625">
														<?php
														}
														?>
													</div>
												</div>
											</div>

											<div class="kt-portlet__head">
												<div class="kt-portlet__head-label">
													<h3 class="kt-portlet__head-title">
														Section 1 Details
													</h3>
												</div>
											</div>
											<div class="kt-portlet__body">
												<div class="form-group col-md-6">
													<label for="sec1_title">Title <code>*</code></label>
													<input type="text" class="form-control" value="<?php echo $sec1_title; ?>" id="sec1_title" name="sec1_title">
												</div>
											</div>
											<div class="kt-portlet__head">
												<div class="kt-portlet__head-label">
													<h3 class="kt-portlet__head-title">
														Section 2 Details
													</h3>
												</div>
											</div>
											<div class="kt-portlet__body">
												<div class="form-group col-md-6">
													<label for="sec2_title">Title <code>*</code></label>
													<input type="text" class="form-control" value="<?php echo $sec2_title; ?>" id="sec2_title" name="sec2_title">
												</div>
												<div class="form-group col-md-6">
													<label for="sec2_button_name">Button Name </label>
													<input type="text" class="form-control" value="<?php echo $sec2_button_name; ?>" id="sec2_button_name" name="sec2_button_name">
												</div>

												<div class="form-group col-md-6">
													<label for="meta_title">Meta Title</label>
													<textarea class="form-control" style="min-height: 110px;" id="meta_title" name="meta_title"><?php echo $meta_title; ?></textarea>
												</div>

												<div class="form-group col-md-6">
													<label for="meta_description">Meta Description</label>
													<textarea class="form-control" style="min-height: 110px;" id="meta_description" name="meta_description"><?php echo $meta_description; ?></textarea>
												</div>

												<div class="form-group col-md-6 form-group-last">
													<label for="meta_keywords">Meta Keywords</label>
													<textarea class="form-control" style="min-height: 110px;" id="meta_keywords" name="meta_keywords"><?php echo $meta_keywords; ?></textarea>
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
        	var custom_img_width = '1250';

            $('#dropzone').html5imageupload({
				onAfterProcessImage: function() {
					var imgName = $('#filename1').val($(this.element).data('imageFileName'));
				},
				onAfterCancel: function() {
					$('#filename1').val('');
				}
			});

		  	$(function(){
				$("#frm").validate({
					ignore: "",
					rules: {
						main_title:{required : true},
						image_path1:{required : $("#mode").val()=="add" && $("#filename1").val()=="" },
						filename1:{ required: $("#mode").val()=="add" && $("#filename1").val()=="" },
						sec1_title:{required : true},
						sec2_title:{required : true},
						sec2_button_name:{required : true},
					},
					messages: {
						main_title:{required:"Please enter title"},
						image_path1:{required:"Please upload image"},
						filename1:{required:"Please click on right tick mark after upload image"},
						sec1_title:{required:"Please enter title"},
						sec2_title:{required:"Please enter title"},
						sec2_button_name:{required:"Please enter button name"},
					},
					errorPlacement: function(error, element) {
						if (element.attr("name") == "image_path1") 
						{
							error.insertAfter("#dropzone");
						}
						else if (element.attr("name") == "filename1") 
						{
							error.insertAfter("#dropzone");
						} 
						else
						{
							error.insertAfter(element);
						}
					}
				});
			});
        </script>
    </body>
</html>