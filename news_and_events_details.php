<?php
include('connect.php'); 
$current_page = "News and Events Details";

$id = $db->clean($_REQUEST['id']);
$ctable_r = $db->rpgetData("events","*","isDelete=0 AND md5(id) = '".$id."'");
$ctable_c = @mysqli_num_rows($ctable_r);
if($ctable_c > 0)
{
    $ctable_d = @mysqli_fetch_array($ctable_r);

    $event_id = $ctable_d['id'];
    $event_date = date("d-M-Y",strtotime($ctable_d['event_date']));
    $event_desc = stripslashes($ctable_d['description']);
    $event_title = stripslashes($ctable_d['title']);
    $event_author = ($ctable_d['added_by']) ? "<span>BY : ".ucwords($ctable_d['added_by'])."</span>" : 0;
    $image_path = stripslashes($ctable_d['image_path']);

    if(!empty($image_path) && file_exists(EVENT.$image_path))
    {
        $img_preview_url = SITEURL.EVENT.$image_path;
    }
    else
    {
        $img_preview_url = SITEURL."common/images/no_image.png";
    }

    $meta_title        = stripslashes($ctable_d['meta_title']);
    $meta_description  = stripslashes($ctable_d['meta_description']);
    $meta_keywords     = stripslashes($ctable_d['meta_keywords']);
}
else
{
    $db->rplocation(SITEURL);
}

if(isset($_POST['event_comment']))
{
    $user_id        = $_SESSION[SESS_PRE.'_SESS_USER_ID'];
    $event_desc    = $db->clean($_POST['event_desc']);

    $dup_where = "user_id = '".$user_id."' and event_id='".$event_id."'";
    $r = $db->rpdupCheck("events_comment",$dup_where);
    if($r)
    {
        $_SESSION['MSG'] = "Duplicate_Comment";
        $db->rplocation($_SERVER['HTTP_REFERER']);
        die();
    }
    else
    {
        $rows   = array(
                "user_id",
                "event_id",
                "event_desc",
                "status",
            );
        $values = array(
                $user_id,
                $event_id,
                $event_desc,
                "Y",
            );
        $last_id =  $db->rpinsert("events_comment",$values,$rows);

        $_SESSION['MSG'] = "Added_Comment";
        $db->rplocation($_SERVER['HTTP_REFERER']);
        die();
    }
}

$total_comments = $db->rpgetTotalRecord("events_comment","event_id='".$event_id."'AND isDelete=0 AND status='Y'");
$dis_total_comments = ($total_comments > 1) ? "<span>".$total_comments." COMMENTS</span>" : "<span>".$total_comments." COMMENT</span>";
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <title><?=$current_page;?> | <?php echo SITETITLE; ?></title>
    <?php 
    if($meta_title!="")
    {
    ?>
    <meta name="title" content="<?=$meta_title;?>">
    <?php
    }

    if($meta_description!="")
    {
    ?>
    <meta name="description" content="<?=$meta_description;?>">
    <?php
    }

    if($meta_keywords!="")
    {
    ?>
    <meta name="keywords" content="<?=$meta_keywords;?>">
    <?php
    }
    ?>
    <?php include('include_css.php'); ?>
    <meta name="robots" content="follow, index, max-snippet:-1, max-image-preview:large"/>
</head>

