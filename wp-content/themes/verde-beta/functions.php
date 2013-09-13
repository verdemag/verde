<?php
show_admin_bar(false);

define('__ROOT__', dirname(__FILE__));

require('functions/meta-box.php');
require('functions/ticker.php');

function enqueueScripts() {
  wp_enqueue_script('jquery');
  wp_enqueue_script('history.js', get_template_directory_uri() . '/js/jquery.history.js', array('jquery'));
  wp_enqueue_script('other', get_template_directory_uri() . '/js/other.js');
  wp_enqueue_script('main', get_template_directory_uri() . '/js/main.js', array('jquery', 'history.js'));
}

add_action('wp_enqueue_scripts', 'enqueueScripts');

function getPage($obj) {
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

add_action( 'add_meta_boxes', 'add_sidebar_box' );
add_action( 'add_meta_boxes', 'add_image_box' );
add_action( 'save_post', 'save_image_for_post', 99 );
add_action( 'admin_menu' , 'ticker_menu' );
?>
