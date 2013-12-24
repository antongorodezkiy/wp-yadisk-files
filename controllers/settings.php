<?php if (!defined('WPINC')) die();

	add_action( 'admin_menu', 'register_yadisk_files_menu_page' );
	function register_yadisk_files_menu_page()
	{
		add_options_page('YaDisk Files', 'YaDisk Files', 'manage_options', 'wp-yadisk-files', 'yadisk_files_settings', plugins_url('../img/icon.png', __FILE__));
	}

	function yadisk_files_settings() {
		global $notify;
		include_once(YADISK_FILES_APPPATH.'/views/settings.php');
	}
	
	
	function yadisk_files_settingsInit() {
		register_setting( 'YadiskFilesSettings', 'wp-yadisk-files-login' );
		register_setting( 'YadiskFilesSettings', 'wp-yadisk-files-pass' );
		register_setting( 'YadiskFilesSettings', 'wp-yadisk-files-root-directory' );
		register_setting( 'YadiskFilesSettings', 'wp-yadisk-files-default-directory' );
		register_setting( 'YadiskFilesSettings', 'wp-yadisk-files-default-download-label' );
		register_setting( 'YadiskFilesSettings', 'wp-yadisk-files-transparent-mode' );
	}
	add_action('admin_init', 'yadisk_files_settingsInit');

	// plugin actions
		function yadisk_files_plugin_actions($links, $file){
			if ($file == 'wp-yadisk-files/wp-yadisk-files.php') {
				$settings_link = '<a href="options-general.php?page=wp-yadisk-files">' . __('Settings', 'wp-yadisk-files') . '</a>';
				$links = array_merge(array($settings_link), $links);
			}
			return $links;
		}
		add_filter('plugin_action_links', 'yadisk_files_plugin_actions', 10, 2);
