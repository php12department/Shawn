<?php

include("connect.php");

$db->rpcheckAdminLogin();



$ctable             = "cartdetails";

$ctable1            = "Order";

$parent_page        = "order-master"; //for sidebar active menu

$main_page          = "manage-order"; //for sidebar active menu

$page_title         = "View ".$ctable1;

$manage_page_url    = ADMINURL."manage-order/";



if(isset($_REQUEST['id']) && $_REQUEST['id']>0)

{

    $cart_id    = $db->clean(trim($_REQUEST['id']))

    ;

    $where      = " cart_id='".$cart_id."' AND isDelete=0";

    $ctable_r   = $db->rpgetData($ctable,"*",$where);

    $ctable_d   = @mysqli_fetch_array($ctable_r);



    $orderdate          =   date("d-m-Y H:i A",strtotime($ctable_d['orderdate']));



    $fname              =   stripslashes($ctable_d['fname']);

    $lname              =   stripslashes($ctable_d['lname']);

    $email              =   stripslashes($ctable_d['email']);   

    $phone              =   stripslashes($ctable_d['phone']);

    $address            =   stripslashes($ctable_d['address1']);

    $zipcode            =   stripslashes($ctable_d['zip']);

    $city               =   stripslashes($ctable_d['city']);

    $state              =   stripslashes($ctable_d['state']);
    $state      = $db->rpgetValue("state","name","id='".$state."'");

    $country            =   stripslashes($ctable_d['country']);

    $country            =   $db->rpgetValue('country','name','id="'.$country.'"');

    $coupon_code        =   stripslashes($ctable_d['coupon_code']);

    $shipping_charge    =   $ctable_d['shipping_charge'];


    $payment_r  = $db->rpgetData("payment_history","*","cart_id='".$cart_id."'","cart_id desc");
    $payment_d  = @mysqli_fetch_array($payment_r);
}

else

{

    $db->rplocation($manage_page_url);

    exit;

}

?>

<!DOCTYPE html>

