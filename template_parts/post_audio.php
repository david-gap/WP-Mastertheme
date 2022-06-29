<?php
/**
 * Blog template for audios
 *
 * @author      David Voglgsang
 * @version     1.0.1
 *
*/
if($args['id'] && $args['id'] !== 0):
  global $post;
  $post = get_post($args['id']);
endif;

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
// disable content loading
if($args['mediaOnly'] && $args['mediaOnly'] == 1):
  $returnExcerpt = false;
else:
  $returnExcerpt = true;
endif;
?>

<article class="<?php echo $css; ?>">
  <?php
    if($returnExcerpt):
      if($audio):
        echo '<div>';
      else:
        echo '';
      endif;
  ?>

      <?php get_template_part('template_parts/header'); ?>
      <div class="entry-content">
        <?php the_excerpt(); ?>
      </div>
      <?php get_template_part('template_parts/footer'); ?>

    <?php
        if($audio):
          echo '</div>';
        else:
          echo '';
        endif;
      endif;
    ?>

  <?php echo $audio; ?>
</article>
