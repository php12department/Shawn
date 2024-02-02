<?php
include("connect.php");
$db->rpcheckAdminLogin();
include('../include/resize_image.php');
$image = new SimpleImage(); 

$ctable 			= "featured_brand";
$ctable1 			= "Featured Brand";
$parent_page 		= "product-master"; //for sidebar active menu
$main_page 			= "manage-featured-brand"; //for sidebar active menu
$page_title 		= ucwords($_REQUEST['mode'])." ".$ctable1;
$manage_page_url 	= ADMINURL."manage-featured-brand/";
$add_page_url 		= ADMINURL."add-featured-brand/add/";
$edit_page_url 		= ADMINURL."add-featured-brand/edit/".$_REQUEST['id']."/";

$IMAGEPATH_T 		= FEATURED_BRAND_T;
$IMAGEPATH_A 		= FEATURED_BRAND_A;
$IMAGEPATH 			= FEATURED_BRAND;

$name			= "";
$slug			= "";
$image_path		= "";
$short_desc		= "";
$meta_title 		= "";
$meta_description 	= "";
$meta_keywords 		= "";

if(isset($_REQUEST['submit'])){

	$name 					= $db->clean($_REQUEST['name']);
	$slug					= $db->rpcreateSlug($_REQUEST['name']);
	$short_desc				= addslashes($db->clean($_REQUEST['short_desc']));
	$meta_title				= $db->clean($_REQUEST['meta_title']);
	$meta_description		= $db->clean($_REQUEST['meta_description']);
	$meta_keywords			= $db->clean($_REQUEST['meta_keywords']);

	/*if(isset($_SESSION['image_path']) && $_SESSION['image_path']!="")
	{
		copy($IMAGEPATH_T.$_SESSION['image_path'], $IMAGEPATH_A.$_SESSION['image_path']);
		$image_path = $_SESSION['image_path'];
		
		unlink($IMAGEPATH_T.$_SESSION['image_path']);
		unset($_SESSION['image_path']);
	}*/

	if(isset($_FILES['image_path']) && !empty($_FILES['image_path']['name']))   
	{
		$img_filename = $_FILES["image_path"]["name"];
		$filetype = $_FILES["image_path"]["type"];
		$filesize = $_FILES["image_path"]["size"];
		
		$img_filename = str_replace(' ', '_', $img_filename);
		$image_path = time()."-feature-brand-".$img_filename;
		move_uploaded_file($_FILES["image_path"]["tmp_name"],$IMAGEPATH_A.$image_path);

		////// - Product Thumb Starts - //////
		
		$image->load($IMAGEPATH_A.$image_path);
		$image->resize(300,100);
		$image->save($IMAGEPATH_A.$image_path);
		////// - Product Thumb Ends - //////
	}

	if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="add")
	{
		$dup_where = "slug = '".$slug."' AND isDelete=0";
		$r = $db->rpdupCheck($ctable,$dup_where);
		if($r){
			$_SESSION['MSG'] = "Duplicate";
			$db->rplocation($add_page_url);
			exit;
		}else{
			$rows 	= array(
					"name",
					"slug",
					"image",
					"short_desc",
					"meta_title",
					"meta_description",
					"meta_keywords",
				);
			$values = array(
					$name,
					$slug,
					$image_path,
					$short_desc,
					$meta_title,
					$meta_description,
					$meta_keywords,
				);
			$last_id =  $db->rpinsert($ctable,$values,$rows);

			$_SESSION['MSG'] = "Inserted";
			$db->rplocation($manage_page_url);
			exit;
		}
		
	}
	else if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="edit")
	{    
		$dup_where = "slug = '".$slug."' AND id!='".$_REQUEST['id']."' AND isDelete=0";
		$r = $db->rpdupCheck($ctable,$dup_where);
		if($r)
		{
			$_SESSION['MSG'] = "Duplicate";
			$db->rplocation($edit_page_url);
			exit;
		}
		else
		{
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


			if($_REQUEST['old_image_path']!="" && $image_path!=""){
				if(file_exists($IMAGEPATH_A.$_REQUEST['old_image_path'])){
					unlink($IMAGEPATH_A.$_REQUEST['old_image_path']);
				}
			}else{
				if($image_path==""){
					$image_path = $_REQUEST['old_image_path'];
					if($image_path == ""){
						$image_path = "";	
					}
				}
			}

			$rows 	= array(
					"name" 					=> $name,
					"slug" 					=> $slug,
					"image"					=> $image_path,
					"short_desc"			=> $short_desc,
					"meta_title"			=> $meta_title,
					"meta_description"		=> $meta_description,
					"meta_keywords"			=> $meta_keywords,
				);

			$where	= "id='".$_REQUEST['id']."' AND isDelete=0";
			$db->rpupdate($ctable,$rows,$where);
			
			$_SESSION['MSG'] = "Updated";
			$db->rplocation($manage_page_url);
			exit;
		}
	}
}

