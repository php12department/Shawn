<?php
include("connect.php");
$db->rpcheckAdminLogin();

$ctable 			= "events";
$ctable1 			= "Events";
$parent_page 		= "news-events"; //for sidebar active menu
$main_page 			= "manage-events-news"; //for sidebar active menu
$page_title 		= ucwords($_REQUEST['mode'])." Event/News";
$manage_page_url 	= ADMINURL."manage-events-news/";
$add_page_url 		= ADMINURL."add-events-news/add/";
$edit_page_url 		= ADMINURL."add-events-news/edit/".$_REQUEST['id']."/";

$IMAGEPATH_T 		= EVENT_T;
$IMAGEPATH_A 		= EVENT_A; 
$IMAGEPATH 			= EVENT;
$IMAGEPATH_THUMB_A 	= EVENT_THUMB_A;

$title	= $description = $image_path = "";
$meta_title 		= "";
$meta_description 	= "";
$meta_keywords 		= "";

if(isset($_REQUEST['submit']))
{
	$title					= $db->clean($_REQUEST['title']);
	$slug					= $db->rpcreateSlug($_REQUEST['title']);
	$added_by				= $db->clean($_REQUEST['added_by']);
	$event_cat				= $db->clean($_REQUEST['event_cat']);
	$event_date				= date("Y-m-d",strtotime($_REQUEST['event_date']));
	$description			= $db->clean($_REQUEST['description']);
	$isEvent 				= (isset($_REQUEST['isEvent'])) ? $_REQUEST['isEvent'] : 0;
	$meta_title				= $db->clean($_REQUEST['meta_title']);
	$meta_description		= $db->clean($_REQUEST['meta_description']);
	$meta_keywords			= $db->clean($_REQUEST['meta_keywords']);
	$adate  				= date('Y-m-d H:i:s');
		
	if(isset($_SESSION['image_path']) && $_SESSION['image_path']!="")
	{
		copy($IMAGEPATH_T.$_SESSION['image_path'], $IMAGEPATH_A.$_SESSION['image_path']);
		$image_path = $_SESSION['image_path'];
		
		////// - Product Thumb Starts - //////
		include('../include/resize_image.php');
		$image = new SimpleImage(); 
		$image->load($IMAGEPATH_A.$image_path);
		$image->resize(281,169);
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
					"added_by",
					"title",
					"slug",
					"event_cat",
					"event_date",
					"image_path",
					"description",
					"isEvent",
					"meta_title",
					"meta_description",
					"meta_keywords",
					"adate",
				);
			$values = array(
					$added_by,
					$title,
					$slug,
					$event_cat,
					$event_date,
					$image_path,
					$description,
					$isEvent,
					$meta_title,
					$meta_description,
					$meta_keywords,
					$adate,
				);

			$db->rpinsert($ctable,$values,$rows);

			$_SESSION['MSG'] = 'Inserted';
			$db->rplocation($manage_page_url);
		}
		
	}
	else if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="edit")
	{
		$dup_where = "slug = '".$slug."' AND id!='".$_REQUEST['id']."' AND isDelete=0";
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
					"title"					=> $title,
					"slug"					=> $slug,
					"added_by"				=> $added_by,
					"event_cat"				=> $event_cat,
					"event_date"			=> $event_date,
					"image_path"			=> $image_path,
					"description"			=> $description,
					"isEvent"				=> $isEvent,
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
}

if(isset($_REQUEST['id']) && $_REQUEST['id']>0 && $_REQUEST['mode']=="edit")
{
	$where 		= " id='".$_REQUEST['id']."' AND isDelete=0";
	$ctable_r 	= $db->rpgetData($ctable,"*",$where);
	$ctable_d 	= @mysqli_fetch_array($ctable_r);
	
	$title					= stripslashes($ctable_d['title']);
	$event_cat				= $ctable_d['event_cat'];
	$added_by				= stripslashes($ctable_d['added_by']);
	$event_date				= date("m/d/Y",strtotime($ctable_d['event_date']));
	$description			= stripslashes($ctable_d['description']);
	$image_path 			= stripslashes($ctable_d['image_path']);
	$isEvent				= stripslashes($ctable_d['isEvent']);
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
													<label for="title">Title <code>*</code></label>
													<input type="text" class="form-control" value="<?php echo $title; ?>" id="title" name="title">
												</div>
												
												<div class="form-group">
													<label for="added_by">Author name <code>*</code></label>
													<input type="text" class="form-control" value="<?php echo $added_by; ?>" id="added_by" name="added_by">
												</div>

												<div class="form-group">
													<label for="aid">Event/News Category <span class="text-danger">*</span></label>
													<select class="form-control" name="event_cat" id="event_cat" >
														<option value="">Select Event/News Category</option>
														<?php
														$cate_r = $db->rpgetData("events_category","*","isDelete=0");
														if(@mysqli_num_rows($cate_r)>0){
															while($cate_d = @mysqli_fetch_array($cate_r)){
															?>
															<option value="<?php echo $cate_d['id']; ?>" <?php if($cate_d['id']==$event_cat){?> selected <?php } ?>><?php echo $cate_d['cat_name']; ?></option>
															<?php
															}
														}
														?>
													</select>
												</div>

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
															<img src="<?php echo SITEURL.$IMAGEPATH.$image_path;?>" width="435">
														<?php
														}
														?>
													</div>
												</div>
												
												<div class="form-group">
													<label for="ans">Description <span class="text-danger">*</span></label>
													<textarea class="form-control summernote" rows="8" id="description" name="description" style="min-height: 100px;"><?php echo $description; ?></textarea>
												</div>

												<div class="form-group">
													<label for="title">Event/News Date <code>*</code></label>
													<div class="input-group date dis_event_date_err">
	                                                    <input type="text" class="form-control" readonly  placeholder="Select start date" name='event_date' id="start_date" value="<?php echo $event_date; ?>" />
	                                                    <div class="input-group-append">
	                                                        <span class="input-group-text">
	                                                        <i class="la la-calendar-check-o"></i>
	                                                        </span>
	                                                    </div>
	                                                </div>
												</div>

												<div class="form-group">
													<label>Event/News</label>
													<div class="kt-radio-inline">
														<label class="kt-radio">
															<input type="radio" name="isEvent" name="events" value="0" <?php echo ($isEvent==0)?"checked":"" ?>> Events
														<span></span>
														</label>
														<label class="kt-radio">
															<input type="radio" name="isEvent" name="news" value="1" <?php echo ($isEvent==1)?"checked":"" ?>>News
														<span></span>
														</label>
													</div>
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
        	var custom_img_width = '870';

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
						title:{required : true},
						added_by:{required : true},
						event_date:{required : true},
						description:{required : true},
						image_path:{required : $("#mode").val()=="add" && $("#filename").val()=="" },
						filename:{ required: $("#mode").val()=="add" && $("#filename").val()=="" },
					},
					messages: {
						title:{required:"Please Enter Event/News Title."},
						added_by:{required:"Please Enter Author Name."},
						event_date:{required:"Please Select Event Date."},
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

						if (element.attr("name") == "event_date") 
		    			{
		    				error.insertAfter(".dis_event_date_err");
		    			}else
		    			{
		    				error.insertAfter(element);
		    			}

					}
				});
			});
        </script>
    </body>
</html>