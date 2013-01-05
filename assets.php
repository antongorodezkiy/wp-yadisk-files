<?php if (!defined('WPINC')) die();

	function yadisk_files_admin_register_head()
	{
		wp_enqueue_style('admin.yadisk-files', plugins_url('css/admin.css', __FILE__ ));
			
		echo "
			<script type='text/javascript'>
				var YadiskFiles = YadiskFiles || {};
				YadiskFiles.lang = {
					'Yadisk Files': '".__('Yadisk Files','yadisk-files')."'
				};
				YadiskFiles.urls = {
					'ajax': '".admin_url('admin.php?page=wp-yadisk-files/yadisk-files.php',false)."'
				};
			</script>
		";
	}
	
	
	function yadisk_files_add_admin_js_files()
	{
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-dialog');
		wp_enqueue_script('jquery-ui-tabs');
		//wp_enqueue_script( 'jquery.hoverintent', plugins_url('js/jquery.hoverintent.js', __FILE__ ),array('jquery'));
		
		//wp_enqueue_script( 'admin.yadisk-files', plugins_url('js/admin.js', __FILE__ ),array(
		//	'jquery',
	//		'jquery.tree'
		//));
		
	}
	
	
	
	function yadisk_files_front_register_head()
	{	
		wp_enqueue_style('front.yadisk-files', plugins_url('css/front.yadisk-files.css', __FILE__ ));	
	}
	

