<?php
include("connect.php");
$db->rpcheckAdminLogin();

$name       = "";
$email          = "";

if(isset($_REQUEST['submit']))
{
    $name       = $db->clean($_REQUEST['name']);
    $email      = $db->clean($_REQUEST['email']);

    $dup_where = "email='".$email."' AND isDelete=0 AND id!='".$_SESSION[SESS_PRE.'_ADMIN_SESS_ID']."'";
    $r = $db->rpdupCheck(CTABLE_ADMIN,$dup_where);
    if($r)
    {
        $_SESSION['MSG'] = "Duplicate_Entry";
        $db->rplocation(ADMINURL."my-account/");    
        exit;
    }
    else
    {
        $rows   = array("name"=>$name,"email"=>$email);
        $where  = "id='".$_SESSION[SESS_PRE.'_ADMIN_SESS_ID'] ."' AND isDelete=0";
        $db->rpupdate(CTABLE_ADMIN,$rows,$where);
        
        $_SESSION[SESS_PRE.'_ADMIN_SESS_NAME']  = $name;
        $_SESSION['MSG'] = 'UPDATE_AC';

        $db->rplocation(ADMINURL."my-account/");
        exit;   
    }
}

if(isset($_REQUEST['submit1']))
{
    $where = " id='".$_SESSION[SESS_PRE.'_ADMIN_SESS_ID']."' AND isDelete=0";
    $admin_r = $db->rpgetData(CTABLE_ADMIN,"*",$where);
    $admin_d = @mysqli_fetch_array($admin_r);

    $old_password   = $admin_d['password'];
    $opassword      = md5(trim($_REQUEST['opassword']));
    $password       = md5(trim($_REQUEST['password']));

    if($old_password!=$opassword)
    {
        $_SESSION['MSG'] = 'PASS_NOT_MATCH';
        $db->rplocation(ADMINURL."my-account/");
        exit;
    }
    else
    {
        $rows   = array("password"=>$password);
        $where  = "id='".$_SESSION[SESS_PRE.'_ADMIN_SESS_ID'] ."' AND isDelete=0";
        $db->rpupdate(CTABLE_ADMIN,$rows,$where);

        $_SESSION['MSG'] = 'PASS_CHANGED';
        $db->rplocation(ADMINURL."my-account/");
        exit;
    }
}

if(isset($_REQUEST['submit2']))
{
    $address                        = addslashes($_REQUEST['address']);
    $email_address                  = $db->clean($_REQUEST['email_address']);
    $telephone_number               = $db->clean($_REQUEST['telephone_number']);
    $store_hours_monday             = $db->clean($_REQUEST['store_hours_monday']);
    $store_hours_tuesday            = $db->clean($_REQUEST['store_hours_tuesday']);
    $store_hours_wednesday          = $db->clean($_REQUEST['store_hours_wednesday']);
    $store_hours_thursday           = $db->clean($_REQUEST['store_hours_thursday']);
    $store_hours_friday             = $db->clean($_REQUEST['store_hours_friday']);
    $store_hours_saturday           = $db->clean($_REQUEST['store_hours_saturday']);
    $store_hours_sunday             = $db->clean($_REQUEST['store_hours_sunday']);
    $map_embed_iframe               = addslashes($_REQUEST['map_embed_iframe']);
    $facebook_link                  = addslashes($_REQUEST['facebook_link']);
    $twitter_link                   = addslashes($_REQUEST['twitter_link']);
    $instagram_link                  = addslashes($_REQUEST['instagram_link']);

    if($address!= "" && $email_address !="" && $telephone_number !="")
    {
        $rows   = array(
                    "address"                   =>  $address,
                    "email_address"             =>  $email_address,
                    "telephone_number"          =>  $telephone_number,
                    "store_hours_monday"        =>  $store_hours_monday,
                    "store_hours_tuesday"       =>  $store_hours_tuesday,
                    "store_hours_wednesday"     =>  $store_hours_wednesday,
                    "store_hours_thursday"      =>  $store_hours_thursday,
                    "store_hours_friday"        =>  $store_hours_friday,
                    "store_hours_saturday"      =>  $store_hours_saturday,
                    "store_hours_sunday"        =>  $store_hours_sunday,
                    "map_embed_iframe"          =>  $map_embed_iframe,
                    "facebook_link"             =>  $facebook_link,
                    "twitter_link"              =>  $twitter_link,
                    "instagram_link"            =>  $instagram_link,
                );

        $where  = "id='1'";
        $db->rpupdate("site_setting",$rows,$where);

        $_SESSION['MSG'] = 'Site_Setting_Updated';
        $db->rplocation(ADMINURL."my-account/");
        exit;
    }
    else
    {
        $_SESSION['MSG'] = "something_went_wrong";
        $db->rplocation(ADMINURL."my-account/");    
        exit;
    }
}

