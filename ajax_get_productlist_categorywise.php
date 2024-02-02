<?php
ini_set('max_execution_time', 0);
include('connect.php');
$cate_id      		= $db->clean($_REQUEST['cate_id']);
$sub_cate_id  		= $db->clean($_REQUEST['sub_cate_id']);
$sub_sub_cate_id  	= $db->clean($_REQUEST['sub_sub_cate_id']);

$is_filter_apply = 0;
if (isset($_REQUEST['pro_feature_brand']) && $_REQUEST['pro_feature_brand'] != "") {
	$is_filter_apply = 1;
	$pro_feature_brand_arr = implode(",", $_REQUEST['pro_feature_brand']);
	$ctable_where .= "pro_feature_brand IN ($pro_feature_brand_arr) AND ";
}

if (isset($_REQUEST['add_field_val'])) {
	$is_filter_apply = 1;
	foreach ($_REQUEST['add_field_val'] as $key => $value) {
		$additional_field_label_id 	= 	$key;
		$additional_field_values 	= 	$_REQUEST['add_field_val'][$key];

		foreach ($additional_field_values as $additional_field_value) {
			$wh_inner .= "FIND_IN_SET($additional_field_value,additional_field_val_ids) AND ";
		}
		//$additional_field_value 	=  	implode(",",$additional_field_value);

		$where_inner = rtrim($wh_inner, " AND");
		$ctable_where .= "id IN (select pid from product_additional_field_details where additional_field_id='" . $additional_field_label_id . "' AND $where_inner) AND ";
	}
}

if (isset($_REQUEST['color_id']) && $_REQUEST['color_id'] != "") {
	$is_filter_apply = 1;
	$color_id_arr = implode(",", $_REQUEST['color_id']);
	$ctable_where .= "color_id IN ($color_id_arr) AND ";
}

if (isset($_REQUEST['material_id']) && $_REQUEST['material_id'] != "") {
	$is_filter_apply = 1;
	$material_id_arr = implode(",", $_REQUEST['material_id']);
	$ctable_where .= " material_id IN ($material_id_arr) AND ";
}

if (isset($_REQUEST['price_range']) && $_REQUEST['price_range'] != "") {
	$is_filter_apply = 1;
	$price_range = explode(" - ", $_REQUEST['price_range']);
	$price_range_0 	= $price_range[0];
	$price_range_1 	= $price_range[1];

	if ($price_range_0 == "3000 And Above") {
		$price_range 	= explode(" And ", $price_range_0);
		$price_range_0 	= $price_range[0];
		$price_range_1 	= "1000000";
	}

	$ctable_where .= " price BETWEEN '" . $price_range_0 . "' AND '" . $price_range_1 . "' AND ";
}

if (isset($_REQUEST['sortData']) && $_REQUEST['sortData'] != "") {
	$is_filter_apply = 1;
	$sortData_arr = explode("-", $_REQUEST['sortData']);

	$field = $sortData_arr[0];
	$order = $sortData_arr[1];

	if ($field == "price") {
		$orderBy = " price $order, id DESC";
	} elseif ($field == "name") {
		$orderBy = " name $order";
	} else {
		$orderBy = " $field $order";
	}
} else {
	$orderBy = " pro_feature_brand=5 DESC";
}

if ($sub_cate_id != "" && $sub_cate_id != 0) {
	$ctable_where .= "sub_cate_id='" . $sub_cate_id . "' AND ";
}

if ($sub_sub_cate_id != "" && $sub_sub_cate_id != 0) {
	$ctable_where .= "sub_sub_cate_id='" . $sub_sub_cate_id . "' AND ";
}

if ($is_filter_apply == 0) {
	$ctable_where .= "isDisplayCategoryPage='1' AND ";
}

