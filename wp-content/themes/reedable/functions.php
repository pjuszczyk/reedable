<?php
/**
 * reedable functions and definitions
 *
 * @package reedable
 * @since reedable 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since reedable 1.0
 */
if (!isset($content_width))
	$content_width = 920; /* pixels */

/*
 * Load Jetpack compatibility file.
 */
require(get_template_directory().'/inc/jetpack.php');

if (!function_exists('reedable_setup')):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since reedable 1.0
 */
function reedable_setup() {
	/**
	 * Custom template tags for this theme.
	 */
	require_once(get_template_directory().'/inc/template-tags.php');

	/**
	 * Custom functions that act independently of the theme templates
	 */
	require_once(get_template_directory().'/inc/extras.php');

	/**
	 * Customizer additions
	 */
	require_once(get_template_directory().'/inc/customizer.php');

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on reedable, use a find and replace
	 * to change 'reedable' to the name of your theme in all the template files
	 */
	load_theme_textdomain('reedable', get_template_directory().'/languages');

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support('automatic-feed-links');

	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support('post-thumbnails');

	add_image_size('reedable-gallery', 436, 436, true);
	add_image_size('reedable-full', 920);

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus(array(
		'primary' => __('Primary Menu', 'reedable'),
	));

	/**
	 * Enable support for Post Formats
	 */
	add_theme_support('post-formats', array(
		'aside', 'audio', 'chat', 'gallery', 'image', 'quote', 'status', 'link', 'video'
	));
}
endif; // reedable_setup

add_action('after_setup_theme', 'reedable_setup');

/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since reedable 1.0
 */
function reedable_widgets_init() {
	register_sidebar(array(
		'name' => __('Sidebar', 'reedable'),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	));
}

add_action('widgets_init', 'reedable_widgets_init');

/**
 * Enqueue scripts and styles
 */
function reedable_scripts() {
	wp_enqueue_style('fancybox-style', get_template_directory_uri().'/fancybox/jquery.fancybox.css?v=2.1.5');
	wp_enqueue_style('reedable-style', get_stylesheet_uri());
	$css = '.gallery .gallery-item {
	max-width: '.get_option('thumbnail_size_w').'px;
}';
	wp_add_inline_style('reedable-style', $css);

	wp_enqueue_script('navigation', get_template_directory_uri().'/js/navigation.js', array(), '20120206', true);

	wp_enqueue_script('skip-link-focus-fix', get_template_directory_uri().'/js/skip-link-focus-fix.js', array(), '20130115', true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}

	if (is_singular() && wp_attachment_is_image()) {
		wp_enqueue_script('keyboard-image-navigation', get_template_directory_uri().'/js/keyboard-image-navigation.js', array('jquery'), '20120202');
	}

	wp_enqueue_script('wp-mediaelement');

	wp_enqueue_style('wp-mediaelement');

	wp_enqueue_script('jquery');

	wp_enqueue_script('jquery-ui', get_template_directory_uri().'/js/jquery-ui-1.10.2.custom.min.js', array(), '20130317');

	wp_enqueue_script('reedable-responsive-videos', get_template_directory_uri().'/js/reedable-responsive-videos.js', array('jquery'), '20140331', true);

	wp_enqueue_script('jquery-mousewheel', get_template_directory_uri().'/js/jquery.mousewheel.js', array('jquery'), '3.1.6', true);
	wp_enqueue_script('fancybox', get_template_directory_uri().'/fancybox/jquery.fancybox.js', array('jquery'), '3b1', true);

	wp_enqueue_script('reedable-script', get_template_directory_uri().'/js/reedable.js', array(), '20140331');

	if (!is_singular() && 'infinite-scroll' == get_theme_mod('page_navigation'))
		wp_enqueue_script('infinite-scroll', get_template_directory_uri().'/js/jquery.infinitescroll.min.js', array('jquery'), '2.0b.110415', true);
}

add_action('wp_enqueue_scripts', 'reedable_scripts');

/**
 * Admin styles
 */
function reedable_admin_scripts_styles() {
	wp_enqueue_style('reedable-admin-style', get_template_directory_uri().'/admin.css');

	wp_enqueue_script('reedable-admin', get_template_directory_uri().'/js/admin.js', array(), '20140331', true);
}

