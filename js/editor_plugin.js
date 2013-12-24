(function() {
	tinymce.create('tinymce.plugins.YadiskFiles', {
		init : function(ed, url) {
			//add keyboard shortcut control
			//ed.addShortcut('ctrl+t+i', 'ctrl+t+i', 'YadiskFiles');
			// Register commands
			ed.addCommand('YadiskFiles', function() {
				
				YadiskFiles.filesDialog(ed);
				
			});

			// Register buttons
			ed.addButton('YadiskFiles', {
				title : YadiskFiles.lang['Choose file'],
				image : url + '/../img/icon.png',
				cmd : 'YadiskFiles'
			});
			
		},
		getInfo : function() {
			return {
				longname : 'YadiskFiles',
				author : 'AntonGorodezkiy',
                authorurl : 'http://eduard.kozachek.net/',
                infourl : 'http://eduard.kozachek.net/',
                version : "1.2.0"
			};
		}
	});
	// Register plugin
	tinymce.PluginManager.add('YadiskFiles', tinymce.plugins.YadiskFiles);
})();
