<?php
include("connect.php");

$data           = $_REQUEST;
$pid            = $data['pid'];
$pro_group_id   = $data['pro_group_id'];
$pro_cate_id    = $data['pro_cate_id'];
$pro_sub_cat_id = $data['pro_sub_cat_id'];
$variation_slug = $data['variation_slug'];

$response   = array();

if ($pid!="" && $pid>0) {
    $pro_ctable_r = $db->rpgetData("product","*","id='".$pid."' AND isDelete=0 ");
    $pro_ctable_c = @mysqli_num_rows($pro_ctable_r);

    if($pro_ctable_c > 0)
    {
        $pro_ctable_d = @mysqli_fetch_array($pro_ctable_r);

        $pro_id                 = $pro_ctable_d['id'];
        $price                  = $pro_ctable_d['price'];
        $sell_price             = $pro_ctable_d['sell_price'];
        $cate_id                = $pro_ctable_d['cate_id'];
        $sub_cate_id            = $pro_ctable_d['sub_cate_id'];
        $sub_sub_cate_id        = $pro_ctable_d['sub_sub_cate_id'];
        $pro_group_id           = $pro_ctable_d['pro_group_id'];
        $image_path             = $pro_ctable_d['image'];
        $isImage                = $pro_ctable_d['isImage'];
        $pro_slug               = stripslashes($pro_ctable_d['slug']);  
        $pro_name               = stripslashes($pro_ctable_d['name']);
        $pro_sku                = stripslashes($pro_ctable_d['pro_sku']);  
        $pro_decs               = stripslashes($pro_ctable_d['decs']);  
        $variation_slug         = stripslashes($pro_ctable_d['variation_slug']);  
        $pro_feature_dimension  = stripslashes($pro_ctable_d['feature_dimension']);  
        $pro_additional_info    = stripslashes($pro_ctable_d['additional_info']);  
        $pro_cate_slug          = $db->rpgetValue("category","slug"," id='".$cate_id."'");
        $pro_sub_cate_slug      = $db->rpgetValue("sub_category","slug"," id='".$sub_cate_id."'");
        
        $meta_title             = stripslashes($pro_ctable_d['meta_title']);
        $meta_description       = stripslashes($pro_ctable_d['meta_description']);
        $meta_keywords          = stripslashes($pro_ctable_d['meta_keywords']);
        
        $isEnquiry_product 	    = ($pro_ctable_d['isEnquiry_product']) ? $pro_ctable_d['isEnquiry_product'] : 0;
        
        $pro_details_url = SITEURL."product/".$pro_cate_slug."/".$pro_slug."/";

        if($pro_sub_cate_slug!="")
        {
            $sub_cate_r = $db->rpgetData("sub_category","*","cate_id='".$cate_id."' AND slug='".$pro_sub_cate_slug."' AND isDelete=0");
            $sub_cate_c          = @mysqli_num_rows($sub_cate_r);

            if($sub_cate_c > 0)
            {
                $sub_cate_d         = @mysqli_fetch_array($sub_cate_r);

                $sub_cate_name      = stripslashes($sub_cate_d['name']);
                $sub_cate_id        = $sub_cate_d['id'];

                $ctable_where.= " sub_cate_id='".$sub_cate_id."' AND ";
                $related_ctable_where.= " sub_cate_id='".$sub_cate_id."' AND ";
                $dis_banner_title.= " > ".$sub_cate_name;

                $pro_details_url = SITEURL."product/".$pro_cate_slug."/".$pro_sub_cate_slug."/".$pro_slug."/";

                
                $sub_sub_cate_r = $db->rpgetData("sub_sub_category","*","cate_id='".$cate_id."' AND sub_cate_id='".$sub_cate_id."' AND slug='".$sub_sub_cate_slug."' AND isDelete=0");
                $sub_sub_cate_c          = @mysqli_num_rows($sub_sub_cate_r);

                if($sub_sub_cate_c > 0)
                {
                    $sub_sub_cate_d         = @mysqli_fetch_array($sub_sub_cate_r);

                    $sub_sub_cate_name      = stripslashes($sub_sub_cate_d['name']);
                    $sub_sub_cate_id        = $sub_sub_cate_d['id'];

                    $ctable_where.= " sub_sub_csate_id='".$sub_sub_cate_id."' AND ";
                    $related_ctable_whsere.= " sub_sub_cate_id='".$sub_sub_cate_id."' AND ";
                    $dis_banner_title.= " > ".$sub_sub_cate_name;

                    $pro_details_url = SITEURL."product/".$pro_cate_slug."/".$pro_sub_cate_slug."/".$sub_sub_cate_slug."/".$pro_slug."/";
                }
            }
        }

        if(!empty($image_path) && file_exists(PRODUCT.$image_path))
        {
            $pro_url = SITEURL.PRODUCT.$image_path;
        }
        else
        {
            $pro_url = SITEURL."common/images/no_image.png";
        }

        if(!empty($image_path) && file_exists(PRODUCT_THUMB_F.$image_path))
        {
            $pro_thumb_url = SITEURL.PRODUCT_THUMB_F.$image_path;
        }
        else
        {
            $pro_thumb_url = SITEURL."common/images/no_image.png";
        }

        if($pro_ctable_d['status']==1)
        {
            $dis_status     = "In Stock";
        }
        
        if($pro_ctable_d['status']==2)
        {
            $dis_status     = "Out Of Stock";
        } 

        if($pro_ctable_d['status']==3)
        {
            $dis_status     = "Special Order";
        } 
        
        if($pro_ctable_d['status']==4)
        {
            $dis_status     = "Online Only";
        }
        
        if($pro_ctable_d['status']==5)
        {
            $dis_status     = "Coming Soon";
        }
        
        if($pro_ctable_d['status']==6)
        {
            $dis_status     = "Special Order (14-16 weeks)";
        }

        if($pro_ctable_d['status']==7)
        {
            $dis_status     = "Special Order (2-4 weeks)";
        }

        if($sell_price > 0)
        {
            $is_discount_product = $db->checkIsDiscountProduct($pro_id,$cate_id,$sub_cate_id,$sub_sub_cate_id,$sell_price);
            $dis_price = '<span class="p-d-price">'.CURR.($sell_price - $is_discount_product['total_discount']).'</span><span class="price-line-through">'.CURR.$price.'</span>';
        }
        else
        {
            $is_discount_product = $db->checkIsDiscountProduct($pro_id,$cate_id,$sub_cate_id,$sub_sub_cate_id,$price);
            if($is_discount_product['is_discount_pro'] == 1)
            {
               $dis_price = '<span class="p-d-price">'.CURR.($price - $is_discount_product['total_discount']).'</span><span class="price-line-through">'.CURR.$price.'</span>'; 
            }
            else
            {
                $dis_price = '<span>'.CURR.($price - $is_discount_product['total_discount']).'</span>';
            }
        }
        $dis_discount_desc = ($is_discount_product['discount_desc']) ? "<p>".$is_discount_product['discount_desc']."</p>" : "";

        $is_wish_listed = $db->rpgetTotalRecord("wishlist","product_id='".$pro_id."' AND user_id='".$_SESSION[SESS_PRE.'_SESS_USER_ID']."'");

        $dis_wishlist_tooltip = 'Add to Wishlist';
        if($is_wish_listed > 0)
        {
            $dis_wishlist_tooltip = 'Remove from Wishlist';
        }

        $dis_isImage_section = 0;
        if($isImage!=0)
        {
            $dis_isImage_section = 1;
        }

        $alt_isImage = $db->rpgetTotalRecord("alt_image","pid='".$pro_id."' AND isDelete=0 AND (isImage=1 OR isImage=2)");
        if($alt_isImage > 0)
        {
            $dis_isImage_section = 1;
        }
    }
}

