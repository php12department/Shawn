<?php
include('connect.php'); 
$current_page = "Featured Brand Product List";

$brand_slug         = $db->clean($_REQUEST['brand_slug']);

$ctable_r   = $db->rpgetData("featured_brand","*","slug = '".$brand_slug."' AND isDelete=0");
if(@mysqli_num_rows($ctable_r)>0)
{
    $ctable_d           = @mysqli_fetch_array($ctable_r);
    $brand_name         = stripslashes($ctable_d['name']);
    $brand_short_desc   = stripslashes($ctable_d['short_desc']);
    $brand_id           = $ctable_d['id'];

    $meta_title        = stripslashes($ctable_d['meta_title']);
    $meta_description  = stripslashes($ctable_d['meta_description']);
    $meta_keywords     = stripslashes($ctable_d['meta_keywords']);

    $image_path     = $ctable_d['image'];
    if(!empty($image_path) && file_exists(FEATURED_BRAND.$image_path))
    {
        $brand_img_url = SITEURL.FEATURED_BRAND.$image_path;
    }
    else
    {
        $brand_img_url = SITEURL."common/images/no_image.png";
    }
}
else
{
      $db->rplocation(SITEURL);
}
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <?php 
    if($meta_title!="")
    {
    ?>
    <title><?=$meta_title;?> | <?php echo SITETITLE; ?></title>
    <meta name="title" content="<?=$meta_title;?> | <?php echo SITETITLE; ?>">
    <?php
    }
    else
    {
    ?>
    <title><?=$current_page;?> | <?php echo SITETITLE; ?></title>
    <?php
    }

    if($meta_description!="")
    {
    ?>
    <meta name="description" content="<?=$meta_description;?>">
    <?php
    }

    if($meta_keywords!="")
    {
    ?>
    <meta name="keywords" content="<?=$meta_keywords;?>">
    <?php
    }
    ?>
    <?php include('include_css.php'); ?>
    <meta name="robots" content="follow, index, max-snippet:-1, max-image-preview:large"/>
    <!-- meta tags site details -->
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="website" />
    <?php 
    if($meta_title!="")
    {
    ?>
    <meta property="og:title" content="<?=$meta_title;?> | <?php echo SITETITLE; ?>" />
    <?php
    }
    else
    {
    ?>
    <meta property="og:title" content="<?=$meta_title;?>" />
    <?php
    }
    ?>
    <meta property="og:description" content="<?=$meta_description;?>" />
    <meta property="og:url" content="<?=$actual_link;?>" />
    <meta property="og:site_name" content="<?php echo SITETITLE; ?>" />
    <?php

    /*if($brand_img_url)
    {
        $metatag_image = $brand_img_url;
        $metatag_image_width = "350";
        $metatag_image_height = "175";
        ?>
        <meta property="og:image" content="<?=$metatag_image?>" />
        <?php
    }
    else
    {*/
        $metatag_image = SITEURL."common/images/logo.png";
        $metatag_image_width = "1282";
        $metatag_image_height = "676";
        ?>
        <meta property="og:image" content="<?=$metatag_image?>" />
        <?php
    //}
    ?>
    <meta property="og:image:secure_url" content="<?= SITEURL?>common/images/logo.png" />
    <meta property="og:image:width" content="<?=$metatag_image_width;?>" />
    <meta property="og:image:height" content="<?=$metatag_image_height;?>" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:description" content="<?=$meta_description;?>" />
    <?php 
    if($meta_title!="")
    {
    ?>
    <meta name="twitter:title" content="<?=$meta_title;?> | <?php echo SITETITLE; ?>" />
    <?php
    }
    else
    {
    ?>
    <meta name="twitter:title" content="<?=$meta_title;?>" />
    <?php
    }
    ?>
    <meta name="twitter:image" content="<?=$metatag_image?>" />
    <!-- end meta tags site details -->
</head>

