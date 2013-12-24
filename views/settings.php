<?php if (!defined('WPINC')) die(); ?>

<div class="wrap wp-yadisk-files row">

	<?=$notify->getMessages()?>
	
	<h2>
		<?=__('YaDisk Files', 'wp-yadisk-files')?>
	</h2>

	<div class="row container">  
		<div class="twothird">			

			<form class="wp-yadisk-files-content wp-yadisk-files-bl validateThisForm" method="post" action="options.php">
				
				<?php settings_fields('YadiskFilesSettings'); ?>
				
				<div class="row hdr">
					<div class="icon32" id="icon-ms-admin"><br /></div>
					<h3>
						<?=__('YaDisk Files Settings', 'wp-yadisk-files')?>
					</h3>
				</div>
				
				<div class="row in">
					<div class="row">
						<div class="half">
							<label class="label push-right"><?=__('Yadisk Login', 'wp-yadisk-files')?>*</label>
						</div>
						<div class="inputs half">
							<input class="width-50" type="text" name="wp-yadisk-files-login" value="<?=get_option('wp-yadisk-files-login')?>" required="required"/>
						</div>
					</div>
							
					<div class="row">
						<div class="half">
							<label class="label push-right"><?=__('Yadisk Password', 'wp-yadisk-files')?>*</label>
						</div>
						<div class="inputs half">
							<input class="width-50" type="password" name="wp-yadisk-files-pass" value="<?=get_option('wp-yadisk-files-pass')?>" required="required"/>
						</div>
					</div>
					
					<div class="row">
						<div class="half">
							<label class="label push-right"><?=__('Root directory', 'wp-yadisk-files')?>*</label>
						</div>
						<div class="inputs half">
							<input class="width-50" type="text" name="wp-yadisk-files-root-directory" value="<?=(get_option('wp-yadisk-files-root-directory') ? get_option('wp-yadisk-files-root-directory') : '/')?>" required="required"/>
						</div>
					</div>
							
					<div class="row">
						<div class="half">
							<label class="label push-right"><?=__('Default directory', 'wp-yadisk-files')?>*</label>
						</div>
						<div class="inputs half">
							<input class="width-50" type="text" name="wp-yadisk-files-default-directory" value="<?=(get_option('wp-yadisk-files-default-directory') ? get_option('wp-yadisk-files-default-directory') : '/')?>" required="required"/>
						</div>
					</div>
					
					<div class="row">
						<div class="half">
							<label class="label push-right"><?=__('Default download label', 'wp-yadisk-files')?>*</label>
						</div>
						<div class="inputs half">
							<?=__('Download {name} from Yandex.Disk','wp-yadisk-files')?>
							<input class="width-50" type="text" name="wp-yadisk-files-default-download-label" value="<?=(get_option('wp-yadisk-files-default-download-label') ? get_option('wp-yadisk-files-default-download-label') : __('Download {name} from Yandex.Disk','wp-yadisk-files'))?>" required="required"/>
						</div>
					</div>
					
					<div class="row">
						<div class="half">
							<label class="label push-right"><?=__('Transparent mode', 'wp-yadisk-files')?></label>
						</div>
						<div class="inputs half">
							<input class="width-50" type="checkbox" name="wp-yadisk-files-transparent-mode" value="1" <?=(get_option('wp-yadisk-files-transparent-mode') ? 'checked="checked"' : '')?>" />
						</div>
					</div>
					<div class="row">
						<div>
							<i><?=__("In Transparent mode user wouldn't be redirected to Yandex.Disk while downloading", 'wp-yadisk-files')?></i>
						</div>
						<div>
							<b><i><?=__("Warning: use careful, turning on this option could increase server load", 'wp-yadisk-files')?></i></b>
						</div>
						<div>
							<b><i><?=__("Warning: not recommended to use with large files", 'wp-yadisk-files')?></i></b>
						</div>
					</div>
					
					<div class="row">
						<div class="half"></div>
						<div class="half">
							<button class="btn" type="submit"><?=__('Save', 'wp-yadisk-files')?></button>
						</div>
					</div>
				</div>
				
			</form>
			
			<div class="wp-yadisk-files-bl row">
				<div class="row hdr">
					<div class="icon32" id="icon-link-manager"><br /></div>
					<h3>
						<?=__('Links', 'wp-yadisk-files')?>
					</h3>
				</div>
				<div class="row in">
					<div class="row container">
						<div class="quarter">
							<a target="_blank" class="icons wordpress" href="http://wordpress.org/extend/plugins/wp-yadisk-files/"><?=__("Yadisk Files Plugin on Wordpress",'wp-yadisk-files')?></a>
						</div>
						<div class="quarter">
							<a target="_blank" class="icons blog" href="http://eduard.kozachek.net/projects/wordpress-projects/wp-yadisk-files-plugin/"><?=__("Yadisk Files Plugin on Author's site",'wp-yadisk-files')?></a>
						</div>
						<div class="quarter">
							<a target="_blank" class="icons github" href="https://github.com/antongorodezkiy/wp-yadisk-files"><?=__("Yadisk Files Plugin on Github",'wp-yadisk-files')?></a>
						</div>
						<div class="quarter">
							<a target="_blank" class="icons support" href="https://github.com/antongorodezkiy/wp-yadisk-files/issues"><?=__("Yadisk Files Plugin Support",'wp-yadisk-files')?></a>
						</div>
					</div>
				</div>
			</div>
		
		</div>
		<div class="third">
			<div class="wp-yadisk-files-bl row">
				<div class="row hdr">
					<div class="icon32" id="icon-user-edit"><br /></div>
					<h3>
						<?=__('About YaDisk Files', 'wp-yadisk-files')?>
					</h3>
				</div>
				<div class="row in container">
					<p><?=__('This plugin is created for easy adding files from <a target="_blank" href="http://disk.yandex.com/">Yandex Disk</a> service to posts or pages of your wordpress site.', 'wp-yadisk-files')?></p>
					<p><?=__('This plugin has no relation to <a target="_blank" href="http://yandex.com">Yandex Company</a>', 'wp-yadisk-files')?></p>
					<p><?=__('This plugin is written by me, <a target="_blank" href="mailto:antongorodezkiy@gmail.com">AntonGorodezkiy</a>', 'wp-yadisk-files')?></p>
					<p><?=__('This plugin is totally free (and opensource!) now and forever. But if you like my plugin you can of course buy me a coffee :)', 'wp-yadisk-files')?></p>
				</div>
			</div>
			
			<div class="wp-yadisk-files-bl row">
				<div class="row hdr">
					<div class="icon32" id="icon-user-edit"><br /></div>
					<h3>
						<?=__('Buy me a coffee', 'wp-yadisk-files')?>
					</h3>
				</div>
				<div class="row in container">
					<div class="third">Yandex.Money</div>
					<div class="row container">
						<form class="twothird" accept-charset="UTF-8" action="https://advisor.wmtransfer.com/Spasibo.aspx" method="post" target="_blank" title="<?=__('Say "Thanks" to Author','wp-yadisk-files')?>">
							<input type="hidden" name="url" value="<?=$_SERVER['SERVER_NAME']?>"/>
							<button class="nobutton" type="submit"><img src="http://advisor.wmtransfer.com/img/Spasibo!.png" alt="<?=__('Thank you','wp-yadisk-files')?>"/></button>
						</form>
					</div>
					<div class="row container">
						<div class="third">WebMoney</div>
						<div class="twothird">
							<iframe allowtransparency="true" src="https://money.yandex.ru/embed/small.xml?uid=41001290763964&amp;button-text=06&amp;button-size=s&amp;button-color=white&amp;targets=%d0%9f%d0%be%d0%b6%d0%b5%d1%80%d1%82%d0%b2%d0%be%d0%b2%d0%b0%d0%bd%d0%b8%d0%b5+%d0%b7%d0%b0+wp-yadisk-files&amp;default-sum=40&amp;mail=on" frameborder="0" height="31" scrolling="no" width="auto"></iframe>
						</div>
					</div>
					<div class="row container">
						<div class="third">PayPal</div>
						<form class="twothird" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
							<input type="hidden" name="cmd" value="_s-xclick">
							<input type="hidden" name="hosted_button_id" value="B5BNM66C4GMB6">
							<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
							<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
						</form>
					</div>
				</div>
			</div>
			
			<div class="wp-yadisk-files-bl row">
				<div class="row hdr">
					<div class="icon32" id="icon-edit-comments"><br /></div>
					<h3>
						<?=__('Thanks to', 'wp-yadisk-files')?>
					</h3>
				</div>
				<div class="row in container">
					<ul>
						<li>
							<?=__('Thanks to','wp-yadisk-files')?> <a target="_blank" href="mailto:christian.juerges@xwave.ch">Christian Juerges</a> <?=__('for a php webdav client library.','wp-yadisk-files')?>
						</li>
						<li>
							<?=__('Thanks to','wp-yadisk-files')?> <a target="_blank" href="http://lazycrazy.deviantart.com">LazyCrazy</a> <?=__('for pretty icons for settings page.','wp-yadisk-files')?>
						</li>
					</ul>
				</div>
			</div>
			
		</div>
	</div>
	
	<div class="wp-yadisk-files-about hidden" title="<?=__('About Wordpress Yadisk Files Plugin','wp-yadisk-files')?>">
		<h1 class="center row"><?=__('Wordpress Yadisk Files Plugin','wp-yadisk-files')?></h1>
		<div class="row centered split half">
			<div class="third"><a href="http://eduard.kozachek.net/projects/wordpress-projects/wp-yadisk-files-plugin/" class="yadisk-btn"><?=__('Blog','wp-yadisk-files')?></a></div>
			<div class="third"><a href="http://github.com" class="yadisk-btn">Github</a></div>
			<div class="third"><a href="http://wordpress.org/" class="yadisk-btn">Wordpress</a></div>
		</div>
	</div>
	
</div>
