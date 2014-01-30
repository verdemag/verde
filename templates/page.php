<?php
require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/wp-blog-header.php');
query_posts(array(
	'name' => $_GET['page'],
	'post_type' => 'page',
	'posts_per_page' => 1
));
if(!have_posts()) die("<section class=\"error\"><h1>Page '{$_GET['page']}' Not Found</h1>
Whoops! it looks like the page you were looking for wasn't found. Maybe it was moved or deleted, or you mistyped the URL.</section>");

the_post();
$slug = get_post(get_the_ID())->name;
$share = urlencode(site_url("/?ver={$ver->slug}&page=$slug"));
?>
<article>
	<?php the_content(); ?>
	<a href="<?php the_pagelink($slug); ?>">Permalink</a><br><br>
	<a href="<?php echo FB_URL.$share; ?>" onclick="" class="social icon-fb"></a>|
  <a href="<?php echo TWITTER_URL.$share; ?>" class="social icon-twitter"></a>|
	<a href="<?php echo GPLUS_URL.$share; ?>" class="social icon-gplus"></a>
</article>
<sidebar>
	<?php include(get_template_directory()."/sidebar.php"); ?>
</sidebar>
