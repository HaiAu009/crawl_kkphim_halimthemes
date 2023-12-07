<?php
/**
 * Plugin Name: Crawl KKPHIM.COM (gốc OPHIM)
 * Description: Crawl + Update Dữ liệu từ KKPHIM.COM (WP - Halimthemes - 5.5.4)
 * Version: 1.2.0
 * Author: Phantom0803
 * Author URI: https://kkphim.com/
 */
set_time_limit(0);
define('CRAWL_KKPHIM_URL', plugin_dir_url(__FILE__));
define('CRAWL_KKPHIM_PATH', plugin_dir_path(__FILE__));
define('CRAWL_KKPHIM_PATH_SCHEDULE_JSON', CRAWL_KKPHIM_PATH . 'schedule.json');
require_once CRAWL_KKPHIM_PATH . 'constant.php';

function crawl_tools_script()
{
	global $pagenow;
	if ('admin.php' == $pagenow && ($_GET['page'] == 'crawl-kkphim-tools' || $_GET['page'] == 'crawl-tools')) {
		wp_enqueue_script('crawl_tools_js', CRAWL_KKPHIM_URL . 'assets/js/main.js?v=1.2.0.0');
		wp_enqueue_style('crawl_tools_css', CRAWL_KKPHIM_URL . 'assets/css/styles.css?v=1.2.0.0');
	} else {
		return;
	}
}
add_action('in_admin_header', 'crawl_tools_script');

// Custom metabox in post
function kkphim_meta_box() {
	add_meta_box( 'kkphim-custom-edit', 'KKPHIM Custom Edit', 'kkphim_custom_meta_box', 'post', 'advanced', 'high' );
}
add_action( 'add_meta_boxes', 'kkphim_meta_box' );

function kkphim_custom_meta_box($post, $metabox) {
	$_halim_metabox_options = get_post_meta($post->ID, '_halim_metabox_options', true);
	wp_nonce_field(basename(__FILE__), 'post_media_metabox');
?>
  <div class="inside">
    <label for="fetch_kkphim_id">KKPHIM ID: </label><input styles="width: 100%" name="fetch_kkphim_id" type="text" id="fetch_kkphim_id" value="<?php echo $_halim_metabox_options["fetch_kkphim_id"];?>">
    <label for="fetch_kkphim_update_time">Thời gian cập nhật: </label><input styles="width: 100%" name="fetch_kkphim_update_time" type="text" id="fetch_kkphim_update_time" value="<?php echo $_halim_metabox_options["fetch_kkphim_update_time"];?>">
	</div>
<?php
}

function kkphim_custom_save_metabox($post_id, $post)
{
  if (!wp_verify_nonce($_POST["post_media_metabox"], basename(__FILE__))) {
		return $post_id;
	}
	if (defined("DOING_AUTOSAVE") && DOING_AUTOSAVE) {
		return $post_id;
	}
	if ('post' != $post->post_type) {
		return $post_id;
	}
  $fetch_kkphim_id = (isset($_POST["fetch_kkphim_id"])) ? sanitize_text_field($_POST["fetch_kkphim_id"]) : '';
  $fetch_kkphim_update_time = (isset($_POST["fetch_kkphim_update_time"])) ? sanitize_text_field($_POST["fetch_kkphim_update_time"]) : '';

	$_halim_metabox_options = get_post_meta($post_id, '_halim_metabox_options', true);
	$_halim_metabox_options["fetch_kkphim_id"] = $fetch_kkphim_id;
	$_halim_metabox_options["fetch_kkphim_update_time"] = $fetch_kkphim_update_time;
	
	update_post_meta($post_id, '_halim_metabox_options', $_halim_metabox_options);
}
add_action('save_post', 'kkphim_custom_save_metabox', 20, 2);

include_once CRAWL_KKPHIM_PATH . 'functions.php';
include_once CRAWL_KKPHIM_PATH . 'crawl_movies.php';
