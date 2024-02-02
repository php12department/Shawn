<?php
include("connect.php");
$db->rpcheckAdminLogin();

$ctable 			= "aboutus"; 
$ctable1 			= "About Us";
$parent_page 		= "static-pages"; //for sidebar active menu
$main_page 			= "manage-aboutus"; //for sidebar active menu
$page_title 		= ucwords($_REQUEST['mode'])." ".$ctable1;
$manage_page_url 	= ADMINURL."manage-aboutus/";
$add_page_url 		= ADMINURL."add-aboutus/add/";
$edit_page_url 		= ADMINURL."add-aboutus/edit/".$_REQUEST['id']."/";

$IMAGEPATH_T        = ABOUTUS_T;
$IMAGEPATH_A        = ABOUTUS_A; 
$IMAGEPATH          = ABOUTUS;
$IMAGEPATH_THUMB_A  = ABOUTUS_THUMB_A;

$title	= $description = $image_path1 = $image_path2 = $image_path3 = "";
$meta_title 		= "";
$meta_description 	= "";
$meta_keywords 		= "";

if(isset($_REQUEST['submit']))
{
	$title1					= $db->clean($_REQUEST['title1']);
	$title2					= $db->clean($_REQUEST['title2']);
	$title3					= $db->clean($_REQUEST['title3']);
	$description1			= $db->clean($_REQUEST['description1']);
	$description2			= $db->clean($_REQUEST['description2']);
	$description3			= $db->clean($_REQUEST['description3']);
	$meta_title				= $db->clean($_REQUEST['meta_title']);
	$meta_description		= $db->clean($_REQUEST['meta_description']);
	$meta_keywords			= $db->clean($_REQUEST['meta_keywords']);
	$adate  				= date('Y-m-d H:i:s');
	

	if(isset($_SESSION['image_path1']) && $_SESSION['image_path1']!="")
	{
		copy($IMAGEPATH_T.$_SESSION['image_path1'], $IMAGEPATH_A.$_SESSION['image_path1']);
		$image_path1 = $_SESSION['image_path1'];
		
		////// - Product Thumb Starts - //////
		include('../include/resize_image.php');
		$image = new SimpleImage(); 
		$image->load($IMAGEPATH_A.$image_path1);
		$image->resize(92,114);
		$image->save($IMAGEPATH_THUMB_A.$image_path1);
		////// - Product Thumb Ends - //////
		
		unlink($IMAGEPATH_T.$_SESSION['image_path1']);
		unset($_SESSION['image_path1']);
	}
	
	if(isset($_SESSION['image_path2']) && $_SESSION['image_path2']!="")
	{
		copy($IMAGEPATH_T.$_SESSION['image_path2'], $IMAGEPATH_A.$_SESSION['image_path2']);
		$image_path2 = $_SESSION['image_path2'];
		
		////// - Product Thumb Starts - //////
		include('../include/resize_image.php');
		$image1 = new SimpleImage(); 
		$image1->load($IMAGEPATH_A.$image_path2);
		$image1->resize(92,114);
		$image1->save($IMAGEPATH_THUMB_A.$image_path2);
		////// - Product Thumb Ends - //////
		
		unlink($IMAGEPATH_T.$_SESSION['image_path2']);
		unset($_SESSION['image_path2']);
	}

	if(isset($_SESSION['image_path3']) && $_SESSION['image_path3']!="")
	{
		copy($IMAGEPATH_T.$_SESSION['image_path3'], $IMAGEPATH_A.$_SESSION['image_path3']);
		$image_path3 = $_SESSION['image_path3'];
		
		////// - Product Thumb Starts - //////
		include('../include/resize_image.php');
		$image2 = new SimpleImage(); 
		$image2->load($IMAGEPATH_A.$image_path3);
		$image2->resize(92,114);
		$image2->save($IMAGEPATH_THUMB_A.$image_path3);
		////// - Product Thumb Ends - //////
		
		unlink($IMAGEPATH_T.$_SESSION['image_path3']);
		unset($_SESSION['image_path3']);
	}

	if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="add")
	{
			$rows 	= array(
					"title1",
					"title2",
					"title3",
					"image_path1",
					"image_path2",
					"image_path3",
					"description1",
					"description2",
					"description3",
					"meta_title",
					"meta_description",
					"meta_keywords",
				);
			$values = array(
					$title1,
					$title2,
					$title3,
					$image_path1,
					$image_path2,
					$image_path3,
					$description1,
					$description2,
					$description3,
					$meta_title,
					$meta_description,
					$meta_keywords,
				);

			$db->rpinsert($ctable,$values,$rows);

			$_SESSION['MSG'] = 'Inserted';
			$db->rplocation($manage_page_url);
	
		
	}
	else if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="edit")
	{
	 
			if($_REQUEST['old_image_path1']!="" && $image_path1!="")
			{
				if(file_exists($IMAGEPATH_A.$_REQUEST['old_image_path1']))
				{
					unlink($IMAGEPATH_A.$_REQUEST['old_image_path1']);
				}
				if(file_exists($IMAGEPATH_THUMB_A.$_REQUEST['old_image_path1']))
				{
					unlink($IMAGEPATH_THUMB_A.$_REQUEST['old_image_path1']);
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

			if($_REQUEST['old_image_path2']!="" && $image_path2!="")
			{
				if(file_exists($IMAGEPATH_A.$_REQUEST['old_image_path2']))
				{
					unlink($IMAGEPATH_A.$_REQUEST['old_image_path2']);
				}
				if(file_exists($IMAGEPATH_THUMB_A.$_REQUEST['old_image_path2']))
				{
					unlink($IMAGEPATH_THUMB_A.$_REQUEST['old_image_path2']);
				}
			}
			else
			{
				if($image_path2=="")
				{
					$image_path2 = $_REQUEST['old_image_path2'];
					if($image_path2 == "")
					{
						$image_path2 = "";	
					}
				}
			}

			if($_REQUEST['old_image_path3']!="" && $image_path3!="")
			{
				if(file_exists($IMAGEPATH_A.$_REQUEST['old_image_path3']))
				{
					unlink($IMAGEPATH_A.$_REQUEST['old_image_path3']);
				}
				if(file_exists($IMAGEPATH_THUMB_A.$_REQUEST['old_image_path3']))
				{
					unlink($IMAGEPATH_THUMB_A.$_REQUEST['old_image_path3']);
				}
			}
			else
			{
				if($image_path3=="")
				{
					$image_path3 = $_REQUEST['old_image_path3'];
					if($image_path3 == "")
					{
						$image_path3 = "";	
					}
				}
			}
			
			$rows 	= array(
					"title1"				=> $title1,
					"title2"				=> $title2,
					"title3"				=> $title3,
					"image_path1"			=> $image_path1,
					"image_path2"			=> $image_path2,
					"image_path3"			=> $image_path3,
					"description1"			=> $description1,
					"description2"			=> $description2,
					"description3"			=> $description3,
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
	
	$title1					= stripslashes($ctable_d['title1']);
	$title2					= stripslashes($ctable_d['title2']);
	$title3					= stripslashes($ctable_d['title3']);
	$description1			= stripslashes($ctable_d['description1']);
	$description2			= stripslashes($ctable_d['description2']);
	$description3			= stripslashes($ctable_d['description3']);
	$image_path1 			= stripslashes($ctable_d['image_path1']);
	$image_path2 			= stripslashes($ctable_d['image_path2']);
	$image_path3 			= stripslashes($ctable_d['image_path3']);
	$meta_title				= stripslashes($ctable_d['meta_title']);
	$meta_description		= stripslashes($ctable_d['meta_description']);
	$meta_keywords			= stripslashes($ctable_d['meta_keywords']);

}

if(isset($_REQUEST['id']) && $_REQUEST['id']>0 && $_REQUEST['mode']=="delete")
{
	$id 	= $_REQUEST['id'];
	$rows 	= array("isDelete" => "1");
	$db->rpupdate($ctable,$rows,"id='".$id."'");

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
                                <div class="col-md-6">
                                    <!--begin::Portlet-->
                                    <div class="kt-portlet">
                                        <!--begin::Form-->
                                        <form class="kt-form" name="frm" id="frm" action="." method="post" enctype="multipart/form-data">
										    <div class="kt-portlet__body">

										    	<input type="hidden" name="mode" id="mode" value="<?php echo $_REQUEST['mode']; ?>">
												<input type="hidden" name="id" id="id" value="<?php echo $_REQUEST['id']; ?>">

												<div class="form-group">
													<label for="title1">Title 1 <code>*</code></label>
													<input type="text" class="form-control" value="<?php echo $title1; ?>" id="title1" name="title1">
												</div>

												<div class="form-group">
													<label for="image_path1">Image 1<span class="text-danger">*</span>
													<input type="hidden" name="filename1" id="filename1" class="form-control" />
													</label>
													<small>minimum image size 570 x 400</small> 
													<div class="row">
														<div class="col-md-6">
															<div id="dropzone" class="dropzone custom-dropzone" data-width="570" data-height="400" data-ghost="false" data-originalsize="false" data-url="<?php echo ADMINURL?>crop_<?php echo $ctable; ?>.php" style="width: 285px;height:200px;">
																<input type="file" id="image_path1" name="image_path1">
																<input type="hidden" name="old_image_path1" value="<?php echo $image_path1; ?>" />
															</div>
														</div>
													</div>
													<div class="form-group">
														<?php
														if($image_path1!="" && file_exists($IMAGEPATH_A.$image_path1)){
														?>
															<img src="<?php echo SITEURL.$IMAGEPATH.$image_path1;?>" width="285">
														<?php
														}
														?>
													</div>
												</div>
												
												<div class="form-group">
													<label for="ans">Description 1 <span class="text-danger">*</span></label>
													<textarea class="form-control summernote" rows="8" id="description1" name="description1" style="min-height: 100px;"><?php echo $description1; ?></textarea>
												</div>

												<div class="form-group">
													<label for="title2">Title 2 <code>*</code></label>
													<input type="text" class="form-control" value="<?php echo $title2; ?>" id="title2" name="title2">
												</div>

												<div class="form-group">
													<label for="image_path2">Image 2<span class="text-danger">*</span>
													<input type="hidden" name="filename2" id="filename2" class="form-control" />
													</label>
													<small>minimum image size 570 x 400</small> 
													<div class="row">
														<div class="col-md-6">
															<div id="dropzone2" class="dropzone custom-dropzone" data-width="570" data-height="400" data-ghost="false" data-originalsize="false" data-url="<?php echo ADMINURL?>crop_<?php echo $ctable; ?>1.php" style="width: 285px;height:200px;">
																<input type="file" id="image_path2" name="image_path2">
																<input type="hidden" name="old_image_path2" value="<?php echo $image_path2; ?>" />
															</div>
														</div>
													</div>
													<div class="form-group">
														<?php
														if($image_path2!="" && file_exists($IMAGEPATH_A.$image_path2)){
														?>
															<img src="<?php echo SITEURL.$IMAGEPATH.$image_path2;?>" width="285">
														<?php
														}
														?>
													</div>
												</div>
												
												<div class="form-group">
													<label for="ans">Description 2 <span class="text-danger">*</span></label>
													<textarea class="form-control summernote" rows="8" id="description2" name="description2" style="min-height: 100px;"><?php echo $description2; ?></textarea>
												</div>
												
												<div class="form-group">
													<label for="title3">Title 3 <code>*</code></label>
													<input type="text" class="form-control" value="<?php echo $title3; ?>" id="title3" name="title3">
												</div>

												<div class="form-group">
													<label for="image_path2">Image 3<span class="text-danger">*</span>
													<input type="hidden" name="filename3" id="filename3" class="form-control" />
													</label>
													<small>minimum image size 570 x 400</small> 
													<div class="row">
														<div class="col-md-6">
															<div id="dropzone3" class="dropzone custom-dropzone" data-width="570" data-height="400" data-ghost="false" data-originalsize="false" data-url="<?php echo ADMINURL?>crop_<?php echo $ctable; ?>2.php" style="width: 285px;height:200px;">
																<input type="file" id="image_path3" name="image_path3">
																<input type="hidden" name="old_image_path3" value="<?php echo $image_path3; ?>" />
															</div>
														</div>
													</div>
													<div class="form-group">
														<?php
														if($image_path3!="" && file_exists($IMAGEPATH_A.$image_path3)){
														?>
															<img src="<?php echo SITEURL.$IMAGEPATH.$image_path3;?>" width="285">
														<?php
														}
														?>
													</div>
												</div>
												
												<div class="form-group">
													<label for="ans">Description 3 <span class="text-danger">*</span></label>
													<textarea class="form-control summernote" rows="8" id="description3" name="description3" style="min-height: 100px;"><?php echo $description3; ?></textarea>
												</div>

												<div class="form-group">
													<label for="meta_title">Meta Title</label>
													<textarea class="form-control" style="min-height: 110px;" id="meta_title" name="meta_title"><?php echo $meta_title; ?></textarea>
												</div>

												<div class="form-group">
													<label for="meta_description">Meta Description</label>
													<textarea class="form-control" style="min-height: 110px;" id="meta_description" name="meta_description"><?php echo $meta_description; ?></textarea>
												</div>

												<div class="form-group form-group-last">
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
        	var custom_img_width = '400';

            $('#dropzone').html5imageupload({
				onAfterProcessImage: function() {
					var imgName = $('#filename1').val($(this.element).data('imageFileName'));
				},
				onAfterCancel: function() {
					$('#filename1').val('');
				}
			});

			$('#dropzone2').html5imageupload({
				onAfterProcessImage: function() {
					var imgName = $('#filename2').val($(this.element).data('imageFileName'));
				},
				onAfterCancel: function() {
					$('#filename2').val('');
				}
			});

			$('#dropzone3').html5imageupload({
				onAfterProcessImage: function() {
					var imgName = $('#filename3').val($(this.element).data('imageFileName'));
				},
				onAfterCancel: function() {
					$('#filename3').val('');
				}
			});

		  	$(function(){
				$("#frm").validate({
					rules: {
						title1:{required : true},
						title2:{required : true},
						title3:{required : true},
						description1:{required : true},
						description2:{required : true},
						description3:{required : true},
						image_path1:{required : $("#mode").val()=="add" && $("#filename1").val()=="" },
						filename1:{ required: $("#mode").val()=="add" && $("#filename1").val()=="" },
						image_path2:{required : $("#mode").val()=="add" && $("#filename2").val()=="" },
						filename2:{ required: $("#mode").val()=="add" && $("#filename2").val()=="" },
						image_path3:{required : $("#mode").val()=="add" && $("#filename3").val()=="" },
						filename3:{ required: $("#mode").val()=="add" && $("#filename3").val()=="" },
					},
					messages: {
						title1:{required:"Please Enter Title 1."},
						title2:{required:"Please Enter Title 2."},
						title3:{required:"Please Enter Title 3."},
						description1:{required:"Please Enter Description 1."},
						description2:{required:"Please Enter Description 2."},
						description3:{required:"Please Enter Description 3."},
						image_path1:{required:"Please upload image."},
						filename1:{required:"Please click on right tick mark after upload image."},
						image_path2:{required:"Please upload image."},
						filename2:{required:"Please click on right tick mark after upload image."},
						image_path3:{required:"Please upload image."},
						filename3:{required:"Please click on right tick mark after upload image."},
					},
					errorPlacement: function(error, element) {
						if (element.attr("name") == "image_path1") {
							error.insertAfter("#dropzone");
						}else if (element.attr("name") == "filename1") {
							error.insertAfter("#dropzone");
						} else if (element.attr("name") == "description1") 
						{
							error.insertAfter(".desc_error");
						}else if (element.attr("name") == "image_path2") {
							error.insertAfter("#dropzone2");
						}else if (element.attr("name") == "filename2") {
							error.insertAfter("#dropzone2");
						} else if (element.attr("name") == "description2") 
						{
							error.insertAfter(".desc_error");
						}else if (element.attr("name") == "image_path3") {
							error.insertAfter("#dropzone3");
						}else if (element.attr("name") == "filename3") {
							error.insertAfter("#dropzone3");
						} else if (element.attr("name") == "description3") 
						{
							error.insertAfter(".desc_error");
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