<?php

class post {
  private $content, $title;

  function __construct($c) {
    $this->content = $c[0];
    $this->title = $c[1];
  }

  public function getPageContents() {
    $ret = '<div class="grid_12 content">';
    $ret .= '<h1>' . $this->title . '</h1>';
    $ret .= $this->content;
    $ret .= '<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://hi.com" data-text="Check this out" data-via="verdemagazine" data-dnt="true">Tweet</a>
<div class="fb-send" data-href="http://hi.com"></div>';
    $ret .= '</div>';

    return $ret;
  }
}
?>