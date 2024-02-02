<footer class="footer-area mt-minus-five">
	<div class="footer-top pt-80 pb-80">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-5 mb-3 mb-md-0">
					<div class="single-footer-widget border-variant">
						<div class="footer-logo">
							<a href="<?= SITEURL?>"><img src="<?= SITEURL?>common/images/logo.png" alt="<?php echo SITETITLE; ?>"></a>
						</div>
						<h2 class="signup-title">signup for our news letter</h2>
						<div class="newsletter-form mc_embed_signup">
							<form action="javascript:;" name="frmsubscribe" id="frmsubscribe" method="post" class="validate">
								<div id="mc_embed_signup_scroll" class="mc-form">
									<input type="email" name="email" class="email" id="email" placeholder="Enter your email address" required>
									<!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
									<div class="mc-news" aria-hidden="true">
										<input type="text" name="" tabindex="-1" value="">
									</div>
									<button type="submit" name="subscribe" id="subscribe">Subscribe</button>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="col-lg-2 col-md-3 mb-3 mb-md-0">
					<div class="single-footer-widget">
						<h4>COMPANY</h4>
						<ul class="footer-widget-list">
							<li><a href="<?= SITEURL?>about-us/">About us</a></li>
							<li><a href="<?= SITEURL?>contact-us/">Contact us</a></li>
							<li><a href="<?= SITEURL?>careers/">Careers</a></li>
							<li><a href="<?= SITEURL?>news-and-events/">News & events</a></li>
							<li><a href="<?= SITEURL?>custom-orders/">Custom orders</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-2 col-md-4 mb-3 mb-md-0">
					<div class="single-footer-widget">
						<h4>SERVICES</h4>
						<ul class="footer-widget-list">
							<li><a href="<?= SITEURL?>shipping-information/">Shipping Information</a></li>
							<li><a href="<?= SITEURL?>financing/">Financing</a></li>
							<li><a href="<?= SITEURL?>accidental-damage-protection/">Accidental Damage Protection</a></li>
							<li><a href="<?= SITEURL?>customer-gallary/">Customer Gallary</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-2 col-md-5 mb-3 mb-md-0">
					<div class="single-footer-widget">
						<h4>HELP</h4>
						<ul class="footer-widget-list">
							<li><a href="<?= SITEURL?>returns-and-exchanges/">Returns & Exchanges</a></li>
							<li><a href="<?= SITEURL?>privacy-policy/">Privacy Policy</a></li>
							<li><a href="<?= SITEURL?>furniture-care/">Furniture Care</a></li>
							<!-- <li><a href="<?= SITEURL?>faqs/">FAQs</a></li> -->
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 mb-3 mb-md-0">
					<div class="single-footer-widget">
						<h4>CONTACT</h4>
						<ul class="footer-widget-list">
							<li class="footer-icons">
								<a href="tel:<?= $telephone_number;?>">
									<img src="<?= SITEURL?>assets/img/new_image/m-40.png" class="f-tel" alt="<?php echo SITETITLE; ?>">	
									<!-- <i class="fa fa-mobile" aria-hidden="true" style="font-size: 33px;color: white;margin-right: 11px;margin-left: 10px;"></i> -->
									<a href="tel:<?= $telephone_number;?>" class="fs-14"><?= $telephone_number;?></a>
								</a>
							</li>
							<li class="last-list-social">
								<?php 
								if($facebook_link!="")
								{
								?>
								<a href="<?=$facebook_link;?>"><img src="<?= SITEURL?>images/fb_icon.png" alt="<?php echo SITETITLE; ?>"></a>
								<?php
								}

								if($twitter_link!="")
								{
								?>
								<a href="<?=$twitter_link;?>"><img src="<?= SITEURL?>images/twitter_logo_blue.png" alt="<?php echo SITETITLE; ?>"></a>
								<?php 
								}

								if($instagram_link!="")
								{
								?>
								<a href="<?=$instagram_link;?>"><img src="<?= SITEURL?>images/instagran.jpg" alt="<?php echo SITETITLE; ?>"></a>
								<?php 
								}
								?>
							</li>

							<li class="footer-icons">
							<img src="<?= SITEURL?>assets/img/new_image/location.png"/ class="f-social" alt="<?php echo SITETITLE; ?>">
							<!-- <i class="fa fa-map-marker" aria-hidden="true" style="font-size: 33px;color: white;margin-right: 11px;margin-left: 10px;"></i> -->
								<a href="<?= SITEURL?>store-locations/">location</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="footer-bottom">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12">
					<span>&copy; <?php echo "2009 - ".date("Y")?>
					<a href="javascript:void(0)"><?php echo SITETITLE; ?></a>. All rights reserved.</span>
				</div>
				<div class="col-lg-4 col-md-2">
					<!-- <div class="social-link">
						<a href="javascript:void(0)"><i class="fa fa-twitter"></i></a>
						<a href="javascript:void(0)"><i class="fa fa-google-plus"></i></a>
						<a href="javascript:void(0)"><i class="fa fa-facebook"></i></a>
						<a href="javascript:void(0)"><i class="fa fa-youtube"></i></a>
					</div> -->
				</div>
				<div class="col-lg-4 col-md-4">
					<div class="payment-image">
						<!--<img src="<?= SITEURL?>images/payment.png" alt="<?php echo SITETITLE; ?>">-->
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>
