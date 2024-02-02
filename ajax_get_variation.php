<?php
include("connect.php");
$pid 				= $_POST['pid'];
$pro_group_id 		= $_POST['pro_group_id'];
$pro_cate_id 		= $_POST['pro_cate_id'];
$pro_sub_cat_id 	= $_POST['pro_sub_cat_id'];
$variation_slug 	= $_POST['variation_slug'];
$pro_sub_cat		= $_POST['pro_sub_cat'];
$response 			= array();

	if(isset($pid) && $pid > 0 && isset($variation_slug) && $variation_slug!="")
	{
		if($pro_sub_cat!='' && $pro_sub_cat!=null)
		{
			$where = " variation_slug = '".$variation_slug."' AND pro_sub_cat='".$pro_sub_cat."' AND pro_group_id='".$pro_group_id."' AND  cate_id='".$pro_cate_id."' AND  sub_cate_id='".$pro_sub_cat_id."' AND isDelete=0";
		}
		else{
			$where = " variation_slug = '".$variation_slug."' AND pro_group_id='".$pro_group_id."' AND  cate_id='".$pro_cate_id."' AND  sub_cate_id='".$pro_sub_cat_id."' AND isDelete=0";
		}
		if ($db->rpgetTotalRecord("product",$where)>0) {

			$ctable_r = $db->rpgetData("product","*",$where);
			if($db->rpgetTotalRecord("product",$where) == 1)
			{
				$ctable_d = @mysqli_fetch_array($ctable_r);

				$cate_id     		= $ctable_d['cate_id'];
				$sub_cate_id    	= $ctable_d['sub_cate_id'];
				$sub_sub_cate_id 	= $ctable_d['sub_sub_cate_id'];

				$pro_slug 			= stripslashes($ctable_d['slug']);	
				$pro_name 			= stripslashes($ctable_d['name']);	

				$pro_cate_slug 			= $db->rpgetValue("category","slug"," id='".$cate_id."' ");
				$pro_sub_cate_slug 		= $db->rpgetValue("sub_category","slug"," id='".$sub_cate_id."' ");
				$pro_sub_sub_cate_slug 	= $db->rpgetValue("sub_sub_category","slug"," id='".$sub_sub_cate_id."'");
                $pro_details_url = SITEURL."product/".$pro_cate_slug."/".$pro_sub_cate_slug."/".$pro_sub_sub_cate_slug."/".$pro_slug."/";
				
				$pro_details_url = SITEURL."product/".$pro_cate_slug."/".$pro_slug."/";
                if($sub_cate_id!=0 && $sub_cate_id!="")
                {
                    $pro_details_url = SITEURL."product/".$pro_cate_slug."/".$pro_sub_cate_slug."/".$pro_slug."/";
                }

                if($sub_sub_cate_id!=0 && $sub_sub_cate_id!="")
                {
                    $pro_details_url = SITEURL."product/".$sub_sub_cate_id."/".$pro_sub_cate_slug."/".$pro_sub_sub_cate_slug."/".$pro_slug."/";
                }
					$response['msg'] 		= 'redirect';
        			$response['content'] 	= $pro_details_url;
        			$response['pid'] 		= $ctable_d['id'];
			}
			else
			{
				$content  = '<select name="sub_variation" id="sub_variation"><option value="">Select option</option>';

                                    while ($ctable_d = @mysqli_fetch_array($ctable_r)) {

                                    	$cate_id     		= $ctable_d['cate_id'];
										$sub_cate_id    	= $ctable_d['sub_cate_id'];
										$sub_sub_cate_id 	= $ctable_d['sub_sub_cate_id'];

										$pro_slug 			= stripslashes($ctable_d['slug']);	
										$pro_name 			= stripslashes($ctable_d['name']);	

										$pro_cate_slug 			= $db->rpgetValue("category","slug"," id='".$cate_id."' ");
										$pro_sub_cate_slug 		= $db->rpgetValue("sub_category","slug"," id='".$sub_cate_id."' ");
										$pro_sub_sub_cate_slug 	= $db->rpgetValue("sub_sub_category","slug"," id='".$sub_sub_cate_id."' ");
                                        
                                        $pro_details_url = SITEURL."product/".$pro_cate_slug."/".$pro_slug."/";
                                        if($sub_cate_id!=0 && $sub_cate_id!="")
                                        {
                                            $pro_details_url = SITEURL."product/".$pro_cate_slug."/".$pro_sub_cate_slug."/".$pro_slug."/";
                                        }
                        
                                        if($sub_sub_cate_id!=0 && $sub_sub_cate_id!="")
                                        {
                                            $pro_details_url = SITEURL."product/".$sub_sub_cate_id."/".$pro_sub_cate_slug."/".$pro_sub_sub_cate_slug."/".$pro_slug."/";
                                        }
                
                                      $content .= '<option value="'.$pro_details_url.'" data-id="'.$ctable_d['id'].'">'.ucfirst($pro_name).'</option>';
                                    } 
                $content .='</select>';

				$response['msg'] 		= 'dropdown_added'; //echo "1";die;
				$response['content'] 	= $content;
			}
		}else{
			$response['msg'] 		= 'error';
			$response['content'] 	= "";
		}
	}
	else
	{
		$response['msg'] 		= 'error';
		$response['content'] 	= "";
	}

echo json_encode($response);
die();
?>