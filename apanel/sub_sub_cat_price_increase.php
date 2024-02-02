<?php
include("connect.php");
$db->rpcheckAdminLogin();

$ctable 			= "product";
$ctable1 			= "Price Increase";
$parent_page 		= "price-increase"; //for sidebar active menu
$main_page 			= "sub-sub-cat-price-increase"; //for sidebar active menu
$page_title 		= ucwords($_REQUEST['mode'])." ".$ctable1;
$manage_page_url 	= ADMINURL."sub-sub-cat-price-increase/";
/*$add_page_url 		= ADMINURL."add-discount/add/";
$edit_page_url 		= ADMINURL."add-discount/edit/".$_REQUEST['id']."/";*/

$cate_id 			= 0;
$sub_cate_id 		= 0;
$sub_sub_cate_id 	= 0;
$amount				= "";

if(isset($_REQUEST['submit']))
{
	
	$cate_id			= $db->clean($_REQUEST['cate_id']);
	$sub_cate_id		= $db->clean($_REQUEST['sub_cate_id']);
	$sub_sub_cate_id	= $db->clean($_REQUEST['sub_sub_cate_id']);
	$amount				= $db->clean($_REQUEST['amount']);

	// echo "<pre>";
	// print_r($_REQUEST);die;

	$where_pro 		= " sub_sub_cate_id='".$sub_sub_cate_id."' AND isDelete=0";
	$ctable_pro_r 	= $db->rpgetData($ctable,"*",$where_pro);
	//$ctable_pro_d 	= @mysqli_fetch_array($ctable_pro_r);


	if($sub_sub_cate_id == 0)
	{
		$update = "UPDATE product SET price = ROUND(price + (price * ".$amount." / 100),2) WHERE cate_id=".$cate_id." AND sub_cate_id=".$sub_cate_id." AND isDelete=0";
		// echo $update;die;
		$rows 	= array(
					"cate_id",
					"sub_cate_id",
					"sub_sub_cate_id",
					"amount_percentage",
					"log",
				);
		$values = array(
					$cate_id,
					$sub_cate_id,
					0,
					$amount,
					$update,
				);
		$db->rpinsert("increase_price_log",$values,$rows);
		$query = @mysqli_query($GLOBALS['myconn'],$update);

		if($query)
        {
            $_SESSION['MSG'] = "All_Sub_Sub_Category";
			$db->rplocation($manage_page_url);
        }
        else
        {
            $_SESSION['MSG'] = "Something_Wrong";
			$db->rplocation($manage_page_url);
        }
		/*if(@mysqli_num_rows($ctable_pro_r)>0)
		{
			$price = 0;
			while($ctable_pro_d = @mysqli_fetch_array($ctable_pro_r))
			{
				$price	= $ctable_pro_d['price'];
			}
		}

		$amount = $price + ($price * $amount / 100);
		$rows 	= array(
			"price"	=> $amount,
		);

		$where = "isDelete=0";
		$db->rpupdate($ctable,$rows,$where);
		
		$_SESSION['MSG'] = "All_Category";
		$db->rplocation($manage_page_url);
		exit;*/
		exit;
	}
	else
	{
		$update = "UPDATE product SET price = ROUND(price + (price * ".$amount." / 100),2) WHERE sub_sub_cate_id=".$sub_sub_cate_id." AND isDelete=0";
		// echo $update;die;
		$rows 	= array(
					"sub_sub_cate_id",
					"amount_percentage",
					"log",
				);
		$values = array(
					$sub_sub_cate_id,
					$amount,
					$update,
				);
		$db->rpinsert("increase_price_log",$values,$rows);
		$query = @mysqli_query($GLOBALS['myconn'],$update);

		if($query)
        {
            $_SESSION['MSG'] = "Single_Sub_Sub_Category";
			$db->rplocation($manage_page_url);
        }
        else
        {
            $_SESSION['MSG'] = "Something_Wrong";
			$db->rplocation($manage_page_url);
        }

		/*if(@mysqli_num_rows($ctable_pro_r)>0)
		{
			$price = 0;
			while($ctable_pro_d = @mysqli_fetch_array($ctable_pro_r))
			{
				$price	= $ctable_pro_d['price'];
				$id	= $ctable_pro_d['id'];

				$amount = $price + ($price * $amount / 100);
				$rows 	= array(
					"price"			=> $amount,
				);
				$where = "isDelete=0 AND cate_id='".$cate_id."' AND id='".$id."' ";
				$db->rpupdate($ctable,$rows,$where);
				$price = 0;
			}
		}*/

		
		/*$_SESSION['MSG'] = "Single_Category";
		$db->rplocation($manage_page_url);*/
		exit;
	}
	
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
                                <!-- <div class="kt-subheader__toolbar">
                                    <a href="javascript:void(0);" onClick="window.location.href='<?= $manage_page_url;?>'" class="btn btn-clean btn-icon-sm">
                                        <i class="la la-long-arrow-left"></i>
                                        Back
                                    </a>
                                </div> -->
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

												<div class="form-group">
													<label>Category <span class="text-danger">*</span></label>
													<select class="form-control" name="cate_id" id="cate_id" onChange="getSubCat(this.value);">
														<option value="">Select Category</option>
														<option value="0" >For All Category</option>
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
													<label>Sub Category <span class="text-danger">*</span></label>
													<select class="form-control" name="sub_cate_id" id="sub_cate_id" onChange="getSubSubCat(this.value);">
														<option value="">Select Sub Category</option>
													</select>
												</div>

												<div class="form-group">
													<label>Sub Sub Category <span class="text-danger">*</span></label>
													<select class="form-control" name="sub_sub_cate_id" id="sub_sub_cate_id">
														<option value="">Select Sub Sub Category</option>
													</select>
												</div>

												<div class="form-group">
													<label for="name">Increase Price Amount Percentage(%)<code>*</code></label>
													<input type="number" step="Any" class="form-control" value="<?php echo $amount; ?>" min="1" max="100" id="amount" name="amount" onkeyup="percent_amount(this.value)">
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
						sub_cate_id:{required : true},
						sub_sub_cate_id:{required : true},
		    			amount:{required : true},
					},
					messages: {
						cate_id:{required:"Please Select Category."},
						sub_cate_id:{required:"Please select sub category."},
						sub_sub_cate_id:{required:"Please select sub sub category."},
		    			amount :{required:"Please enter amount."},
					},
				});
			});

			$(document).ready(function(){
				setTimeout(function(){
				<?php if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Something_Wrong') { ?>
				 	$.notify({message: 'Something Went Wrong, Please Try Again !' },{type: 'danger'});
				<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'All_Category') { ?>
				 	$.notify({message: 'Price Increase For All Category Successfully.' },{type: 'success'});
				<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'All_Sub_Sub_Category') { ?>
				 	$.notify({message: 'Price Increase For All Sub Sub Category Successfully.' },{type: 'success'});
				<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Single_Sub_Sub_Category') { ?>
				 	$.notify({message: 'Price Increased Successfully.' },{type: 'success'});
				<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'FILE_TYPE_ERR') { ?>
		            var file_type_err = '<?php echo $_SESSION['FILE_TYPE_ERR_MSG']?>'; 
		            $.notify({message: file_type_err},{type: 'danger'});
		        <?php unset($_SESSION['MSG']); unset($_SESSION['FILE_TYPE_ERR_MSG']); }
		        ?> 
				},1000);
			});

			function percent_amount(str){
				if(str.length == 0)
				{
					$.notify({message: 'enter grater than 0 !' },{type: 'danger'});
				}
				if(str.length > 100)
				{
					$.notify({message: 'Please enter a value less than or equal to 100 !' },{type: 'danger'});
				}
			}

			function getSubCat(id,sid="")
			{
				$.ajax({
					type: "POST",
					url: "<?php echo ADMINURL?>ajax_get_sub_cat.php",
					data: 'mode=sub_cat&cate_id='+id+'&sub_cate_id='+sid,
					success: function(result)
					{
						//alert(result);
						$("#sub_cate_id").html(result);
					}
				});
			}

			function getSubSubCat(sid="",ssid="")
			{
				$.ajax({
					type: "POST",
					url: "<?php echo ADMINURL?>ajax_get_sub_cat.php",
					data: 'mode=sub_sub_cat&sub_cate_id='+sid+'&sub_sub_cate_id='+ssid,
					success: function(result)
					{
						// alert(result);
						$("#sub_sub_cate_id").html(result);
					}
				});
			}

        </script>
    </body>
</html>