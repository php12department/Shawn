<?php
include('connect.php'); 

header("Content-Type: application/xml; charset=utf-8");
echo '<?xml version="1.0" encoding="UTF-8"?>';

echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
  xmlns:xhtml="http://www.w3.org/1999/xhtml"
  xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';

echo '<url>';
echo '<loc>'.SITEURL.'</loc>';
echo '<priority>'.'1.0000'.'</priority>';
echo '</url>';

echo '<url>';
echo '<loc>'.SITEURL.'about-us/'.'</loc>';
echo '<priority>'.'0.9000'.'</priority>';
echo '</url>';

echo '<url>';
echo '<loc>'.SITEURL.'contact-us/'.'</loc>';
echo '<priority>'.'0.9000'.'</priority>';
echo '</url>';

echo '<url>';
echo '<loc>'.SITEURL.'careers/'.'</loc>';
echo '<priority>'.'0.9000'.'</priority>';
echo '</url>';

echo '<url>';
echo '<loc>'.SITEURL.'news-and-events/'.'</loc>';
echo '<priority>'.'0.9000'.'</priority>';
echo '</url>';

echo '<url>';
echo '<loc>'.SITEURL.'custom-orders/'.'</loc>';
echo '<priority>'.'0.9000'.'</priority>';
echo '</url>';

echo '<url>';
echo '<loc>'.SITEURL.'shipping-information/'.'</loc>';
echo '<priority>'.'0.9000'.'</priority>';
echo '</url>';

echo '<url>';
echo '<loc>'.SITEURL.'financing/'.'</loc>';
echo '<priority>'.'0.9000'.'</priority>';
echo '</url>';

echo '<url>';
echo '<loc>'.SITEURL.'accidental-damage-protection/'.'</loc>';
echo '<priority>'.'0.9000'.'</priority>';
echo '</url>';

echo '<url>';
echo '<loc>'.SITEURL.'customer-gallary/'.'</loc>';
echo '<priority>'.'0.9000'.'</priority>';
echo '</url>';

echo '<url>';
echo '<loc>'.SITEURL.'returns-and-exchanges/'.'</loc>';
echo '<priority>'.'0.9000'.'</priority>';
echo '</url>';

echo '<url>';
echo '<loc>'.SITEURL.'privacy-policy/'.'</loc>';
echo '<priority>'.'0.9000'.'</priority>';
echo '</url>';

echo '<url>';
echo '<loc>'.SITEURL.'furniture-care/'.'</loc>';
echo '<priority>'.'0.9000'.'</priority>';
echo '</url>';

echo '<url>';
echo '<loc>'.SITEURL.'products/massage-chairs/'.'</loc>';
echo '<priority>'.'0.9000'.'</priority>';
echo '</url>';

echo '<url>';
echo '<loc>'.SITEURL.'products/sale/'.'</loc>';
echo '<priority>'.'0.9000'.'</priority>';
echo '</url>';

echo '<url>';
echo '<loc>'.SITEURL.'store-locations/'.'</loc>';
echo '<priority>'.'0.9000'.'</priority>';
echo '</url>';

echo '<url>';
echo '<loc>'.SITEURL.'store-details/'.'</loc>';
echo '<priority>'.'0.9000'.'</priority>';
echo '</url>';

$home_featured_brand_r = $db->rpgetData("featured_brand","*","isDelete=0");
$home_featured_brand_c = @mysqli_num_rows($home_featured_brand_r);
if($home_featured_brand_c > 0)
{
    while($home_featured_brand_d = @mysqli_fetch_array($home_featured_brand_r))
    {
        $brand_name  = ucwords($home_featured_brand_d['slug']);
        $brand_pro_url = SITEURL."brand-product/".$home_featured_brand_d['slug'];
        //$brand_update_at  = $home_featured_brand_d['update_at'];

        if($home_featured_brand_d['update_at'] !="")
        {
            $brand_update_at = $db->rpDate($home_featured_brand_d['update_at'],"Y-m-d\TH:i:s\-06:00");
        }
        else
        {
            $brand_update_at = $db->rpDate($home_featured_brand_d['adate'], "Y-m-d\TH:i:s\-06:00");
        }

        echo '<url>';
        echo '<loc>'.$brand_pro_url.'/'.'</loc>';
        echo '<lastmod>'.$brand_update_at.'</lastmod>';
        echo '<changefreq>'.'daily'.'</changefreq>';
        echo '<priority>'.'0.8000'.'</priority>';
        echo '</url>';
    }
}

