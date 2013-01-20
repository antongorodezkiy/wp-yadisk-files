<?php if (!defined('WPINC')) die();

	add_action( 'admin_menu', 'register_yadisk_files_menu_page' );
	function register_yadisk_files_menu_page()
	{
		add_options_page('YaDisk Files', 'YaDisk Files', 'manage_options', 'wp-wp-yadisk-files/wp-yadisk-files.php?page=settings', 'yadisk_files_settings', get_option('siteurl')."/wp-content/plugins/wp-wp-yadisk-files/img/icon.png");
	}

	function yadisk_files_settings() {
		global $notify;
		include_once(YADISK_FILES_APPPATH.'/views/settings.php');
	}
	
	
	function yadisk_files_settingsInit() {
		register_setting( 'YadiskFilesSettings', 'wp-yadisk-files-login' );
		register_setting( 'YadiskFilesSettings', 'wp-yadisk-files-pass' );
	}
	add_action('admin_init', 'yadisk_files_settingsInit');

