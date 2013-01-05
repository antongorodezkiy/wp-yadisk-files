<?php if (!defined('WPINC')) die(); ?>

<div class="wrap yadisk">
        
	<div id="icon-campaigns" class="icon32"></div>
	<h2>
		<?=__('Settings', 'yadisk-files')?>
	</h2>
	<?=$notify->getMessages()?>
	<div class="campaigns">
		<form class="ticker-content ticker-bl validateThisForm" method="post" action="options.php">
			
			<?php settings_fields('YadiskFilesSettings'); ?>

			<div class="p">
				<label class="label"><?=__('Yadisk Login', 'yadisk-files')?>*</label>
				<div class="inputs">
					<input class="regular-text code" type="text" name="yadisk-files-login" value="<?=get_option('yadisk-files-login')?>" required="required"/>
				</div>
				<div class="clear"></div>
			</div>

			<div class="p">
				<label class="label"><?=__('Yadisk Password', 'yadisk-files')?>*</label>
				<div class="inputs">
					<input class="regular-text code" type="password" name="yadisk-files-pass" value="<?=get_option('yadisk-files-pass')?>" required="required"/>
				</div>
				<div class="clear"></div>
			</div>

			
			<div class="p buttons">
				<button class="button-primary" type="submit"><?=__('Save', 'yadisk-files')?></button>
			</div>
			
		</form>
		
		<div class="clear"></div>
	</div>
	
</div>
