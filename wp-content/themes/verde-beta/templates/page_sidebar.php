<?php 
/*
Template Name: Page with a sidebar
*/

class sidebar {
  private $content = 'fien';

  function __construct($c) {
    $this->content = $c;
  }

  public function getPageContents() {
    $ret = '<div class="grid_9">';
    $ret .= $this->content;
    $ret .= '</div>';
    $ret .= '<div class="grid_3">';
    $ret .= file_get_contents(get_template_directory_uri() . '/sidebar.php');
    $ret .= '</div>';

    return $ret;
  }
}
?>
