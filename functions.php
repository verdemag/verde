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

define('SHARE_MSG', 'Check out this article!');
define('FB_URL', 'https://www.facebook.com/share.php?u=');
define('TWITTER_URL', 'https://www.twitter.com/share?via=verdemagazine&url=');
define('GPLUS_URL', 'https://plus.google.com/share?url=');

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
	isset($_POST['ver']) ? (
		get_category_by_slug($_POST['ver'])
	):(
	get_categories(array('parent' => $archive_ID,
	                     'order' => 'desc',
	                     'number' => 1))[0]));

function version_filter( $query ) {
	global $ver;
	if($query->is_category() && $query->is_main_query()) {
		$query->set('category__and', array($ver->cat_ID));
	}
}

add_action( 'pre_get_posts', 'version_filter' );

?>
