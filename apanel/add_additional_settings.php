<?php
include("connect.php");
$db->rpcheckAdminLogin();

$ctable             = "site_setting";
$ctable1            = "Additional settings";
$parent_page        = "additional-settings"; //for sidebar active menu
$main_page          = "add-additional-settings"; //for sidebar active menu
$page_title 		= ucwords($_REQUEST['mode'])." ".$ctable1;
$add_page_url 		= ADMINURL."add-additional-settings/add/";
$edit_page_url 		= ADMINURL."add-additional-settings/edit/".$_REQUEST['id']."/";

$other_cus_tracking_num = $custom_tracking = $website_schema = $local_scheme = $ecommerce_scheme = $breadcrumb_scheme = $google_analytics = $google_tag_manager = "";

if(isset($_REQUEST['submit']))
{	
	$website_schema				= addslashes($_REQUEST['website_schema']);
	$local_scheme				= addslashes($_REQUEST['local_scheme']);
	$ecommerce_scheme			= addslashes($_REQUEST['ecommerce_scheme']);
	$breadcrumb_scheme			= addslashes($_REQUEST['breadcrumb_scheme']);
	$google_analytics			= addslashes($_REQUEST['google_analytics']);
	$google_tag_manager			= addslashes($_REQUEST['google_tag_manager']);
	$custom_tracking			= addslashes($_REQUEST['custom_tracking']);
	$other_cus_tracking_num		= addslashes($_REQUEST['other_cus_tracking_num']);

 	if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="edit")
	{
		$rows 	= array(
				"website_schema"					=> $website_schema,
				"local_scheme"						=> $local_scheme,
				"ecommerce_scheme"					=> $ecommerce_scheme,
				"breadcrumb_scheme"					=> $breadcrumb_scheme,
				"google_analytics"					=> $google_analytics,
				"google_tag_manager"				=> $google_tag_manager,
				"custom_tracking"					=> $custom_tracking,
				"other_cus_tracking_num"			=> $other_cus_tracking_num,
			);

		$where	= "id='1'";
		$db->rpupdate($ctable,$rows,$where);

		$_SESSION['MSG'] = "Updated";
		$db->rplocation($edit_page_url);
		die();
	}
}

if($_REQUEST['mode']=="edit")
{
	$where 		= " id=1";
	$ctable_r 	= $db->rpgetData($ctable,"*",$where,"");
	$ctable_d 	= @mysqli_fetch_array($ctable_r);
	
	$website_schema				= $ctable_d['website_schema'];
	$local_scheme				= $ctable_d['local_scheme'];
	$ecommerce_scheme			= $ctable_d['ecommerce_scheme'];
	$breadcrumb_scheme			= $ctable_d['breadcrumb_scheme'];
	$google_analytics			= $ctable_d['google_analytics'];
	$google_tag_manager			= $ctable_d['google_tag_manager'];
	$custom_tracking			= $ctable_d['custom_tracking'];
	$other_cus_tracking_num		= $ctable_d['other_cus_tracking_num'];
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

										    	<input type="hidden" name="mode" id="mode" value="<?php echo "edit"; ?>">
												<input type="hidden" name="id" id="id" value="<?php echo 1; ?>">

												<div class="form-group">
													<label for="website_schema">Website Schema Code</label>
													<textarea class="form-control" rows="8" id="website_schema" name="website_schema" style="min-height: 100px;"><?php echo $website_schema; ?></textarea>
												</div>
												
												
												<div class="form-group">
													<label for="local_scheme">Local Schema Code</label>
													<textarea class="form-control" rows="8" id="local_scheme" name="local_scheme" style="min-height: 100px;"><?php echo $local_scheme; ?></textarea>
												</div>

												<div class="form-group">
													<label for="ecommerce_scheme">Ecommerce Schema Code</label>
													<textarea class="form-control" rows="8" id="ecommerce_scheme" name="ecommerce_scheme" style="min-height: 100px;"><?php echo $ecommerce_scheme; ?></textarea>
												</div>
												<div class="form-group">
													<label for="breadcrumb_scheme">Breadcrumb Schema Code</label>
													<textarea class="form-control" rows="8" id="breadcrumb_scheme" name="breadcrumb_scheme" style="min-height: 100px;"><?php echo $breadcrumb_scheme; ?></textarea>
												</div>
												<div class="form-group">
													<label for="google_analytics">Google Analytics Tracking Code</label>
													<textarea class="form-control" rows="8" id="google_analytics" name="google_analytics" style="min-height: 100px;"><?php echo $google_analytics; ?></textarea>
												</div>
												<div class="form-group">
													<label for="google_tag_manager">Google Tag Manager Code</label>
													<textarea class="form-control" rows="8" id="google_tag_manager" name="google_tag_manager" style="min-height: 100px;"><?php echo $google_tag_manager; ?></textarea>
												</div>
												<div class="form-group">
													<label for="custom_tracking">Other Custom Tracking Code</label>
													<textarea class="form-control" rows="8" id="custom_tracking" name="custom_tracking" style="min-height: 100px;"><?php echo $custom_tracking; ?></textarea>
												</div>	
												<div class="form-group">
													<label for="other_cus_tracking_num">Other Custom Tracking / Number</label>
													<textarea class="form-control" rows="8" id="other_cus_tracking_num" name="other_cus_tracking_num" style="min-height: 100px;"><?php echo $other_cus_tracking_num; ?></textarea>
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
						website_schema:{required : false},
						local_scheme:{required : false},
						ecommerce_scheme:{required : false},
						ecommerce_scheme:{required : false},
						breadcrumb_scheme:{required : false},
						google_analytics:{required : false},
						google_tag_manager:{required : false},
						custom_tracking:{required : false},
						other_cus_tracking_num:{required : false},
					},
					messages: {
						website_schema:{required:"Please Enter Website schema code."},
						local_scheme:{required:"Please Enter Local schema code."},
						ecommerce_scheme:{required:"Please Enter Ecommerce schema code."},
						breadcrumb_scheme:{required:"Please Enter Breadcrumb schema code."},
						google_analytics:{required:"Please Enter Google Analytics code."},
						google_tag_manager:{required:"Please Enter Google Tag Manager code."},
						custom_tracking:{required:"Please Enter Custom Tracking code."},
						other_cus_tracking_num:{required:"Please Enter Other Custom Tracking / Number."},
					}
				});
			});
        </script>
    </body>
</html>