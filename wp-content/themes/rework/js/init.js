(function ($) {
	/*jslint undef: false, browser: true, devel: false, eqeqeq: false, bitwise: false, white: false, plusplus: false, regexp: false, nomen: false */ 
	/*global jQuery,setTimeout,clearTimeout,projekktor,location,setInterval,YT,clearInterval,pixelentity,prettyPrint */
	
	
	$(function () {
		// activate widgets
		$.pixelentity.widgets.build($("body"),{});
		
		var ps = $(".resize-height p");
		var jwin = $(window);
		
		var maxH = 0;
		
		function getParHeight(idx,el) {
			maxH = Math.max(maxH,ps.eq(idx).height());
		}

		
		function setParHeight(idx,el) {
			ps.eq(idx).height(maxH === 0 ? "auto" : maxH);
		}
		
		function parHeight() {
			if (maxH > 0) {
				maxH = 0;
				ps.each(setParHeight);
			}
			if (jwin.width() > 768) {
				ps.each(getParHeight);
				ps.each(setParHeight);
			}

		}
		
		if (ps.length > 0) {
			jwin.resize(parHeight).triggerHandler("resize");
		}
		
		$("blockquote").append('<span class="corner"></span>');
		
	});

	
}(jQuery));
