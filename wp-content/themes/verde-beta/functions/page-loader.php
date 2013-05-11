<?php
function getPage($obj) {
  if($obj->post_type == 'post') {
    $class = 'post';
    $c = array(wpautop($obj->post_content), $obj->post_title);
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
?>