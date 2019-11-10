<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package reedable
 * @since reedable 1.0
 */
?>

  </div><!-- #main -->
</div><!-- #page -->

<footer id="colophon" class="site-footer" role="contentinfo">
  <div id="footer-wrapper">
    <div class="site-info">
      <div id="site-info-wrapper">
        <div id="site-info-wrapper2">
          <?php do_action('reedable_credits'); ?>
          <p>Peter Juszczyk - peter@webartisans.io</p>
        </div>
      </div>
    </div><!-- .site-info -->

<?php
$options = get_option('reedable_social');
$social = array();

if (!empty($options)):

  foreach ($options as $key => $value) {
    if ($options[$key] != '') {
      $social[$key] = $value;
    }
  }

  if (!empty($social)):
    $array = array(
      'twitter' => '&#xf099;',
      'facebook' => '&#xf09a;',
      'instagram' => '&#xf16d;',
      'pinterest' => '&#xf0d2;',
      'dribbble' => '&#xf17d;',
      'google' => '&#xf1a0;',
      'vimeo' => '&#xf27d;',
      'flickr' => '&#xf16e;',
      'rss' => '&#xf09e;',
      'github' => '&#xf09b;',
    );
?>

    <div id="social">
      <div id="social_wrapper">
        <div id="social_wrapper2">
          <?php foreach ($social as $key => $value): ?>
          <a href="<?php echo $value; ?>"><?php echo $array[$key]; ?></a>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

<?php
  endif;
endif;
?>
  </div>
</footer><!-- #colophon -->

<?php wp_footer(); ?>

</body>
</html>