$catable_r   = $db->rpgetData("category","*","isDelete=0");
if(@mysqli_num_rows($catable_r)>0)
{
    while($catable_d = @mysqli_fetch_array($catable_r))
    {
        $cate_slug = $catable_d['slug'];
        $cate_adate = $catable_d['adate'];
        $cate_update_at = $catable_d['update_at'];
        /*$cate_slug = $db->rpgetValue("category","slug","id='".$catable_d['cate_id']."'");*/
        /*$cate_adate = $db->rpgetValue("category","adate","id='".$catable_d['cate_id']."'");*/
        /*$cate_update_at = $db->rpgetValue("category","update_at","id='".$catable_d['cate_id']."'");*/

        if($cate_update_at >0)
        {
            $cate_date = $db->rpDate($cate_update_at,"Y-m-d\TH:i:s\-06:00");
        }
        else
        {
            $cate_date = $db->rpDate($cate_adate,"Y-m-d\TH:i:s\-06:00");
        }

        $dis_cat_url = SITEURL."product-category";
        if($catable_d['id']!=0 && $catable_d['id']!="")
        {
            $dis_cat_url.= "/".$cate_slug;
            /*echo "<pre>";print_r($dis_cat_url);exit;*/
            echo '<url>';
            echo '<loc>'.$dis_cat_url.'/'.'</loc>';
            echo '<lastmod>'.$cate_date.'</lastmod>';
            echo '<changefreq>'.'daily'.'</changefreq>';
            echo '<priority>'.'0.8000'.'</priority>';
            echo '</url>';
        }

    }
}

$sub_catable_r   = $db->rpgetData("sub_category","*","isDelete=0");
if(@mysqli_num_rows($sub_catable_r)>0)
{
    while($sub_catable_d = @mysqli_fetch_array($sub_catable_r))
    {
        $sub_cate_slug = $sub_catable_d['slug'];
        $sub_cate_adate = $sub_catable_d['adate'];
        $sub_cate_update_at = $sub_catable_d['update_at'];
        $cate_slug = $db->rpgetValue("category","slug","id='".$sub_catable_d['cate_id']."'");

        if($sub_cate_update_at >0)
        {
            $cate_date = $db->rpDate($sub_cate_update_at,"Y-m-d\TH:i:s\-06:00");
        }
        else
        {
            $cate_date = $db->rpDate($sub_cate_adate,"Y-m-d\TH:i:s\-06:00");
        }

        $dis_cat_url = SITEURL."products/".$cate_slug;
        if($sub_catable_d['id']!=0 && $sub_catable_d['id']!="")
        {
            $dis_cat_url.= "/".$sub_cate_slug;
            /*echo "<pre>";print_r($dis_cat_url);exit;*/
            echo '<url>';
            echo '<loc>'.$dis_cat_url.'/'.'</loc>';
            echo '<lastmod>'.$cate_date.'</lastmod>';
            echo '<changefreq>'.'daily'.'</changefreq>';
            echo '<priority>'.'0.7000'.'</priority>';
            echo '</url>';
        }
    }
}

$sub_sub_catable_r   = $db->rpgetData("sub_sub_category","*","isDelete=0");
if(@mysqli_num_rows($sub_sub_catable_r)>0)
{
    while($sub_sub_catable_d = @mysqli_fetch_array($sub_sub_catable_r))
    {
        $sub_sub_cate_slug = stripslashes($sub_sub_catable_d['slug']);
        $sub_sub_cate_adate = $sub_sub_catable_d['adate'];
        $sub_sub_cate_update_at = $sub_sub_catable_d['update_at'];
        $sub_cate_slug = $db->rpgetValue("sub_category","slug","id='".$sub_sub_catable_d['sub_cate_id']."' AND isDelete=0");
        $cate_slug = $db->rpgetValue("category","slug","id='".$sub_sub_catable_d['cate_id']."' AND isDelete=0");

        if($sub_sub_cate_update_at >0)
        {
            $cate_date = $db->rpDate($sub_sub_cate_update_at,"Y-m-d\TH:i:s\-06:00");
        }
        else
        {
            $cate_date = $db->rpDate($sub_sub_cate_adate,"Y-m-d\TH:i:s\-06:00");
        }

        $dis_sub_syb_url = SITEURL."products/".stripslashes($cate_slug)."/".stripslashes($sub_cate_slug)."/".$sub_sub_cate_slug;
        if($sub_sub_catable_d['id']!=0 && $sub_sub_catable_d['id']!="")
        {
            /*$dis_sub_syb_url.= "/".$sub_sub_cate_slug;*/
            /*echo "<pre>";print_r($dis_sub_syb_url);exit;*/
            echo '<url>';
            echo '<loc>'.$dis_sub_syb_url.'/'.'</loc>';
            echo '<lastmod>'.$cate_date.'</lastmod>';
            echo '<changefreq>'.'daily'.'</changefreq>';
            echo '<priority>'.'0.6000'.'</priority>';
            echo '</url>';
        }
    }
}

