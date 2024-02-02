<div class="col-lg-3 col-md-4 col-12 pb-4 pb-md-0">
    <div class="sidebar-box">
        <ul class="custom-nav">
            <li><a <?php if($current_page=="My Account"){ echo 'class="active"';}?> href="<?php echo SITEURL;?>my-account/">My Account</a></li>
            <li><a <?php if($current_page=="Change Password"){ echo 'class="active"';}?> href="<?php echo SITEURL?>change-password/">Change Password</a></li>
            <li><a <?php if($current_page=="Wishlist"){ echo 'class="active"';}?> href="<?php echo SITEURL;?>wishlist/">Wishlist</a></li>
            <li><a <?php if($current_page=="My Orders"){ echo 'class="active"';}?> href="<?php echo SITEURL;?>orders/">My Order</a></li>
            <li><a href="<?php echo SITEURL;?>logout/">Logout</a></li>
        </ul>
    </div>
</div>