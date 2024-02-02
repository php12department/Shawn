<?php
include('connect.php'); 
$db->rpcheckLogin();
$current_page = "My Account";

$ctable_r = $db->rpgetData("user","*","isDelete=0 AND id='".$_SESSION[SESS_PRE.'_SESS_USER_ID']."'");
$ctable_d = @mysqli_fetch_array($ctable_r);

$first_name     = stripslashes($ctable_d['first_name']);
$last_name      = stripslashes($ctable_d['last_name']);
$email          = stripslashes($ctable_d['email']);
$phone          = stripslashes($ctable_d['phone']);
$address        = stripslashes($ctable_d['address']);
$city           = stripslashes($ctable_d['city']);
$state          = stripslashes($ctable_d['state']);
$country        = stripslashes($ctable_d['country']);
$zipcode        = stripslashes($ctable_d['zipcode']);
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
                <?php include('include_user_sidebar.php'); ?>
                <div class="col-lg-9 col-md-8 col-12">
                    <form name="frm" id="frm" action="<?php echo SITEURL; ?>process-my-account/" method="post">
                        <div class="form-fields">
                            <h2>Personal Information</h2>
                            <div class="row">
                                <div class="col-md-6">
                                    <p>
                                        <label for="login-name" class="important">First Name </label>
                                        <input type="text" id="first_name" name="first_name" value="<?php echo $first_name?>">
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p>
                                        <label for="login-name" class="important">Last Name </label>
                                        <input type="text" name="last_name" value="<?php echo $last_name?>" id="last_name">
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p>
                                        <label for="login-name" class="important">Phone Number </label>
                                        <input type="text" id="phone" name="phone" value="<?php echo $phone?>" pattern="[1-9]{1}[0-9]{9}">
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p>
                                        <label for="login-name" class="important">Email Address</label>
                                        <input type="text" name="email" id="email" value="<?php echo $email;?>" readonly>
                                    </p>
                                </div>
                                <div class="col-md-12">
                                    <p>
                                        <label for="login-name" class="important">Address</label>
                                        <textarea style="min-height: 100px;" id="address" name="address"><?php echo $address?></textarea>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p>
                                        <label for="login-name" class="important">City</label>
                                        <input type="text" id="city" name="city" value="<?php echo $city?>" onkeypress="return (event.charCode > 64 && 
                                                    event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)">
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p>
                                        <label for="login-name" class="important">Country</label>
                                        <select class="country" name="country" id="country" onchange="get_state_lists(this.value)">
                                            <option value="">Please select country</option>
                                            <?php
                                            $c_r = $db->rpgetData("country","*","isDelete=0","name ASC");
                                            if(@mysqli_num_rows($c_r)>0)
                                            {
                                                while($c_d = @mysqli_fetch_array($c_r))
                                                {
                                                ?>
                                                <option value="<?php echo $c_d['id']; ?>" <?php if($c_d['id']==$country){?> selected <?php } ?>><?php echo $c_d['name']; ?></option>
                                                <?php
                                                }
                                            }
                                            ?>       
                                        </select>
                                        <div class="error_country"></div>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p>
                                        <label for="login-name" class="important">Region, State OR Province</label>
                                        <select class="state" name="state" id="state">
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
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p>
                                        <label for="login-name" class="important">Zip/Postal Code</label>
                                        <input type="text" id="zipcode" name="zipcode" value="<?php echo $zipcode?>">
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="form-action">
                            <button type="submit">Save Changes</button>
                        </div>
                    </form>
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
        /* Form Validation Start */
        $(function(){
            $("#frm").validate({
                rules: {
                    first_name:{required : true},
                    last_name:{required : true},
                    phone:{required : true,number:true,minlength:5,maxlength:15},
                    email:{required : true,email:true},
                    address:{required : true},
                    city:{required : true},
                    state:{required : true},
                    country:{required : true},
                    zipcode:{required : true,maxlength:8},
                },
                messages: {
                    first_name:{required:"Please enter your first name."},
                    last_name:{required:"Please enter your last name."},
                    phone:{required:"Please enter your phone.",number:"Please enter valid phone number.",minlength:"More than five or equal digits are allowed",maxlength:"Less than fifteen or equal digits are allowed"},
                    email:{required:"Please enter your email.",email:"Please enter valid email address."},
                    address:{required:"Please enter your address."},
                    city:{required:"Please enter your city."},
                    state:{required:"Please enter your state."},
                    country:{required:"Please enter your country."},
                    zipcode:{required:"Please enter your zipcode.",maxlength:"Less than eight or equal digits are allowed"},
                },
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                }
            });
        });
        /* Form Validation End */

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
    </script>
</body>

</html>