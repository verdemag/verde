<?php get_header(); ?>

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

<?php if(isset($_GET['post'])): ?>
	<section class="post" id="<?php echo $_GET['post']; ?>">
		<?php include "templates/post.php"; ?>
	</section>
<?php elseif(isset($_GET['page'])): ?>
	<section class="page" id="<?php echo $_GET['page']; ?>">
		<?php include "templates/page.php"; ?>
	</section>
<?php elseif(isset($_GET['cat'])): ?>
	<section class="category" id="<?php echo $_GET['cat']; ?>">
		<?php include "templates/category.php"; ?>
	</section>
<?php else: ?>
	<section class="page" id="home">
		<?php include "templates/home.php"; ?>
	</section>
<?php endif; ?>

<?php get_footer(); ?>
