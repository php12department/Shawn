<script>
	var SITEURL = '<?php echo SITEURL ?>';
</script>
<script src="<?php echo SITEURL;?>assets/js/vendor/jquery-3.2.1.min.js"></script>
<script src="<?php echo SITEURL;?>assets/js/popper.js"></script>
<script src="<?php echo SITEURL;?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo SITEURL;?>assets/js/owl.carousel.min.js"></script>
<script src="<?php echo SITEURL;?>assets/js/jquery.meanmenu.js"></script>
<script src="<?php echo SITEURL;?>assets/js/ajax-mail.js"></script>
<script src="<?php echo SITEURL;?>assets/js/plugins.js"></script>
<script src="<?php echo SITEURL;?>assets/js/main.js"></script>

<script src="<?php echo SITEURL; ?>common/js/bootstrap-notify.js"></script>
<script src="<?php echo SITEURL; ?>common/js/jquery.validate.js"></script>


<script>

	$(document).on('click', '.pro_wishlist', function(){
        var pid = $(this).attr("data-proid");
        var thisd = $(this);
        $.ajax({
            type: "POST",
            url: "<?php echo SITEURL; ?>ajax_update_wishlist.php",
            data: "pid=" + pid,
            dataType: "json",
            success: function(result) 
            {
                if(result['msg']=='remove')
                {
                    var is_pro_details_page = thisd.attr('data-curr-page');
					if (typeof is_pro_details_page !== typeof undefined && is_pro_details_page !== false) 
					{
                    	thisd.text("Add to Wishlist");
					}
					else
					{
                    	thisd.html(result['content']);
                    	thisd.attr("tooltip","Add to Wishlist");
					}
                }
                else if(result['msg']=='add')
                {
                    var is_pro_details_page = thisd.attr('data-curr-page');
					if (typeof is_pro_details_page !== typeof undefined && is_pro_details_page !== false) 
					{
                    	thisd.text("Remove from Wishlist");
					}
					else
					{
                    	thisd.html(result['content']);
                    	thisd.attr("tooltip","Remove from Wishlist");
					}
                }
                else if(result['msg']=="error")
                {
                    location.reload();
                }
                else if(result['msg']=="login_error")
                {
                    window.location.href='<?php echo SITEURL?>login/';
                }
            }
        });
    });
   $(document).on('click', '#addtocart', function(){
			
			var dataId = $(this).data("id");

			console.log(dataId);
			$.ajax({
				url: '<?php echo SITEURL; ?>ajax_get_addtocartproduct.php',
				type:'POST',
				dataType: 'json',
				data:{'action':"addtocartproduct",'productid':dataId},
				success:function(data)
				{
					if(data.message=='login_first')
					{
						setTimeout(function(){
							$.notify({message: 'Please login first for product add to cart.'},{ type: 'danger'});
						},1000);
					}else if(data.message=='not_available'){
						setTimeout(function(){
							$.notify({message: 'Something went worng. Please try again.'},{ type: 'danger'});
						},1000);
					}else{
						setTimeout(function(){
							$.notify({message: 'Product add to acrt successfully.'},{ type: 'success'});
						},1000);
						getHeaderCart();
					}
				},
				error: function(){
					//  alert("error in ajax form submission");
				}
			});
		});
 	$(document).on('click', '.num-in span', function(){
        var $input = $(this).parents('.num-block').find('input.in-num');
        if($(this).hasClass('minus')) 
        {
            var count = parseFloat($input.val()) - 1;
            count = count < 1 ? 1 : count;
            if (count < 2) {
                $(this).addClass('dis');
            }
            else {
                $(this).removeClass('dis');
            }
            $input.val(count);
        }
        else 
        {
            var count = parseFloat($input.val()) + 1
            $input.val(count);
            if (count > 1) {
                $(this).parents('.num-block').find(('.minus')).removeClass('dis');
            }
        }
        
        $(".front-loading-div").fadeIn(800);
        var cartid = $(this).attr("data-cartid");

        $.ajax({
          	type: "POST",
          	url: "<?php echo SITEURL; ?>ajax_update_qty.php",
          	data: { 'cart_itemid' : cartid, 'new_qty' : count },
          	success: function(html)
          	{
            	getHeaderCart();
            	getShoppingCart();
        		$input.change();
          	}
        });
        return false;
    });

	$(document).ready(function(e){ 
	    setTimeout(function(){
	        getHeaderCart();
	    },1000);
	});

	function getHeaderCart(){
		$.ajax({
			type: "POST",
			url: "<?php echo SITEURL; ?>ajax_get_header_cart.php",
			success: function(result){
				$(".header_cart").html(result);
			}
		});
	}


	function removeCartItem(val1,val2)
	{
		var a = confirm("Are you sure to remove this item from Cart?");
		if(!a) { return false; }
		$.ajax({
			type: "POST",
			url: "<?php echo SITEURL; ?>ajax_removeCartItem.php",
			data: 'val1='+val1+'&val2='+val2,
			success: function(){
				getHeaderCart();
				if($('#cpage').length){ getShoppingCart();}
				$.notify({message: 'Cart item removed successfully.' },{type: 'success'});
				
			}
		});
	}

	function checkOnlyDigits(e) 
	{
	  e = e ? e : window.event;
	  var charCode = e.which ? e.which : e.keyCode;
	  if (charCode < 48 || charCode > 57) {
		//alert('OOPs! Only digits allowed.');
		return false;
	  }
	}

	function myFunction()
    {
        return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)
    }

    function get_search_events()
    {
        var search_val = $("#search").val();

        if(search_val!="")
        {
          url = SITEURL + 'news-and-events/search/' + search_val.replace(' ', '+');
          window.location.replace(url);
        }
    }
    
    $(document).ready(function(){
	     setTimeout(function(){
	        <?php if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Something_Wrong') { ?>
	           $.notify({message: 'Something went worng. Please try again.'},{ type: 'danger'});
	        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'NEED_TO_LOGIN_FRONTEND') { ?>
	           $.notify({message: 'Please login to your account.'},{ type: 'danger'});
	        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Invalid_Email_Password') { ?>
	           $.notify({ message: 'Invalid email and password.'},{type: 'danger'});
	        <?php unset($_SESSION['MSG']); }  else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Success') { ?>
	           $.notify({ message: 'Your forgot password reset link is successfully sent to your register email address.'},{ type: 'success'});
	        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Success_Logout') { ?>
	           $.notify( {message: 'You are successfully logged out.'},{ type: 'success'});
	        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Success_Signup') { ?>
	           $.notify({message: 'You have successfully registered to <?php echo SITETITLE; ?>. Please check your email inbox and verifiy your account.'},{ type: 'success'});
	        <?php unset($_SESSION['MSG']); }else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Success_product_enquiry') { ?>
	           $.notify({message: 'You have successfully Did Product Enquiry to <?php echo SITETITLE; ?>. Please check your email inbox and verifiy your account.'},{ type: 'success'});
	        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'ACC_CODE_SUCCESS') { ?>
	           $.notify( {message: 'Your account has been successfully verified. Please login to continue.'},{ type: 'success'});
	        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'CODE_LINK_EXPIRE') { ?>
	           $.notify( {message: 'This link has already been used or expired.'},{ type: 'danger'});
	        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Acc_Not_Verified') { ?>
	           $.notify( {message: 'Sorry! your account is not verified. Please verify your account in order to login. Account verification mail is successfully sent to your register email address.'},{ type: 'danger'});
	        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Success_Fsent') { ?>
	           $.notify( {message: 'Your forgot password reset link is successfully sent to your register email address.'},{ type: 'success'}); 
	        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Update_Pass') { ?>
	              $.notify( {message: 'Your password has been updated successfully.'},{ type: 'success'});
	        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Link_Expired') { ?>
	           $.notify( {message: 'Your email verification link has been expired.'},{ type: 'danger'}); 
	        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'LOGIN_REQUIRE') { ?>
				$.notify( {message: 'Please login first to add this product to wishlist.'},{ type: 'danger'});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Duplicate_User') { ?>
             $.notify({message: 'Your email id is already registered with us..' },{type: 'danger'});
	        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Duplicate_Review') { ?>
             $.notify({message: 'Your review already added.' },{type: 'danger'});
	        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Duplicate_Comment') { ?>
             $.notify({message: 'Your comment already added.' },{type: 'danger'});
	        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Added_Review') { ?>
             $.notify({message: 'Your review added successfully.' },{type: 'success'});
	        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Added_Comment') { ?>
             $.notify({message: 'Your comment added successfully.' },{type: 'success'});
	        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Success_signup') { ?>
	             $.notify({message: 'You registered succesfully.' },{type: 'success'});
	        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'CONFORM_PASS') { ?>
	             $.notify({message: 'Confirm password must be as  password.' },{type: 'danger'});
	        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'FILL_ALL_DATA') { ?>
	             $.notify({message: 'Please fill all required field.' },{type: 'danger'});
	        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Something_Wrong') { ?>
	             $.notify({message: 'Something went worng. Please try again.' },{type: 'danger'});
	        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'No_Data_Found') { ?>
	             $.notify({message: 'Your email id is not register with us.' },{type: 'danger'});
	        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Link_Expired') { ?>
	             $.notify({message: 'Your link to reset the password is expired.' },{type: 'danger'});
	        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Valid_Email') { ?>
	             $.notify({message: 'Please enter valid email address.' },{type: 'danger'});
	        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'INVALID_DATA') { ?>
		         $.notify({  type: 'danger'}, {message: 'Your email address is not registered with us.'});
	      	<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'changes_saved') { ?>
	             $.notify({message: 'Your changes has been successfully saved.' },{type: 'success'});
	        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'password_change') { ?>
	             $.notify({message: 'Your password has been successfully changed.' },{type: 'success'});
	        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Acc_Suspended') { ?>
	             $.notify({message: 'This account has been temporarily suspended. Contact customer service at <?php echo SITEMAIL?> for more information.' },{type: 'danger'});
	        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Duplicate_my_account') { ?>
				$.notify({message: 'Your request has been already received one time. We will contact you soon.' },{type: 'danger'});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Success_Quote_Request') { ?>
				$.notify({message: 'Your request has been succesfully received.' },{type: 'success'});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'ZERO_AMOUNT') { ?>
				$.notify({message: "You can't use this coupon code, because discount must not be greater than total amount." },{type: 'danger'});
			<?php
				unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'INVALID_DATA') { ?>
				$.notify({message: 'Invalid Data. Please enter valid data.' },{type: 'danger'});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'EWAY_ERROR') { ?>
				var eway_error = '<?php echo $_SESSION['EWAY_ERROR']?>';
				$.notify({message: eway_error },{type: 'danger'});
			<?php unset($_SESSION['MSG']); unset($_SESSION['EWAY_ERROR']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'ORDER_PLACED') { ?>
				$.notify({message: 'Your order has been placed successfully.' },{type: 'success'});
			<?php unset($_SESSION['MSG']); } 
			else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'duplicate_subscribe') { ?>
				$.notify({message: 'Your have already subscribe.' },{type: 'success'});
			<?php unset($_SESSION['MSG']); }
			else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'success_subscribe') { ?>
				$.notify({message: 'Your have successfully subscribe.' },{type: 'success'});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Success_Contactus_Request') { ?>
	             $.notify({message: 'Your request has been succesfully received.' },{type: 'success'});
	        <?php unset($_SESSION['MSG']); }
	        else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Uploaded_success') { ?>
				$.notify({message: 'Your have successfully uploaded image.' },{type: 'success'});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'order_success') { ?>
	           $.notify({message: 'Please check your Email for Order Details'},{ type: 'success'});
	        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'shipping_not_available') { ?>
	           $.notify({message: 'Shipping details not found.'},{ type: 'danger'});
	        <?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'recaptcha_error') { ?>
	            var recaptcha_error = '<?php echo $_SESSION['recaptcha_error_msg']?>';
	           $.notify({message: recaptcha_error},{ type: 'danger'});
	        <?php unset($_SESSION['MSG']); unset($_SESSION['recaptcha_error_msg']); }
	           ?>
	     },1000);
  	});
</script>

<script type="text/javascript">
	$(document).ready(function(){
 		$("#subscribe").click(function(e){
			e.preventDefault();
			var form = $("#frmsubscribe");
			if(! form.valid()) return false;
	  
			var email   =   $('#email').val();
			console.log(email);
			$.ajax({
				url: '<?php echo ADMINURL ?>ajax_get_subscription.php',
				type:'POST',
				dataType: 'json',
				data:{'action':"Addsubscription",'email':email},
				success:function(data)
				{
					if(data.msg=='success_subscribe')
					{
						setTimeout(function(){
							$.notify({message: 'You have successfully subscribe.'},{ type: 'success'});
						},1000);
					}
					else if(data.msg=='duplicate_subscribe')
					{
					    $('#email').val("");
						setTimeout(function(){
							$.notify({message: 'You have already subscribe.'},{ type: 'danger'});
						},1000);
					}else{
					    $('#email').val("");
						setTimeout(function(){
							$.notify({message: 'Something went worng. Please try again.'},{ type: 'danger'});
						},1000);
					}
				},
				error: function(){
					//  alert("error in ajax form submission");
				}
			});
		});
    });
</script>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5eb00f7581d25c0e58489e01/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
<?php echo $other_cus_tracking_num; ?>