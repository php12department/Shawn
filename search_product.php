<?php
include('connect.php'); 
$current_page = "Search Product";
$r  = $db->clean($_REQUEST['r']);
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <title><?php echo $r; ?> | <?php echo SITETITLE; ?></title>
    <?php include('include_css.php'); ?>
    <meta name="robots" content="follow, index, max-snippet:-1, max-image-preview:large"/>
</head>

<body>
    <!-- Header Area Start -->
    <?php include('include_header.php'); ?>
    <!-- Header Area End -->

    <div class="product-list-section">
        <div class="banner" style="background-image: url('<?= SITEURL?>assets/img/product/house-753271_1280.jpg')">
          <!--  <img class="primary-image" src="<?= SITEURL?>assets/img/product/mo-2.jpg" alt=""> -->
          <div class="container">
              <div class="row justify-content-center align-items-center">
                  <div class="col-md-12 text-center">
                      <h1><?=$r;?></h1>
                      <nav aria-label="breadcrumb">
                            <ul class="breadcrumb justify-content-center">
                                <li class="breadcrumb-item"><a href="<?= SITEURL?>">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Shop</li>
                            </ul>
                        </nav>
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
                                    $cate_r = $db->rpgetData("product","cate_id","name LIKE '%".$r."%' AND isDelete=0 group by cate_id");
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
                                                $total_cate = $db->rpgetTotalRecord("product","name LIKE '%".$r."%' AND cate_id='".$cate_d['cate_id']."' AND isDelete=0");
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

                                    $add_label_r = $db->rpgetData("product_additional_field_details","*","isDelete=0 AND pid IN (select id from product where name LIKE '%".$r."%' AND isDelete=0) group by additional_field_id","id DESC");
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
                                                $total_add_label = $db->rpgetTotalRecord("product_additional_field_details","pid IN (select id from product where name LIKE '%".$r."%' AND isDelete=0) AND isDelete=0 AND additional_field_id='".$add_label_d['additional_field_id']."' AND FIND_IN_SET(".$value.",additional_field_val_ids)");
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
                                                $total_color = $db->rpgetTotalRecord("product","name LIKE '%".$r."%' AND color_id='".$color_d['id']."' AND isDelete=0");
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
                                                $total_material = $db->rpgetTotalRecord("product","name LIKE '%".$r."%' AND material_id='".$material_d['id']."' AND isDelete=0");
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

                                                    $total_price_range = $db->rpgetTotalRecord("product","name LIKE '%".$r."%' AND price BETWEEN '".$price_range_0."' AND '".$price_range_1."' AND isDelete=0");
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
                url: "<?php echo SITEURL; ?>ajax_get_search_products.php",
                data: "ajax=true&s=<?php echo $r; ?>&sortData="+sortData+"&"+FillterColorData,
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