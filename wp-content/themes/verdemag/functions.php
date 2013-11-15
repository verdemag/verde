<?php
show_admin_bar(false);
add_theme_support('post-thumbnails');
set_post_thumbnail_size(340, 9999);

define('__ROOT__', dirname(__FILE__));

require('functions/post-meta.php');
require('functions/ticker.php');

function enqueueScripts() {
  wp_enqueue_script('jquery');
  wp_enqueue_script('history.js', get_template_directory_uri() . '/js/jquery.history.js', array('jquery'));
  wp_enqueue_script('other', get_template_directory_uri().'/js/other.js');
  wp_enqueue_script('ticker', get_template_directory_uri().'/js/ticker.js');
  wp_enqueue_script('main', get_template_directory_uri().'/js/main.js', array('jquery', 'history.js'));
  wp_enqueue_style('style', get_stylesheet_uri());
}

add_action('wp_enqueue_scripts', 'enqueueScripts');

function getPage($obj) {
  if(isset($obj->post_type)) {
    if($obj->post_type == 'post') {
      $class = 'post';
      $c = array('content' => wpautop($obj->post_content),
                 'title' => $obj->post_title,
                 'name' => $obj->post_name);
    } else if($obj->post_type == 'page') {
      $template = $obj->page_template;
      if($template == 'default') {
        $class='page';
      } else {
        $class = substr($template, 15, strlen($template) - 19);
      }
      $c = wpautop($obj->post_content);
    }
  } else if($obj->cat_name != '') {
    $class = 'category';
    $c = $obj->cat_ID;
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

function get_cover_post($location) {
  global $wpdb;
	$querystr = "SELECT post_id, count(post_id)
		FROM $wpdb->postmeta
		WHERE
			(meta_key = 'cover-pos' AND meta_value = '%s')
		GROUP BY post_id;
	";
	$postid = $wpdb->get_var($wpdb->prepare($querystr), $location);
  error_log($postid);
  $post = new stdClass();
  $post->slug = get_post($postid)->post_name;
  $post->img = wp_get_attachment_url( get_post_meta($postid, 'cover-image', true) );
  if( !$post->img ) {
    if (in_array($location, ['ul', 'lr'])) {
      $post->img = 'http://placehold.it/300x320';
    } else {
      $post->img = 'http://placehold.it/300x160';
    }
  }

  return $post;
}

function get_cover_posts() {
  $locs = ['ul', 'll', 'um', 'mm', 'lm', 'ur', 'lr'];
  $ret = Array();
  foreach ($locs as $loc) {
    $ret[$loc] = get_cover_post($loc);
  }

  return $ret;
}

?>
