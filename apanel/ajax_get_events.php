<?php

include("connect.php");

$IMAGEPATH_T        = EVENT_T;
$IMAGEPATH_A        = EVENT_A; 
$IMAGEPATH          = EVENT;
$IMAGEPATH_THUMB_A  = EVENT_THUMB_A;

$ctable 			= "events";

if(isset($_REQUEST['searchName']) && $_REQUEST['searchName']!=""){
	$ctable_where .= " (
                            title like '%".$_REQUEST['searchName']."%' OR
                            description like '%".$_REQUEST['searchName']."%' OR
                            added_by like '%".$_REQUEST['searchName']."%' OR
                            image_path like '%".$_REQUEST['searchName']."%' OR
                            event_date like '%".$_REQUEST['searchName']."%' OR
                            event_cat like (select id from events_category where cat_name like '%".$_REQUEST['searchName']."%')
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
            <th>Image</th>
            <th>Event/News Category Name</th>
            <th>Event/News Name</th>
            <th>Author Name</th>
            <!-- <th>Description</th> -->
            <th width="17%">Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
    if(@mysqli_num_rows($ctable_r)>0)
    {
	    $count = 0;
	    while($ctable_d = @mysqli_fetch_array($ctable_r)){
			$count++;
            $cate_name = $db->rpgetValue("events_category","cat_name","isDelete = 0 AND id=".$ctable_d['event_cat']."");
		?>
	    <tr>
	        <td><?php echo $count+$page_position; ?></td>
			<td class="text-center">
				<?php if(!empty($ctable_d['image_path'])){?>
					<img height="50" width="50" src="<?php echo ADMINURL.$IMAGEPATH_THUMB_A.$ctable_d['image_path']; ?>" alt="<?php echo stripslashes($ctable_d['title']); ?>" />
				<?php }?>
			</td>
            <td><?php echo ucfirst($cate_name); ?></td>
            <td><?php echo stripslashes(ucfirst($ctable_d['title'])); ?></td>
            <td><?php echo stripslashes(ucfirst($ctable_d['added_by'])); ?></td>
	        <!-- <td><?php echo $db->rplimitChar(Strip_tags($ctable_d['description']),40); ?></td> -->
	        <td>
                <a href="<?php echo ADMINURL?>add-<?php echo str_replace("_", "-", "events-news"); ?>/edit/<?php echo $ctable_d['id']; ?>/" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit">
                  <i class="la la-edit"></i>
                </a>

                <a onClick="del_conf('<?php echo $ctable_d['id']; ?>');" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                  <i class="la la-trash-o"></i>
                </a>

                <a target="_blank" class="btn btn-sm btn-clean" title="View Comments" href="<?php echo ADMINURL?>manage-events-comment/<?php echo $ctable_d['id']; ?>/"><i class="la la-comment"></i> Comments (<?php echo $db->rpgetTotalRecord("events_comment","isDelete=0 AND event_id=".$ctable_d['id']); ?>)</a>
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
