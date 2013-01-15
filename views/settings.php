<?php if (!defined('WPINC')) die(); ?>

<div class="wrap yadisk-files row">
      
	<div class="row container">  
		<div class="fivesixth">
			<div id="icon-campaigns" class="icon32"></div>
			<div class="row">
				<h2>
					<?=__('YaDisk Files Settings', 'yadisk-files')?>
				</h2>
			</div>	
			<?=$notify->getMessages()?>
			<div class="campaigns">
				<form class="yadisk-files-content yadisk-files-bl validateThisForm" method="post" action="options.php">
					
					<?php settings_fields('YadiskFilesSettings'); ?>
		
					<div class="row">
						<label class="label quarter"><?=__('Yadisk Login', 'yadisk-files')?>*</label>
						<div class="inputs threequarter">
							<input class="width-50" type="text" name="yadisk-files-login" value="<?=get_option('yadisk-files-login')?>" required="required"/>
						</div>
						<div class="clear"></div>
					</div>
		
					<div class="row">
						<label class="label quarter"><?=__('Yadisk Password', 'yadisk-files')?>*</label>
						<div class="inputs threequarter">
							<input class="width-50" type="password" name="yadisk-files-pass" value="<?=get_option('yadisk-files-pass')?>" required="required"/>
						</div>
						<div class="clear"></div>
					</div>
		
					
					<div class="row">
						<div class="quarter"></div>
						<button class="threequarter yadisk-btn" type="submit"><?=__('Save', 'yadisk-files')?></button>
					</div>
					
				</form>
				
				<div class="clear"></div>
			</div>
		</div>
		<div class="sixth">Sixth</div>
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
