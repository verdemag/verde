<?php
class category {
  private $posts;

  function __construct($c) {
    $this->posts = get_posts(array('numberposts' => 4,
                                   'category' => $c));
  }

  public function getPageContents() {
    $ret = ('<div class="grid_12 alpha">');
    foreach ($this->posts as $post) {
      $tagless = strip_tags($post->post_content);
      $content = implode(' ', array_slice(explode(' ', $tagless), 0, 50));
      $ret .= ('<div class="grid_6 content">'
              . '<img alt="" src="' . get_post_meta( $post->ID, 'cover_image', true ) . '">'
              . '<h1>' . $post->post_title . '</h1>'
              . '<p>' . $content . '</p>'
              . '</div>');
    }
    $ret .= ('</div>'
            . '<div class="grid_4 omega">'
            . file_get_contents(get_template_directory_uri() . '/sidebar.php')
            . '</div>');

    return $ret;
  }
}
?>