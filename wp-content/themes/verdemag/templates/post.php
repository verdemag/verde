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
if(!have_posts()) die("<section class=\"error\"><h1>Post '{$_GET['post']}' Not Found</h1>
Whoops! it looks like the post you were looking for wasn't found. Maybe it was moved or deleted, or you mistyped the URL.</section>");

the_post();
$slug = get_post(get_the_ID())->post_name;
$share = urlencode(site_url("/?ver={$ver->slug}&post=$slug"));
?>
<article>
  <header>
		<h1><?php the_title(); ?></h1>
		<h2><?php echo get_post_meta(get_the_ID(), 'subtitle', true); ?></h2>
		<span class="author">By: <?php echo get_post_meta(get_the_ID(), 'verde_author', true); ?></span>
	</header>
	</header>
	<?php the_content(); ?>
	<a href="<?php echo FB_URL.$share; ?>" onclick="" class="social icon-fb"></a>|
  <a href="<?php echo TWITTER_URL.$share; ?>" class="social icon-twitter"></a>|
	<a href="<?php echo GPLUS_URL.$share; ?>" class="social icon-gplus"></a>
</article>
<sidebar>
	<?php include(get_template_directory()."/sidebar.php"); ?>
</sidebar>
