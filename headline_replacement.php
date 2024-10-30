<?php
/*
Plugin Name: Headline Replacement
Plugin URI: http://mariokostelac.com/plugins/headline-replacement
Description: Simple plugin allows replacing headlines by unique images. Just upload, no sIFR, no Cufon. Plugin is based on http://wordpress.org/extend/plugins/headline-image/ plugin originally written by Pavol Klacansky
Version: 0.1.2
Author: Mario Kostelac
Author URI: http://www.mariokostelac.com
*/

// get setted options
$options = get_option('_unique_image');

// only in admin section
if (is_admin())
{
	
	wp_enqueue_script('headline_image_script', WP_PLUGIN_URL . '/headline-replacement/js/image.js');// register script

	// load function
	if (!function_exists('add_meta_box'))
		require_once('includes/template.php');

	// add box in Post page
	add_meta_box('headline_image_div', __('Headline replacement'), 'headline_image_meta_box', 'page', 'normal', 'high');
	add_meta_box('headline_image_div', __('Headline replacement'), 'headline_image_meta_box', 'post', 'normal', 'high');
	add_action('save_post', 'headline_image_save');
	
	// add entry to Settings menu and add setting page
	add_action('admin_menu', 'headline_image_admin_menu');
	add_action('admin_init', 'headline_image_admin_register');
	
	function headline_image_admin_menu()
	{
		add_submenu_page('options-general.php', 'Headline replacement Usage', 'Headline replacement', 'administrator', __FILE__, 'headline_image_settings_page', '');
	}
	
	function headline_image_settings_page()
	{
		global $options;
			
		// URL must be valid
		if (!headline_image_valid_url($url))
		{
			$error = __('Not valid URL.', 'headline_replacement') . ' ';
			$url = '';
		}	
?>
<div class="wrap">
	<h2>Headline replacement Usage</h2>

	<!-- begin: example of integration with template -->
	<h3>Example of integration with your template</h3>
	<ol>
		<li>Open your template file e.g. /wp-content/themes/your_theme_name/single.php</li>
		<li>Add into LOOP that code <code>&lt;?php if (function_exists(&#039;headline_image_show&#039;)) headline_image_show(); ?&gt;</code></li>
	</ol>
	<!-- end: example of integration with template -->
</div>
<?php
	}

	// register settings
	function headline_image_admin_register()
	{
		register_setting('headline_image_settings_page', '_headline_replacement');
	}

}

// copied and modified function media_buttons() from file /wp-admin/includes/media.php
function headline_image_button()
{
	global $post_ID, $temp_ID;
	
	$uploading_iframe_ID = (int) (0 == $post_ID ? $temp_ID : $post_ID);
	$context = apply_filters('media_buttons_context', __('Upload/Insert %s'));
	$media_upload_iframe_src = "media-upload.php?post_id=$uploading_iframe_ID";
	
	$image_upload_iframe_src = apply_filters('image_upload_iframe_src', "$media_upload_iframe_src&amp;type=image");
	$image_title = __('Add an Image');
	$out = <<<EOF
	<a href="{$image_upload_iframe_src}&amp;TB_iframe=true" class="thickbox" title='$image_title' onclick="return false;"><img src='images/media-button-image.gif' alt='$image_title' /></a>
EOF;
	printf($context, $out);
}

function headline_image_meta_box($post)
{
	global $post_ID, $temp_ID;
	
	$image_ID = get_post_meta($post_ID, '_headline_image', true);
	
	echo '<input type="hidden" name="headline_image_value" id="headline_image_value" value="' . $image_ID . '" />';
?>
<div id="headline_image_button"><?php headline_image_button(); ?></div>

<p id="headline_image_show">
	<?php echo wp_get_attachment_image($image_ID, 'full'); ?>
</p>

<a href="#" onclick="headline_image_clear()" <?php echo $image_ID ? '' : 'style="display: none;"'; ?> id="headline_image_remove"><?php echo __('Remove'); ?></a>
<?php
}

// save image to DB
function headline_image_save($post_ID)
{
	// if hidden form does not exists, then do nothing (0 => no image, '' => form not exists, 1,2,... => id of image)
	if ($_POST['headline_image_value'] != '')
		update_post_meta($post_ID, '_headline_image', intval($_POST['headline_image_value']));
}

function headline_image_get($post_ID = 0)
{
	global $post;
	
	// if $post_ID is not setted (for special purposes), use normal ID from global variable
	if (!$post_ID)
		$post_ID = $post->ID;
	
	$attachment_id = get_post_meta($post_ID, '_headline_image', true);
	
	// use alternate text for image (if it is setted)
	return wp_get_attachment_image_src($attachment_id, $size = 'full', $icon = false, array('alt' => get_post_meta($attachment_id, '_wp_attachment_image_alt', true)));
}

function headline_image_show($post_ID = 0)
{
	global $post;
	
	// if $post_ID is not setted (for special purposes), use normal ID from global variable
	if (!$post_ID)
		$post_ID = $post->ID;
	
	$attachment_id = get_post_meta($post_ID, '_headline_image', true);
	
	// use alternate text for image (if it is setted)
	echo wp_get_attachment_image($attachment_id, $size = 'full', $icon = false, array('alt' => get_post_meta($attachment_id, '_wp_attachment_image_alt', true)));
}

function headline_image_valid_url($url)
{
	return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
}

?>