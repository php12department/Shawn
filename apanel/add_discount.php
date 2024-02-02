<?php
include("connect.php");
$db->rpcheckAdminLogin();

$ctable 			= "discount";
$ctable1 			= "Discount";
$parent_page 		= "discount-master"; //for sidebar active menu
$main_page 			= "manage-discount"; //for sidebar active menu
$page_title 		= ucwords($_REQUEST['mode'])." ".$ctable1;
$manage_page_url 	= ADMINURL."manage-discount/";
$add_page_url 		= ADMINURL."add-discount/add/";
$edit_page_url 		= ADMINURL."add-discount/edit/".$_REQUEST['id']."/";

$cate_id 			= 0;
$sub_cate_id 		= 0;
$sub_sub_cate_id 	= 0;
$pid 				= 0;
$disc_desc			= "";
$type				= "";
$amount				= "";
$start_date			= "";
$expiration_date	= "";

if(isset($_REQUEST['submit']))
{
	$cate_id			= $db->clean($_REQUEST['cate_id']);
	$sub_cate_id		= $db->clean($_REQUEST['sub_cate_id']);
	$sub_sub_cate_id	= $db->clean($_REQUEST['sub_sub_cate_id']);
	// $pid				= $db->clean($_REQUEST['pid']);
	$disc_desc			= $db->clean($_REQUEST['disc_desc']);
	$type				= $db->clean($_REQUEST['type']);
	$amount				= $db->clean($_REQUEST['amount']);
	$start_date			= date("Y-m-d",strtotime($_REQUEST['start_date']));
	$expiration_date	= date("Y-m-d",strtotime($_REQUEST['expiration_date']));
	$pid 				= implode(",",$_REQUEST['pro_not_dis']);

	if (empty($pid)) {
		$pid = 0;
	}

	if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="add")
	{
		$dup_where = "isDelete=0 AND cate_id='".$cate_id."'";
		$r = $db->rpdupCheck($ctable,$dup_where);
		// if($r){
		// 	$_SESSION['MSG'] = "Duplicate";
		// 	$db->rplocation($add_page_url);
		// 	exit;
		// }else{
			$rows 	= array(
					"cate_id",
					"sub_cate_id",
					"sub_sub_cate_id",
					"pid",
					"disc_desc",
					"type",
					"amount",
					"start_date",
					"expiration_date",
				);
			$values = array(
					$cate_id,
					$sub_cate_id,
					$sub_sub_cate_id,
					$pid,
					$disc_desc,
					$type,
					$amount,
					$start_date,
					$expiration_date,
				);
			$last_id =  $db->rpinsert($ctable,$values,$rows);

			$_SESSION['MSG'] = "Inserted";
			$db->rplocation($manage_page_url);
			exit;
		// }
		
	}
	else if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="edit")
	{    
		$dup_where = "id!='".$_REQUEST['id']."' AND isDelete=0 AND cate_id='".$cate_id."'";
		$r = $db->rpdupCheck($ctable,$dup_where);
		// if($r)
		// {
		// 	$_SESSION['MSG'] = "Duplicate";
		// 	$db->rplocation($edit_page_url);
		// 	exit;
		// }
		// else
		// {
			$rows 	= array(
					"cate_id"			=> $cate_id,
					"sub_cate_id"		=> $sub_cate_id,
					"sub_sub_cate_id"	=> $sub_sub_cate_id,
					"pid"				=> $pid,
					"disc_desc"			=> $disc_desc,
					"type"				=> $type,
					"amount"			=> $amount,
					"start_date"		=> $start_date,
					"expiration_date"	=> $expiration_date,
				);

			$where	= "id='".$_REQUEST['id']."' AND isDelete=0";
			$db->rpupdate($ctable,$rows,$where);
			
			$_SESSION['MSG'] = "Updated";
			$db->rplocation($manage_page_url);
			exit;
		// }
	}
}

