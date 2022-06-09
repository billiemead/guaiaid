<?php
    if ( !defined( 'ABSPATH' ) ) {
        exit;
    }
    define('DS',DIRECTORY_SEPARATOR);
    $files = array(
        'lib' . DS . 'php-browser-detection',

        'funtions',
        'actions',
        'filters',
        'ajax',
        'shortcodes',
        'admin',
        'woocommerce',

        'class' . DS . 'wp-bootstrap-navwalker',
        'class' . DS . 'wp-comment-walker',
    );
    foreach ( $files as $key => $file ) {
        $file = DS . 'inc' . DS . $file . '.php';
        if ( file_exists( get_template_directory() . $file ) ) {
            require( get_template_directory() . $file );
        }
    }
?>