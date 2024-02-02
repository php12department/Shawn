<style>

#toTopBtn {
     position: fixed;
    bottom: 26px;
    left: 39px;
    z-index: 1 !important;
    padding: 21px;
    /* background-color: hsla(5,76%,62%,.8); */
    background-color: red;
    display:none;
    
}
.js .cd-top {
    visibility: hidden;
    opacity: 0;
    transition: opacity .3s,visibility .3s,background-color .3s;
}

.js .cd-top--is-visible {
    visibility: visible;
    opacity: 1;
}

.js .cd-top--fade-out {
    opacity: .5;
}


.cd-top {
    position: fixed;
    bottom: 20px;
    bottom: var(--cd-back-to-top-margin);
    right: 20px;
    right: var(--cd-back-to-top-margin);
    display: inline-block;
    height: 40px;
    height: var(--cd-back-to-top-size);
    width: 40px;
    width: var(--cd-back-to-top-size);
    box-shadow: 0 0 10px rgba(0,0,0,.05) !important;
    background: url(https://res.cloudinary.com/dxfq3iotg/image/upload/v1571057658/cd-top-arrow.svg) no-repeat center 50%;
    /* background-color: hsla(5,76%,62%,.8);
    background-color: hsla(var(--cd-color-3-h),var(--cd-color-3-s),var(--cd-color-3-l),0.8); */
}



     </style>
<footer class="site-footer new-footer">
     <div class="container-fluid">
          <div class="row"> 
               <div class="offset-lg-2 col-lg-8 col-md-12">
                    <div class="row">
                         <div class="col-lg-2 col-md-4 col-sm-6">
                              <div class="logo-footer">
                              <a href="<?= SITEURL?>"><img src="<?= SITEURL?>assets/new_home/img/logo/main.png"></a>
                              </div>
                         </div>
                         <div class="offset-lg-1 col-lg-2 col-md-4 col-sm-6">
                              <div class="useful-link">
                                   <h4>Company</h4>
                                   <ul class="list-inline mt-4">
                                        <li><a href="<?= SITEURL?>about-us/">About us</a></li>
                                        <li><a href="<?= SITEURL?>contact-us/">Contact us</a></li>
                                        <li><a href="<?= SITEURL?>careers/">Careers</a></li>
                                        <li><a href="<?= SITEURL?>news-and-events/">News & events</a></li>
                                        <li><a href="<?= SITEURL?>custom-orders/">Custom orders</a></li>
                                   </ul>
                              </div>
                         </div>
                         <div class="col-lg-2 col-md-4 col-sm-6">
                              <div class="useful-link">
                                   <h4>Services</h4>
                                   <ul class="list-inline mt-4">
                                        <li><a href="<?= SITEURL?>shipping-information/">Shipping Information</a></li>
                                        <li><a href="<?= SITEURL?>financing/">Financing</a></li>
                                        <li><a href="<?= SITEURL?>accidental-damage-protection/">Accidental Damage Protection</a></li>
                                        <!-- <li><a href="#">Protection</a></li> -->
                                        <li><a href="<?= SITEURL?>customer-gallary/">Customer Gallary</a></li>
                                   </ul>
                              </div>
                         </div>
                         <div class="col-lg-2 col-md-4 col-sm-6">
                              <div class="useful-link">
                                   <h4>Help</h4>
                                   <ul class="list-inline mt-4">
                                   <li><a href="<?= SITEURL?>returns-and-exchanges/">Returns & Exchanges</a></li>
							<li><a href="<?= SITEURL?>privacy-policy/">Privacy Policy</a></li>
							<li><a href="<?= SITEURL?>furniture-care/">Furniture Care</a></li>
                                   </ul>
                              </div>
                         </div>
                         <div class="col-lg-2 col-md-4 col-sm-6">
                              <div class="useful-link">
                                   <h4>Contact</h4>
                                   <ul class="list-inline mt-4">
                                        <li><a href="tel:<?= $telephone_number;?>"><i class="fa-regular fa-phone"></i>&nbsp;<?= $telephone_number;?></a></li>
                                        <li>
                                             <a href="<?=$facebook_link;?>"><i class="fa-brands fa-facebook-f mr-3"></i></a>&nbsp;
                                             <a href="<?=$twitter_link;?>"><i class="fa-brands fa-twitter mr-3"></i></a>&nbsp;
                                             <a href="<?=$instagram_link;?>"><i class="fa-brands fa-instagram"></i></a>
                                        </li>
                                        <li><a href="<?= SITEURL?>store-locations/"><i class="fa-thin fa-location-dot"></i>&nbsp; Location</a></li>
                                        <li><a href="https://www.google.com/maps?ll=33.072124,-96.688704&z=16&t=m&hl=en-US&gl=US&mapclient=embed&cid=3052341362603140637"><i class="fa-thin fa-location-dot"></i>&nbsp; 7265 Central Expressway Plano, Texas 75025</a></li>
                                   
                                   </ul>
                              </div>
                         </div>
                    </div>
                    <a href="#" id="toTopBtn" class="cd-top text-replace js-cd-top cd-top--is-visible cd-top--fade-out" data-abc="true"></a>
                    <div class="copyright">
                         <p>&copy; <?php echo "2009 - ".date("Y")?>
					<a href="javascript:void(0)" style="color: #B61F1F;"><?php echo SITETITLE; ?></a>. All rights reserved. </p>
                    </div>
          </div>
     </div>
     </div>
</footer>