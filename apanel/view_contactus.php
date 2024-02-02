<?php
include("connect.php");
$db->rpcheckAdminLogin();

$ctable             = "contactus";
$ctable1            = "Contact Inquiry";
$parent_page        = "contactus"; //for sidebar active menu
$main_page          = "manage-contactus"; //for sidebar active menu
$page_title         = "View ".$ctable1;
$manage_page_url    = ADMINURL."manage-contactus/";
$add_page_url       = ADMINURL."add-contactus/add/";
$edit_page_url      = ADMINURL."add-contactus/edit/".$_REQUEST['id']."/";

if(isset($_REQUEST['id']) && $_REQUEST['id']>0)
{
    $where      = " id='".$_REQUEST['id']."' AND isDelete=0";
    $ctable_r   = $db->rpgetData($ctable,"*",$where);
    $ctable_d   = @mysqli_fetch_array($ctable_r);
    
    $name       = stripslashes($ctable_d['name']);
    $email      = stripslashes($ctable_d['email']);
    $subject    = stripslashes($ctable_d['subject']);
    $message    = stripslashes($ctable_d['message']);
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
                                        <div class="accordion accordion-solid accordion-toggle-svg" id="viewpage_accordion">
                                            <div class="card">
                                                <div class="card-header" id="headingOne8">
                                                    <div class="card-title" data-toggle="collapse" data-target="#collapseOne8" aria-expanded="true" aria-controls="collapseOne8">
                                                        Contact Inquiry Information
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <polygon id="Shape" points="0 0 24 0 24 24 0 24"></polygon>
                                                                <path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" id="Path-94" fill="#000000" fill-rule="nonzero"></path>
                                                                <path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" id="Path-94" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "></path>
                                                            </g>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div id="collapseOne8" class="collapse show" aria-labelledby="headingOne8" data-parent="#viewpage_accordion">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Name</label>
                                                                    <input type="text" class="form-control" value="<?php echo $name; ?>" id="name" name="name" readonly>
                                                                </div> 
                                                            </div>
                                                        
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Email Address</label>
                                                                    <input type="text" class="form-control" value="<?php echo $email; ?>" id="email" name="email" readonly>
                                                                </div> 
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Subject</label>
                                                                    <input type="text" class="form-control" value="<?php echo $subject; ?>" id="subject" name="subject" readonly>
                                                                </div> 
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Message</label>
                                                                    <textarea class="form-control" style="min-height: 100px;" id="message" name="message" readonly><?php echo $message; ?></textarea>
                                                                </div> 
                                                            </div>  
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
    </body>
</html>