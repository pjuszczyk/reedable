var read_more_color = '#dcdcdb';
var hover_speed = 200;
var body;
var footer;

function getHeight(el) {
	return el.height() + parseInt(el.css('padding-top'))
		+ parseInt(el.css('padding-bottom'))
		+ parseInt(el.css('border-top-width'))
		+ parseInt(el.css('border-bottom-width'));
}

function fixLinks() {
	jQuery('.format-link .entry-content p').each(function() {
		var item = jQuery(this);
		if (item.find('a').length !== 0) item.addClass('link_post_p');
	});
	jQuery('.entry-content a').each(function() {
		var item = jQuery(this);
		var img = item.find('img');
		if (img.length === 1) {
			item.addClass('image_link');
		}
	});
}

function getRatio(item, type) {
	var video = item.find(type);
	if (video.length === 1) {
		var width = video.attr('width');
		var height = video.attr('height');
		if (typeof width !== 'undefined' && width !== false && typeof height !== 'undefined' && height !== false) {
			var ratio = parseInt(height) / parseInt(width) * 100;
			return ratio.toFixed(2);
		}
	}
	return 0;
}

jQuery(function() {
	body = jQuery('body');
	footer = jQuery('#colophon');

	body.css('margin-bottom', getHeight(footer));
	footer.css('visibility', 'visible');
	jQuery(window).resize(function() {
		body.css('margin-bottom', getHeight(footer));
	});

	// fancybox for galleries
	jQuery('.fancybox').fancybox({
		padding: 50,
		openEffect: 'none',
		closeEffect: 'none',
		nextEffect: 'none',
		prevEffect: 'none',
		tpl: {
			next: '<a title="Next" class="fancybox-nav fancybox-next" href="javascript:;">Next</a>',
			prev: '<a title="Previous" class="fancybox-nav fancybox-prev" href="javascript:;">Previous</a>'
		},
		afterShow: function() {
			jQuery('#fancybox-lock > .fancybox-close, #fancybox-lock > .fancybox-nav').remove();
			jQuery('.fancybox-close, .fancybox-nav').appendTo('#fancybox-lock');
		}
	});
	jQuery('body').on('click', '.fancybox-image', function() {
		jQuery.fancybox.next();
	});

	// comment html fix for submit
	jQuery('.form-submit #submit').after('<span id="submit_after"></span>');
	jQuery('.form-submit #submit').hover(function() {
		jQuery(this).stop().animate({backgroundColor: hover_color}, hover_speed);
		jQuery(this).next().stop().animate({borderLeftColor: hover_color}, hover_speed);
	}).on('mouseout', function() {
		jQuery(this).stop().animate({backgroundColor: read_more_color}, hover_speed);
		jQuery(this).next().stop().animate({borderLeftColor: read_more_color}, hover_speed);
	});

	fixLinks();
	jQuery('.entry-video').reedableResponsiveVideos();
});
