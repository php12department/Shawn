<?php
include("connect.php");
$db->rpcheckAdminLogin();

include('../include/resize_image.php');
$image = new SimpleImage(); 

$ctable 			= "sub_category";
$ctable1 			= "Sub Category";
$parent_page 		= "product-master"; //for sidebar active menu
$main_page 			= "manage-sub-category"; //for sidebar active menu
$page_title 		= ucwords($_REQUEST['mode'])." ".$ctable1;
$manage_page_url 	= ADMINURL."manage-sub-category/";
$add_page_url 		= ADMINURL."add-sub-category/add/";
$edit_page_url 		= ADMINURL."add-sub-category/edit/".$_REQUEST['id']."/";

$IMAGEPATH_T 		= SUB_CATEGORY_T;
$IMAGEPATH_A 		= SUB_CATEGORY_A;
$IMAGEPATH 			= SUB_CATEGORY;

$IMAGEPATH_BANNER_T = CATE_BANNER_T;
$IMAGEPATH_BANNER_A = CATE_BANNER_A;
$IMAGEPATH_BANNER 	= CATE_BANNER;

$cate_id		= "";
$name			= "";
$slug			= "";
$image_path		= "";
$banner_image_path		= "";
$meta_title 		= "";
$meta_description 	= "";
$meta_keywords 		= "";

