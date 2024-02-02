<?php
include("connect.php");
$db->rpcheckAdminLogin();

$ctable 			= "faq";
$ctable1 			= "FAQs";
$parent_page 		= "static-pages"; //for sidebar active menu
$main_page 			= "manage-faq"; //for sidebar active menu
$page_title 		= ucwords($_REQUEST['mode'])." ".$ctable1;
$manage_page_url 	= ADMINURL."manage-faq/";
$add_page_url 		= ADMINURL."add-faq/add/";
$edit_page_url 		= ADMINURL."add-faq/edit/".$_REQUEST['id']."/";

$page_name = $description = "";

if(isset($_REQUEST['submit']))
{
	$question				= $db->clean($_REQUEST['question']);
	$answer					= $db->clean($_REQUEST['answer']);
	$adate					= date('Y-m-d H:i:s');
	
	if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="add")
	{
		$dup_where = "question = '".$question."' AND isDelete=0";
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
					"question",
					"answer",
					"adate",
				);
			$values = array(
					$question,
					$answer,
					$adate,
				);

			$db->rpinsert($ctable,$values,$rows);

			$_SESSION['MSG'] = 'Inserted';
			$db->rplocation($manage_page_url);
		}
		
	}
	else if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="edit")
	{
		$dup_where = "question = '".$question."' AND id!='".$_REQUEST['id']."' AND isDelete=0";
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
					"question"				=> $question,
					"answer"				=> $answer,
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
	
	$question		= stripslashes($ctable_d['question']);
	$answer			= stripslashes($ctable_d['answer']);

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
													<label for="name">Question <code>*</code></label>
													<input type="text" class="form-control" value="<?php echo $question; ?>" id="question" name="question" >
												</div>
																								
												<div class="form-group">
													<label for="ans">Answer <span class="text-danger">*</span></label>
													<textarea class="form-control" rows="8" id="answer" name="answer" style="min-height: 100px;"><?php echo $answer; ?></textarea>
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
						question:{required : true},
						answer:{required : true},
					},
					messages: {
						question:{required:"Please Enter Page Name."},
						answer:{required:"Please Enter Description."},
					}
				});
			});
        </script>
    </body>
</html>