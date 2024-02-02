<?php
include('connect.php'); 
// $db->rpcheckLogin();
$current_page = "Checkout";

if(!isset($_SESSION[SESS_PRE.'_SESS_CART_ID']))
{
    $db->rplocation(SITEURL."shopping-cart/");
}

$fname      = "";
$lname      = "";
$email      = "";
$phone      = "";
$address    = "";
$zip        = "";
$country    = "";
$state      = "";
$city       = "";
$uid     = ($_SESSION[SESS_PRE.'_SESS_USER_ID'])?$_SESSION[SESS_PRE.'_SESS_USER_ID']:0;

if(isset($uid) && $uid!="")
{
    $where  = " id='".$_SESSION[SESS_PRE.'_SESS_USER_ID']."' AND isDelete=0";
    
    $ctable_r   = $db->rpgetData("user","*",$where);
    $ctable_d   = @mysqli_fetch_array($ctable_r);

    $fname      = htmlentities($ctable_d['first_name']);
    $lname      = htmlentities($ctable_d['last_name']);
    $email      = htmlentities($ctable_d['email']);
    $phone      = htmlentities($ctable_d['phone']);
    $address    = htmlentities($ctable_d['address']);
    $zipcode    = stripslashes($ctable_d['zipcode']);
    $country    = stripslashes($ctable_d['country']);
    $state      = htmlentities($ctable_d['state']);
    $city       = htmlentities($ctable_d['city']);
}
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
        <title><?=$current_page;?> | <?php echo SITETITLE; ?></title>
        <?php include('include_css.php'); ?>
</head>

