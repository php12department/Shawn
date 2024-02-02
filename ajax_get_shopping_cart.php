<?php 
$page = "shopping-cart";
include("connect.php"); 

if(isset($_SESSION[SESS_PRE.'_SESS_CART_ID']))
{
    $shop_cart_r = $db->rpgetData("cartitems","*","cart_id='".$_SESSION[SESS_PRE.'_SESS_CART_ID']."'");
    if(@mysqli_num_rows($shop_cart_r)>0)
    {
        $coupon_code = $db->rpgetValue("cartdetails","coupon_code","cart_id='".$_SESSION[SESS_PRE.'_SESS_CART_ID']."'");
        
        $sub_total  = 0;
        $discount   = 0;
        ?>
        <div class="cart-table table-responsive">
            <table class="cart-table-new">
                <thead>
                    <tr>
                        <th class="p-image">Image</th>
                        <th class="p-name">Product Name</th>
                        <th class="p-amount">Unit Price</th>
                        <th class="p-quantity">Qty</th>
                        <th class="p-total">SubTotal</th>
                        <th class="p-edit">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    $regular_pro_final_amt = 0;
                    $total_sell_product = 0;
                    $dis_pro_cart_item_arr = array();
                    while($shop_cart_d = @mysqli_fetch_array($shop_cart_r))
                    {
                        $id                     =   $shop_cart_d['id'];
                        $pid                    =   $shop_cart_d['pid'];
                        $qty                    =   $shop_cart_d['qty'];
                        $unitprice              =   $db->rpnum($shop_cart_d['unitprice']);
                        $totalprice             =   $db->rpnum($shop_cart_d['totalprice']);
                        $finalprice             =   $db->rpnum($shop_cart_d['finalprice']);

                        $dis_discount_desc      = ($shop_cart_d['discount_desc']) ? "<p><small>(".$shop_cart_d['discount_desc'].")</small></p>" : "";
                        $sub_total  += $db->rpnum($finalprice);

                        if ($shop_cart_d['product_type']=="w") 
                        {
                            $pro_r = $db->rpgetData("warranty","*","id='".$pid."'");
                        }
                        else
                        {
                            $pro_r = $db->rpgetData("product","*","id='".$pid."'");
                        }
                        
                        if(mysqli_num_rows($pro_r)>0)
                        {
                            $pro_d      = @mysqli_fetch_array($pro_r);
                            
                            if ($shop_cart_d['product_type']=="w") 
                            {

                                $pro_name           = stripslashes($pro_d['title']); 
                                $pro_thumb_url      = SITEURL."images/warranty.jpg";
                                $pro_details_url    = "javascript:;";
                            }
                            else
                            {
                                $cate_id            = $pro_d['cate_id'];
                                $sub_cate_id        = $pro_d['sub_cate_id'];
                                $sub_sub_cate_id    = $pro_d['sub_sub_cate_id'];

                                $pro_slug           = stripslashes($pro_d['slug']);  
                                $pro_name           = stripslashes($pro_d['name']); 

                                $pro_cate_slug      = $db->rpgetValue("category","slug"," id='".$cate_id."'");
                                $pro_sub_cate_slug  = $db->rpgetValue("sub_category","slug"," id='".$sub_cate_id."'");
                                $pro_sub_sub_cate_slug  = $db->rpgetValue("sub_sub_category","slug"," id='".$sub_sub_cate_id."'");

                                $image_path         = $pro_d['image'];
                                if(!empty($image_path) && file_exists(PRODUCT_THUMB_F.$image_path))
                                {
                                    $pro_thumb_url = SITEURL.PRODUCT_THUMB_F.$image_path;
                                }
                                else
                                {
                                    $pro_thumb_url = SITEURL."common/images/no_image.png";
                                }

                                $pro_details_url = SITEURL."product/".$pro_cate_slug."/".$pro_slug."/";
                                if($sub_cate_id!=0 && $sub_cate_id!="")
                                {
                                    $pro_details_url = SITEURL."product/".$pro_cate_slug."/".$pro_sub_cate_slug."/".$pro_slug."/";
                                }

                                if($sub_sub_cate_id!=0 && $sub_sub_cate_id!="")
                                {
                                    $pro_details_url = SITEURL."product/".$pro_cate_slug."/".$pro_sub_cate_slug."/".$pro_sub_sub_cate_slug."/".$pro_slug."/";
                                }

                                if($pro_d['sell_price'] <= 0)
                                {
                                    $regular_pro_final_amt = $regular_pro_final_amt + $db->rpnum($shop_cart_d['finalprice']);
                                    $total_sell_product++;

                                    $dis_pro_cart_item_arr[] = $id;
                                }
                            }   
                            
                        }
                        ?>
                        <tr>
                            <td class="p-image">
                                <a href="<?=$pro_details_url;?>">
                                    <img alt="<?= $pro_name; ?>" title="<?= $pro_name; ?>" src="<?php echo $pro_thumb_url ?>">
                                </a>
                            </td>
                            <td class="p-name">
                                <a href="<?=$pro_details_url;?>"><?= $pro_name ?></a>
                            </td>
                            <td class="p-amount">
                                <?php 
                                if($shop_cart_d['total_discount']!=0)
                                {
                                    $dis_price = '<span class="p-d-price">'.CURR.($unitprice - $shop_cart_d['total_discount']).'</span><span class="price-line-through">'.CURR.$unitprice.'</span>';
                                }
                                else
                                {
                                    $dis_price = '<span>'.CURR.($unitprice).'</span>';
                                }
                                ?>
                                <?= $dis_price;?><?=$dis_discount_desc;?></td>
                            <td class="p-quantity">
                                <div class="num-block skin-5">
                                  <div class="num-in">
                                    <span class="minus dis" data-cartid='<?= $id ?>'>-</span>
                                    <input type="text" class="in-num" value="<?= $qty; ?>" min='1' readonly="">
                                    <span class="plus" data-cartid='<?= $id ?>'>+</span>
                                  </div>
                                </div>
                            </td>
                            <td class="p-total">
                                <span><?= CURR.$finalprice; ?></span>
                            </td>
                            <td class="edit">
                                <a onclick="removeCartItem('<?php echo $id; ?>','<?php echo $pid; ?>');" href="javascript:;"><img src="<?=SITEURL?>images/delte.png" alt="<?php echo SITETITLE; ?>" ></a>
                            </td>
                        </tr>
                    <?php
                    $count++;
                    }

                    $final_total = $sub_total;

                    $coupon_id= $db->rpgetValue("cartdetails","coupon_id","cart_id='".$_SESSION[SESS_PRE.'_SESS_CART_ID']."'");

                    $cpn_f      = $db->rpgetData("coupon","*"," id='".$coupon_id."' AND isDelete=0 ");
                    $coupon_no  = @mysqli_num_rows($cpn_f);
                    
                    $coupon_name = "";
                    $upd_final_total = $final_total;
                    $upd_discount = 0;
                    $coupon = 0;
                    
                    if($coupon_no > 0) 
                    {
                        $coupon = 1;
                        $coupon_d   = @mysqli_fetch_assoc($cpn_f);
                       
                        $min_amt        = $coupon_d['min_spend_amount'];
                        $type           = $coupon_d['type'];
                        $coupon_value   = $coupon_d['amount'];

                        $flag = true;
                        $curr_dt = date('Y-m-d');
                        if(strtotime($coupon_d['start_date']) > strtotime($curr_dt)) 
                        {
                            $flag = false;
                        }

                        if(strtotime($coupon_d['expiration_date']) < strtotime($curr_dt)) 
                        {
                            $flag = false;
                        }

                        if($regular_pro_final_amt >= $min_amt) 
                        {
                            if($regular_pro_final_amt <= 0) 
                            {
                                $flag = false;
                                $discount = $upd_discount;
                                $final_total = $upd_final_total;
                            }
                        } 
                        else 
                        {
                            $flag = false;
                        }
                        

                        if($total_sell_product == 0)
                        {
                            $flag = false; //if all sell price product added in cart then return this error to user
                        }

                        if($flag == false) 
                        {
                            $values = array(
                                "coupon_id"         => "",
                                "coupon_code"       => "",
                                "coupon_type"       => "",
                                "total_discount"    => $discount,
                                "finaltotal"        => $final_total,
                            );
                            $wh = " cart_id='".$_SESSION[SESS_PRE.'_SESS_CART_ID']."' ";
                            $db->rpupdate("cartdetails",$values,$wh);

                            $values_itm = array(
                                "coupon_id"         => "",
                                "coupon_discount"   => 0,
                            );
                            $itm_wh = " cart_id='".$_SESSION[SESS_PRE.'_SESS_CART_ID']."' ";
                            $db->rpupdate("cartitems",$values_itm,$itm_wh);
                        } 
                        else 
                        {
                            if($regular_pro_final_amt >= $min_amt) 
                            {
                                if($type=="percent") 
                                {  
                                    $coupon_type = 2;                  
                                    $discount = round(($regular_pro_final_amt * $coupon_value)/100,2);
                                    $final_total = round($final_total - $discount,2);
                                } 
                                else if($type=="flat") 
                                {
                                    $coupon_type = 1;
                                    $discount = round($coupon_value,2);
                                    $final_total = round($final_total - $discount,2);
                                }

                                $discount_for_single_pro = round($discount / $total_sell_product,2);
                            }
                            
                            $values = array(
                                "coupon_type"       => $coupon_type,
                                "total_discount"    => $discount,
                                "finaltotal"        => $final_total,
                            );
                            $wh = " cart_id='".$_SESSION[SESS_PRE.'_SESS_CART_ID']."' ";
                            $db->rpupdate("cartdetails",$values,$wh);


                            //update coupon discount product wise
                            if(count($dis_pro_cart_item_arr) > 0)
                            {   
                                foreach ($dis_pro_cart_item_arr as $dis_pro_cart_item_ar) 
                                {
                                    $values = array(
                                        "coupon_id"         => $coupon_id,
                                        "coupon_discount"   => $discount_for_single_pro,
                                    );
                                    $wh = " cart_id='".$_SESSION[SESS_PRE.'_SESS_CART_ID']."' AND id='".$dis_pro_cart_item_ar."'";
                                    $db->rpupdate("cartitems",$values,$wh);
                                }
                            }
                        }
                        

                        $final_total = $final_total;
                    } 
                    else 
                    {
                        $values = array(
                            "coupon_id"         => "",
                            "coupon_code"       => "",
                            "coupon_type"       => "",
                            "total_discount"    => $discount,
                            "finaltotal"        => $final_total,
                        );
                        $wh = " cart_id='".$_SESSION[SESS_PRE.'_SESS_CART_ID']."' ";
                        $db->rpupdate("cartdetails",$values,$wh);

                        $values_itm = array(
                            "coupon_id"         => "",
                            "coupon_discount"   => 0,
                        );
                        $itm_wh = " cart_id='".$_SESSION[SESS_PRE.'_SESS_CART_ID']."' ";
                        $db->rpupdate("cartitems",$values_itm,$itm_wh);
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php 
        $coupon_id= $db->rpgetValue("cartdetails","coupon_id","cart_id='".$_SESSION[SESS_PRE.'_SESS_CART_ID']."' AND isDelete=0");

        $cpn_f      = $db->rpgetData("coupon","*"," id='".$coupon_id."' AND isDelete=0");
        $coupon_no  = mysqli_num_rows($cpn_f);
        $coupon_d   = mysqli_fetch_assoc($cpn_f);
        $coupon_class = "";
        if($coupon_no>0) 
        {
            $coupon_class = "readonly";
        }
        ?>
        <div class="row mt-30">
            <div class="col-lg-8 col-md-12 mb-0">
                <div class="ht-shipping-content mb-0">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="postal-code">
                                <input <?= $coupon_class ?> id="coupon" type="text" placeholder="Enter Coupon Code" class="form-control coupancode" name="coupon" value="<?= $coupon_d['code'] ?>">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="buttons-set">
                                <?php
                                if($coupon_class!="") 
                                {
                                ?>
                                <button class="button removeCode" type="button"><span>Remove Coupon</span></button>
                                <?php
                                } 
                                else 
                                {
                                ?>
                                <button class="button apply_coupon" type="button"><span>Apply Coupon</span></button>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>    
                </div>
            </div>
            <div class="col-lg-4 col-md-12 mb-5 mb-lg-0">
                <div class="ht-shipping-content">
                    <div class="amount-totals no-p">
                        <p class="total">Subtotal <span><?= CURR.$sub_total; ?></span></p>
                        <p class="total">Coupon Discount(-) <span><?= CURR.$discount; ?></span></p>
                        <p class="total">Total <span><?= CURR.$final_total; ?></span></p>
                        <div class="clearfix"></div>
                    </div>   
                </div>
            </div>
        </div>

        <div class="all-cart-buttons button-in-flex">
            <button class="button" type="button" onClick="window.location.href='<?php echo SITEURL; ?>'"><span>Continue Shopping</span></button>
            <button class="button" type="button" title="Proceed to Checkout" onClick="window.location.href='<?php echo SITEURL; ?>checkout/'"><span>Procced to checkout</span></button>
            <button class="button" type="button" onClick="clearCartItem()"><span>CLEAR CART</span></button>
        </div>
        <br>
        <hr>
        <?php 
        $check_warrantyplan_n = $db->rpgetTotalRecord("cartitems"," cart_id = '".$_SESSION[SESS_PRE.'_SESS_CART_ID']."' AND product_type='w'");
        if ($check_warrantyplan_n==0) 
        {
        ?>
        <div class="plan-list">
            <h2 class="text-left plan-h2">Product warranty Plans</h2>
            <div class="warranty-plan">
             <?php
            $warranty_r = $db->rpgetData("warranty","*"," (".$final_total." >= from_amount AND ".$final_total." <= to_amount) AND isDelete=0");
                if(@mysqli_num_rows($warranty_r)>0)
                {
                    while($warranty_d = @mysqli_fetch_array($warranty_r))
                    {
                    ?>
                        <div class="plan-card wrapper-plan-card">
                            <div class="ribbon-wrapper-green"><div class="ribbon-green">5 Year</div></div>
                            <div class="plan-title">
                                <h3 class="plan-h3"><?php echo $warranty_d['title']; ?></h3>
                            </div>
                            <hr>
                            <div class="plan-content">
                                <p><?php echo $warranty_d['description']; ?></p>
                            </div>
                            <div class="plan-footer all-cart-buttons ">
                                <span class="red-span"><?php echo CURR.$warranty_d['amount']; ?></span>
                                <form method="post" name="frm" id="frm" action="<?php echo SITEURL; ?>process-add-to-cart/">
                                    <input type="hidden" name="product_id" value="<?php echo $warranty_d['id']; ?>">
                                    <input type="hidden" name="qty" id="qty" value="1">
                                    <input type="hidden" name="product_type" id="product_type" value="w">
                                    <button class="button float-none" type="submit"><span>Add to Cart</span></button>
                                </form>
                                
                            </div>
                        </div>
                    <?php 
                    }
                }
             ?>
        </div>
        </div>
        <?php
        }
    }
    else
    {
    ?>
    <div class="cart-table table-responsive">
        <table class="cart-table-new">
            <thead>
                <tr>
                    <th class="p-image">Image</th>
                    <th class="p-name">Product Name</th>
                    <th class="p-amount">Unit Price</th>
                    <th class="p-quantity">Qty</th>
                    <th class="p-total">SubTotal</th>
                    <th class="p-edit">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr><td class="text-center" colspan="6">Your cart is empty.</td></tr>   
            </tbody>
        </table>
    </div> 
    <?php 
    }
} 
else 
{
?>
<div class="cart-table table-responsive">
    <table class="cart-table-new">
        <thead>
            <tr>
                <th class="p-image">Image</th>
                <th class="p-name">Product Name</th>
                <th class="p-amount">Unit Price</th>
                <th class="p-quantity">Qty</th>
                <th class="p-total">SubTotal</th>
                <th class="p-edit">Action</th>
            </tr>
        </thead>
        <tbody>
            <tr><td class="text-center" colspan="6">Your cart is empty.</td></tr>   
        </tbody>
    </table>
</div>   
<?php   
}
?>