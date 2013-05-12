<?php

class post {
  private $post, $link;

  function __construct($c) {
    $this->post = $c;
    $this->link = $_SERVER['REQUEST_URI'] . '?post=' . $this->post['name'];
  }

  public function getPageContents() {
    $ret = '<div class="grid_12 content">';
    $ret .= '<h1>' . $this->post['title'] . '</h1>';
    $ret .= $this->post['content'];
    $ret .= '<a href="https://twitter.com/share" class="twitter-share-button" data-url="' . $this->link . '" data-text="' . $this->title . '" data-via="verdemagazine" data-dnt="true">Tweet</a>';
    $ret .= '<div class="fb-send" data-href="' . $this->link . '"></div>';
    $ret .= '</div>';

    return $ret;
  }
}
?>


