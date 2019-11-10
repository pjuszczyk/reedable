<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package reedable
 * @since reedable 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

			<article id="post-0" class="post error404 not-found">
				<header class="entry-header">
					</h1><h1 class="entry-title"><span class="entry-face icon">&#xf11a;</span>
						<?php _e('Oops! 404', 'reedable'); ?></h1>
				</header><!-- .entry-header -->

				<div class="entry-content">
					<p><?php _e('Sorry, something went wrong. You can <a href="'.esc_url(home_url('/')).'">go to the front page</a> or use the search box to find what you were looking for.', 'reedable'); ?></p>

					<?php get_search_form(); ?>
				</div><!-- .entry-content -->
			</article><!-- #post-0 .post .error404 .not-found -->

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>