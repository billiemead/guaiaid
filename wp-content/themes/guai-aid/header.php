<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0" />
    <meta name="theme-color" content="#F57C00" />
    <meta name="content-language" content="en-US">
    <meta http-equiv="Expires" content="30">
    <!-- <meta name="twitter:site" content="@Guai-Aid" /> -->
    <meta name="application-name" content="Guai-Aid">
    <link rel="alternate" hreflang="en-US" href="<?php echo get_curr_page_url();?>">
    <link rel="profile" href="https://gmpg.org/xfn/11" />
    <link rel="preconnect" href="//fonts.googleapis.com" />
    <link rel="preconnect" href="//www.google-analytics.com" />
    <link rel="preconnect" href="//www.googletagmanager.com" />
    <link rel="preconnect" href="//pixel.wp.com" />
    <link rel="preconnect" href="//stats.wp.com" />
    <link rel="preconnect" href="//twemoji.maxcdn.com" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<meta name="ahrefs-site-verification" content="fd9637ef1bae02e32ea856f8d6efe24d080dcb6a2a5414ccd0cc473ab605c973">
    <link href="https://fonts.googleapis.com/css2?family=Bitter:ital,wght@0,400;0,700;1,400&family=Rubik:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script>
        (function(html) {
        html.className = html.className.replace(/\bno-js\b/, 'js')
    })(document.documentElement);
    </script>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <?php woocommerce_demo_store();?>
    <header id="site-header" class="site-header">
        <div class="header-search collapse collapsed d-print-none" id="header-search">
            <div class="inner">
                <div class="container">
                    <button class="btn navbar-toggle close-button" type="button" data-bs-toggle="collapse" data-bs-target="#header-search" aria-controls="header-search" aria-expanded="false">
                        <i class="fas fa-times"></i>
                        <span class="sr-only">
                            <?php _e('Close','guai-aid');?></span>
                    </button>
                    <?php get_search_form();?>
                </div>
            </div>
        </div>
        <a class="skip-link faux-button screen-reader-text sr-only" href="#site-content">
            <?php _e('Skip to content', 'guai-aid'); ?>
        </a>
        <div class="header-top">
            <div class="container">
                <div class="row align-items-center sm-text-center">
                    <div class="col-4">
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
                    <div class="col-8 text-md-end">
                        <ul class="nav mb-0 nav-right">
                            <?php if(is_user_logged_in()){?>
                            <li class="nav-item"><a href="<?php echo home_url('my-account');?>" class="nav-link">My Account</a></li>
                            <li class="nav-item"><a href="<?php echo wc_logout_url();?>" class="nav-link">Logout</a></li>
                            <?php } else {?>
                            <li class="nav-item"><a href="<?php echo home_url('my-account');?>" class="nav-link">Login</a></li>
                            <li class="nav-item"><a href="<?php echo home_url('my-account/register/');?>" class="nav-link">New Customer</a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-middle">
            <div class="container">
                <div class="row m-0">
                    <div class="col-12 d-sm-none text-center mb-2">
                        <?php guai_aid_the_custom_logo(); ?>
                    </div>
                    <div class="col-6 col-sm-4 p-0 top-col">
                        <?php if (has_nav_menu('category')) { ?>
                        <nav class="navbar navbar-2 pb-0">
                            <button class="navbar-toggler categoryDropDown" type="button" data-bs-toggle="collapse" data-bs-target="#categoryDropDown" aria-expanded="false" aria-label="Toggle navigation">
                                <i class="fas fa-bars"></i>
                                <small class="cat-label">Categories</small>
                            </button>
                            <div class="collapse navbar-collapse box-shadow" id="categoryDropDown">
                                <?php wp_nav_menu(array(
                                        'theme_location' => 'category',
                                        'container' => false,
                                        'menu_id' => 'category-nav',
                                        'menu_name' => 'category',
                                        'menu_class' => 'category-nav nav navbar-nav ml-auto mr-auto d-block w-100',
                                        'link_before' => '',
                                        'link_after' => '',
                                        'fallback_cb' => 'WP_Bootstrap_Navwalker::fallback',
                                        'items_wrap'      => '<ul id="%1$s" class="%2$s" itemscope itemtype="https://schema.org/SiteNavigationElement" role="menu" >%3$s</ul>',
                                        'walker' => new WP_Bootstrap_Navwalker(),
                                        'depth' => 2
                                    ));
                                    ?>
                            </div>
                        </nav>
                        <?php } ?>
                    </div>
                    <div class="col-sm-4 text-center p-0 d-none d-sm-block">
                        <?php guai_aid_the_custom_logo(); ?>
                    </div>
                    <div class="col-6 col-sm-4 p-0">
                        <ul class="nav nav-right">
                            <li class="nav-item"><a href="#" class="btn d-block search-button nav-link navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#header-search" aria-controls="header-search" aria-expanded="false"> <i class="fas fa-search"></i> <span class="sr-only">
                                        <?php _e('Search','guai-aid');?></span>
                                </a></li>
                            <li class="nav-item"><a href="<?php echo home_url('my-account/wishlist');?>" class="btn d-block wishlist-button nav-link navbar-toggler" title="<?php _e('Wishlist','guai-aid');?>"><i class="fas fa-heart"></i><span class="sr-only">
                                        <?php _e('Wishlist','guai-aid');?></span></a></li>
                            <li class="nav-item dropdown ">
                                <a href="<?php echo wc_get_cart_url();?>" class="btn d-block cart-button nav-link dropdown-toggle cart-customlocation cart-contents" id="mini-cart" title="<?php _e('View your shopping cart','guai-aid');?>" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-shopping-bag"></i>
                                    <span class="sr-only">
                                        <?php _e('Cart','guai-aid');?></span>
                                    <span class="count">
                                        <?php echo sprintf ( _n( '%d', '%d', WC()->cart->get_cart_contents_count() ), WC()->cart->get_cart_contents_count() ); ?></span>
                                    <?php //echo WC()->cart->get_cart_total(); ?>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end p-3 dropdown-mini-cart" aria-labelledby="mini-cart">
                                    <div class="widget_shopping_cart_content">
                                        <?php woocommerce_mini_cart();?>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-bottom">
            <div class="container">
                <div class="row m-0">
                    <div class="col-6 col-md-8 p-0">
                        <?php if (has_nav_menu('primary')) { ?>
                        <nav class="navbar navbar-expand-md  p-0 d-print-block navbar-light">
                            <button class="navbar-toggler menu-button" type="button" data-bs-toggle="collapse" data-bs-target="#primary-navigation" aria-expanded="false" aria-label="Toggle navigation">
                                <i class="fas fa-bars"></i>
                                <small class="cat-label">Menu</small>
                            </button>
                            <div class="collapse navbar-collapse primary-navigation primary-menu-wrapper" id="primary-navigation">
                                <?php 
                                        wp_nav_menu(array(
                                            'theme_location' => 'primary',
                                            'container' => false,
                                            'menu_id' => 'primary-nav',
                                            'menu_name' => 'primary',
                                            'menu_class' => 'primary-nav navbar-nav ms-0  d-print-none ',
                                            'link_before' => '',
                                            'link_after' => '',
                                            'fallback_cb' => 'WP_Bootstrap_Navwalker::fallback',
                                            'items_wrap'      => '<ul id="%1$s" class="%2$s" itemscope itemtype="https://schema.org/SiteNavigationElement" role="menu" >%3$s</ul>',
                                            'walker' => new WP_Bootstrap_Navwalker(),
                                            'depth' => 2
                                        ));
                                    ?>
                            </div>
                        </nav>
                        <?php } ?>
                    </div>
                    <div class="col-6 col-md-4 p-0 text-end">
                        <img src="<?php echo guai_aid_asset('images','delivery_van.png');?>" class="img-fluid" width="385" height="61" alt="delivery_van">
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main id="site-main" class="site-main">