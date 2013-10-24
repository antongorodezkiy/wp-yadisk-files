<?=$notify->getMessages()?>
<div class="wp-yadisk-files popup">
	<div class="loading hidden"></div>
	<div class="loading_back hidden"></div>
	
	<div class="breadcrumbs file drive_network">
		<div class="file-icon">
		</div>
		<div class="in"></div>
		<div class="clear"></div>
	</div>
	
	<div class="container file-list">
		<table class="width-100 striped">
			<thead class="thead-gray">
				<tr>
					<th>
						<?=__('Filename', 'wp-yadisk-files')?>
						<span class="button fileinput-button">
							<span><?=__('Upload', 'wp-yadisk-files')?></span>
							<input class="yadisk_fileupload" type="file" name="yadisk_file" />
						</span>
					</th>
					<th><?=__('Size', 'wp-yadisk-files')?></th>
				</tr>
			</thead>
			<tbody class="content">
			</tbody>	
		</table>	
	</div>

</div>
