<?php
include("connect.php");
include('include/resize_image.php');
include("include/notification.class.php");
$image = new SimpleImage(); 

$ctable      = "submission";

$comments    = $db->clean($_POST['comments']);
$order_number    = $db->clean($_POST['order_number']);
$adate       = date('Y-m-d h:i:s');
$user_id     = $_SESSION[SESS_PRE.'_SESS_USER_ID'];
// $file_name   = "";

$IMAGEPATH_T = SUBMISSION_T;
$IMAGEPATH_A = SUBMISSION_A;
$IMAGEPATH   = SUBMISSION;

if(isset($_FILES['file_name']) && !empty($_FILES['file_name']['name']))   
{
    $img_filename   = $_FILES["file_name"]["name"];
    $filetype       = $_FILES["file_name"]["type"];
    $filesize       = $_FILES["file_name"]["size"];
    
    $img_filename   = str_replace(' ', '_', $img_filename);
    $file_name      = time()."-img-".$img_filename;
    move_uploaded_file($_FILES["file_name"]["tmp_name"],$IMAGEPATH.$file_name);

    ////// - Product Thumb Starts - //////
    $image->load($IMAGEPATH_A.$file_name);
    $image->resize(1349,360);
    $image->save($IMAGEPATH_A.$file_name);
    ////// - Product Thumb Ends - //////
}

if($comments!="" && $file_name !="")
{
    $rows   = array(
        "order_number",
        "comments",
        "user_id",
        "image",
        "status",
        "adate",
    );
    $values = array(
        $order_number,
        $comments,
        $user_id,
        $file_name,
        "N",
        $adate,
    );

    $db->rpinsert($ctable,$values,$rows);
    
    if(ISMAIL)
	{
		$nt = new Notification();

		$mail_subject = SITETITLE." received new gallery request";
		include("mailbody/admin_new_gallery_request_mail.php");
		
		$nt->rpsendEmail(SITEMAIL,$mail_subject,$admin_body);
	}
    
    $_SESSION['MSG'] = 'Uploaded_success';
    $db->rplocation(SITEURL."thankyou/");
    exit();
}
else
{
    $_SESSION['MSG'] = 'Something_Wrong';
    $db->rplocation(SITEURL."addsubmission/");
}
?>