<header class="site-header">
    <div class="top-header" style="background-color: black;">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-2 col-md-2 col-sm-2">
                    <div class="small-icon phone">
                        <img src="<?= SITEURL ?>common/images/small-logo.png" alt="<?php echo SITETITLE; ?>">

                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-10">
                    <div class="top-call-location-fix">
                        <a href="tel:<?= $telephone_number; ?>"><img src="<?= SITEURL ?>/assets/new_home/img/home/phone.svg"> &nbsp; <?= $telephone_number; ?></a>
                        <a href="https://www.google.com/maps?ll=33.072124,-96.688704&z=16&t=m&hl=en-US&gl=US&mapclient=embed&cid=3052341362603140637"><img src="<?= SITEURL ?>/assets/new_home/img/home/location.svg"> &nbsp; 7265 Central Expressway Plano, Texas 75025</a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12">
                    <div class="social-media-icon-fix">
                        <?php
                        if ($facebook_link != "") {
                        ?>
                            <a href="<?= $facebook_link; ?>"><img src="<?= SITEURL ?>images/fb_icon.png" alt="<?php echo SITETITLE; ?>"></a>
                        <?php
                        }

                        if ($twitter_link != "") {
                        ?>
                            <a href="<?= $twitter_link; ?>"><img src="<?= SITEURL ?>images/twitter_logo_blue.png" alt="<?php echo SITETITLE; ?>"></a>
                        <?php
                        }

                        if ($instagram_link != "") {
                        ?>
                            <a href="<?= $instagram_link; ?>"><img src="<?= SITEURL ?>images/instagram (1).png" alt="<?php echo SITETITLE; ?>"></a>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- desktop menu start -->
    <div class="main-navabr" id="desktop-menu">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand" href="<?= SITEURL ?>"><img src="<?= SITEURL ?>common/images/logo.png" alt="<?php echo SITETITLE; ?>"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto">
                        <?php
                            $menu_cate_r = $db->rpgetData("category", "*", "isDelete=0", "display_order ASC");
                            //$menu_cate_r = $db->rpgetData("category", "*", "isDelete=0 AND id=1", "display_order ASC");
                            $menu_cate_c = @mysqli_num_rows($menu_cate_r);
                            if ($menu_cate_c > 0)
                            {
                                while ($menu_cate_d = @mysqli_fetch_array($menu_cate_r)) 
                                {
                                    $menu_sub_cate_r = $db->rpgetData("sub_category", "*", "cate_id='" . $menu_cate_d['id'] . "' AND isDelete=0");
									$menu_sub_cate_c = @mysqli_num_rows($menu_sub_cate_r);
                                    $dis_menu_url 		= "javascript:void(0)";
                                    if ($menu_sub_cate_c > 0) {
                                        $dis_menu_url = SITEURL . "product-category/" . $menu_cate_d['slug'] . "/";
                                    } else {
                                        $dis_menu_url = SITEURL . "products/" . $menu_cate_d['slug'] . "/";
                                    }
                                    ?>
                                        <li class="nav-item menu-dropdown">
                                        <a class="nav-link" href="<?php echo $dis_menu_url; ?>"><?= $menu_cate_d['name'] ?></a>
                                        <?php
                                        if ($menu_sub_cate_c > 0) 
                                        {
                                            ?>
                                                <ul class="list-inline megamenu">
                                                    <li class="sub-menu-item-name">
                                                        <?php
                                                        $single_menu_sub_cate_r = $db->rpgetData("sub_category", "*", "cate_id='" . $menu_cate_d['id'] . "' AND isDelete=0 AND id NOT IN (select sub_cate_id from sub_sub_category where cate_id='" . $menu_cate_d['id'] . "' AND isDelete=0)", "");
                                                        $single_menu_sub_cate_c = @mysqli_num_rows($single_menu_sub_cate_r);
                                                        if ($single_menu_sub_cate_c > 0) 
                                                        {
                                                            ?>
                                                                
                                                                        <ul class="list-inline">
                                                                            <?php
                                                                                while ($single_menu_sub_cate_d = @mysqli_fetch_array($single_menu_sub_cate_r)) 
                                                                                {
                                                                                    $dis_sub_menu_url = SITEURL . "products/" . $menu_cate_d['slug'] . "/" . $single_menu_sub_cate_d['slug'] . "/";
                                                                                    ?>
                                                                                        <li><a href="<?php echo $dis_sub_menu_url; ?>"><?= $single_menu_sub_cate_d['name'] ?></a></li>
                                                                                    <?php
                                                                                }
                                                                            ?>
                                                                        </ul>
                                                                
                                                            <?php
                                                        }
                                                        $multi_menu_sub_cate_r = $db->rpgetData("sub_category", "*", "cate_id='" . $menu_cate_d['id'] . "' AND isDelete=0 AND id IN (select sub_cate_id from sub_sub_category where cate_id='" . $menu_cate_d['id'] . "' AND isDelete=0)", "");
                                                        $multi_menu_sub_cate_c = @mysqli_num_rows($multi_menu_sub_cate_r);
                                                        if ($multi_menu_sub_cate_c > 0)
                                                        {
                                                            while ($multi_menu_sub_cate_d = @mysqli_fetch_array($multi_menu_sub_cate_r))
                                                            {
                                                                $dis_sub_menu_url = SITEURL . "products/" . $menu_cate_d['slug'] . "/" . $multi_menu_sub_cate_d['slug'] . "/";
                                                                $menu_sub_sub_cate_r = $db->rpgetData("sub_sub_category", "*", "cate_id='" . $menu_cate_d['id'] . "' AND sub_cate_id = '" . $multi_menu_sub_cate_d['id'] . "' AND isDelete=0");
                                                                $menu_sub_sub_cate_c = @mysqli_num_rows($menu_sub_sub_cate_r);
                                                                ?>
                                                                
                                                                <?php
                                                                if ($menu_sub_sub_cate_c > 0) 
                                                                {
                                                                    ?>
                                                                         <ul class="list-inline">
                                                                                        <li class="menu-title"><a href="<?= $dis_sub_menu_url; ?>"><b><?= $multi_menu_sub_cate_d['name'] ?></b></a></li>
                                                                            <?php
                                                                                while ($menu_sub_sub_cate_d = @mysqli_fetch_array($menu_sub_sub_cate_r)) 
                                                                                {
                                                                                    $dis_sub_sub_menu_url = SITEURL . "products/" . $menu_cate_d['slug'] . "/" . $multi_menu_sub_cate_d['slug'] . "/" . $menu_sub_sub_cate_d['slug'] . "/";
                                                                                    ?>
                                                                                   
                                                                                        <li><a href="<?= $dis_sub_sub_menu_url; ?>"><?php echo $menu_sub_sub_cate_d['name']; ?></a></li>
                                                                                        
                                                                                    <?php
                                                                                }
                                                                            ?>
                                                                            </ul>
                                                                    
                                                                    <?php
                                                                }
                                                                ?>
                                                                
                                                                
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </li>
                                                </ul>  
                                            <?php
                                        }
                                        echo "</li>";
                                } 
                                ?>
                                
                             
                                <?php
                            }
                        ?>
                        <li class="nav-item menu-dropdown">
                            <a class="nav-link" href="<?= SITEURL ?>store-locations/">Location</a>
                            <ul class="list-inline megamenu">
                                <li class="sub-menu-item-name">
                                    <ul class="list-inline">
                                        <li><a href="<?= SITEURL ?>store-details/">Plano, TX</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    
                </ul>
                
                <ul class="navbar-nav right-navbar">
                    <form action="<?php echo SITEURL; ?>search/" method="GET" class="header-search">
                        <li class="nav-item search-input">
                            <input class="nav-link" type="text" placeholder="Search..." value="" maxlength="70" name="r">
                            <i class="fa-regular fa-magnifying-glass mr-3"></i>
                        </li>
                    </form>
                    <li class="nav-item search-input">
                        <a class="nav-link" data-toggle="dropdown" href="javascript:void(0)"><i class="fa-regular fa-cart-shopping"></i></a>
                        <div class="dropdown-menu cart-dropdown fixed-height-cart-dropdown header_cart"></div>
                    </li>
                    <li class="nav-item search-input">
                        <?php
                            if (isset($_SESSION[SESS_PRE . '_SESS_USER_ID']) && $_SESSION[SESS_PRE . '_SESS_USER_ID'] > 0)
                            {
                                ?>
                                    <a class="nav-link" data-toggle="dropdown" href="<?= SITEURL; ?>login/"><i class="fa-regular fa-user"></i></a>
                                    <div class="dropdown-menu user-profile">
                                        <a href="<?php echo SITEURL ?>my-account/" class="dropdown-item">My Account</a>
                                        <a href="<?php echo SITEURL ?>change-password/" class="dropdown-item">Change Password</a>
                                        <a href="<?php echo SITEURL ?>logout/" class="dropdown-item">Log Out</a>
                                      </div>
                                <?php
                            }
                            else
                            {
                                ?>
                                    <a class="nav-link" href="<?= SITEURL; ?>login/"><i class="fa-regular fa-user"></i></a>
                                <?php
                            }
						?>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <!-- desktop menu End -->

    <!-- mobile menu start -->
    <div class="main-navabr" id="mobile-menu">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand" href="<?= SITEURL ?>"><img src="<?= SITEURL ?>common/images/logo.png"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="sidebar-navigation">

                    <ul>
                    <?php
                            $menu_cate_r = $db->rpgetData("category", "*", "isDelete=0", "display_order ASC");
                            //$menu_cate_r = $db->rpgetData("category", "*", "isDelete=0 AND id=1", "display_order ASC");
                            $menu_cate_c = @mysqli_num_rows($menu_cate_r);
                            if ($menu_cate_c > 0)
                            {
                                while ($menu_cate_d = @mysqli_fetch_array($menu_cate_r)) 
                                {
                                    $menu_sub_cate_r = $db->rpgetData("sub_category", "*", "cate_id='" . $menu_cate_d['id'] . "' AND isDelete=0");
									$menu_sub_cate_c = @mysqli_num_rows($menu_sub_cate_r);
                                    $dis_menu_url 		= "javascript:void(0)";
                                    if ($menu_sub_cate_c > 0) {
                                        $dis_menu_url = SITEURL . "product-category/" . $menu_cate_d['slug'] . "/";
                                    } else {
                                        $dis_menu_url = SITEURL . "products/" . $menu_cate_d['slug'] . "/";
                                    }
                                    ?>
                                        <li><a href="<?php echo $dis_menu_url; ?>"><?= $menu_cate_d['name'] ?> <em class="mdi mdi-chevron-down"></em></a>
                                            <?php
                                                if ($menu_sub_cate_c > 0) 
                                                {
                                                    ?>
                                                    <ul>
                                                        <?php
                                                            $single_menu_sub_cate_r = $db->rpgetData("sub_category", "*", "cate_id='" . $menu_cate_d['id'] . "' AND isDelete=0 AND id NOT IN (select sub_cate_id from sub_sub_category where cate_id='" . $menu_cate_d['id'] . "' AND isDelete=0)", "");
                                                            $single_menu_sub_cate_c = @mysqli_num_rows($single_menu_sub_cate_r);
                                                            if ($single_menu_sub_cate_c > 0) 
                                                            {
                                                               while ($single_menu_sub_cate_d = @mysqli_fetch_array($single_menu_sub_cate_r)) 
                                                                {
                                                                    $dis_sub_menu_url = SITEURL . "products/" . $menu_cate_d['slug'] . "/" . $single_menu_sub_cate_d['slug'] . "/";
                                                                    ?>
                                                                        <li><a href="<?php echo $dis_sub_menu_url; ?>"><?= $single_menu_sub_cate_d['name'] ?></a></li>
                                                                    <?php
                                                                }
                                                                $multi_menu_sub_cate_r = $db->rpgetData("sub_category", "*", "cate_id='" . $menu_cate_d['id'] . "' AND isDelete=0 AND id IN (select sub_cate_id from sub_sub_category where cate_id='" . $menu_cate_d['id'] . "' AND isDelete=0)", "");
                                                                $multi_menu_sub_cate_c = @mysqli_num_rows($multi_menu_sub_cate_r);
                                                                if ($multi_menu_sub_cate_c > 0)
                                                                {
                                                                    while ($multi_menu_sub_cate_d = @mysqli_fetch_array($multi_menu_sub_cate_r))
                                                                    {
                                                                        $dis_sub_menu_url = SITEURL . "products/" . $menu_cate_d['slug'] . "/" . $multi_menu_sub_cate_d['slug'] . "/";
                                                                        $menu_sub_sub_cate_r = $db->rpgetData("sub_sub_category", "*", "cate_id='" . $menu_cate_d['id'] . "' AND sub_cate_id = '" . $multi_menu_sub_cate_d['id'] . "' AND isDelete=0");
                                                                        $menu_sub_sub_cate_c = @mysqli_num_rows($menu_sub_sub_cate_r);
                                                                        ?>
                                                                        
                                                                        <?php
                                                                        if ($menu_sub_sub_cate_c > 0) 
                                                                        {
                                                                            ?>
                                                                            <li><a href="<?= $dis_sub_menu_url; ?>"><b><?= $multi_menu_sub_cate_d['name'] ?></b></a></li>
                                                                            <?php
                                                                                while ($menu_sub_sub_cate_d = @mysqli_fetch_array($menu_sub_sub_cate_r)) 
                                                                                {
                                                                                    $dis_sub_sub_menu_url = SITEURL . "products/" . $menu_cate_d['slug'] . "/" . $multi_menu_sub_cate_d['slug'] . "/" . $menu_sub_sub_cate_d['slug'] . "/";
                                                                                    ?>
                                                                                   
                                                                                        <li><a href="<?= $dis_sub_sub_menu_url; ?>"><?php echo $menu_sub_sub_cate_d['name']; ?></a></li>
                                                                                        
                                                                                    <?php
                                                                                }
                                                                            ?>
                                                                            <?php
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        ?>
                                                    </ul>
                                                    <?php
                                                }
                                            ?>
                                        </li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                </div>
                <ul class="navbar-nav right-navbar">
                    <form action="<?php echo SITEURL; ?>search/" method="GET" class="header-search">
                        <li class="nav-item search-input">
                            <input class="nav-link" type="text" placeholder="Search..." value="" maxlength="70" name="r">
                            <i class="fa-regular fa-magnifying-glass mr-3"></i>
                        </li>
                    </form>
                    <li class="nav-item search-input">
                        <a class="nav-link" href="javascript:void(0)"><i class="fa-regular fa-cart-shopping"></i></a>
                    </li>

                    <li class="nav-item search-input">
                    <?php
                            if (isset($_SESSION[SESS_PRE . '_SESS_USER_ID']) && $_SESSION[SESS_PRE . '_SESS_USER_ID'] > 0)
                            {
                                ?>
                                    <a class="nav-link" data-toggle="dropdown" href="<?= SITEURL; ?>login/"><i class="fa-regular fa-user"></i></a>
                                    <div class="dropdown-menu user-profile">
                                        <a href="<?php echo SITEURL ?>my-account/" class="dropdown-item">My Account</a>
                                        <a href="<?php echo SITEURL ?>change-password/" class="dropdown-item">Change Password</a>
                                        <a href="<?php echo SITEURL ?>logout/" class="dropdown-item">Log Out</a>
                                      </div>
                                <?php
                            }
                            else
                            {
                                ?>
                                    <a class="nav-link" href="<?= SITEURL; ?>login/"><i class="fa-regular fa-user"></i></a>
                                <?php
                            }
						?>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <!-- mobile menu end -->

</header>