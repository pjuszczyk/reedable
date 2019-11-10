(function($) {
	function reedablePostType() {
		$('#reedable_big_video_box').hide();
		$('#reedable_big_audio_box').hide();
		if ($('#post-format-video:checked').length > 0) {
			$('#reedable_big_video_box').show();
		}
		else if ($('#post-format-audio:checked').length > 0) {
			$('#reedable_big_audio_box').show();
		}
	}

	$(function() {
		reedablePostType();
		$('input[name="post_format"]').on('change', reedablePostType);
	});
})(jQuery);
