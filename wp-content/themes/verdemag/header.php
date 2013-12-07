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

global $ver;

?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php wp_title(); ?> <?php bloginfo('name'); ?></title>
		<script>
		var template_dir = '<?php bloginfo("template_url"); ?>';
		var ver = '<?php echo $ver->slug; ?>';
		</script>
		<script>
		<?php vticker_js(); ?>
		</script>

		<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico">

		<?php wp_head(); ?>
	</head>

	<body>
		<div class="loader"></div>
		<header>
			<div class="container_16">
				<div id="logo">
					<div class="title"><?php bloginfo('name'); ?><small><?php echo $ver->name ?></small></div>
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
