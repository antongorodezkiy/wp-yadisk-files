<?php if (!defined('WPINC')) die();

	function yadisk_files_admin_register_head() {
		wp_enqueue_style('kube.wp-yadisk-files', plugins_url('css/kube.wp-yadisk-files.css', __FILE__ ));
		wp_enqueue_style('admin.wp-yadisk-files', plugins_url('css/admin.css', __FILE__ ), array('kube.wp-yadisk-files'));
		wp_register_style('jq-ui','http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/themes/smoothness/jquery-ui.css');
		wp_enqueue_style('jq-ui');
	}
	
	function yadisk_files_js_settings() {
		echo "
			<script type='text/javascript'>
				var YadiskFiles = {
					lang: []
				};
				YadiskFiles.lang['Choose file'] = '".__('Choose file', 'wp-yadisk-files')."';
			</script>
		";
	}
	
	function yadisk_files_add_admin_js_files() {
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-dialog');
		wp_enqueue_script('jquery-ui-tabs');	
		wp_enqueue_script( 'admin.wp-yadisk-files', plugins_url('js/admin.js', __FILE__ ),array(
			'jquery'
		));
	}
	
	function yadisk_files_front_register_head() {	
		wp_enqueue_style('front.wp-yadisk-files', plugins_url('css/front.wp-yadisk-files.css', __FILE__ ));	
	}
