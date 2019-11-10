<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package reedable
 * @since reedable 1.0
 */

if (!function_exists('reedable_content_nav')):
/**
 * Display navigation to next/previous pages when applicable
 *
 * @since reedable 1.0
 */
function reedable_content_nav($nav_id) {
  global $wp_query, $post;

  // Don't print empty markup on single pages if there's nowhere to navigate.
  if (is_single()) {
    $previous = (is_attachment()) ? get_post($post->post_parent) : get_adjacent_post(false, '', true);
    $next = get_adjacent_post(false, '', false);

    if (!$next && !$previous)
      return;
  }

  // Don't print empty markup in archives if there's only one page.
  if ($wp_query->max_num_pages < 2 && (is_home() || is_archive() || is_search()))
    return;

  $nav_class = (is_single()) ? 'navigation-post' : 'navigation-paging';
  ?>

  <nav role="navigation" id="<?php echo esc_attr($nav_id); ?>" class="<?php echo $nav_class; ?><?php if ('infinite-scroll' == get_theme_mod('page_navigation') && !is_single()) echo ' infinite-scroll' ?>">
    <div id="nav-below-separator">
      <h1 class="assistive-text"><?php _e('Post navigation', 'reedable'); ?></h1>

    <?php if (is_single()): // navigation links for single posts ?>

      <div class="previous"><?php previous_post_link('%link', '<span class="meta-nav">'._x('Previous Article', 'Previous post link', 'reedable').'</span><br />%title'); ?></div>
      <div class="next"><?php next_post_link('%link', '<span class="meta-nav">'._x('Next Article', 'Next post link', 'reedable').'</span><br />%title'); ?></div>

    <?php elseif ($wp_query->max_num_pages > 1 && (is_home() || is_archive() || is_search())): // navigation links for home, archive, and search pages ?>

      <?php if ('ajax-fetch' == get_theme_mod('page_navigation')): ?>
        <div class="load-more">
          <?php next_posts_link(__('<span class="img loader">&#xf021;</span><span class="img loader2">&#xf021;</span><span class="text">Load more posts</span>', 'reedable')); ?>
        </div>
        <script type="text/javascript">
          jQuery(function() {
            jQuery('.load-more').on('click', 'a', function(e) {
              e.preventDefault();
              var link = jQuery(this);
              link.addClass('loading').find('.text').text('Loading...');
              jQuery.ajax({
                type: 'GET',
                url: jQuery(this).attr('href') + '#content',
                dataType: 'html',
                success: function(out) {
                  result = jQuery(out).find('#content .hentry');
                  nextLink = jQuery(out).find('.load-more a').attr('href');
                  var nav = jQuery('#nav-below');
                  result.each(function() {
                    jQuery(this).insertBefore(nav);
                  });
                  if (undefined != nextLink) {
                    link.removeClass('loading').attr('href', nextLink).find('.text').text('Load more posts');
                  }
                  else {
                    jQuery('#nav-below').remove();
                  }
                  fixLinks();
                  result.find('.entry-video').reedableResponsiveVideos();
                  result.find('audio,video').mediaelementplayer();
                }
              });
            });
          });
        </script>
      <?php else: ?>
        <div class="previous previous_total">
        <?php if (get_next_posts_link()): ?>
          <?php next_posts_link(__('<span class="meta-nav"></span>Older posts', 'reedable')); ?>
        <?php endif; ?>
        </div>

        <div class="total"><?php global $paged; echo $paged; ?> <span>of</span> <?php echo $wp_query->max_num_pages; ?></div>

        <div class="next next_total">
        <?php if (get_previous_posts_link()): ?>
          <?php previous_posts_link(__('Newer posts<span class="meta-nav"></span>', 'reedable')); ?>
        <?php endif; ?>
        </div>
      <?php endif; ?>
    <?php endif; ?>
    </div>
  </nav><!-- #<?php echo esc_html($nav_id); ?> -->
  <?php
}
endif; // reedable_content_nav

if (!function_exists('reedable_comment')):
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since reedable 1.0
 */
function reedable_comment($comment, $args, $depth) {
  $GLOBALS['comment'] = $comment;
  switch ($comment->comment_type):
    case 'pingback':
    case 'trackback':
  ?>
  <li class="post pingback">
    <p><?php _e('Pingback:', 'reedable'); ?> <?php comment_author_link(); ?><?php edit_comment_link(__('Edit', 'reedable'), '<span class="edit-link">', '<span>'); ?></p>
  <?php
      break;
    default:
  ?>
  <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
    <article id="comment-<?php comment_ID(); ?>" class="comment">
      <footer>
        <div class="comment-author vcard">
          <?php printf(__('%s <span class="says">on</span>', 'reedable'), sprintf('<cite class="fn">%s</cite>', get_comment_author_link())); ?>
          <span class="comment-meta commentmetadata">
            <a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>"><time datetime="<?php comment_time('F jS, Y'); ?>">
                <?php printf(_x('%1$s %2$s', '1: date, 2: time', 'reedable'), get_comment_date(), get_comment_time()); ?>
              </time></a>
            <?php edit_comment_link(__('Edit', 'reedable'), '<span class="edit-link">', '<span>'); ?>
          </span><!-- .comment-meta .commentmetadata -->
        </div><!-- .comment-author .vcard -->
        <?php if ($comment->comment_approved == '0'): ?>
          <em><?php _e('Your comment is awaiting moderation.', 'reedable'); ?></em>
          <br />
        <?php endif; ?>
      </footer>

      <div class="comment-content"><?php comment_text(); ?></div>

      <div class="reply">
        <?php comment_reply_link(array_merge($args, array('reply_text' => '&#8618; Reply', 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
      </div><!-- .reply -->
    </article><!-- #comment-## -->

  <?php
      break;
  endswitch;
}
endif; // ends check for reedable_comment()

if (!function_exists('reedable_posted_on')):
/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @since reedable 1.0
 */
function reedable_posted_on() {
  printf(__('<a href="%1$s" title="%2$s" rel="bookmark"><span class="icon calendar">&#xf133; </span><time class="entry-date" datetime="%3$s">%4$s</time></a>', 'reedable'),
    esc_url(get_permalink()),
    esc_attr(get_the_time()),
    esc_attr(get_the_date('F jS, Y')),
    esc_html(get_the_date('F jS, Y'))
  );
}
endif;

/**
 * Returns true if a blog has more than 1 category
 *
 * @since reedable 1.0
 */
function reedable_categorized_blog() {
  if (false === ($all_the_cool_cats = get_transient('all_the_cool_cats'))) {
    // Create an array of all the categories that are attached to posts
    $all_the_cool_cats = get_categories(array(
      'hide_empty' => 1,
    ));

    // Count the number of categories that are attached to the posts
    $all_the_cool_cats = count($all_the_cool_cats);

    set_transient('all_the_cool_cats', $all_the_cool_cats);
  }

  if ('1' != $all_the_cool_cats) {
    // This blog has more than 1 category so reedable_categorized_blog should return true
    return true;
  }
  else {
    // This blog has only 1 category so reedable_categorized_blog should return false
    return false;
  }
}

/**
 * Flush out the transients used in reedable_categorized_blog
 *
 * @since reedable 1.0
 */
function reedable_category_transient_flusher() {
  // Like, beat it. Dig?
  delete_transient('all_the_cool_cats');
}

add_action('edit_category', 'reedable_category_transient_flusher');
add_action('save_post', 'reedable_category_transient_flusher');
