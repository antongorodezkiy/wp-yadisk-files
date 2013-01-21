<?php if (!defined('WPINC')) die();

	function yadiskFilesAddButtons()
	{
		
		// Don't bother doing this stuff if the current user lacks permissions
		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
			return;
	 
		// Add only in Rich Editor mode
		if ( get_user_option('rich_editing') == 'true') {
			add_filter("mce_external_plugins", "add_yadisk_files_tinymce_plugin");
			add_filter('mce_buttons', 'register_yadisk_files_button');
		}
		else
			add_filter('mce_buttons', 'register_yadisk_files_button');
	}
	 
	function register_yadisk_files_button($buttons) {
		array_push($buttons, "separator", "YadiskFiles");
		return $buttons;
	}
	 
	// Load the TinyMCE plugin : editor_plugin.js (wp2.5)
	function add_yadisk_files_tinymce_plugin($plugin_array) {
		$plugin_array['YadiskFiles'] = plugins_url( 'js/editor_plugin.js' , __FILE__ );
		return $plugin_array;
	}
