<header class="site-header">
    <div class="top-header">
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
                    <li class="nav-item menu-dropdown">
                        <a class="nav-link" href="#">Living </a>
                        <ul class="list-inline megamenu">
                            <li class="sub-menu-item-name">
                                <ul class="list-inline">
                                    <li><a href="#">Sofas | Sofa Sets</a></li>
                                    <li><a href="#">Sectionals</a></li>
                                    <li><a href="#">Sleeper Sofas</a></li>
                                    <li><a href="#">Recliners</a></li>
                                    <li><a href="#">Ottomans | Benches</a></li>
                                    <li><a href="#">Accent Chairs | Chaises</a></li>
                                    <li><a href="#">Stools</a></li>
                                </ul>
                                <ul class="list-inline">
                                    <li class="menu-title"><a href="#"><b>Tables</b></a></li>
                                    <li><a href="#">Coffee Tables | End Tables</a></li>
                                    <li><a href="#">Console Tables</a></li>
                                    <li><a href="#">Accent Tables</a></li>
                                </ul>
                                <ul class="list-inline">
                                    <li class="menu-title"><a href="#"><b>Home Entertainment</b></a></li>
                                    <li><a href="#">TV Stands | Wall Unit</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">Dining</a>
                        <ul class="list-inline megamenu">
                            <li class="sub-menu-item-name">
                                <ul class="list-inline">
                                    <li><a href="#">Dining Tables</a></li>
                                    <li><a href="#">Dining Chairs</a></li>
                                    <li><a href="#">Sideboards | Buffets</a></li>
                                    <li><a href="#">Curios | Bookcases</a></li>
                                    <li><a href="#">Bars | Bar Tables</a></li>
                                    <li><a href="#">Benches</a></li>
                                    <li><a href="#">Mirror</a></li>
                                    <li><a href="#">Bar Cabinet</a></li>
                                    <li><a href="#">Cabinet</a></li>
                                    <li><a href="#">China Cabinet</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Bedroom</a>
                        <ul class="list-inline megamenu">
                            <li class="sub-menu-item-name">
                                <ul class="list-inline">
                                    <li><a href="#">Sofas | Sofa Sets</a></li>
                                    <li><a href="#">Sectionals</a></li>
                                    <li><a href="#">Sleeper Sofas</a></li>
                                    <li><a href="#">Recliners</a></li>
                                    <li><a href="#">Ottomans | Benches</a></li>
                                    <li><a href="#">Accent Chairs | Chaises</a></li>
                                    <li><a href="#">Stools</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Office</a>
                        <ul class="list-inline megamenu">
                            <li class="sub-menu-item-name">
                                <ul class="list-inline">
                                    <li><a href="#">Sofas | Sofa Sets</a></li>
                                    <li><a href="#">Sectionals</a></li>
                                    <li><a href="#">Sleeper Sofas</a></li>
                                    <li><a href="#">Recliners</a></li>
                                    <li><a href="#">Ottomans | Benches</a></li>
                                    <li><a href="#">Accent Chairs | Chaises</a></li>
                                    <li><a href="#">Stools</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Mattresses</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Rugs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">ART/Accessories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Lighting</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Blinds/Shades</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Sales</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Message Chairs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Location</a>
                    </li>
                </ul>
                <ul class="navbar-nav right-navbar">
                    <li class="nav-item search-input">
                        <input class="nav-link" type="text" placeholder="Search...">
                        <i class="fa-regular fa-magnifying-glass mr-3"></i>
                    </li>
                    <li class="nav-item search-input">
                        <a class="nav-link" href="#"><i class="fa-regular fa-cart-shopping"></i></a>
                    </li>
                    <li class="nav-item search-input">
                        <a class="nav-link" href="#"><i class="fa-regular fa-user"></i></a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <!-- desktop menu End -->

    <!-- mobile menu start -->
    <!-- <div class="main-navabr" id="mobile-menu">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand" href="#"><img src="img/logo/main.png"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="sidebar-navigation">

                    <ul>
                        <li><a href="#">Living <em class="mdi mdi-chevron-down"></em></a>
                            <ul>
                                <li><a href="#">Sofas | Sofa Sets</a></li>
                                <li><a href="#">Sectionals</a></li>
                                <li><a href="#">Sleeper Sofas</a></li>
                                <li><a href="#">Recliners</a></li>
                                <li><a href="#">Ottomans | Benches</a></li>
                                <li><a href="#">Accent Chairs | Chaises</a></li>
                                <li><a href="#">Stools</a></li>
                                <li><a href="#"><b>Tables</b></a></li>
                                <li><a href="#">Coffee Tables | End Tables</a></li>
                                <li><a href="#">Console Tables</a></li>
                                <li><a href="#">Accent Tables</a></li>
                                <li><a href="#"><b>Home Entertainment</b></a></li>
                                <li><a href="#">TV Stands | Wall Unit</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Dining <em class="mdi mdi-chevron-down"></em></a>
                            <ul>
                                <li><a href="#">Dining Tables</a></li>
                                <li><a href="#">Dining Chairs</a></li>
                                <li><a href="#">Sideboards | Buffets</a></li>
                                <li><a href="#">Curios | Bookcases</a></li>
                                <li><a href="#">Bars | Bar Tables</a></li>
                                <li><a href="#">Benches</a></li>
                                <li><a href="#">Mirror</a></li>
                                <li><a href="#">Bar Cabinet</a></li>
                                <li><a href="#">Cabinet</a></li>
                                <li><a href="#">China Cabinet</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Bedroom <em class="mdi mdi-chevron-down"></em></a>
                            <ul>
                                <li><a href="#">Dining Tables</a></li>
                                <li><a href="#">Dining Chairs</a></li>
                                <li><a href="#">Sideboards | Buffets</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Office <em class="mdi mdi-chevron-down"></em></a>
                            <ul>
                                <li><a href="#">Dining Tables</a></li>
                                <li><a href="#">Dining Chairs</a></li>
                                <li><a href="#">Sideboards | Buffets</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Mattresses <em class="mdi mdi-chevron-down"></em></a>
                            <ul>
                                <li><a href="#">Dining Tables</a></li>
                                <li><a href="#">Dining Chairs</a></li>
                                <li><a href="#">Sideboards | Buffets</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Rugs <em class="mdi mdi-chevron-down"></em></a>
                            <ul>
                                <li><a href="#">Dining Tables</a></li>
                                <li><a href="#">Dining Chairs</a></li>
                                <li><a href="#">Sideboards | Buffets</a></li>
                            </ul>
                        </li>
                        <li><a href="#">ART/Accessories <em class="mdi mdi-chevron-down"></em></a>
                            <ul>
                                <li><a href="#">Dining Tables</a></li>
                                <li><a href="#">Dining Chairs</a></li>
                                <li><a href="#">Sideboards | Buffets</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Lighting <em class="mdi mdi-chevron-down"></em></a>
                            <ul>
                                <li><a href="#">Dining Tables</a></li>
                                <li><a href="#">Dining Chairs</a></li>
                                <li><a href="#">Sideboards | Buffets</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Blinds/Shades <em class="mdi mdi-chevron-down"></em></a>
                            <ul>
                                <li><a href="#">Dining Tables</a></li>
                                <li><a href="#">Dining Chairs</a></li>
                                <li><a href="#">Sideboards | Buffets</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Sales<em class="mdi mdi-chevron-down"></em></a>
                            <ul>
                                <li><a href="#">Dining Tables</a></li>
                                <li><a href="#">Dining Chairs</a></li>
                                <li><a href="#">Sideboards | Buffets</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Message Chairs<em class="mdi mdi-chevron-down"></em></a>
                            <ul>
                                <li><a href="#">Dining Tables</a></li>
                                <li><a href="#">Dining Chairs</a></li>
                                <li><a href="#">Sideboards | Buffets</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Location<em class="mdi mdi-chevron-down"></em></a>
                            <ul>
                                <li><a href="#">Dining Tables</a></li>
                                <li><a href="#">Dining Chairs</a></li>
                                <li><a href="#">Sideboards | Buffets</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <ul class="navbar-nav right-navbar">
                    <li class="nav-item search-input">
                        <input class="nav-link" type="text" placeholder="Search...">
                        <i class="fa-regular fa-magnifying-glass mr-3"></i>
                    </li>
                    <li class="nav-item search-input">
                        <a class="nav-link" href="#"><i class="fa-regular fa-cart-shopping"></i></a>
                    </li>
                    <li class="nav-item search-input">
                        <a class="nav-link" href="#"><i class="fa-regular fa-user"></i></a>
                    </li>
                </ul>
            </div>
        </nav>
    </div> -->
    <!-- mobile menu end -->

</header>