if(isset($_REQUEST['id']) && $_REQUEST['id']>0 && $_REQUEST['mode']=="edit")
{
	$where 		= " id='".$_REQUEST['id']."' AND isDelete=0";
	$ctable_r 	= $db->rpgetData($ctable,"*",$where);
	$ctable_d 	= @mysqli_fetch_array($ctable_r);
	
	$name		= $ctable_d['name'];
	$image_path = stripslashes($ctable_d['image']);
	$short_desc = stripslashes($ctable_d['short_desc']);
	$meta_title			= stripslashes($ctable_d['meta_title']);
	$meta_description	= stripslashes($ctable_d['meta_description']);
	$meta_keywords		= stripslashes($ctable_d['meta_keywords']);
}

if(isset($_REQUEST['id']) && $_REQUEST['id']>0 && $_REQUEST['mode']=="delete")
{
	$id 	= $_REQUEST['id'];
	$rows 	= array("isDelete" => "1");
	
	$db->rpupdate($ctable,$rows,"id='".$id."'");
	
	$_SESSION['MSG'] = "Deleted";
	$db->rplocation($manage_page_url);
	exit;
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
													<label for="name">Name <code>*</code></label>
													<input type="text" class="form-control" value="<?php echo $name; ?>" id="name" name="name">
												</div>

												<div class="form-group">
                                                    <label>Image <code>*</code></label>
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
	                                                        <img src="<?php echo SITEURL.$IMAGEPATH.$image_path;?>" width="300" >
	                                                    </div>
	                                                </div>
	                                                <br><br><br>
												<?php
												}
												?>

												<!-- <div class="form-group">
													<label for="image_path">Image <span class="text-danger">*</span>
													<input type="hidden" name="filename" id="filename" class="form-control" />
													</label>
													<small>minimum image size 310 x 180</small> 
													<div class="row">
														<div class="col-md-6">
															<div id="dropzone" class="dropzone custom-dropzone" data-width="310" data-height="180" data-ghost="false" data-originalsize="false" data-url="<?php echo ADMINURL?>crop_<?php echo $ctable; ?>.php" style="width: 310px;height:180px;">
																<input type="file" id="image_path" name="image_path">
																<input type="hidden" name="old_image_path" value="<?php echo $image_path; ?>" />
															</div>
														</div>
													</div>
													<div class="form-group">
														<?php
														if($image_path!="" && file_exists($IMAGEPATH_A.$image_path)){
														?>
															<img src="<?php echo SITEURL.$IMAGEPATH.$image_path;?>" width="310">
														<?php
														}
														?>
													</div>
												</div> -->

												<div class="form-group">
													<label for="ans">Short Description</label>
													<textarea class="form-control summernote" id="short_desc" name="short_desc"><?php echo $short_desc; ?></textarea>
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
        	var custom_img_width = '310';

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
						name:{required : true},
						image_path:{required : $("#mode").val()=="add" && $("#filename").val()=="" },
						filename:{ required: $("#mode").val()=="add" && $("#filename").val()=="" },
						
					},
					messages: {
						name:{required:"Please enter category name."},
						image_path:{required:"Please upload image."},
						filename:{required:"Please click on right tick mark after upload image."},
					
					}
				});
			});
        </script>
    </body>
</html>