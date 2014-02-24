jQuery('.scc-show-post-list').click(function() {
	jQuery(this).closest('.scc-post-list').find('.scc-post-container').slideDown();
	jQuery(this).fadeOut();
	return false;
});