$(function() {



	$('.rating').raty({
		path: '/assets/raty/lib/img',
		noRatedMsg : "Not rated yet",
		click: function(score, evt) {
			var media_id = $(this).find('[type="hidden"]').val();

			$.ajax({
				url: '/',
				method: 'post',
				data: {ajax: true, media_id: media_id, rating: score}
			});
		},
		score: function() {
			return $(this).attr('data-score');
		},
		hints: ['bad', 'poor', 'regular', 'good', 'great']
	});
});