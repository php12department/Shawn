<?php
include("connect.php");

$data = $_REQUEST;
if(isset($_POST["page"]))
{
  $page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
  if(!is_numeric($page_number))
  {
    die('Invalid page number!');
  } //incase of invalid page number
}
else
{
  $page_number = 1; //if there's no page number, set it to 1
}

$uid =  $_SESSION[SESS_PRE.'_SESS_USER_ID']; 

$get_total_rows = $db->rpgetTotalRecord("cartdetails","uid='".$uid."' AND isDelete=0 AND orderstatus!='1'");
$item_per_page = '5';
$total_pages = ceil($get_total_rows/$item_per_page);
$page_position = (($page_number-1) * $item_per_page);

$orderBy = "";
$orderBy = " cart_id DESC limit $page_position, $item_per_page";

$ctable_r = $db->rpgetData("cartdetails","*","uid='".$uid."' AND isDelete=0 AND orderstatus!='1'",$orderBy);
?>
<div class="wishlist-table table-responsive">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Order Date</th>
                <th>Price</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if(@mysqli_num_rows($ctable_r) >0)
        {
            $sr = 1;
            while($ctable_d = @mysqli_fetch_array($ctable_r))
            { 
            $link = SITEURL."order-details/".md5($ctable_d['cart_id'])."/"; 
            ?> 
              <tr>
                  <td><?php echo $page_position+$sr; $sr++; ?></td>
                  <td><?php echo date('M d, Y',strtotime($ctable_d['orderdate'])); ?></td>
                  <td><?php echo CURR.$ctable_d['finaltotal']; ?></td>
                  <td><span class="badge"><?php echo $db->order_status_arr($ctable_d['orderstatus']);?></span></td>
                  <td class="product-add-to-cart"><a href="<?= $link; ?>"> View Details</a></td>
              </tr>
            <?php
            }
        }
        else
        {
        ?>
          <tr><td colspan="6"><center>No record found.</center></td></tr>
        <?php 
        }
        ?>
        </tbody>
    </table>
</div>  
<?php 
echo $db->paginate_function($item_per_page, $page_number, $get_total_rows, $total_pages); 
?>