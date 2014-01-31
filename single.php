<?php if(empty($_POST)) : ?>
	<?php get_header(); ?>
	<section class="page">
<?php endif; ?>

<?php if(have_posts()) : ?>
	<?php while(have_posts()) : the_post(); ?>
		<?php
		$slug = get_post(get_the_ID())->name;
		$share = get_permalink();
		?>
		<article>
			<header>
				<h1><?php the_title(); ?></h1>
				<h2><?php echo get_post_meta(get_the_ID(), 'subtitle', true); ?></h2>
				<span class="author">By: <?php echo get_post_meta(get_the_ID(), 'verde_author', true); ?></span>
			</header>
			<?php the_content(); ?>
			<a href="<?php echo FB_URL.$share; ?>" onclick="" class="social icon-fb"></a>|
			<a href="<?php echo TWITTER_URL.$share; ?>" class="social icon-twitter"></a>|
			<a href="<?php echo GPLUS_URL.$share; ?>" class="social icon-gplus"></a>
		</article>
		<sidebar>
			<?php include(get_template_directory()."/sidebar.php"); ?>
		</sidebar>
	<?php endwhile; ?>
<?php else : ?>
	<section class="error">
		<h1>Page Not Found</h1>
		<p>Whoops! it looks like the page you were looking for wasn't found. Maybe it was moved or deleted, or you mistyped the URL.</p>
	</section>
<?php endif; ?>

<?php if(empty($_POST)) : ?>
	</section>
	<?php get_footer(); ?>
<?php endif ?>
