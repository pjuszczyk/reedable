/**
 * navigation.js
 *
 * Handles toggling the navigation menu for small screens.
 */
var menu;
var menu_height;

function mobileMenu() {
	menu_height = 0;
	menu.children().each(function(){
		menu_height += jQuery(this).outerHeight();
	});
	jQuery('#mobile_menu_animation').remove();
	jQuery('head').append('<style type="text/css" id="mobile_menu_animation">' + "\n"
		+ "@media only screen and (max-width : 640px) {\n"
		+ "#site-navigation-wrapper2 > div > ul.menu-visible {max-height:" + menu_height + "px}\n"
		+ "}\n"
		+ "</style>");
}

jQuery(function() {
	menu = jQuery('#site-navigation-wrapper2 > div > ul');

	mobileMenu();
	
	jQuery(window).resize(function() {
		mobileMenu();
	});

	jQuery('#site-navigation-wrapper2 > div > ul > li > .sub-menu').each(function() {
		var submenu = jQuery(this);
		var menu_item = submenu.parent();
		submenu.css('left', Math.round((menu_item.width() - submenu.width()) / 2));
		menu_item.addClass('submenu-off');
	});

	jQuery('.menu-toggle').on('click', function() {
		var item = jQuery(this).parent().find('.menu');
		if (item.hasClass('menu-visible')) item.removeClass('menu-visible');
		else item.addClass('menu-visible');
	});
});
