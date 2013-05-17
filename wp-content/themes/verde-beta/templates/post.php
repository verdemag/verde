<?php
define('SHARE_MSG', 'Check out this article!');
define(FB_URL, 'https://www.facebook.com/share.php?u=');
define(TWITTER_URL, 'https://www.twitter.com/share?via=verdemagazine&url=');
define(GPLUS_URL, 'https://plus.google.com/share?url=');

class post {
  private $post, $link;

  function __construct($c) {
    $this->post = $c;
    $this->url = "http://$_SERVER[HTTP_HOST]/verde?post={$this->post[name]}";

    $this->fb = FB_URL.$this->url;
    $this->twit = TWITTER_URL.$this->url;
    $this->gplus = GPLUS_URL.$this->url;
  }

  public function getPageContents() {
    $ret = '<article>';
    $ret .= "<a href=\"{$this->url}\"><h1>{$this->post[title]}</h1></a>";
    $ret .= "<time>{$this->post[post_date]}</time>";
    $ret .= $this->post['content'];
    $ret .= "<a href=\"{$this->url}\">Permalink</a><br /><br />";
    $ret .= "<a href=\"{$this->fb}\" class=\"icon-fb\"></a>|";
    $ret .= "<a href=\"{$this->twit}\" class=\"icon-twitter\"></a>|";
    $ret .= "<a href=\"{$this->gplus}\" class=\"icon-gplus\"></a>";

    return $ret;
  }
}
?>
