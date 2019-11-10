<?php
/**
 * The template for displaying search forms in reedable
 *
 * @package reedable
 * @since reedable 1.0
 */
?>
	<form method="get" id="searchform" class="searchform" action="<?php echo esc_url(home_url('/')); ?>" role="search">
		<label for="s" class="assistive-text icon"><?php _ex('Search', 'assistive text', 'reedable'); ?>&#xf002;</label>
		<input type="search" class="field" name="s" value="<?php echo esc_attr(get_search_query()); ?>" id="s" placeholder="<?php echo esc_attr_x('Search &hellip;', 'placeholder', 'reedable'); ?>" />
		<input type="submit" class="submit" id="searchsubmit" value="<?php echo esc_attr_x('Search', 'submit button', 'reedable'); ?>" />
	</form>