$ctable_where .= "cate_id='" . $cate_id . "' AND isDelete=0";
$ctable_r = $db->rpgetData("product", "*", $ctable_where, $orderBy,0);
if (@mysqli_num_rows($ctable_r) > 0) {
	while ($ctable_d = @mysqli_fetch_array($ctable_r)) {
		$pro_id         = $ctable_d['id'];
		$price          = $ctable_d['price'];
		$sell_price     = $ctable_d['sell_price'];
		$cate_id     	= $ctable_d['cate_id'];
		$sub_cate_id    = $ctable_d['sub_cate_id'];
		$sub_sub_cate_id = $ctable_d['sub_sub_cate_id'];
		$image_path     = $ctable_d['image'];

		if (!empty($image_path) && file_exists(PRODUCT . $image_path)) {
			$pro_url = SITEURL . PRODUCT . $image_path;
		} else {
			$pro_url = SITEURL . "common/images/no_image.png";
		}
		$pro_list_url1 = SITEURL . PRODUCT_LIST_THUMB . $image_path;
		if (!empty($image_path) && file_exists(PRODUCT_LIST_THUMB . $image_path)) {
			$pro_list_url = SITEURL . PRODUCT_LIST_THUMB . $image_path;
		} else {
			$pro_list_url = SITEURL . "common/images/no_image.png";
		}

		$pro_slug 		= stripslashes($ctable_d['slug']);
		$pro_name 		= stripslashes($ctable_d['name']);

		$pro_cate_slug = $db->rpgetValue("category", "slug", " id='" . $cate_id . "' ");
		$pro_sub_cate_slug = $db->rpgetValue("sub_category", "slug", " id='" . $sub_cate_id . "' ");
		$pro_sub_sub_cate_slug = $db->rpgetValue("sub_sub_category", "slug", " id='" . $sub_sub_cate_id . "' ");

		if ($ctable_d['status'] == 1) {
			$dis_status 	= "In Stock";
		}

		if ($ctable_d['status'] == 2) {
			$dis_status 	= "Out Of Stock";
		}

		if ($ctable_d['status'] == 3) {
			$dis_status     = "Special Order";
		}

		if ($ctable_d['status'] == 4) {
			$dis_status     = "Online Only";
		}

		if ($ctable_d['status'] == 5) {
			$dis_status     = "Coming Soon";
		}

		if ($sell_price > 0) {

			$is_discount_product = $db->checkIsDiscountProduct($pro_id, $cate_id, $sub_cate_id, $sub_sub_cate_id, $sell_price);
			// $dis_price = '<span>'.CURR.($sell_price - $is_discount_product['total_discount']).'</span><span class="price-line-through">'.CURR.$price.'</span>';
			$dis_price = '<span>' . CURR . number_format(($sell_price - $is_discount_product['total_discount'])) . '</span><span class="price-line-through">' . CURR . number_format($price) . '</span>';
		} else {
			$is_discount_product = $db->checkIsDiscountProduct($pro_id, $cate_id, $sub_cate_id, $sub_sub_cate_id, $price);
			// echo "========";
			// print_r($is_discount_product);
			if ($is_discount_product['is_discount_pro'] == 1) {
				$dis_price = '<span class="p-d-price">' . CURR . number_format(($price - $is_discount_product['total_discount'])) . '</span><span class="price-line-through">' . CURR . number_format($price) . '</span>';
			} else {
				$dis_price = '<span>' . CURR . number_format(($price - $is_discount_product['total_discount'])) . '</span>';
			}
		}
		$dis_discount_desc = ($is_discount_product['discount_desc']) ? "<p>" . $is_discount_product['discount_desc'] . "</p>" : "";

		$pro_details_url = SITEURL . "product/" . $pro_cate_slug . "/" . $pro_slug . "/";
		if ($sub_cate_id != 0 && $sub_cate_id != "") {
			$pro_details_url = SITEURL . "product/" . $pro_cate_slug . "/" . $pro_sub_cate_slug . "/" . $pro_slug . "/";
		}

		if ($sub_sub_cate_id != 0 && $sub_sub_cate_id != "") {
			$pro_details_url = SITEURL . "product/" . $pro_cate_slug . "/" . $pro_sub_cate_slug . "/" . $pro_sub_sub_cate_slug . "/" . $pro_slug . "/";
		}

		$is_wish_listed = $db->rpgetTotalRecord("wishlist", "product_id='" . $pro_id . "' AND user_id='" . $_SESSION[SESS_PRE . '_SESS_USER_ID'] . "'");

		$dis_wishlist_tooltip = 'Add to Wishlist';
		$dis_wishlist_icon = '<i class="fa fa-heart-o" aria-hidden="true"></i>';
		if ($is_wish_listed > 0) {
			$dis_wishlist_tooltip = 'Remove from Wishlist';
			$dis_wishlist_icon = '<i class="fa fa-heart" aria-hidden="true"></i>';
		}
?>
		<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-12 p-0-10">
			<!-- <div class="pro-width"> -->
			<div class="product-item">
				<div class="product-image-hover">
					<a href="<?php echo $pro_details_url; ?>" class="img-a">
						<img class="primary-image" src="<?= $pro_list_url ?>" alt="<?php echo $pro_name; ?>">
						<!-- <img class="hover-image" src="<?= SITEURL.$pro_list_url1 ?>" alt=""> -->
						<?php echo $db->proBadge($ctable_d['isProduct']); ?>
					</a>
					<div class="product-hover">
						<a href="<?= $pro_details_url ?>" tooltip="Add to Cart"><i class="icon-basket" title="" data-placement="top" data-original-title="Add to cart"></i></a>
						<a href="javascript:void(0)" class="pro_wishlist" tooltip="<?= $dis_wishlist_tooltip; ?>" data-proid="<?php echo $pro_id; ?>">
							<?= $dis_wishlist_icon; ?>
						</a>
						<!-- <a href="javscript:void(0)" class="last" tooltip="Compare"><i class="icon icon-Files"></i></a> -->
					</div>
				</div>
				<div class="product-text">
					<h4><a href="<?php echo $pro_details_url; ?>"><?php echo $db->rplimitChar($pro_name, 30, ""); ?></a></h4>
					<?= $dis_discount_desc; ?>
					<div class="product-price">
						<?= $dis_price; ?>
						<?php //echo number_format($dis_price, 2);
						?>
					</div>
					<?php
					echo $db->get_single_rating($pro_id);
					?>
				</div>
			</div>
			<!-- </div> -->
		</div>

	<?php

	}
} else {
	?>
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h3 class="text-center mt-30">coming soon...</h3>
	</div>
<?php
}
?>