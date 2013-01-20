<?php
	include '../../../wp-blog-header.php';
	
	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js');
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery-ui-core' );
	wp_enqueue_script( 'jquery-ui-tabs' );
	
	if(!class_exists('Notify')) {
		include_once(YADISK_FILES_APPPATH.'/libraries/notify.class.php');
		$notify = new Notify(array('ttl' => 4));
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title><?=__('Yadisk Files', 'wp-yadisk-files')?></title>
	<?php wp_head(); ?>
	<script type="text/javascript">
		var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
	</script>
	<?=$notify->initJsCss()?>
	<script type="text/javascript" src="js/admin.js"></script>
	<script type="text/javascript" src="js/tiny_mce_popup.js"></script>
	<link rel="stylesheet" href="css/kube.css" />
	<link rel="stylesheet" href="css/popup.css" />
</head>
<body class="wp-yadisk-files">
	<div class="loading hidden"></div>
	<div class="loading_back hidden"></div>
	<form>
		<div class="breadcrumbs"></div>
		<?php if (!get_option('wp-yadisk-files-login') or !get_option('wp-yadisk-files-pass')) { ?>
			<a href="#"><?=__('Need to set login and password in Yadisk Files plugin settings','wp-yadisk-files')?></a>
		<?php }
		else { ?>
			<div class="container">
				<table class="width-100 bordered">
					<thead class="thead-gray">
						<tr>
							<th><?=__('Filename', 'wp-yadisk-files')?></th>
							<th><?=__('Size', 'wp-yadisk-files')?></th>
						</tr>
					</thead>
					<tbody class="content">
					</tbody>	
				</table>	
			</div>
		<?php } ?>
		<div class="clear"></div>
    
		<div id="clear" class="buttonclear"></div>
		
        <div id="tinysubmit" style="float: right">	
			<input type="button" id="cancel" name="cancel" value="{#close}" onclick="tinyMCEPopup.close();" />
		</div>
    </form>
</body>
</html>
