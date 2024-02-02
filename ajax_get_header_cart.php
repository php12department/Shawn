<?php
include("connect.php"); 

/*if(isset($_SESSION[SESS_PRE.'_SESS_USER_ID']) && $_SESSION[SESS_PRE.'_SESS_USER_ID'] > 0)
{*/ 
	if(isset($_SESSION[SESS_PRE.'_SESS_CART_ID']))
	{
		//$total_discount = $db->rpgetValue("cartdetails","total_discount","cart_id='".$_SESSION[SESS_PRE.'_SESS_CART_ID']."'");
		$cart_total = $db->rpgetSumVal("cartitems","finalprice","cart_id='".$_SESSION[SESS_PRE.'_SESS_CART_ID']."'");
		$shop_cart_r = $db->rpgetData("cartitems","*","cart_id='".$_SESSION[SESS_PRE.'_SESS_CART_ID']."'");
		$shop_cart_t =  @mysqli_num_rows($shop_cart_r);
		if($shop_cart_t > 0)
		{ 
		?>
			<div class="cart-item-a-wrapper">
				<div class="cart-item-amount">
					<span class="cart-number"><span><?php echo $db->rpgetCartTotalItem(); ?></span> items</span>
					<div class="cart-amount">
						<h5>Cart Total :</h5>
						<h4><?= CURR.$cart_total;?></h4>
					</div>
				</div>
				<a href="<?=SITEURL?>checkout/" class="grey-button">Go to Checkout</a>
			</div>
			<div class="cart-dropdown-scroll">
				<table >
				<?php
				$total_pro_amt = 0;
				$count = 1;
				while($shop_cart_d = @mysqli_fetch_array($shop_cart_r))
				{
					$id 					= 	$shop_cart_d['id'];
					$pid 					= 	$shop_cart_d['pid'];
					$pro_name 				= 	stripslashes($shop_cart_d['name']);
					$qty 					= 	$shop_cart_d['qty'];
					$unitprice 				= 	$db->rpnum($shop_cart_d['unitprice']);
					$totalprice 			= 	$db->rpnum($shop_cart_d['totalprice']);
					$finalprice 			= 	$db->rpnum($shop_cart_d['finalprice']);

					$cate_id 				= 	$shop_cart_d['cate_id'];
					$sub_cate_id 			= 	$shop_cart_d['sub_cate_id'];
					$sub_sub_cate_id 		= 	$shop_cart_d['sub_sub_cate_id'];
					
					$sub_total 	+= $totalprice;
					$total_pro_amt += $totalprice;

					if ($shop_cart_d['product_type']=='w') {
                        $pro_thumb_url      = SITEURL."images/warranty.jpg";
                        $pro_details_url    = "javascript:;";
					}else{
						$pro_slug = $db->rpgetValue("product","slug","id='".$pid."'");
						$pro_cate_slug = $db->rpgetValue("category","slug","id='".$shop_cart_d['cate_id']."'");
						$pro_sub_cate_slug = $db->rpgetValue("sub_category","slug","id='".$shop_cart_d['sub_cate_id']."'");
						$pro_sub_sub_cate_slug = $db->rpgetValue("sub_sub_category","slug","id='".$shop_cart_d['sub_sub_cate_id']."'");
						$image_path = $db->rpgetValue("product","image","id='".$pid."'");

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
					}

					
					?>
					<tr>
						<td><a href="<?=$pro_details_url;?>"><img src="<?= $pro_thumb_url ?>" alt="" height="100px" width="150px"></a></td>
						<td>
							<div class="cart-p-qty-div">
							<a href="<?=$pro_details_url;?>" class="cart-p-name "><?= $pro_name ?></a>
							<span class="span_cart"><?= CURR.$finalprice; ?></span>
							<div class="cart-p-qty align-items-center">
								<label>Qty</label>
								<div class="num-block skin-5">
									<div class="num-in">
									<span class="minus dis" data-cartid='<?= $id ?>'>-</span>
									<input type="text" class="in-num" value="<?=$qty;?>" min="1" readonly="">
									<span class="plus" data-cartid='<?= $id ?>'>+</span>
									</div>
								</div>
							<button onclick="removeCartItem('<?php echo $id; ?>','<?php echo $pid; ?>');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></button>
							</div>
						</td>
					</tr>
				
				<?php
					$count++;
					$final_discount_amount = 0;
					$sub_total = $db->rpnum($sub_total);
					$final_total = $db->rpnum($sub_total);
		   		}
			   	?>
				</table>
			</div>
			<div class="cart-btn-wrapper">
				<a href="<?=SITEURL?>shopping-cart/" class="grey-button">View and edit cart</a>
			</div>
		<?php 
		}
		else
		{ 
		?>
		<div class="cart-item-a-wrapper">
			<div class="cart-item-amount">
				<span class="cart-number"> Your Cart is Empty</span>
			</div>
		</div>
		<?php 
		}
	}
	else
	{
	?>
	<div class="cart-item-a-wrapper">
		<div class="cart-item-amount">
			<span class="cart-number"> Your Cart is Empty</span>
		</div>
	</div>
	<?php	
	}
/*}	
else
{ 
?>
	<div class="cart-item-a-wrapper">
		<div class="cart-item-amount">
			<span class="cart-number"><a href="<?php echo SITEURL?>login/">Login</a> To View Cart Details</span>
		</div>
	</div>
<?php 
}*/
?>