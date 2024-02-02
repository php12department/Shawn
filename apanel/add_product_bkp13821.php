<?php
include("connect.php");
$db->rpcheckAdminLogin();
include('../include/resize_image.php');
$image = new SimpleImage(); 


$ctable 			= "product";
$ctable1 			= "Product";
$parent_page 		= "product-master"; //for sidebar active menu
$main_page 			= "manage-product"; //for sidebar active menu
$page_title 		= ucwords($_REQUEST['mode'])." ".$ctable1;
$manage_page_url 	= ADMINURL."manage-product/";
$add_page_url 		= ADMINURL."add-product/add/";
$edit_page_url 		= ADMINURL."add-product/edit/".$_REQUEST['id']."/";

$IMAGEPATH_T 				= PRODUCT_T;
$IMAGEPATH_A 				= PRODUCT_A;
$IMAGEPATH 					= PRODUCT;
$IMAGEPATH_THUMB_A 			= PRODUCT_THUMB_A;
$IMAGEPATH_LIST_THUMB_A 	= PRODUCT_LIST_THUMB_A;

$name 					= "";
$cate_id 				= "0";
$sub_cate_id 			= "0";
$sub_sub_cate_id 		= "0";
$pro_group_id 			= "0";
$color_id 				= "0";
$material_id 			= "0";
$pro_feature_brand 		= "0";
$decs					= "";
$feature_dimension		= "";
$additional_info		= "";
$image_path				= "";
$sell_price				= "";
$pro_sku				= "";
$status					= "";
$meta_title 			= "";
$meta_description 		= "";
$meta_keywords 			= "";
$variation 			    = "";
$variation_slug			= "";

