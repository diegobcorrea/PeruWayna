jQuery.noConflict();

(function($) {

	$(document).ready(function() {

		var count = 1,
			noncename = $("#img_tag_noncename").val();

		$(".temp .wPsticky").clone().appendTo(".tag-container");
		$(".temp .wPsticky").remove();

		$(".temp .drawnBox").clone().appendTo("#map-container");
		$(".temp .drawnBox").remove();

		if( $('.show_box input[type=checkbox]').is(':checked') ) {
			$(".hide_box").css({"display":"inline-block"});
		};

		$('.show_box input[type=checkbox]').click(function() {
			if( $(this).is(':checked') ) {
		    	$(".hide_box").css({"display":"inline-block"});
		    }else{
		    	$(".hide_box").css({"display":"none"});
		    };
		});

	});

})(jQuery);

