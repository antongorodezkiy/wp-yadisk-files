var YadiskFiles = YadiskFiles || {};
YadiskFiles.currentDir = '/';
YadiskFiles.editor = null;

(function($) {
	
	$(document).ready(function()
	{
		
		function cd(path) {
	
			Loading.show();
			
		
			var pathParts = [];
			var newPathParts = [];
			if (typeof(path) == 'undefined') {
				path = '/';
			}
			else
				pathParts = path.split("/");
			
			$.post(YadiskFiles.url['ajaxurl'], { 'action': 'yadisk_files_get_list', 'path': path }, function(data) {
				
				Loading.hide();
				
				var json = $.parseJSON(data);
				var html = '';
				
				if (notifyIsSuccess(json)) {
					
					if (path != '/') {
						html += '<tr><td><a href="#" class="jq-dir in dir file arrow_up" data-href="/"><span class="file-icon"></span>/</a></td><td>&nbsp;</td></tr>';
						
						for(i in pathParts)
							if (pathParts[i] != '')
								newPathParts.push(pathParts[i]);
							
						delete newPathParts[newPathParts.length-1];
						
						var newPath = newPathParts.join('/');
						html += '<tr><td><a href="#" class="jq-dir in dir file arrow_turn_left" data-href="/'+newPath+'"><span class="file-icon"></span>..</a></td><td>&nbsp;</td></tr>';
					}
					
					// breadcrumbs
						$(".breadcrumbs .in",".wp-yadisk-files-filesDialog").html(decodeURIComponent(path));
					
					var folders = json.data.folders;
					$.each(folders,function(index, value){
						html += '<tr><td><a href="#" class="jq-dir in dir file folder" data-href="'+value.href+'"><span class="file-icon"></span>'+value.name+'</a></td><td>&nbsp;</td></tr>';
					});
					
					
					var files = json.data.files;
					$.each(files,function(index, value){
						html += '<tr><td><a href="#" class="jq-file in file '+value.ext+'" data-href="'+value.href+'" data-size="'+value.size+'"><span class="file-icon"></span>'+value.name+'</a></td><td><span class="in">'+value.size+'</span></td></tr>';
					});
					
					
					$(".content",".wp-yadisk-files-filesDialog").html(html);
				}
				else {
					Loading.show();
					notify(json);
				}
				
				return false;
			});
		}
		
		Loading = {
			show: function() {
				$(".loading",".wp-yadisk-files").show();
				$(".loading_back",".wp-yadisk-files").show();
			},
			hide: function() {
				$(".loading",".wp-yadisk-files").hide();
				$(".loading_back",".wp-yadisk-files").hide();
			}
		};
		
		
		$(".jq-dir",".wp-yadisk-files").live("click",function(event)
		{
			var targetDir = $(this).attr('data-href');
			
			cd(targetDir);
			
			return false;
		});
		
		
		$(".jq-file",".wp-yadisk-files").live("click",function(event)
		{
			Loading.show();
			
			var name = $(this).text();
			var size = $(this).attr('data-size');
			var path = $(this).attr('data-href');
			
			$.post(YadiskFiles.url['ajaxurl'], { 'action': 'yadisk_files_publish', 'path': path }, function(data) {
				
				Loading.hide();
				
				var json = $.parseJSON(data);
				
				if (notifyIsSuccess(json)) {
					YadiskFiles.editor.execCommand('mceInsertContent', false, '[YadiskFiles href="'+json.data.href+'" name="'+name+'" size="'+size+'"]');
					$(".wp-yadisk-files-filesDialog","body").dialog("close");
				}
				else {
					Loading.show();
					notify(json);
				}
				
				return false;
			});
			
			return false;
		});
		
	
		// функция проверки confirm
		$(".confirm",".wp-yadisk-files").click(function(event)
		{
			var title = $(this).attr("title");
			if (!confirm(title))
			{
				return false;
			}

			return true;
		});
		// функция проверки confirm
		
		YadiskFiles.filesDialog = function(ed){
			YadiskFiles.editor = ed;

			$.get(YadiskFiles.url['ajaxurl'], { 'action': 'yadisk_files_get_popup_template' }, function(response){
				
				var dialogHtml = response;
				if ($(".wp-yadisk-files-filesDialog").size()) {
					$(".wp-yadisk-files-filesDialog","body").dialog("open");
				}
				else {
					cd(YadiskFiles.currentDir);
					$("body").append('<div class="wp-yadisk-files-filesDialog"></div>');
					$(".wp-yadisk-files-filesDialog","body")
						.html(dialogHtml)
						.dialog({
							modal: true,
							title: YadiskFiles.lang['Choose file'],
							width: 800,
							height: 470,
							resizable: false,
							closeOnEscape: true
						});
				}
			});
			
			
		};
		
		
		$(".ui-widget-overlay").live("click", function() {
			$(".wp-yadisk-files-filesDialog","body").dialog("close");
		});
		
		
	}); // ready
})(jQuery);
