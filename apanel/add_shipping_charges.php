<?php
include("connect.php");
$db->rpcheckAdminLogin();

$ctable 			= "shipping_charges";
$ctable1 			= "Shipping Charges";
$parent_page 		= "shipping_charges"; //for sidebar active menu
$main_page 			= "manage-shipping-charges"; //for sidebar active menu
$page_title 		= ucwords($_REQUEST['mode'])." ".$ctable1;
$manage_page_url 	= ADMINURL."manage-shipping-charges/";
$add_page_url 		= ADMINURL."add-shipping-charges/add/";
$edit_page_url 		= ADMINURL."add-shipping-charges/edit/".$_REQUEST['id']."/";

$from_mile = $to_mile = $amount = ""; 
$is_call = $above_mile = "0";

if(isset($_REQUEST['submit']))
{
	// $is_call  		= (isset($_REQUEST['is_call'])) ? "1" : "0";
	$above_mile  	= (isset($_REQUEST['above_mile'])) ? "1" : "0";

	$from_mile			    = $_REQUEST['from_mile'];
	$to_mile				= (isset($above_mile) && $above_mile=="1") ? "0" : $_REQUEST['to_mile'];
	$amount					= $_REQUEST['amount'];
	// $is_call				= $is_call;
	$above_mile				= $above_mile;
	
	if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="add")
	{
		if ($above_mile=="0") {
			$dup_where = " (from_mile <= ".$from_mile." AND to_mile >= ".$from_mile.") OR (from_mile <= ".$to_mile." AND to_mile >= ".$to_mile.") AND isDelete=0";
		}else{
			$dup_where = " (from_mile <= ".$from_mile." AND to_mile >= ".$from_mile.") AND isDelete=0";
		}

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
					"from_mile",
					"to_mile",
					"amount",
					// "is_call",
					"above_mile",
				);
			$values = array(
					$from_mile,
					$to_mile,
					$amount,
					// $is_call,
					$above_mile,
				);

			$db->rpinsert($ctable,$values,$rows);

			$_SESSION['MSG'] = 'Inserted';
			$db->rplocation($manage_page_url);
		}
		
	}
	else if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="edit")
	{
		if ($above_mile=="0") {
			$dup_where = "id!='".$_REQUEST['id']."' AND (from_mile <= ".$from_mile." AND to_mile >= ".$from_mile.") OR (from_mile <= ".$to_mile." AND to_mile >= ".$to_mile.") AND isDelete=0";
		}else{
			$dup_where = "id!='".$_REQUEST['id']."' AND (from_mile <= ".$from_mile." AND to_mile >= ".$from_mile.") AND isDelete=0";
		}

		
		$r = $db->rpdupCheck($ctable,$dup_where);
		if($r)
		{
			$_SESSION['MSG'] = 'Duplicate';
			$db->rplocation($manage_page_url);
			die;
		}
		else
		{			
			$rows 	= array(
					"from_mile"				=> $from_mile,
					"to_mile"				=> $to_mile,
					"amount"			    => $amount,
					// "is_call"			    => $is_call,
					"above_mile"			=> $above_mile,
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
	
	$from_mile			= $ctable_d['from_mile'];
	$to_mile			= $ctable_d['to_mile'];
	$amount				= $ctable_d['amount'];
	// $is_call			= $ctable_d['is_call'];
	$above_mile			= $ctable_d['above_mile'];

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
													<label for="from_mile">From <code>*</code></label>
													<input type="text" class="form-control" value="<?php echo $from_mile; ?>" id="from_mile" name="from_mile" >
												</div>	
												<div class="form-group">
													<label for="to_mile">To <code>*</code></label>
													<input type="text" class="form-control" value="<?php echo $to_mile; ?>" id="to_mile" name="to_mile" >
												</div>
												<div class="form-group">	
													<div class="kt-checkbox-inline">
														<label class="kt-checkbox kt-checkbox--bold kt-checkbox--success">
															<input type="checkbox" name="above_mile" id="above_mile" 
															value="<?=$above_mile?>" <?php echo ($above_mile=="1") ? "checked" : ""; ?>> Above 500 Mile?
															<span></span>
														</label>
													</div>
												</div>
												<!-- <div class="form-group">	
													<div class="kt-checkbox-inline">
														<label class="kt-checkbox kt-checkbox--bold kt-checkbox--success">
															<input type="checkbox" name="is_call" id="is_call" 
															value="<?=$is_call?>" <?php echo ($is_call=="1") ? "checked" : ""; ?>> Need To call for shipping charges?
															<span></span>
														</label>
													</div>
												</div> -->
												<div class="form-group">
													<label for="amount">Amount <code>*</code></label>
													<input type="text" class="form-control" value="<?php echo $amount; ?>" id="amount" name="amount" >
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
					rules: {
						from_mile:{required : true, number:true},
						to_mile:{
							required: function (element) {
		                     	if($("#above_mile").is(':checked')){
		                         	return false;                            
		                     	}
		                     	else
		                     	{
		                         	return true;
		                     	} 
		                  	},number:true
		                  },
						amount:{
							required: function (element) {
		                     	if($("#above_mile").is(':checked')){
		                         	return false;                            
		                     	}
		                     	else
		                     	{
		                         	return true;
		                     	} 
		                  	} 
						},number:true
					},
					messages: {
						from_mile:{required:"Please Enter from mile."},
						to_mile:{required:"Please Enter to mile."},
						amount:{required:"Please Enter amount."},
					}
				});
			});
        </script>
    </body>
</html>