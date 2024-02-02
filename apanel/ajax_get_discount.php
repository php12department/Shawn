<?php
include("connect.php");
$ctable 		= "discount";

if(isset($_REQUEST['searchName']) && $_REQUEST['searchName']!=""){
	$ctable_where .= " (
                            cate_id IN (select id from category where name like '%".$_REQUEST['searchName']."%') OR
                            sub_cate_id IN (select id from sub_category where name like '%".$_REQUEST['searchName']."%') OR
                            sub_sub_cate_id IN (select id from sub_sub_category where name like '%".$_REQUEST['searchName']."%') OR
                            disc_desc like '%".$_REQUEST['searchName']."%' OR
                            type like '%".$_REQUEST['searchName']."%' OR
                            amount like '%".$_REQUEST['searchName']."%'   
						) AND ";
}

$ctable_where .= " isDelete=0";
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
            <th>Category Name</th>
            <th>Desc</th>
            <th>Type</th>
            <th>Amount</th>
            <th>Start Date</th>
            <th>Expiration</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
    if(@mysqli_num_rows($ctable_r)>0){
        $count = 0;
        while($ctable_d = @mysqli_fetch_array($ctable_r)){
			$count++;

            $cate_name = $db->rpgetValue("category","name","isDelete = 0 AND id=".$ctable_d['cate_id']."");
            $sub_cate_name = $db->rpgetValue("sub_category","name","isDelete = 0 AND id=".$ctable_d['sub_cate_id']."");
            $sub_sub_cate_name = $db->rpgetValue("sub_sub_category","name","isDelete = 0 AND id=".$ctable_d['sub_sub_cate_id']."");

            $dis_cate_name = $cate_name;
            if($ctable_d['sub_cate_id']!=0 && $ctable_d['sub_cate_id']!="")
            {
                $dis_cate_name.= " >> ".$sub_cate_name;
            }
            if($ctable_d['sub_sub_cate_id']!=0 && $ctable_d['sub_sub_cate_id']!="")
            {
                $dis_cate_name.= " >> ".$sub_sub_cate_name;
            }

            if($ctable_d['type']=='percent')
            {
                $dis_amount = stripslashes($ctable_d['amount'])."%";
            }
            else
            {
                $dis_amount = CURR."".stripslashes($ctable_d['amount']);
            }
    	?>
        <tr>
            <td><?php echo $count+$page_position; ?></td>
            <td><?php echo stripslashes($dis_cate_name); ?></td>
            <td><?php echo stripslashes($ctable_d['disc_desc']); ?></td>
            <td><?php echo stripslashes($ctable_d['type']); ?></td>
            <td><?php echo $dis_amount; ?></td>
            <td><?php echo stripslashes($ctable_d['start_date']); ?></td>
            <td><?php echo stripslashes($ctable_d['expiration_date']); ?></td>
			<td>
                <a href="<?php echo ADMINURL?>add-<?php echo str_replace("_", "-", $ctable); ?>/edit/<?php echo $ctable_d['id']; ?>/" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit">
                  <i class="la la-edit"></i>
                </a>
                <a onClick="del_conf('<?php echo $ctable_d['id']; ?>');" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
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
