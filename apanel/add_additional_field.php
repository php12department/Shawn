<?php
include("connect.php");
$db->rpcheckAdminLogin();
		
$ctable 			= "additional_field";
$ctable1 			= "Additional Field";
$parent_page 		= "product-master"; //for sidebar active menu
$main_page 			= "manage-additional-field"; //for sidebar active menu
$page_title 		= ucwords($_REQUEST['mode'])." ".$ctable1;
$manage_page_url 	= ADMINURL."manage-additional-field/";
$add_page_url 		= ADMINURL."add-additional-field/add/";
$edit_page_url 		= ADMINURL."add-additional-field/edit/".$_REQUEST['id']."/";

$name 					= "";
$cate_id 				= "0";
$sub_cate_id 			= "0";
$sub_sub_cate_id 		= "0";

if(isset($_REQUEST['submit']))
{
	$cate_id				= $db->clean($_REQUEST['cate_id']);
	$sub_cate_id			= $db->clean($_REQUEST['sub_cate_id']);
	$sub_sub_cate_id		= $db->clean($_REQUEST['sub_sub_cate_id']);
	$name					= $db->clean($_REQUEST['name']);
	$slug					= $db->rpcreateSlug($_REQUEST['name']);
	
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
			$rows 	= array(
					"cate_id",
					"sub_cate_id",
					"sub_sub_cate_id",
					"name",
					"slug",
				);
			$values = array(
					$cate_id,
					$sub_cate_id,
					$sub_sub_cate_id,
					$name,
					$slug,
				);

			$last_id = $db->rpinsert($ctable,$values,$rows);

			if($last_id!=0)
			{
				for($i=0;$i < count($_REQUEST['additional_field_val']);$i++)
				{
					$additional_field_val		= $db->clean($_REQUEST['additional_field_val'][$i]);
					$additional_field_val_slug	= $db->rpcreateSlug($_REQUEST['additional_field_val'][$i]);

					$rows3	=	array(
								"additional_field_id",
								"name",
								"slug",
							);
							
					$values3 =	array(
								$last_id,
								$additional_field_val,
								$additional_field_val_slug,
							);	

					$insert_details = $db->rpinsert("additional_field_value",$values3,$rows3);
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
			$rows 	= array(
					"cate_id"				=> $cate_id,
					"sub_cate_id"			=> $sub_cate_id,
					"sub_sub_cate_id"		=> $sub_sub_cate_id,
					"name"					=> $name,
					"slug"					=> $slug,
				);

			$where	= "id='".$_REQUEST['id']."' AND isDelete=0";
			$db->rpupdate($ctable,$rows,$where);


			$delete_ids = $_REQUEST['deleted_row_ids'];
			$delete_ids = explode(',', $delete_ids);
			foreach ($delete_ids as $key => $value) 
			{
				$del_where	= "id=".$value;
				$del_rows = array("isDelete"=>1);
				$db->rpupdate("additional_field_value",$del_rows,$del_where);
			}

			$update_ids = $_REQUEST['main_row_ids'];
			$update_cnt = count($update_ids);

			for($i=0;$i < count($_REQUEST['additional_field_val']);$i++)
			{
				if($i < $update_cnt) 
				{
					foreach ($update_ids as $key => $value) 
					{
						$additional_field_val		= $db->clean($_REQUEST['additional_field_val'][$key]);
						$additional_field_val_slug	= $db->rpcreateSlug($_REQUEST['additional_field_val'][$key]);

						$update_rows =	array(
							"additional_field_id" 	=>	$_REQUEST['id'],
							"name" 					=>	$additional_field_val,
							"slug" 					=>	$additional_field_val_slug,
						);

						$update_where = "id=".$value;
						$db->rpupdate("additional_field_value",$update_rows,$update_where);
					}
				}
				else 
				{	
					$additional_field_val		= $db->clean($_REQUEST['additional_field_val'][$i]);
					$additional_field_val_slug	= $db->rpcreateSlug($_REQUEST['additional_field_val'][$i]);

					$rows3	=	array(
								"additional_field_id",
								"name",
								"slug",
							);
							
					$values3	=	array(
								$_REQUEST['id'],
								$additional_field_val,
								$additional_field_val_slug,
							);	

					$insert_details = $db->rpinsert("additional_field_value",$values3,$rows3);
				}

			}

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
	
	$cate_id				= $ctable_d['cate_id'];
	$sub_cate_id			= $ctable_d['sub_cate_id'];
	$sub_sub_cate_id		= $ctable_d['sub_sub_cate_id'];
	$name					= stripslashes($ctable_d['name']);
}

if(isset($_REQUEST['id']) && $_REQUEST['id']>0 && $_REQUEST['mode']=="delete")
{
	$id 	= $_REQUEST['id'];
	$rows 	= array("isDelete" => "1");

	$db->rpupdate($ctable,$rows,"id='".$id."'");
	$db->rpupdate("additional_field_value",$rows,"additional_field_id='".$id."'");

	$_SESSION['MSG'] = 'Deleted';
	$db->rplocation($manage_page_url);	
}	
?>
<!DOCTYPE html>
<html lang="en">
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
                                        <form class="kt-form" name="frm" id="frm" action="." method="post" enctype="multipart/form-data" onsubmit="return form_submit();">
										    <div class="kt-portlet__body">
										    	<input type="hidden" name="deleted_row_ids" id="deleted_row_ids" value="">

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
													<label for="name">Label Name <code>*</code></label>
													<input type="text" class="form-control" value="<?php echo $name; ?>" id="name" name="name">
												</div>

												<div class="form-group col-md-6 mb-0">
													<label>Label Multiple Value :- </label>
												</div>	
												<div class="filed">
													<?php 
													$ctable_c2 = 0;
													$auto_count=1;
													if(isset($_REQUEST['id']) && $_REQUEST['id']>0 && $_REQUEST['mode']=="edit")
													{
														$where2 	= "additional_field_id='".$_REQUEST['id']."' AND isDelete=0";
														$ctable_r2 	= $db->rpgetData("additional_field_value","*",$where2);
														$ctable_c2 	= @mysqli_num_rows($ctable_r2);
													}

													if($ctable_c2 > 0)
													{
														while($ctable_d2 = @mysqli_fetch_array($ctable_r2)) 
														{
														$add_val_name_id = stripslashes($ctable_d2['id']);
														$add_val_name 	 = stripslashes($ctable_d2['name']);
														?>
														<input type="hidden" name="main_row_ids[]" data-id="<?php echo $add_val_name_id ?>" value="<?php echo $add_val_name_id ?>">

														<div class="row mb-0 form-group col-md-6 filed_class">
															<div class="form-group col-md-11">
																<input type="text" class="form-control class_additional_field_val" id="additional_field_val<?php echo $auto_count; ?>" name="additional_field_val[]" value="<?php echo $add_val_name;?>" />
															</div>	
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
															<div data-delete-id="<?php echo $add_val_name_id ?>" class="form-group col-md-1 remove_button">
																<button type="button" class="btn btn-outline-danger btn-elevate btn-icon">
																	<i class="fa fa-minus"></i>
																</button>
															</div>
															<?php 
															}
															?>
														</div>
														<?php
														$auto_count++;
														}
													}
													else
													{
													?>
													<div class="row mb-0 form-group col-md-6 filed_class">
														<div class="form-group col-md-11">
															<input type="text" class="form-control class_additional_field_val" id="additional_field_val1" name="additional_field_val[]" />
														</div>
														<div class="form-group col-md-1 add_button">
															<button type="button" class="btn btn-outline-success btn-elevate btn-icon">
																<i class="fa fa-plus"></i>
															</button>
														</div>
													</div>
													<?php
													} 
													?>
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

        <?php 
        $demo .= '<div class="row mb-0 form-group col-md-6 filed_class">';
        $demo .= '<div class="form-group col-md-11">';
        $demo .= '<input type="text" class="form-control class_additional_field_val" id="additional_field_val1" name="additional_field_val[]"  />';
        $demo .= '</div>';
        $demo .= '<div class="form-group col-md-1 remove_button">';
        $demo .= '<button type="button" class="btn btn-outline-danger btn-elevate btn-icon">';
        $demo .= '<i class="fa fa-minus"></i>';
        $demo .= '</button>';
        $demo .= '</div>';
        $demo .= '</div>';
        ?>
        <!-- end:: Page -->
<?php include('include_js.php'); ?>
<script type="text/javascript">
	$(document).ready(function(){ 
	    var addButton = $('.add_button'); 
	    var wrapper = $('.filed'); 
	    <?php 
		if(isset($_REQUEST['id']) && $_REQUEST['id']>0 && $_REQUEST['mode']=="edit")
		{ 
		?>
		var cal = '<?php echo ($auto_count - 1)?>'; 
		<?php 
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
	    	var tmp1  = tmp1.replace(/additional_field_val1/gi,"additional_field_val"+(auto_newval));
	        $(wrapper).append(tmp1); 
	        cal = parseInt(cal) + 1;
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

	$(function(){
		$("#frm").validate({
			rules: {
				name:{required : true},
				cate_id:{required : true},
			},
			messages: {
				name:{required:"Please Enter Product Name."},
				cate_id:{required:"Please Select Category."},
			},
			errorPlacement: function(error, element) {
				if (element.attr("name") == "image_path") {
					error.insertAfter("#dropzone");
				}
				else if (element.attr("name") == "filename") {
					error.insertAfter("#dropzone");
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
			}
		});
	}

	function form_submit() 
	{
		$("#submit").attr("readonly", true);
		if($("#frm").validate())
		{
			$("#submit").attr("readonly", true);
			
			var multi_val = true;
			$( ".filed_class" ).filter(function( index ) 
			{
				var additional_field 	= $(this).find(".class_additional_field_val").val();

				$(this).find(".class_additional_field_val").css('border','1px solid #e2e5ec');
				
				if(additional_field=="" || additional_field==null)
				{
					$(this).find(".class_additional_field_val").css('border','1px solid #ff3111');
					multi_val = false;
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