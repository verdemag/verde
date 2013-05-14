<?php

define('SHARE_MSG', 'Check out this article!');

class post {
  private $post, $link;

  function __construct($c) {
    $this->post = $c;
    $this->link = "http://$_SERVER[HTTP_HOST]/verde?post={$this->post[name]}";

    require_once();
  }

  public function getPageContents() {
    $ret = '<article class="grid_12">';
    $ret .= "<h1>{$this->post[title]}</h1>";
    $ret .= "<time>{$this->post[post_date]}</time>";
    $ret .= $this->post['content'];
    $ret .= "<a href={$this->link}>Permalink</a><br /><br />";
    $ret .= "<ul class="socialcount socialcount-small" data-url="http://www.google.com/" data-counts="true" data-share-text="Check out this article!">
	<li class="facebook"><a href="https://www.facebook.com/sharer/sharer.php?u={$this->link}" title="Share on Facebook"><span class="count">Like</span></a></li>
	<li class="twitter"><a href="https://twitter.com/intent/tweet?text={$this->link}" title="Share on Twitter"><span class="count">Tweet</span></a></li>
	<li class="googleplus"><a href="https://plus.google.com/share?url={$this->link}" title="Share on Google Plus"><span class="count">+1</span></a></li>
</ul>"

    return $ret;
  }
}
?>


