<?php
class page {
  private $content;

  function __construct($c) {
    $this->content = $c;
  }

  public function getPageContents() {
    $ret = '<div class="grid_12">';
    $ret .= $this->content;
    $ret .= '</div>';

    return $ret;
  }
}
?>