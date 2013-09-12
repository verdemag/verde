<?php
class category {
  private $posts;

  function __construct($c) {
    $this->posts = get_posts(array('numberposts' => 8,
                                   'category' => $c));
  }

  public function getPageContents() {
    $ret = '<section class="articles">';
    foreach ($this->posts as $post) {
      setup_postdata($post);
      $name = $post->post_name;
      $ret .= ('<article>'
              . get_the_post_thumbnail()
              . "<a data-target=\"$name\"><h1>{$post->post_title}</h1></a>"
              . get_the_excerpt($post->ID)
              . '<a data-target="' . $name . '" class="navLink">Read more</a>'
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