<?php
include("connect.php");
$pro_id             = $db->clean($_POST['pro_id']);
$slider_image_type  = $db->clean($_POST['slider_image_type']);

if ($_POST['action']=='pro_images') 
{   
    $pro_where = "id='".$pro_id."' AND isDelete=0";
    $pro_r = $db->rpgetData("product","*",$pro_where);
    $pro_d = @mysqli_fetch_array($pro_r);

    $get_where = "pro_group_id='".$pro_d['pro_group_id']."' AND  cate_id='".$pro_d['cate_id']."' AND isDelete=0";
    // $get_ids = $db->rpgetData("product","id",$get_where);
    $get_ids = $db->rpgetData("product","id",$pro_where);

    $ids = array();

    while ($get_ids_d = @mysqli_fetch_array($get_ids)) 
    {
        $ids[] .= $get_ids_d['id'];
    }

    $product_ids  =  implode(",", $ids);
    if($slider_image_type!="undefined")
    {
        $ctable_where.="isImage IN (0,'".$slider_image_type."') AND ";
    }

    $ctable_where.= "id IN (".$product_ids.") AND isDelete=0 order by id=".$pro_id." desc, id asc";
    $pro_ctable_r = $db->rpgetData("product","image",$ctable_where);
    $pro_ctable_c = @mysqli_num_rows($pro_ctable_r);
    ?>
    <div class="single-product-image product-image-slider fix">
        <?php
        if($pro_ctable_c >0) 
        {
            $counter = 1;
            while ($pro_ctable_d = @mysqli_fetch_array($pro_ctable_r)) 
            {
                $image_path = $pro_ctable_d['image'];
                if(!empty($image_path) && file_exists(PRODUCT.$image_path))
                {
                    $pro_url = SITEURL.PRODUCT.$image_path;
                }
                else
                {
                    $pro_url = SITEURL."common/images/no_image.png";
                }
                ?>
                <div class="p-image">
                    <a data-toggle="modal" data-target="#zoomImage">
                        <img alt="<?php echo SITETITLE; ?>" id="zoom1" src="<?= $pro_url;?>" data-zoom-image="<?= $pro_url;?>" onclick="image_Fun(this.src,this.id);">
                    </a>
                </div>
            <?php 
             $counter++;
            }
        }

        if($slider_image_type!="undefined")
        {
            $alt_img_where.="isImage IN (0,'".$slider_image_type."') AND ";
        }

        $alt_img_where.= "pid IN (".$product_ids.") AND isDelete=0 order by pid=".$pro_id." desc, id asc";
        $alt_img_p = $db->rpgetData("alt_image","*",$alt_img_where);
        $alt_img_c = @mysqli_num_rows($alt_img_p);
        if($alt_img_c > 0)
        {
            while($alt_img_d = @mysqli_fetch_array($alt_img_p))
            {
                if(!empty($alt_img_d['image_path']) && file_exists(PRODUCT_ALT.$alt_img_d['image_path']))
                {
                    $pro_alt_url = SITEURL.PRODUCT_ALT.$alt_img_d['image_path'];
                }
                else
                {
                    $pro_alt_url = SITEURL."common/images/no_image.png";
                }
                ?>
                <div class="p-image">
                    <a data-toggle="modal" data-target="#zoomImage">
                        <img id="zoom<?php echo $alt_img_d['id']; ?>" onclick="image_Fun(this.src,this.id);" src="<?= $pro_alt_url;?>" alt="<?php echo SITETITLE; ?>">
                    </a>
                </div>
                <?php 
            }
        }
        ?>
    </div>
    
    <div class="single-product-thumbnail product-thumbnail-slider float-left" id="gallery_01">
        <?php
        $pro_ctable_r = $db->rpgetData("product","image",$ctable_where);
        $pro_ctable_c = @mysqli_num_rows($pro_ctable_r);

        if($pro_ctable_c >0) 
        {
            while ($pro_ctable_d = @mysqli_fetch_array($pro_ctable_r)) 
            {
                $image_path = $pro_ctable_d['image']; 
                if(!empty($image_path) && file_exists(PRODUCT_THUMB_F.$image_path))
                {
                    $pro_thumb_url = SITEURL.PRODUCT_THUMB_F.$image_path;
                }
                else
                {
                    $pro_thumb_url = SITEURL."common/images/no_image.png";
                }
            ?>
            <div class="p-thumb">
                <img src="<?= $pro_thumb_url;?>" alt="<?php echo SITETITLE; ?>">
            </div>
            <?php 
            }
        }

        if($slider_image_type!="undefined")
        {
            $alt_img_thumb_where.="isImage IN (0,'".$slider_image_type."') AND ";
        }

        $alt_img_thumb_where.= "pid IN (".$product_ids.") AND isDelete=0";
        $alt_img_thumb_p = $db->rpgetData("alt_image","*",$alt_img_thumb_where);
        $alt_img_thumb_c = @mysqli_num_rows($alt_img_thumb_p);
        if($alt_img_thumb_c > 0)
        {
            while($alt_img_thumb_d = @mysqli_fetch_array($alt_img_thumb_p))
            {
                if(!empty($alt_img_thumb_d['image_path']) && file_exists(PRODUCT_ALT_THUMB.$alt_img_thumb_d['image_path']))
                {
                    $pro_alt_thumb_url = SITEURL.PRODUCT_ALT_THUMB.$alt_img_thumb_d['image_path'];
                }
                else
                {
                    $pro_alt_thumb_url = SITEURL."common/images/no_image.png";
                }
                ?>
                <div class="p-thumb">
                    <img src="<?= $pro_alt_thumb_url;?>" alt="<?php echo SITETITLE; ?>">
                </div>
                <?php 
            }
        }
        ?>
    </div>
    <?php
    
}
?>