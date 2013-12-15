<?php
require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/wp-blog-header.php');
global $ver;

$cat = get_category_by_slug($_GET['cat']);
if(!$cat) die("<section class=\"error\"><h1>Category '{$_GET['cat']}' Not Found</h1>
Whoops! it looks like the category you were looking for wasn't found. Maybe it was moved or deleted, or you mistyped the URL.</section>");

query_posts(array(
	'category__and' => array($cat->cat_ID, $ver->cat_ID),
	'posts_per_page' => -1
));
$i = 0;
?>

<section class="articles">
	<?php while(have_posts()) : the_post(); ?>
		<?php
		$slug = get_post(get_the_ID())->post_name;
		$thumb = get_the_post_thumbnail(get_the_ID(), array(300, 255));
		?>
		<?php if($i % 2 == 0) : ?><div class="cf"><?php endif; ?>
		<article>
			<?php if($thumb) : ?><div class="featured-img"><?php echo $thumb; ?></div><?php endif; ?>
			<header>
				<a href="<?php the_postlink($slug); ?>" data-target="<?php echo $slug; ?>" class="navLink">
					<h1><?php the_title(); ?></h1>
				</a>
				<h2><?php echo get_post_meta(get_the_ID(), 'subtitle', true); ?></h2>
				<span class="author">By: <?php echo get_post_meta(get_the_ID(), 'verde_author', true); ?></span>
			</header>
			<?php the_excerpt(); ?>
			<a href="<?php the_postlink($slug); ?>" data-target="<?php echo $slug; ?>" class="navLink">Read more</a>
		</article>
		<?php if($i % 2 == 1) : ?></div><?php endif; ?>
		<?php $i++; ?>
	<?php endwhile; ?>
</section>
<sidebar>
	<?php include(get_template_directory()."/sidebar.php"); ?>
</sidebar>