<body>
    <!-- Header Area Start -->
    <?php include('include_header.php'); ?>
    <!-- Header Area End -->

    <div class="product-list-section">
        <div class="brand-banner-section">
            <div class="row justify-content-center align-items-center text-center h-100">
                <div class="col-12 col-md-12 h-100">
                    <div class="outer-border-section h-100">
                        <div class="border-logo-text h-100">
    						<h3 class="banner-brand-name"><?=$brand_name;?></h3>
    						<div class="logo-text-p">
                                <?=$brand_short_desc;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="shop-area ptb-80">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="shop-content-wrapper d-flex">
                                <div class="shop-results d-flex">
                                    <span class="word-break white-space">Sort By : </span>
                                    <select name="sortData" id="sortData" onChange="sortData();" class="float-right" style="width:250px">
                                        <option value="">Select option</option>
                                        <option value="price-ASC">Price Low to High</option>
                                        <option value="price-DESC">Price High to Low</option>
                                        <option value="name-ASC">A-Z</option>
                                        <option value="name-DESC">Z-A</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-md-6 justify-content-start">
                            <h4>Living Room</h4>
                        </div> -->
                    </div>
                    <div class="front-loading-div" style="display:none;">
                        <div><img style="width:10%" src="<?php echo SITEURL."common/images/loader.svg"?>" /></div>
                    </div>
                    <div class="row flex-lg-nowrap justify-content-lg-center">
                        <!-- <div class="col-xl-3 col-lg-4 pt-30 pl-40">
                            <div class="collapse-sidebar-filter d-block d-lg-none text-center">
								<a class="btn btn-light-black text-uppercase" data-toggle="collapse" href="#collapse-filter-options" role="button" aria-expanded="false" aria-controls="collapseExample">
								    Filter By
								</a>
							</div>
                            <div class="sidebar-widget widget-style-1 panel-group border-0 p-0" id="widget-parent" aria-multiselectable="true" role="tablist">
                               <h4 class="d-none d-lg-block">Shop By</h4>
								<div class="collapse mt-3 border-filter" id="collapse-filter-options">
                                    <form name="FillterColorData" id="FillterColorData" method="POST">
                                    <?php 
                                    $cate_r = $db->rpgetData("product","cate_id","pro_feature_brand='".$brand_id."' AND isDelete=0 group by pro_feature_brand");
                                    $cate_c = @mysqli_num_rows($cate_r);
                                    if($cate_c > 0)
                                    {
                                    ?>
                                    <div class="panel widget-option">
                                        <a class="collapsed" data-toggle="collapse" href="#category_section" data-parent="#widget-parent">Category</a>
                                        <div class="collapse show" id="category_section">
                                            <div class="collapse-content">
                                                <?php 
                                                while($cate_d = @mysqli_fetch_array($cate_r))
                                                {
                                                $total_cate = $db->rpgetTotalRecord("product","pro_feature_brand='".$brand_id."' AND cate_id='".$cate_d['cate_id']."' AND isDelete=0");
                                                $cate_name = $db->rpgetValue("category","name","id='".$cate_d['cate_id']."' and isDelete=0");
                                                ?>
                                                <div class="single-widget-opt">
                                                    <input type="checkbox" name="cate_id[]" id="cate_<?=$cate_d['cate_id'];?>" value="<?=$cate_d['cate_id'];?>"  onClick="sortData();">
                                                    <label for="cate_<?=$cate_d['cate_id'];?>"><?=ucwords($cate_name);?> <span>(<?=$total_cate;?>)</span></label>
                                                </div>
                                                <?php
                                                } 
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    }

                                    $add_label_r = $db->rpgetData("product_additional_field_details","*","isDelete=0 AND pid IN (select id from product where pro_feature_brand='".$brand_id."' AND isDelete=0)  group by additional_field_id","id DESC");
                                    while($add_label_d = @mysqli_fetch_array($add_label_r))
                                    {
                                        $add_label_nm = $db->rpgetValue("additional_field","name","id='".$add_label_d['additional_field_id']."'");
                                    ?>
                                    <div class="panel widget-option">
                                        <a class="collapsed" data-toggle="collapse" href="#additional_<?=$add_label_d['id']?>_section" data-parent="#widget-parent"><?=ucwords($add_label_nm);?></a>
                                        <div class="collapse" id="additional_<?=$add_label_d['id']?>_section">
                                            <div class="collapse-content">
                                                <?php 
                                                $exp_add_field_val_ids = explode(",",$add_label_d['additional_field_val_ids']);
                                                foreach ($exp_add_field_val_ids as $key => $value) 
                                                {
                                                $add_field_val_nm = $db->rpgetValue("additional_field_value","name","id='".$value."'");
                                                $total_add_label = $db->rpgetTotalRecord("product_additional_field_details","pid IN (select id from product where pro_feature_brand='".$brand_id."' AND isDelete=0) AND isDelete=0 AND additional_field_id='".$add_label_d['additional_field_id']."' AND FIND_IN_SET(".$value.",additional_field_val_ids)");
                                                ?>
                                                <div class="single-widget-opt">
                                                    <input type="checkbox" name="add_field_val[<?=$add_label_d['additional_field_id']?>][]" id="add_filed_label_<?=$value;?>" value="<?=$value;?>" onClick="sortData();">
                                                    <label for="add_filed_label_<?=$value;?>"><?=ucwords($add_field_val_nm);?> <span>(<?=$total_add_label;?>)</span></label>
                                                </div>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php 
                                    }

                                    $color_r = $db->rpgetData("color","*","isDelete=0");
                                    $color_c = @mysqli_num_rows($color_r);
                                    if($color_c > 0)
                                    {
                                    ?>
                                    <div class="panel widget-option">
                                        <a class="collapsed" data-toggle="collapse" href="#color_section" data-parent="#widget-parent">Color</a>
                                        <div class="collapse" id="color_section">
                                            <div class="collapse-content">
                                                <?php 
                                                while($color_d = @mysqli_fetch_array($color_r))
                                                {
                                                $total_color = $db->rpgetTotalRecord("product","pro_feature_brand='".$brand_id."' AND color_id='".$color_d['id']."' AND isDelete=0");
                                                ?>
                                                <div class="single-widget-opt">
                                                    <input type="checkbox" name="color_id[]" id="color_<?=$color_d['id'];?>" value="<?=$color_d['id'];?>"  onClick="sortData();">
                                                    <label for="color_<?=$color_d['id'];?>"><?=ucwords($color_d['name']);?> <span>(<?=$total_color;?>)</span></label>
                                                </div>
                                                <?php
                                                } 
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php 
                                    }

                                    $material_r = $db->rpgetData("material","*","isDelete=0");
                                    $material_c = @mysqli_num_rows($material_r);
                                    if($material_c > 0)
                                    {
                                    ?>
                                    <div class="panel widget-option">
                                        <a class="collapsed" data-toggle="collapse" href="#material_section" data-parent="#widget-parent">Material</a>
                                        <div class="collapse" id="material_section">
                                            <div class="collapse-content">
                                                <?php 
                                                while($material_d = @mysqli_fetch_array($material_r))
                                                {
                                                $total_material = $db->rpgetTotalRecord("product","pro_feature_brand='".$brand_id."' AND material_id='".$material_d['id']."' AND isDelete=0");
                                                ?>
                                                <div class="single-widget-opt">
                                                    <input type="checkbox" name="material_id[]" id="material_<?=$material_d['id'];?>" value="<?=$material_d['id'];?>"  onClick="sortData();">
                                                    <label for="material_<?=$material_d['id'];?>"><?=ucwords($material_d['name']);?> <span>(<?=$total_material;?>)</span></label>
                                                </div>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php 
                                    }
                                    ?>
                                    <div class="panel widget-option">
                                        <a class="collapsed" data-toggle="collapse" href="#price_section" data-parent="#widget-parent">Price</a>
                                        <div class="collapse" id="price_section">
                                            <div class="collapse-content">
                                                <?php 
                                                $price_array = range(0,3000,500);
                                                $count_price_array = count($price_array);
                                                foreach ($price_array as $key => $value) 
                                                {
                                                    $last_price = " - ".$price_array[$key+1];
                                                    if($key == ($count_price_array - 1))
                                                    {
                                                        $last_price = " And Above";
                                                    }

                                                    $price_range = explode(" - ",$value.$last_price);
                                                    $price_range_0  = $price_range[0];
                                                    $price_range_1  = $price_range[1];

                                                    if($price_range_0 == "3000 And Above")
                                                    {   
                                                        $price_range    = explode(" And ",$price_range_0);
                                                        $price_range_0  = $price_range[0];
                                                        $price_range_1  = "1000000";
                                                    }

                                                    $total_price_range = $db->rpgetTotalRecord("product","pro_feature_brand='".$brand_id."' AND price BETWEEN '".$price_range_0."' AND '".$price_range_1."' AND isDelete=0");
                                                ?>
                                                <div class="single-widget-opt">
                                                    <input type="radio" id="price_<?=$value;?>" name="price_range" value="<?=$value.$last_price;?>"  onClick="sortData();">
                                                    <label for="price_<?=$value;?>"><?php echo $value.$last_price;?> <span>(<?=$total_price_range;?>)</span></label>
                                                </div>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div> -->

                        <div class="col-xl-12 col-lg-12 mt-5 p-0">
                            <div class="ht-product-shop tab-content">
                                <div class="tab-pane active show fade text-center" id="grid" role="tabpanel">
                                    <div class="row w-lg-100 mx-0" id="results">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Area Start -->
    <?php include('include_footer.php'); ?>
    <!-- Footer Area End -->

    <!-- all js here -->
    <?php include('include_js.php'); ?>
    <script type="text/javascript">
        $(document).ready(function(){
            view_product();
        });

        function view_product()
        {
            var FillterColorData    = $('#FillterColorData').serialize();
            var sortData            = $("#sortData").val();

            $.ajax({
                type: "POST",
                cache: false,
                url: "<?php echo SITEURL; ?>ajax_get_productlist_featured_brandwise.php",
                data: "ajax=true&brand_id=<?=$brand_id;?>&sortData="+sortData+"&"+FillterColorData,
                beforeSend: function(){
                    $(".front-loading-div").show();
                },
                success: function(html) 
                {
                    setTimeout(function(){
                        $(".front-loading-div").hide();
                        $("#results").empty();
                        $("#results").html(html);
                    },1500);
                }
            });
        }

        function sortData()
        {
            $("#results").html("");
            view_product();
        }
    </script>
</body>
</html>