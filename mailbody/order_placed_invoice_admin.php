<?php
include("../connect.php");

if($payment_d['payment_type'] == 2)
{
    $dis_tran_id = '<td style="border:1px solid #e9ecef;padding:.75rem;vertical-align:top;border-top:1px solid #e9ecef;">
                    <span style="color: #868e96!important;">'.$payment_d['stripe_transaction_id'].'</span>
                </td>';
}
else
{
    $dis_tran_id = '<td style="border:1px solid #e9ecef;padding:.75rem;vertical-align:top;border-top:1px solid #e9ecef;">
                    <span style="color: #868e96!important;">'.$payment_d['txn_id'].'</span>
                </td>';
}

$country_name = $db->rpgetValue("country","name"," id='".$cartdetails_d['country']."' ");
$state_name = $db->rpgetValue("state","name"," id='".$cartdetails_d['state']."' ");

$body_admin = '
<table style="border: 1px solid #ddd;width: 100%; max-width: 100%; margin-bottom: 20px; background-color: transparent;border-spacing: 0; border-collapse: collapse; box-sizing: border-box;">
        <tbody style="color: #444444; font-size: 13px; font-style: normal; font-weight: 400; line-height: 1.53846; text-align: left;">
            <tr>
                <td style="border:1px solid #e9ecef;padding:.75rem;vertical-align:top;border-top:1px solid #e9ecef;background-color: #F9F9F9;" >Full Name</td>
                <td style="border:1px solid #e9ecef;padding:.75rem;vertical-align:top;border-top:1px solid #e9ecef;background-color: #F9F9F9;">
                    <span style="color: #868e96!important;">'.ucwords($cartdetails_d['fname']." ".$cartdetails_d['lname']).'</span>
                </td>
                <td style="border:1px solid #e9ecef;padding:.75rem;vertical-align:top;border-top:1px solid #e9ecef;background-color: #F9F9F9;">Order Date</td>
                <td style="border:1px solid #e9ecef;padding:.75rem;vertical-align:top;border-top:1px solid #e9ecef;background-color: #F9F9F9;">
                    <span style="color: #868e96!important;">'.date("M d, Y h:i A",strtotime($cartdetails_d['orderdate'])).'</span>
                </td>
            </tr>
            <tr>
                <td style="border:1px solid #e9ecef;padding:.75rem;vertical-align:top;border-top:1px solid #e9ecef;"> Order Number </td>
                <td style="border:1px solid #e9ecef;padding:.75rem;vertical-align:top;border-top:1px solid #e9ecef;" colspan="1">
                    <span style="color: #868e96!important;">'."#".$cartdetails_d['cart_id'].'</span>
                </td>
                <td style="border:1px solid #e9ecef;padding:.75rem;vertical-align:top;border-top:1px solid #e9ecef;"> Transaction ID </td>
                '.$dis_tran_id.'
            </tr>
             <tr>
                <td style="border:1px solid #e9ecef;padding:.75rem;vertical-align:top;border-top:1px solid #e9ecef;background-color: #F9F9F9;">Order Status</td>
                <td style="border:1px solid #e9ecef;padding:.75rem;vertical-align:top;border-top:1px solid #e9ecef; background-color: #F9F9F9;"><span style="display: inline-block; min-width: 10px; padding: 3px 7px; font-size: 12px;font-weight: 700;line-height: 1; color: #fff; text-align: center; white-space: nowrap; vertical-align: middle; background-color: #777; border-radius: 10px;">'.$db->order_status_arr($cartdetails_d['orderstatus']).'</span></td>
                <td style="border:1px solid #e9ecef;padding:.75rem;vertical-align:top;border-top:1px solid #e9ecef; background-color: #F9F9F9;"> Payment Status</td>';
                if($payment_d['payment_status'] == 1) $pstatus = 'Completed'; else $pstatus = 'In Process';  
                $body_admin  .='<td style="border:1px solid #e9ecef;padding:.75rem;vertical-align:top;border-top:1px solid #e9ecef; background-color: #F9F9F9;">
                    <span style="display: inline-block; min-width: 10px; padding: 3px 7px; font-size: 12px;font-weight: 700;line-height: 1; color: #fff; text-align: center; white-space: nowrap; vertical-align: middle; background-color: #777; border-radius: 10px;">'.$pstatus.' </span>
                </td>
            </tr>
            <tr>
                <td style="border:1px solid #e9ecef;padding:.75rem;vertical-align:top;border-top:1px solid #e9ecef;">Shipping Address</td>
                <td style="border:1px solid #e9ecef;padding:.75rem;vertical-align:top;border-top:1px solid #e9ecef;" colspan="3">
                    <span style="color: #868e96!important;">
                        '.$cartdetails_d['address1'].'
                    </span>
                </td>
            </tr>
            <tr>
                <td style="border:1px solid #e9ecef;padding:.75rem;vertical-align:top;border-top:1px solid #e9ecef; background-color: #F9F9F9;"> Phone </td>
                <td style="border:1px solid #e9ecef;padding:.75rem;vertical-align:top;border-top:1px solid #e9ecef; background-color: #F9F9F9;">
                    <span style="color: #868e96!important;">'.$cartdetails_d['phone'].'</span>
                </td>
                <td style="border:1px solid #e9ecef;padding:.75rem;vertical-align:top;border-top:1px solid #e9ecef; background-color: #F9F9F9;"> Email </td>
                <td style="border:1px solid #e9ecef;padding:.75rem;vertical-align:top;border-top:1px solid #e9ecef; background-color: #F9F9F9;">
                    <span style="color: #868e96!important;">'.$cartdetails_d['email'].'</span>
                </td>
            </tr>
            <tr>
                <td style="border:1px solid #e9ecef;padding:.75rem;vertical-align:top;border-top:1px solid #e9ecef;" > City </td>
                <td style="border:1px solid #e9ecef;padding:.75rem;vertical-align:top;border-top:1px solid #e9ecef;">
                    <span style="color: #868e96!important;">'.$cartdetails_d['city'].'</span>
                </td>
                <td style="border:1px solid #e9ecef;padding:.75rem;vertical-align:top;border-top:1px solid #e9ecef;" > Country </td>
                <td style="border:1px solid #e9ecef;padding:.75rem;vertical-align:top;border-top:1px solid #e9ecef;" >
                    <span style="color: #868e96!important;">'.$country_name.'</span>
                </td>
            </tr>
            <tr>
                <td style="border:1px solid #e9ecef;padding:.75rem;vertical-align:top;border-top:1px solid #e9ecef; background-color: #F9F9F9;"> State/Province </td>
                <td style="border:1px solid #e9ecef;padding:.75rem;vertical-align:top;border-top:1px solid #e9ecef; background-color: #F9F9F9;">
                    <span style="color: #868e96!important;"> '.$state_name.'</span>
                </td>
                <td style="border:1px solid #e9ecef;padding:.75rem;vertical-align:top;border-top:1px solid #e9ecef; background-color: #F9F9F9;"> Zip/Postal Code </td>
                <td style="border:1px solid #e9ecef;padding:.75rem;vertical-align:top;border-top:1px solid #e9ecef; background-color: #F9F9F9;">
                    <span style="color: #868e96!important;">'.$cartdetails_d['zip'].'</span>
                </td>
            </tr>
        </tbody>
    </table>

    <table style="border: 1px solid #ddd; width: 100%; max-width: 100%; margin-bottom: 20px; background-color: transparent; border-spacing: 0; border-collapse: collapse; box-sizing: border-box;">
        <thead>
            <tr>
                <th style="width: 150px;border-bottom: 1px solid #f2f2f2; border-right: 1px solid #f2f2f2; color: #252531; font-size: 14px; letter-spacing: 0.3px; padding: 20px 10px; text-align: center; text-transform: uppercase; word-break: normal; white-space: nowrap;">Image</th>
                <th style="border-bottom: 1px solid #f2f2f2; border-right: 1px solid #f2f2f2; color: #252531; font-size: 14px; letter-spacing: 0.3px; padding: 20px 10px; text-align: center; text-transform: uppercase; word-break: normal; white-space: nowrap;"><span>Product</span></th>
                <th style="border-bottom: 1px solid #f2f2f2; border-right: 1px solid #f2f2f2; color: #252531; font-size: 14px; letter-spacing: 0.3px; padding: 20px 10px; text-align: center; text-transform: uppercase; word-break: normal; white-space: nowrap; color: #252531;"><span> Qty </span></th>
                <th style="border-bottom: 1px solid #f2f2f2; border-right: 1px solid #f2f2f2; color: #252531; font-size: 14px; letter-spacing: 0.3px; padding: 20px 10px; text-align: center; text-transform: uppercase; word-break: normal; white-space: nowrap; color: #252531;"><span> Unit Price </span></th>
                <th style="border-bottom: 1px solid #f2f2f2; border-right: 1px solid #f2f2f2; color: #252531; font-size: 14px; letter-spacing: 0.3px; padding: 20px 10px; text-align: center; text-transform: uppercase; word-break: normal; white-space: nowrap; color: #252531;"><span> Sub Total </span></th>
            </tr>
        </thead>
        <tbody>';
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


                $totalprice =   $db->rpnum($cart_d['totalprice']);
                $finalprice =   $db->rpnum($cart_d['finalprice']);
                $sub_total  += $finalprice;

                if ($cart_d['product_type']=="w") {
                    $pro_r = $db->rpgetData("warranty","*","id='".$cart_d['pid']."' AND isDelete=0");
                    $pro_no = @mysqli_num_rows($pro_r);
                    $pro_d  = @mysqli_fetch_array($pro_r);
                    $pro_details_url = "javascript:;";
                    $img_path        = SITEURL."images/warranty.jpg";
                    $pro_name        = $pro_d['title'];
                    $pro_title       = $pro_d['title'];
                }else{
                    $pro_r = $db->rpgetData("product","*"," id='".$cart_d['pid']."' AND isDelete=0 ");
                    $pro_no = mysqli_num_rows($pro_r);
                    $pro_d = mysqli_fetch_array($pro_r);

                    $pro_cate_name = $db->rpgetValue("category","name","id='".$cart_d['cate_id']."'");
                    $pro_sub_cate_name = $db->rpgetValue("sub_category","name","id='".$cart_d['sub_cate_id']."'");

                    $pro_cate_slug = $db->rpgetValue("category","slug"," id='".$cart_d['cate_id']."' ");
                    $pro_sub_cate_slug = $db->rpgetValue("sub_category","slug"," id='".$cart_d['sub_cate_id']."' ");

                    $pro_details_url = SITEURL."product/".$pro_cate_slug."/".$pro_d['slug']."/";
                    if($sub_cate_id!=0 && $sub_cate_id!="")
                    {
                        $pro_details_url = SITEURL."product/".$pro_cate_slug."/".$pro_sub_cate_slug."/".$pro_d['slug']."/";
                    }
                    $folder = PRODUCT_THUMB_F;
                    
                    if($pro_d['image']!="" && file_exists($folder.$pro_d['image']))
                    {
                        $img_path = SITEURL.$folder.$pro_d['image'];
                    }
                    else
                    {
                            $img_path =SITEURL."common/images/no_image.png";
                    }

                    $pro_name       = $pro_d['name'];
                    $pro_title      = $pro_d['name']."<br>".$pro_cate_name." >> ".$pro_sub_cate_name;
                }

                 
            
            $body_admin .= '<tr>
                <td style="border-bottom: 1px solid #f2f2f2;border-right: 1px solid #f2f2f2; color: #252531; font-size: 14px; letter-spacing: 0.3px; padding: 20px 10px; text-align: center; text-transform: uppercase; word-break: normal; white-space: nowrap;">
                   <img src="'.$img_path.'" alt="'.$pro_name.'" style="width: 100px; height: auto;" />
                </td>
                <td style="border-bottom: 1px solid #f2f2f2;border-right: 1px solid #f2f2f2; color: #252531; font-size: 14px; letter-spacing: 0.3px; padding: 20px 10px; text-align: center; text-transform: uppercase; word-break: normal; white-space: nowrap;">
                    <a href="'.$pro_details_url.'">
                        '.$pro_title.'
                    </a>
                </td>
                <td style="color: #252531;border-bottom: 1px solid #f2f2f2;border-right: 1px solid #f2f2f2; color: #252531; font-size: 14px; letter-spacing: 0.3px; padding: 20px 10px; text-align: center; text-transform: uppercase; word-break: normal; white-space: nowrap;"><span style="    padding: 0;margin: 5px auto;">'.$cart_d['qty'].'</span></td>
                <td style="color: #252531;border-bottom: 1px solid #f2f2f2;border-right: 1px solid #f2f2f2; color: #252531; font-size: 14px; letter-spacing: 0.3px; padding: 20px 10px; text-align: center; text-transform: uppercase; word-break: normal; white-space: nowrap;"><span style="    padding: 0;margin: 5px auto;">$'.$db->rpnum($cart_d['unitprice']).'</span>'.$dis_discount_desc.'</td>
                <td style="color: #252531;border-bottom: 1px solid #f2f2f2;border-right: 1px solid #f2f2f2; color: #252531; font-size: 14px; letter-spacing: 0.3px; padding: 20px 10px; text-align: center; text-transform: uppercase; word-break: normal; white-space: nowrap;"><span style="    padding: 0;margin: 5px auto;">$'. $db->rpnum($cart_d['finalprice']).'</span></td>
            </tr>';
            $i++;
            } 
            $coupon_code_type = $cartdetails_d['coupon_type'];
            $sub_total = $db->rpnum($sub_total);
             if( $coupon_code != "" ) $ccode ="(".$coupon_code.")"; 
            $body_admin .='<tr>
                <td colspan="4" style="border-bottom: 1px solid #f2f2f2; border-right: 1px solid #f2f2f2; color: #252531; font-size: 14px; letter-spacing: 0.3px; padding: 20px 10px; text-align: center; text-transform: uppercase; word-break: normal; white-space: nowrap;text-align: right!important;"><strong>Sub Total</strong></td>
                <td style="border-bottom: 1px solid #f2f2f2; border-right: 1px solid #f2f2f2; color: #252531; font-size: 14px; letter-spacing: 0.3px; padding: 20px 10px; text-align: center; text-transform: uppercase; word-break: normal; white-space: nowrap;"><strong style="font-weight: 700;">$'.$sub_total.'</strong></td>
            </tr>
            <tr>
                <td colspan="4" style="border-bottom: 1px solid #f2f2f2; border-right: 1px solid #f2f2f2; color: #252531; font-size: 14px; letter-spacing: 0.3px; padding: 20px 10px; text-align: center; text-transform: uppercase; word-break: normal; white-space: nowrap;text-align: right!important;"><strong>Discount(-)<br><span style="color:#345498">'.$ccode.'</span></strong></td>
                <td style="border-bottom: 1px solid #f2f2f2; border-right: 1px solid #f2f2f2; color: #252531; font-size: 14px; letter-spacing: 0.3px; padding: 20px 10px; text-align: center; text-transform: uppercase; word-break: normal; white-space: nowrap;"><strong>$'.$db->rpnum($cartdetails_d['total_discount']).'</strong></td>
            </tr>
            <tr>
                <td colspan="4" style="border-bottom: 1px solid #f2f2f2; border-right: 1px solid #f2f2f2; color: #252531; font-size: 14px; letter-spacing: 0.3px; padding: 20px 10px; text-align: center; text-transform: uppercase; word-break: normal; white-space: nowrap;text-align: right!important;"><strong>Shipping Charges(+)<br></strong></td>
                <td style="border-bottom: 1px solid #f2f2f2; border-right: 1px solid #f2f2f2; color: #252531; font-size: 14px; letter-spacing: 0.3px; padding: 20px 10px; text-align: center; text-transform: uppercase; word-break: normal; white-space: nowrap;"><strong>$'.$db->rpnum($cartdetails_d['shipping_charge']).'</strong></td>
            </tr>';

            if($cartdetails_d['tax_amount']!=0)
            {
                $body .='<tr>
                    <td colspan="4" style="border-bottom: 1px solid #f2f2f2; border-right: 1px solid #f2f2f2; color: #252531; font-size: 14px; letter-spacing: 0.3px; padding: 20px 10px; text-align: center; text-transform: uppercase; word-break: normal; white-space: nowrap;text-align: right!important;"><strong>Tax Amount(+)<br></strong></td>
                    <td style="border-bottom: 1px solid #f2f2f2; border-right: 1px solid #f2f2f2; color: #252531; font-size: 14px; letter-spacing: 0.3px; padding: 20px 10px; text-align: center; text-transform: uppercase; word-break: normal; white-space: nowrap;"><strong>$'.$db->rpnum($cartdetails_d['tax_amount']).' ('.$cartdetails_d['tax_percentage'].'%)</strong></td>
                </tr>';
            }
            
            $body .='<tr>
                <td colspan="4" style="border-bottom: 1px solid #f2f2f2; border-right: 1px solid #f2f2f2; color: #252531; font-size: 14px; letter-spacing: 0.3px; padding: 20px 10px; text-align: center; text-transform: uppercase; word-break: normal; white-space: nowrap;text-align: right!important;"><strong>Total</strong></td>
                <td style="border-bottom: 1px solid #f2f2f2; border-right: 1px solid #f2f2f2; color: #252531; font-size: 14px; letter-spacing: 0.3px; padding: 20px 10px; text-align: center; text-transform: uppercase; word-break: normal; white-space: nowrap;"><strong>$'.$db->rpnum($cartdetails_d['finaltotal']).'</strong></td>
             </tr>
        </tbody>
    </table>';
?>