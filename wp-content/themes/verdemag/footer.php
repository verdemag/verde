</main>
</div>
</div>
<footer>
	<div>
		<div class="row">&#169; Verde Magazine 2014</div>
    <div class="row">
		  <a href="/?page=about" class="navlink" data-target="about">About</a> -
		  <a href="/?page=contact" class="navlink" data-target="contact">Contact</a>
    </div>
    <div class="row">
      <?php if (is_user_logged_in()) : ?>
      <a href="wp-admin">Dashboard</a> -
      <a href="wp-admin/post-new.php">Write</a> -
			<a href="<?php echo wp_logout_url(); ?>">Logout</a>
      <?php else : ?>
      <a href="<?php echo wp_login_url(); ?>">Login</a>
      <?php endif; ?>
    </div>
	</div>
	<address>
		Palo Alto High School</br>
		50 Embarcadero Rd</br>
		Palo Alto, California 94301
	</address>
</footer>
<?php wp_footer(); ?>
</body>
</html>