if(isset($_REQUEST['submit']))
{
	/*echo "<pre>";
	print_r($_REQUEST);
	die();*/

	$cate_id				= $db->clean($_REQUEST['cate_id']);
	$sub_cate_id			= $db->clean($_REQUEST['sub_cate_id']);
	$sub_sub_cate_id		= $db->clean($_REQUEST['sub_sub_cate_id']);
	$pro_group_id			= $db->clean($_REQUEST['pro_group_id']);
	$color_id				= $db->clean($_REQUEST['color_id']);
	$material_id			= $db->clean($_REQUEST['material_id']);
	$pro_feature_brand		= $db->clean($_REQUEST['pro_feature_brand']);
	$name					= $db->clean($_REQUEST['name']);
	$slug					= $db->rpcreateSlug($_REQUEST['name']);
	$variation				= $db->clean($_REQUEST['variation']);
	$variation_slug			= $db->rpcreateSlug($_REQUEST['variation']);
	$price					= trim($_REQUEST['price']);
	$sell_price				= trim($_REQUEST['sell_price']);
	$pro_sku					= $db->clean($_REQUEST['pro_sku']);
	$decs					= addslashes($db->clean($_REQUEST['decs']));
	$feature_dimension		= addslashes($db->clean($_REQUEST['feature_dimension']));
	$additional_info		= addslashes($db->clean($_REQUEST['additional_info']));
	$status 				= $db->clean($_REQUEST['status']);

	$isImage 				= ($_REQUEST['isImage']) ? $_REQUEST['isImage'] : 0;
	$isProduct 				= ($_REQUEST['isProduct']) ? $_REQUEST['isProduct'] : 0;
	$isDisplayHomePage 		= ($_REQUEST['isDisplayHomePage']) ? $_REQUEST['isDisplayHomePage'] : 0;
	$isDisplayCategoryPage 	= ($_REQUEST['isDisplayCategoryPage']) ? $_REQUEST['isDisplayCategoryPage'] : 0;
	$isEnquiry_product 	    = ($_REQUEST['isEnquiry_product']) ? $_REQUEST['isEnquiry_product'] : 0;
	/*$is_trending 			= ($_REQUEST['is_trending']) ? $_REQUEST['is_trending'] : 0;
	$is_top_new 			= ($_REQUEST['is_top_new']) ? $_REQUEST['is_top_new'] : 0;*/
	$meta_title				= $db->clean($_REQUEST['meta_title']);
	$meta_description		= $db->clean($_REQUEST['meta_description']);
	$meta_keywords			= $db->clean($_REQUEST['meta_keywords']);

	if(isset($_FILES['image_path']) && !empty($_FILES['image_path']['name']))   
	{
		$img_filename = $_FILES["image_path"]["name"];
		$filetype = $_FILES["image_path"]["type"];
		$filesize = $_FILES["image_path"]["size"];
		
		$img_filename = str_replace(' ', '_', $img_filename);
		$image_path = time()."-pro-".$img_filename;
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
		
		////// - Product Thumb Starts - product details page //////
		$image->load($IMAGEPATH_A.$image_path);
		$image->resize(154,106);
		$image->save($IMAGEPATH_THUMB_A.$image_path);
		////// - Product Thumb Ends - product details page //////

		////// - Categorywise Product List Thumb Starts - //////
		$image->load($IMAGEPATH_A.$image_path);
		$image->resize(270,200);
		$image->save($IMAGEPATH_LIST_THUMB_A.$image_path);
		////// - Categorywise Product List Thumb Ends - //////
		
		unlink($IMAGEPATH_T.$_SESSION['image_path']);
		unset($_SESSION['image_path']);
	}*/
	
	if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="add")
	{
		$dup_where = "slug = '".$slug."' AND cate_id='".$cate_id."' AND sub_cate_id='".$sub_cate_id."' AND sub_sub_cate_id='".$sub_sub_cate_id."' AND isDelete=0";
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
					"cate_id",
					"sub_cate_id",
					"sub_sub_cate_id",
					"pro_group_id",
					"color_id",
					"material_id",
					"pro_feature_brand",
					"name",
					"variation",
					"variation_slug",
					"price",
					"sell_price",
					"pro_sku",
					"slug",
					"isImage",
					"image",
					"decs",
					"feature_dimension",
					"additional_info",
					"status",
					"isProduct",
					"isDisplayHomePage",
					"isDisplayCategoryPage",
					"isEnquiry_product",
					/*"is_trending",
					"is_top_new",*/
					"display_order",
					"meta_title",
					"meta_description",
					"meta_keywords",
				);
			$values = array(
					$cate_id,
					$sub_cate_id,
					$sub_sub_cate_id,
					$pro_group_id,
					$color_id,
					$material_id,
					$pro_feature_brand,
					$name,
					$variation,
					$variation_slug,
					$price,
					$sell_price,
					$pro_sku,
					$slug,
					$isImage,
					$image_path,
					$decs,
					$feature_dimension,
					$additional_info,
					$status,
					$isProduct,
					$isDisplayHomePage,
					$isDisplayCategoryPage,
					$isEnquiry_product,
					/*$is_trending,
					$is_top_new,*/
					$display_order,
					$meta_title,
					$meta_description,
					$meta_keywords,
				);

			$last_id = $db->rpinsert($ctable,$values,$rows);

			if($last_id!=0)
			{
				foreach ($_REQUEST['additional_field'] as $key => $value) 
				{
					$additional_field 		= $value[0];
					$additional_field_value = $_REQUEST['additional_field_value'][$key];
					$additional_field_value =  implode(",",$additional_field_value);

					$rows3	=	array(
								"pid",
								"cate_id",
								"sub_cate_id",
								"sub_sub_cate_id",
								"additional_field_id",
								"additional_field_val_ids",
							);
							
					$values3 =	array(
								$last_id,
								$cate_id,
								$sub_cate_id,
								$sub_sub_cate_id,
								$additional_field,
								$additional_field_value,
							);	

					$insert_details = $db->rpinsert("product_additional_field_details",$values3,$rows3);
				}
			}

			$_SESSION['MSG'] = 'Inserted';
			$db->rplocation($manage_page_url);
		}
		
	}
	else if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="edit")
	{
		$dup_where = "slug = '".$slug."' AND cate_id='".$cate_id."' AND sub_cate_id='".$sub_cate_id."' AND sub_sub_cate_id='".$sub_sub_cate_id."' AND id!='".$_REQUEST['id']."' AND isDelete=0";
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
					"cate_id"				=> $cate_id,
					"sub_cate_id"			=> $sub_cate_id,
					"sub_sub_cate_id"		=> $sub_sub_cate_id,
					"pro_group_id"			=> $pro_group_id,
					"color_id"				=> $color_id,
					"material_id"			=> $material_id,
					"pro_feature_brand"		=> $pro_feature_brand,
					"name"					=> $name,
					"variation"				=> $variation,
					"variation_slug"		=> $variation_slug,
					"price"					=> $price,
					"sell_price"			=> $sell_price,
					"pro_sku"				=> $pro_sku,
					"slug"					=> $slug,
					"isImage"				=> $isImage,
					"image"					=> $image_path,
					"decs"					=> $decs,
					"feature_dimension"		=> $feature_dimension,
					"additional_info"		=> $additional_info,
					"status"				=> $status,
					"isProduct"				=> $isProduct,
					"isDisplayHomePage"		=> $isDisplayHomePage,
					"isDisplayCategoryPage"	=> $isDisplayCategoryPage,
					"isEnquiry_product"     => $isEnquiry_product,
					/*"is_trending"			=> $is_trending,
					"is_top_new"			=> $is_top_new,*/
					"meta_title"			=> $meta_title,
					"meta_description"		=> $meta_description,
					"meta_keywords"			=> $meta_keywords,
				);

			$where	= "id='".$_REQUEST['id']."' AND isDelete=0";
			$db->rpupdate($ctable,$rows,$where);

			$delete_ids = $_REQUEST['deleted_row_ids'];
			$delete_ids = explode(',', $delete_ids);
			foreach ($delete_ids as $key => $value) 
			{
				$del_where	= "id=".$value;
				$del_rows = array("isDelete"=>1);
				$db->rpupdate("product_additional_field_details",$del_rows,$del_where);
			}

			$update_ids = $_REQUEST['main_row_ids'];
			$update_cnt = count($update_ids);

			$counter = 0;
			foreach ($_REQUEST['additional_field'] as $key => $value) 
			{
				if($counter < $update_cnt) 
				{
					foreach ($update_ids as $key1 => $value1) 
					{
						$additional_field 		= $_REQUEST['additional_field'][$value1][0];
						$additional_field_value = $_REQUEST['additional_field_value'][$value1];
						$additional_field_value =  implode(",",$additional_field_value);

						$update_rows =	array(
							"pid" 						=>	$_REQUEST['id'],
							"cate_id" 					=>	$cate_id,
							"sub_cate_id" 				=>	$sub_cate_id,
							"sub_sub_cate_id" 			=>	$sub_sub_cate_id,
							"additional_field_id" 		=>	$additional_field,
							"additional_field_val_ids" 	=>	$additional_field_value,
						);

						$update_where = "id=".$value1;
						$db->rpupdate("product_additional_field_details",$update_rows,$update_where);
					}
				}
				else 
				{	
					$additional_field 		= $value[0];
					$additional_field_value = $_REQUEST['additional_field_value'][$key];
					$additional_field_value =  implode(",",$additional_field_value);

					$rows3	=	array(
								"pid",
								"cate_id",
								"sub_cate_id",
								"sub_sub_cate_id",
								"additional_field_id",
								"additional_field_val_ids",
							);
							
					$values3 =	array(
								$_REQUEST['id'],
								$cate_id,
								$sub_cate_id,
								$sub_sub_cate_id,
								$additional_field,
								$additional_field_value,
							);	

					$insert_details = $db->rpinsert("product_additional_field_details",$values3,$rows3);
				}
				$counter++;
			}
            
			$_SESSION['MSG'] = 'Updated';
			?>
			   <script>
			       window.location.href = '<?=$manage_page_url?>';
			   </script>
			<?php
			//$db->rplocation($manage_page_url);
			die();
		}
	}
}

