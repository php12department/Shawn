<?php
include('connect.php'); 
require_once 'common/css/pagination_style.php';

$current_page = "News and Events";

$cate_slug = "";
if(isset($_REQUEST['cate_slug']))
{
  $cate_slug = $_REQUEST['cate_slug']; 
  $meta_title = $db->rpgetValue("events_category","meta_title","cat_slug = '".$cate_slug."' AND isDelete=0");
  $meta_description = $db->rpgetValue("events_category","meta_description","cat_slug = '".$cate_slug."' AND isDelete=0");
  $meta_keywords = $db->rpgetValue("events_category","meta_keywords","cat_slug = '".$cate_slug."' AND isDelete=0");
}

$search_keyword = "";
if(isset($_REQUEST['search_keyword']))
{
  $dis_search_keyword = str_replace("+", " ", $_REQUEST['search_keyword']); 
  $search_keyword = base64_encode($_REQUEST['search_keyword']); 
}
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <?php 
    if($meta_title!="")
    {
    ?>
    <title><?=$meta_title;?> | <?php echo SITETITLE; ?></title>
    <meta name="title" content="<?=$meta_title;?> | <?php echo SITETITLE; ?>">
    <?php
    }
    else
    {
    ?>
    <title><?=$current_page;?> | <?php echo SITETITLE; ?></title>
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
    <!-- meta tags site details -->
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="website" />
    <?php 
    if($meta_title!="")
    {
    ?>
    <meta property="og:title" content="<?=$meta_title;?> | <?php echo SITETITLE; ?>" />
    <?php
    }
    else
    {
    ?>
    <meta property="og:title" content="<?=$meta_title;?>" />
    <?php
    }
    ?>
    <meta property="og:description" content="<?=$meta_description;?>" />
    <meta property="og:url" content="<?=$actual_link;?>" />
    <meta property="og:site_name" content="<?php echo SITETITLE; ?>" />
    <meta property="og:image" content="<?=SITEURL?>common/images/logo.png" />
    <meta property="og:image:secure_url" content="<?= SITEURL?>common/images/logo.png" />
    <meta property="og:image:width" content="1282" />
    <meta property="og:image:height" content="676" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:description" content="<?=$meta_description;?>" />
    <?php 
    if($meta_title!="")
    {
    ?>
    <meta name="twitter:title" content="<?=$meta_title;?> | <?php echo SITETITLE; ?>" />
    <?php
    }
    else
    {
    ?>
    <meta name="twitter:title" content="<?=$meta_title;?>" />
    <?php
    }
    ?>
    <meta name="twitter:image" content="<?= SITEURL?>common/images/logo.png" />
    <!-- end meta tags site details -->
</head>

<body>
    <!-- Header Area Start -->
    <?php include('include_header.php'); ?>
    <!-- Header Area End -->

    <!-- Breadcrumb Area Start -->
    <?php include('include_breadcrumb_area.php'); ?>
    <!-- Breadcrumb Area End -->
    
    <div class="front-loading-div" style="display:none;">
        <div><img style="width:10%" src="<?php echo SITEURL."common/images/loader.svg"?>" alt="<?php echo SITETITLE; ?>" /></div>
    </div>

    <!-- news and events section -->
    <div class="blog-section pt-80 pb-35 events-section">
        <div class="container">
            <div class="row">
                <!-- left row -->
                
                <div class="col-xl-9 col-lg-8">
                    <?php
                    if($search_keyword!="")
                    {
                    ?>
                    <div class="row mb-3">
                        <div class="col-lg-12 col-md-12">
                            <label>&nbsp;Search By : &nbsp;<button type="button"><?=$dis_search_keyword;?><a href="<?=SITEURL."news-and-events/";?>">&nbsp;&nbsp;X</a></button></label>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                    <div class="row" id="results">
                    </div>
                </div> 
                <!-- right row -->
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
                            <h4 class="details-title events-sidebar-title">CATEGORY</h4>
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
        $(document).ready(function() { 
            $("#results" ).load("<?php echo SITEURL; ?>ajax_get_news_and_event.php?cate_slug=<?=$cate_slug;?>&search_keyword=<?=$search_keyword;?>"); 

            $("#results").on( "click", ".pagination_my a", function (e){
              e.preventDefault();
              $(".front-loading-div").show(); 
              var page = $(this).attr("data-page"); 
              $("#results").load("<?php echo SITEURL; ?>ajax_get_news_and_event.php?cate_slug=<?=$cate_slug;?>&search_keyword=<?=$search_keyword;?>",{"page":page}, function(){ 
                $(".front-loading-div").hide(); 
              });
            });
        });
    </script>
</body>
</html>