<!-- begin::Scrolltop -->
<div id="kt_scrolltop" class="kt-scrolltop">
    <i class="fa fa-arrow-up"></i>
</div>
<!-- end::Scrolltop -->
<!-- begin::Global Config(global config for global JS sciprts) -->
<script>
    var ADMINURL = '<?php echo ADMINURL ?>';
    
    var KTAppOptions = {"colors":{"state":{"brand":"#5d78ff","dark":"#282a3c","light":"#ffffff","primary":"#5867dd","success":"#34bfa3","info":"#36a3f7","warning":"#ffb822","danger":"#fd3995"},"base":{"label":["#c5cbe3","#a1a8c3","#3d4465","#3e4466"],"shape":["#f0f3ff","#d9dffa","#afb4d4","#646c9a"]}}};
</script>
<!-- end::Global Config -->
<!--begin::Global Theme Bundle(used by all pages) -->
<script src="<?php echo ADMINURL; ?>assets/vendors/global/vendors.bundle.js" type="text/javascript"></script>
<script src="<?php echo ADMINURL; ?>assets/js/demo1/scripts.bundle.js" type="text/javascript"></script>
<!--end::Global Theme Bundle -->
<!--begin::Page Vendors(used by this page) -->
<script src="<?php echo ADMINURL; ?>assets/vendors/custom/fullcalendar/fullcalendar.bundle.js" type="text/javascript"></script>
<!--end::Page Vendors -->
<!--begin::Page Scripts(used by this page) -->
<script src="<?php echo ADMINURL; ?>assets/js/demo1/pages/dashboard.js" type="text/javascript"></script>
<!--end::Page Scripts -->

<!--begin::Page Vendors(used by this page) -->
<script src="<?php echo ADMINURL; ?>assets/vendors/custom/datatables/datatables.bundle.js" type="text/javascript"></script>
<script src="<?php echo ADMINURL; ?>assets/js/demo1/pages/datatables/basic/paginations.js" type="text/javascript"></script>

<script src="<?php echo ADMINURL; ?>assets/js/demo1/pages/components/extended/blockui.js" type="text/javascript"></script>
<script src="<?php echo ADMINURL; ?>assets/js/demo1/pages/components/extended/bootstrap-notify.js" type="text/javascript"></script>
<script src="<?php echo ADMINURL; ?>assets/js/demo1/pages/components/extended/sweetalert2.js" type="text/javascript"></script>
<script src="<?php echo ADMINURL; ?>assets/js/demo1/pages/widgets/bootstrap-datepicker.js" type="text/javascript"></script>
<script src="<?php echo ADMINURL; ?>assets/js/demo1/pages/widgets/bootstrap-datetimepicker.js" type="text/javascript"></script>
<script src="<?php echo ADMINURL?>assets/crop/js/commonfile_html5imageupload.js?v1.3.4"></script>


<!--end::Page Scripts -->
<!-- <script src="<?php echo ADMINURL?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo ADMINURL?>assets/plugins/datatables/dataTables.bootstrap.js"></script> -->