if(isset($_REQUEST['submit']))
{
	$cate_id 		= $db->clean($_REQUEST['cate_id']);
	$name 			= $db->clean($_REQUEST['name']);
	$slug			= $db->rpcreateSlug($_REQUEST['name']);
	$meta_title				= $db->clean($_REQUEST['meta_title']);
	$meta_description		= $db->clean($_REQUEST['meta_description']);
	$meta_keywords			= $db->clean($_REQUEST['meta_keywords']);
	$is_video         	    = ($_REQUEST['is_video']) ? $_REQUEST['is_video'] : 0;

	if(isset($_SESSION['image_path']) && $_SESSION['image_path']!="")
	{
		copy($IMAGEPATH_T.$_SESSION['image_path'], $IMAGEPATH_A.$_SESSION['image_path']);
		$image_path = $_SESSION['image_path'];
		
		unlink($IMAGEPATH_T.$_SESSION['image_path']);
		unset($_SESSION['image_path']);
	}

	if(isset($_FILES['banner_image_path']) && !empty($_FILES['banner_image_path']['name']))   
	{
		if($is_video == 1)
		{
		    $mime = mime_content_type($_FILES['banner_image_path']['name']);
            if(strstr($mime, "video/"))
            {
                // this code for video
            }
            else
            {
                $_SESSION['MSG'] = "FILE_TYPE_ERR";
                $_SESSION['FILE_TYPE_ERR_MSG'] = "Please upload video instead of image.";
                
                $db->rplocation($manage_page_url);
			    exit;
            }
		}
		// else
		// {
		//     $mime = mime_content_type($_FILES['banner_image_path']['name']);
		// 	echo "<pre>";
		// 	print_r(mime_content_type($_FILES['banner_image_path']['name']));
  //           if(strstr($mime, "image/"))
  //           {
  //               // this code for image
  //           }
  //           else
  //           {
  //               $_SESSION['MSG'] = "FILE_TYPE_ERR";
  //               $_SESSION['FILE_TYPE_ERR_MSG'] = "Please upload image instead of video.";
                
		// 	print_r($_FILES);
		// 	die;
  //               $db->rplocation($manage_page_url);
		// 	    exit;
  //           }
		// }
	
		$img_filename = $_FILES["banner_image_path"]["name"];
		$filetype = $_FILES["banner_image_path"]["type"];
		$filesize = $_FILES["banner_image_path"]["size"];
		
		$img_filename = str_replace(' ', '_', $img_filename);
		$banner_image_path = time()."-subcate-".$img_filename;
		if(@move_uploaded_file($_FILES["banner_image_path"]["tmp_name"],$IMAGEPATH_BANNER_A.$banner_image_path))
		{

		}
		else
		{
			print_r($_FILES);
			echo $IMAGEPATH_BANNER_A . $banner_image_path;
			echo $_FILES["banner_image_path"];
			echo "emn";
			die();
		}

		// echo "<pre>";
		// print_r($banner_image_path);
		// 	die;

		////// - Product Thumb Starts - //////
		/*$image->load($IMAGEPATH_BANNER_A.$banner_image_path);
		$image->resize(1349,360);
		$image->save($IMAGEPATH_BANNER_A.$banner_image_path);*/
		////// - Product Thumb Ends - //////
	}

	if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="add")
	{
		$dup_where = "slug = '".$slug."' AND cate_id='".$cate_id."' AND isDelete=0";
		$r = $db->rpdupCheck($ctable,$dup_where);
		if($r){
			$_SESSION['MSG'] = "Duplicate";
			$db->rplocation($add_page_url);
			exit;
		}else{
			$rows 	= array(
					"cate_id",
					"name",
					"slug",
					"image",
					"banner_image",
					"is_video",
					"meta_title",
					"meta_description",
					"meta_keywords",
				);
			$values = array(
					$cate_id,
					$name,
					$slug,
					$image_path,
					$banner_image_path,
					$is_video,
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
		$dup_where = "slug = '".$slug."' AND cate_id='".$cate_id."' AND id!='".$_REQUEST['id']."' AND isDelete=0";
		$r = $db->rpdupCheck($ctable,$dup_where);
		if($r)
		{
			$_SESSION['MSG'] = "Duplicate";
			$db->rplocation($edit_page_url);
			exit;
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

			if($_REQUEST['old_banner_image_path']!="" && $banner_image_path!="")
			{
				if(file_exists($IMAGEPATH_BANNER_A.$_REQUEST['old_banner_image_path']))
				{
					unlink($IMAGEPATH_BANNER_A.$_REQUEST['old_banner_image_path']);
				}
			}
			else
			{
				if($banner_image_path=="")
				{
					$banner_image_path = $_REQUEST['old_banner_image_path'];
					if($banner_image_path == "")
					{
						$banner_image_path = "";	
					}
				}
			}

			$rows 	= array(
					"cate_id" 	  			=> $cate_id,
					"name" 		  			=> $name,
					"slug" 		  			=> $slug,
					"image"		  			=> $image_path,
					"banner_image"			=> $banner_image_path,
					"is_video"              => $is_video,
					"meta_title"			=> $meta_title,
					"meta_description"		=> $meta_description,
					"meta_keywords"			=> $meta_keywords,
				);
				

			$where	= "id='".$_REQUEST['id']."' AND isDelete=0";
			$db->rpupdate($ctable,$rows,$where,0);
			
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
	
	$cate_id			= $ctable_d['cate_id'];
	$name				= $ctable_d['name'];
	$image_path 		= stripslashes($ctable_d['image']);
	$banner_image_path 	= stripslashes($ctable_d['banner_image']);
	$is_video         	= stripslashes($ctable_d['is_video']);
	$meta_title			= stripslashes($ctable_d['meta_title']);
	$meta_description	= stripslashes($ctable_d['meta_description']);
	$meta_keywords		= stripslashes($ctable_d['meta_keywords']);
}
else
{
    $is_video = 0;
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
													<label>Category <code>*</code></label>
													<select class="form-control" name="cate_id" id="cate_id">
														<option value="">Select Category</option>
														<?php
														$pro_cate_r = $db->rpgetData("category","*","isDelete=0");
														while($pro_cate_d = @mysqli_fetch_array($pro_cate_r))
														{
														?>
														<option <?php if($pro_cate_d['id']==$cate_id){ echo "selected";}?> value="<?php echo $pro_cate_d['id']?>"><?php echo $pro_cate_d['name']?></option>
														<?php
														}
														?>
													</select>
												</div>

												<div class="form-group">
													<label for="name">Name <code>*</code></label>
													<input type="text" class="form-control" value="<?php echo $name; ?>" id="name" name="name">
												</div>

												<div class="form-group">
													<label for="image_path">Image <span class="text-danger">*</span>
													<input type="hidden" name="filename" id="filename" class="form-control" />
													</label>
													<small>minimum image size 370 x 242</small> 
													<div class="row">
														<div class="col-md-6">
															<div id="dropzone" class="dropzone custom-dropzone" data-width="370" data-height="242" data-ghost="false" data-originalsize="false" data-url="<?php echo ADMINURL?>crop_<?php echo $ctable; ?>.php" style="width: 370px;height:242px;">
																<input type="file" id="image_path" name="image_path">
																<input type="hidden" name="old_image_path" value="<?php echo $image_path; ?>" />
															</div>
														</div>
													</div>
													<div class="form-group">
														<?php
														if($image_path!="" && file_exists($IMAGEPATH_A.$image_path)){
														?>
															<img src="<?php echo SITEURL.$IMAGEPATH.$image_path;?>" width="370">
														<?php
														}
														?>
													</div>
												</div>
												
												<div class="form-group col-md-6">
													<label>Select Upload Type</label>
													<div class="kt-radio-inline">
														<label class="kt-radio">
															<input type="radio" id="is_video" name="is_video" value="0" <?php if($is_video=="0"){ echo "checked";}?>> Banner Image
														<span></span>
														</label>
														<label class="kt-radio">
															<input type="radio" id="is_video" name="is_video" value="1" <?php if($is_video=="1"){ echo "checked";}?>> Banner Video
														<span></span>
														</label>
													</div>
													<div class="is_video_error"></div>
												</div>
												
												<div class="form-group">
                                                    <label>Banner Image <code>*</code></label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="banner_image_path" name="banner_image_path">
                                                        <label class="custom-file-label" for="banner_image_path">Choose file</label>
                                                    </div>
                                                    <div class="dis_banner_img_err"></div>
                                                </div>
                                                <input type="hidden" name="old_banner_image_path" id="old_banner_image_path" value="<?php echo $banner_image_path; ?>" />
                                                <?php
												if($banner_image_path!="" && file_exists($IMAGEPATH_BANNER_A.$banner_image_path))
												{
												?>
													<div class="form-group">
													    <?php
												        if($is_video=="1")
        												{ 
        												    ?>
        												    <label>Uploaded Banner Video</label>
        												    <div class="custom-file">
        												        <video width="450" height="240" controls>
                                                                  <source src="<?php echo SITEURL.$IMAGEPATH_BANNER.$banner_image_path;?>" type="video/mp4">
                                                                </video>
    	                                                    </div>
        												    <?php
        												}
        												else
        												{
        												    ?>
        												    <label>Uploaded Banner Image</label>
        												    <div class="custom-file">
    	                                                        <img src="<?php echo SITEURL.$IMAGEPATH_BANNER.$banner_image_path;?>" width="450">
    	                                                    </div>
        												    <?php
        												}
													    ?>
	                                                    
	                                                </div>
	                                                <br><br>
												<?php
												}
												?>

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
        	var custom_img_width = '370';

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
					ignore: [],
					rules: {
						cate_id:{required : true,},
						name:{required : true,},
						is_video:{required : true,},
						image_path:{required : $("#mode").val()=="add" && $("#filename").val()=="" },
						filename:{ required: $("#mode").val()=="add" && $("#filename").val()=="" },
						banner_image_path: { required: '#old_banner_image_path:blank' },
					},
					messages: {
						cate_id:{required:"Please select category."},
						name:{required:"Please enter category name."},
						is_video:{required : "Please select upload type."},
						image_path:{required:"Please upload image."},
						filename:{required:"Please click on right tick mark after upload image."},
						banner_image_path:{required:"This field is required."},
					},
					errorPlacement: function(error, element) 
					{
						if (element.attr("name") == "image_path") 
						{
							error.insertAfter("#dropzone");
						}
						else if (element.attr("name") == "filename") 
						{
							error.insertAfter("#dropzone");
						}
						else if (element.attr("name") == "banner_image_path") 
						{
							error.insertAfter(".dis_banner_img_err");
						} 
						else if (element.attr("name") == "is_video") 
						{
							error.insertAfter(".is_video_error");
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