$ctable_r   = $db->rpgetData("product","*","isDelete=0");
if(@mysqli_num_rows($ctable_r)>0)
{
    while($ctable_d = @mysqli_fetch_array($ctable_r))
    {

        
        $cate_slug = $db->rpgetValue("category","slug","id='".$ctable_d['cate_id']."'  AND isDelete=0");
        $cate_adate = $db->rpgetValue("category","adate","id='".$ctable_d['cate_id']."'  AND isDelete=0");
        $cate_update_at = $db->rpgetValue("category","update_at","id='".$ctable_d['cate_id']."'  AND isDelete=0");
        

        if($cate_update_at >0)
        {
            /*$cate_date = $cate_update_at;*/
            $cate_date = $db->rpDate($cate_update_at,"Y-m-d\TH:i:s\-06:00");
        }
        else
        {
            /*$cate_date = $cate_adate;*/
            $cate_date = $db->rpDate($cate_adate,"Y-m-d\TH:i:s\-06:00");
        }


        $sub_cate_slug = $db->rpgetValue("sub_category","slug","id='".$ctable_d['sub_cate_id']."'  AND isDelete=0");
        $sub_cate_adate = $db->rpgetValue("sub_category","adate","id='".$ctable_d['sub_cate_id']."'  AND isDelete=0");
        $sub_cate_update_at = $db->rpgetValue("sub_category","update_at","id='".$ctable_d['sub_cate_id']."' AND isDelete=0");

        if($sub_cate_update_at >0)
        {
            /*$sub_cate_date = $sub_cate_update_at;*/
            $sub_cate_date = $db->rpDate($sub_cate_update_at,"Y-m-d\TH:i:s\-06:00");
        }
        else
        {
            /*$sub_cate_date = $sub_cate_adate;*/
            $sub_cate_date = $db->rpDate($sub_cate_adate,"Y-m-d\TH:i:s\-06:00");
        }

        $sub_sub_cate_slug = $db->rpgetValue("sub_sub_category","slug","id='".$ctable_d['sub_sub_cate_id']."' AND cate_id='".$ctable_d['cate_id']."' AND sub_cate_id='".$ctable_d['sub_cate_id']."' isDelete=0");
        $sub_sub_cate_adate = $db->rpgetValue("sub_sub_category","adate","id='".$ctable_d['sub_sub_cate_id']."' AND isDelete=0");
        $sub_sub_cate_update_at = $db->rpgetValue("sub_sub_category","update_at","id='".$ctable_d['sub_sub_cate_id']."' AND isDelete=0");

        $sub_sub_cate_r = $db->rpgetData("sub_sub_category","*","cate_id='".$ctable_d['cate_id']."' AND sub_cate_id='".$ctable_d['sub_cate_id']."' AND id='".$ctable_d['sub_sub_cate_id']."' AND isDelete=0");

        $sub_sub_cate_c          = @mysqli_num_rows($sub_sub_cate_r);

        if($sub_sub_cate_c > 0)
        {
            $sub_sub_cate_d         = @mysqli_fetch_array($sub_sub_cate_r);

            $sub_sub_cate_name      = stripslashes($sub_sub_cate_d['name']);
            $sub_sub_cate_id        = $sub_sub_cate_d['id'];

            $dis_url_sub_sub_pro = SITEURL."product/".stripslashes($cate_slug)."/".stripslashes($sub_cate_slug)."/".stripslashes($sub_sub_cate_d['slug'])."/".stripslashes($ctable_d['slug']);
    
            echo '<url>';
            echo '<loc>'.$dis_url_sub_sub_pro.'/'.'</loc>';
            echo '<lastmod>'.$pro_date.'</lastmod>';
            echo '<changefreq>'.'daily'.'</changefreq>';
            echo '<priority>'.'0.6000'.'</priority>';
            echo '</url>';
        }

        /*echo "<pre>";
        print_r($sub_sub_cate_slug);die;*/
        if($sub_sub_cate_update_at >0)
        {
            /*$sub_sub_cate_date = $sub_sub_cate_update_at;*/
            $sub_sub_cate_date = $db->rpDate($sub_sub_cate_update_at,"Y-m-d\TH:i:s\-06:00");
        }
        else
        {
            /*$sub_sub_cate_date = $sub_sub_cate_adate;*/
            $sub_sub_cate_date = $db->rpDate($sub_sub_cate_adate,"Y-m-d\TH:i:s\-06:00");
        }

        $dis_url = SITEURL."product";
        if($ctable_d['cate_id']!=0 && $ctable_d['cate_id']!="")
        {
            // $dis_url.= "/".$cate_slug;
            /*echo '<url>';
            echo '<loc>'.$dis_url.'</loc>';
            echo '<lastmod>'.$cate_date.'</lastmod>';
            echo '<changefreq>'.'daily'.'</changefreq>';
            echo '<priority>'.'0.8000'.'</priority>';
            echo '</url>';*/
        }

        if($ctable_d['sub_cate_id']!=0 && $ctable_d['sub_cate_id']!="")
        {
            // $dis_url.= "/".$sub_cate_slug;
            /*echo '<url>';
            echo '<loc>'.$dis_url.'</loc>';
            echo '<lastmod>'.$sub_cate_date.'</lastmod>';
            echo '<changefreq>'.'daily'.'</changefreq>';
            echo '<priority>'.'0.7000'.'</priority>';
            echo '</url>';*/        
        }

        if($ctable_d['sub_sub_cate_id']!=0 && $ctable_d['sub_sub_cate_id']!="")
        {
            // $dis_url.= "/".$sub_sub_cate_slug;

            /*echo '<url>';
            echo '<loc>'.$dis_url.'</loc>';
            echo '<lastmod>'.$sub_sub_cate_date.'</lastmod>';
            echo '<changefreq>'.'daily'.'</changefreq>';
            echo '<priority>'.'0.6000'.'</priority>';
            echo '</url>';*/
            

            /*$dis_url_sub_sub_pro = SITEURL."product/".$cate_slug."/".$sub_cate_slug."/";*/
            
        }

        if($ctable_d['sub_sub_cate_id']!=0 && $ctable_d['sub_sub_cate_id']!="")
        {
            $dis_url_sub_sub = SITEURL."products/".$cate_slug."/".$sub_cate_slug."/".$sub_sub_cate_slug."/";

            /*echo '<url>';
            echo '<loc>'.$dis_url_sub_sub.'</loc>';
            echo '<lastmod>'.$sub_sub_cate_date.'</lastmod>';
            echo '<changefreq>'.'daily'.'</changefreq>';
            echo '<priority>'.'0.6000'.'</priority>';
            echo '</url>';*/
        }

        if($ctable_d['update_at'] >0)
        {
            /*$pro_date = $ctable_d['update_at'];*/
            $pro_date = $db->rpDate($ctable_d['update_at'],"Y-m-d\TH:i:s\-06:00");
        }
        else
        {
            /*$pro_date = $ctable_d['adate'];*/
            $pro_date = $db->rpDate($ctable_d['adate'],"Y-m-d\TH:i:s\-06:00");
        }

        if($ctable_d['sub_sub_cate_id']!=0 && $ctable_d['sub_sub_cate_id']!="")
        {

            /*$dis_url_sub_sub_pro = SITEURL."product/".$cate_slug."/".$sub_cate_slug."/".$ctable_d['slug']."/";
            
            $dis_url_sub_sub_pro.= $ctable_d['slug'];
            echo '<url>';
            echo '<loc>'.$dis_url_sub_sub_pro.'/'.'</loc>';
            echo '<lastmod>'.$pro_date.'</lastmod>';
            echo '<changefreq>'.'daily'.'</changefreq>';
            echo '<priority>'.'0.6000'.'</priority>';
            echo '</url>';*/
        }
        else
        {

            // $dis_url.= "/".stripslashes($ctable_d['slug']);

            $dis_url.= "/".stripslashes($ctable_d['slug']);

            
            echo '<url>';
            echo '<loc>'.$dis_url.'/'.'</loc>';
            echo '<lastmod>'.$pro_date.'</lastmod>';
            echo '<changefreq>'.'daily'.'</changefreq>';
            echo '<priority>'.'0.6000'.'</priority>';
            echo '</url>';
        }
        

    }
}

echo '</urlset>';
?>