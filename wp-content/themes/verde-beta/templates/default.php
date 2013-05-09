<?php
class page {
  private $page = '';

  function __construct(string $p) {
    $page = $p;
  }

  public function getPageContents() {
    $ret = '<div class="grid-12">';
    $ret .= $page->page_contents;
    $ret .= '</div>';

    return $ret;
  }
}
?>