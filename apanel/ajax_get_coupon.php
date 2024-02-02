<?php
include("connect.php");
$ctable 		= "coupon";

if(isset($_REQUEST['searchName']) && $_REQUEST['searchName']!=""){
	$ctable_where .= " (
                            name like '%".$_REQUEST['searchName']."%' OR
                            code like '%".$_REQUEST['searchName']."%' OR
                            type like '%".$_REQUEST['searchName']."%' OR
                            amount like '%".$_REQUEST['searchName']."%' OR
                            min_spend_amount like '%".$_REQUEST['searchName']."%'   
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
            <th>Name</th>
            <th>Code</th>
            <th>Type</th>
            <th>Amount</th>
            <th>Min Spend Amt.</th>
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
            <td><?php echo stripslashes($ctable_d['name']); ?></td>
            <td><?php echo stripslashes($ctable_d['code']); ?></td>
            <td><?php echo stripslashes($ctable_d['type']); ?></td>
            <td><?php echo $dis_amount; ?></td>
            <td><?php echo CURR."".stripslashes($ctable_d['min_spend_amount']); ?></td>
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