<html lang="en" >

    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />

    <head>

        <title><?php echo $page_title?> | <?php echo ADMINTITLE; ?></title>

        <?php include('include_css.php'); ?>

        <style type="text/css">

            @media print { 

               .noprint { 

                  visibility: hidden; 

               } 

            } 

            .kt_table_1 .btn.btn-icon.btn-icon-md [class*=" la-"], .btn.btn-icon.btn-icon-md [class^=la-] {

                font-size: 1.7rem!important;

            }

            .kt-invoice-1 .kt-invoice__head .kt-invoice__items .kt-invoice__item {
                
                color: #111;
            }

            .kt-invoice-1 .kt-invoice__head .kt-invoice__items .kt-invoice__item .kt-invoice__text {
                color: #111;
            }

            .kt-invoice-1 .kt-invoice__head .kt-invoice__brand .kt-invoice__logo .kt-invoice__desc {
                
                color: #111;
            }

        </style>

    </head>

    <!-- end::Head -->

    <!-- begin::Body -->

    <body  class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading"  >

        <!-- begin:: Page -->

        <!-- begin:: Header Mobile -->

        <?php include("header_mobile.php");?>

        <!-- end:: Header Mobile -->    

        <div class="kt-grid kt-grid--hor kt-grid--root">

            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">

                <!-- begin:: Aside -->

                <?php include("left.php"); ?>

                <!-- end:: Aside -->            

                <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">

                    <!-- begin:: Header -->

                    <?php include("header.php");?>

                    <!-- end:: Header -->

                    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

                        <!-- begin:: Subheader -->

                        <div class="kt-subheader  kt-grid__item noprint" id="kt_subheader">

                            <div class="kt-container  kt-container--fluid ">

                                <div class="kt-subheader__main">

                                    <h3 class="kt-subheader__title"><?php echo $page_title?></h3>

                                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>

                                </div>

                                <div class="kt-subheader__toolbar">

                                    <a href="javascript:void(0);" onClick="window.location.href='<?= $manage_page_url;?>'" class="btn btn-clean btn-icon-sm">

                                    <i class="la la-long-arrow-left"></i>

                                    Back

                                    </a>

                                </div>

                            </div>

                        </div>

                        <!-- end:: Subheader -->                    

                        <!-- begin:: Content -->

                        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

                            <div class="kt-portlet">

                                <div class="kt-portlet__body kt-portlet__body--fit">

                                    <div class="kt-invoice-1">

                                        <!-- <div class="kt-invoice__head" style="background: #1e1e2d;"> -->
                                            <div class="kt-invoice__head" style="background: #ffffff;">

                                            <div class="kt-invoice__container">

                                                <div class="kt-invoice__brand">

                                                    <h1 class="kt-invoice__title" style="color: #111;">INVOICE</h1>

                                                    <div href="#" class="kt-invoice__logo">

                                                        <a href="javascript:void(0);"><img width="150" src="<?= SITEURL?>common/images/logo.png"></a>

                                                        <span class="kt-invoice__desc">

                                                        <span><?= SITEADDRESS;?></span>

                                                        <span>Phone : <?= SITEPHONE;?></span>

                                                        <span>Email : <?= SITEMAIL;?></span>

                                                        </span>

                                                    </div>

                                                </div>

                                                <div class="kt-invoice__items">

                                                    <div class="kt-invoice__item">

                                                        <span class="kt-invoice__subtitle">Order Date</span>

                                                        <span class="kt-invoice__text"><?= $orderdate;?></span>

                                                    </div>

                                                    <div class="kt-invoice__item">

                                                        <span class="kt-invoice__subtitle">INVOICE NO.</span>

                                                        <span class="kt-invoice__text"><?=$cart_id;?></span>

                                                    </div>

                                                    <div class="kt-invoice__item">

                                                        <span class="kt-invoice__subtitle">INVOICE TO.</span>

                                                        <span class="kt-invoice__text">

                                                            <?= $fname." ".$lname;?><br>

                                                            <?= $address;?><br>

                                                            <?= $city.", ".$state.", ".$country.", ".$zipcode;?><br>

                                                            Phone : <?= $phone;?><br>

                                                            Email : <?= $email;?><br>

                                                            <?php
                                                            if($payment_d['payment_type'] == 2)
                                                            {
                                                            ?>
                                                            Payment Method : Stripe<br>
                                                            Transaction ID : <?php echo $payment_d['stripe_transaction_id']; ?><br>
                                                            Charge ID : <?php echo $payment_d['stripe_charge_id']; ?><br>
                                                            <?php
                                                            }
                                                            else
                                                            {
                                                            ?>
                                                            Payment Method : Paypal<br>
                                                            Transaction ID : <?php echo $payment_d['txn_id']; ?><br>
                                                            <?php
                                                            }
                                                            ?>
                                                        </span>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="kt-invoice__body">

                                            <div class="kt-invoice__container">

                                                <div class="table-responsive">

                                                    <table class="table">

                                                        <thead>

                                                            <tr>

                                                                <th class="text-center">No</th>

                                                                <th class="text-center">Image</th>

                                                                <th class="text-center">Product Name</th>

                                                                <th>Unit Price</th>

                                                                <th>Qty</th>

                                                                <th>Sub Total</th>

                                                            </tr>

                                                        </thead>

                                                        <tbody>

                                                            <?php

                                                            $count = 1;

                                                            $shop_cart_r = $db->rpgetData("cartitems","*","cart_id='".$cart_id."'");

                                                            $discount       = 0;

                                                            $sub_total      = 0;

                                                            $total_ship_charge= 0;

                                                            while($shop_cart_d = mysqli_fetch_array($shop_cart_r))

                                                            {

                                                                

                                                                $id   = $shop_cart_d['id'];

                                                                $pid  = $shop_cart_d['pid'];

                                                                $qty  = $shop_cart_d['qty'];



                                                                $unitprice  = $db->rpnum($shop_cart_d['unitprice']);

                                                                $totalprice = $db->rpnum($shop_cart_d['totalprice']);

                                                                $finalprice = $db->rpnum($shop_cart_d['finalprice']);

                                                                $total_disc = $db->rpnum($shop_cart_d['total_discount']);

                                                                $final_discount_amount +=   $total_discount;

                                                                $discount   += $shop_cart_d['discount'];

                                                                $sub_total  += $finalprice;

                                                                

                                                                $dis_discount_desc      = ($shop_cart_d['discount_desc']) ? "<p><small>(".$shop_cart_d['discount_desc'].")</small></p>" : "";



                                                                 if ($shop_cart_d['product_type']=="w") {



                                                                    $pro_name           = $db->rpgetValue("warranty","title","id='".$pid."'");; 

                                                                    $pro_thumb_url      = SITEURL."images/warranty.jpg";

                                                                    $pro_details_url    = "javascript:;";

                                                                    $pro_title       = $pro_name;

                                                                }else{

                                                                    $pro_name = $db->rpgetValue("product","name","id='".$pid."'");



                                                                    $pro_cate_name = $db->rpgetValue("category","name","id='".$shop_cart_d['cate_id']."'");

                                                                    $pro_sub_cate_name = $db->rpgetValue("sub_category","name","id='".$shop_cart_d['sub_cate_id']."'");

                                                                    $image_path = $db->rpgetValue("product","image","id='".$pid."'");



                                                                    if(!empty($image_path))

                                                                    {

                                                                        $pro_thumb_url = SITEURL.PRODUCT_THUMB_F.$image_path;

                                                                    }

                                                                    else

                                                                    {

                                                                        $pro_thumb_url = SITEURL."common/images/no_image.png";

                                                                    }

                                                                    $pro_title = $pro_d['name']."</div>

                                                                        <div>".$pro_cate_name." >> ".$pro_sub_cate_name;

                                                                }

                                                                ?>

                                                                <tr>

                                                                    <th class="text-center"><?php echo $count;?></th>

                                                                    <td class="text-center">

                                                                        <img src="<?php echo $pro_thumb_url; ?>" alt="<?php echo $pro_name;?>" style="width: 100px; height: auto;">

                                                                    </td>

                                                                    <td class="text-center">    

                                                                        <div><?php echo $pro_title; ?></div>

                                                                    </td>

                                                                    <td>

                                                                        <?php echo CURR.$unitprice."".$dis_discount_desc; ?>

                                                                    </td>

                                                                    <td>

                                                                        <label><?php echo $qty; ?></label>

                                                                    </td>

                                                                    <td>

                                                                        <span class="cart-price"> 

                                                                            <span class="old-price">

                                                                                <?php echo CURR.$finalprice; ?>

                                                                            </span> 

                                                                        </span>

                                                                    </td>

                                                                </tr>

                                                            <?php

                                                            $count++;

                                                            }

                                                            

                                                            $final_discount_amount = 0;

                            

                                                            $sub_total = $db->rpnum($sub_total);

                                                            $shipping_charge = $db->rpnum($shipping_charge);

                                                            $final_total = $db->rpnum(($sub_total + $shipping_charge + $ctable_d['tax_amount']) - $final_discount_amount - $discount);



                                                            $dis_total_discount = $db->rpgetValue("cartdetails","total_discount","cart_id='".$cart_id."'");

                                                            ?>

                                                        </tbody>

                                                    </table>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="kt-invoice__footer">

                                            <div class="kt-invoice__container">

                                                <div class="kt-invoice__bank">

                                                </div>

                                                <div class="kt-invoice__total">

                                                    <div class="kt-invoice-in-one-line">

                                                        <span class="kt-invoice__title">Subtotal </span>

                                                        <span class="kt-invoice__price"><?php echo CURR.$sub_total; ?></span>

                                                    </div>

                                                    <div class="kt-invoice-in-one-line">

                                                        <span class="kt-invoice__title">Discount(-) <?php if( $coupon_code != "" ) echo '<span style="color: #345498">(' . $coupon_code .')</span>'; ?></span>

                                                        <span class="kt-invoice__price"><?php echo CURR.$dis_total_discount; ?></span>

                                                    </div>

                                                    <div class="kt-invoice-in-one-line">

                                                        <span class="kt-invoice__title">Shipping Charges(+) </span>

                                                        <span class="kt-invoice__price"><?php echo CURR.$shipping_charge; ?></span>

                                                    </div>

                                                    <?php 
                                                    if($ctable_d['tax_amount']!=0)
                                                    {
                                                    ?>
                                                    <div class="kt-invoice-in-one-line">

                                                        <span class="kt-invoice__title">Tax Amount(+) </span>

                                                        <span class="kt-invoice__price"><?php echo CURR . $db->rpnum($ctable_d['tax_amount']); ?> (<?=$ctable_d['tax_percentage'];?>%)</span>

                                                    </div>
                                                    <?php 
                                                    }
                                                    ?>

                                                    <div class="kt-invoice-in-one-line">

                                                        <span class="kt-invoice__title">TOTAL </span>

                                                        <span class="kt-invoice__price"><?php echo CURR.$final_total; ?></span>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="kt-invoice__actions">

                                            <div class="kt-invoice__container">

                                                <!-- <button type="button" class="btn btn-label-brand btn-bold" onclick="window.print();">Download Invoice</button> -->

                                                <button type="button" class="btn btn-brand btn-bold" onclick="window.print();">Print Invoice</button>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <!-- end:: Content -->              

                    </div>

                    <!-- begin:: Footer -->

                    <?php include("footer.php"); ?>

                    <!-- end:: Footer -->           

                </div>

            </div>

        </div>

        <!-- end:: Page -->

        <?php include('include_js.php'); ?>

        <script type="text/javascript">

            

        </script>

    </body>

</html>