if(isset($_REQUEST['id']) && $_REQUEST['id']>0 && $_REQUEST['mode']=="edit")
{
	$where 		= " id='".$_REQUEST['id']."' AND isDelete=0";
	$ctable_r 	= $db->rpgetData($ctable,"*",$where);
	$ctable_d 	= @mysqli_fetch_array($ctable_r);
	
	$cate_id				= $ctable_d['cate_id'];
	$sub_cate_id			= $ctable_d['sub_cate_id'];
	$sub_sub_cate_id		= $ctable_d['sub_sub_cate_id'];
	$pro_group_id			= $ctable_d['pro_group_id'];
	$color_id				= $ctable_d['color_id'];
	$material_id			= $ctable_d['material_id'];
	$pro_feature_brand		= $ctable_d['pro_feature_brand'];
	$name					= stripslashes($ctable_d['name']);
	$price 					= stripslashes($ctable_d['price']);
	$sell_price 			= stripslashes($ctable_d['sell_price']);
	$pro_sku	 			= stripslashes($ctable_d['pro_sku']);
	$decs					= stripslashes($ctable_d['decs']);
	$feature_dimension		= stripslashes($ctable_d['feature_dimension']);
	$additional_info		= stripslashes($ctable_d['additional_info']);
	$status					= stripslashes($ctable_d['status']);
	$isImage 				= stripslashes($ctable_d['isImage']);
	$image_path 			= stripslashes($ctable_d['image']);
	$isProduct 				= stripslashes($ctable_d['isProduct']);
	$isDisplayHomePage 		= stripslashes($ctable_d['isDisplayHomePage']);
	$isDisplayCategoryPage 	= stripslashes($ctable_d['isDisplayCategoryPage']);
	$isEnquiry_product   	= stripslashes($ctable_d['isEnquiry_product']);
	/*$is_trending			= stripslashes($ctable_d['is_trending']);
	$is_top_new				= stripslashes($ctable_d['is_top_new']);*/
	$meta_title				= stripslashes($ctable_d['meta_title']);
	$meta_description		= stripslashes($ctable_d['meta_description']);
	$meta_keywords			= stripslashes($ctable_d['meta_keywords']);
	$variation			    = stripslashes($ctable_d['variation']);

}
else
{
	$status					= 1;
	$isDisplayHomePage		= 0;
	$isDisplayCategoryPage	= 0;
	$isEnquiry_product      = 0;
	$isImage				= 0;
	$isProduct				= 0;
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
                                <div class="col-md-12">
                                    <!--begin::Portlet-->
                                    <div class="kt-portlet">
                                        <!--begin::Form-->
                                        <form class="kt-form" name="frm" id="frm" action="." method="post" enctype="multipart/form-data" accept-charset="UTF-8" onsubmit="return form_submit();">
										    <div class="kt-portlet__body">

										    	<input type="hidden" name="mode" id="mode" value="<?php echo $_REQUEST['mode']; ?>">
												<input type="hidden" name="id" id="id" value="<?php echo $_REQUEST['id']; ?>">

												<div class="form-group col-md-6">
													<label>Category <span class="text-danger">*</span></label>
													<select class="form-control" name="cate_id" id="cate_id" onChange="getSubCat(this.value);">
														<option value="">Select Category</option>
														<?php
														$cate_r = $db->rpgetData("category","*","isDelete=0");
														if(@mysqli_num_rows($cate_r)>0){
															while($cate_d = @mysqli_fetch_array($cate_r)){
															?>
															<option value="<?php echo $cate_d['id']; ?>" <?php if($cate_d['id']==$cate_id){?> selected <?php } ?>><?php echo $cate_d['name']; ?></option>
															<?php
															}
														}
														?>
													</select>
												</div>

												<div class="form-group col-md-6">
													<label>Sub Category</label>
													<select class="form-control" name="sub_cate_id" id="sub_cate_id" onChange="getSubSubCat(this.value);">
														<option value="">Select Sub Category</option>
													</select>
												</div>

												<div class="form-group col-md-6">
													<label>Sub Sub Category</label>
													<select class="form-control" name="sub_sub_cate_id" id="sub_sub_cate_id">
														<option value="">Select Sub Sub Category</option>
													</select>
												</div>

												<div class="form-group col-md-6">
													<label>Product Group</label>
													<select class="form-control" name="pro_group_id" id="pro_group_id">
														<option value="">Select Product Group</option>
														<?php
														$group_r = $db->rpgetData("product_group","*","isDelete=0");
														if(@mysqli_num_rows($group_r)>0){
															while($group_d = @mysqli_fetch_array($group_r)){
															?>
															<option value="<?php echo $group_d['id']; ?>" <?php if($group_d['id']==$pro_group_id){?> selected <?php } ?>><?php echo $group_d['name']; ?></option>
															<?php
															}
														}
														?>
													</select>
												</div>

												<div class="form-group col-md-6">
													<label>Color</label>
													<select class="form-control" name="color_id" id="color_id">
														<option value="">Select Color</option>
														<?php
														$color_r = $db->rpgetData("color","*","isDelete=0");
														if(@mysqli_num_rows($color_r)>0){
															while($color_d = @mysqli_fetch_array($color_r)){
															?>
															<option value="<?php echo $color_d['id']; ?>" <?php if($color_d['id']==$color_id){?> selected <?php } ?>><?php echo $color_d['name']; ?></option>
															<?php
															}
														}
														?>
													</select>
												</div>

												<div class="form-group col-md-6">
													<label>Material</label>
													<select class="form-control" name="material_id" id="material_id">
														<option value="">Select Material</option>
														<?php
														$material_r = $db->rpgetData("material","*","isDelete=0");
														if(@mysqli_num_rows($material_r)>0){
															while($material_d = @mysqli_fetch_array($material_r)){
															?>
															<option value="<?php echo $material_d['id']; ?>" <?php if($material_d['id']==$material_id){?> selected <?php } ?>><?php echo $material_d['name']; ?></option>
															<?php
															}
														}
														?>
													</select>
												</div>

												<div class="form-group col-md-6">
													<label>Featured Brand</label>
													<select class="form-control" name="pro_feature_brand" id="pro_feature_brand">
														<option value="">Select Featured Brand</option>
														<?php
														$featured_brand_r = $db->rpgetData("featured_brand","*","isDelete=0");
														if(@mysqli_num_rows($featured_brand_r)>0){
															while($featured_brand_d = @mysqli_fetch_array($featured_brand_r)){
															?>
															<option value="<?php echo $featured_brand_d['id']; ?>" <?php if($featured_brand_d['id']==$pro_feature_brand){?> selected <?php } ?>><?php echo $featured_brand_d['name']; ?></option>
															<?php
															}
														}
														?>
													</select>
												</div>

												<div class="form-group col-md-6">
													<label for="name">Product Name <code>*</code></label>
													<input type="text" class="form-control" value="<?php echo htmlentities($name); ?>" id="name" name="name">
												</div>
												
												<div class="form-group col-md-6">
													<label for="name">Product Price (<?php echo CURR?>) <code>*</code></label>
													<input type="number" min="0" step="Any" class="form-control" value="<?php echo $price; ?>" id="price" name="price">
												</div>
												<div class="form-group col-md-6">
													<label for="name">Product Sell Price (<?php echo CURR?>) </label>
													<input type="number" min="0" step="Any" class="form-control" value="<?php echo $sell_price; ?>" id="sell_price" name="sell_price">
												</div>

												<div class="form-group col-md-6">
													<label for="name">Product SKU </label>
													<input type="text" class="form-control" value="<?php echo $pro_sku; ?>" id="pro_sku" name="pro_sku">
												</div>

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

												<!-- <div class="form-group">
													<label for="image_path">Image <span class="text-danger">*</span>
													<input type="hidden" name="filename" id="filename" class="form-control" />
													</label>
													<small>minimum image size 1198 x 712</small> 
													<div class="row">
														<div class="col-md-6">
															<div id="dropzone" class="dropzone custom-dropzone" data-width="1198" data-height="712" data-ghost="false" data-originalsize="false" data-url="<?php echo ADMINURL?>crop_<?php echo $ctable; ?>.php" style="width: 599px;height:356px;">
																<input type="file" id="image_path" name="image_path">
																<input type="hidden" name="old_image_path" value="<?php echo $image_path; ?>" />
															</div>
														</div>
													</div>
													<div class="form-group">
														<?php
														if($image_path!="" && file_exists($IMAGEPATH_A.$image_path)){
														?>
															<img src="<?php echo SITEURL.$IMAGEPATH.$image_path;?>" width="599">
														<?php
														}
														?>
													</div>
												</div> -->
												
												<div class="form-group col-md-6">
													<label for="ans">Short Description <span class="text-danger">*</span></label>
													<textarea class="form-control summernote" id="decs" name="decs"><?php echo $decs; ?></textarea>
													<div class="desc_error"></div>
												</div>

												<div class="form-group col-md-6">
													<label for="ans">Features & Dimensions</label>
													<textarea class="form-control summernote" id="feature_dimension" name="feature_dimension"><?php echo $feature_dimension; ?></textarea>
												</div>

												<div class="form-group col-md-6">
													<label for="ans">Additional Information</label>
													<textarea class="form-control summernote" id="additional_info" name="additional_info"><?php echo $additional_info; ?></textarea>
												</div>
                                                
                                                <div class="form-group col-md-6">
													<label for="variation">Product Variation</label>
													<input type="text" class="form-control" value="<?php echo htmlentities($variation); ?>" id="variation" name="variation">
												</div>
												
												<div class="form-group col-md-6">
													<label>Product Status</label>
													<select class="form-control" name="status" id="status">
														<option value="">Select Product Status</option>
														<option <?php if($status=="1"){ echo "selected";}?> value="1">In Stock</option>
														<option <?php if($status=="2"){ echo "selected";}?> value="2">Out Of Stock</option>
														<option <?php if($status=="3"){ echo "selected";}?> value="3">Special Order</option>
														<option <?php if($status=="4"){ echo "selected";}?> value="4">Online Only</option>
														<option <?php if($status=="5"){ echo "selected";}?> value="5">Coming Soon</option>
														<option <?php if($status=="6"){ echo "selected";}?> value="6">Special Order (14-16 weeks)</option>
														<option <?php if($status=="7"){ echo "selected";}?> value="7">Special Order (2-4 weeks)</option>
													</select>
												</div>

												<div class="form-group col-md-6">
													<label>Is Product?</label>
													<div class="kt-radio-inline">
														<label class="kt-radio">
															<input type="radio" name="isProduct" value="0" <?php if($isProduct=="0"){ echo "checked";}?>> None
														<span></span>
														</label>
														<label class="kt-radio">
															<input type="radio" name="isProduct" value="1" <?php if($isProduct=="1"){ echo "checked";}?>> Trending
														<span></span>
														</label>
														<label class="kt-radio">
															<input type="radio" name="isProduct" value="2" <?php if($isProduct=="2"){ echo "checked";}?>>New
														<span></span>
														</label>
													</div>
													<!-- <span class="form-text text-muted">Some help text goes here</span> -->
												</div>

												<div class="form-group col-md-6">
													<label>Is Display On Home Page Under Banner?</label>
													<div class="kt-radio-inline">
														<label class="kt-radio">
															<input type="radio" name="isDisplayHomePage" value="0" <?php if($isDisplayHomePage=="0"){ echo "checked";}?>> No
														<span></span>
														</label>
														<label class="kt-radio">
															<input type="radio" name="isDisplayHomePage" value="1" <?php if($isDisplayHomePage=="1"){ echo "checked";}?>> Yes
														<span></span>
														</label>
													</div>
													<span class="form-text text-muted">(Maximum 2 products are allow.)</span>
													<div class="isDisplayHomePage_error"></div>
												</div>

												<div class="form-group col-md-6">
													<label>Is Display On Categorywise Product List Page?</label>
													<div class="kt-radio-inline">
														<label class="kt-radio">
															<input type="radio" name="isDisplayCategoryPage" value="0" <?php if($isDisplayCategoryPage=="0"){ echo "checked";}?>> No
														<span></span>
														</label>
														<label class="kt-radio">
															<input type="radio" name="isDisplayCategoryPage" value="1" <?php if($isDisplayCategoryPage=="1"){ echo "checked";}?>> Yes
														<span></span>
														</label>
													</div>
													<div class="isDisplayCategoryPage_error"></div>
												</div>
												
												<div class="form-group col-md-6">
													<label>Is Product Enquiry?</label>
													<div class="kt-radio-inline">
														<label class="kt-radio">
															<input type="radio" name="isEnquiry_product" value="0" <?php if($isEnquiry_product=="0"){ echo "checked";}?>> No
														<span></span>
														</label>
														<label class="kt-radio">
															<input type="radio" name="isEnquiry_product" value="1" <?php if($isEnquiry_product=="1"){ echo "checked";}?>> Yes
														<span></span>
														</label>
													</div>
													<div class="isEnquiry_product_error"></div>
												</div>

												<div class="form-group col-md-6 mb-0">
													<label>Select Additional Fields Details :-
													</label>
												</div>
												<div class="filed">
													<input type="hidden" name="deleted_row_ids" id="deleted_row_ids" value="">
													<?php 
													$ctable_c2 = 0;
													$auto_count=1;
													if(isset($_REQUEST['id']) && $_REQUEST['id']>0 && $_REQUEST['mode']=="edit")
													{
														$where2 	= "pid='".$_REQUEST['id']."' AND isDelete=0";
														$ctable_r2 	= $db->rpgetData("product_additional_field_details","*",$where2);
														$ctable_c2 	= @mysqli_num_rows($ctable_r2);
													}

													if($ctable_c2 > 0)
													{
														while($ctable_d2 = @mysqli_fetch_array($ctable_r2)) 
														{
														$addon_id = $ctable_d2['id'];
														$additional_field_id = $ctable_d2['additional_field_id'];
														$additional_field_val_ids = $ctable_d2['additional_field_val_ids'];
														?>
														<input type="hidden" name="main_row_ids[]" data-id="<?php echo $addon_id ?>" value="<?php echo $addon_id ?>">

														<div class="row mb-0 form-group col-md-12 filed_class">
															<?php 
															if($auto_count==1)
															{
															?>
															<div class="form-group col-md-1 add_button">
																<button type="button" class="btn btn-outline-success btn-elevate btn-icon">
																	<i class="fa fa-plus"></i>
																</button>
															</div>
															<?php
															} 
															else 
															{
															?>
															<div data-delete-id="<?php echo $addon_id ?>" class="form-group col-md-1 remove_button">
																<button type="button" class="btn btn-outline-danger btn-elevate btn-icon">
																	<i class="fa fa-minus"></i>
																</button>
															</div>
															<?php 
															}
															?>
															<div class="form-group col-md-3">
																<select name="additional_field[<?php echo $addon_id ?>][]" id="additional_field<?php echo $addon_id ?>" class="form-control class_additional_field" onchange="getAdditionFieldVal(this.value,this);">
																	<option value="">Please select option</option>
																	<?php 
																	$add_field_val_r = $db->rpgetData("additional_field","*","isDelete=0");
																	while($add_field_val_d = @mysqli_fetch_array($add_field_val_r))
																	{
																	?>
																	<option <?php if($add_field_val_d['id']==$additional_field_id){?> selected <?php } ?> value="<?=$add_field_val_d['id']?>"><?=$add_field_val_d['name'];?></option>
																	<?php
																	}
																	?>
																</select>
															</div>
															<div class="form-group col-md-8 class_additional_field_val" id="additional_field_val<?php echo $addon_id ?>">
																<?php
																$add_field_val_r = $db->rpgetData("additional_field_value","*","isDelete=0 AND additional_field_id='".$additional_field_id."'");
																?>
																<div class="kt-checkbox-inline">
																	<?php
																	while($add_field_val_d = @mysqli_fetch_array($add_field_val_r))
																	{
																	$exp_additional_field_val_ids = explode(',',$additional_field_val_ids);
																	?>
																	<label class="kt-checkbox kt-checkbox--bold kt-checkbox--success">
																		<input type="checkbox" name="additional_field_value[<?php echo $addon_id ?>][]" 
																		<?php 
																		echo in_array($add_field_val_d['id'], $exp_additional_field_val_ids)? "checked" : "";
																		?>
																		value="<?=$add_field_val_d['id']?>"> <?=$add_field_val_d['name']?>
																		<span></span>
																	</label>
																	<?php 
																	}
																	?>
																</div>
															</div>
														</div>
														<?php
														$auto_count++;
														}
													}
													else
													{
													?>
													<div class="row mb-0 form-group col-md-12 filed_class">
														<div class="form-group col-md-1 add_button">
															<button type="button" class="btn btn-outline-success btn-elevate btn-icon">
																<i class="fa fa-plus"></i>
															</button>
														</div>
														<div class="form-group col-md-3">
															<select name="additional_field[1][]" id="additional_field1" class="form-control class_additional_field" onchange="getAdditionFieldVal(this.value,this);">

															</select>
														</div>
														<div class="form-group col-md-8 class_additional_field_val" id="additional_field_val1">

														</div>
													</div>
													<?php
													} 
													?>
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

												<!-- <div class="form-group form-group-last">
													<label>Is Product?</label>
													<div class="kt-checkbox-inline">
														<label class="kt-checkbox">
															<input type="checkbox" name="is_trending" id="is_trending" value="1" <?php if($is_trending=="1"){ echo "checked";}?>> Trending
															<span></span>
														</label>
														<label class="kt-checkbox">
															<input type="checkbox" name="is_top_new" id="is_top_new" value="1" <?php if($is_top_new=="1"){ echo "checked";}?>> New
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

        <?php 
        $demo .= '<div class="row mb-0 form-group col-md-12 filed_class">';
        	$demo .= '<div class="form-group col-md-1 remove_button">';
	        $demo .= '<button type="button" class="btn btn-outline-danger btn-elevate btn-icon">';
	        $demo .= '<i class="fa fa-minus"></i>';
	        $demo .= '</button>';
	        $demo .= '</div>';
			$demo .= '<div class="form-group col-md-3">';
				$demo .= '<select name="additional_field[1][]" id="additional_field1" class="form-control class_additional_field" onchange="getAdditionFieldVal(this.value,this);">';

				$demo .= '</select>';
			$demo .= '</div>';
			$demo .= '<div class="form-group col-md-8 class_additional_field_val" id="additional_field_val1">';

			$demo .= '</div>';
		$demo .= '</div>';
        ?>

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
					ignore: [],
					rules: {
						name:{required : true},
						cate_id:{required : true},
						pro_group_id:{required : true},
						price:{required : true},
						decs:{required : true},
						isImage:{required : true},
						image_path:{required : $("#mode").val()=="add" && $("#filename").val()=="" },
						filename:{ required: $("#mode").val()=="add" && $("#filename").val()=="" },
						isDisplayHomePage:{ 
										required : false,
										remote: {
											url: "<?php echo ADMINURL?>ajax_check_isDisplayHomePage.php",
											type : "post",
											data: {
												id : "<?= isset($_REQUEST['id']) ? $_REQUEST['id'] : '0'; ?>",
												isDisplayHomePage : function (){
													return $("input[name=isDisplayHomePage]:checked").val();
												}
											}
										}
						 				},
						isDisplayCategoryPage:{required : true},
					},
					messages: {
						name:{required:"Please Enter Product Name."},
						cate_id:{required:"Please Select Category."},
						pro_group_id:{required:"Please Select Product Group."},
						price:{required:"Please Enter Price."},
						decs:{required:"Please Enter Description."},
						isImage:{required:"Please select option."},
						image_path:{required:"Please upload image."},
						filename:{required:"Please click on right tick mark after upload image."},
						isDisplayHomePage:{required:"Maximum 2 products are allow."},
						isDisplayCategoryPage:{required:"Please select option."},
					},
					errorPlacement: function(error, element) {
						if (element.attr("name") == "image_path") {
							error.insertAfter("#dropzone");
						}
						else if (element.attr("name") == "filename") {
							error.insertAfter("#dropzone");
						} 
						else if (element.attr("name") == "decs") 
						{
							error.insertAfter(".desc_error");
						} 
						else if (element.attr("name") == "isImage") 
						{
							error.insertAfter(".isImage_error");
						}
						else if (element.attr("name") == "isDisplayHomePage") 
						{
							error.insertAfter(".isDisplayHomePage_error");
						}
						else if (element.attr("name") == "isDisplayCategoryPage") 
						{
							error.insertAfter(".isDisplayCategoryPage_error");
						}
						else if (element.attr("name") == "isEnquiry_product") 
						{
							error.insertAfter(".isEnquiry_product_error");
						}
						
						else
						{
							error.insertAfter(element);
						}
					}
				});
			});

		  	<?php 
            if($_REQUEST['mode'] == "edit")
            {
            ?>
            getSubCat('<?= $cate_id;?>','<?= $sub_cate_id;?>');
            getSubSubCat('<?= $sub_cate_id;?>','<?= $sub_sub_cate_id;?>');
            <?php 
        	}
        	?>
			function getSubCat(id,sid="")
			{
				$("#sub_cate_id").html("");
				$("#sub_sub_cate_id").html("");
				
				$.ajax({
					type: "POST",
					url: "<?php echo ADMINURL?>ajax_get_sub_category_list.php",
					data: 'cate_id='+id+"&sub_cate_id="+sid,
					success: function(result)
					{
						$("#sub_cate_id").html(result);
						<?php 
			            if($_REQUEST['mode'] == "add" || $auto_count==1)
			            {
			            ?>
						getAdditionalLabel();
						<?php 
						}
						?>
					}
				});
			}

			function getSubSubCat(sid,ssid="")
			{
				$.ajax({
					type: "POST",
					url: "<?php echo ADMINURL?>ajax_get_sub_sub_category_list.php",
					data: 'sub_cate_id='+sid+"&sub_sub_cate_id="+ssid,
					success: function(result)
					{
						$("#sub_sub_cate_id").html(result);
						<?php 
			            if($_REQUEST['mode'] == "add" || $auto_count==1)
			            {
			            ?>
						getAdditionalLabel();
						<?php 
						}
						?>
					}
				});
			}

			function getAdditionalLabel(get_curr_pos="")
			{
				var cate_id 		= $("#cate_id").val();
				var sub_cate_id 	= $("#sub_cate_id").val();
				var sub_sub_cate_id = $("#sub_sub_cate_id").val();

				if(cate_id=="" || cate_id==null)
				{
					cate_id = 0;
				}

				if(sub_cate_id=="" || sub_cate_id==null)
				{
					sub_cate_id = 0;
				}

				if(sub_sub_cate_id=="" || sub_sub_cate_id==null)
				{
					sub_sub_cate_id = 0;
				}

				$.ajax({
					type: "POST",
					url: "<?php echo ADMINURL?>ajax_get_additional_label.php",
					data: 'cate_id='+cate_id+"&sub_cate_id="+sub_cate_id+"&sub_sub_cate_id="+sub_sub_cate_id,
					success: function(result)
					{
						if(get_curr_pos!="")
						{
							$("#additional_field"+get_curr_pos).html(result);
						}
						else
						{
							$(".class_additional_field").html(result);
						}
						//$(".class_additional_field_val").html("");
					}
				});
			}

			function getAdditionFieldVal(additional_field_id,all_details)
			{
				var tmp = $(all_details).attr("id");
				var res = tmp.split("additional_field");
				var curr_pos = res[1];

				$.ajax({
					type: "POST",
					url: "<?php echo ADMINURL?>ajax_get_additional_value.php",
					data: 'additional_field_id='+additional_field_id+'&curr_pos='+curr_pos,
					success: function(result)
					{
						$("#additional_field_val"+curr_pos).html(result);
					}
				});
			}

			$(document).ready(function(){ 
			    var addButton = $('.add_button'); 
			    var wrapper = $('.filed'); 
			    <?php 
				if(isset($_REQUEST['id']) && $_REQUEST['id']>0 && $_REQUEST['mode']=="edit")
				{
					if($auto_count!= 1)
					{
					?>
					var cal = '<?php echo ($auto_count - 1)?>'; 
					<?php
					}
					else
					{
					?>
					var cal = '<?php echo $auto_count; ?>'; 
					<?php
					}
				}
				else
				{
				?>
				var cal = '<?php echo ($auto_count)?>'; 
				<?php 
				}
				?>
			    $(addButton).click(function(){ 
			    	var tmp1 = '<?php echo $demo; ?>';
			    	var auto_newval = parseInt(cal) + 1;
			    	var tmp1  = tmp1.replace(/additional_field1/gi,"additional_field"+(auto_newval));
			    	var tmp_name = "additional_field[1][]";
			    	var tmp1  = tmp1.replace(tmp_name,"additional_field["+(auto_newval)+"][]");
			    	var tmp1  = tmp1.replace(/additional_field_val1/gi,"additional_field_val"+(auto_newval));
			        $(wrapper).append(tmp1); 
			        cal = parseInt(cal) + 1;

			        getAdditionalLabel(auto_newval);
			    });
			    $(wrapper).on('click', '.remove_button', function(e){ 
			        e.preventDefault();
			        $(this).parent('div').remove(); 

			        var id = $(this).attr('data-delete-id');
			        console.log($(this));
					$('input[name="main_row_ids[]"][data-id="'+id+'"]').remove();
					var delete_ids = $('#deleted_row_ids').val();
					if(delete_ids != '') 
					{
						$('#deleted_row_ids').val(delete_ids+','+id);
					}
					else 
					{
						$('#deleted_row_ids').val(id);
					}
			    });
			});

			function form_submit() 
			{
				$("#submit").attr("readonly", true);

				if($("#frm").valid())
				{
					$("#submit").attr("readonly", true);
					
					var multi_val = true;
					$( ".filed_class" ).filter(function( index ) 
					{
						var additional_field = $(this).find(".class_additional_field").val();
						var additional_field_value = $(this).find('input:checkbox:checked').length;
						$(this).find(".class_additional_field").css('border','1px solid #e2e5ec');
						$(this).find(".kt-checkbox.kt-checkbox--success>span").css('border','1px solid #0abb87');

						if(index == 0)
						{
						    if(additional_field=="" || additional_field==null)
							{
							}
							else
							{
								if(additional_field_value=="" || additional_field_value==0 || additional_field_value==null)
								{
									$(this).find(".kt-checkbox.kt-checkbox--success>span").css('border','1px solid #ff3111');
									multi_val = false;
								}
							}
						}
						else
						{
							if(additional_field=="" || additional_field==null)
							{
								$(this).find(".class_additional_field").css('border','1px solid #ff3111');
								multi_val = false;
							}

							if(additional_field_value=="" || additional_field_value==0 || additional_field_value==null)
							{
								$(this).find(".kt-checkbox.kt-checkbox--success>span").css('border','1px solid #ff3111');
								multi_val = false;
							}
						}
					});

					if(multi_val==false)
					{
						$("#submit").attr("readonly", false);
					}
					return multi_val;
				}
				else
				{
					$("#submit").attr("readonly", false);
					return false;
				}
				return true;
			}
        </script>
    </body>
</html>