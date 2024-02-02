<?php
include("connect.php");
?>
<div class="wishlist-table table-responsive">
    <table>
        <thead>
            <tr>
                <th class="product-remove"><span>Remove</span></th>
                <th class="product-thumbnail">Image</th>
                <th class="product-name"><span>Product</span></th>
                <th class="w-c-price"><span> Unit Price </span></th>
                <th class="product-stock-stauts"><span> Stock Status </span></th>
                <th class="product-add-to-cart"><span>Add to Cart </span></th>
            </tr>
        </thead>
        <tbody>
          <?php
          $count = 1;
          $ctable_r = $db->rpgetData("wishlist","*"," user_id='".$_SESSION[SESS_PRE.'_SESS_USER_ID']."' AND isDelete=0","id DESC");
          if(@mysqli_num_rows($ctable_r) >0)
          {
              while($ctable_d = @mysqli_fetch_array($ctable_r))
              {  
                  $wish_r = $db->rpgetData("product","*"," id='".$ctable_d['product_id']."' AND isDelete=0");
                  $wish_no = @mysqli_num_rows($wish_r);
                  $wish_d = @mysqli_fetch_array($wish_r);
                  if ($wish_no > 0) 
                  {
                    $count++;
                    if($wish_d['status']==1)
                      {
                        $dis_status   = "In Stock";
                      }
                      
                      if($wish_d['status']==2)
                      {
                        $dis_status   = "Out Of Stock";
                      } 

                      if($wish_d['status']==3)
                      {
                        $dis_status   = "Special Order";
                      } 
                      
                      if($wish_d['status']==4)
                      {
                        $dis_status   = "Online Only";
                      }
                      
                      if($wish_d['status']==5)
                      {
                          $dis_status     = "Coming Soon";
                      }

                      $price          = $wish_d['price'];
                      $sell_price     = $wish_d['sell_price'];

                      $pro_id           = $wish_d['id'];
                      
                      $cate_id          = $wish_d['cate_id'];
                      $sub_cate_id      = $wish_d['sub_cate_id'];
                      $sub_sub_cate_id  = $wish_d['sub_sub_cate_id'];
                      $pro_slug         = stripslashes($wish_d['slug']);  
                      $pro_name         = stripslashes($wish_d['name']);  
                      $image_path       = $wish_d['image'];

                      /*if($sell_price > 0)
                      {
                          $dis_price = '<span class="p-d-price">'.CURR.$sell_price.'</span><span class="price-line-through">'.CURR.$price.'</span>';
                      }
                      else
                      {
                          $dis_price = '<span>'.CURR.$price.'</span>';
                      }*/
                      if($sell_price > 0)
                      {

                        $is_discount_product = $db->checkIsDiscountProduct($pro_id,$cate_id,$sub_cate_id,$sub_sub_cate_id,$sell_price);
                        $dis_price = '<span>'.CURR.($sell_price - $is_discount_product['total_discount']).'</span><span class="price-line-through">'.CURR.$price.'</span>';
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


                      if(!empty($image_path) && file_exists(PRODUCT_THUMB_F.$image_path))
                      {
                        $pro_url = SITEURL.PRODUCT_THUMB_F.$image_path;
                      }
                      else
                      {
                        $pro_url = SITEURL."common/images/no_image.png";
                      }

                      $pro_cate_slug = $db->rpgetValue("category","slug"," id='".$cate_id."' ");
                      $pro_sub_cate_slug = $db->rpgetValue("sub_category","slug"," id='".$sub_cate_id."' ");
                      $pro_sub_sub_cate_slug = $db->rpgetValue("sub_sub_category","slug"," id='".$sub_sub_cate_id."' ");

                      $pro_details_url = SITEURL."product/".$pro_cate_slug."/".$pro_slug."/";
                      if($sub_cate_id!=0 && $sub_cate_id!="")
                      {
                        $pro_details_url = SITEURL."product/".$pro_cate_slug."/".$pro_sub_cate_slug."/".$pro_slug."/";
                      }

                      if($sub_sub_cate_id!=0 && $sub_sub_cate_id!="")
                      {
                        $pro_details_url = SITEURL."product/".$pro_cate_slug."/".$pro_sub_cate_slug."/".$pro_sub_sub_cate_slug."/".$pro_slug."/";
                      }
                    ?>  
                    <tr>
                        <td class="product-remove">
                          <a href="javascript:void(0);" onclick="remove_wishList('<?php echo $ctable_d['product_id']; ?>');">×</a>
                        </td>
                        <td class="product-thumbnail">
                          <a href="<?=$pro_details_url;?>">
                            <img src="<?php echo $pro_url; ?>" alt="<?php echo $pro_name;?>">
                          </a>
                        </td>
                        <td class="product-name"><a href="<?=$pro_details_url;?>"><?php echo $wish_d['name']; ?></a></td>
                        <td class="w-c-price"><?=$dis_price;?></td>
                        <td class="product-stock-status"><span class="wishlist-in-stock"><?=$dis_status;?></span></td>
                        <td class="product-add-to-cart"><a href="<?=$pro_details_url;?>">Add to Cart</a></td>
                    </tr> 
                  <?php
                  }
              }
          }
          
          if($count == 1)
          {
          ?>
          <tr><td colspan="6"><center>No record found.</center></td></tr>
          <?php 
          }
          ?>
        </tbody>
    </table>
    <?php 
      $db->rppaginate_function_front(5,1,10,10);
    ?>
</div>  