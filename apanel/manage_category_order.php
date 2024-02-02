<?php
include("connect.php");
$db->rpcheckAdminLogin();

$ctable             = "category";
$ctable1            = "Category";
$parent_page        = "product-master"; //for sidebar active menu
$main_page          = "manage-category"; //for sidebar active menu
$page_title         = "Manage ".$ctable1." Order";
?>
<!DOCTYPE html>
<html lang="en" >
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <head>
        <title><?php echo $page_title?> | <?php echo ADMINTITLE; ?></title>
        <?php include('include_css.php'); ?>
        <style>
           #page_list li
           {
            padding:5px;
            background-color:#f9f9f9;
            border:1px dotted #ccc;
            cursor:move;
            margin-top:12px;
           }
           #page_list li.ui-state-highlight
           {
            padding:14px;
            background-color:#ffffcc;
            border:1px dotted #ccc;
            cursor:move;
            margin-top:12px;
           }
        </style>
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
                                    <a href="javascript:void(0);" onClick="window.location.href='<?= ADMINURL."manage-category/"?>'" class="btn btn-clean btn-icon-sm">
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
                                <div class="col-sm-6 col-xs-12">
                                    <ul class="list-unstyled" id="page_list">
                                        <?php
                                        $ctable_r = $db->rpgetData($ctable,"*","isDelete=0","display_order ASC");
                                        if(@mysqli_num_rows($ctable_r)>0){
                                            $count = 0;
                                            while($ctable_d = @mysqli_fetch_array($ctable_r))
                                            {
                                            $count++;
                                            ?>
                                            <li id="<?php echo $ctable_d["id"]?>"><?php echo stripslashes($ctable_d['name']); ?></li>
                                            <?php
                                            }
                                        }
                                        ?>
                                        <input type="hidden" name="page_order_list" id="page_order_list" />
                                    </ul>
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
        <script src="https://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
        <script src="<?php echo SITEURL; ?>common/js/jquery.ui.touch-punch.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $( "#page_list" ).sortable({
                    placeholder : "ui-state-highlight",
                    update  : function(event, ui)
                    {
                        var page_id_array = new Array();
                        $('#page_list li').each(function(){
                            page_id_array.push($(this).attr("id"));
                        });
                        
                        $.ajax({
                            url:"<?php echo ADMINURL?>ajax_change_category_display_order.php",
                            method:"POST",
                            data:{page_id_array:page_id_array},
                            success:function(data)
                            {
                                //alert(data);
                            }
                        });
                    }
                });
            });
        </script>
    </body>
</html>