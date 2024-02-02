<?php
include("connect.php");
$db->rpcheckAdminLogin();
include('../include/resize_image.php');
$image = new SimpleImage(); 

$ctable 			= "category";
$ctable1 			= "Category";
$parent_page 		= "product-master"; //for sidebar active menu
$main_page 			= "manage-category"; //for sidebar active menu
$page_title 		= ucwords($_REQUEST['mode'])." ".$ctable1;
$manage_page_url 	= ADMINURL."manage-category/";
$add_page_url 		= ADMINURL."add-category/add/";
$edit_page_url 		= ADMINURL."add-category/edit/".$_REQUEST['id']."/";

$IMAGEPATH_T 		= CATEGORY_T;
$IMAGEPATH_A 		= CATEGORY_A;
$IMAGEPATH 			= CATEGORY;

$IMAGEPATH_BANNER_T = CATE_BANNER_T;
$IMAGEPATH_BANNER_A = CATE_BANNER_A;
$IMAGEPATH_BANNER 	= CATE_BANNER;

$name				    = "";
$slug				    = "";
$image_path			    = "";
$meta_title 		    = "";
$meta_description 	    = "";
$meta_keywords 		    = "";
$banner_image_path	    = "";
$section1title          = "";
$section1_description   = "";
$section1_pnumber       = "";
$section2title          = "";
$section2_description   = "";
$pnumber                = "";
$section3title          = "";
$section3_description   = "";
$section4title          = "";
$section4_description   = "";
$section4_description2  = "";
$section5title          = "";
$section5_description   = "";
$section5_description2  = "";
$rating_no              = "";
$from_review            = "";
$revie_description      = "";
$user_name              = "";
$rating_no2             = "";
$from_review2           = "";
$revie_description2     = "";
$user_name2             = "";

