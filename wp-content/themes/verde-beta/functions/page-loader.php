<?php
function getPage($obj) {
  if($obj->post_type == 'post') {
    $class = 'post';
    $c = $obj->post_content;
  } else if($obj->post_type == 'page') {
    $template = $obj->page_template;
    if($template == 'default') {
      $class='page';
    } else {
      $class = substr($template, 15, strlen($template) - 19);
    }
    $c = $obj->post_content;
  } else if($obj->cat_name != '') {
    $class = 'category';
    $c = $obj->cat_ID;
  } else {
    $class = $obj->post_type;
    $c = $obj->post_content;
  }

  if(!class_exists($class)) {
    if($class == 'page') {
      $file = __ROOT__ . '/templates/page.php';
    } else if($class == 'category') {
      $file = __ROOT__ . '/templates/category.php';
    } else {
      $file = __ROOT__ . $obj->page_template;
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