add_action('admin_enqueue_scripts', 'reedable_admin_scripts_styles');

// This theme uses its own gallery styles.
add_filter('use_default_gallery_style', '__return_false');

// [big] shortcode
function reedableShortcodeBig($atts, $content = null) {
	return '<div class="reedable_big">'.do_shortcode($content).'</div>';
}

add_shortcode('big', 'reedableShortcodeBig');

// updated form for password protected posts
function reedablePasswordForm($content) {
	$before = array('>Password: <input name="post_password" id="');
	$after = array('><input name="post_password" placeholder="Password" class="password_protected" id=');
	$content = str_replace($before, $after, $content);
	return $content;
}

add_filter('the_password_form', 'reedablePasswordForm');

// infinite scroll
function reedable_infinite_scroll_js() {
	if (is_singular() || 'infinite-scroll' != get_theme_mod('page_navigation')) return;
?>
	<script type="text/javascript">
		jQuery(function() {
			var infinite_scroll = {
				loading: {
					img: "<?php echo get_stylesheet_directory_uri(); ?>/icons/loadmore.svg",
					msgText: "",
					finishedMsg: "<?php _e('The End', 'reedable'); ?>"
				},
				'nextSelector': '#nav-below .previous a',
				'navSelector': '#nav-below',
				'itemSelector': 'article',
				'contentSelector': '#content'
			};
			jQuery(infinite_scroll.contentSelector).infinitescroll(infinite_scroll, function(arrayOfNewElems) {
				fixLinks();
				var items = jQuery(arrayOfNewElems);
				items.find('.entry-video').reedableResponsiveVideos();
				items.find('audio,video').mediaelementplayer();
			});
		});
	</script>
<?php
}

add_action('wp_footer', 'reedable_infinite_scroll_js', 100);

class reedable {
	public static $color = '#1e83cb';
	private static $gallery = null;

	public static function catchGallery($output) {
		$preg = preg_match_all('/\[gallery(.*?)ids="(.*?)"\]/', $output, $match);
		if ($preg) {
			$disable_fancybox = get_theme_mod('reedable_fancybox');
			foreach ($match[0] as $key => $gallery) {
				if (trim($match[2][$key]) == '') {
					continue;
				}
				$attachments = explode(',', $match[2][$key]);
				if (get_post_format(get_the_ID()) == 'gallery' && self::$gallery == null) {
					self::$gallery = $disable_fancybox ? $gallery : $attachments;
					$output = str_replace($gallery, '', $output);
				} elseif (!$disable_fancybox) {
					$output = str_replace($gallery, reedable_formatted_gallery($attachments), $output);
				}
			}
		}
		return $output;
	}

	private static function getGallery() {
		$results = self::$gallery;
		self::$gallery = null;
		return $results;
	}

	/**
	 * Function to get the content earlier than it needs to be printed; shortcodes are catched this way
	 */
	public static function filteredContent($content = null) {
		if ($content === null) {
			$content = get_the_content(__('Read More', 'reedable'));
			$content = apply_filters('the_content', $content);
		} else {
			global $wp_embed;
			$content = do_shortcode($content);
			$content = $wp_embed->autoembed($content);
		}
		$content = str_replace('<p></p>', '', $content); // TODO: fix it (youtube embed adds empty paragraphs?)
		return str_replace(']]>', ']]&gt;', $content);
	}

	public static function getContentAndAttachments() {
		$content = self::filteredContent();
		return array('content' => $content, 'attachments' => self::getGallery());
	}
}

add_filter('the_content', array('reedable', 'catchGallery'), 1, 1);

/* Audio & video boxes for posts */
function reedable_big_video_box($post) {
	$value = get_post_meta($post->ID, 'reedable_big_video', true);
	?>
	<p>
		<textarea id="reedable_big_video" name="reedable_big_video" rows="4" cols="40" placeholder="<?php _e('Enter your video link, embed code or shortcode here:', 'reedable'); ?>"><?php echo $value ?></textarea>
	</p>
	<?php
}

