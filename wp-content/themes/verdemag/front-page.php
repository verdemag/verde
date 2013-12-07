<?php get_header(); ?>

<?php if (!is_user_logged_in()) : ?>
	<section class="page">
		<h1>Site under construction!</h1>
		<p>Hello, this site is currently under construction! If you want to view the site, please <a href="http://verdemagazine.com/wp-login.php?redirect_to=http%3A%2F%2Fverdemagazine.com%2F&reauth=1">login</a>.</p>
	</section>
	<script>
	 jQuery(document).ready(function() {
		 window.setTimeout(function() {jQuery('.navLink').click(null);}, 200)
	 });
	</script>
	<?php get_footer(); ?>

	<?php die(); ?>
<?php endif; ?>

<?php if(isset($_GET['post'])): ?>
	<section class="post" id="<?php echo $_GET['post']; ?>">
		<?php echo getPage(get_posts(array('name' => $_GET['post']))[0]); ?>
	</section>
<?php elseif(isset($_GET['page'])): ?>
	<section class="page" id="<?php echo $_GET['page']; ?>">
		<?php echo getPage(get_posts(array('name' => $_GET['page']))[0]); ?>
	</section>
<?php elseif(isset($_GET['cat'])): ?>
	<section class="category" id="<?php echo $_GET['cat']; ?>">
		<?php echo getPage(get_category_by_slug($_GET['cat'])); ?>
	</section>
<?php else: ?>
	<section class="page" id="home">
		<?php include 'home.php'; ?>
	</section>
<?php endif; ?>

<?php get_footer(); ?>
