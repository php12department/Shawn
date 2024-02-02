<?php
include("connect.php");
$db->rpcheckAdminLogin();
include('../include/resize_image.php');
$image = new SimpleImage(); 

$ctable 			= "alt_image";
$ctable1 			= "Alternate Image";
$parent_page 		= "product-master"; //for sidebar active menu
$main_page 			= "manage-product"; //for sidebar active menu
$page_title 		= ucwords($_REQUEST['mode'])." ".$ctable1;
$manage_page_url 	= ADMINURL."manage-alt-image/".$_REQUEST['pid']."/";
$add_page_url 		= ADMINURL."add-alt-image/add/".$_REQUEST['pid']."/";
$edit_page_url 		= ADMINURL."add-alt-image/edit/".$_REQUEST['id']."/".$_REQUEST['pid']."/";

$IMAGEPATH_T 		= PRODUCT_ALT_T;
$IMAGEPATH_A 		= PRODUCT_ALT_A;
$IMAGEPATH 			= PRODUCT_ALT;
$IMAGEPATH_THUMB_A  = PRODUCT_ALT_THUMB_A;
$IMAGEPATH_LIST_THUMB_A = PRODUCT_ALT_LIST_THUMB_A;

if(isset($_REQUEST['submit']))
{
	$pid 		= $db->clean($_REQUEST['pid']);
	$isImage 	= ($_REQUEST['isImage']) ? $_REQUEST['isImage'] : 0;

	if(isset($_FILES['image_path']) && !empty($_FILES['image_path']['name']))   
	{
		$img_filename = $_FILES["image_path"]["name"];
		$filetype = $_FILES["image_path"]["type"];
		$filesize = $_FILES["image_path"]["size"];
		
		$img_filename = str_replace(' ', '_', $img_filename);
		$image_path = time()."-pro-alt-".$img_filename;
			$image_path = substr($image_path, 0, strrpos($image_path, ".")).".webp";
		$imgInfo = getimagesize($image_path); 
         
        $mime = $imgInfo['mime']; 
	      switch($mime){ 
	            case 'image/jpeg': 
	                $image1 = imagecreatefromjpeg($image_path); 
	                break; 
	            case 'image/png': 
	                $image1 = imagecreatefrompng($image_path); 
	                imagepalettetotruecolor($image);
	                break; 
	            case 'image/gif': 
	                $image1 = imagecreatefromgif($image_path); 
	                imagepalettetotruecolor($image);
	                break; 
	            default: 
	                $image1 = imagecreatefromjpeg($image_path); 
	        } 
            imagewebp($image1, null, 100);
		@move_uploaded_file($_FILES["image_path"]["tmp_name"],$IMAGEPATH_A.$image_path);

		////// - Product Thumb Starts - product details page //////
		$image->createThumbnail($image_path,154,106,$IMAGEPATH_A.$image_path,$IMAGEPATH_THUMB_A.$image_path);
		/*$image->load($IMAGEPATH_A.$image_path);
		$image->resize(154,106);
		$image->save($IMAGEPATH_THUMB_A.$image_path);*/
		////// - Product Thumb Ends - product details page //////

		////// - Categorywise Product List Thumb Starts - //////
		$image->createThumbnail($image_path,270,200,$IMAGEPATH_A.$image_path,$IMAGEPATH_LIST_THUMB_A.$image_path);
		/*$image->load($IMAGEPATH_A.$image_path);
		$image->resize(270,200);
		$image->save($IMAGEPATH_LIST_THUMB_A.$image_path);*/
		////// - Categorywise Product List Thumb Ends - //////
	}

	/*if(isset($_SESSION['image_path']) && $_SESSION['image_path']!="")
	{
		copy($IMAGEPATH_T.$_SESSION['image_path'], $IMAGEPATH_A.$_SESSION['image_path']);
		$image_path = $_SESSION['image_path'];
		
		////// - Product Thumb Starts - //////
		$image->load($IMAGEPATH_A.$image_path);
		$image->resize(92,114);
		$image->save($IMAGEPATH_THUMB_A.$image_path);
		////// - Product Thumb Ends - //////
		
		////// - Product List Thumb Starts - //////
		$image->load($IMAGEPATH_A.$image_path);
		$image->resize(270,200);
		$image->save($IMAGEPATH_LIST_THUMB_A.$image_path);
		////// - Product List Thumb Ends - //////

		unlink($IMAGEPATH_T.$_SESSION['image_path']);
		unset($_SESSION['image_path']);
	}*/
	
	if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="add")
	{
		$display_order	= $db->rpgetDisplayOrder($ctable,"pid=".$pid);

		$rows 	= array(
				"pid",
				"isImage",
				"image_path",
				"display_order",
			);
		$values = array(
				$pid,
				$isImage,
				$image_path,
				$display_order,
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
		
		/*if($_REQUEST['old_image_path']!="" && $image_path!="")
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
		}*/
		
		$rows 	= array(
				"isImage"			=> $isImage,
				"image_path"		=> $image_path,
			);
			
		$where	= "id=".$_REQUEST['id'];
		$db->rpupdate($ctable,$rows,$where);

		$_SESSION['MSG'] = 'Updated';
		$db->rplocation($manage_page_url);
	}
}

