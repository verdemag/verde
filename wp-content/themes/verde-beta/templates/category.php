<?php
class category {
  private $posts;

  function __construct($c) {
    $this->posts = get_posts(array('numberposts' => 4,
                                   'category' => $c));
  }

  public function getPageContents() {
    $ret = '<section class="articles">';
    foreach ($this->posts as $post) {
      setup_postdata($post);
      $url = "http://$_SERVER[HTTP_HOST]/?post={$post->post_name}";
      $ret .= ('<article>'
              . '<img alt="" src="' . get_post_meta( $post->ID, 'cover_image', true ) . '">'
              . "<a href=\"$url\"><h1>{$post->post_title}</h1></a>"
              . get_the_excerpt()
              . '<a id="' . $post->post_name . 'link" class="navLink">Read more</a>'
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