function reedable_big_audio_box($post) {
	$value = get_post_meta($post->ID, 'reedable_big_audio', true);
	?>
	<p>
		<textarea id="reedable_big_audio" name="reedable_big_audio" rows="4" cols="40" placeholder="<?php _e('Enter your audio link, embed code or shortcode here:', 'reedable'); ?>"><?php echo $value ?></textarea>
	</p>
	<?php
}

function reedable_boxes() {
	add_meta_box(
		'reedable_big_video_box',
		__('Video', 'reedable'),
		'reedable_big_video_box',
		'post',
		'normal',
		'high'
	);
	add_meta_box(
		'reedable_big_audio_box',
		__('Audio', 'reedable'),
		'reedable_big_audio_box',
		'post',
		'normal',
		'high'
	);
}

add_action('add_meta_boxes', 'reedable_boxes');

/* Save action for posts */
function reedable_save_postdata($post_id) {
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return $post_id;

	if (!isset($_POST['post_type'])) {
		return $post_id;
	}

	// First we need to check if the current user is authorised to do this action.
	if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id))
			return;
	}
	else {
		if (!current_user_can('edit_post', $post_id))
			return;
	}

	if ($_POST['post_type'] == 'post') {
		$media = array('audio' => false, 'video' => false);
		$format = get_post_format(get_the_ID());
		if ($format == 'audio' || $format == 'video') $media[$format] = true;
		foreach ($media as $key => $save) {
			if ($save) {
				$value = isset($_POST['reedable_big_'.$key]) ? $_POST['reedable_big_'.$key] : '';
				if (!update_post_meta($post_id, 'reedable_big_'.$key, $value)) {
					add_post_meta($post_id, 'reedable_big_'.$key, $value, true);
				}
			}
			else {
				update_post_meta($post_id, 'reedable_big_'.$key, '');
			}
		}
	}
}

add_action('save_post', 'reedable_save_postdata');

function reedable_formatted_audio() {
	if (post_password_required()) return;

	$meta = get_post_meta(get_the_ID(), 'reedable_big_audio', true);
	$meta = reedable::filteredContent($meta);
	$local = strpos($meta, 'wp-audio-shortcode') !== false ? true : false;
	?>

	<div class="entry-media entry-audio<?php if (!$local) echo ' entry-audio-embed'; ?>">
		<?php echo $meta; ?>
	</div><!-- .entry-media -->

	<?php
}

function reedable_formatted_video() {
	if (post_password_required()) return;

	$meta = get_post_meta(get_the_ID(), 'reedable_big_video', true);
	?>

	<div class="entry-media entry-video">
		<div class="video-content">
			<?php echo reedable::filteredContent($meta); ?>
		</div>
	</div><!-- .entry-media -->

	<?php
}

function reedable_formatted_image() {
	if (post_password_required()) return;

	$thumbnail_id = get_post_thumbnail_id(get_the_ID());
	if ($thumbnail_id == '') return;

	$src = wp_get_attachment_image_src($thumbnail_id, 'reedable-full');
	if (!isset($src[0])) return;
	?>

	<div class="entry-media entry-image">
		<a href="<?php the_permalink(); ?>"><img src="<?php echo $src[0]; ?>" alt="<?php the_title_attribute(); ?>" /></a>
	</div><!-- .entry-media -->

	<?php
}

function reedable_formatted_gallery($attachments, $class = '') {
	if (is_string($attachments)) {
		return '<div class="reedable_big">'.reedable::filteredContent($attachments).'</div>';
	}
	$html = '<div class="template-gallery'.($class != '' ? ' '.$class : '').'">
	<div class="gallery-wrapper">';
	foreach ($attachments as $attachment):
		$image = get_post($attachment);
		$src = wp_get_attachment_image_src($attachment, 'full');
		$thumbnail_link = wp_get_attachment_image_src($attachment, 'reedable-gallery');
		$html .= '<a class="fancybox" rel="group" href="'.esc_url($src[0]).'" title="'.esc_attr($image->post_excerpt).'"><img src="'.esc_url($thumbnail_link[0]).'" alt="" /></a>';
	endforeach;
	$html .= '	</div>
</div>';
	return $html;
}
