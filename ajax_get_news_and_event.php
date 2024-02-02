<?php
include("connect.php");

$data = $_REQUEST;
if(isset($_POST["page"]))
{
  $page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
  if(!is_numeric($page_number))
  {
    die('Invalid page number!');
  } //incase of invalid page number
}
else
{
  $page_number = 1; //if there's no page number, set it to 1
}

if(isset($_REQUEST['cate_slug']) && $_REQUEST['cate_slug']!="")
{
  $cate_id = $db->rpgetValue("events_category","id","cat_slug = '".$_REQUEST['cate_slug']."' AND isDelete=0");
  $ctable_where.= "event_cat = '".$cate_id."' AND ";
}

if(isset($_REQUEST['search_keyword']) && $_REQUEST['search_keyword']!="")
{
  $_REQUEST['search_keyword'] = base64_decode($_REQUEST['search_keyword']);
  $ctable_where .= " (
                        added_by like '%".$_REQUEST['search_keyword']."%' OR
                        title like '%".$_REQUEST['search_keyword']."%' OR
                        description like '%".$_REQUEST['search_keyword']."%' OR
                        image_path like '%".$_REQUEST['search_keyword']."%' OR
                        event_date like '%".$_REQUEST['search_keyword']."%' OR 
                        event_cat like (select id from events_category where cat_name like '%".$_REQUEST['search_keyword']."%') 
            ) AND ";
}

$ctable_where.= "isDelete=0";
$get_total_rows = $db->rpgetTotalRecord("events",$ctable_where);
$item_per_page = '10';
$total_pages = ceil($get_total_rows/$item_per_page);
$page_position = (($page_number-1) * $item_per_page);

$orderBy = "";
$orderBy = " id DESC limit $page_position, $item_per_page";

$ctable_r = $db->rpgetData("events","*",$ctable_where,$orderBy);

if(@mysqli_num_rows($ctable_r) >0)
{
    $sr = 1;
    while($ctable_d = @mysqli_fetch_array($ctable_r))
    { 
      $date_day = date("d",strtotime($ctable_d['event_date']));
      $date_month = date("M",strtotime($ctable_d['event_date']));
      $event_desc = $db->rplimitChar(Strip_tags($ctable_d['description']),200);
      $event_title = stripslashes($ctable_d['title']);
      $event_id = $ctable_d['id'];
      $image_path = stripslashes($ctable_d['image_path']);

      if(!empty($image_path) && file_exists(EVENT_THUMB_F.$image_path))
      {
          $img_preview_url = SITEURL.EVENT_THUMB_F.$image_path;
      }
      else
      {
          $img_preview_url = SITEURL."common/images/no_image.png";
      }

      $details_url = SITEURL.'news-and-events/details/'.md5($event_id).'/';
    ?> 
      <div class="col-lg-6 col-md-6">
        <div class="single-blog">
            <div class="blog-image">
                <a href="<?= $details_url;?>">
                    <img src="<?= $img_preview_url;?>" alt="">
                    <span class="tag-date"><?=$date_day;?> <span><?=$date_month;?></span></span>
                </a>
            </div>
            <div class="blog-text">
                <h5><a href="<?= $details_url;?>"><?=$event_title;?></a></h5>
                <p><?=$event_desc;?></p>
                <a href="<?= $details_url;?>">Read More</a>
            </div>
        </div>
      </div>
    <?php
    }
}
else
{
?>
<div class="col-lg-12 col-md-12"><center>No record found.</center></div>
<?php 
}

echo $db->paginate_function($item_per_page, $page_number, $get_total_rows, $total_pages); 
?>