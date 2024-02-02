<?php
include('connect.php'); 

$ctable_r   = $db->rpgetData("product","*","isDelete=0");
if(@mysqli_num_rows($ctable_r)>0)
{
    while($ctable_d           = @mysqli_fetch_array($ctable_r))
    {
    	$cate_slug = $db->rpgetValue("category","slug","id='".$ctable_d['cate_id']."'");
    	$sub_cate_slug = $db->rpgetValue("sub_category","slug","id='".$ctable_d['sub_cate_id']."'");
    	$sub_sub_cate_slug = $db->rpgetValue("sub_sub_category","slug","id='".$ctable_d['sub_sub_cate_id']."'");

    	$dis_url = SITEURL."product/";
    	if($ctable_d['cate_id']!=0 && $ctable_d['cate_id']!="")
    	{
    		$dis_url.= $cate_slug."/";
    	}

    	if($ctable_d['sub_cate_id']!=0 && $ctable_d['sub_cate_id']!="")
    	{
    		$dis_url.= $sub_cate_slug."/";
    	}

    	if($ctable_d['sub_sub_cate_id']!=0 && $ctable_d['sub_sub_cate_id']!="")
    	{
    		$dis_url.= $sub_sub_cate_slug."/";
    	}

    	echo $dis_url.= $ctable_d['slug']."<br>";
    }
}
?>