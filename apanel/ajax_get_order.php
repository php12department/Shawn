<?php
include("connect.php");
$ctable         = "cartdetails";

if(isset($_REQUEST['searchName']) && $_REQUEST['searchName']!=""){
  $ctable_where .= " (
                        fname like '%".$_REQUEST['searchName']."%' OR
                        lname like '%".$_REQUEST['searchName']."%' OR
                        email like '%".$_REQUEST['searchName']."%' OR
                        finaltotal like '%".$_REQUEST['searchName']."%' OR
                        orderdate like '%".$_REQUEST['searchName']."%'  
            ) AND ";
}

$ctable_where .= " isDelete=0 AND orderstatus!=1";
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
$ctable_r = $db->rpgetData($ctable,"*",$ctable_where,"cart_id DESC limit $page_position, $item_per_page");
?>
<table id="kt_table_1" class="table table-striped- table-bordered table-hover table-checkable">
    <thead>
        <tr>
            <th>No.</th>
            <th>Name</th>
            <th>Email</th>
            <th>Price</th>
            <th>Order Id</th>
            <th>Order Date</th>
            <th>Order Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
    if(@mysqli_num_rows($ctable_r)>0)
    {
        $count = 0;
        while($ctable_d = @mysqli_fetch_array($ctable_r))
        {
            $count++;

            $userdetail_r=$db->rpgetData("user","*","`id`='".$ctable_d['uid']."'");
            $userdetail_d=@mysqli_fetch_array($userdetail_r);
            ?>
            <tr>
                <td><?php echo $count+$page_position; ?></td>
                <td><?php echo stripslashes($ctable_d['fname'])." ".stripslashes($ctable_d['lname']); ?></td>
                <td><?php echo stripslashes($ctable_d['email']); ?></td>
                <td><?php echo CURR.stripslashes($ctable_d['finaltotal']); ?></td>
                <td><a href="javascript:;"><?php echo $ctable_d['cart_id'];?></a></td>
                <td><?php echo stripslashes($ctable_d['orderdate']); ?></td>
                <td><?php echo $db->order_status_with_label($ctable_d['orderstatus']); ?></td>
                <td>
                    <a href="<?php echo ADMINURL?>view-order/<?php echo $ctable_d['cart_id']; ?>/" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View">
                      <i class="la la-eye"></i>
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
