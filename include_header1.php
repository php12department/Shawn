<header class="header-area mobile-header-page">
	<!--Header Top Area Start -->
	<div class="header-top order-0">
		<div class="header-container htp">
			<div class="row justify-content-between">
				<div class="col-md-12">
					<div class="p-span-header mobile d-block d-lg-none">
						<div class="top">
							<span class="phone">
								<img src="<?= SITEURL ?>common/images/small-logo.png" alt="<?php echo SITETITLE; ?>">
							</span>
							<span>
								<div class="social-icon-header">
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
							</span>
						</div>
						<div class="bottom">
							<span class="phone d-flex align-items-center">
								<!-- <img src="<?= SITEURL ?>images/m41.png" alt="<?php echo SITETITLE; ?>"> -->
								<i class="fa fa-mobile" aria-hidden="true" style="font-size: 25px;color: #fff;"></i>
								<a class="mobile-device-sty" href="tel:<?= $telephone_number; ?>"><?= $telephone_number; ?></a>
							</span>
							<a href="https://www.google.com/maps?ll=33.072124,-96.688704&z=16&t=m&hl=en-US&gl=US&mapclient=embed&cid=3052341362603140637">
								<span class="phone d-flex align-items-center">
									<!-- <img src="<?= SITEURL ?>images/c-40.png" alt="<?php echo SITETITLE; ?>"> -->
									<i class="fa fa-map-marker" aria-hidden="true" style="font-size: 20px;color: #fff;"></i>
									<!--<span class="py-0">Monday - Saturday 10:00 AM - 8:00 PM  &nbsp;&nbsp;&nbsp; Sunday 12:00 PM - 6:00 PM</span>-->
									<span class="py-0 mobile-dis">7265 Central Expressway Plano, Texas 75025 <br>United States (US)</span>
									<span class="py-0 des-dis">7265 Central Expressway Plano, Texas 75025 &nbsp;United States (US)</span>
								</span>
							</a>
						</div>
					</div>
					<div class="p-span-header d-none d-lg-flex">
						<!-- <span class="text-capitalize">Welcome to the world of <?php echo SITETITLE; ?>!</span> -->
						<div class="left">
							<span class="phone">
								<img src="<?= SITEURL ?>common/images/small-logo.png" alt="<?php echo SITETITLE; ?>">
							</span>
							<span class="phone">
								<!-- <img src="<?= SITEURL ?>images/m41.png" alt="<?php echo SITETITLE; ?>"> -->
								<!-- <i class="fa fa-mobile" aria-hidden="true" style="font-size: 35px;color: #fff;"></i> -->
								<i class="fa fa-mobile" aria-hidden="true" style="font-size: 20px;color: #fff;"></i>
								<a class="mobile-device-sty" href="tel:<?= $telephone_number; ?>"><?= $telephone_number; ?></a>
							</span>
							<a href="https://www.google.com/maps?ll=33.072124,-96.688704&z=16&t=m&hl=en-US&gl=US&mapclient=embed&cid=3052341362603140637">
								<span class="phone">
									<!-- <img src="<?= SITEURL ?>images/c-40.png" alt="<?php echo SITETITLE; ?>"> -->
									<!-- <i class="fa fa-clock" style="font-size: 25px;color: #fff;"></i> -->
									<i class="fa fa-map-marker" style="font-size: 18px;color: #fff;"></i>
									<!--<span><?= $header_store_hours; ?></span>-->
									<!--<span>Monday - Saturday 10:00 AM - 8:00 PM  &nbsp;&nbsp;&nbsp; Sunday 12:00 PM - 6:00 PM</span>-->
									<span class="py-0 mobile-dis">7265 Central Expressway Plano, Texas 75025 </span>
									<span class="py-0 des-dis">7265 Central Expressway Plano, Texas 75025</span>
									<!-- <span class="py-0 mobile-dis">Monday - Friday 10:00 AM - 7:00 PM <br> Saturday 10:00 PM - 8:00 PM <br> Sunday 12:00 PM - 6:00 PM</span>
								<span class="py-0 des-dis">Monday - Friday 10:00 AM - 7:00 PM &nbsp;&nbsp;&nbsp; Saturday 10:00 PM - 8:00 PM &nbsp;&nbsp;&nbsp; Sunday 12:00 PM - 6:00 PM</span> -->
								</span>
							</a>
						</div>
						<div class="right">
							<div class="social-icon-header">
								<a href="https://www.facebook.com/zillifurniture"><img src="<?= SITEURL ?>images/fb_icon.png" alt="<?php echo SITETITLE; ?>"></a>

								<a href="https://twitter.com/zillifurniture1"><img src="<?= SITEURL ?>images/twitter_logo_blue.png" alt="<?php echo SITETITLE; ?>"></a>

								<a href="https://www.instagram.com/zillifurniture/"><img src="<?= SITEURL ?>images/instagram (1).png" alt="<?php echo SITETITLE; ?>"></a>
								<!--<a href="javascript:void(0)"><img src="<?= SITEURL ?>images/yt-n.png"/></a>-->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--Header Top Area End -->

	<!--Header Middle Area Start -->
	<div class="header-middle-area order-2 order-lg-1">
		<div class="header-container p-md-0">
			<div class="row mx-md-0 mx-lg-2 mx-xl-0">
				<div class="col-12">
					<div class="row justify-content-between">
						<div class="col-6 col-md-7 col-xl-7 d-none d-lg-flex p-lg-0">
							<div class="logo">
								<a href="<?= SITEURL ?>"><img src="<?= SITEURL ?>common/images/logo.png" alt="<?php echo SITETITLE; ?>"></a>
							</div>
						</div>
						<div class="col-12 col-lg-5 col-xl-5 top-col top-col-mobile">
							<form action="<?php echo SITEURL; ?>search/" method="GET" class="header-search">
								<input type="text" autocomplete="off" placeholder="Search here..." value="" maxlength="70" name="r">
								<button><i class="icon icon-Search"></i></button>
							</form>
							<div class="cart-box-wrapper">
								<a class="cart-info" href="javascript:void(0)">
									<span>
										<img src="<?= SITEURL ?>images/cart.png" alt="<?php echo SITETITLE; ?>">
										<!-- <i class="fa fa-shopping-cart" style="font-size: 25px;margin-top: 10px;"></i> -->
									</span>
								</a>
								<div class="cart-dropdown fixed-height-cart-dropdown header_cart">

								</div>
							</div>
							<div class="cart-box-wrapper">
								<?php
								if (isset($_SESSION[SESS_PRE . '_SESS_USER_ID']) && $_SESSION[SESS_PRE . '_SESS_USER_ID'] > 0) {
								?>
									<!--<a class="cart-info" href="<?php echo SITEURL ?>my-account/">-->
									<!--	<span>-->
									<!--		<img src="<?= SITEURL ?>images/user1.png" class="cart" alt="">-->
									<!--	</span>-->
									<!--</a>-->
									<div class="dropdown after-login-admin">
										<button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<a class="cart-info" href="javascript:void(0);">
												<span>
													<img src="<?= SITEURL ?>images/user.png" class="cart" alt="<?php echo SITETITLE; ?>">
												</span>
											</a>
										</button>
										<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
											<a class="dropdown-item" href="<?php echo SITEURL ?>my-account/"><i class="pr-3 fa fa-user" aria-hidden="true"></i>My Account</a>

											<a class="dropdown-item" href="<?php echo SITEURL ?>change-password/"><i class="pr-3 fa fa-lock" aria-hidden="true"></i>Change Password</a>

											<a class="dropdown-item" href="<?php echo SITEURL ?>logout/"><i class="pr-3 fa fa-sign-out" aria-hidden="true"></i>Log Out</a>
										</div>
									</div>
								<?php
								} else {
								?>
									<a class="cart-info" href="<?= SITEURL; ?>login/">
										<span>
											<img src="<?= SITEURL ?>images/user.png" class="cart" alt="<?php echo SITETITLE; ?>">
										</span>
									</a>
								<?php
								}
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--Header Middle Area End -->

	<!-- Mainmenu Area Start -->
	<div class="mainmenu-area header-sticky display-none order-0 order-lg-2">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<div class="menu-wrapper">
						<div class="main-menu">
							<nav>
								<ul>
									<?php
									$menu_cate_r = $db->rpgetData("category", "*", "isDelete=0", "display_order ASC");
									$menu_cate_c = @mysqli_num_rows($menu_cate_r);
									if ($menu_cate_c > 0) {
										while ($menu_cate_d = @mysqli_fetch_array($menu_cate_r)) {
											$menu_sub_cate_r = $db->rpgetData("sub_category", "*", "cate_id='" . $menu_cate_d['id'] . "' AND isDelete=0");
											$menu_sub_cate_c = @mysqli_num_rows($menu_sub_cate_r);

											$dis_menu_url 		= "javascript:void(0)";
											if ($menu_sub_cate_c > 0) {
												$dis_menu_url = SITEURL . "product-category/" . $menu_cate_d['slug'] . "/";
											} else {
												$dis_menu_url = SITEURL . "products/" . $menu_cate_d['slug'] . "/";
											}

											$check_is_megamenu = $db->rpgetTotalRecord("sub_sub_category", " cate_id='" . $menu_cate_d['id'] . "' AND isDelete = 0");

											$dis_megamenu_class = "";
											if ($check_is_megamenu > 0) {
												$dis_megamenu_class = 'class="megamenu"';
											}
									?>
											<li <?= $dis_megamenu_class; ?>>
												<a href="<?= $dis_menu_url; ?>" class="text-uppercase">
													<?= $menu_cate_d['name'] ?></a>
												<?php
												if ($menu_sub_cate_c > 0) {
												?>
													<ul>
														<?php
														$single_menu_sub_cate_r = $db->rpgetData("sub_category", "*", "cate_id='" . $menu_cate_d['id'] . "' AND isDelete=0 AND id NOT IN (select sub_cate_id from sub_sub_category where cate_id='" . $menu_cate_d['id'] . "' AND isDelete=0)", "");
														$single_menu_sub_cate_c = @mysqli_num_rows($single_menu_sub_cate_r);
														if ($single_menu_sub_cate_c > 0) {
														?>
															<li>
																<ul>
																	<?php
																	while ($single_menu_sub_cate_d = @mysqli_fetch_array($single_menu_sub_cate_r)) {
																		$dis_sub_menu_url = SITEURL . "products/" . $menu_cate_d['slug'] . "/" . $single_menu_sub_cate_d['slug'] . "/";
																	?>
																		<li class="border-0 mb-0 pb-0"><a href="<?= $dis_sub_menu_url; ?>" class="text-capitalize"><?= $single_menu_sub_cate_d['name'] ?></a></li>
																	<?php
																	}
																	?>

																</ul>
															</li>
															<?php
														}

														$multi_menu_sub_cate_r = $db->rpgetData("sub_category", "*", "cate_id='" . $menu_cate_d['id'] . "' AND isDelete=0 AND id IN (select sub_cate_id from sub_sub_category where cate_id='" . $menu_cate_d['id'] . "' AND isDelete=0)", "");
														$multi_menu_sub_cate_c = @mysqli_num_rows($multi_menu_sub_cate_r);
														if ($multi_menu_sub_cate_c > 0) {
															while ($multi_menu_sub_cate_d = @mysqli_fetch_array($multi_menu_sub_cate_r)) {
																$dis_sub_menu_url = SITEURL . "products/" . $menu_cate_d['slug'] . "/" . $multi_menu_sub_cate_d['slug'] . "/";

																$menu_sub_sub_cate_r = $db->rpgetData("sub_sub_category", "*", "cate_id='" . $menu_cate_d['id'] . "' AND sub_cate_id = '" . $multi_menu_sub_cate_d['id'] . "' AND isDelete=0");
																$menu_sub_sub_cate_c = @mysqli_num_rows($menu_sub_sub_cate_r);

																if ($menu_sub_sub_cate_c > 0) {
															?>
																	<li>
																		<ul class="sub-cat-list">
																			<li><a href="<?= $dis_sub_menu_url; ?>"><b><?= $multi_menu_sub_cate_d['name'] ?></b></a></li>
																			<?php
																			while ($menu_sub_sub_cate_d = @mysqli_fetch_array($menu_sub_sub_cate_r)) {
																				$dis_sub_sub_menu_url = SITEURL . "products/" . $menu_cate_d['slug'] . "/" . $multi_menu_sub_cate_d['slug'] . "/" . $menu_sub_sub_cate_d['slug'] . "/";
																			?>
																				<li><a href="<?= $dis_sub_sub_menu_url; ?>"><?= $menu_sub_sub_cate_d['name'] ?></a></li>
																			<?php
																			}
																			?>
																		</ul>
																	</li>
														<?php
																}
															}
														}
														?>
													</ul>
												<?php
												}
												?>
											</li>
											<!-- <li>
												<a href="<?= $dis_menu_url; ?>" class="text-capitalize">
												<?= $menu_cate_d['name'] ?></a>
												<?php
												if ($menu_sub_cate_c > 0) {
												?>
												<ul>
													<?php
													while ($menu_sub_cate_d = @mysqli_fetch_array($menu_sub_cate_r)) {
														$dis_sub_menu_url = SITEURL . "products/" . $menu_cate_d['slug'] . "/" . $menu_sub_cate_d['slug'] . "/";
													?>
													<li><a href="<?= $dis_sub_menu_url; ?>" class="text-capitalize"><?= $menu_sub_cate_d['name'] ?></a></li>
													<?php
													}
													?>
												</ul>
												<?php
												}
												?>
											</li> -->
									<?php
										}
									}
									?>
									<li><a href="<?= SITEURL ?>store-locations/" class="text-uppercase">
											Location</a>
										<ul>
											<li><a href="<?= SITEURL ?>store-details/" class="text-capitalize">Plano, TX</a></li>
										</ul>
									</li>
								</ul>
							</nav>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Mainmenu Area End -->

	<!-- Mobile Menu Area Start -->
	<div class="mobile-menu-area container order-1 order-lg-0">
		<div class="mobile-menu">
			<div class="logo mobile-logo">
				<a href="<?= SITEURL ?>"><img src="<?= SITEURL ?>common/images/logo.png" alt="<?php echo SITETITLE; ?>"></a>
			</div>
			<nav id="mobile-menu-active">
				<ul class="menu-overflow">
					<?php
					$menu_cate_r = $db->rpgetData("category", "*", "isDelete=0", "display_order ASC");
					$menu_cate_c = @mysqli_num_rows($menu_cate_r);
					if ($menu_cate_c > 0) {
						while ($menu_cate_d = @mysqli_fetch_array($menu_cate_r)) {
							$menu_sub_cate_r = $db->rpgetData("sub_category", "*", "cate_id='" . $menu_cate_d['id'] . "' AND isDelete=0");
							$menu_sub_cate_c = @mysqli_num_rows($menu_sub_cate_r);

							$dis_menu_url 		= "javascript:void(0)";
							if ($menu_sub_cate_c > 0) {
								$dis_menu_url = SITEURL . "product-category/" . $menu_cate_d['slug'] . "/";
							} else {
								$dis_menu_url = SITEURL . "products/" . $menu_cate_d['slug'] . "/";
							}

							$check_is_megamenu = $db->rpgetTotalRecord("sub_sub_category", " cate_id='" . $menu_cate_d['id'] . "' AND isDelete = 0");

							$dis_megamenu_class = "";
							if ($check_is_megamenu > 0) {
								$dis_megamenu_class = 'class="megamenu"';
							}
					?>
							<li <?= $dis_megamenu_class; ?> class="open-li">
								<a href="<?= $dis_menu_url; ?>" class="text-uppercase">
									<?= $menu_cate_d['name'] ?></a>
								<?php
								if ($menu_sub_cate_c > 0) {
								?>
									<ul>
										<?php
										$single_menu_sub_cate_r = $db->rpgetData("sub_category", "*", "cate_id='" . $menu_cate_d['id'] . "' AND isDelete=0 AND id NOT IN (select sub_cate_id from sub_sub_category where cate_id='" . $menu_cate_d['id'] . "' AND isDelete=0)", "");
										$single_menu_sub_cate_c = @mysqli_num_rows($single_menu_sub_cate_r);
										if ($single_menu_sub_cate_c > 0) {
										?>
											<li>
												<ul>
													<?php
													while ($single_menu_sub_cate_d = @mysqli_fetch_array($single_menu_sub_cate_r)) {
														$dis_sub_menu_url = SITEURL . "products/" . $menu_cate_d['slug'] . "/" . $single_menu_sub_cate_d['slug'] . "/";
													?>
														<li class="border-0 mb-0 pb-0"><a href="<?= $dis_sub_menu_url; ?>" class="text-capitalize"><?= $single_menu_sub_cate_d['name'] ?></a></li>
													<?php
													}
													?>

												</ul>
											</li>
											<?php
										}

										$multi_menu_sub_cate_r = $db->rpgetData("sub_category", "*", "cate_id='" . $menu_cate_d['id'] . "' AND isDelete=0 AND id IN (select sub_cate_id from sub_sub_category where cate_id='" . $menu_cate_d['id'] . "' AND isDelete=0)", "");
										$multi_menu_sub_cate_c = @mysqli_num_rows($multi_menu_sub_cate_r);
										if ($multi_menu_sub_cate_c > 0) {
											while ($multi_menu_sub_cate_d = @mysqli_fetch_array($multi_menu_sub_cate_r)) {
												$dis_sub_menu_url = SITEURL . "products/" . $menu_cate_d['slug'] . "/" . $multi_menu_sub_cate_d['slug'] . "/";

												$menu_sub_sub_cate_r = $db->rpgetData("sub_sub_category", "*", "cate_id='" . $menu_cate_d['id'] . "' AND sub_cate_id = '" . $multi_menu_sub_cate_d['id'] . "' AND isDelete=0");
												$menu_sub_sub_cate_c = @mysqli_num_rows($menu_sub_sub_cate_r);

												if ($menu_sub_sub_cate_c > 0) {
											?>
													<li>
														<ul>
															<li><a href="<?= $dis_sub_menu_url; ?>"><b><?= $multi_menu_sub_cate_d['name'] ?></b></a></li>
															<?php
															while ($menu_sub_sub_cate_d = @mysqli_fetch_array($menu_sub_sub_cate_r)) {
																$dis_sub_sub_menu_url = SITEURL . "products/" . $menu_cate_d['slug'] . "/" . $multi_menu_sub_cate_d['slug'] . "/" . $menu_sub_sub_cate_d['slug'] . "/";
															?>
																<li><a href="<?= $dis_sub_sub_menu_url; ?>"><?= $menu_sub_sub_cate_d['name'] ?></a></li>
															<?php
															}
															?>
														</ul>
													</li>
										<?php
												}
											}
										}
										?>
									</ul>
								<?php
								}
								?>
							</li>
							<!-- <li>
								<a href="<?= $dis_menu_url; ?>" class="text-capitalize">
								<?= $menu_cate_d['name'] ?></a>
								<?php
								if ($menu_sub_cate_c > 0) {
								?>
								<ul>
									<?php
									while ($menu_sub_cate_d = @mysqli_fetch_array($menu_sub_cate_r)) {
										$dis_sub_menu_url = SITEURL . "products/" . $menu_cate_d['slug'] . "/" . $menu_sub_cate_d['slug'] . "/";
									?>
									<li><a href="<?= $dis_sub_menu_url; ?>" class="text-capitalize"><?= $menu_sub_cate_d['name'] ?></a></li>
									<?php
									}
									?>
								</ul>
								<?php
								}
								?>
							</li> -->
					<?php
						}
					}
					?>
					<li><a href="<?= SITEURL ?>store-locations/" class="text-capitalize">
							Location</a>
						<ul>
							<li><a href="<?= SITEURL ?>store-details/" class="text-capitalize">Plano, TX</a></li>
						</ul>
					</li>
				</ul>
			</nav>
		</div>
	</div>
	<!-- Mobile Menu Area End -->

</header>