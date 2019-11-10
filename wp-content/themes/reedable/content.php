  <?php
/**
 * @package reedable
 * @since reedable 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <header class="entry-header">
    <div class="entry-meta">
  
      <?php reedable_posted_on(); ?>
      <?php if (!post_password_required() && (comments_open() && '0' != get_comments_number())): ?>
  
        <span class="sep">|</span>
        <span class="comments-link">
        <?php comments_popup_link(
          __('<span class="icon">&#xf075; </span>Leave a comment', 'reedable'), 
          __('<span class="icon">&#xf075; </span>1 Comment', 'reedable'), 
          __('<span class="icon">&#xf086; </span>% Comments', 'reedable')); ?>
        </span>      
  
      <?php endif; ?>
      <?php edit_post_link(__('<span class="icon">&#xf040; </span>Edit', 'reedable'), '<span class="sep">|</span><span class="edit-link">', '</span>'); ?>
  
    </div><!-- .entry-meta -->

    <?php $post_format = get_post_format(); ?>
    <?php if (!in_array($post_format, array('link','quote'), true)): ?>
  
    <h1 class="entry-title">  
      <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr(sprintf(__('Permalink to %s', 'reedable'), the_title_attribute('echo=0'))); ?>" rel="bookmark"><?php the_title(); ?></a>
    </h1>
    <?php endif; ?>
  </header><!-- .entry-header -->

  <?php
  if ('audio' == $post_format) reedable_formatted_audio();
  elseif ('video' == $post_format) reedable_formatted_video();
  elseif ('image' == $post_format) reedable_formatted_image();
  elseif ('gallery' == $post_format) {
    $result = reedable::getContentAndAttachments();
    echo reedable_formatted_gallery($result['attachments'], 'reedable_big');
  }
  ?>

  <div class="entry-content">
    <?php
    if ('gallery' == $post_format) echo $result['content'];
    else the_content(__('Read More<span></span>', 'reedable'));
    ?>
  </div><!-- .entry-content -->

</article><!-- #post-## -->
