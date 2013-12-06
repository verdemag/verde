<?php
require_once(dirname(dirname(dirname(dirname(__FILE__)))).'/wp-blog-header.php');

if(isset($_GET['post'])) {
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
} else if(isset($_GET['page'])) {
  $name = $_GET['page'];
  $args=array(
    'name' => $name,
    'post_type' => 'page',
    'post_status' => 'publish',
    'numberposts' => 1
  );
  $posts = get_posts($args);
  if(!$posts) {
    echo "page $name not found :/";
  } else {
    echo getPage($posts[0]);
  }
} else if(isset($_GET['cat'])) {
	$name = $_GET['cat'];
	$cat = get_category_by_slug($name);
	if(!$cat) {
		echo "category $name not found :/";
	} else {
		echo getPage($cat);
	}
} else {
  echo 'you did not specify the post you wanted.';
}
?>
