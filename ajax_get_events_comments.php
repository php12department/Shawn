<?php
include("connect.php");
$response   = array();
$data       = array();

$event_id = $_POST['event_id'];
$page = $_POST['page'];

$offset     = 5*$page;
$limit      = 5;

$user_id = $_SESSION[SESS_PRE.'_SESS_USER_ID'];
$comment_r = $db->rpgetData("events_comment","*","isDelete = 0 AND status='Y' AND event_id='".$event_id."'","id DESC LIMIT ".$limit." OFFSET ".$offset."");
$comment_c = @mysqli_num_rows($comment_r);
if($comment_c > 0)
{
  while($comment_d = @mysqli_fetch_array($comment_r))
  {
    $msg        = $comment_d['event_desc'];
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
    //$response['uid']    = ($comment_d['user_id']!="")? $comment_d['user_id'] : "";
    $response['msg']    = ($msg!="")? $msg : "";

    if(!empty($response))
    {
      $total_review = $db->rpgetTotalRecord("events_comment"," isDelete = 0 AND status='Y' AND event_id='".$event_id."'");
      $response['tot_count'] = $total_review;
      $data[] = $response;
    }
  }
}
else
{
  $data['msg'] = "Something_Wrong";
}

header("Content-Type: application/json", true);
echo json_encode($data);
exit; 
?>