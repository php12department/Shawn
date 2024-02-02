<?php
include("connect.php");
$db->rpcheckAdminLogin();
include('../include/resize_image.php');
$image = new SimpleImage(); 

$ctable 			= "home_page"; 
$ctable1 			= "Home Page";
$parent_page 		= "static-pages"; //for sidebar active menu
$main_page 			= "manage-home-page"; //for sidebar active menu
$page_title 		= ucwords($_REQUEST['mode'])." ".$ctable1;
$manage_page_url 	= ADMINURL."manage-home-page/";
$add_page_url 		= ADMINURL."add-home-page/add/";
$edit_page_url 		= ADMINURL."add-home-page/edit/".$_REQUEST['id']."/";

$IMAGEPATH_T        = HOME_PAGE_T;
$IMAGEPATH_A        = HOME_PAGE_A; 
$IMAGEPATH          = HOME_PAGE;

$title_1_img = $title1 = $title_2_img = $title2 = $title_3_img = $title3 = $description1 = $button_name = $button_link = $sec3_title = $sec3_desc = $sec3_button_name = $sec3_button_link = $sec4_title = $sec5_title = $title_1_img_file = "";
$meta_title 		= "";
$meta_description 	= "";
$meta_keywords 		= "";

if(isset($_REQUEST['submit']))
{
	$title1			= $db->clean($_REQUEST['title1']);
	$title2			= $db->clean($_REQUEST['title2']);
	$title3			= $db->clean($_REQUEST['title3']);
	$description1	= $db->clean($_REQUEST['description1']);
	$button_name	= $db->clean($_REQUEST['button_name']);
	$button_link	= $db->clean($_REQUEST['button_link']);	
	$sec3_title		= $db->clean($_REQUEST['sec3_title']);	
	$sec3_desc		= $db->clean($_REQUEST['sec3_desc']);	
	$sec3_button_name = $db->clean($_REQUEST['sec3_button_name']);	
	$sec3_button_link = $db->clean($_REQUEST['sec3_button_link']);	
	$sec4_title		= $db->clean($_REQUEST['sec4_title']);	
	$sec5_title		= $db->clean($_REQUEST['sec5_title']);	

	$meta_title				= $db->clean($_REQUEST['meta_title']);
	$meta_description		= $db->clean($_REQUEST['meta_description']);
	$meta_keywords			= $db->clean($_REQUEST['meta_keywords']);

	if(isset($_FILES['title_1_img']) && !empty($_FILES['title_1_img']['name']))   
	{
		$title_1_filename = $_FILES["title_1_img"]["name"];
		$filetype = $_FILES["title_1_img"]["type"];
		$filesize = $_FILES["title_1_img"]["size"];
		
		$title_1_filename = str_replace(' ', '_', $title_1_filename);
		$title_1_img_file = time()."-1-".$title_1_filename;
		move_uploaded_file($_FILES["title_1_img"]["tmp_name"],$IMAGEPATH_A.$title_1_img_file);

		////// - Product Thumb Starts - //////
		
		$image->load($IMAGEPATH_A.$title_1_img_file);
		$image->resize(50,25);
		$image->save($IMAGEPATH_A.$title_1_img_file);
		////// - Product Thumb Ends - //////
	}

	if(isset($_FILES['title_2_img']) && !empty($_FILES['title_2_img']['name']))   
	{
		$title_2_filename = $_FILES["title_2_img"]["name"];
		$filetype = $_FILES["title_2_img"]["type"];
		$filesize = $_FILES["title_2_img"]["size"];
		
		$title_2_filename = str_replace(' ', '_', $title_2_filename);
		$title_2_img_file = time()."-2-".$title_2_filename;
		move_uploaded_file($_FILES["title_2_img"]["tmp_name"],$IMAGEPATH_A.$title_2_img_file);

		////// - Product Thumb Starts - //////
		$image->load($IMAGEPATH_A.$title_2_img_file);
		$image->resize(50,25);
		$image->save($IMAGEPATH_A.$title_2_img_file);
		////// - Product Thumb Ends - //////
	}

	if(isset($_FILES['title_3_img']) && !empty($_FILES['title_3_img']['name']))   
	{
		$title_3_filename = $_FILES["title_3_img"]["name"];
		$filetype = $_FILES["title_3_img"]["type"];
		$filesize = $_FILES["title_3_img"]["size"];
		
		$title_3_filename = str_replace(' ', '_', $title_3_filename);
		$title_3_img_file = time()."-3-".$title_3_filename;
		move_uploaded_file($_FILES["title_3_img"]["tmp_name"],$IMAGEPATH_A.$title_3_img_file);

		////// - Product Thumb Starts - //////
		$image->load($IMAGEPATH_A.$title_3_img_file);
		$image->resize(50,25);
		$image->save($IMAGEPATH_A.$title_3_img_file);
		////// - Product Thumb Ends - //////
	}

	if(isset($_SESSION['image_path1']) && $_SESSION['image_path1']!="")
	{
		copy($IMAGEPATH_T.$_SESSION['image_path1'], $IMAGEPATH_A.$_SESSION['image_path1']);
		$image_path1 = $_SESSION['image_path1'];
		
		unlink($IMAGEPATH_T.$_SESSION['image_path1']);
		unset($_SESSION['image_path1']);
	}

	if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="add")
	{
			/*$rows 	= array(
					"title_1_img",
					"title1",
					"title_2_img",
					"title2",
					"title_3_img",
					"title3",
					"image_path1",
					"description1",
					"button_name",
					"button_link",
					"sec3_title",
					"sec3_desc",
					"sec3_button_name",
					"sec3_button_link",
					"sec4_title",
					"sec5_title",
				);
			$values = array(
					$title_1_img,
					$title1,
					$title_2_img,
					$title2,
					$title_3_img,
					$title3,
					$image_path1,
					$description1,
					$button_name,
					$button_link,
					$sec3_title,
					$sec3_desc,
					$sec3_button_name,
					$sec3_button_link,
					$sec4_title,
					$sec5_title,
				);

			$db->rpinsert($ctable,$values,$rows);

			$_SESSION['MSG'] = 'Inserted';
			$db->rplocation($manage_page_url);*/
	
		
	}
	else if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="edit")
	{
	 
	 	if($_REQUEST['old_title_1_img']!="" && $title_1_img_file!=""){
			if(file_exists($IMAGEPATH_A.$_REQUEST['old_title_1_img'])){
				unlink($IMAGEPATH_A.$_REQUEST['old_title_1_img']);
			}
		}else{
			if($title_1_img_file==""){
				$title_1_img_file = $_REQUEST['old_title_1_img'];
				if($title_1_img_file == ""){
					$title_1_img_file = "";	
				}
			}
		}

		if($_REQUEST['old_title_2_img']!="" && $title_2_img_file!=""){
			if(file_exists($IMAGEPATH_A.$_REQUEST['old_title_2_img'])){
				unlink($IMAGEPATH_A.$_REQUEST['old_title_2_img']);
			}
		}else{
			if($title_2_img_file==""){
				$title_2_img_file = $_REQUEST['old_title_2_img'];
				if($title_2_img_file == ""){
					$title_2_img_file = "";	
				}
			}
		}
		if($_REQUEST['old_title_3_img']!="" && $title_3_img_file!=""){
			if(file_exists($IMAGEPATH_A.$_REQUEST['old_title_3_img'])){
				unlink($IMAGEPATH_A.$_REQUEST['old_title_3_img']);
			}
		}else{
			if($title_3_img_file==""){
				$title_3_img_file = $_REQUEST['old_title_3_img'];
				if($title_3_img_file == ""){
					$title_3_img_file = "";	
				}
			}
		}

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
				"title_1_img"			=> $title_1_img_file,
				"title1"				=> $title1,
				"title_2_img"			=> $title_2_img_file,
				"title2"				=> $title2,
				"title_3_img"			=> $title_3_img_file,
				"title3"				=> $title3,
				"image_path1"			=> $image_path1,
				"description1"			=> $description1,
				"button_name"			=> $button_name,
				"button_link"			=> $button_link,
				"sec3_title"			=> $sec3_title,
				"sec3_desc"				=> $sec3_desc,
				"sec3_button_name"		=> $sec3_button_name,
				"sec3_button_link"		=> $sec3_button_link,
				"sec4_title"			=> $sec4_title,
				"sec5_title"			=> $sec5_title,
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
	
	$title_1_img			= stripslashes($ctable_d['title_1_img']);
	$title1					= stripslashes($ctable_d['title1']);
	$title_2_img			= stripslashes($ctable_d['title_2_img']);
	$title2					= stripslashes($ctable_d['title2']);
	$title_3_img			= stripslashes($ctable_d['title_3_img']);
	$title3					= stripslashes($ctable_d['title3']);
	$image_path1 			= stripslashes($ctable_d['image_path1']);
	$description1			= stripslashes($ctable_d['description1']);
	$button_name			= stripslashes($ctable_d['button_name']);
	$button_link			= stripslashes($ctable_d['button_link']);
	$sec3_title				= stripslashes($ctable_d['sec3_title']);
	$sec3_desc 				= stripslashes($ctable_d['sec3_desc']);
	$sec3_button_name 		= stripslashes($ctable_d['sec3_button_name']);
	$sec3_button_link 		= stripslashes($ctable_d['sec3_button_link']);
	$sec4_title 			= stripslashes($ctable_d['sec4_title']);
	$sec5_title 			= stripslashes($ctable_d['sec5_title']);

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
                                        	<input type="hidden" name="mode" id="mode" value="<?php echo $_REQUEST['mode']; ?>">
											<input type="hidden" name="id" id="id" value="<?php echo $_REQUEST['id']; ?>">
                                        	<div class="kt-portlet__head">
												<div class="kt-portlet__head-label">
													<h3 class="kt-portlet__head-title">
														Section 1 Details
													</h3>
												</div>
											</div>
										    <div class="kt-portlet__body">
												<div class="form-group">
                                                    <label>Image 1 <code>*</code></label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="title_1_img" name="title_1_img">
                                                        <label class="custom-file-label" for="title_1_img">Choose file</label>
                                                    </div>
                                                </div>
                                                <?php
												if($title_1_img!="" && file_exists($IMAGEPATH_A.$title_1_img))	
												{
												?>
													<input type="hidden" name="old_title_1_img" value="<?php echo $title_1_img; ?>" />
													<div class="form-group">
	                                                    <label>Uploade Image 1</label>
	                                                    <div class="custom-file">
	                                                        <img src="<?php echo SITEURL.$IMAGEPATH.$title_1_img;?>" width="50" >
	                                                    </div>
	                                                </div>
												<?php
												}
												?>
												<div class="form-group">
													<label for="title1">Title 1 <code>*</code></label>
													<input type="text" class="form-control" value="<?php echo $title1; ?>" id="title1" name="title1">
												</div>

												<div class="form-group">
                                                    <label>Image 2 <code>*</code></label>
                                                    <div></div>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="title_2_img" name="title_2_img">
                                                        <label class="custom-file-label" for="title_2_img">Choose file</label>
                                                    </div>
                                                </div>
                                                <?php
												if($title_2_img!="" && file_exists($IMAGEPATH_A.$title_2_img))	
												{
												?>
													<input type="hidden" name="old_title_2_img" value="<?php echo $title_2_img; ?>" />
													<div class="form-group">
	                                                    <label>Uploade Image 2</label>
	                                                    <div class="custom-file">
	                                                        <img src="<?php echo SITEURL.$IMAGEPATH.$title_2_img;?>" width="50" >
	                                                    </div>
	                                                </div>
												<?php
												}
												?>
												<div class="form-group">
													<label for="title2">Title 2 <code>*</code></label>
													<input type="text" class="form-control" value="<?php echo $title2; ?>" id="title2" name="title2">
												</div>

												<div class="form-group">
                                                    <label>Image 3 <code>*</code></label>
                                                    <div></div>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="title_3_img" name="title_3_img">
                                                        <label class="custom-file-label" for="title_3_img">Choose file</label>
                                                    </div>
                                                </div>
                                                <?php
												if($title_3_img!="" && file_exists($IMAGEPATH_A.$title_3_img))	
												{
												?>
													<input type="hidden" name="old_title_3_img" value="<?php echo $title_3_img; ?>" />
													<div class="form-group">
	                                                    <label>Uploade Image 3</label>
	                                                    <div class="custom-file">
	                                                        <img src="<?php echo SITEURL.$IMAGEPATH.$title_3_img;?>" width="50" >
	                                                    </div>
	                                                </div>
												<?php
												}
												?>
												<div class="form-group">
													<label for="title3">Title 3 <code>*</code></label>
													<input type="text" class="form-control" value="<?php echo $title3; ?>" id="title3" name="title3">
												</div>

													<!-- <span class="form-text text-muted">Some help text goes here</span> -->
											</div>

											<div class="kt-portlet__head">
												<div class="kt-portlet__head-label">
													<h3 class="kt-portlet__head-title">
														Section 2 Details
													</h3>
												</div>
											</div>
											<div class="kt-portlet__body">
												<div class="form-group">
													<label for="image_path1">Image <code>*</code>
													<input type="hidden" name="filename1" id="filename1" class="form-control" />
													</label>
													<small>minimum image size 732 x 486</small> 
													<div class="row">
														<div class="col-md-6">
															<div id="dropzone" class="dropzone custom-dropzone" data-width="732" data-height="486" data-ghost="false" data-originalsize="false" data-url="<?php echo ADMINURL?>crop_<?php echo $ctable; ?>.php" style="width: 366px;height:243px;">
																<input type="file" id="image_path1" name="image_path1">
																<input type="hidden" name="old_image_path1" value="<?php echo $image_path1; ?>" />
															</div>
														</div>
													</div>
													<div class="form-group">
														<?php
														if($image_path1!="" && file_exists($IMAGEPATH_A.$image_path1)){
														?>
															<img src="<?php echo SITEURL.$IMAGEPATH.$image_path1;?>" width="366">
														<?php
														}
														?>
													</div>
												</div>
												
												<div class="form-group">
													<label for="description1">Description <code>*</code></label>
													<textarea class="form-control summernote" rows="8" id="description1" name="description1" style="min-height: 100px;"><?php echo $description1; ?></textarea>
													<div class="desc_error"></div>
												</div>

												<div class="form-group">
													<label for="button_name">Button Name </label>
													<input type="text" class="form-control" value="<?php echo $button_name; ?>" id="button_name" name="button_name">
												</div>

												<div class="form-group">
													<label for="button_link">Button Link </label>
													<input type="text" class="form-control" value="<?php echo $button_link; ?>" id="button_link" name="button_link">
												</div>
											</div>
											<div class="kt-portlet__head">
												<div class="kt-portlet__head-label">
													<h3 class="kt-portlet__head-title">
														Section 3 Details
													</h3>
												</div>
											</div>
											<div class="kt-portlet__body">
												<div class="form-group">
													<label for="sec3_title">Title <code>*</code></label>
													<input type="text" class="form-control" value="<?php echo $sec3_title; ?>" id="sec3_title" name="sec3_title">
												</div>
												<div class="form-group">
													<label for="ans">Short Description <code>*</code></label>
													<textarea class="form-control summernote" rows="8" id="sec3_desc" name="sec3_desc" style="min-height: 100px;"><?php echo $sec3_desc; ?></textarea>
													<div class="sec3_desc_error"></div>
												</div>

												<div class="form-group">
													<label for="sec3_button_name">Button Name </label>
													<input type="text" class="form-control" value="<?php echo $sec3_button_name; ?>" id="sec3_button_name" name="sec3_button_name">
												</div>

												<div class="form-group">
													<label for="sec3_button_link">Button Link </label>
													<input type="text" class="form-control" value="<?php echo $sec3_button_link; ?>" id="sec3_button_link" name="sec3_button_link">
												</div>
											</div>
											<div class="kt-portlet__head">
												<div class="kt-portlet__head-label">
													<h3 class="kt-portlet__head-title">
														Section 4 Details
													</h3>
												</div>
											</div>
											<div class="kt-portlet__body">
												<div class="form-group">
													<label for="sec4_title">Title <code>*</code></label>
													<input type="text" class="form-control" value="<?php echo $sec4_title; ?>" id="sec4_title" name="sec4_title">
												</div>
											</div>
											<div class="kt-portlet__head">
												<div class="kt-portlet__head-label">
													<h3 class="kt-portlet__head-title">
														Section 5 Details
													</h3>
												</div>
											</div>
											<div class="kt-portlet__body">
												<div class="form-group">
													<label for="sec5_title">Title <code>*</code></label>
													<input type="text" class="form-control" value="<?php echo $sec5_title; ?>" id="sec5_title" name="sec5_title">
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
        	var custom_img_width = '732';

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
						title1:{required : true},
						title2:{required : true},
						title3:{required : true},
						image_path1:{required : $("#mode").val()=="add" && $("#filename1").val()=="" },
						filename1:{ required: $("#mode").val()=="add" && $("#filename1").val()=="" },
						description1:{required : true},
						sec3_title:{required : true},
						sec3_desc:{required : true},
						sec4_title:{required : true},
						sec5_title:{required : true},
					},
					messages: {
						title1:{required:"Please enter title"},
						title2:{required:"Please enter title"},
						title3:{required:"Please enter title"},
						image_path1:{required:"Please upload image"},
						filename1:{required:"Please click on right tick mark after upload image"},
						description1:{required:"Please enter description"},
						sec3_title:{required:"Please enter title"},
						sec3_desc:{required:"Please enter description"},
						sec4_title:{required:"Please enter title"},
						sec5_title:{required:"Please enter title"},
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
						else if (element.attr("name") == "description1") 
						{
							error.insertAfter(".desc_error");
						}
						else if (element.attr("name") == "sec3_desc") 
						{
							error.insertAfter(".sec3_desc_error");
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