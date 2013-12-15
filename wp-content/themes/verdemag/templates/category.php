<?php
require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/wp-blog-header.php');
global $ver;

$cat = get_category_by_slug($_GET['cat']);
if(!$cat) die("category '{$_GET['cat']}' not found :/");

query_posts(array(
	'category__and' => array($cat->cat_ID, $ver->cat_ID),
	'posts_per_page' => -1
));
?>
<section class="articles">
	<?php while(have_posts()) : the_post(); ?>
		<?php
		$slug = get_post(get_the_ID())->post_name;
		$thumb = get_the_post_thumbnail(get_the_ID(), array(300, 255));
		$link = site_url("/?ver={$ver->slug}&post=$slug");
		?>
		<article>
			<?php if($thumb) : ?><div class="featured-img"><?php echo $thumb; ?></div><?php endif; ?>
			<header>
				<a href="<?php echo $link; ?>" data-target="<?php echo $slug; ?>" class="navLink">
					<h1><?php the_title(); ?></h1>
				</a>
				<h2><?php echo get_post_meta(get_the_ID(), 'subtitle', true); ?></h2>
				<span class="author">By: <?php echo get_post_meta(get_the_ID(), 'verde_author', true); ?></span>
			</header>
			<?php the_excerpt(); ?>
			<a href="<?php echo $link; ?>" data-target="<?php echo $slug; ?>" class="navLink">Read more</a>
		</article>
	<?php endwhile; ?>
</section>
<sidebar>
	<?php include(get_template_directory()."/sidebar.php"); ?>
</sidebar>
