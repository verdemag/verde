<?php
/**
 * The header!
 */

function pageClasses($obj) {
	$type = $obj->taxonomy ? $obj->taxonomy : $obj->post_type;
  echo $type;
	$name = $obj->slug ? $obj->slug : $obj->post_name;
  if(!isset($_GET['post']) && isset($_GET['page']) && $_GET['page'] == $name) {
    echo ' select';
  }
}

$ver = isset($_GET['ver']) ? "\"{$_GET['ver']}\"" : 'false';
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php wp_title(); ?> <?php bloginfo('name'); ?></title>
		<script>
		var template_dir = '<?php bloginfo("template_url"); ?>';
		var ver = <?php echo $ver; ?>;
		</script>
		<script>
		<?php vticker_js(); ?>
		</script>

		<?php wp_head(); ?>
	</head>

	<body>
		<header>
			<div class="container_16">
				<div id="logo">
					<div class="title"><?php bloginfo('name'); ?></div>
					<div class="sub"><?php bloginfo('description'); ?></div>
				</div>
				<nav class="navBar">
					<?php
					wp_nav_menu(array('theme-location' => 'primary',
					                  'container' => false,
					                  'depth' => 2,
					                  'walker' => new verde_walker_nav_menu
					                  ));
					?>
					<span></span>
				</nav>

				<div class="lineBreak"></div>
				<div class="ticker"><span></span></div>
			</div>
		</header>

		<div id="mask">
			<main>
