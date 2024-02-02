<?php
include("connect.php");
$db->rpcheckAdminLogin();

$ctable 			= "coupon";
$ctable1 			= "Coupon";
$parent_page 		= "coupon-master"; //for sidebar active menu
$main_page 			= "manage-coupon"; //for sidebar active menu
$page_title 		= ucwords($_REQUEST['mode'])." ".$ctable1;
$manage_page_url 	= ADMINURL."manage-coupon/";
$add_page_url 		= ADMINURL."add-coupon/add/";
$edit_page_url 		= ADMINURL."add-coupon/edit/".$_REQUEST['id']."/";

$seller_id 			= 0;
$name 				= "";
$code 				= "";
$type				= "";
$amount				= "";
$min_spend_amount	= 0;
$start_date			= "";
$expiration_date	= "";

if(isset($_REQUEST['submit'])){

	$name				= $db->clean($_REQUEST['name']);
	$code				= $db->clean($_REQUEST['code']);
	$type				= $db->clean($_REQUEST['type']);
	$slug				= $db->rpcreateSlug($_REQUEST['code']);
	$amount				= $db->clean($_REQUEST['amount']);
	$min_spend_amount	= $db->clean($_REQUEST['min_spend_amount']);
	$start_date			= date("Y-m-d",strtotime($_REQUEST['start_date']));
	$expiration_date	= date("Y-m-d",strtotime($_REQUEST['expiration_date']));

	if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="add")
	{
		$dup_where = "slug = '".$slug."' AND isDelete=0 AND seller_id='".$seller_id."'";
		$r = $db->rpdupCheck($ctable,$dup_where);
		if($r){
			$_SESSION['MSG'] = "Duplicate";
			$db->rplocation($add_page_url);
			exit;
		}else{
			$rows 	= array(
					"seller_id",
					"name",
					"code",
					"type",
					"slug",
					"amount",
					"min_spend_amount",
					"start_date",
					"expiration_date",
				);
			$values = array(
					$seller_id,
					$name,
					$code,
					$type,
					$slug,
					$amount,
					$min_spend_amount,
					$start_date,
					$expiration_date,
				);
			$last_id =  $db->rpinsert($ctable,$values,$rows);

			$_SESSION['MSG'] = "Inserted";
			$db->rplocation($manage_page_url);
			exit;
		}
		
	}
	else if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="edit")
	{    
		$dup_where = "slug = '".$slug."' AND id!='".$_REQUEST['id']."' AND isDelete=0 AND seller_id='".$seller_id."'";
		$r = $db->rpdupCheck($ctable,$dup_where);
		if($r)
		{
			$_SESSION['MSG'] = "Duplicate";
			$db->rplocation($edit_page_url);
			exit;
		}
		else
		{
			$rows 	= array(
					"name"				=> $name,
					"code"				=> $code,
					"type"				=> $type,
					"slug"				=> $slug,
					"amount"			=> $amount,
					"min_spend_amount"	=> $min_spend_amount,
					"start_date"		=> $start_date,
					"expiration_date"	=> $expiration_date,
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
	$where 		= " id='".$_REQUEST['id']."' AND isDelete=0 AND seller_id='".$seller_id."'";
	$ctable_r 	= $db->rpgetData($ctable,"*",$where);
	$ctable_d 	= @mysqli_fetch_array($ctable_r);
	
	$id					= $ctable_d['id'];
	$name				= stripslashes($ctable_d['name']);
	$code 				= stripslashes($ctable_d['code']);
	$type				= stripslashes($ctable_d['type']);
	$amount		 		= stripslashes($ctable_d['amount']);
	$min_spend_amount	= stripslashes($ctable_d['min_spend_amount']);
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
													<label for="name">Coupon Name <code>*</code></label>
													<input type="text" class="form-control" value="<?php echo $name; ?>" id="name" name="name">
												</div>

												<div class="form-group">
													<label for="name">Coupon Code <code>*</code></label>
													<input type="text" class="form-control" value="<?php echo $code; ?>" id="code" name="code">
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
													<label for="name">minimum spend Amount <code>*</code></label>
													<input type="number" step="Any" class="form-control" value="<?php echo $min_spend_amount; ?>" min="0" id="min_spend_amount" name="min_spend_amount">
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
        	var custom_img_width = '530';

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
					ignore: "",
					rules: {
						name:{required : true},
		    			code:{required : true},
		    			type:{required : true},
		    			amount:{required : true},
		    			min_spend_amount:{required : true},
		    			start_date:{required : true},
		    			expiration_date:{required : true},
					},
					messages: {
						name :{required:"Please enter Coupon Name."},
		    			code :{required:"Please enter Coupon Code."},
		    			type :{required:"Please select type."},
		    			amount :{required:"Please enter amount."},
		    			min_spend_amount :{required:"Please enter minimu amount ."},
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
        </script>
    </body>
</html>