<?php
/**
 * Blog template for audios
 *
 * @author      David Voglgsang
 * @version     1.0.1
 *
*/
$audio = '';
$content = do_shortcode(apply_filters('the_content', get_the_content()));
$embeds = get_media_embedded_in_content($content);
if (!empty($embeds)):
  //check what is the first embed containg video tag, youtube or vimeo
  foreach ($embeds as $embed) {
    // return
    if (strpos($embed, 'audio')):
      $audio .= '<figure class="wp-block-audio">';
          $audio .= $embed;
      $audio .= '</figure>';
      break;
    endif;
  }
endif;

$css = 'temp-' . get_post_type() . '-image';
$css .= $audio ? ' flex' : '';
?>

<article class="<?php echo $css; ?>">
  <?php echo $audio ? '<div>' : ''; ?>

    <?php get_template_part('template_parts/header'); ?>
    <div class="entry-content">
      <?php the_excerpt(); ?>
    </div>
    <?php get_template_part('template_parts/footer'); ?>

  <?php echo $audio ? '</div>' : ''; ?>

  <?php echo $audio; ?>
</article>