if(isset($_REQUEST['id']) && $_REQUEST['id']>0 && $_REQUEST['mode']=="edit")
{
	$where 		= " id='".$_REQUEST['id']."' AND pid='".$_REQUEST['pid']."' AND isDelete=0";
	$ctable_r 	= $db->rpgetData($ctable,"*",$where);
	$ctable_d 	= @mysqli_fetch_array($ctable_r);
	
	$isImage 	= stripslashes($ctable_d['isImage']);
	$image_path = stripslashes($ctable_d['image_path']);
}
else
{
	$isImage				= 0;
}

if(isset($_REQUEST['id']) && $_REQUEST['id']>0 && $_REQUEST['mode']=="delete")
{
	$where = " id='".$_REQUEST['id']."' AND pid='".$_REQUEST['pid']."'";
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
												<input type="hidden" name="pid" id="pid" value="<?php echo $_REQUEST['pid']; ?>">

												<div class="form-group col-md-6">
													<label>Is Image? <code>*</code></label>
													<div class="kt-radio-inline">
														<label class="kt-radio">
															<input type="radio" name="isImage" value="0" <?php if($isImage=="0"){ echo "checked";}?>> None
														<span></span>
														</label>
														<label class="kt-radio">
															<input type="radio" name="isImage" value="1" <?php if($isImage=="1"){ echo "checked";}?>> Left
														<span></span>
														</label>
														<label class="kt-radio">
															<input type="radio" name="isImage" value="2" <?php if($isImage=="2"){ echo "checked";}?>>Right
														<span></span>
														</label>
													</div>
													<div class="isImage_error"></div>
												</div>

												<div class="form-group col-md-6">
                                                    <label>Image (minimum image size 1198 x 712)<code> *</code></label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="image_path" name="image_path">
                                                        <label class="custom-file-label" for="image_path">Choose file</label>
                                                    </div>
                                                </div>
                                                <?php
												if($image_path!="" && file_exists($IMAGEPATH_A.$image_path))
												{
												?>
													<input type="hidden" name="old_image_path" value="<?php echo $image_path; ?>" />
													<div class="form-group">
	                                                    <label>Uploaded Image</label>
	                                                    <div class="custom-file">
	                                                        <img src="<?php echo SITEURL.$IMAGEPATH.$image_path;?>" width="599"><br><br>
	                                                    </div>
	                                                </div>
												<?php
												}
												?>

												<!-- <div class="form-group form-group-last">
													<label for="image_path">Image <span class="text-danger">*</span>
													<input type="hidden" name="filename" id="filename" class="form-control" />
													</label>
													<small>minimum image size 1198 x 712</small> 
													<div class="row">
														<div class="col-md-6">
															<div id="dropzone" class="dropzone custom-dropzone" data-width="1198" data-height="712" data-ghost="false" data-originalsize="false" data-url="<?php echo ADMINURL?>crop_alt_image.php" style="width: 599px;height:356px;">
																<input type="file" id="image_path" name="image_path">
																<input type="hidden" name="old_image_path" value="<?php echo $image_path; ?>" />
															</div>
														</div>
													</div>
													<div class="form-group">
														<?php
														if($image_path!="" && file_exists($IMAGEPATH_A.$image_path)){
														?>
															<img src="<?php echo SITEURL.$IMAGEPATH.$image_path;?>" width="350">
														<?php
														}
														?>
													</div>
												</div> -->

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
        	/*var custom_img_width = '1198';

            $('#dropzone').html5imageupload({
				onAfterProcessImage: function() {
					var imgName = $('#filename').val($(this.element).data('imageFileName'));
				},
				onAfterCancel: function() {
					$('#filename').val('');
				}
			});*/

		  	$(function(){
				$("#frm").validate({
					rules: {
						isImage:{required : true},
						image_path:{required : $("#mode").val()=="add" && $("#filename").val()=="" },
						filename:{ required: $("#mode").val()=="add" && $("#filename").val()=="" },
					},
					messages: {
						isImage:{required:"Please select option."},
						image_path:{required:"Please upload image."},
						filename:{required:"Please click on right tick mark after upload image."},
					},
					errorPlacement: function(error, element) {
						if (element.attr("name") == "image_path") {
							error.insertAfter("#dropzone");
						}else if (element.attr("name") == "filename") {
							error.insertAfter("#dropzone");
						}else if (element.attr("name") == "isImage") 
						{
							error.insertAfter(".isImage_error");
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