<?php
class category {
  private $posts;

  function __construct($c) {
    $this->posts = get_posts(array('numberposts' => -1,
                                   'category__and' => $c));
  }

  public function getPageContents() {
    $ret = '<section class="articles">';
    foreach ($this->posts as $post) {
      setup_postdata($post);
      $name = $post->post_name;
      $author = get_post_meta($post->ID, 'verde_author', true);
      $author_string = $author ? 'By: '.$author : '';
      $subtitle = get_post_meta($post->ID, 'subtitle', true);
      $href = post_permalink($post->ID);
      $thumb = get_the_post_thumbnail($post->ID);
      $ret .= ('<article>'
              . $thumb
              . '<header>'
              . "<a href=\"$href\" data-target=\"$name\" class=\"navLink\"><h1>$post->post_title</h1></a>"
              . "<h2>$subtitle</h2>"
              . "<span class=\"author\">$author_string</span>"
              . '</header>'
              . get_the_excerpt()
              . "<a href=\"$href\" data-target=\"$name\" class=\"navLink\">Read more</a>"
              . '</article>');
    }
    $ret .= ('</section>'
            . '<sidebar>'
            . file_get_contents(get_template_directory_uri() . '/sidebar.php')
            . '</sidebar>');

    return $ret;
  }
}
?>
