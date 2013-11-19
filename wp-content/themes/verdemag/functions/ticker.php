<?php
global $wpdb;
define('vticker_table', $wpdb->prefix . 'verde_ticker');
define('vticker_UNIQUE_NAME', 'verde-ticker');
define('vticker_TITLE', 'Verde ticker');

function vticker_js() {
  global $wpdb;

	$sSql = "select * from ".vticker_table." where vticker_status = 'YES'";
	$sSql.= " and ( vticker_dateend >= NOW() or vticker_dateend = '0000-00-00 00:00:00' )";
	$sSql.= " Order by vticker_order";

	$data = $wpdb->get_results($sSql);

  $ret = "var tickerText = new Array();\n";
  if(!$data) {
    $ret .= "tickerText.push('Add some text to the ticker!');";
  }

  foreach($data as $datum) {
    $link = $datum->vticker_link;
    if($link == '#') {
      $text = stripslashes($datum->vticker_text);
    } else {
      $text = '<a href="'.$link.'">';
      $text.= stripslashes($datum->vticker_text);
      $text.= '</a>';
    }
    $ret .= "tickerText.push('".$text."');\n";
  }

  echo $ret;
}

function vticker_install() {
  global $wpdb;

  if($wpdb->get_var("show tables like '" . vticker_table . "'") != vticker_table) {
    error_log('no table!');
		$sSql = "CREATE TABLE ". vticker_table . " (
			 vticker_id mediumint(9) NOT NULL AUTO_INCREMENT,
			 vticker_text text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
			 vticker_link VARCHAR(1024) DEFAULT '#' NOT NULL,
			 vticker_order int(11) NOT NULL default '0',
			 vticker_status char(3) NOT NULL default 'YES',
			 vticker_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			 vticker_dateend datetime DEFAULT '9999-12-31 00:00:00' NOT NULL,
			 vticker_extra1 VARCHAR(100) NOT NULL default '' ,
			 vticker_extra2 VARCHAR(100) NOT NULL default '' ,
			 vticker_extra3 VARCHAR(100) NOT NULL default '' ,
			 UNIQUE KEY vticker_id (vticker_id)
		  );";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sSql );
  }
}

function vticker_admin() {
	global $wpdb;
	$current_page = isset($_GET['ac']) ? $_GET['ac'] : '';
	switch($current_page)
	{
		case 'edit':
			require(dirname(__FILE__).'/../pages/content-management-edit.php');
			break;
		case 'add':
			require(dirname(__FILE__).'/../pages/content-management-add.php');
			break;
		default:
			require(dirname(__FILE__).'/../pages/content-management-show.php');
			break;
	}
}

function vticker_add_to_menu() {
  add_options_page('Verde Ticker', 'Verde Ticker', 'manage_options', 'verde-ticker', 'vticker_admin');
}

if(is_admin()) {
  add_action('admin_menu', 'vticker_add_to_menu');
}

add_action('after_setup_theme', 'vticker_install', 10, 2);
?>