$where = " id='".$_SESSION[SESS_PRE.'_ADMIN_SESS_ID'] ."' AND isDelete=0";
$admin_r = $db->rpgetData(CTABLE_ADMIN,"*",$where);
$admin_d = @mysqli_fetch_array($admin_r);

$name = stripslashes($admin_d['name']);
$email = stripslashes($admin_d['email']);

$site_setting_where = " id='1'";
$site_setting_r = $db->rpgetData("site_setting","*",$site_setting_where);
$site_setting_d = @mysqli_fetch_array($site_setting_r);

$address                    = stripslashes($site_setting_d['address']);
$email_address              = stripslashes($site_setting_d['email_address']);
$telephone_number           = stripslashes($site_setting_d['telephone_number']);
$store_hours_monday         = stripslashes($site_setting_d['store_hours_monday']);
$store_hours_tuesday        = stripslashes($site_setting_d['store_hours_tuesday']);
$store_hours_wednesday      = stripslashes($site_setting_d['store_hours_wednesday']);
$store_hours_thursday       = stripslashes($site_setting_d['store_hours_thursday']);
$store_hours_friday         = stripslashes($site_setting_d['store_hours_friday']);
$store_hours_saturday       = stripslashes($site_setting_d['store_hours_saturday']);
$store_hours_sunday         = stripslashes($site_setting_d['store_hours_sunday']);
$map_embed_iframe           = stripslashes($site_setting_d['map_embed_iframe']);
$facebook_link              = stripslashes($site_setting_d['facebook_link']);
$twitter_link               = stripslashes($site_setting_d['twitter_link']);
$instagram_link             = stripslashes($site_setting_d['instagram_link']);
?>
<!DOCTYPE html>
<html lang="en" >
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <head>
        <title>My Account | <?php echo ADMINTITLE; ?></title>
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
                        <!-- begin:: Content Head -->
                        <div class="kt-subheader   kt-grid__item" id="kt_subheader">
                            <div class="kt-container  kt-container--fluid ">
                                <div class="kt-subheader__main">
                                    <h3 class="kt-subheader__title">
                                        My Account                           
                                    </h3>
                                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                                    <div class="kt-subheader__group" id="kt_subheader_search">
                                        <span class="kt-subheader__desc" id="kt_subheader_total">
                                            <?=$dis_admin_name;?>
                                        </span>
                                    </div>
                                </div>
                                <div class="kt-subheader__toolbar">
                                    <a href="javascript:void(0);" onclick="window.history.back();" class="btn btn-clean btn-icon-sm">
                                        <i class="la la-long-arrow-left"></i>
                                        Back
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- end:: Content Head -->                 
                        <!-- begin:: Content -->
                        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                            <div class="kt-portlet kt-portlet--tabs">
                                <div class="kt-portlet__head">
                                    <div class="kt-portlet__head-toolbar">
                                        <ul class="nav nav-tabs nav-tabs-space-xl nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#kt_apps_user_edit_tab_2" role="tab">
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <polygon id="Shape" points="0 0 24 0 24 24 0 24"/>
                                                            <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" id="Mask" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                            <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" id="Mask-Copy" fill="#000000" fill-rule="nonzero"/>
                                                        </g>
                                                    </svg>
                                                    Account
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#kt_apps_user_edit_tab_3" role="tab">
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <rect id="bound" x="0" y="0" width="24" height="24"/>
                                                            <path d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z" id="Path-50" fill="#000000" opacity="0.3"/>
                                                            <path d="M12,11 C10.8954305,11 10,10.1045695 10,9 C10,7.8954305 10.8954305,7 12,7 C13.1045695,7 14,7.8954305 14,9 C14,10.1045695 13.1045695,11 12,11 Z" id="Mask" fill="#000000" opacity="0.3"/>
                                                            <path d="M7.00036205,16.4995035 C7.21569918,13.5165724 9.36772908,12 11.9907452,12 C14.6506758,12 16.8360465,13.4332455 16.9988413,16.5 C17.0053266,16.6221713 16.9988413,17 16.5815,17 C14.5228466,17 11.463736,17 7.4041679,17 C7.26484009,17 6.98863236,16.6619875 7.00036205,16.4995035 Z" id="Mask-Copy" fill="#000000" opacity="0.3"/>
                                                        </g>
                                                    </svg>
                                                    Change Password
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#kt_apps_user_edit_tab_4" role="tab">
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <rect id="Bound" opacity="0.200000003" x="0" y="0" width="24" height="24"/>
                                                            <path d="M4.5,7 L9.5,7 C10.3284271,7 11,7.67157288 11,8.5 C11,9.32842712 10.3284271,10 9.5,10 L4.5,10 C3.67157288,10 3,9.32842712 3,8.5 C3,7.67157288 3.67157288,7 4.5,7 Z M13.5,15 L18.5,15 C19.3284271,15 20,15.6715729 20,16.5 C20,17.3284271 19.3284271,18 18.5,18 L13.5,18 C12.6715729,18 12,17.3284271 12,16.5 C12,15.6715729 12.6715729,15 13.5,15 Z" id="Combined-Shape" fill="#000000" opacity="0.3"/>
                                                            <path d="M17,11 C15.3431458,11 14,9.65685425 14,8 C14,6.34314575 15.3431458,5 17,5 C18.6568542,5 20,6.34314575 20,8 C20,9.65685425 18.6568542,11 17,11 Z M6,19 C4.34314575,19 3,17.6568542 3,16 C3,14.3431458 4.34314575,13 6,13 C7.65685425,13 9,14.3431458 9,16 C9,17.6568542 7.65685425,19 6,19 Z" id="Combined-Shape" fill="#000000"/>
                                                        </g>
                                                    </svg>
                                                    Site Setting
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="kt-portlet__body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="kt_apps_user_edit_tab_2" role="tabpanel">
                                            <form name="frm" id="frm" role="form" action="" method="post" enctype="multipart/form-data">
                                                <div class="kt-form kt-form--label-right">
                                                    <div class="kt-form__body">
                                                        <div class="kt-section kt-section--first">
                                                            <div class="kt-section__body">
                                                                <div class="row">
                                                                    <label class="col-xl-3"></label>
                                                                    <div class="col-lg-9 col-xl-6">
                                                                        <h3 class="kt-section__title kt-section__title-sm">Account Details:</h3>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-xl-3 col-lg-3 col-form-label">Name</label>
                                                                    <div class="col-lg-9 col-xl-6">
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="la la-user"></i></span></div>
                                                                            <input class="form-control" type="text" value="<?php echo $name; ?>" id="name" name="name" placeholder="Enter name" aria-describedby="basic-addon1">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-xl-3 col-lg-3 col-form-label">Email Address</label>
                                                                    <div class="col-lg-9 col-xl-6">
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="la la-at"></i></span></div>
                                                                            <input type="text" class="form-control"  name="email" id="email" placeholder="Enter Email" value="<?php echo $email; ?>" aria-describedby="basic-addon1">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="kt-separator kt-separator--space-lg kt-separator--fit kt-separator--border-solid"></div>
                                                <div class="kt-form__actions">
                                                    <div class="row">
                                                        <div class="col-xl-3"></div>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <button type="submit" name="submit" id="submit" class="btn btn-label-brand btn-bold">Save Changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane" id="kt_apps_user_edit_tab_3" role="tabpanel">
                                            <form action="" name="frm_pass" id="frm_pass"  method="post">
                                                <div class="kt-form kt-form--label-right">
                                                    <div class="kt-form__body">
                                                        <div class="kt-section kt-section--first">
                                                            <div class="kt-section__body">
                                                                <div class="row">
                                                                    <label class="col-xl-3"></label>
                                                                    <div class="col-lg-9 col-xl-6">
                                                                        <h3 class="kt-section__title kt-section__title-sm">Change Your Password:</h3>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-xl-3 col-lg-3 col-form-label">Current Password</label>
                                                                    <div class="col-lg-9 col-xl-6">
                                                                        <input type="password" name="opassword" id="opassword" class="form-control" value="" placeholder="Current password">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-xl-3 col-lg-3 col-form-label">New Password</label>
                                                                    <div class="col-lg-9 col-xl-6">
                                                                        <input type="password" class="form-control" name="password" id="password" value="" placeholder="New password">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group form-group-last row">
                                                                    <label class="col-xl-3 col-lg-3 col-form-label">Verify Password</label>
                                                                    <div class="col-lg-9 col-xl-6">
                                                                        <input type="password" class="form-control" name="cpassword" id="cpassword" value="" placeholder="Verify password">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="kt-separator kt-separator--space-lg kt-separator--fit kt-separator--border-solid"></div>
                                                    <div class="kt-form__actions">
                                                        <div class="row">
                                                            <div class="col-xl-3"></div>
                                                            <div class="col-lg-9 col-xl-6">
                                                                <button type="submit" name="submit1" id="submit1" class="btn btn-label-brand btn-bold">Save Changes</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane" id="kt_apps_user_edit_tab_4" role="tabpanel">
                                            <form action="" name="frmsitesetting" id="frmsitesetting"  method="post">
                                                <div class="kt-form kt-form--label-right">
                                                    <div class="kt-form__body">
                                                        <div class="kt-section kt-section--first">
                                                            <div class="kt-section__body">
                                                                <div class="row">
                                                                    <label class="col-xl-3"></label>
                                                                    <div class="col-lg-9 col-xl-6">
                                                                        <h3 class="kt-section__title kt-section__title-sm">Site setting:</h3>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-xl-3 col-lg-3 col-form-label">Address Details </label>
                                                                    <div class="col-lg-9 col-xl-6">
                                                                        <textarea name="address" id="address" class="form-control" style="min-height: 110px;" placeholder="Address"><?php echo $address; ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-xl-3 col-lg-3 col-form-label">Email Address</label>
                                                                    <div class="col-lg-9 col-xl-6">
                                                                        <input type="text" class="form-control" name="email_address" id="email_address" value="<?php echo $email_address; ?>" placeholder="Email Address">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-xl-3 col-lg-3 col-form-label">Telephone Number</label>
                                                                    <div class="col-lg-9 col-xl-6">
                                                                        <input type="text" class="form-control" name="telephone_number" id="telephone_number" value="<?php echo $telephone_number; ?>" placeholder="Telephone number">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-xl-3 col-lg-3 col-form-label">Store Hours Of Monday</label>
                                                                    <div class="col-lg-9 col-xl-6">
                                                                        <input type="text" class="form-control" value="<?php echo $store_hours_monday; ?>" id="store_hours_monday" name="store_hours_monday">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label class="col-xl-3 col-lg-3 col-form-label">Store Hours Of Tuesday</label>
                                                                    <div class="col-lg-9 col-xl-6">
                                                                        <input type="text" class="form-control" value="<?php echo $store_hours_tuesday; ?>" id="store_hours_tuesday" name="store_hours_tuesday">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label class="col-xl-3 col-lg-3 col-form-label">Store Hours Of Wednesday</label>
                                                                    <div class="col-lg-9 col-xl-6">
                                                                        <input type="text" class="form-control" value="<?php echo $store_hours_wednesday; ?>" id="store_hours_wednesday" name="store_hours_wednesday">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label class="col-xl-3 col-lg-3 col-form-label">Store hours of Thursday</label>
                                                                    <div class="col-lg-9 col-xl-6">
                                                                        <input type="text" class="form-control" value="<?php echo $store_hours_thursday; ?>" id="store_hours_thursday" name="store_hours_thursday">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label class="col-xl-3 col-lg-3 col-form-label">Store Hours Of Friday</label>
                                                                    <div class="col-lg-9 col-xl-6">
                                                                        <input type="text" class="form-control" value="<?php echo $store_hours_friday; ?>" id="store_hours_friday" name="store_hours_friday">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label class="col-xl-3 col-lg-3 col-form-label">Store Hours Of Saturday</label>
                                                                    <div class="col-lg-9 col-xl-6">
                                                                        <input type="text" class="form-control" value="<?php echo $store_hours_saturday; ?>" id="store_hours_saturday" name="store_hours_saturday">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label class="col-xl-3 col-lg-3 col-form-label">Store Hours Of Sunday</label>
                                                                    <div class="col-lg-9 col-xl-6">
                                                                        <input type="text" class="form-control" value="<?php echo $store_hours_sunday; ?>" id="store_hours_sunday" name="store_hours_sunday">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-xl-3 col-lg-3 col-form-label">Map Embed Iframe Code</label>
                                                                    <div class="col-lg-9 col-xl-6">
                                                                        <textarea name="map_embed_iframe" id="map_embed_iframe" class="form-control" style="min-height: 110px;" placeholder="Map Embed Iframe"><?php echo $map_embed_iframe; ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-xl-3 col-lg-3 col-form-label">Facebook Link</label>
                                                                    <div class="col-lg-9 col-xl-6">
                                                                        <input type="text" class="form-control" value="<?php echo $facebook_link; ?>" id="facebook_link" name="facebook_link">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-xl-3 col-lg-3 col-form-label">Twitter Link</label>
                                                                    <div class="col-lg-9 col-xl-6">
                                                                        <input type="text" class="form-control" value="<?php echo $twitter_link; ?>" id="twitter_link" name="twitter_link">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row form-group-last">
                                                                    <label class="col-xl-3 col-lg-3 col-form-label">Instagram Link</label>
                                                                    <div class="col-lg-9 col-xl-6">
                                                                        <input type="text" class="form-control" value="<?php echo $instagram_link; ?>" id="instagram_link" name="instagram_link">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="kt-separator kt-separator--space-lg kt-separator--fit kt-separator--border-solid"></div>
                                                    <div class="kt-form__actions">
                                                        <div class="row">
                                                            <div class="col-xl-3"></div>
                                                            <div class="col-lg-9 col-xl-6">
                                                                <button type="submit" name="submit2" id="submit2" class="btn btn-label-brand btn-bold">Save Changes</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
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
                        name:{required : true},
                        email:{required : true,email:true},
                    },
                    messages: {
                        name:{required:"Please enter Your name."},
                        email:{required:"Please enter your email.",email:"Please enter valid email address."},
                    }
                });
            });

            $(function(){
                $("#frm_pass").validate({
                    rules: {
                        opassword:{required : true},
                        password:{required : true},
                        cpassword:{required : true,equalTo: "#password"},
                    },
                    messages: {
                        opassword:{required:"Please enter current password."},
                        password:{required:"Please enter new password."},
                        cpassword:{required:"Please enter verify password.", equalTo:"New password and verify password not matched."},
                    }
                });
            });
            $(function(){
                $("#frmsitesetting").validate({
                    rules: {
                        address:{required : true},
                        email_address:{required : true},
                        telephone_number:{required : true},
                        store_hours_monday:{required : true},
                        store_hours_tuesday:{required : true},
                        store_hours_wednesday:{required : true},
                        store_hours_thursday:{required : true},
                        store_hours_friday:{required : true},
                        store_hours_saturday:{required : true},
                        store_hours_sunday:{required : true},
                        map_embed_iframe:{required : true},
                    },
                    messages: {
                        address:{required:"Please enter site address."},
                        email_address:{required:"Please enter site email address."},
                        telephone_number:{required:"Please enter site telephone number."},
                        store_hours_monday:{required:"Please enter store hours of monday."},
                        store_hours_tuesday:{required:"Please enter store hours of tuesday."},
                        store_hours_wednesday:{required:"Please enter store hours of wednesday."},
                        store_hours_thursday:{required:"Please enter store hours of thursday."},
                        store_hours_friday:{required:"Please enter store hours of friday."},
                        store_hours_saturday:{required:"Please enter store hours of saturday."},
                        store_hours_sunday:{required:"Please enter store hours of sunday."},
                        map_embed_iframe:{required:"Please enter map embed iframe code."},
                    }
                });
            });
        </script>
    </body>
</html>