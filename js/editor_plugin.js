(function() {
	tinymce.create('tinymce.plugins.YadiskFiles', {
		init : function(ed, url) {
			//add keyboard shortcut control
			//ed.addShortcut('ctrl+t+i', 'ctrl+t+i', 'YadiskFiles');
			// Register commands
			ed.addCommand('YadiskFiles', function() {
				
				ed.windowManager.open({
					file : url + '/../popup.php',
					width : 800,
					height : 450,
					inline : 1
				}, {
					baseURL : url
				});

				
			});

			// Register buttons
			ed.addButton('YadiskFiles', {
				title : YadiskFiles.lang['Yadisk Files'],
				image : url + '/../img/icon.png',
				cmd : 'YadiskFiles'
			});
			
		},
		getInfo : function() {
			return {
				longname : 'YadiskFiles',
				author : 'AntonGorodezkiy',
                authorurl : 'http://kozachek.net/',
                infourl : 'http://kozachek.net/',
                version : "1.0"
			};
		}
	});
	// Register plugin
	tinymce.PluginManager.add('YadiskFiles', tinymce.plugins.YadiskFiles);
})();
