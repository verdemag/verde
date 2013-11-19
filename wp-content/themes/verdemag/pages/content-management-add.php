<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<div class="wrap">
<?php
$vticker_errors = array();
$vticker_success = '';
$vticker_error_found = FALSE;

// Preset the form fields
$form = array(
	'vticker_text' => '',
	'vticker_link' => '',
	'vticker_order' => '',
	'vticker_status' => '',
	'vticker_date' => '',
	'vticker_dateend' => '',
	'vticker_id' => ''
);

// Form submitted, check the data
if (isset($_POST['vticker_form_submit']) && $_POST['vticker_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('vticker_form_add');

	$form['vticker_text'] = isset($_POST['vticker_text']) ? $_POST['vticker_text'] : '';
	if ($form['vticker_text'] == '')
	{
		$vticker_errors[] = __('Please enter your ticker news.', vticker_UNIQUE_NAME);
		$vticker_error_found = TRUE;
	}

	$form['vticker_link'] = isset($_POST['vticker_link']) ? $_POST['vticker_link'] : '';
	if ($form['vticker_link'] == '')
	{
		$vticker_errors[] = __('Please enter your link.', vticker_UNIQUE_NAME);
		$vticker_error_found = TRUE;
	}

	$form['vticker_order'] = isset($_POST['vticker_order']) ? $_POST['vticker_order'] : '';
	if ($form['vticker_order'] == '')
	{
		$vticker_errors[] = __('Please enter your display order.', vticker_UNIQUE_NAME);
		$vticker_error_found = TRUE;
	}

	$form['vticker_status'] = isset($_POST['vticker_status']) ? $_POST['vticker_status'] : '';
	if ($form['vticker_status'] == '')
	{
		$vticker_errors[] = __('Please select your display status.', vticker_UNIQUE_NAME);
		$vticker_error_found = TRUE;
	}

	$form['vticker_dateend'] = isset($_POST['vticker_dateend']) ? $_POST['vticker_dateend'] : '';
	if ($form['vticker_dateend'] == '')
	{
		$vticker_errors[] = __('Please enter the expiration date in this format YYYY-MM-DD.', vticker_UNIQUE_NAME);
		$vticker_error_found = TRUE;
	}

	//	No errors found, we can add this Group to the table
	if ($vticker_error_found == FALSE)
	{
		$vticker_date = date('Y-m-d H:i:s');
		$sql = $wpdb->prepare(
			"INSERT INTO `".vticker_table."`
			(`vticker_text`, `vticker_link`, `vticker_order`, `vticker_status`, `vticker_date`, `vticker_dateend`)
			VALUES(%s, %s, %s, %s, %s, %s);",
			array($form['vticker_text'], $form['vticker_link'], $form['vticker_order'], $form['vticker_status'], $vticker_date, $form['vticker_dateend'])
		);
		$wpdb->query($sql);

		$vticker_success = __('New details was successfully added.', vticker_UNIQUE_NAME);

		// Reset the form fields
		$form = array(
			'vticker_text' => '',
			'vticker_link' => '',
			'vticker_order' => '',
			'vticker_status' => '',
			'vticker_date' => '',
			'vticker_dateend' => '',
			'vticker_id' => ''
		);
	}
}

if ($vticker_error_found == TRUE && isset($vticker_errors[0]) == TRUE)
{
	?>
	<div class="error fade">
		<p><strong><?php echo $vticker_errors[0]; ?></strong></p>
	</div>
	<?php
}
if ($vticker_error_found == FALSE && strlen($vticker_success) > 0)
{
	?>
	  <div class="updated fade">
		<p><strong><?php echo $vticker_success; ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/options-general.php?page=verde-ticker">Click here</a> to view the details</strong></p>
	  </div>
	  <?php
	}
?>
<script language="JavaScript" src="<?php echo get_template(); ?>/pages/setting.js"></script>
<div class="form-wrap">
	<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
	<h2><?php echo vticker_TITLE; ?></h2>
	<form name="vticker_form" method="post" action="#" onsubmit="return _vticker_submit()"  >
      <h3>Add details</h3>

		<label for="tag-a">News</label>
		<textarea name="vticker_text" id="vticker_text" cols="130" rows="2"></textarea>
		<p>Please enter your ticker news.</p>

		<label for="tag-a">Link</label>
		<input name="vticker_link" type="text" id="vticker_link" value="#" size="133" maxlength="1024" />
		<p>Please enter your link.</p>

		<label for="tag-a">Order</label>
		<input name="vticker_order" type="text" id="vticker_order" value="1" size="20" maxlength="3" />
		<p>Please enter your display order.</p>

		<label for="tag-a">Display</label>
		<select name="vticker_status" id="vticker_status">
			<option value='YES' selected="selected">Yes</option>
			<option value='NO'>No</option>
		</select>
		<p>Please select your display status.</p>

		<label for="tag-title">Expiration date</label>
		<input name="vticker_dateend" type="text" id="vticker_dateend" value="9999-12-31" maxlength="10" />
		<p>Please enter the expiration date in this format YYYY-MM-DD <br /> 9999-12-31 : Is equal to no expire.</p>

      <input name="vticker_id" id="vticker_id" type="hidden" value="">
      <input type="hidden" name="vticker_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button" value="Submit" type="submit" />
        <input name="publish" lang="publish" class="button" onclick="_vticker_redirect()" value="Cancel" type="button" />
        <input name="Help" lang="publish" class="button" onclick="_vticker_help()" value="Help" type="button" />
      </p>
	  <?php wp_nonce_field('vticker_form_add'); ?>
    </form>
</div>
</div>