<script src="<?php echo SITEURL; ?>common/js/jquery.validate.js"></script>
<!-- <script src="<?php echo SITEURL; ?>common/js/bootstrap-notify.js"></script> -->
<script>
    $(document).on('change','.changeStatus',function(){

        var mode = $(this).prop('checked');
        console.log(mode);
        //var status = $(this).attr("data-status");             
        var status = mode == true ? 'Y' : 'N';
        var id = $(this).attr("data-id");             
        var field = $(this).attr("data-i");             
        var table = $(this).attr("data-td");         
        $.ajax({
            url: ADMINURL+'ajax_changeStatus.php',
            dataType: "JSON",
            method:"POST",
            data: {
                "id": id,
                "status": status,
                "td": table,
                "i": field,
            },
            success: function (response)
            { 
                swal.fire("Status successfully changed");
                //$('#posts').DataTable().ajax.reload();
            }
        });
    });
    
    $(document).on('change','.isApproved',function(){

        var mode = $(this).prop('checked');
        console.log(mode);
        //var status = $(this).attr("data-status");             
        var status = mode == true ? 'Y' : 'N';
        var id = $(this).attr("data-id");             
        var field = $(this).attr("data-i");             
        var table = $(this).attr("data-td");         
        $.ajax({
            url: ADMINURL+'ajax_approved.php',
            dataType: "JSON",
            method:"POST",
            data: {
                "id": id,
                "status": status,
                "td": table,
                "i": field,
            },
            success: function (response)
            { 
                swal.fire("Status successfully changed");
                //$('#posts').DataTable().ajax.reload();
            }
        });
    });
    jQuery(document).ready(function(){
        $('.summernote').summernote({
            toolbar: [
                ['style', ['style']],
                  ['font', ['bold', 'underline', 'clear']],
                  ['fontsize', ['fontsize']],
                  ['fontname', ['fontname']],
                  ['color', ['color']],
                  ['para', ['ul', 'ol', 'paragraph']],
                  ['table', ['table']],
                  ['insert', ['link', 'picture', 'video']],
                  ['view', ['fullscreen', 'codeview', 'help']],
              ],
            height: 240,                 // set editor height
            minHeight: 240,             // set minimum height of editor
            maxHeight: null,             // set maximum height of editor
            focus: false                 // set focus to editable area after initializing summernote
        });
      });

	function dis_blockui()
    {
        KTApp.blockPage({
            overlayColor: "#000000",
            type: "v2",
            state: "primary",
            message: "Processing..."
        }), setTimeout(function() {
            KTApp.unblockPage()
        }, 2e3)
    }
    
	$(document).ready(function(){
		setTimeout(function(){
		<?php if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Something_Wrong') { ?>
		 	$.notify({message: 'Something Went Wrong, Please Try Again !' },{type: 'danger'});
		<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Inserted') { ?>
		 	$.notify({message: 'Record Added successfully.' },{type: 'success'});
		<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Updated') { ?>
		 	$.notify({message: 'Record Updated successfully.' },{type: 'success'});
		<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Deleted') { ?>
			$.notify({message: 'Record Deleted successfully.'},{type: 'success'});
		<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Duplicate') { ?>
			$.notify({message: 'This Record is Already Exist. Please Try Another.'},{type: 'danger'});
		<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'INVALID_DATA') { ?>
             $.notify({message: 'Invalid Data. Please enter valid data.' },{type: 'danger'});
        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'UPDATE_AC') { ?>
            $.notify({message: 'Your Account Info has been updated successfully' },{type: 'success'});
        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Site_Setting_Updated') { ?>
            $.notify({message: 'Site setting has been updated successfully' },{type: 'success'});
        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'PASS_NOT_MATCH') { ?>
            $.notify({message: 'Old Password does not matched.' },{type: 'danger'});
        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'PASS_CHANGED') { ?>
            $.notify({message: 'New Password has been updated successfully.' },{type: 'success'});
        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Duplicate_Entry') { ?>
            $.notify({message: 'This email address is already registered with us. Please try another.' },{type: 'success'});
        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Invalid_Email_Password') { ?>
             $.notify({message: 'Invalid email and password.' },{type: 'success'});
        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Success_Fsent') { ?>
            $.notify({message: 'Your forgot password reset link is successfully sent to your register email address.'},{type: 'success'});
        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Update_Pass') { ?>
            $.notify({message: 'Your password has been updated successfully.'},{type: 'success'});
        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'No_Data_Found') { ?>
            $.notify({message: 'Your email address is not registered with us.'},{ type: 'danger'});
        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Link_Expired') { ?>
            $.notify({message: 'Your link to reset the password is expired.'},{type: 'danger'});
        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'NEED_TO_LOGIN') { ?>
            $.notify({message: 'Please login to your account.'},{type: 'danger'});
        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'FILE_TYPE_ERR') { ?>
            var file_type_err = '<?php echo $_SESSION['FILE_TYPE_ERR_MSG']?>'; 
            $.notify({message: file_type_err},{type: 'danger'});
        <?php unset($_SESSION['MSG']); unset($_SESSION['FILE_TYPE_ERR_MSG']); }
        ?> 
		},1000);
	});
</script>