<body>
    <!-- Header Area Start -->
    <?php include('include_header.php'); ?>
    <!-- Header Area End -->

    <!-- Breadcrumb Area Start -->
    <?php include('include_breadcrumb_area.php'); ?>
    <!-- Breadcrumb Area End -->
    
    <!-- news and events section -->
    <div class="blog-details-area ptb-80">
            <div class="container">
                <div class="row">
                    <div class="col-xl-9 col-lg-8">
                        <div class="blog-image">
                            <img src="<?= $img_preview_url;?>" alt="<?=$event_title;?>">
                        </div>
                        <h1><?=$event_title;?></h1>
                        <div class="post-information">
                            <?=$event_author;?>
                            <?=$dis_total_comments;?>
                        </div>
                        <div class="blog-details-text">
                            <?=$event_desc;?>
                        </div>
                        <div class="comment-reply-area">
                            <h4 class="details-title">Comments</h4>
                            <div class="comments-wrapper">
                                <div id="comment_history"></div>
                
                                <div class="col-12 text-center" id="comment_button" style="display: none;"> 
                                    <button type="button" id="load_more" data-val="0" class="btn btn-warning">View more</button>
                                </div>
                            </div>
                        </div>
                        <?php 
                        if(isset($_SESSION[SESS_PRE.'_SESS_USER_ID']) && $_SESSION[SESS_PRE.'_SESS_USER_ID'] > 0)
                        { 
                        ?>
                        <div class="new-comment-post">
                            <h4 class="details-title">Leave a Comment</h4>
                            <form action="." method="post" name="commentForm" id="commentForm">
                                <div class="comment-form">
                                    <textarea name="event_desc" id="event_desc" style="min-height: 100px;margin-bottom: 5px;" placeholder="Enter your message here..."></textarea>
                                </div>
                                <button class="default-btn" type="submit" name="event_comment" id="event_comment">Submit</button>
                            </form>
                        </div>
                        <?php 
                        }
                        else
                        {
                        ?>
                        <div class="new-comment-post">
                            <h4><a href="<?= SITEURL?>login/">Login</a> To View Comments.</h4>
                        </div>
                        <?php    
                        }
                        ?>
                    </div>

                    <div class="col-xl-3 col-lg-4">
                        <div class="single-widget">
                            <div class="search-box">
                                <input type="text" name="search" id="search" placeholder="Search......">
                                <button type="submit" value="Search" onclick="get_search_events();"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <?php 
                        $event_cate_r = $db->rpgetData("events_category","*","isDelete=0");
                        $event_cate_c = @mysqli_num_rows($event_cate_r);
                        if($event_cate_c > 0)
                        {
                        ?>
                        <div class="single-widget">
                            <h4 class="details-title">CATEGORY</h4>
                            <ul>
                                <?php 
                                while($event_cate_d = @mysqli_fetch_array($event_cate_r))
                                {

                                $event_cate_id = ucwords($event_cate_d['id']);
                                $event_cate_nm = ucwords($event_cate_d['cat_name']);
                                $event_cate_slug = stripslashes($event_cate_d['cat_slug']);

                                $details_url = SITEURL.'news-and-events/category/'.$event_cate_slug.'/';

                                $total_cate_events = $db->rpgetTotalRecord("events","event_cat='".$event_cate_id."'AND isDelete=0");
                                ?>
                                <li>
                                    <a href="<?=$details_url;?>"><i class="fa fa-caret-right"></i><?=$event_cate_nm;?> <span><?=$total_cate_events;?></span></a>
                                </li>
                                <?php 
                                }
                                ?>
                            </ul>
                        </div>
                        <?php 
                        }

                        $latest_post_r = $db->rpgetData("events","*","isDelete=0 AND id!='".$event_id."' limit 4");
                        $latest_post_c = @mysqli_num_rows($latest_post_r);
                        if($latest_post_c > 0)
                        {
                        ?>
                        <div class="single-widget">
                            <h4 class="details-title">LATEST POST</h4>
                            <?php 
                            while($latest_post_d = @mysqli_fetch_array($latest_post_r))
                            {
                                $latest_post_event_id = $latest_post_d['id'];
                                $image_path = stripslashes($latest_post_d['image_path']);
                                if(!empty($image_path) && file_exists(EVENT_THUMB_F.$image_path))
                                {
                                    $img_preview_url = SITEURL.EVENT_THUMB_F.$image_path;
                                }
                                else
                                {
                                    $img_preview_url = SITEURL."common/images/no_image.png";
                                }
                                $latest_post_title = $db->rplimitChar(Strip_tags($latest_post_d['title']),50);
                                $latest_post_date = date("d M Y",strtotime($latest_post_d['event_date']));

                                $details_url = SITEURL.'news-and-events/details/'.md5($latest_post_event_id).'/';
                                ?>
                                <div class="recent-item">
                                    <a href="<?=$details_url;?>"><img src="<?=$img_preview_url;?>"></a>
                                    <div class="recent-text">
                                        <h5><a href="<?=$details_url;?>"><?=$latest_post_title;?></a></h5>
                                        <div class="recent-info">
                                            <?=$latest_post_date;?>
                                        </div>
                                    </div>
                                </div>
                                <?php 
                            }
                            ?>
                        </div>
                        <?php 
                        }
                        ?>
                    </div>
                </div>
            </div>
    </div>

    <!-- Footer Area Start -->
    <?php include('include_footer.php'); ?>
    <!-- Footer Area End -->

    <!-- all js here -->
    <?php include('include_js.php'); ?>
    <script type="text/javascript">
        $(function(){
            $("#commentForm").validate({
                ignore : [],
                rules: {
                   event_desc:{required : true}
                },
                messages: {
                   event_desc:{required:"Message is required."}
                }, 
                 errorPlacement: function (error, element) 
                 {
                    if (element.attr('name') == 'field_name_here')
                    {
                       error.insertAfter(".dis_error_pro_rating");
                    }
                    else 
                    {
                       error.insertAfter(element);
                    }
                 }
            }); 
        });

        $(document).ready(function(){
            <?php 
            if(isset($_SESSION[SESS_PRE.'_SESS_USER_ID']) && $_SESSION[SESS_PRE.'_SESS_USER_ID'] > 0)
            { 
            ?>
            view_comment(0);
            <?php 
            }
            ?>
            $("#load_more").on("click",function(e){
                e.preventDefault();
                var page = $(this).attr('data-val');
                view_comment(page);
            });
        });

        function view_comment(page)
        {
            $.ajax({
                type: "POST",
                cache: false,
                url: "<?php echo SITEURL; ?>ajax_get_events_comments.php",
                data: "event_id=<?php echo $event_id;?>&page="+page,
                dataType: 'json',
                success: function(result) 
                {
                    //return false;
                    if(result['msg']=="Something_Wrong")
                    {
                        $("#comment_button").hide();
                    }
                    else if(result!='null' && result!='')
                    {
                        var dis_html= "";
                        var total_count     = result[0]['tot_count'];
                        for (i = 0; i < result.length; ++i) 
                        {
                            var nm          = result[i].nm;
                            var dt          = result[i].dt;
                            var msg         = result[i].msg;
                            var dis_img     = "<?php echo SITEURL.'common/images/no_user.png'?>";

                            dis_html+= '<div class="single-comments"><div class="comment-img"><img width="50" src="'+dis_img+'"></div><div class="comment-text"><div class="comment-information infor"><a href="javascript:void(0)" class="text-uppercase">'+nm+'</a><span><a href="javascript:void(0);">'+dt+'</a></span></div><p>'+msg+'</p></div></div>';
                        }

                        $('#comment_history').append(dis_html);
                        $("#comment_button").show();
                        var new_count = parseInt($('#load_more').attr('data-val')) + parseInt(1);
                        $('#load_more').attr('data-val',new_count);

                        var displayed_record = parseInt(new_count) * 5;

                        if(total_count <= displayed_record)
                        {
                            $('#load_more').hide();
                        }
                    }
                    else
                    {
                        dis_html = '';
                    }
         
                    
                }
            });
        }
    </script>
</body>

</html>