<?php
include("connect.php");
$db->rpcheckAdminLogin();

$ctable             = "warranty";
$ctable1            = "warranty";
$parent_page        = "warranty"; //for sidebar active menu
$main_page          = "manage-warranty"; //for sidebar active menu
$delete_page_url    = ADMINURL."add-".str_replace("_", "-", $ctable)."/delete/";
$page_title         = "Manage ".$ctable1;
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
                                    <?php
                                    echo $db->getAddButton($ctable,$ctable1);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <!-- end:: Subheader -->                    
                        <!-- begin:: Content -->
                        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                            
                            <div class="kt-portlet kt-portlet--mobile">
                                <div class="kt-portlet__body">
                                    <!--begin: Search -->
                                    <form class="kt-form kt-form--fit" action="javascript:void(0);" onSubmit="return searchByName();">
                                        <div class="row kt-margin-b-20">
                                            <div class="col-lg-4 kt-margin-b-10-tablet-and-mobile">
                                                <input type="text" name="searchName" id="searchName" value="" class="form-control kt-input" placeholder="Search keyword here..." data-col-index="0">
                                            </div>
                                            <div class="col-lg-8 kt-margin-b-10-tablet-and-mobile">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <button type="submit" class="btn btn-primary btn-brand--icon">
                                                            <span>
                                                                <i class="la la-search"></i>
                                                                <span>Search</span>
                                                            </span>
                                                        </button>
                                                        &nbsp;&nbsp;
                                                        <button type="button" class="btn btn-secondary btn-secondary--icon" onClick="clearSearchByName();">
                                                            <span>
                                                                <i class="la la-close"></i>
                                                                <span>Reset</span>
                                                            </span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="kt-separator kt-separator--md kt-separator--dashed"></div>
                                    </form>
                                    <!--end: Search -->
                                    <!--begin: Datatable -->

                                    <div class="loading-div" style="display:none;">
                                        <div class="kt-dialog kt-dialog--shown kt-dialog--default kt-dialog--loader kt-dialog--top-center">Loading ...</div>
                                    </div>
                                    <div id="results"></div>
                                    <!--end: Datatable -->
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
            var searchName="";
            function searchByName(){
                searchName = $("#searchName").val();
                if(searchName!="")
                {
                    displayRecords(10,1);
                }
                return false;
            }
            function clearSearchByName(){
                searchName = $("#searchName").val();
                if(searchName!="")
                {
                   searchName = "";
                    $("#searchName").val("");
                    displayRecords(10,1); 
                }
            }
            $("#searchName").keyup(function(event){
                if(event.keyCode == 13){
                    $("#searchByName").click();
                }
            });
            function loadDataTable(data_url,page=""){
                setTimeout(function(){
                    $("#results" ).load( data_url,{"page":page},function(){
                        $('#kt_table_1').DataTable({
                            "bPaginate": false,
                            "bFilter": false,
                            "bInfo": false,
                            "bAutoWidth": false, 
                            "aoColumnDefs": [
                                { 'bSortable': false, 'aTargets': [ 5 ] }
                              ]
                        });
                        $(".loading-div").fadeOut(500);
                        $("#results").fadeIn();
                    }); //load initial records
                },1500);
            }
            function displayRecords(numRecords) {
                //var type  = $("#type").val();
                var searchName  = $("#searchName").val();
                searchName  = encodeURIComponent(searchName.trim());
                var data_url = "<?php echo ADMINURL?>ajax_get_<?php echo $ctable; ?>.php?show=" + numRecords + "&searchName=" + searchName ;
                $("#results" ).html("");
                $(".loading-div").show();
                loadDataTable(data_url);
                
                //executes code below when user click on pagination links
                $("#results").on( "click", ".paging_simple_numbers a", function (e){
                    e.preventDefault();
                    var numRecords  = $("#numRecords").val();
                    $(".loading-div").show(); //show loading element
                    var page = $(this).attr("data-page"); //get page number from link
                    loadDataTable(data_url,page);
                });
                $("#results").on( "change", "#numRecords", function (e){
                    e.preventDefault();
                    var numRecords  = $("#numRecords").val();
                    $(".loading-div").show(); //show loading element
                    var page = $(this).attr("data-page"); //get page number from link
                    loadDataTable(data_url,page);
                });
            }

            // used when user change row limit
            function changeDisplayRowCount(numRecords) {
                displayRecords(numRecords, 1);
            }

            $(document).ready(function() {
                displayRecords(10,1);
            });

            function del_conf(id)
            {
                swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    type: "warning",
                    showCancelButton: !0,
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonColor: "#e1e1ef",
                    confirmButtonColor: "#0abb87",
                }).then(function(e) {
                    if(e.value)
                    {
                        window.location.href='<?php echo $delete_page_url;?>'+id+'/';
                    }
                })
            }
            
        </script>
    </body>
</html>s