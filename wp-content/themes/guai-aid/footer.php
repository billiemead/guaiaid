<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
?>
<div class="clearfix"></div>
</main>
<footer id="site-footer" class="">
    <?php get_template_part('templates/forms/email-subscription'); ?>
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-md-5 mb-3">
                    <?php guai_aid_the_custom_logo(true); ?>
                    <p class="mt-2">Guai-Aid® products are distributed by the <a href="https://www.healthproductsexpress.com/" style="color:#16ccd2">Health Products Express</a>, Inc. Boston, Massachusetts</p>
                    <div class="social-icons">
                        <ul class="nav mb-0">
                            <li class="nav-item">
                                <a href="https://www.facebook.com/Guaifenesin-for-Fibromyaadlgia-102680795014885" class="nav-link" target="_blank"> <i class="fab fa-facebook-f"></i>
                                    <span class="sr-only">Facebook</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="https://www.instagram.com/guaiaid/" class="nav-link" target="_blank"> <i class="fab fa-instagram"></i>
                                    <span class="sr-only">Instagram</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-7 footer-list ">
                    <div class="row">
                        <div class="col-md-3  mb-3">
                            <h5>EXTRAS</h5>
                            <ul class="list-unstyled">
                                <li><a href="<?php echo home_url('products/gift-card');?>" class="nav-link">Gift Certificates</a>
                                </li>
                                <!--<li><a href="#">Site Map</a>-->
                                <!--</li>-->
                                <li><a href="<?php echo home_url('contact-us');?>" class="nav-link">Contact Us</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-4  mb-3">
                            <h5>MY ACCOUNT</h5>
                            <ul class="list-unstyled">
                                <li>
                                    <a href="<?php echo home_url('my-account');?>" class="nav-link">My Account</a>
                                </li>
                                <li>
                                    <a href="<?php echo home_url('my-account/orders/');?>" class="nav-link">Order History</a>
                                </li>
                                <li>
                                    <a href="<?php echo home_url('my-account/orders/');?>" class="nav-link">Returns</a>
                                </li>
                                <li>
                                    <a href="<?php echo home_url('my-account/wishlist/');?>" class="nav-link">Wish List</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-5">
                            <h5>CONTACT US</h5>
                            <ul class="media-icon list-unstyled">
                                <li class="mb-4">
                                    <p class="mb-0"><i class="fa fa-map-marker"></i> Health Products Express, Inc.10 Post Office Square, 8th Floor South</p>
                                </li>
                                <li class="mb-4">
                                    <a href="#"><i class="fa fa-map-marker"></i> Boston, Massachusetts 02109</a>
                                </li>
                                <li class="mb-4">
                                    <a href="#"><i class="fa fa-phone fa-flip-horizontal"></i> 800-846-5525</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="secondary-footer text-center copyright  py-3">
        <p class="m-0">Copyright <?php echo date('Y');?> Design &amp; Developed By . <a target="_blank" href="https://codeatech.com/"> Codea Technologies </a>. All Rights Reserved
        </p>
    </div>
</footer>

<?php wp_footer(); ?>
</body>

</html>