<body>
        <!-- Header Area Start -->
        <?php include('include_header.php'); ?>
        <!-- Header Area End -->

        <!-- Breadcrumb Area Start -->
        <?php include('include_breadcrumb_area.php'); ?>
        <!-- Breadcrumb Area End -->
        
        <!-- Checkout Area Start -->
        <div class="checkout-area pt-80">
            <div class="container">
                <form name="form_checkout" id="form_checkout" action="<?php echo SITEURL; ?>checkout-process/" method="post" onsubmit="return form_submit();">
                    <div class="row">
                        <div class="col-lg-7 col-md-12">
                            <div class="checkout-progress">
                                <div class="section-title"><h4>Billing Information</h4></div>
                                <div class="login-form">
                                    <div class="customer-name">
                                        <div class="first-name">
                                            <p>First Name<span>*</span></p>
                                            <input type="text" id="fname" name="fname" value='<?php echo $fname; ?>' required>
                                        </div>
                                        <div class="last-name">
                                            <p>Last Name<span>*</span></p>
                                            <input type="text" id="lname" name="lname" value="<?php echo $lname; ?>" required>
                                        </div>
                                    </div>
                                    <div class="customer-info">
                                        <div class="telephone">
                                            <p>Phone Number<span>*</span></p>
                                            <input type="text" id="phone" name="phone" value="<?php echo $phone; ?>" pattern="[1-9]{1}[0-9]{9}" required>
                                        </div>
                                        <div class="email-address">
                                            <p>Email Adress<span>*</span></p>
                                            <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
                                        </div>
                                    </div>
                                    <div class="customer-address">
                                        <p>Address<span>*</span></p>
                                        <textarea row="3" id="address" name="address"><?php echo $address;?></textarea>
                                    </div>
                                    <div class="city-country">
                                        <div class="city">
                                            <p>City<span>*</span></p>
                                            <input type="text" id="city" name="city" value="<?php echo $city; ?>" required onkeypress="return (event.charCode > 64 && 
                                                    event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)">
                                        </div>
                                        <div class="state">
                                            <p>Country<span>*</span></p>
                                            <select class="country" name="country" id="country" onchange="get_state_lists(this.value)" required="">
                                               <option value="">Select a Country</option>
                                                <?php
                                                    $country_r = $db->rpgetData("country","*","isDelete=0","name ASC");
                                                    if(@mysqli_num_rows($country_r)>0){
                                                        while($country_d = @mysqli_fetch_array($country_r)){
                                                        ?>
                                                    <option class="frt-options" value="<?php echo $country_d['id']; ?>" <?php if($country == $country_d['id']){ echo "selected";} ?>><?php echo $country_d['name']; ?></option>
                                                    <?php
                                                        }
                                                    }
                                                ?>   
                                            </select>
                                        </div>
                                    </div>
                                    <div class="city-country">
                                        <div class="state">
                                            <p>Region, State OR Province<span>*</span></p>
                                            <select class="state" name="state" id="state" required="" onchange="check_is_taxable_state()">
                                               <option value="">Please select state</option>
                                                <?php
                                                $state_r = $db->rpgetData("state","*","country_id='".$country."' AND isDelete=0","name ASC");
                                                if(@mysqli_num_rows($state_r)>0)
                                                {
                                                    while($state_d = @mysqli_fetch_array($state_r))
                                                    {
                                                    ?>
                                                    <option value="<?php echo $state_d['id']; ?>" <?php if($state_d['id']==$state){?> selected <?php } ?>><?php echo $state_d['name']; ?></option>
                                                    <?php
                                                    }
                                                }
                                                ?>   
                                            </select>
                                        </div>
                                        <div class="city">
                                            <p>Zip/Postal Code<span>*</span></p>
                                            <input type="text" id="zipcode" name="zipcode" value="<?php echo $zipcode;?>" required>
                                        </div>
                                        <input type="hidden" id="shipping_charge" name="shipping_charge" value="0" >
                                        <input type="hidden" id="distance" name="distance" value="">
                                        <input type="hidden" id="shipping_id" name="shipping_id" value="">
                                        <input type="hidden" id="tax_amount" name="tax_amount" value="0">
                                        <input type="hidden" id="tax_percentage" name="tax_percentage" value="0">
                                        <input type="hidden" id="finaltotal" name="finaltotal" value="">
                                    </div>
                                </div>
                                <!--<div class="shipping-method">
                                    <div class="section-title"><h4>SHIPPING METHOD</h4></div>
                                    <div class="ship-method">
                                        <div class="customer-name mb-4">
                                            <div class="city-country w-100">
                                                <p>Select Shipping Method<span> *</span></p>
                                                <select class="country w-100">
                                                    <option value="1">Method 1</option>
                                                    <option value="2">Method 2</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>-->
                                <div class="payment">
                                    <div class="section-title"><h4>PAYMENT METHOD</h4></div>
                                    <div class="ship-method payment">
                                        <div class="ship-wrap">
                                            <div class="ship-address">
                                                <div class="form-check form-check-inline">
                                                  <input class="form-check-input" type="radio" name="pay_method" id="paypal_method" checked value="paypal" onchange="show2();"> Paypal
                                                </div>

                                                <div class="form-check form-check-inline">
                                                  <input class="form-check-input" type="radio" name="pay_method" id="credit_card_method" value="credit_card" onchange="show2();"> Credit Card
                                                </div>

                                                <!-- <div class="form-check form-check-inline">
                                                  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2" onchange="show2();"> Cash on delivery
                                                </div> -->
                                            </div>
                                        </div>

                                        <div class="card-info payment-information login-form" id="div1" style="display: none;">

                                            <div class="payment-image mb-4 text-left" style="float:none">
                                                <img src="<?=SITEURL?>images/payment.png" alt="">
                                            </div>

                                            <div class="city mb-4">
                                                <p>Credit Card Number<span>*</span></p>
                                                <input type="text" id="card_number" name="card_number" onkeypress="return checkOnlyDigits(event)" maxlength="16" required>
                                            </div>

                                            <div class="customer-name mb-4">
                                                <div class="city-country">
                                                    <p>Expiration Month<span>*</span></p>
                                                    <select class="country" id="mm" name="mm">
                                                        <option value="">Select Month</option>
                                                        <?php for($mm = 1 ; $mm <=12 ; $mm++) {?>
                                                            <option value="<?php echo sprintf("%02d", $mm) ?>" ><?php echo sprintf("%02d", $mm) ?></option>
                                                        <?php  }?> 
                                                    </select>
                                                </div>
                                                <div class="city-country mb-4">
                                                    <p>Expiration Year<span>*</span></p>
                                                    <select class="country" id="yy" name="yy">
                                                        <option value="">Select Year</option>
                                                        <?php for($yy = date("y") ; $yy <= date("y")+20 ; $yy++) {?>
                                                            <option value="<?php echo $yy ?>" ><?php echo 2000+$yy ?></option>
                                                        <?php  }?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="city mb-4">
                                                <p>Card Verification Number<span>*</span></p>
                                                <input type="text" name="cvv" id="cvv" onkeypress="return checkOnlyDigits(event)" maxlength="4" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-12">
                            <div class="checkout-progress your-order">
                                <div class="section-title"><h4>Your order</h4></div>
                                <div class="checkout-table table-responsive">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="p-name alignleft">Product Name</th>
                                                <th class="p-amount">Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $finaltotal = $db->rpgetValue("cartdetails","finaltotal","cart_id='".$_SESSION[SESS_PRE.'_SESS_CART_ID']."'");
                                            $tax_amount =   $db->rpnum($db->rpgetValue("cartdetails","tax_amount","cart_id='".$_SESSION[SESS_PRE.'_SESS_CART_ID']."'"));
                                            $shipping_charge =   $db->rpnum($db->rpgetValue("cartdetails","shipping_charge","cart_id='".$_SESSION[SESS_PRE.'_SESS_CART_ID']."'"));

                                            $finaltotal = ($finaltotal - $shipping_charge - $tax_amount);
                                            //echo $finaltotal."========";die();
                                            $sub_total  = 0;
                                            $shop_cart_r = $db->rpgetData("cartitems","*","cart_id='".$_SESSION[SESS_PRE.'_SESS_CART_ID']."'");
                                            if(@mysqli_num_rows($shop_cart_r)>0)
                                            {
                                                while($shop_cart_d = @mysqli_fetch_array($shop_cart_r))
                                                {
                                                    $pro_name   =   stripslashes($shop_cart_d['name']);
                                                    $qty        =   $shop_cart_d['qty'];
                                                    $unitprice  =   $db->rpnum($shop_cart_d['unitprice']);
                                                    $totalprice =   $db->rpnum($shop_cart_d['totalprice']);
                                                    $finalprice =   $db->rpnum($shop_cart_d['finalprice']);
                                                    $sub_total  += $finalprice;
                                                    $sub_total  = $db->rpnum($sub_total);
                                                    
                                                    $total_discount = $db->rpgetValue("cartdetails","total_discount","cart_id='".$_SESSION[SESS_PRE.'_SESS_CART_ID']."'");
                                                    ?>
                                                    <tr>
                                                        <td class="p-name text-black"><?=$pro_name;?> × <?=$qty;?> </td>
                                                        <td class="p-amount">
                                                            <span class="amount"><?= CURR.$finalprice; ?></span>
                                                        </td>
                                                    </tr>
                                                    <?php 
                                                }
                                                ?>
                                                <tr>
                                                    <td class="alignright text-black sub_total">Subtotal</td>
                                                    <td><?= CURR.$sub_total; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="alignright text-black total_discount">Discount(-)</td>
                                                    <td><?= CURR.$total_discount; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="alignright text-black">Shipping Charge(+)</td>
                                                    <td id="shipping_charges"><?= CURR.$shipping_charge; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="alignright text-black">Tax Amount(+)</td>
                                                    <td id="dis_tax_amount"><?= CURR.$tax_amount; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="alignright text-black "><strong>Grand Total</strong></td>
                                                    <td class="finaltotal"></td>
                                                </tr>
                                            <?php 
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <div class="checkout-buttons place-order-button">

                                        <h4 id="shipping_charges_msg">
                                        
                                        </h4>
                                        <button type="submit" name="place_order" id="place_order" class="default-btn w-100 mt-5 submit_btn"><span>Place Order</span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Checkout Area End -->  

        <!-- Footer Area Start -->
        <?php include('include_footer.php'); ?>
        <!-- Footer Area End -->

        <!-- all js here -->
        <?php include('include_js.php'); ?>
        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
        <script type="text/javascript">
            
            $(function(){
                $("#form_checkout").validate({
                    rules: {
                        fname:{required : true},
                        lname:{required : true},
                        email:{required : true,email:true},
                        phone:{required : true,number:true,minlength:5,maxlength:15},
                        address:{required : true},
                        city:{required : true},
                        state:{required : true},
                        country:{required : true},
                        zipcode:{required : true,maxlength:8},
                        card_number:{required : true,number : true, maxlength:16},
                        mm:{required : true},
                        yy:{required : true},
                        cvv:{required : true,number : true, maxlength:4}
                    },
                    messages: {
                        fname:{required:"Please enter your first name."},
                        lname:{required:"Please enter your last name."},
                        email:{required:"Please enter your email.",email:"Please enter valid email address."},
                        phone:{required:"Please enter your phone.",number:"Please enter valid phone number.",minlength:"More than five or equal digits are allowed",maxlength:"Less than fifteen or equal digits are allowed"},
                        address:{required:"Please enter your address."},
                        city:{required:"Please enter your city."},
                        state:{required:"Please enter your state."},
                        country:{required:"Please enter your country."},
                        zipcode:{required:"Please enter your zipcode.",maxlength:"Less than eight or equal digits are allowed"},
                        card_number:{required:"Please enter card number.",number:"Only Digits Allowed",maxlength:"Less than sixteen or equal digits are allowed"},
                        mm:{required:"Please select month."},
                        yy:{required:"Please select year."},
                        cvv:{required:"Please enter CVC.",number:"Only Digits Allowed",maxlength:"Less than four or equal digits are allowed"}
                    }
                });
            }); 

            function form_submit() 
            {

                console.log("shipping " + $("#shipping_charge").val());
                console.log("distance " + $("#distance").val());
                console.log("shipping_id " + $("#shipping_id").val());
                if($("#shipping_charge").val()!=0 && $("#distance").val()!=0 && $("#shipping_id").val()!=0)
                {
                    $(".submit_btn").attr("readonly", true);
                    //$(".custom-loading-div").show();
                    if($("#form_checkout").valid())
                    {
                        $(".submit_btn").attr("readonly", true);
                    }
                    else
                    {
                        $(".submit_btn").attr("readonly", false);
                        //$(".custom-loading-div").fadeOut(3000);   
                        return false;
                    }
                }
                else
                {
                    console.log("fals");
                    return false;
                }
                return true;
            } 

            function show2()
            {
                var get_st_needs = $('input[name=pay_method]:checked').val();
                // alert(get_st_needs);
                if(get_st_needs == "credit_card")
                {
                    $(".payment-information").show();
                }
                else if(get_st_needs == "paypal")
                {
                    $(".payment-information").hide();
                }
            }
            $(document).ready(function(){
                shipping_calculate();
                check_is_taxable_state();

                $('#zipcode').keyup(function(){
                    shipping_calculate();
                });
            })

            function shipping_calculate(zip_val){

                var zip_val =  $('#zipcode').val();

                $.ajax({
                    type: "POST",
                    cache: false,
                    url: "<?php echo SITEURL; ?>ajax_get_shipping_charges.php",
                    data: "zip="+zip_val,
                    dataType: 'json',
                    success: function(result) 
                    {
                        console.log(result);
                        if(result['msg']!="")
                        {
                            var tax_amount = $("#tax_amount").val();
                            $("#shipping_charge").val(result['charges']);
                            $("#distance").val(result['distance']);
                            $("#shipping_id").val(result['shipping_id']);

                            $("#shipping_charges").html('<?php echo CURR; ?>'+result['charges']);
                            $("#shipping_charges_msg").html('<td class="text-danger"><b>'+result['content']+'</b></td><td></td>');

                            var finaltotal      = '<?php echo $finaltotal; ?>';
                            //console.log(finaltotal);
                            var grand_total = parseInt(result['charges']) + parseInt(finaltotal) + parseFloat(tax_amount);
                            //console.log(grand_total);
                            $(".finaltotal").html('<strong class="val finaltotal"><?php echo CURR; ?>'+grand_total+'</strong>');
                            $("#finaltotal").val(grand_total);
                        }
                    }
                });
            }

            function get_state_lists(country_id)
            {
                $("#state").html("");
                $.ajax({
                    type: "POST",
                    cache: false,
                    url: "<?php echo SITEURL; ?>ajax_get_state_lists.php",
                    data: "country_id="+country_id,
                    dataType: 'json',
                    success: function(result) 
                    {
                        if(result['msg']=="success")
                        {
                            $("#state").html(result['html']);
                        }
                    }
                });
            }

            function check_is_taxable_state()
            {
                
                var state = $("#state").val();
                $.ajax({
                    type: "POST",
                    cache: false,
                    url: "<?php echo SITEURL; ?>ajax_check_is_taxable_state.php",
                    data: "state="+state,
                    dataType: 'json',
                    success: function(result) 
                    {
                        console.log(result);
                        if(result['msg']=="success")
                        {
                            var shipping_charge = $("#shipping_charge").val();

                            $("#dis_tax_amount").html('<?php echo CURR; ?>'+result['tax_amount']+'('+result['tax_percentage']+'%)');
                            $("#tax_amount").val(result['tax_amount']);
                            $("#tax_percentage").val(result['tax_percentage']);

                            var finaltotal      = '<?php echo $finaltotal; ?>';
                            //console.log(finaltotal);
                            var grand_total = parseInt(shipping_charge) + parseInt(finaltotal) + parseFloat(result['tax_amount']);
                            $(".finaltotal").html('<strong class="val finaltotal"><?php echo CURR; ?>'+grand_total+'</strong>');
                            $("#finaltotal").val(grand_total);
                        }
                    }
                    
                });
            }
        </script>
</body>

</html>