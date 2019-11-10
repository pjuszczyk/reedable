/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function($) {
	// Site title and description.
	wp.customize('blogname', function(value) {
		value.bind(function(to) {
			$('.site-title a').text(to);
		});
	});
	wp.customize('blogdescription', function(value) {
		value.bind(function(to) {
			$('.site-description').text(to);
		});
	});
	wp.customize('reedable_color', function(value) {
		value.bind(function(to) {
			$('.entry-content a').css('color', to);
			hover_color = to;
		});
	});
})(jQuery);
