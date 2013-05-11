<?php
wp_enqueue_script('jquery');
show_admin_bar(false);

define('__ROOT__', dirname(__FILE__));

require('functions/meta-box.php');
require('functions/ticker.php');
require('functions/page-loader.php');

add_action( 'add_meta_boxes', 'add_sidebar_box' );
add_action( 'add_meta_boxes', 'add_image_box' );
add_action( 'save_post', 'save_image_for_post', 99 );
add_action( 'admin_menu' , 'ticker_menu' );
?>
