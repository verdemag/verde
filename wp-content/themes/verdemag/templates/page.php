<?php
class page {
  private $content;

  function __construct($c) {
    $this->content = $c;
  }

  public function getPageContents() {
		$ret = '<article>';
    $ret .= $this->content;
		$ret .= ('</article>'
            . '<sidebar>'
            . file_get_contents(get_template_directory_uri() . '/sidebar.php')
						. '</sidebar>');

    return $ret;
  }
}
?>
