var YadiskFiles = YadiskFiles || {};

var currentDir = '/';

(function($) {
	
	$(document).ready(function()
	{
		
		Loading = {
			show: function() {
				$(".loading").show();
				$(".loading_back").show();
			},
			hide: function() {
				$(".loading").hide();
				$(".loading_back").hide();
			}
		};
		
		function cd(path) {
			
			Loading.show();
			console.log('cd '+path);
		
			var pathParts = [];
			var newPathParts = [];
			if (typeof(path) == 'undefined') {
				path = '/';
			}
			else
				pathParts = path.split("/");
			
			$.post(ajaxurl, { 'action': 'yadisk_files_get_list', 'path': path }, function(data) {
				
				Loading.hide();
				
				var json = $.parseJSON(data);
				var html = '';
				
				if (notifyIsSuccess(json)) {
				
					if (path != '/') {
						html += '<tr><td><a href="#" class="dir" data-href="/">/</a></td><td>&nbsp;</td></tr>';
						
						for(i in pathParts)
							if (pathParts[i] != '')
								newPathParts.push(pathParts[i]);
							
						delete newPathParts[newPathParts.length-1];
						
						var newPath = newPathParts.join('/');
						html += '<tr><td><a href="#" class="dir" data-href="/'+newPath+'">..</a></td><td>&nbsp;</td></tr>';
					}
					
					// breadcrumbs
						$(".breadcrumbs").html(decodeURIComponent(path));
					
					var folders = json.data.folders;
					$.each(folders,function(index, value){
						html += '<tr><td><a href="#" class="dir" data-href="'+value.href+'">'+value.name+'</a></td><td>&nbsp;</td></tr>';
					});
					
					
					var files = json.data.files;
					$.each(files,function(index, value){
						html += '<tr><td><a href="#" class="file" data-href="'+value.href+'" data-size="'+value.size+'">'+value.name+'</a></td><td>'+value.size+'</td></tr>';
					});
					
					$(".content").html(html);
				}
				
				return false;
			});
		}
	
		cd(currentDir);
		$(".dir").live("click",function(event)
		{
			var targetDir = $(this).attr('data-href');
			
			cd(targetDir);
			
			return false;
		});
		
		
		$(".file").live("click",function(event)
		{
			Loading.show();
			
			var name = $(this).text();
			var size = $(this).attr('data-size');
			var path = $(this).attr('data-href');
			
			$.post(ajaxurl, { 'action': 'yadisk_files_publish', 'path': path }, function(data) {
				
				Loading.hide();
				
				var json = $.parseJSON(data);
				console.log(json);
				if (notifyIsSuccess(json)) {
					
					tinyMCEPopup.execCommand('mceInsertContent', false, '[YadiskFiles href="'+json.data.href+'" name="'+name+'" size="'+size+'"]');
					tinyMCEPopup.close();
				}
				
				return false;
			});
			
			return false;
		});
		
	
		// функция проверки confirm
		$(".confirm").click(function(event)
		{
			var title = $(this).attr("title");
			if (!confirm(title))
			{
				return false;
			}

			return true;
		});
		// функция проверки confirm
		
		
	// tabs
		$(".tabs").tabs();
		
		
	}); // ready
})(jQuery);