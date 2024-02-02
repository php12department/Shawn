<?php
include("connect.php");
$db->rpcheckAdminLogin();

$ctable             = "store";
$ctable1            = "Store details";
$parent_page        = "static-pages"; //for sidebar active menu
$main_page          = "manage-store"; //for sidebar active menu
$page_title 		= ucwords($_REQUEST['mode'])." Store details";
$manage_page_url 	= ADMINURL."manage-store/";
$add_page_url 		= ADMINURL."add-store/add/";
$edit_page_url 		= ADMINURL."add-store/edit/".$_REQUEST['id']."/";

$IMAGEPATH_T        = STORE_T;
$IMAGEPATH_A        = STORE_A; 
$IMAGEPATH          = STORE;
$IMAGEPATH_THUMB_A  = STORE_THUMB_A;

$title	= $description = $image_path = "";
$meta_title 		= "";
$meta_description 	= "";
$meta_keywords 		= "";

$details_page_meta_title 		= "";
$details_page_meta_description 	= "";
$details_page_meta_keywords 	= "";

if(isset($_REQUEST['submit']))
{
	// $map_embed					= $_REQUEST['map_embed'];
	$text							= $db->clean($_REQUEST['text']);
	$address						= $db->clean($_REQUEST['address']);
	// $phone							= $db->clean($_REQUEST['phone']);
	$description					= $db->clean($_REQUEST['description']);
	/*$store_hours_monday				= $db->clean($_REQUEST['store_hours_monday']);
	$store_hours_tueday				= $db->clean($_REQUEST['store_hours_tueday']);
	$store_hours_wednesday			= $db->clean($_REQUEST['store_hours_wednesday']);
	$store_hours_thursdayday		= $db->clean($_REQUEST['store_hours_thursdayday']);
	$store_hours_fridayday			= $db->clean($_REQUEST['store_hours_fridayday']);
	$store_hours_saturday			= $db->clean($_REQUEST['store_hours_saturday']);
	$store_hours_sunday				= $db->clean($_REQUEST['store_hours_sunday']);*/
	$description_title				= $db->clean($_REQUEST['description_title']);
	$text_title						= $db->clean($_REQUEST['text_title']);
	$meta_title						= $db->clean($_REQUEST['meta_title']);
	$meta_description				= $db->clean($_REQUEST['meta_description']);
	$meta_keywords					= $db->clean($_REQUEST['meta_keywords']);

	$details_page_meta_title		= $db->clean($_REQUEST['details_page_meta_title']);
	$details_page_meta_description	= $db->clean($_REQUEST['details_page_meta_description']);
	$details_page_meta_keywords		= $db->clean($_REQUEST['details_page_meta_keywords']);

	$adate  						= date('Y-m-d H:i:s');
		
	if(isset($_SESSION['image_path']) && $_SESSION['image_path']!="")
	{
		copy($IMAGEPATH_T.$_SESSION['image_path'], $IMAGEPATH_A.$_SESSION['image_path']);
		$image_path = $_SESSION['image_path'];
		
		////// - Product Thumb Starts - //////
		include('../include/resize_image.php');
		$image = new SimpleImage(); 
		$image->load($IMAGEPATH_A.$image_path);
		$image->resize(92,114);
		$image->save($IMAGEPATH_THUMB_A.$image_path);
		////// - Product Thumb Ends - //////
		
		unlink($IMAGEPATH_T.$_SESSION['image_path']);
		unset($_SESSION['image_path']);
	}
	
	if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="add")
	{
		$dup_where = "slug = '".$slug."' AND isDelete=0";
		$r = $db->rpdupCheck($ctable,$dup_where);
		if($r)
		{
			$_SESSION['MSG'] = 'Duplicate';
			$db->rplocation($add_page_url);
			die;
		}
		else
		{
			
			$display_order	= $db->rpgetDisplayOrder($ctable);

			$rows 	= array(
					"image_path",
					// "map_embed",
					"text_title",
					"text",
					// "address",
					// "phone",
					"description",
					/*"store_hours_monday",
					"store_hours_tueday",
					"store_hours_wednesday",
					"store_hours_thursdayday",
					"store_hours_fridayday",
					"store_hours_saturday",
					"store_hours_sunday",*/
					"description_title",
					"meta_title",
					"meta_description",
					"meta_keywords",
					"details_page_meta_title",
					"details_page_meta_description",
					"details_page_meta_keywords",
					"adate",
				);
			$values = array(
					$image_path,
					// $map_embed,
					$text_title,
					$text,
					// $address,
					// $phone,
					$description,
					/*$store_hours_monday,
					$store_hours_tueday,
					$store_hours_wednesday,
					$store_hours_thursdayday,
					$store_hours_fridayday,
					$store_hours_saturday,
					$store_hours_sunday,*/
					$description_title,
					$meta_title,
					$meta_description,
					$meta_keywords,
					$details_page_meta_title,
					$details_page_meta_description,
					$details_page_meta_keywords,
					$adate,
				);

			$db->rpinsert($ctable,$values,$rows);

			$_SESSION['MSG'] = 'Inserted';
			$db->rplocation($manage_page_url);
		}
		
	}
	else if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="edit")
	{
		$dup_where =" id!='".$_REQUEST['id']."' AND isDelete=0";
		$r = $db->rpdupCheck($ctable,$dup_where);
		if($r)
		{
			$_SESSION['MSG'] = 'Duplicate';
			$db->rplocation($edit_page_url);
			die;
		}
		else
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
					"image_path"					=> $image_path,
					// "map_embed"					=> $map_embed,
					"text_title"					=> $text_title,
					"text"							=> $text,
					/*"address"						=> $address,
					"phone"							=> $phone,*/
					"description"					=> $description,
					/*"store_hours_monday"			=> $store_hours_monday,
					"store_hours_tueday"			=> $store_hours_tueday,
					"store_hours_wednesday"			=> $store_hours_wednesday,
					"store_hours_thursdayday"		=> $store_hours_thursdayday,
					"store_hours_fridayday"			=> $store_hours_fridayday,
					"store_hours_saturday"			=> $store_hours_saturday,
					"store_hours_sunday"			=> $store_hours_sunday,*/
					"description_title"				=> $description_title,
					"meta_title"					=> $meta_title,
					"meta_description"				=> $meta_description,
					"meta_keywords"					=> $meta_keywords,
					"details_page_meta_title"		=> $details_page_meta_title,
					"details_page_meta_description"	=> $details_page_meta_description,
					"details_page_meta_keywords"	=> $details_page_meta_keywords,
				);

			$where	= "id='".$_REQUEST['id']."' AND isDelete=0";
			$db->rpupdate($ctable,$rows,$where);

			$_SESSION['MSG'] = 'Updated';
			$db->rplocation($manage_page_url);
		}
	}
}

