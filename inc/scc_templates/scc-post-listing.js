(function($){
	$('.scc-toggle-post-list').on('click', function(e){
		var postList = $(this).siblings('.scc-post-container');
		if (postList.css('display') == 'none') {
			postList.slideDown();
			$( ".scc-toggle-post-list" ).addClass( "scc-opened" );
		} else if (postList.css('display') == 'block') {
			postList.slideUp();
			$( ".scc-toggle-post-list" ).removeClass( "scc-opened" );
		}
		return false;
	});
})(jQuery);