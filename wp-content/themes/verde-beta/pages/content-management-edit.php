<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<div class="wrap">
<?php
$did = isset($_GET['did']) ? $_GET['did'] : '0';

// First check if ID exist with requested ID
$sSql = $wpdb->prepare(
	"SELECT COUNT(*) AS `count` FROM ".vticker_table."
	WHERE `vticker_id` = %d",
	array($did)
);
$result = '0';
$result = $wpdb->get_var($sSql);

if ($result != '1')
{
	?><div class="error fade"><p><strong>Oops, selected details doesn't exist.</strong></p></div><?php
}
else
{
	$vticker_errors = array();
	$vticker_success = '';
	$vticker_error_found = FALSE;

	$sSql = $wpdb->prepare("
		SELECT *
		FROM `".vticker_table."`
		WHERE `vticker_id` = %d
		LIMIT 1
		",
		array($did)
	);
	$data = array();
	$data = $wpdb->get_row($sSql, ARRAY_A);

	// Preset the form fields
	$form = array(
		'vticker_text' => $data['vticker_text'],
		'vticker_link' => $data['vticker_link'],
		'vticker_order' => $data['vticker_order'],
		'vticker_status' => $data['vticker_status'],
		'vticker_date' => $data['vticker_date'],
		'vticker_dateend' => $data['vticker_dateend'],
		'vticker_id' => $data['vticker_id']
	);
}
// Form submitted, check the data
if (isset($_POST['vticker_form_submit']) && $_POST['vticker_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('vticker_form_edit');

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
		$sSql = $wpdb->prepare(
				"UPDATE `".vticker_table."`
				SET `vticker_text` = %s,
				`vticker_link` = %s,
				`vticker_order` = %s,
				`vticker_status` = %s,
				`vticker_dateend` = %s
				WHERE vticker_id = %d
				LIMIT 1",
				array($form['vticker_text'], $form['vticker_link'], $form['vticker_order'], $form['vticker_status'], $form['vticker_dateend'], $did)
			);

		$wpdb->query($sSql);

		$vticker_success = 'Details was successfully updated.';
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
      <h3>Update details</h3>

	  <label for="tag-a">News</label>
		<textarea name="vticker_text" id="vticker_text" cols="130" rows="2"><?php echo esc_html(stripslashes($form['vticker_text'])); ?></textarea>
		<p>Please enter your ticker news.</p>

		<label for="tag-a">Link</label>
		<input name="vticker_link" type="text" id="vticker_link" value="<?php echo $form['vticker_link']; ?>" size="133" maxlength="1024" />
		<p>Please enter your link.</p>

		<label for="tag-a">Order</label>
		<input name="vticker_order" type="text" id="vticker_order" value="<?php echo $form['vticker_order']; ?>" size="20" maxlength="3" />
		<p>Please enter your display order.</p>

		<label for="tag-a">Display</label>
		<select name="vticker_status" id="vticker_status">
			<option value='YES' <?php if($form['vticker_status'] == 'YES') { echo "selected='selected'" ; } ?>>Yes</option>
			<option value='NO' <?php if($form['vticker_status'] == 'NO') { echo "selected='selected'" ; } ?>>No</option>
		</select>
		<p>Please select your display status.</p>

		<label for="tag-title">Expiration date</label>
		<input name="vticker_dateend" type="text" id="vticker_dateend" value="<?php echo substr($form['vticker_dateend'],0,10); ?>" maxlength="10" />
		<p>Please enter the expiration date in this format YYYY-MM-DD <br /> 9999-12-31 : Is equal to no expire.</p>

      <input name="vticker_id" id="vticker_id" type="hidden" value="<?php echo $form['vticker_id']; ?>">
      <input type="hidden" name="vticker_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button add-new-h2" value="Update Details" type="submit" />
        <input name="publish" lang="publish" class="button add-new-h2" onclick="_vticker_redirect()" value="Cancel" type="button" />
        <input name="Help" lang="publish" class="button add-new-h2" onclick="_vticker_help()" value="Help" type="button" />
      </p>
	  <?php wp_nonce_field('vticker_form_edit'); ?>
    </form>
</div>
</div>