<?php if (!defined('WPINC')) die(); ?>

<div class="wrap yadisk-files row">
      
	<div class="row container">  
		<div class="twothird">			
			<?=$notify->getMessages()?>

			<form class="yadisk-files-content yadisk-files-bl validateThisForm" method="post" action="options.php">
				
				<?php settings_fields('YadiskFilesSettings'); ?>
				
				<div class="row hdr">
					<div class="icon32" id="icon-ms-admin"><br /></div>
					<h2>
						<?=__('YaDisk Files Settings', 'yadisk-files')?>
					</h2>
				</div>
				
				<div class="row in">
					<div class="row">
						<label class="label fifth"><?=__('Yadisk Login', 'yadisk-files')?>*</label>
						<div class="inputs half">
							<input class="width-50" type="text" name="yadisk-files-login" value="<?=get_option('yadisk-files-login')?>" required="required"/>
						</div>
					</div>
							
					<div class="row">
						<label class="label fifth"><?=__('Yadisk Password', 'yadisk-files')?>*</label>
						<div class="inputs half">
							<input class="width-50" type="password" name="yadisk-files-pass" value="<?=get_option('yadisk-files-pass')?>" required="required"/>
						</div>
					</div>
							
					
					<div class="row">
						<div class="fifth"></div>
						<div class="fifth">
							<button class="btn" type="submit"><?=__('Save', 'yadisk-files')?></button>
						</div>
					</div>
				</div>
				
			</form>
			
			<div class="yadisk-files-bl row">
				<div class="row hdr">
					<div class="icon32" id="icon-link-manager"><br /></div>
					<h3>
						<?=__('Links', 'yadisk-files')?>
					</h3>
				</div>
				<div class="row in">
					<div class="row container">
						<div class="quarter">
							<a target="_blank" class="icons wordpress" href="http://wordpress.org/extend/plugins/wp-yadisk-files/"><?=__("Yadisk Files Plugin on Wordpress",'yadisk-files')?></a>
						</div>
						<div class="quarter">
							<a target="_blank" class="icons blog" href="http://eduard.kozachek.net/projects/wordpress-projects/yadisk-files-plugin/"><?=__("Yadisk Files Plugin on Author's site",'yadisk-files')?></a>
						</div>
						<div class="quarter">
							<a target="_blank" class="icons github" href="https://github.com/antongorodezkiy/wp-yadisk-files"><?=__("Yadisk Files Plugin on Github",'yadisk-files')?></a>
						</div>
						<div class="quarter">
							<a target="_blank" class="icons support" href="https://github.com/antongorodezkiy/wp-yadisk-files/issues"><?=__("Yadisk Files Plugin Support",'yadisk-files')?></a>
						</div>
					</div>
				</div>
			</div>
		
		</div>
		<div class="third">
			<div class="yadisk-files-bl row">
				<div class="row hdr">
					<div class="icon32" id="icon-user-edit"><br /></div>
					<h3>
						<?=__('About YaDisk Files', 'yadisk-files')?>
					</h3>
				</div>
				<div class="row in container">
					<p><?=__('This plugin is created for easy adding files from <a href="http://disk.yandex.com/">Yandex Disk</a> service to posts or pages of your wordpress site.', 'yadisk-files')?></p>
					<p><?=__('This plugin has no relation to <a href="http://yandex.com">Yandex Company</a>', 'yadisk-files')?></p>
					<p><?=__('This plugin is written by me, <a target="_blank" href="mailto:antongorodezkiy@gmail.com">AntonGorodezkiy</a>', 'yadisk-files')?></p>
					<p><?=__('This plugin is totally free (and opensource!) now and forever. But if you like my plugin you can of course buy me a coffee :)', 'yadisk-files')?></p>
				</div>
			</div>
			
			<div class="yadisk-files-bl row">
				<div class="row hdr">
					<div class="icon32" id="icon-user-edit"><br /></div>
					<h3>
						<?=__('Buy me a coffee', 'yadisk-files')?>
					</h3>
				</div>
				<div class="row in container">
					<div class="row container">
						<form class="half" accept-charset="UTF-8" action="https://advisor.wmtransfer.com/Spasibo.aspx" method="post" target="_blank" title="<?=__('Say "Thanks" to Author','yadisk-files')?>">
							<input type="hidden" name="url" value="<?=$_SERVER['SERVER_NAME']?>"/>
							<button class="nobutton" type="submit"><img src="http://advisor.wmtransfer.com/img/Spasibo!.png" alt="<?=__('Thank you','yadisk-files')?>"/></button>
						</form>
						<div class="half">
							<iframe allowtransparency="true" src="https://money.yandex.ru/embed/small.xml?uid=41001290763964&amp;button-text=06&amp;button-size=s&amp;button-color=white&amp;targets=%d0%9f%d0%be%d0%b6%d0%b5%d1%80%d1%82%d0%b2%d0%be%d0%b2%d0%b0%d0%bd%d0%b8%d0%b5+%d0%b7%d0%b0+wp-yadisk-files&amp;default-sum=40&amp;mail=on" frameborder="0" height="31" scrolling="no" width="auto"></iframe>
						</div>
					</div>
				</div>
			</div>
			
			<div class="yadisk-files-bl row">
				<div class="row hdr">
					<div class="icon32" id="icon-edit-comments"><br /></div>
					<h3>
						<?=__('Thanks to', 'yadisk-files')?>
					</h3>
				</div>
				<div class="row in container">
					<ul>
						<li>
							Thanks to <a href="mailto:christian.juerges@xwave.ch">Christian Juerges</a> for a php webdav client library.
						</li>
						<li>
							Thanks to <a href="http://lazycrazy.deviantart.com">LazyCrazy</a> for pretty icons for settings page.
						</li>
					</ul>
				</div>
			</div>
			
		</div>
	</div>
	
	<div class="yadisk-files-about hidden" title="<?=__('About Wordpress Yadisk Files Plugin','yadisk-files')?>">
		<h1 class="center row"><?=__('Wordpress Yadisk Files Plugin','yadisk-files')?></h1>
		<div class="row centered split half">
			<div class="third"><a href="http://eduard.kozachek.net/projects/wordpress-projects/yadisk-files-plugin/" class="yadisk-btn">Blog</a></div>
			<div class="third"><a href="http://github.com" class="yadisk-btn">Github</a></div>
			<div class="third"><a href="http://wordpress.org/" class="yadisk-btn">Wordpress</a></div>
		</div>
	</div>
	
</div>
