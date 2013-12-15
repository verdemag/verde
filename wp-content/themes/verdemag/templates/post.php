<?php
require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/wp-blog-header.php');
define('SHARE_MSG', 'Check out this article!');
define('FB_URL', 'https://www.facebook.com/share.php?u=');
define('TWITTER_URL', 'https://www.twitter.com/share?via=verdemagazine&url=');
define('GPLUS_URL', 'https://plus.google.com/share?url=');

query_posts(array(
	'name' => $_GET['post'],
	'post_type' => 'post',
	'posts_per_page' => 1
));
the_post();
?>
<article>
  <header>
		<h1><?php the_title(); ?></h1>
		<h2><?php echo get_post_meta(get_the_ID(), 'subtitle', true); ?></h2>
		<span class="author">By: <?php echo get_post_meta(get_the_ID(), 'verde_author', true); ?></span>
	</header>
	</header>
	<?php the_content(); ?>
	<a href="<?php the_permalink(); ?>">Permalink</a><br><br>
	<a href="<?php echo FB_URL; the_permalink(); ?>" onclick="" class="social icon-fb"></a>|
  <a href="<?php echo TWITTER_URL; the_permalink(); ?>" class="social icon-twitter"></a>|
	<a href="<?php echo GPLUS_URL; the_permalink(); ?>" class="social icon-gplus"></a>
</article>
<sidebar>
	<?php include(get_template_directory()."/sidebar.php"); ?>
</sidebar>