if(isset($_REQUEST['id']) && $_REQUEST['id']>0 && $_REQUEST['mode']=="edit")
{
	$where 		= " id='".$_REQUEST['id']."' AND isDelete=0";
	$ctable_r 	= $db->rpgetData($ctable,"*",$where);
	$ctable_d 	= @mysqli_fetch_array($ctable_r);
	
	$image_path 					= stripslashes($ctable_d['image_path']);
	// $map_embed 					= $ctable_d['map_embed'];
	$text_title						= stripslashes($ctable_d['text_title']);
	$text							= stripslashes($ctable_d['text']);
	/*$address						= stripslashes($ctable_d['address']);
	$phone							= stripslashes($ctable_d['phone']);*/
	$description					= stripslashes($ctable_d['description']);
	/*$store_hours_monday				= stripslashes($ctable_d['store_hours_monday']);
	$store_hours_tueday				= stripslashes($ctable_d['store_hours_tueday']);
	$store_hours_wednesday			= stripslashes($ctable_d['store_hours_wednesday']);
	$store_hours_thursdayday		= stripslashes($ctable_d['store_hours_thursdayday']);
	$store_hours_fridayday			= stripslashes($ctable_d['store_hours_fridayday']);
	$store_hours_saturday			= stripslashes($ctable_d['store_hours_saturday']);
	$store_hours_sunday				= stripslashes($ctable_d['store_hours_sunday']);*/
	$description_title				= stripslashes($ctable_d['description_title']);
	$meta_title						= stripslashes($ctable_d['meta_title']);
	$meta_description				= stripslashes($ctable_d['meta_description']);
	$meta_keywords					= stripslashes($ctable_d['meta_keywords']);

	$details_page_meta_title		= stripslashes($ctable_d['details_page_meta_title']);
	$details_page_meta_description	= stripslashes($ctable_d['details_page_meta_description']);
	$details_page_meta_keywords		= stripslashes($ctable_d['details_page_meta_keywords']);
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
													<label for="text_title">Text Title<code>*</code></label>
													<input type="text" class="form-control" value="<?php echo $text_title; ?>" id="text_title" name="text_title">
												</div>

												<div class="form-group">
													<label for="text">Text <code>*</code></label>
													<input type="text" class="form-control" value="<?php echo $text; ?>" id="text" name="text">
												</div>
												
												<!-- <div class="form-group">
													<label for="added_by">Address <code>*</code></label>
													<textarea class="form-control" rows="3" id="address" name="address" style="min-height: 100px;"><?php echo $address; ?></textarea>
												</div>
												
												<div class="form-group">
													<label for="added_by">Map embedded Code <code>*</code></label>
													<textarea class="form-control" rows="3" id="map_embed" name="map_embed" style="min-height: 100px;"><?php echo $map_embed; ?></textarea>
												</div>
												
												<div class="form-group">
													<label for="phone">Phone <code>*</code></label>
													<input type="text" class="form-control" value="<?php echo $phone; ?>" id="phone" name="phone">
												</div> -->

												<div class="form-group">
													<label for="image_path">Image <span class="text-danger">*</span>
													<input type="hidden" name="filename" id="filename" class="form-control" />
													</label>
													<small>minimum image size 870 x 522</small> 
													<div class="row">
														<div class="col-md-6">
															<div id="dropzone" class="dropzone custom-dropzone" data-width="870" data-height="522" data-ghost="false" data-originalsize="false" data-url="<?php echo ADMINURL?>crop_<?php echo $ctable; ?>.php" style="width: 435px;height:261px;">
																<input type="file" id="image_path" name="image_path">
																<input type="hidden" name="old_image_path" value="<?php echo $image_path; ?>" />
															</div>
														</div>
													</div>
													<div class="form-group">
														<?php
														if($image_path!="" && file_exists($IMAGEPATH_A.$image_path)){
														?>
															<img src="<?php echo SITEURL.$IMAGEPATH."/".$image_path;?>" width="435">
														<?php
														}
														?>
													</div>
												</div>
												<div class="form-group">
													<label for="description_title">Description Title<code>*</code></label>
													<input type="text" class="form-control" value="<?php echo $description_title; ?>" id="description_title" name="description_title">
												</div>
												<div class="form-group">
													<label for="ans">Description <span class="text-danger">*</span></label>
													<textarea class="form-control summernote" rows="8" id="description" name="description" style="min-height: 100px;"><?php echo $description; ?></textarea>
												</div>

											

												<!-- <div class="form-group">
													<label for="store_hours_monday">Store hours of monday <code>*</code></label>
													<input type="text" class="form-control" value="<?php echo $store_hours_monday; ?>" id="store_hours_monday" name="store_hours_monday">
												</div>
												
												<div class="form-group">
													<label for="store_hours_tueday">Store hours of tuesday <code>*</code></label>
													<input type="text" class="form-control" value="<?php echo $store_hours_tueday; ?>" id="store_hours_tueday" name="store_hours_tueday">
												</div>
												
												<div class="form-group">
													<label for="store_hours_wednesday">Store hours of Wednesday <code>*</code></label>
													<input type="text" class="form-control" value="<?php echo $store_hours_wednesday; ?>" id="store_hours_wednesday" name="store_hours_wednesday">
												</div>
												
												<div class="form-group">
													<label for="store_hours_thursdayday">Store hours of Thursday <code>*</code></label>
													<input type="text" class="form-control" value="<?php echo $store_hours_thursdayday; ?>" id="store_hours_thursdayday" name="store_hours_thursdayday">
												</div>
												
												<div class="form-group">
													<label for="store_hours_fridayday">Store hours of Friday <code>*</code></label>
													<input type="text" class="form-control" value="<?php echo $store_hours_fridayday; ?>" id="store_hours_fridayday" name="store_hours_fridayday">
												</div>
												
												<div class="form-group">
													<label for="store_hours_saturday">Store hours of Saturday <code>*</code></label>
													<input type="text" class="form-control" value="<?php echo $store_hours_saturday; ?>" id="store_hours_saturday" name="store_hours_saturday">
												</div>
												
												<div class="form-group">
													<label for="store_hours_sunday">Store hours of Sunday <code>*</code></label>
													<input type="text" class="form-control" value="<?php echo $store_hours_sunday; ?>" id="store_hours_sunday" name="store_hours_sunday">
												</div> -->
												<div class="form-group">
													<label for="meta_title">Meta Title (Store Location Page)</label>
													<textarea class="form-control" style="min-height: 110px;" id="meta_title" name="meta_title"><?php echo $meta_title; ?></textarea>
												</div>

												<div class="form-group">
													<label for="meta_description">Meta Description (Store Location Page)</label>
													<textarea class="form-control" style="min-height: 110px;" id="meta_description" name="meta_description"><?php echo $meta_description; ?></textarea>
												</div>

												<div class="form-group">
													<label for="meta_keywords">Meta Keywords (Store Location Page)</label>
													<textarea class="form-control" style="min-height: 110px;" id="meta_keywords" name="meta_keywords"><?php echo $meta_keywords; ?></textarea>
												</div>

												<div class="form-group">
													<label for="details_page_meta_title">Meta Title (Store Location Details Page)</label>
													<textarea class="form-control" style="min-height: 110px;" id="details_page_meta_title" name="details_page_meta_title"><?php echo $details_page_meta_title; ?></textarea>
												</div>

												<div class="form-group">
													<label for="details_page_meta_description">Meta Description (Store Location Details Page)</label>
													<textarea class="form-control" style="min-height: 110px;" id="details_page_meta_description" name="details_page_meta_description"><?php echo $details_page_meta_description; ?></textarea>
												</div>

												<div class="form-group form-group-last">
													<label for="details_page_meta_keywords">Meta Keywords (Store Location Details Page)</label>
													<textarea class="form-control" style="min-height: 110px;" id="details_page_meta_keywords" name="details_page_meta_keywords"><?php echo $details_page_meta_keywords; ?></textarea>
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

		  	$(function(){
				$("#frm").validate({
					rules: {
						text_title:{required : true},
						text:{required : true},
						description_title:{required : true},
						description:{required : true},
						image_path:{required : $("#mode").val()=="add" && $("#filename").val()=="" },
						filename:{ required: $("#mode").val()=="add" && $("#filename").val()=="" },
					},
					messages: {
						text_title:{required:"Please Enter Text title."},
						text:{required:"Please Enter Text."},
						description_title:{required:"Please Enter Description Title."},
						description:{required:"Please Enter Description."},
						image_path:{required:"Please upload image."},
						filename:{required:"Please click on right tick mark after upload image."},
					},
					errorPlacement: function(error, element) {
						if (element.attr("name") == "image_path") {
							error.insertAfter("#dropzone");
						}else if (element.attr("name") == "filename") {
							error.insertAfter("#dropzone");
						} else if (element.attr("name") == "description") 
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