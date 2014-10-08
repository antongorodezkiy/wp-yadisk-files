<?php if (!defined('WPINC')) die();
/*
	Plugin Name: YaDisk Files
	Plugin URI: http://eduard.kozachek.net/projects/wordpress-projects/wp-yadisk-files-plugin/
	Description: This plugin is created for easy adding files from <a target="_blank" href="http://disk.yandex.com/">Yandex Disk</a> service to posts or pages of your wordpress site.
	Version: 1.2.2
	Author: AntonGorodezkiy
	Author URI: http://eduard.kozachek.net/
	License: GPLv2
	Text Domain: wp-yadisk-files
*/

define('YADISK_FILES_PLUGIN','wp-yadisk-files');
define('YADISK_FILES_APPPATH',dirname(__FILE__));
include_once(YADISK_FILES_APPPATH.'/libraries/functions.php');
include_once(YADISK_FILES_APPPATH.'/assets.php');
add_action('init', 'yadisk_files_front_register_head');

// Create Text Domain For Translations
	function yadiskFilesLocalization() {
		load_plugin_textdomain('wp-yadisk-files', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/'.get_locale().'/' );
	}
	add_action('wp_loaded', 'yadiskFilesLocalization');

// init api
	function YadiskFilesInitApi() {
		// includes
			if (!class_exists('webdav_client')) {
				require(YADISK_FILES_APPPATH.'/libraries/class_webdav_client.php');
			}
			
			if (!class_exists('yadisk')) {
				include_once(YADISK_FILES_APPPATH.'/libraries/yadisk.class.php');
			}
			
			if (!class_exists('YadiskAPI')) {
				include_once(YADISK_FILES_APPPATH.'/controllers/yadiskapi.php');
			}
			
		return new YadiskAPI(get_option('wp-yadisk-files-login'), get_option('wp-yadisk-files-pass'));
	}

/* Shortcode */
	function yadisk_files_init_shortcodes() {
		function YadiskFilesShortcode( $atts ) {
			
			$yadisk_download_counters = get_option('yadisk_download_counters', array());
			$filename = parse_str(parse_url(html_entity_decode($atts['href']), PHP_URL_QUERY), $href);
			
			$counter = (isset($yadisk_download_counters[$href['filename']]) ? $yadisk_download_counters[$href['filename']] : 0);
			
			$html = '
				<div class="yadisk-download-container">
					<a class="yadisk-download" href="{href}" title="{size}" target="_blank">
						{label} {size} {download_counter}
					</a>
				</div>
			';
			
			return str_replace(
				array(
					'{href}',
					'{size}',
					'{name}',
					'{label}',
					'{download_counter}'
				),
				array(
					$atts['href'],
					$atts['size'],
					$atts['name'],
					(isset($atts['label']) ? $atts['label'] : str_replace('{name}',$atts['name'],__('Download {name} from Yandex.Disk','wp-yadisk-files'))),
					(isset($atts['counter']) && $atts['counter'] == 'true' ?
						__('Download count: ','wp-yadisk-files').$counter
						: '' )
				),
				$html);
		}
		add_shortcode( 'YadiskFiles', 'YadiskFilesShortcode' );
	}
	add_action('wp_loaded', 'yadisk_files_init_shortcodes');
	
// for transparent mode
	function yadisk_files_init_routing() {

		// routing
			if (isset($_REQUEST[YADISK_FILES_PLUGIN]) && isset($_REQUEST['action']))
			{
				switch($_REQUEST['action'])
				{
					case 'download':
						
						if (isset($_REQUEST['filename'])) {
							
							$filename = esc_sql(sanitize_text_field($_REQUEST['filename']));
							
							// count download
								$yadisk_download_counters = get_option('yadisk_download_counters', array());
								if (!isset($yadisk_download_counters[$filename])) {
									$yadisk_download_counters[$filename] = 0;
								}
								$yadisk_download_counters[$filename]++;
								update_option('yadisk_download_counters', $yadisk_download_counters);
							
							// init api
							$YadiskAPI = YadiskFilesInitApi();
							$YadiskAPI->download();
						}
					break;
				}
			}
	}
	add_action('init', 'yadisk_files_init_routing');
	
if (is_admin())
{
		
			
	// init api
		if (!isset($YadiskAPI)) {
			$YadiskAPI = YadiskFilesInitApi();
		}
	
	/* Notify */
		if(!class_exists('Notify')) {
			include_once(YADISK_FILES_APPPATH.'/libraries/notify.class.php');
			$notify = new Notify(array('ttl' => 4));
		}
		
	
		
	/* styles and scripts */
	add_action('admin_print_styles', 'yadisk_files_js_settings');
	add_action('admin_print_styles', 'yadisk_files_admin_register_head');
	add_action('admin_head','yadisk_files_add_admin_js_files');
	
	
	/* editor */
		include_once(YADISK_FILES_APPPATH.'/editor.php');
		add_action('init', 'yadiskFilesAddButtons');
		
	/* admin menu and settings */
		include_once(YADISK_FILES_APPPATH.'/controllers/settings.php');
		
		add_action('wp_ajax_yadisk_files_get_list', array($YadiskAPI, 'getList'));
		add_action('wp_ajax_yadisk_files_upload', array($YadiskAPI, 'upload'));
		add_action('wp_ajax_yadisk_files_publish', array($YadiskAPI, 'publish'));
		add_action('wp_ajax_yadisk_files_get_popup_template', array($YadiskAPI, 'getPopupTemplate'), 10, 'popup');
}
