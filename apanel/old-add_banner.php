<?php
include("connect.php");
$db->rpcheckAdminLogin();

$ctable 			= "banner";
$ctable1 			= "Banner";
$parent_page 		= "banner-master"; //for sidebar active menu
$main_page 			= "manage-banner"; //for sidebar active menu
$page_title 		= ucwords($_REQUEST['mode'])." ".$ctable1;
$manage_page_url 	= ADMINURL."manage-banner/";
$add_page_url 		= ADMINURL."add-banner/add/";
$edit_page_url 		= ADMINURL."add-banner/edit/".$_REQUEST['id']."/";

$IMAGEPATH_T 		= BANNER_T;
$IMAGEPATH_A 		= BANNER_A;
$IMAGEPATH 			= BANNER;

$title					= "";
$sub_title				= "";
$image_path				= "";
$button_text			= "";
$button_link			= "";
$start_date_time		= "";
$expiration_date_time	= "";

if(isset($_REQUEST['submit']))
{
	$title 					= $db->clean($_REQUEST['title']);
	$sub_title 				= $db->clean($_REQUEST['sub_title']);
	$button_text 			= $db->clean($_REQUEST['button_text']);
	$button_link 			= $db->clean($_REQUEST['button_link']);

	$start_date_time		= date("Y-m-d H:i:s",strtotime($_REQUEST['start_date_time']));
	$start_date_time		= ($start_date_time!="1970-01-01 00:00:00") ? $start_date_time : NULL;
	$expiration_date_time	= date("Y-m-d H:i:s",strtotime($_REQUEST['expiration_date_time']));
	$expiration_date_time	= ($expiration_date_time!="1970-01-01 00:00:00") ? $expiration_date_time : NULL;
	
	if(isset($_SESSION['image_path']) && $_SESSION['image_path']!="")
	{
		copy($IMAGEPATH_T.$_SESSION['image_path'], $IMAGEPATH_A.$_SESSION['image_path']);
		$image_path = $_SESSION['image_path'];
		
		unlink($IMAGEPATH_T.$_SESSION['image_path']);
		unset($_SESSION['image_path']);
	}
	
	if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="add")
	{
		$display_order	= $db->rpgetDisplayOrder($ctable);

		$rows 	= array(
				"title",
				"sub_title",
				"button_text",
				"button_link",
				"image",
				"display_order",
				"start_date_time",
				"expiration_date_time",
			);
		$values = array(
				$title,
				$sub_title,
				$button_text,
				$button_link,
				$image_path,
				$display_order,
				$start_date_time,
				$expiration_date_time,
			);
		$db->rpinsert($ctable,$values,$rows);

		$_SESSION['MSG'] = 'Inserted';
		$db->rplocation($manage_page_url);
		
	}
	else if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="edit")
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
				"title"					=> $title,
				"sub_title"				=> $sub_title,
				"button_text"			=> $button_text,
				"button_link"			=> $button_link,
				"image"					=> $image_path,
				"start_date_time"		=> $start_date_time,
				"expiration_date_time"	=> $expiration_date_time,
			);
			
		$where	= "id=".$_REQUEST['id'];
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
	
	$title 					= stripslashes($ctable_d['title']);
	$sub_title 				= stripslashes($ctable_d['sub_title']);
	$image_path 			= stripslashes($ctable_d['image']);
	$button_text 			= stripslashes($ctable_d['button_text']);
	$button_link 			= stripslashes($ctable_d['button_link']);
	$start_date_time		= date("Y/m/d H:i",strtotime($ctable_d['start_date_time']));
	$expiration_date_time	= date("Y/m/d H:i",strtotime($ctable_d['expiration_date_time']));
}