if(isset($_REQUEST['submit'])){

	$name 					= $db->clean($_REQUEST['name']);
	$slug					= $db->rpcreateSlug($_REQUEST['name']);
	$is_display_on_home 	= ($_REQUEST['is_display_on_home']) ? $_REQUEST['is_display_on_home'] : 0;
	$meta_title				= $db->clean($_REQUEST['meta_title']);
	$meta_description		= $db->clean($_REQUEST['meta_description']);
	$meta_keywords			= $db->clean($_REQUEST['meta_keywords']);
	$isCategory_blinds 	    = ($_REQUEST['isCategory_blinds']) ? $_REQUEST['isCategory_blinds'] : 0;
	$section1title          = $db->clean($_REQUEST['section1title']);
	$section1_description   = $db->clean($_REQUEST['section1_description']);
	$section1_pnumber       = $db->clean($_REQUEST['section1_pnumber']);
    $section2title          = $db->clean($_REQUEST['section2title']);
    $section2_description   = $db->clean($_REQUEST['section2_description']);
    $pnumber                = $db->clean($_REQUEST['pnumber']);
    $section3title          = $db->clean($_REQUEST['section3title']);
    $section3_description   = $db->clean($_REQUEST['section3_description']);
    $section4title          = $db->clean($_REQUEST['section4title']);
    $section4_description   = $db->clean($_REQUEST['section4_description']);
    $section4_description2  = $db->clean($_REQUEST['section4_description2']);
    $section5title          = $db->clean($_REQUEST['section5title']);
    $section5_description   = $db->clean($_REQUEST['section5_description']);
    $section5_description2  = $db->clean($_REQUEST['section5_description2']);
    $rating_no              = $db->clean($_REQUEST['rating_no']);
    $from_review            = $db->clean($_REQUEST['from_review']);
    $revie_description      = $db->clean($_REQUEST['revie_description']);
    $user_name              = $db->clean($_REQUEST['user_name']);
    $rating_no2             = $db->clean($_REQUEST['rating_no2']);
    $from_review2           = $db->clean($_REQUEST['from_review2']);
    $revie_description2     = $db->clean($_REQUEST['revie_description2']);
    $user_name2             = $db->clean($_REQUEST['user_name2']);

	if(isset($_SESSION['image_path']) && $_SESSION['image_path']!="")
	{
		copy($IMAGEPATH_T.$_SESSION['image_path'], $IMAGEPATH_A.$_SESSION['image_path']);
		$image_path = $_SESSION['image_path'];
		
		unlink($IMAGEPATH_T.$_SESSION['image_path']);
		unset($_SESSION['image_path']);
	}

	if(isset($_FILES['banner_image_path']) && !empty($_FILES['banner_image_path']['name']))   
	{
		$img_filename = $_FILES["banner_image_path"]["name"];
		$filetype = $_FILES["banner_image_path"]["type"];
		$filesize = $_FILES["banner_image_path"]["size"];
		
		$img_filename = str_replace(' ', '_', $img_filename);
		$banner_image_path = time()."-feature-brand-".$img_filename;
		@move_uploaded_file($_FILES["banner_image_path"]["tmp_name"],$IMAGEPATH_BANNER_A.$banner_image_path);

		////// - Product Thumb Starts - //////
		$image->load($IMAGEPATH_BANNER_A.$banner_image_path);
		$image->resize(1349,360);
		$image->save($IMAGEPATH_BANNER_A.$banner_image_path);
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

			$display_order	= $db->rpgetDisplayOrder($ctable);

			$rows 	= array(
					"name",
					"slug",
					"image",
					"banner_image",
					"is_display_on_home",
					"isCategory_blinds",
					"meta_title",
					"meta_description",
					"meta_keywords",
					"display_order",
					"section1title",
                    "section1_description",
                    "section1_pnumber",
                    "section2title",
                    "section2_description",
                    "pnumber",
                    "section3title",
                    "section3_description",
                    "section4title",
                    "section4_description",
                    "section4_description2",
                    "section5title",
                    "section5_description",
                    "section5_description2",
                    "rating_no",
                    "from_review",
                    "revie_description",
                    "user_name",
                    "rating_no2",
                    "from_review2",
                    "revie_description2",
                    "user_name2",
				);
			$values = array(
					$name,
					$slug,
					$image_path,
					$banner_image_path,
					$is_display_on_home,
					$isCategory_blinds,
					$meta_title,
					$meta_description,
					$meta_keywords,
					$display_order,
					$section1title,
                    $section1_description,
                    $section1_pnumber,
                    $section2title,
                    $section2_description,
                    $pnumber,
                    $section3title,
                    $section3_description,
                    $section4title,
                    $section4_description,
                    $section4_description2,
                    $section5title,
                    $section5_description,
                    $section5_description2,
                    $rating_no,
                    $from_review,
                    $revie_description,
                    $user_name,
                    $rating_no2,
                    $from_review2,
                    $revie_description2,
                    $user_name2,
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
					"name" 					=> $name,
					"slug" 					=> $slug,
					"image"					=> $image_path,
					"banner_image"			=> $banner_image_path,
					"is_display_on_home"	=> $is_display_on_home,
					"isCategory_blinds"     => $isCategory_blinds,
					"meta_title"			=> $meta_title,
					"meta_description"		=> $meta_description,
					"meta_keywords"			=> $meta_keywords,
					"section1title"			=> $section1title,
                    "section1_description"	=> $section1_description,
                    "section1_pnumber"      => $section1_pnumber,
                    "section2title"			=> $section2title,
                    "section2_description"	=> $section2_description,
                    "pnumber"				=> $pnumber,
                    "section3title"			=> $section3title,
                    "section3_description"	=> $section3_description,
                    "section4title"			=> $section4title,
                    "section4_description"	=> $section4_description,
                    "section4_description2"	=> $section4_description2,
                    "section5title"			=> $section5title,
                    "section5_description"	=> $section5_description,
                    "section5_description2"	=> $section5_description2,
                    "rating_no"             => $rating_no,
                    "from_review"           => $from_review,
                    "revie_description"     => $revie_description,
                    "user_name"             => $user_name,
                    "rating_no2"            => $rating_no2,
                    "from_review2"          => $from_review2,
                    "revie_description2"    => $revie_description2,
                    "user_name2"            => $user_name2,
                    
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
	
	$name				    = $ctable_d['name'];
	$image_path 		    = stripslashes($ctable_d['image']);
	$banner_image_path 	    = stripslashes($ctable_d['banner_image']);
	$is_display_on_home     = stripslashes($ctable_d['is_display_on_home']);
	$isCategory_blinds      = stripslashes($ctable_d['isCategory_blinds']);
	$meta_title			    = stripslashes($ctable_d['meta_title']);
	$meta_description   	= stripslashes($ctable_d['meta_description']);
	$meta_keywords		    = stripslashes($ctable_d['meta_keywords']);
	$section1title			= stripslashes($ctable_d['section1title']);
    $section1_description	= stripslashes($ctable_d['section1_description']);
    $section1_pnumber   	= stripslashes($ctable_d['section1_pnumber']);
    $section2title			= stripslashes($ctable_d['section2title']);
    $section2_description	= stripslashes($ctable_d['section2_description']);
    $pnumber				= stripslashes($ctable_d['pnumber']);
    $section3title			= stripslashes($ctable_d['section3title']);
    $section3_description	= stripslashes($ctable_d['section3_description']);
    $section4title			= stripslashes($ctable_d['section4title']);
    $section4_description	= stripslashes($ctable_d['section4_description']);
    $section4_description2	= stripslashes($ctable_d['section4_description2']);
    $section5title			= stripslashes($ctable_d['section5title']);
    $section5_description	= stripslashes($ctable_d['section5_description']);
    $section5_description2	= stripslashes($ctable_d['section5_description2']);
    $rating_no              = stripslashes($ctable_d['rating_no']);
    $from_review            = stripslashes($ctable_d['from_review']);
    $revie_description      = stripslashes($ctable_d['revie_description']);
    $user_name              = stripslashes($ctable_d['user_name']);
    $rating_no2             = stripslashes($ctable_d['rating_no2']);
    $from_review2           = stripslashes($ctable_d['from_review2']);
    $revie_description2     = stripslashes($ctable_d['revie_description2']);
    $user_name2             = stripslashes($ctable_d['user_name2']);
}
else
{
    $isCategory_blinds = 0;
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
													<label for="image_path">Image <span class="text-danger">*</span>
													<input type="hidden" name="filename" id="filename" class="form-control" />
													</label>
													<small>minimum image size 260 x 230</small> 
													<div class="row">
														<div class="col-md-6">
															<div id="dropzone" class="dropzone custom-dropzone" data-width="260" data-height="230" data-ghost="false" data-originalsize="false" data-url="<?php echo ADMINURL?>crop_<?php echo $ctable; ?>.php" style="width: 260px;height:230px;">
																<input type="file" id="image_path" name="image_path">
																<input type="hidden" name="old_image_path" value="<?php echo $image_path; ?>" />
															</div>
														</div>
													</div>
													<div class="form-group">
														<?php
														if($image_path!="" && file_exists($IMAGEPATH_A.$image_path)){
														?>
															<img src="<?php echo SITEURL.$IMAGEPATH.$image_path;?>" width="260">
														<?php
														}
														?>
													</div>
												</div>

												<div class="form-group">
                                                    <label>Banner Image <code>*</code></label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="banner_image_path" name="banner_image_path">
                                                        <label class="custom-file-label" for="banner_image_path">Choose file</label>
                                                    </div>
                                                    <div class="dis_banner_img_err"></div>
                                                </div>
												<input type="hidden" id="old_banner_image_path" name="old_banner_image_path" value="<?php echo $banner_image_path; ?>" />
                                                <?php
												if($banner_image_path!="" && file_exists($IMAGEPATH_BANNER_A.$banner_image_path))
												{
												?>
													<div class="form-group">
	                                                    <label>Uploaded Banner Image</label>
	                                                    <div class="custom-file">
	                                                        <img src="<?php echo SITEURL.$IMAGEPATH_BANNER.$banner_image_path;?>" width="450" >
	                                                    </div>
	                                                </div>
	                                                <br><br><br>
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
												
												<br>
												<div class="form-group col-md-6">
													<label>Is Category Blinds?</label>
													<div class="kt-radio-inline">
														<label class="kt-radio">
															<input type="radio" id="noCheck" onclick="javascript:yesnoCheck();" name="isCategory_blinds" value="0" <?php if($isCategory_blinds=="0"){ echo "checked";}?>> No
														<span></span>
														</label>
														<label class="kt-radio">
															<input type="radio" id="yesCheck" onclick="javascript:yesnoCheck();" name="isCategory_blinds" value="1" <?php if($isCategory_blinds=="1"){ echo "checked";}?>> Yes
														<span></span>
														</label>
													</div>
													<div class="isCategory_blinds_error"></div>
												</div>
												
												<?php
												
												if($isCategory_blinds=="1")
												{ 
												    $style = "block"; 
												}
												else
												{
												    $style = "none";
												}
												
												?>
												<div id="ifYes" style="display:<?php echo $style; ?>">
    												<div class="form-group">
    													<label for="section1title">Section 1 Title</label>
    													<input type="text" class="form-control" value="<?php echo $section1title; ?>" id="section1title" name="section1title">
    												</div>
    												<div class="form-group">
    													<label for="section1_description">Section 1 Description</label>
    													<textarea class="form-control" style="min-height: 110px;" id="section1_description" name="section1_description"><?php echo $section1_description; ?></textarea>
    												</div>
    												<div class="form-group">
    													<label for="section1_pnumber">Section1 Phone Number</label>
    													<input type="text" class="form-control" value="<?php echo $section1_pnumber; ?>" id="section1_pnumber" name="section1_pnumber">
    												</div>
    												
    												<div class="form-group">
    													<label for="section2title">Section 2 Title</label>
    													<input type="text" class="form-control" value="<?php echo $section2title; ?>" id="section2title" name="section2title">
    												</div>
    												<div class="form-group">
    													<label for="section2_description">Section 2 Description</label>
    													<textarea class="form-control" style="min-height: 110px;" id="section2_description" name="section2_description"><?php echo $section2_description; ?></textarea>
    												</div>
    												<!--<div class="form-group col-md-6">
    													<label for="pnumber">Phone Number</label>
    													<input type="number" min="0" step="Any" class="form-control" value="<?php echo $pnumber; ?>" id="pnumber" name="pnumber">
    												</div>-->
    												<div class="form-group">
    													<label for="pnumber">Phone Number</label>
    													<input type="text" class="form-control" value="<?php echo $pnumber; ?>" id="pnumber" name="pnumber">
    												</div>
    												
    												<div class="form-group">
    													<label for="section3title">Section 3 Title</label>
    													<input type="text" class="form-control" value="<?php echo $section3title; ?>" id="section3title" name="section3title">
    												</div>
    												<div class="form-group">
    													<label for="section3_description">Section 3 Description</label>
    													<textarea class="form-control" style="min-height: 110px;" id="section3_description" name="section3_description"><?php echo $section3_description; ?></textarea>
    												</div>
    												
    												<div class="form-group">
    													<label for="section4title">Section 4 Title</label>
    													<input type="text" class="form-control" value="<?php echo $section4title; ?>" id="section4title" name="section4title">
    												</div>
    												<div class="form-group">
    													<label for="section4_description">Section 4 Description 1</label>
    													<textarea class="form-control" style="min-height: 110px;" id="section4_description" name="section4_description"><?php echo $section4_description; ?></textarea>
    												</div>
    												<div class="form-group">
    													<label for="section4_description2">Section 4 Description 2</label>
    													<textarea class="form-control" style="min-height: 110px;" id="section4_description2" name="section4_description2"><?php echo $section4_description2; ?></textarea>
    												</div>
    												
    												<div class="form-group">
    													<label for="section5title">Section 5 Title</label>
    													<input type="text" class="form-control" value="<?php echo $section5title; ?>" id="section5title" name="section5title">
    												</div>
    												<div class="form-group">
    													<label for="section5_description">Section 5 Description 1</label>
    													<textarea class="form-control" style="min-height: 110px;" id="section5_description" name="section5_description"><?php echo $section5_description; ?></textarea>
    												</div>
    												<div class="form-group">
    													<label for="section5_description2">Section 5 Description 2</label>
    													<textarea class="form-control" style="min-height: 110px;" id="section5_description2" name="section5_description2"><?php echo $section5_description2; ?></textarea>
    												</div>
    												
    												<!--Rating 1-->
    												<div class="form-group">
    													<label>Rating</label>
    													<select class="form-control" name="rating_no" id="rating_no" >
    														<option value="">Select Rating</option>
    														<option type="hidden" value="<?php echo $rating_no; ?>" selected></option>
    														<option value="1">1</option>
    														<option value="2">2</option>
    														<option value="3">3</option>
    														<option value="4">4</option>
    														<option value="5">5</option>
    														
    													</select>
												    </div>
    												<div class="form-group">
    													<label for="from_review">From Reviews 1</label>
    													<input type="text" class="form-control" value="<?php echo $from_review; ?>" id="from_review" name="from_review">
    												</div>
    												<div class="form-group">
    													<label for="revie_description">Review Description 1</label>
    													<textarea class="form-control" style="min-height: 110px;" id="revie_description" name="revie_description"><?php echo $revie_description; ?></textarea>
    												</div>
    												<div class="form-group">
    													<label for="user_name">User Name 1</label>
    													<input type="text" class="form-control" value="<?php echo $user_name; ?>" id="user_name" name="user_name">
    												</div>
    												
    												<!--Rating 2-->
    												<div class="form-group">
    													<label>Rating 2</label>
    													<select class="form-control" name="rating_no2" id="rating_no2" >
    														<option value="">Select Rating</option>
    														<option type="hidden" value="<?php echo $rating_no2; ?>" selected></option>
    														<option value="1">1</option>
    														<option value="2">2</option>
    														<option value="3">3</option>
    														<option value="4">4</option>
    														<option value="5">5</option>
    														
    													</select>
												    </div>
    												<div class="form-group">
    													<label for="from_review2">From Reviews 2</label>
    													<input type="text" class="form-control" value="<?php echo $from_review2; ?>" id="from_review2" name="from_review2">
    												</div>
    												<div class="form-group">
    													<label for="revie_description2">Review Description 2</label>
    													<textarea class="form-control" style="min-height: 110px;" id="revie_description2" name="revie_description2"><?php echo $revie_description2; ?></textarea>
    												</div>
    												<div class="form-group">
    													<label for="user_name2">User Name 2</label>
    													<input type="text" class="form-control" value="<?php echo $user_name2; ?>" id="user_name2" name="user_name2">
    												</div>
    												
    											</div>

												<!-- <div class="form-group form-group-last">
													<label>Is Display On Home Page?</label>
													<div class="kt-checkbox-inline">
														<label class="kt-checkbox">
															<input type="checkbox" name="is_display_on_home" id="is_display_on_home" value="1" <?php if($is_display_on_home=="1"){ echo "checked";}?>> Yes
															<span></span>
														</label>
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
        	var custom_img_width = '260';

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
						name:{required : true},
						image_path:{required : $("#mode").val()=="add" && $("#filename").val()=="" },
						filename:{ required: $("#mode").val()=="add" && $("#filename").val()=="" },
						banner_image_path: { required: '#old_banner_image_path:blank' },
					},
					messages: {
						name:{required:"Please enter category name."},
						image_path:{required:"Please upload image."},
						filename:{required:"Please click on right tick mark after upload image."},
						banner_image_path:{required:"Please upload banner image."},
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
						else if (element.attr("name") == "isCategory_blinds") 
						{
							error.insertAfter(".isCategory_blinds_error");
						}
						else
						{
							error.insertAfter(element);
						}
					}
				});
			});
			
			function yesnoCheck() {
                if (document.getElementById('yesCheck').checked) {
                    document.getElementById('ifYes').style.display = 'block';
                }
                else document.getElementById('ifYes').style.display = 'none';
            
            }
        </script>
    </body>
</html>