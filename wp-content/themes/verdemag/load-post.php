<?php
require_once(dirname(dirname(dirname(dirname(__FILE__)))).'/wp-blog-header.php');

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
    echo "post $name not found :/";
  } else {
    echo getPage($posts[0]);
  }
}
?>