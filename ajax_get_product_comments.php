<?php
include("connect.php");
$response   = array();
$data       = array();
$response['tot_count'] = "";
$pro_id = $_POST['pro_id'];
$page = $_POST['page'];

$offset     = 5*$page;
$limit      = 5;

$user_id = $_SESSION[SESS_PRE.'_SESS_USER_ID'];
$comment_r = $db->rpgetData("product_review","*","isDelete = 0 AND status='Y' AND pid='".$pro_id."'","id DESC LIMIT ".$limit." OFFSET ".$offset."");
$comment_c = @mysqli_num_rows($comment_r);
if(isset($user_id) && $user_id>0){
   if($comment_c > 0)
    {
      while($comment_d = @mysqli_fetch_array($comment_r))
      {
        $msg        = $comment_d['review_desc'];
        $timestamp  = $comment_d['adate'];
        
        if($user_id == $comment_d['user_id'])
        {
          $full_name = "You";
        }
        else
        {
          $fname = $db->rpgetValue("user","first_name","id='".$comment_d['user_id']."'");
          $lname = $db->rpgetValue("user","last_name","id='".$comment_d['user_id']."'");
    
          $full_name = ucfirst($fname." ".$lname);
        }
    
        $rating = $comment_d['pro_rating'];
    
        $response['nm']     = $full_name;
        $response['dt']     = date("M d, Y",strtotime($timestamp));
        $response['rating'] = $db->getStar($rating);
        //$response['uid']    = ($comment_d['user_id']!="")? $comment_d['user_id'] : "";
        $response['msg']    = ($msg!="")? $msg : "";
    
        if(!empty($response))
        {
          $total_review = $db->rpgetTotalRecord("product_review"," isDelete = 0 AND status='Y' AND pid='".$pro_id."'");
          $response['tot_count'] = $total_review;
          $data[] = $response;
        }
      }
    }
    else
    {
      $data['msg'] = "Something_Wrong";
    } 
}else{
    $data['msg'] ="";
}


header("Content-Type: application/json", true);
echo json_encode($data);
exit; 
?>