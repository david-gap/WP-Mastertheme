<?php
/**
 * Blog template for audios
 *
 * @author      David Voglgsang
 * @version     1.2.2
 *
*/
if($args && array_key_exists('callingFrom', $args) && $args['callingFrom'] !== ''):
  $callingFrom = $args['callingFrom'];
else:
  $callingFrom = '';
endif;
if($args && array_key_exists('id', $args) && $args['id'] !== 0):
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
// fallback if audio does not exist
if($audio == ''):
  $audio = get_the_post_thumbnail(get_the_id(), 'full', array('callingFrom' => $callingFrom));
endif;

$css = 'temp-' . get_post_type() . '-image';
// disable content loading
if($args && array_key_exists('mediaOnly', $args) && $args['mediaOnly'] == 1):
  $returnExcerpt = false;
else:
  $css .= $audio ? ' flex' : '';
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