if(isset($_REQUEST['id']) && $_REQUEST['id']>0 && $_REQUEST['mode']=="edit")
{
	$where 		= " id='".$_REQUEST['id']."' AND isDelete=0";
	$ctable_r 	= $db->rpgetData($ctable,"*",$where);
	$ctable_d 	= @mysqli_fetch_array($ctable_r);
	
	$id					= $ctable_d['id'];
	$cate_id			= $ctable_d['cate_id'];
	$sub_cate_id		= $ctable_d['sub_cate_id'];
	$sub_sub_cate_id	= $ctable_d['sub_sub_cate_id'];
	// $pid				= $ctable_d['pid'];
	$pid				= explode(",",$ctable_d['pid']);
	$disc_desc			= stripslashes($ctable_d['disc_desc']);
	$type				= stripslashes($ctable_d['type']);
	$amount		 		= stripslashes($ctable_d['amount']);
	$start_date			= date("m/d/Y",strtotime($ctable_d['start_date']));
	$expiration_date	= date("m/d/Y",strtotime($ctable_d['expiration_date']));
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
													<label>Category <span class="text-danger">*</span></label>
													<select class="form-control" name="cate_id" id="cate_id" onChange="getSubCat(this.value),getCatProducts(this.value)">
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

												<div class="form-group">
													<label>Sub Category</label>
													<select class="form-control" name="sub_cate_id" id="sub_cate_id" onChange="getSubSubCat(this.value),getSubCatProducts(this.value);">
														<option value="">Select Sub Category</option>
													</select>
												</div>

												<div class="form-group">
													<label>Sub Sub Category</label>
													<select class="form-control" name="sub_sub_cate_id" id="sub_sub_cate_id" onChange="getSubSubCatProducts(this.value);">
														<option value="">Select Sub Sub Category</option>
													</select>
												</div>

												<div class="form-group">
													<label>Do Not Add Discount On Selected Products</label>
													<select multiple data-show-subtext="false" data-live-search="true" class="selectpicker form-control" name="pro_not_dis[]" id="pro_not_dis" Placeholder="Select Products">
														<?php
														$pro_r = $db->rpgetData("product","*","isDelete=0");
														if(@mysqli_num_rows($pro_r)>0){
															while($pro_d = @mysqli_fetch_array($pro_r)){
															?>
															<!-- <option value="<?php echo $pro_d['id']; ?>" <?php if($pro_d['id']==$pro_id){?> selected <?php } ?>><?php echo $pro_d['name']; ?></option> -->
															<?php
															}
														}
														?>
													</select>
												</div>

												<div class="form-group">
													<label for="disc_desc">Discount Description</label>
													<textarea class="form-control" id="disc_desc" name="disc_desc"><?php echo $disc_desc; ?></textarea>
												</div>

												<div class="form-group">
													<label for="type">Type <code>*</code></label>
													<select class="form-control" name="type" id="type">
														<option value="">Select Type</option>
														<option <?php if($type=='percent'){ echo "selected"; }?> value="percent">Percentage</option>
														<option <?php if($type=='flat'){ echo "selected"; }?> value="flat">Flat amount</option>
																
													</select>
												</div>

												<div class="form-group">
													<label for="name">Discount Amount <code>*</code></label>
													<input type="number" step="Any" class="form-control" value="<?php echo $amount; ?>" min="1" id="amount" name="amount">
												</div>
												
												<div class="form-group">
													<label for="name">Start Date <code>*</code></label>
													<div class="input-group date dis_start_date_err">
	                                                    <input type="text" class="form-control" readonly  placeholder="Select start date" name='start_date' id="start_date" value="<?php echo $start_date; ?>" />
	                                                    <div class="input-group-append">
	                                                        <span class="input-group-text">
	                                                        <i class="la la-calendar-check-o"></i>
	                                                        </span>
	                                                    </div>
	                                                </div>
												</div>
												<div class="form-group form-group-last">
													<label for="name">Expiration Date <code>*</code></label>
													<div class="input-group date dis_expiration_date_err">
	                                                    <input type="text" class="form-control" readonly  placeholder="Select expiration date" name='expiration_date' id="expiration_date" value="<?php echo $expiration_date; ?>" />
	                                                    <div class="input-group-append">
	                                                        <span class="input-group-text">
	                                                        <i class="la la-calendar-check-o"></i>
	                                                        </span>
	                                                    </div>
	                                                </div>
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
        	$(function(){
				$("#frm").validate({
					ignore: "",
					rules: {
						cate_id:{required : true},
		    			type:{required : true},
		    			amount:{required : true},
		    			start_date:{required : true},
		    			expiration_date:{required : true},
					},
					messages: {
						cate_id:{required:"Please Select Category."},
		    			type :{required:"Please select type."},
		    			amount :{required:"Please enter amount."},
		    			start_date :{required:"Please enter start date."},
		    			expiration_date :{required:"Please enter end date."},
					},
		    		errorPlacement: function(error, element) {
		    			if (element.attr("name") == "start_date") 
		    			{
		    				error.insertAfter(".dis_start_date_err");
		    			}
		    			else if (element.attr("name") == "expiration_date") 
		    			{
		    				error.insertAfter(".dis_expiration_date_err");
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
            getCatProducts('<?= $cate_id;?>');
            getSubCatProducts('<?= $sub_cate_id;?>');
            getSubSubCatProducts('<?= $sub_sub_cate_id;?>');
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

			function getCatProducts(cid) {
				$.ajax({
					type: "POST",
					url: "<?php echo ADMINURL?>ajax_get_catproducts_list.php",
					data: 'cate_id='+cid,
					success: function(result)
					{
						console.log(result);
						$("#pro_not_dis").html(result).selectpicker('refresh');
					}
				});
			}

			function getSubCatProducts(scid) {
				$.ajax({
					type: "POST",
					url: "<?php echo ADMINURL?>ajax_get_subcatproducts_list.php",
					data: 'sub_cate_id='+scid,
					success: function(result)
					{
						console.log(result);
						$("#pro_not_dis").html(result).selectpicker('refresh');
					}
				});
			}

			function getSubSubCatProducts(sscid) {
				$.ajax({
					type: "POST",
					url: "<?php echo ADMINURL?>ajax_get_subsubcatproducts_list.php",
					data: 'sub_sub_cate_id='+sscid,
					success: function(result)
					{
						console.log(result);
						$("#pro_not_dis").html(result).selectpicker('refresh');
					}
				});
			}
        </script>
    </body>
</html>