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

function getPage($obj) {
	error_log("Object: " + print_r($obj, true));
	if(isset($obj->post_type)) {
    if($obj->post_type == 'post') {
      $class = 'post';
      $c = array('content' => wpautop($obj->post_content),
                 'title' => $obj->post_title,
                 'name' => $obj->post_name,
                 'author' => get_post_meta($obj->ID, 'verde_author', true),
                 'subtitle' => get_post_meta($obj->ID, 'subtitle', true));
    } else if($obj->post_type == 'page') {
      $class='page';
      $c = wpautop($obj->post_content);
    }
  } else if($obj->cat_name != '') {
    $class = 'category';
    global $ver;
    $c = array($obj->cat_ID, $ver->cat_ID);
  } else {
    $class = $obj->post_type;
    $c = wpautop($obj->post_content);
  }

  if(!class_exists($class)) {
    switch ($class) {
      case 'post':
      $file = __ROOT__ . '/templates/post.php';
      break;
      case 'category':
      $file = __ROOT__ . '/templates/category.php';
      break;
      case 'page':
      $file = __ROOT__ . '/templates/page.php';
      break;
      default:
      return false;
    }

    require_once $file;
    if(!class_exists($class)) {
      return $class;
    }
  }

  $loader = new $class($c);

  return $loader->getPageContents();
}

?>
