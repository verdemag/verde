<?php
class page {
  private $content;

  function __construct($c) {
    $this->content = $c;
  }

  public function getPageContents() {
    $ret = $this->content;

    return $ret;
  }
}
?>