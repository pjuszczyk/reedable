<?php
/**
 * reedable Theme Customizer
 *
 * @package reedable
 * @since reedable 1.2
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 *
 * @since reedable 1.2
 */
function reedable_customize_register($wp_customize) {
	// Colors
	$wp_customize->add_section('reedable_colors', array(
		'title' => __('Colors', 'reedable'),
		'priority' => 35,
		'capability' => 'edit_theme_options',
		'description' => __('Allows you to customize some colors.', 'reedable')
	));
	$wp_customize->add_setting('reedable_color', array(
		'default' => reedable::$color,
		'type' => 'option',
		'capability' => 'edit_theme_options',
		'transport' => 'postMessage'
	));
	$wp_customize->add_control(new WP_Customize_Color_Control(
		$wp_customize,
		'reedable_color',
		array(
			'label' => __('Color', 'reedable'),
			'section' => 'reedable_colors',
			'settings' => 'reedable_color',
			'priority' => 10,
		)
	));

	// Social networks
	$wp_customize->add_section('reedable_social', array(
		'title' => __('Social networks', 'reedable'),
		'priority' => 95,
		'capability' => 'edit_theme_options',
		'description' => __('Allows you to customize social network links.', 'reedable')
	));
	$array = array(
		'twitter' => 'Twitter',
		'facebook' => 'Facebook',
		'instagram' => 'Instagram',
		'pinterest' => 'Pinterest',
		'dribbble' => 'Dribbble',
		'google' => 'Google+',
		'vimeo' => 'Vimeo',
		'flickr' => 'Flickr',
		'rss' => 'RSS',
		'github' => 'GitHub',
	);
	$i = 0;
	foreach ($array as $key => $value) {
		$i++;
		$wp_customize->add_setting('reedable_social['.$key.']', array(
			'default' => '',
			'type' => 'option',
			'capability' => 'edit_theme_options',
			'transport' => 'postMessage'
		));
		$wp_customize->add_control('reedable_social['.$key.']', array(
			'label' => __($value, 'reedable'),
			'section' => 'reedable_social',
			'type' => 'text',
			'priority' => $i
		));
	}

	// Page navigation
	$wp_customize->add_section('page_navigation', array(
		'title' => __('Page Navigation', 'reedable'),
		'priority' => 100,
	));
	$wp_customize->add_setting('page_navigation', array(
		'default' => 'standard',
		'sanitize_callback' => 'sanitize_key',
	));
	$wp_customize->add_control('page_navigation', array(
		'section' => 'page_navigation',
		'type' => 'select',
		'choices' => array(
			'standard' => __('Standard', 'reedable'),
			'ajax-fetch' => __('Load More Button', 'reedable'),
			'infinite-scroll' => __('Infinite Scroll', 'reedable'),
		),
	));

	// Galleries
	$wp_customize->add_section('reedable_section_galleries', array(
		'title' => __('Galleries', 'reedable'),
		'priority' => 105
	));
	$wp_customize->add_setting('reedable_fancybox', array(
		'default' => false
	));
	$wp_customize->add_control('reedable_fancybox', array(
		'label' => __('Disable custom fancybox galleries', 'reedable'),
		'section' => 'reedable_section_galleries',
		'type' => 'checkbox',
		'priority' => 20
	));

	$wp_customize->get_setting('blogname')->transport = 'postMessage';
	$wp_customize->get_setting('blogdescription')->transport = 'postMessage';
	$wp_customize->get_setting('reedable_color')->transport = 'postMessage';
}

add_action('customize_register', 'reedable_customize_register');

function reedable_header_output() {
	$color = get_option('reedable_color', reedable::$color);

	echo '<style type="text/css" id="custom-background-css">
a {
	color: '.$color.';
}
.entry-content a {
	-webkit-transition: border-bottom-color 0.2s linear;
	-moz-transition: border-bottom-color 0.2s linear;
	-o-transition: border-bottom-color 0.2s linear;
	transition: border-bottom-color 0.2s linear;
}
.entry-content a:hover {
	border-bottom-color: '.$color.';
}
#masthead .site-title a, #site-navigation a, .sub-menu a, #nav-below a, .entry-title a, #image-navigation a {
	-webkit-transition: color 0.2s linear;
	-moz-transition: color 0.2s linear;
	-o-transition: color 0.2s linear;
	transition: color 0.2s linear;
}
#masthead .site-title a:hover, #nav-below a:hover, .entry-title a:hover, #image-navigation a:hover {
	color: '.$color.';
}
#s, #commentform input[type="text"], #commentform textarea, .password_protected, #social a, a.more-link {
	-webkit-transition: background-color 0.2s linear;
	-moz-transition: background-color 0.2s linear;
	-o-transition: background-color 0.2s linear;
	transition: background-color 0.2s linear;
}
a.more-link span {
	-webkit-transition: border-left-color 0.2s linear;
	-moz-transition: border-left-color 0.2s linear;
	-o-transition: border-left-color 0.2s linear;
	transition: border-left-color 0.2s linear;
}
#s:focus, #commentform input[type="text"]:focus, #commentform textarea:focus, .password_protected:focus {
	background-color: #fff;
}
#social a:hover {
	background-color: '.$color.';
}
a.more-link:hover {
	background-color: '.$color.';
}
a.more-link:hover span {
	border-left-color: '.$color.';
}
.entry-meta a, footer .site-info a, #comments a, .link_post_p a {
	-webkit-transition: color 0.2s linear, border-bottom-color 0.2s linear;
	-moz-transition: color 0.2s linear, border-bottom-color 0.2s linear;
	-o-transition: color 0.2s linear, border-bottom-color 0.2s linear;
	transition: color 0.2s linear, border-bottom-color 0.2s linear;
}
.entry-meta a:hover, footer .site-info a:hover, #comments a:hover, #comments a#cancel-comment-reply-link:hover, .link_post_p a:hover {
	color: '.$color.';
	border-bottom-color: '.$color.';
}
@media only screen and (min-width : 641px) {
	#site-navigation a:hover, .sub-menu a:hover {
		color: '.$color.';
	}
}
html {
	position: relative;'.(is_admin_bar_showing() ? '
	min-height: -moz-calc(100% - 32px);
	min-height: -webkit-calc(100% - 32px);
	min-height: calc(100% - 32px);' : '
	min-height: 100%;').'
}
.hentry .mejs-controls .mejs-time-rail .mejs-time-current {
	background: '.$color.';
}
</style>
<script type="text/javascript">
var hover_color = "'.$color.'";
</script>';
}

add_action('wp_head', 'reedable_header_output');

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @since reedable 1.2
 */
function reedable_customize_preview_js() {
	wp_enqueue_script('reedable_customizer', get_template_directory_uri().'/js/customizer.js', array('customize-preview'), '20140331', true);
}

add_action('customize_preview_init', 'reedable_customize_preview_js');
