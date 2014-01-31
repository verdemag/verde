<?php
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
		<title><?php bloginfo('name'); ?></title>
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
		<script>
		 document.write('<div class="loader"></div>');
		</script>
		<div id="wrapper" class="cf">
			<header class="cf">
				<div id="logo">
					<div class="title">
						<h1><?php bloginfo('name'); ?><small><?php echo $ver->name ?></small></h1>
					</div>
					<div class="sub"><?php bloginfo('description'); ?></div>
				</div>
				<div id="nav-placeholder"></div>
				<nav>
					<?php
					wp_nav_menu(array('theme-location' => 'primary',
														'container' => false,
														'depth' => 2,
														'walker' => new verde_walker_nav_menu
														));
					?>
					<span></span>
				</nav>
				<div id="ticker"><span></span></div>
			</header>

			<div id="mask" class="cf">
				<main class="cf">

					<?php if (!is_user_logged_in()) : ?>
						<section class="page">
							<h1>Site under construction!</h1>
							<p>Hello, this site is currently under construction! If you want to view the site, please <a href="<?php echo wp_login_url( home_url() ); ?>">login</a>.</p>
						</section>
						<script>
						 jQuery(document).ready(function() {
							 jQuery('.navlink').off('click');
						 });
						</script>
						<?php get_footer(); ?>

						<?php die(); ?>
					<?php endif; ?>
