function notify(json, globalTtl, globalRegion)
			{
				var now = new Date();
				now = now.getTime();
				for (key in json)
				{
					
					if ( key != "data" && key != "comeback" )
					{
						if (typeof globalRegion != "undefined" && globalRegion != null)
							var region = globalRegion;
						else if (json[key].region == null || json[key].region == "default")
							var region = "default";
						else
							var region = json[key].region;
						
						if (typeof globalTtl != "undefined" && globalTtl != null)
							var ttl = globalTtl*1000;
						else
							var ttl = json[key].ttl*1000;
							
							
						$(".notify."+region).prepend("<div data-ttl=\""+ttl+"\" class=\"notice "+json[key].type+"\"><p>"+json[key].message+"</p></div>");
					}
					
					if ( key == "comeback" && json["comeback"] != null && json["comeback"] != "" )
						window.location = json["comeback"];
				}
					
				$(".notice",".notify").click(function(){ $(this).fadeOut(300); });

			}
			
			function notifyIsSuccess(json)
			{
				if (json != undefined && json[0] != undefined && !json[0].isError)
					return true;
				else
					return false;
			}
			
			function notifyError(message, ttl, region)
			{
				var json = [{
					"isError" : 1,
					"type" : "error",
					"message" : message,
					"region"	: region,
					"ttl"		: ttl
				}];
				notify(json);
			}
			
			function notifySuccess(message, ttl, region)
			{
				var json = [{
					"isError" 	: 0,
					"type" 		: "updated",
					"message" 	: message,
					"region"	: region,
					"ttl"		: ttl
				}];
				notify(json);
			}
			
			var notifyRegion;
			function notifySetRegion(region)
			{
				notifyRegion = region;
			}
			
			function close_old_notifies()
			{
			
				var now = new Date();
				now = now.getTime();
				if ($(".notify > div:visible").size())
				{
					$(".notify > div:visible").each(function()
					{
						if (!$(this).attr("data-time"))
						{
							$(this).attr("data-time",now);
						}
							
						var notice_time = $(this).attr("data-time");
						var notice_ttl = $(this).attr("data-ttl");
		
						if (notice_ttl != 0 && (now-notice_time) > notice_ttl )
							$(this).fadeOut(800);

					});
				}
			}

(function($) {

			
			$(document).ready(function()
			{
				$(".notice",".notify").live("click",function(){ $(this).fadeOut(300); });
				
				//setInterval("close_old_notifies()",500);
				
				/*$(".notice",".notify").hover(function()
				{
					$(this).css("opacity","1");
				},
				function()
				{
					$(this).css("opacity","0.5");
				});*/
			});
})(jQuery);
