<?php
include("connect.php");
$ctable 	= "events_comment";
$event_id   = $_REQUEST['event_id'];

if(isset($_REQUEST['searchName']) && $_REQUEST['searchName']!=""){
	$ctable_where .= " (
                            event_desc like '%".$_REQUEST['searchName']."%' OR
                            user_id like (select id from user where first_name like '%".$_REQUEST['searchName']."%') OR
                            user_id like (select id from user where last_name like '%".$_REQUEST['searchName']."%')
						) AND ";
}

$ctable_where .= "event_id='".$event_id."' AND isDelete=0";
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
            <th class="text-center">User Name</th>
            <th>Description</th>
            <th>Comment Date</th>
            <th>Is Approve?</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
    if(@mysqli_num_rows($ctable_r)>0){
        $count = 0;
        while($ctable_d = @mysqli_fetch_array($ctable_r)){
			$count++;

            $fname = $db->rpgetValue("user","first_name","id='".$ctable_d['user_id']."'");
            $lname = $db->rpgetValue("user","last_name","id='".$ctable_d['user_id']."'");

            $tablename = base64_encode($ctable);
            $tableId = base64_encode('id');
            $ischecked = $ctable_d['status'] == 'Y' ? 'checked="checked"' : '';
            $status = $ctable_d['status'] == 'N' ? 'N' : 'Y'; 
    	?>
        <tr>
            <td><?php echo $count+$page_position; ?></td>
			<td class="text-center"><?=$fname." ".$lname;?></td>
            <td><?=stripslashes($ctable_d['event_desc']);?></td>
            <td><?=date("d M Y h:i A",strtotime($ctable_d['adate']));?></td>
            <td>
                <span class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success">
                    <label>
                        <input class="changeStatus" data-id="<?= $ctable_d['id'];?>" data-status="<?= $status; ?>" data-td="<?=$tablename; ?>" data-i="<?= $tableId; ?>" type="checkbox"  <?=$ischecked;?>>
                        <span></span>
                    </label>
                </span>
            </td>
			<td>
                <!-- <a href="<?php echo ADMINURL?>add-<?php echo str_replace("_", "-", $ctable); ?>/edit/<?php echo $ctable_d['id']; ?>/<?php echo $ctable_d['event_id'];?>/" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit">
                  <i class="la la-edit"></i>
                </a> -->
                <a onClick="del_conf('<?php echo $ctable_d['id']; ?>','<?php echo $ctable_d['event_id']; ?>');" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
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
