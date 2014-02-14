<?php $i = 0; ?>
<?php if(empty($_POST)) : ?>
	<?php get_header(); ?>
	<?php global $wp_query; ?>
	<section class="category" id="<?php echo get_query_var('category_name'); ?>">
<?php endif; ?>

<?php if(have_posts()) : ?>
	<?php echo get_query_var('post_name'); ?>
	<section class="articles">
		<?php while(have_posts()) : the_post(); ?>
			<?php
			$slug = get_post(get_the_ID())->post_name;
			$thumb = get_the_post_thumbnail(get_the_ID(), array(300, 255));
			?>
			<?php if($i % 2 == 0) : ?><div class="cf"><?php endif; ?>
				<article>
					<header>
						<a href="<?php the_permalink(); ?>" data-target="<?php echo $slug; ?>" class="navlink">
							<?php if($thumb) : ?>
								<div class="featured-img"><?php echo $thumb; ?></div>
							<?php endif; ?>
							<h1><?php the_title(); ?></h1>
						</a>
						<h2><?php echo get_post_meta(get_the_ID(), 'subtitle', true); ?></h2>
						<span class="author">By: <?php echo get_post_meta(get_the_ID(), 'verde_author', true); ?></span>
					</header>
					<?php the_excerpt(); ?>
					<a href="<?php the_permalink(); ?>" data-target="<?php echo $slug; ?>" class="navlink">Read more</a>
				</article>
				<?php if($i % 2 == 1) : ?></div><?php endif; ?>
				<?php $i++; ?>
		<?php endwhile; ?>
	</section>

	<?php get_sidebar(); ?>
<?php else : ?>
	<section class="error">
		<h1>No Articles Found</h1>
		<p>Unfortunately, no articles were found in this category</p>
	</section>
<?php endif; ?>

<?php if(empty($_POST)) : ?>
	</section>
	<?php get_footer(); ?>
<?php endif ?>
