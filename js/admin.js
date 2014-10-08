var YadiskFiles = YadiskFiles || {};
YadiskFiles.rootDir = YadiskFiles.url['root-directory'] ? YadiskFiles.url['root-directory'] : '/';
YadiskFiles.currentDir = YadiskFiles.url['default-directory'] ? YadiskFiles.url['default-directory'] : YadiskFiles.rootDir;
YadiskFiles.editor = null;

// get current dir
	YadiskFiles.getCurrentDir = function() {
		return YadiskFiles.currentDir;
	};

// set current dir
	YadiskFiles.setCurrentDir = function($, path) {
		YadiskFiles.currentDir = path;
		$('.yadisk_fileupload', ".wp-yadisk-files").fileupload(
			'option',
			'formData',
			{
				'action': 'yadisk_files_upload',
				'path': YadiskFiles.getCurrentDir()
			}
		);
	};

// cd
	YadiskFiles.cd = function($, path, loaded) {
	
		Loading.show();
		
	
		var pathParts = [];
		var newPathParts = [];
		if (typeof(path) == 'undefined') {
			path = YadiskFiles.rootDir;
		}
		else {
			pathParts = path.split("/");
		}
		
		$.post(YadiskFiles.url['ajaxurl'], { 'action': 'yadisk_files_get_list', 'path': path }, function(data) {
			
			Loading.hide();
			
			var json = $.parseJSON(data);
			var html = '';
			
			if (notifyIsSuccess(json)) {
				
				YadiskFiles.setCurrentDir($, path);
				
				if (path != YadiskFiles.rootDir) {
					html += '<tr><td><a href="#" class="jq-dir in dir file arrow_up" data-href="'+YadiskFiles.rootDir+'"><span class="file-icon"></span>/</a></td><td>&nbsp;</td></tr>';
					
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
				
				if (typeof(loaded) != 'undefined') {
					loaded();
				}
			}
			else {
				Loading.hide();
				notify(json);
			}
			
			return false;
		});
	};

(function($) {
	
	$(document).ready(function()
	{
		
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
		
		// переход в директорию
		$(".jq-dir",".wp-yadisk-files").live("click",function(event)
		{
			var targetDir = $(this).attr('data-href');
			
			YadiskFiles.cd($, targetDir);
			
			return false;
		});
		
		// добавление файла в пост
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
					YadiskFiles.editor.execCommand(
						'mceInsertContent',
						false,
						'[YadiskFiles label="'+(YadiskFiles.lang['Default download label'].replace('{name}',name))+'" href="'+json.data.href+'" name="'+name+'" size="'+size+'" path_hash="'+json.data.path_hash+'" counter="true"]'
					);
					$(".wp-yadisk-files-filesDialog","body").dialog("close");
				}
				else {
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
					YadiskFiles.cd($, YadiskFiles.currentDir);
					$(".wp-yadisk-files-filesDialog","body").dialog("open");
				}
				else {
					
					$("body").append('<div class="wp-yadisk-files-filesDialog"></div>');
					$(".wp-yadisk-files-filesDialog","body")
						.html(dialogHtml)
						.dialog({
							modal: false,
							title: YadiskFiles.lang['Choose file'],
							width: 800,
							height: 470,
							resizable: false,
							closeOnEscape: true
						});
					
					YadiskFiles.cd($, YadiskFiles.currentDir);

					$('.yadisk_fileupload',".wp-yadisk-files").fileupload({
						url: YadiskFiles.url['ajaxurl'],
						formData: {
							'action': 'yadisk_files_upload',
							'path': YadiskFiles.getCurrentDir()
						},
						dataType: 'json',
						submit: function (e, data) {
							Loading.show();
						},
						done: function (e, data) {
							var json = data.result;
							Loading.hide();
							if (notifyIsSuccess(json)) {
								YadiskFiles.cd($, YadiskFiles.currentDir);
							}
							else {
								notify(json);
							}
						}
					});
				}
			});
			
			
		};
		
		
		$(".ui-widget-overlay").live("click", function() {
			$(".wp-yadisk-files-filesDialog","body").dialog("close");
		});
		
	}); // ready
})(jQuery);
