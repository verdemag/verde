<?php
define('SHARE_MSG', 'Check out this article!');
define('FB_URL', 'https://www.facebook.com/share.php?u=');
define('TWITTER_URL', 'https://www.twitter.com/share?via=verdemagazine&url=');
define('GPLUS_URL', 'https://plus.google.com/share?url=');

class post {
  private $post, $link;

  function __construct($c) {
    $this->post = $c;

    $this->url = get_site_url().'?post='.$c['name'];
    $this->fb = FB_URL.$this->url;
    $this->twit = TWITTER_URL.$this->url;
    $this->gplus = GPLUS_URL.$this->url;
  }

  public function getPageContents() {
    $ret = '<article>';
    $ret .= "<header><h1>{$this->post['title']}</h1>";
    $ret .= "<h2>{$this->post['subtitle']}</h2>";
    if($this->post['author'])
      $ret .= "<span class=\"author\">By: {$this->post['author']}</span></header>";
    $ret .= do_shortcode($this->post['content']);
    $ret .= "<a href=\"{$this->url}\">Permalink</a><br /><br />";
    $ret .= "<a href=\"{$this->fb}\" class=\"social icon-fb\"></a>|";
    $ret .= "<a href=\"{$this->twit}\" class=\"social icon-twitter\"></a>|";
    $ret .= "<a href=\"{$this->gplus}\" class=\"social icon-gplus\"></a>";

    return $ret;
  }
}
?>
