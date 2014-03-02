(function($){
	$('.scc-toggle-post-list').on('click', function(e){
		var postList = $(this).siblings('.scc-post-container');
		if (postList.css('display') == 'none') {
			postList.slideDown();
		} else if (postList.css('display') == 'block') {
			postList.slideUp();
		}
		return false;
	});
})(jQuery);