<?php
/**
 * The footer!
 */
?>
</main>
<footer>
	<div>
		<div class="row">&#169; Verde Magazine</div>
    <div class="row">
		  <a class="navLink" id="aboutlink">About</a> -
		  <a href="">Contact</a> -
      <a id="zoombutton">Zoom</a>
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
</div><!-- Close mask div -->
<?php
if (current_user_can('administrator')){
    global $wpdb;
    echo "<pre>";
    print_r($wpdb->queries);
    echo "</pre>";
}
?>
<?php wp_footer(); ?>
</body>
</html>
