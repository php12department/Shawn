<?php
include("connect.php");
$ctable 		                = "alt_image";
$IMAGEPATH_PRO_ALT_T            = PRODUCT_ALT_T;
$IMAGEPATH_PRO_ALT_A            = PRODUCT_ALT_A;
$IMAGEPATH_PRO_ALT              = PRODUCT_ALT;
$IMAGEPATH_PRO_ALT_THUMB_A      = PRODUCT_ALT_THUMB_A;
$pid                            = $_REQUEST['pid'];

if(isset($_REQUEST['searchName']) && $_REQUEST['searchName']!=""){
	$ctable_where .= " (
                            image_path like '%".$_REQUEST['searchName']."%' OR
                            display_order like '%".$_REQUEST['searchName']."%' 
						) AND ";
}

$ctable_where .= "pid='".$pid."' AND isDelete=0";
$item_per_page =  ($_REQUEST["show"] <> "" && is_numeric($_REQUEST["show"]) ) ? intval($_REQUEST["show"]) : 10;

if(isset($_REQUEST["page"]) && $_REQUEST["page"]!=""){
	$page_number = filter_var($_REQUEST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
	if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
}else{
	$page_number = 1; //if there's no page number, set it to 1
}

$get_total_rows = $db->rpgetTotalRecord($ctable,$ctable_where); //hold total records in variable

//break records into pages
$total_pages = ceil($get_total_rows/$item_per_page);

//get starting position to fetch the records
$page_position = (($page_number-1) * $item_per_page);
$pagiArr = array($item_per_page, $page_number, $get_total_rows, $total_pages);
$ctable_r = $db->rpgetData($ctable,"*",$ctable_where,"id DESC limit $page_position, $item_per_page");
?>
<table id="kt_table_1" class="table table-striped- table-bordered table-hover table-checkable">
    <thead>
        <tr>
            <th>No.</th>
            <th class="text-center">Is Image?</th>
            <th class="text-center">Image</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
    if(@mysqli_num_rows($ctable_r)>0){
        $count = 0;
        while($ctable_d = @mysqli_fetch_array($ctable_r)){
			$count++;

            $dis_isImage = "";
            if($ctable_d['isImage'] == 0)
            {
                $dis_isImage = "None";
            }
            else if($ctable_d['isImage'] == 1)
            {
                $dis_isImage = "Left";
            }
            else if($ctable_d['isImage'] == 2)
            {
                $dis_isImage = "Right";
            }
    	?>
        <tr>
            <td><?php echo $count+$page_position; ?></td>
			<td class="text-center"><?=$dis_isImage;?></td>
            <td class="text-center">
                <?php 
                if(!empty($ctable_d['image_path']) && file_exists($IMAGEPATH_PRO_ALT_THUMB_A.$ctable_d['image_path']))
                {
                ?>
                <img height="50" width="50" src="<?php echo ADMINURL.$IMAGEPATH_PRO_ALT_THUMB_A.$ctable_d['image_path']; ?>" alt="<?php echo stripslashes($ctable_d['image_path']); ?>" />
                <?php 
                }
                else
                {
                    echo "No Image Available.";
                }
                ?>
            </td>
			<td>
                <a href="<?php echo ADMINURL?>add-<?php echo str_replace("_", "-", $ctable); ?>/edit/<?php echo $ctable_d['id']; ?>/<?php echo $ctable_d['pid'];?>/" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit">
                  <i class="la la-edit"></i>
                </a>
                <a onClick="del_conf('<?php echo $ctable_d['id']; ?>','<?php echo $ctable_d['pid']; ?>');" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                  <i class="la la-trash-o"></i>
                </a>
            </td>
        </tr>
    	<?php
        }
    }
    ?>
    </tbody>
</table>
<?php 
	$db->rpgetTablePaginationBlock($pagiArr);
?>
