<?php
require_once(dirname(dirname(dirname(dirname(__FILE__)))).'/wp-blog-header.php');

if(!$_GET['cat']) {
  echo 'you did not specify a category';
} elseif(!$_GET['start']) {
  echo 'you did not specify a post to start the get at';
} else {
  $posts = get_posts(array('numberposts' => 2,
                           'offset' => $_GET['start'],
                           'category' => $_GET['cat']));

  foreach ($this->posts as $post) {
    $excerpt = implode(' ', array_slice(explode(' ', $post->post_content), 0, 150));

    $doc = new DOMDocument();
    $doc->loadHTML(wpautop($excerpt . '&hellip;'));

    $content = $doc->saveHTML();
    $url = "http://$_SERVER[HTTP_HOST]/verde?post={$post->post_name}";
    echo ('<article>'
         ."<img src=\"{get_post_meta( $post->ID, 'cover_image', true )}\">"
         ."<a href=\"$url\"><h1>{$post->post_title}</h1></a>"
         .$content
         .'<a id="{$post->post_name}link" class="navLink">Read more</a>'
         .'</article>');
  }
}
?>