if(isset($_REQUEST['id']) && $_REQUEST['id']>0 && $_REQUEST['mode']=="delete")
{
	$where = " id='".$_REQUEST['id']."'";
	$rows 	= array("isDelete" => "1");
	$db->rpupdate($ctable,$rows,$where);

	$_SESSION['MSG'] = 'Deleted';
	$db->rplocation($manage_page_url);	
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
										    <div class="kt-portlet__body">

										    	<input type="hidden" name="mode" id="mode" value="<?php echo $_REQUEST['mode']; ?>">
												<input type="hidden" name="id" id="id" value="<?php echo $_REQUEST['id']; ?>">

												<div class="col-md-6 form-group">
													<label>Title</label>
													<input type="text" class="form-control" value="<?php echo $title; ?>" id="title" name="title">
												</div>

												<div class="col-md-6 form-group">
													<label>Sub Title</label>
													<textarea type="text" class="form-control" id="sub_title" name="sub_title" style="min-height: 70px;"><?php echo $sub_title; ?></textarea>
												</div>

												<div class="col-md-6 form-group">
													<label>Button Text</label>
													<input type="text" class="form-control" value="<?php echo $button_text; ?>" id="button_text" name="button_text">
												</div>

												<div class="col-md-6 form-group">
													<label>Button Link</label>
													<input type="text" class="form-control" value="<?php echo $button_link; ?>" id="button_link" name="button_link">
												</div>

												<div class="form-group">
													<label for="image_path">Image <span class="text-danger">*</span>
													<input type="hidden" name="filename" id="filename" class="form-control" />
													</label>
													<small>minimum image size 1350 x 496</small> 
													<div class="row">
														<div class="col-md-6">
															<div id="dropzone" class="dropzone custom-dropzone" data-width="1350" data-height="496" data-ghost="false" data-originalsize="false" data-url="<?php echo ADMINURL?>crop_banner_image.php" style="width: 675px;height:248px;">
																<input type="file" id="image_path" name="image_path">
																<input type="hidden" name="old_image_path" value="<?php echo $image_path; ?>" />
															</div>
														</div>
													</div>
													<div class="form-group">
														<?php
														if($image_path!="" && file_exists($IMAGEPATH_A.$image_path)){
														?>
															<img src="<?php echo SITEURL.$IMAGEPATH.$image_path;?>" width="675">
														<?php
														}
														?>
													</div>
												</div>
												<div class="col-md-6 form-group">
													<label for="name">Start Date</label>
													<div class="input-group date dis_start_date_err">
														<input type="text" class="form-control" readonly placeholder="Select start date & time" name="start_date_time" id="start_date_time" value="<?php echo $start_date_time; ?>" />
	                                                    <div class="input-group-append">
	                                                        <span class="input-group-text"><i class="la la-calendar-check-o glyphicon-th"></i></span>
	                                                    </div>
	                                                </div>
												</div>
												<div class="col-md-6 form-group form-group-last">
													<label for="name">Expiration Date</label>
													<div class="input-group date dis_expiration_date_err">
	                                                    <input type="text" class="form-control" readonly  placeholder="Select expiration date & time" name='expiration_date_time' id="expiration_date_time" value="<?php echo $expiration_date_time; ?>" />
	                                                    <div class="input-group-append">
	                                                        <span class="input-group-text">
	                                                        <i class="la la-calendar-check-o"></i>
	                                                        </span>
	                                                    </div>
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
        	var custom_img_width = '1350';

            $('#dropzone').html5imageupload({
				onAfterProcessImage: function() {
					var imgName = $('#filename').val($(this.element).data('imageFileName'));
				},
				onAfterCancel: function() {
					$('#filename').val('');
				}
			});

		  	$(function(){
				$("#frm").validate({
					rules: {
						image_path:{required : $("#mode").val()=="add" && $("#filename").val()=="" },
						filename:{ required: $("#mode").val()=="add" && $("#filename").val()=="" },
					},
					messages: {
						image_path:{required:"Please upload image."},
						filename:{required:"Please click on right tick mark after upload image."},
					},
					errorPlacement: function(error, element) {
						if (element.attr("name") == "image_path") {
							error.insertAfter("#dropzone");
						}else if (element.attr("name") == "filename") {
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