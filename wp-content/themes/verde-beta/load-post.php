<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/verde/wp-blog-header.php');
require_once('functions/page-loader.php');

if(!$_GET['post']) {
  echo 'you did not specify the post you wanted.';
} else {
  $name = $_GET['post'];
  $args=array(
    'name' => $name,
    'post_type' => 'post',
    'post_status' => 'publish',
    'numberposts' => 1
  );
  $posts = get_posts($args);
  if(!$posts) {
    echo 'post not found :/';
  } else {
    echo getPage($posts[0]);
  }
}
?>