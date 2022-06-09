<?php
/**
 * @version    1.1
 * @package    diza
 * @author     Billie Mead
 * @copyright  Copyright (C) 2022 https://billiemead.com All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: https://billiemead.com
 */


 // Update CSS within in Admin
function admin_style() {
    wp_enqueue_style('admin-styles', get_stylesheet_directory_uri().'/adminstyles.css');
}
add_action('admin_enqueue_scripts', 'admin_style');

// Disable notifications in backend
add_action('admin_enqueue_scripts', 'ds_admin_theme_style');
add_action('login_enqueue_scripts', 'ds_admin_theme_style');
function ds_admin_theme_style() {
    if (!current_user_can( 'manage_options' )) {
echo '<style>.update-nag, .updated, .error, .is-dismissible { display: none; }</style>';}}        


add_action('wp_enqueue_scripts', 'diza_child_enqueue_styles', 10000);
function diza_child_enqueue_styles() {
	$parent_style = 'diza-style';
	wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'diza-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}