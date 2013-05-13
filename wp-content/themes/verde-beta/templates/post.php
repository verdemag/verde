<?php

define('SHARE_MSG', 'Check out this article!');

class post {
  private $post, $link;

  function __construct($c) {
    $this->post = $c;
    $this->link = "http://$_SERVER[HTTP_HOST]/verde?post={$this->post[name]}";

    $this->tweetlink = "https://platform.twitter.com/widgets/tweet_button.html?url={$this->link}&via=verdemagazine&text={SHARE_MSG}&related=verdemagazine";
    $this->likelink = "https://www.facebook.com/plugins/like.php?href={$this->link}&layout=button_count&width=100";
  }

  public function getPageContents() {
    $ret = '<div class="grid_12 content">';
    $ret .= "<h1>{$this->post[title]}</h1>";
    $ret .= $this->post['content'];
    $ret .= "<a href={$this->link}>Permalink</a><br /><br />";
    $ret .= "<iframe allowtransparency=\"true\" frameborder=\"0\" scrolling=\"no\"
        src=\"{$this->tweetlink}\"
        style=\"width:90px; height:20px;\"></iframe>";
    //$ret .= "<a rel=\"nofollow\" href=\"http://twitter.com/share?url={$this->link}&text=7%20Reasons%20Not%20To%20Use%20The%20New%20Tweet%20Buttons&via=verdemagazine\">Tweet</a>";
    $ret .= "<iframe allowTransparency=\"true\" frameborder=\"0\" scrolling=\"no\"
				src=\"{$this->likelink}\"
				style=\"width:100px; height:20px;\"></iframe>";
    //$ret .= "<iframe src=\"https://www.facebook.com/plugins/like.php?href={$this->link}&layout=button_count&action=recommend\"></iframe>";
    $ret .= '</div>';

    return $ret;
  }
}
?>


