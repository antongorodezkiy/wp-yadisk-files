(function($) {
	$(document).ready(function() {
		
		if ($(".js-yadisk-download").size()) {
			$(".js-yadisk-download").click(function(e){
				
				var href = $(this).attr("href");
				var hash = $(this).attr("data-path_hash");
				
				if (hash && href && href.indexOf(hash) == -1) {
					$.post(YadiskFiles.url.ajaxurl, { 'action': 'yadisk_files_count_download', 'path_hash': hash }, function(data) {
						
					});
				}
			});
		}
		
	}); // ready
})(jQuery);
