<?php
include('connect.php'); 
// $db->rpcheckLogin();
$current_page = "Shopping Cart";
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
	<div class="front-loading-div" style="display:none;">
        <div><img style="width:10%" src="<?php echo SITEURL."common/images/loader.svg"?>" alt="<?php echo SITETITLE; ?>" /></div>
    </div>
	<!-- cart section start-->
	<div class="cart-main-area ptb-80">
		<div class="container" id="results">
			
		</div>
	</div>
	<!-- cart section end-->
	<input type="hidden" name="cpage" id="cpage" value="shopping-cart">
	<!-- Footer Area Start -->
	<?php include('include_footer.php'); ?>
	<!-- Footer Area End -->

	<!-- all js here -->
	<?php include('include_js.php'); ?>
	<script type="text/javascript">
		$(document).ready(function() {
			getShoppingCart();
		});	

		function getShoppingCart() 
		{
			$("#results").hide();
			$.ajax({
				type: "POST",
				url: "<?php echo SITEURL; ?>ajax_get_shopping_cart.php",
				data: "show=1",
				cache: false,
				beforeSend: function() {
				  $(".front-loading-div").fadeIn(800);
				},
				success: function(html) 
				{ 
					setTimeout(function(){
						$(".front-loading-div").hide();
						$("#results").html(html).show();
						$('.q').bind('keypress', function(event){
						  var charCode = (event.which) ? event.which : event.keyCode;
						  if (charCode!=8 && (charCode < 48 || charCode > 57)) {
							return false;
						  }
						});
						$(".front-loading-div").fadeOut(800);
					},2000);      
				}
			});
		}
		
		function clearCartItem()
		{
			var r = confirm("Are you sure you want to clear your cart?");
			if(r)
			{
				$.ajax({
				  type: "POST",
				  url: "<?php echo SITEURL; ?>ajax_removeCartItem.php",
				  data: 'cl=1',
				  success: function(){
					getHeaderCart();
					getShoppingCart();
				  }
				});
			}
		}

		$(document).on("click",".removeCode",function(){
			$(".front-loading-div").fadeIn(800);
			$.ajax({
			  type: "POST",
			  url: "<?php echo SITEURL; ?>ajax_remove_coupon.php",
			  success: function(html){
				if(html=="1"){
				  getShoppingCart();
				}else{  
				  $(".front-loading-div").fadeOut(800);
				  //alert("Invalid Request");
				}
			  }
			});
		});

		$(document).on('click','.apply_coupon',function()
		{
			var r = $("#coupon").val();
			if(!r) 
			{
				$.notify({message: 'Please Enter Coupon Code' },{type: 'danger'});
				return false ;
			}
			$.ajax({
			type: "POST",
			url: "<?php echo SITEURL; ?>ajax_apply_coupon.php",
			data: {'coupon':r},
			dataType: 'json',
			success: function(res) 
			{ 
	            if(res.message=="not_available") 
				{
					$.notify({message: 'Coupon Not Available' },{type: 'danger'});
				} 
				else if(res.message=="success") 
				{
					$.notify({message: 'Coupon Applied' },{type: 'success'});
					$("#coupon").prop('disabled',true);
					$("#submit").prop('disabled',true);
	              
					setTimeout(function(){
						window.location.href = "<?php echo SITEURL.'shopping-cart/' ?>";
					},1000);
				} 
				else if(res.message=="already_applied") 
				{
	                  $.notify({message: 'This Coupon Code Already Used By You' },{type: 'danger'});
				} 
				else if(res.message=="expire_too") 
				{
	                  $.notify({message: 'Coupon Was Expired..' },{type: 'danger'});
				} 
				else if(res.message=="Invalid Request") 
				{
	                  $.notify({message: 'Invalid Request..' },{type: 'danger'});
				} 
				else if(res.message=="min_spend_amount") 
				{
	                  $.notify({message: 'Minimum amount not Sufficient excepted discount products.' },{type: 'danger'});
				} 
				else if(res.message=="commin_soon") 
				{
					$.notify({message: 'Coupon not available yet.' },{type: 'danger'});
				}
				else if(res.message=="regular_product_not_found") 
				{
					$.notify({message: "You can't apply coupon on the discount products." },{type: 'danger'});
				}
				
				$("#coupon").val("");
	          }
	      });
		});
	</script>
</body>
</html>