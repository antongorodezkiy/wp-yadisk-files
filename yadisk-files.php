<?php if (!defined('WPINC')) die();
/*
	Plugin Name: YaDisk Files
	Plugin URI: 
	Description: Wordpress Yandex Disk Files Plugin
	Version: 1.0
	Author: AntonGorodezkiy
	Author URI: http://kozachek.net/
	License: GNU GPL 2
	Text Domain: yadisk_files
*/

define('YADISK_FILES_APPPATH',dirname(__FILE__));
include_once(YADISK_FILES_APPPATH.'/libraries/functions.php');
include_once(YADISK_FILES_APPPATH.'/assets.php');
add_action('init', 'yadisk_files_front_register_head');

/* Shortcode */
	function YadiskFilesShortcode( $atts ){
		return sprintf('
			<div class="yadisk-download-container">
				<a class="yadisk-download" href="%s" title="%s" target="_blank">
					Скачать %s с Яндекс.Диск
				</a>
			</div>
		',$atts['href'],$atts['size'],$atts['name']);
	}
	add_shortcode( 'YadiskFiles', 'YadiskFilesShortcode' );
	
	
	
if (is_admin())
{
	
/*
	error_reporting(E_ALL);
	ini_set('display_errors',1);
*/


// Create Text Domain For Translations
	function yadiskFilesLocalization() {
		load_plugin_textdomain('yadisk_files', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/'.get_locale().'/' );
	}
	add_action('wp_loaded', 'yadiskFilesLocalization');
	
		
// includes
	if (!class_exists('webdav_client')) {
		require(YADISK_FILES_APPPATH.'/libraries/class_webdav_client.php');
	}
	
	if (!class_exists('yadisk')) {
		require(YADISK_FILES_APPPATH.'/libraries/yadisk.class.php');
	}
	include_once(YADISK_FILES_APPPATH.'/controllers/yadiskapi.php');
	$YadiskAPI = new YadiskAPI(get_option('yadisk-files-login'), get_option('yadisk-files-pass'));

/* Notify */
	if(!class_exists('Notify')) {
		include_once(YADISK_FILES_APPPATH.'/libraries/notify.class.php');
		$notify = new Notify(array('ttl' => 4));
	}
	

	
/* styles and scripts */
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
	
}
