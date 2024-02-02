<?php
include("connect.php");
$db->rpcheckAdminLogin(); 

$ctable 			= "careers";
$ctable1 			= "Careers";
$parent_page 		= "static-pages"; //for sidebar active menu
$main_page 			= "manage-careers"; //for sidebar active menu
$page_title 		= ucwords($_REQUEST['mode'])." ".$ctable1;
$manage_page_url 	= ADMINURL."manage-careers/";
$add_page_url 		= ADMINURL."add-careers/add/";
$edit_page_url 		= ADMINURL."add-careers/edit/".$_REQUEST['id']."/";

$page_name = $description1 = $description2 = $description3 = $description4 = "";
$meta_title 		= "";
$meta_description 	= "";
$meta_keywords 		= "";

if(isset($_REQUEST['submit']))
{

	$title					= $db->clean($_REQUEST['title']);
	$description1			= $db->clean($_REQUEST['description1']);
	$description2			= $db->clean($_REQUEST['description2']);
	$description3			= $db->clean($_REQUEST['description3']);
	$description4			= $db->clean($_REQUEST['description4']);
	$meta_title				= $db->clean($_REQUEST['meta_title']);
	$meta_description		= $db->clean($_REQUEST['meta_description']);
	$meta_keywords			= $db->clean($_REQUEST['meta_keywords']);

	if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="add")
	{
		$display_order	= $db->rpgetDisplayOrder($ctable);

			$rows 	= array(
					"title",
					"description1",
					"description2",
					"description3",
					"description4",
					"meta_title",
					"meta_description",
					"meta_keywords",
				);
			$values = array(
					$title,
					$description1,
					$description2,
					$description3,
					$description4,
					$meta_title,
					$meta_description,
					$meta_keywords,
				);

			$db->rpinsert($ctable,$values,$rows);

			$_SESSION['MSG'] = 'Inserted';
			$db->rplocation($manage_page_url);
		
	}
	else if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="edit")
	{
		$dup_where = "page_slug = '".$page_slug."' AND id!='".$_REQUEST['id']."' AND isDelete=0";
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
					"title"					=> $title,
					"description1"			=> $description1,
					"description2"			=> $description2,
					"description3"			=> $description3,
					"description4"			=> $description4,
					"meta_title"			=> $meta_title,
					"meta_description"		=> $meta_description,
					"meta_keywords"			=> $meta_keywords,
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
	
	$title					= stripslashes($ctable_d['title']);
	$description1			= $ctable_d['description1'];
	$description2			= $ctable_d['description2'];
	$description3			= $ctable_d['description3'];
	$description4			= $ctable_d['description4'];
	$meta_title				= stripslashes($ctable_d['meta_title']);
	$meta_description		= stripslashes($ctable_d['meta_description']);
	$meta_keywords			= stripslashes($ctable_d['meta_keywords']);
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
													<label for="name">Title <code>*</code></label>
													<input type="text" class="form-control" value="<?php echo $title; ?>" id="title" name="title" >
												</div>												
												<div class="form-group">
													<label for="ans">Description 1 <span class="text-danger">*</span></label>
													<textarea class="form-control summernote" rows="8" id="description1" name="description1" style="min-height: 100px;"><?php echo $description1; ?></textarea>
												</div>
												<div class="form-group">
													<label for="ans">Description 2<span class="text-danger">*</span></label>
													<textarea class="form-control summernote" rows="8" id="description2" name="description2" style="min-height: 100px;"><?php echo $description2; ?></textarea>
												</div>
												<div class="form-group">
													<label for="ans">Description 3<span class="text-danger">*</span></label>
													<textarea class="form-control summernote" rows="8" id="description3" name="description3" style="min-height: 100px;"><?php echo $description3; ?></textarea>
												</div>
												<div class="form-group">
													<label for="ans">Description 4<span class="text-danger">*</span></label>
													<textarea class="form-control summernote" rows="8" id="description4" name="description4" style="min-height: 100px;"><?php echo $description4; ?></textarea>
												</div>
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
     	  	$(function(){
				$("#frm").validate({
					rules: {
						title:{required : true},
						description1:{required : true},
						description2:{required : true},
						description3:{required : true},
						description4:{required : true},
					},
					messages: {
						title:{required:"Please Enter title."},
						description1:{required:"Please Enter Description 1."},
						description2:{required:"Please Enter Description 2."},
						description3:{required:"Please Enter Description 3."},
						description4:{required:"Please Enter Description 4."},
					}
				});
			});
        </script>
    </body>
</html>