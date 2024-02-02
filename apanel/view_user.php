<?php
include("connect.php");
$db->rpcheckAdminLogin();

$ctable             = "user";
$ctable1            = "User";
$parent_page        = "user-master"; //for sidebar active menu
$main_page          = "manage-user"; //for sidebar active menu
$page_title         = "View ".$ctable1;
$manage_page_url    = ADMINURL."manage-user/";
$add_page_url       = ADMINURL."add-user/add/";
$edit_page_url      = ADMINURL."add-user/edit/".$_REQUEST['id']."/";

if(isset($_REQUEST['id']) && $_REQUEST['id']>0)
{
    $where      = " id='".$_REQUEST['id']."' AND isDelete=0";
    $ctable_r   = $db->rpgetData($ctable,"*",$where);
    $ctable_d   = @mysqli_fetch_array($ctable_r);
    
    $first_name = stripslashes($ctable_d['first_name']);
    $last_name  = stripslashes($ctable_d['last_name']);
    $phone      = stripslashes($ctable_d['phone']);
    $city       = stripslashes($ctable_d['city']);
    $state      = stripslashes($ctable_d['state']);
    $state      = $db->rpgetValue("state","name","id='".$state."'");
    $country    = stripslashes($ctable_d['country']);
    $country    = $db->rpgetValue("country","name","id='".$country."'");
    $zipcode    = stripslashes($ctable_d['zipcode']);
    $address    = stripslashes($ctable_d['address']);
    $email      = stripslashes($ctable_d['email']);
    $adate      = date("d-m-Y H:i:s A",strtotime($ctable_d['adate']));
    $reg_ip     = stripslashes($ctable_d['reg_ip']);
    $last_login = date("d-m-Y H:i:s A",strtotime($ctable_d['last_login']));
    $status     = $ctable_d['status'] == 'Y' ? 'checked="checked"' : '';
    $agree_newsletter_email     = $ctable_d['agree_newsletter_email'] == '1' ? 'checked="checked"' : '';
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
                                                        User Information
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
                                                                    <label>First Name</label>
                                                                    <input type="text" class="form-control" value="<?php echo $first_name; ?>" id="first_name" name="first_name" readonly>
                                                                </div> 
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Last Name</label>
                                                                    <input type="text" class="form-control" value="<?php echo $last_name; ?>" id="last_name" name="last_name" readonly>
                                                                </div> 
                                                            </div>
                                                        
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Phone Number</label>
                                                                    <input type="text" class="form-control" value="<?php echo $phone; ?>" id="phone" name="phone" readonly>
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
                                                                    <label>Address</label>
                                                                    <textarea class="form-control" style="min-height: 100px;" id="address" name="address" readonly><?php echo $address?></textarea>
                                                                </div> 
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>City</label>
                                                                    <input type="text" class="form-control" value="<?php echo $city; ?>" id="city" name="city" readonly>
                                                                </div> 
                                                            </div>
                                                        
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Region, State OR Province</label>
                                                                    <input type="text" class="form-control" value="<?php echo $state; ?>" id="state" name="state" readonly>
                                                                </div> 
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Country</label>
                                                                    <input type="text" class="form-control" value="<?php echo $country; ?>" id="country" name="country" readonly>
                                                                </div> 
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Zip/Postal Code</label>
                                                                    <input type="text" class="form-control" value="<?php echo $zipcode; ?>" id="zipcode" name="zipcode" readonly>
                                                                </div> 
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Register IP Address</label>
                                                                    <input type="text" class="form-control" value="<?php echo $reg_ip; ?>" id="reg_ip" name="reg_ip" readonly>
                                                                </div> 
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Register On</label>
                                                                    <input type="text" class="form-control" value="<?php echo $adate; ?>" id="adate" name="adate" readonly>
                                                                </div> 
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Last Login Date</label>
                                                                    <input type="text" class="form-control" value="<?php echo $last_login; ?>" id="last_login" name="last_login" readonly>
                                                                </div> 
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Account Status</label><br>
                                                                    <span class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success">
                                                                        <label>
                                                                            <input type="checkbox" <?=$status;?> disabled>
                                                                            <span></span>
                                                                        </label>
                                                                    </span>
                                                                </div> 
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Subscribe for Newsletter Email ?</label>
                                                                    <div class="kt-checkbox-list">
                                                                        <label class="kt-checkbox kt-checkbox--bold kt-checkbox--success">
                                                                            <input type="checkbox" <?=$agree_newsletter_email;?> disabled> Yes
                                                                            <span></span>
                                                                        </label>
                                                                    </div>
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
                    rules: {
                        name:{required : true},
                        image_path:{required : $("#mode").val()=="add" && $("#filename").val()=="" },
                        filename:{ required: $("#mode").val()=="add" && $("#filename").val()=="" },
                        
                    },
                    messages: {
                        name:{required:"Please enter category name."},
                        image_path:{required:"Please upload image."},
                        filename:{required:"Please click on right tick mark after upload image."},
                    
                    }
                });
            });
        </script>
    </body>
</html>