?>


<div class="p-d-wrapper" >
    <h2 id='product_name' class="product-name-title">
       <?=$pro_name;?> 
       <?php echo $db->proBadge($pro_ctable_d['isProduct']);?>
    </h2>
    <?=$dis_discount_desc;?>
    <div class="p-rating-review">
        <?php 
        echo $db->get_single_rating($pro_id);
        
        if ($total_review > 0)
        {
            $dis_total_review = $total_review." review";
            if($total_review > 1)
            {
                $dis_total_review = $total_review." reviews";
            }
        ?>
        <span><?=$dis_total_review;?></span>
        <?php
        }
        ?>
    </div>
    <!--<span class="p-d-price"><?=$dis_price;?></span>-->
    <div class="price-with-stripe">
        <?=$dis_price;?>
    </div>
    <span class="model-stock"><?=$dis_status;?></span>
    <?php 
    if($pro_sku!="")
    {
    ?>
    <span>SKU : <?=$pro_sku;?></span>
    <?php 
    }
    
    if($pro_ctable_d['status']==1 || $pro_ctable_d['status']==3 || $pro_ctable_d['status']==4)
    {

    if($dis_isImage_section == 1)
    {
    ?>
    <div class="select-right-left-pro">
        <label class="text-uppercase pr-label slider_image_type_label">Select</label>
        <section class="rl">
            <div class="group-right-pro group-pro">
                <input name="slider_image_type" type="radio" id="rightpro" class="right-and-left-pro" value="2">
                <label for="rightpro" class="rightpro"></label>
            </div>
            <div class="group-left-pro group-pro">
                <input name="slider_image_type" type="radio" id="leftpro" class="right-and-left-pro" value="1">
                <label for="leftpro" class="leftpro"></label>
            </div>
        </section>
    </div>
    <?php 
    }
    ?>
    <?php 
        $variation_r =  $db->rpgetData("product","*","pro_group_id='".$pro_group_id."' AND  cate_id='".$cate_id."' AND  sub_cate_id='".$sub_cate_id."' AND isDelete=0 AND variation_slug!='' GROUP BY variation_slug","");
        
        $variation_c = @mysqli_num_rows($variation_r);
        if ($variation_c > 0) {
            
        ?>

        <div class="mt-5 position-relative"> 
            <div class="loading-div1 inner_section_loader" style="display: none;"></div>
            <select name="variation" id="variation" >
                <option value="">Select option</option>
                <?php
                $count=0;
                
                while ($variation_d = @mysqli_fetch_array($variation_r)) {
                    if($variation_d['variation_slug']==$variation_slug){
                        $selected_class = "selected";

                        $num_slug_r = $db->rpgetData("product","*","pro_group_id='".$pro_group_id."' AND  cate_id='".$cate_id."' AND  sub_cate_id='".$sub_cate_id."' AND isDelete=0 AND variation_slug='".$variation_slug."'","",0);

                        if (@mysqli_num_rows($num_slug_r)>1) {
                            $content = '<select name="sub_variation" id="sub_variation"><option value="">Select option</option>';
                            while ($num_slug_d = @mysqli_fetch_array($num_slug_r)) {
                                $count++;
                                $cate_id            = $num_slug_d['cate_id'];
                                $sub_cate_id        = $num_slug_d['sub_cate_id'];
                                $sub_sub_cate_id    = $num_slug_d['sub_sub_cate_id'];

                                $pro_slug           = stripslashes($num_slug_d['slug']);  
                                $pro_name           = stripslashes($num_slug_d['name']);  

                                $pro_cate_slug          = $db->rpgetValue("category","slug"," id='".$cate_id."' ");
                                $pro_sub_cate_slug      = $db->rpgetValue("sub_category","slug"," id='".$sub_cate_id."' ");
                                $pro_sub_sub_cate_slug  = $db->rpgetValue("sub_sub_category","slug"," id='".$sub_sub_cate_id."' ");
                                
                                $pro_details_url = SITEURL."product/".$pro_cate_slug."/".$pro_slug."/";
                                if($sub_cate_id!=0 && $sub_cate_id!="")
                                {
                                    $pro_details_url = SITEURL."product/".$pro_cate_slug."/".$pro_sub_cate_slug."/".$pro_slug."/";
                                }
                
                                if($sub_sub_cate_id!=0 && $sub_sub_cate_id!="")
                                {
                                    $pro_details_url = SITEURL."product/".$sub_sub_cate_id."/".$pro_sub_cate_slug."/".$pro_sub_sub_cate_slug."/".$pro_slug."/";
                                }

                                if ($pro_id==$num_slug_d['id']) {
                                   $select  = "selected";
                                }else{
                                   $select = ""; 
                                }
                                $content .= '<option value="'.$pro_details_url.'" data-id="'.$num_slug_d['id'].'" '.$select.'>'.ucfirst($num_slug_d['name']).'</option>';
                            }
                            $content .= "</select>";
                        }
                        
                    }else{
                        $selected_class = "";
                    }
                    
                    if ($count>0) {
                        $content = $content;
                    }else{
                        $content = "";
                    }
                   
                    echo '<option value="'.$variation_d['variation_slug'].'" '.$selected_class.' >'.ucfirst($variation_d['variation']).'</option>';
                }
                ?>
            </select>
        </div>
       
        <div id="sub-variation-div" class="mt-5"><?php echo $content; ?></div>
        <?php
        }

    ?>
    <form method="post" name="frm" id="frm" action="<?php echo SITEURL; ?>process-add-to-cart/">
        <div class="qty-cart-add">
            <label for="qty">qty</label>
            <div class="num-block num-change-block skin-5">
                <div class="num-in">
                    <span class="minus dis">-</span>
                    <input type="text" class="in-num" name="qty" id="qty" min="1" value="1" readonly="">
                    <span class="plus">+</span>
                </div>
            </div>
            <input type="hidden" name="product_id" id="product_id" value="<?php echo $pro_id; ?>">
            <input type="hidden" name="product_url" id="product_url" value="<?php echo $pro_details_url; ?>">
            <button type="submit">Add to cart</button>
        </div>
    </form>
    <?php 
    }
    ?>
    <div class="p-d-buttons">
        <a href="javascript:void(0)" data-curr-page="pro_details" class="pro_wishlist" data-proid="<?=$pro_id;?>"><?=$dis_wishlist_tooltip;?></a>
        <?php
        if($isEnquiry_product == 1)
        {
        ?>
        <a href="javascript:void(0)" class="black-btn" type="button" data-toggle="modal" data-target="#enquiryModal">MAKE AN ENQUIRY FOR THIS PRODUCT</a>
        <?php
        }
        ?>
        <!-- <a href="javascript:void(0)">Add to compare</a> -->
    </div>
    <div class="share mt-4">
        <span class="pr-3">Share On:</span>
        <span><a target="_blank" href="https://www.facebook.com/sharer.php?u=<?=$pro_details_url;?>&t=<?=$pro_name;?>"><img src="<?= SITEURL?>images/fb-n.png" alt="<?php echo SITETITLE; ?>" /></a></span>
        <span><a target="_blank" href="https://twitter.com/intent/tweet?url=<?=$pro_details_url;?>&text=<?=$pro_name;?>"><img src="<?= SITEURL?>images/twi-n.png" alt="<?php echo SITETITLE; ?>" /></a></span>
        <span><a target="_blank" href="https://plus.google.com/share?url=<?=$pro_details_url;?>"><img src="<?= SITEURL?>images/gplus-n.png" alt="<?php echo SITETITLE; ?>" /></a></span>
        <span><a target="_blank" href="http://pinterest.com/pin/create/button/?url=<?=$pro_details_url;?>&description=<?=$pro_name;?>"><img src="<?= SITEURL?>images/pin-n.png" alt="<?php echo SITETITLE; ?>" /></a></span>
    </div>
    
    <!--enquiry modal-->
    <div class="modal fade" id="enquiryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-new">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Product Enquiry</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method="post" action="<?php echo SITEURL; ?>enquiry/" id="product_enquiry_form" name="product_enquiry_form">
              <div class="modal-body">
                  <div class="form-group row">
                    <label for="ename" class="col-sm-2 col-form-label">*Name</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="ename" value="" name="ename">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="eemail" class="col-sm-2 col-form-label">*Email</label>
                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="eemail" value="" name="eemail">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="esubject" class="col-sm-2 col-form-label">*Subject</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="esubject" value="" name="esubject">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="eletter" class="col-sm-2 col-form-label">*Enquiry</label>
                    <div class="col-sm-10">
                      <textarea class="form-control" id="eletter" rows="5"  value="" name="eletter"></textarea>
                    </div>
                  </div>
              </div>
              <div class="modal-footer">
                <input type="hidden" name="pid" id="pid" value="<?php echo $pro_id; ?>">
                <input type="hidden" name="user_id" id="user_id" value="<?php echo $_SESSION[SESS_PRE.'_SESS_USER_ID']; ?>">
                <input type="hidden" name="product_url" id="product_url" value="<?php echo $pro_details_url; ?>">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="submit">Save changes</button>
              </div>
          </form>
        </div>
      </div>
    </div>

</div>
<script>
      $(function(){
        $("#product_enquiry_form").validate({
         rules: 
         {
           ename:{required : true},
           esubject:{required : true},
           eletter:{required : true},
           eemail:{required : true,email: true},
           
         },
         messages: {
           ename:{required:"Please enter your Name."},
           esubject:{required:"Please enter your Subject."},
           eletter:{required:"Please enter your Letter."},
           eemail:{required:"Please enter your email address.",email : "Please enter valid email address."},
           
         }, 
		errorPlacement: function (error, element) 
		{
			error.insertAfter(element);
		}
        });
      });
</script>
