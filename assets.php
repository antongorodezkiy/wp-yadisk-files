<?php if (!defined('WPINC')) die();

	function yadisk_files_admin_register_head() {
		wp_enqueue_style('kube.wp-yadisk-files', plugins_url('css/kube.wp-yadisk-files.css', __FILE__ ));
		wp_enqueue_style('jquery.fileupload-ui.css.wp-yadisk-files', plugins_url('css/jquery.fileupload-ui.css', __FILE__ ));
		wp_enqueue_style('jquery.fileupload.css.wp-yadisk-files', plugins_url('css/jquery.fileupload.css', __FILE__ ));
		wp_enqueue_style('admin.wp-yadisk-files', plugins_url('css/admin.css', __FILE__ ), array('kube.wp-yadisk-files'));
		wp_enqueue_style('popup.wp-yadisk-files', plugins_url('css/popup.css', __FILE__ ));
		wp_register_style('jq-ui.wp-yadisk-files', plugins_url('css/jquery-ui.css', __FILE__ ));
		wp_enqueue_style('jq-ui.wp-yadisk-files');
	}
	
	function yadisk_files_js_settings() {
		echo "
			<script type='text/javascript'>
				var YadiskFiles = {
					lang: [],
					url: []
				};
				YadiskFiles.lang['Choose file'] = '".__('Choose file', 'wp-yadisk-files')."';
				YadiskFiles.lang['Default download label'] = '".get_option('wp-yadisk-files-default-download-label')."';
				YadiskFiles.url['ajaxurl'] = '".admin_url('admin-ajax.php')."';
				YadiskFiles.url['root-directory'] = '".get_option('wp-yadisk-files-root-directory')."';
				YadiskFiles.url['default-directory'] = '".get_option('wp-yadisk-files-default-directory')."';
			</script>
		";
	}
	
	function yadisk_files_add_admin_js_files() {
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-dialog');
		wp_enqueue_script('jquery-ui-tabs');
		
		wp_enqueue_script( 'notify.wp-yadisk-files', plugins_url('js/notify.js', __FILE__ ),array(
			'jquery'
		));
		wp_enqueue_script( 'jquery.ui.widget.wp-yadisk-files', plugins_url('js/jquery.ui.widget.js', __FILE__ ),array(
			'jquery'
		));
		wp_enqueue_script( 'jquery.iframe-transport.js.wp-yadisk-files', plugins_url('js/jquery.iframe-transport.js', __FILE__ ),array(
			'jquery'
		));
		wp_enqueue_script( 'jquery.fileupload.js.wp-yadisk-files', plugins_url('js/jquery.fileupload.js', __FILE__ ),array(
			'jquery'
		));
		wp_enqueue_script( 'admin.wp-yadisk-files', plugins_url('js/admin.js', __FILE__ ),array(
			'jquery',
			'notify.wp-yadisk-files'
		));
		
		wp_localize_script('admin.wp-yadisk-files', 'YadiskFiles', array(
			'lang' => array(
				'Choose file' => __('Choose file', 'wp-yadisk-files'),
				'Default download label' => get_option('wp-yadisk-files-default-download-label')
			),
			'url' => array(
				'ajaxurl' => admin_url('admin-ajax.php'),
				'root-directory' => get_option('wp-yadisk-files-root-directory'),
				'default-directory' => get_option('wp-yadisk-files-default-directory')
			)
		));
	}
	
	function yadisk_files_front_register_head() {
		
		wp_enqueue_style('front.wp-yadisk-files', plugins_url('css/front.wp-yadisk-files.css', __FILE__ ));
		
		wp_enqueue_script('jquery');
		wp_enqueue_script( 'frontend.wp-yadisk-files', plugins_url('js/frontend.js', __FILE__ ),array(
			'jquery'
		));
		
		// javascript settings
			wp_localize_script('frontend.wp-yadisk-files', 'YadiskFiles', array(
				'url' => array(
					'ajaxurl' => admin_url('admin-ajax.php')
				)
			));
	}
