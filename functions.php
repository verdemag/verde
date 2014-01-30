<?php
show_admin_bar(false);
add_theme_support('post-thumbnails');
set_post_thumbnail_size(340, 9999);
register_nav_menu( 'primary', 'Primary Menu' );

define('__ROOT__', dirname(__FILE__));

require_once('functions/ads.php');
require_once('functions/navlinks.php');
require_once('functions/post-meta.php');
require_once('functions/ticker.php');

function enqueueScripts() {
	wp_enqueue_script('jquery');
	wp_enqueue_script('history.js', get_template_directory_uri() . '/js/jquery.history.js', array('jquery'));
	wp_enqueue_script('other', get_template_directory_uri().'/js/other.js');
	wp_enqueue_script('ticker', get_template_directory_uri().'/js/ticker.js');
	wp_enqueue_script('main', get_template_directory_uri().'/js/main.js', array('jquery', 'history.js'));
	wp_enqueue_style('style', get_stylesheet_uri());
}

add_action('wp_enqueue_scripts', 'enqueueScripts');

global $archive_ID, $ver;
$archive_ID = get_category_by_slug('archive')->cat_ID;
$ver = isset($_GET['ver']) ? (
	get_category_by_slug($_GET['ver'])
):(
	get_categories(array('parent' => $archive_ID,
	                     'order' => 'desc',
	                     'number' => 1))[0]);

function the_postlink($slug) {
	global $ver;
	echo site_url("/?ver={$ver->slug}&post=$slug");
}

function the_pagelink($slug) {
	global $ver;
	echo site_url("/?ver={$ver->slug}&post=$slug");
}

function the_catlink($slug) {
	global $ver;
	echo site_url("/?ver={$ver->slug}&cat=$slug");
}

?>
