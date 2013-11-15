<?php
define('SHARE_MSG', 'Check out this article!');
define(FB_URL, 'https://www.facebook.com/share.php?u=');
define(TWITTER_URL, 'https://www.twitter.com/share?via=verdemagazine&url=');
define(GPLUS_URL, 'https://plus.google.com/share?url=');

class post {
  private $post, $link;

  function __construct($c) {
    $this->post = $c;

    $this->fb = FB_URL.$this->url;
    $this->twit = TWITTER_URL.$this->url;
    $this->gplus = GPLUS_URL.$this->url;
  }

  public function getPageContents() {
    $ret = '<article>';
    $ret .= "<h1>{$this->post[title]}</h1>";
    $ret .= "<time>{$this->post[post_date]}</time>";
    $ret .= do_shortcode($this->post['content']);
    $ret .= "<a href=\"{$this->url}\">Permalink</a><br /><br />";
    $ret .= "<a href=\"{$this->fb}\" class=\"social icon-fb\"></a>|";
    $ret .= "<a href=\"{$this->twit}\" class=\"social icon-twitter\"></a>|";
    $ret .= "<a href=\"{$this->gplus}\" class=\"social icon-gplus\"></a>";

    return $ret;
  }
}
?>