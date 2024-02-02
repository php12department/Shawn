<?php

include('connect.php'); 

$db->rpcheckLogin();

$current_page = "Order Details";



$cart_id = $_REQUEST['cart_id'];



$uid =  $_SESSION[SESS_PRE.'_SESS_USER_ID'] ; 



$cartdetails_q = $db->rpgetData("cartdetails","*"," md5(cart_id)='".$cart_id."' AND orderstatus!='1' ");



if(@mysqli_num_rows($cartdetails_q) > 0) 

{

  $cartdetails_d = mysqli_fetch_array($cartdetails_q);
  $state = $cartdetails_d['state'];
  $state      = $db->rpgetValue("state","name","id='".$state."'");

} 

else 

{

    $db->rplocation(SITEURL);

} 



$payment_r  = $db->rpgetData("payment_history","*","md5(cart_id)='".$cart_id."' AND user_id='".$uid."'","cart_id desc");

$payment_d  = @mysqli_fetch_array($payment_r);

?>

<!doctype html>

<html class="no-js" lang="en">

<head>

    <title><?=$current_page;?> | <?php echo SITETITLE; ?></title>

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

    <!-- Account Area Start -->

    <div class="my-account-area ptb-80">

        <div class="container">

            <div class="row">

                <div class="col-lg-12 col-md-12 col-12">

                    <div class="wishlist-area">

                        <div class="container">

                            <div class="wishlist-content">

                                <div class="table-responsive">

                                    <table class="table table-bordered table-striped">

                                        <tbody>

                                            <tr>

                                                <td>Full Name</td>

                                                <td>

                                                    <span class="text-muted"><?php echo ucwords($cartdetails_d['fname']." ".$cartdetails_d['lname']); ?></span>

                                                </td>

                                                <td>Order Date</td>

                                                <td>

                                                    <span class="text-muted"><?php echo $db->rpDate($cartdetails_d['orderdate'], "M d, Y h:i A"); ?></span>

                                                </td>

                                            </tr>

                                            <tr>

                                                <td> Order Number </td>

                                                <td colspan="1">

                                                    <span class="text-muted"><?="#".$cartdetails_d['cart_id'];?></span>

                                                </td>

                                                <td> Transaction ID </td>

                                                <td>
                                                    <?php
                                                    if($payment_d['payment_type'] == 2)
                                                    {
                                                    ?>
                                                    <span class="text-muted"><?php echo $payment_d['stripe_transaction_id']; ?></span>
                                                    <?php
                                                    }
                                                    else
                                                    {
                                                    ?>
                                                    <span class="text-muted"><?php echo $payment_d['txn_id']; ?></span>
                                                    <?php
                                                    }
                                                    ?>
                                                    

                                                </td>

                                            </tr>

                                            <tr>

                                                <td>Order Status</td>

                                                <td><span class="badge"><?php echo $db->order_status_arr($cartdetails_d['orderstatus']);?></span></td>

                                                <td> Payment Status</td>

                                                <td>

                                                    <span class="badge">

                                                    <?php 

                                                    if($payment_d['payment_status'] == 1) echo 'Completed'; else echo 'In Process'; 

                                                    ?></span>

                                                </td>

                                            </tr>

                                            <tr>

                                                <td>Shipping Address</td>

                                                <td colspan="3">

                                                    <span class="text-muted">

                                                        <?php echo $cartdetails_d['address1']; ?>

                                                    </span>

                                                </td>

                                            </tr>

                                            <tr>

                                                <td> Phone </td>

                                                <td>

                                                    <span class="text-muted"><?php echo $cartdetails_d['phone']; ?></span>

                                                </td>

                                                <td> Email </td>

                                                <td>

                                                    <span class="text-muted"><?php echo $cartdetails_d['email']; ?></span>

                                                </td>

                                            </tr>

                                            <tr>

                                                <td> City </td>

                                                <td>

                                                    <span class="text-muted"><?php echo $cartdetails_d['city']; ?></span>

                                                </td>

                                                <td> Country </td>

                                                <td>

                                                    <span class="text-muted"> <?php echo $db->rpgetValue("country","name"," id='".$cartdetails_d['country']."' ") ?></span>

                                                </td>

                                            </tr>

                                            <tr>

                                                <td> State/Province </td>

                                                <td>

                                                    <span class="text-muted"> <?php echo $state; ?></span>

                                                </td>

                                                <td> Zip/Postal Code </td>

                                                <td>

                                                    <span class="text-muted"><?php echo $cartdetails_d['zip']; ?></span>

                                                </td>

                                            </tr>

                                        </tbody>

                                    </table>

                                </div>



                                <div class="wishlist-table table-responsive">

                                    <table>

                                        <thead>

                                            <tr>

                                                <th class="product-thumbnail">Image</th>

                                                <th class="product-name"><span>Product</span></th>

                                                <th class="w-c-price"><span> Qty </span></th>

                                                <th class="w-c-price"><span> Unit Price </span></th>

                                                <th class="w-c-price"><span> Sub Total </span></th>

                                            </tr>

                                        </thead>

                                        <tbody>

                                            <?php

                                            $shipping_charge    = $cartdetails_d['shipping_charge'];

                                            $coupon_code        = $cartdetails_d['coupon_code'];

                                            $sub_total          = 0;

                                            $total_discount     = 0;

                                            $grand_total        = 0;         

                                            $i = 1;

                                            $cart_r = $db->rpgetData("cartitems","*"," cart_id='".$cartdetails_d['cart_id']."' ");

                                            $cart_no = @mysqli_num_rows($cart_r);

                                            while($cart_d = @mysqli_fetch_array($cart_r))

                                            {

                                                $dis_discount_desc  = ($cart_d['discount_desc']) ? "<p style='text-transform: none;'><small>(".$cart_d['discount_desc'].")</small></p>" : "";



                                               



                                                if ($cart_d['product_type']=="w") {

						                            $pro_r = $db->rpgetData("warranty","*","id='".$cart_d['pid']."' AND isDelete=0");

						                            $pro_no = @mysqli_num_rows($pro_r);

                                                	$pro_d  = @mysqli_fetch_array($pro_r);

                                                	$pro_details_url = "javascript:;";

                                                	$pro_image       = SITEURL."images/warranty.jpg";

                                                	$pro_title 		 = $pro_d['title'];

						                        }else{

						                            $pro_r = $db->rpgetData("product","*"," id='".$cart_d['pid']."' AND isDelete=0 ");

	                                                $pro_no = @mysqli_num_rows($pro_r);

	                                                $pro_d  = @mysqli_fetch_array($pro_r);



	                                                $pro_cate_name = $db->rpgetValue("category","name","id='".$cart_d['cate_id']."'");

	                                                $pro_sub_cate_name = $db->rpgetValue("sub_category","name","id='".$cart_d['sub_cate_id']."'");



	                                                $pro_cate_slug = $db->rpgetValue("category","slug"," id='".$cart_d['cate_id']."' ");

	                                                $pro_sub_cate_slug = $db->rpgetValue("sub_category","slug"," id='".$cart_d['sub_cate_id']."' ");



	                                                $pro_details_url = SITEURL."product/".$pro_cate_slug."/".$pro_d['slug']."/";

	                                                if($sub_cate_id!=0 && $sub_cate_id!="")

	                                                {

	                                                    $pro_details_url = SITEURL."product/".$pro_cate_slug."/".$pro_sub_cate_slug."/".$pro_d['slug']."/";

	                                                }



	                                                if($pro_d['image']!='')

                                                    {

                                                    	$pro_image = SITEURL.PRODUCT_THUMB_F.$pro_d['image'];

                                                    }else{

                                                    	$pro_image = SITEURL."images/no_image.png";

                                                    }



                                                    $pro_title = $pro_d['name']."<br>".$pro_cate_name." >> ".$pro_sub_cate_name;

						                        }



                                                $totalprice =   $db->rpnum($cart_d['totalprice']);

                                                $finalprice =   $db->rpnum($cart_d['finalprice']);

                                                $sub_total  +=  $finalprice;

                                                

                                            ?>

                                            <tr>

                                                <td class="product-thumbnail">

                                                    <img src="<?php echo $pro_image; ?>" alt="<?php echo $pro_d['name'];?>" style="width: 100px; height: auto;">

                                                </td>

                                                <td class="product-name">

                                                    <a href="<?=$pro_details_url;?>">

                                                        <?php echo $pro_title; ?>

                                                    </a>

                                                </td>

                                                <td class="w-c-price"><span class="amount"><?php echo $cart_d['qty']; ?></span></td>

                                                <td class="w-c-price"><span class="amount"><?php echo CURR . $db->rpnum($cart_d['unitprice']); ?></span><?=$dis_discount_desc;?></td>

                                                <td class="w-c-price"><span class="amount"><?php echo CURR . $db->rpnum($cart_d['finalprice']); ?></span></td>

                                            </tr>

                                            <?php 

                                            $i++;

                                            } 

                                            $coupon_code_type = $cartdetails_d['coupon_type'];

                                            $sub_total = $db->rpnum($sub_total);

                                            ?>

                                            <tr>

                                                <td colspan="4" class="text-right"><strong>Sub Total</strong></td>

                                                <td><strong><?php echo CURR.$sub_total; ?></strong></td>

                                            </tr>

                                            <tr>

                                                <td colspan="4" class="text-right"><strong>Discount(-)<br><?php if( $coupon_code != "" ) echo '<span style="color: #345498">(' . $coupon_code .')</span>'; ?></strong></td>

                                                <td><strong><?php echo CURR . $db->rpnum($cartdetails_d['total_discount']); ?></strong></td>

                                            </tr>

                                            <tr>

                                                <td colspan="4" class="text-right"><strong>Shipping Charges(+)</strong></td>

                                                <td><strong><?php echo CURR . $db->rpnum($shipping_charge); ?></strong></td>

                                            </tr>
                                            <?php 
                                            if($cartdetails_d['tax_amount']!=0)
                                            {
                                            ?>
                                            <tr>

                                                <td colspan="4" class="text-right"><strong>Tax Amount(+)</strong></td>

                                                <td><strong><?php echo CURR . $db->rpnum($cartdetails_d['tax_amount']); ?> (<?=$cartdetails_d['tax_percentage'];?>%)</strong></td>

                                            </tr>
                                            <?php 
                                            }
                                            ?>
                                            <tr>

                                                <td colspan="4" class="text-right"><strong>Total</strong></td>

                                                <td><strong><?php echo CURR . $db->rpnum($cartdetails_d['finaltotal']); ?></strong></td>

                                             </tr>

                                        </tbody>

                                    </table>

                                </div> 

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Account Area End -->



    <!-- Footer Area Start -->

    <?php include('include_footer.php'); ?>

    <!-- Footer Area End -->



    <!-- all js here -->

    <?php include('include_js.php'); ?>

    <script type="text/javascript">

        

    </script>

</body>



</html>