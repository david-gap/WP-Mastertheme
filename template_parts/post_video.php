<?php
/**
 * Blog template for video
 *
 * @author      David Voglgsang
 * @version     1.0.1
 *
*/
if($args['id'] && $args['id'] !== 0):
  global $post;
  $post = get_post($args['id']);
endif;

$video = '';
// check for blocks
if(has_blocks()):
  $supportedBlocks = array("core/embed", "templates/vimeo", "core/vimeo");
  $blocks = parse_blocks( $post->post_content );
  foreach ($blocks as $blockKey => $block) {
    if(in_array($block['blockName'], $supportedBlocks)):
        $video .= '<div class="gb-block">' . render_block($block) . '</div>';
        if("core/embed" === $block['blockName']):
          $not_embedded = $block['attrs']['url'];
          $video = str_replace( $not_embedded, wp_oembed_get($not_embedded), $video );
        endif;
      break;
    endif;
  }
else:
  $content = get_the_content();
  $embeds = get_media_embedded_in_content($content);
  if (!empty($embeds)):
    //check what is the first embed containg video tag, youtube or vimeo
    if(prefix_DSGVOsupport::$dsgvo_active == 1):
      $video .= '<div class="gb-block">' . prefix_DSGVOsupport::fiterEmbeds($embeds[0]) . '</div>';
    else:
      $wrapper = true;
      $blockWidth = 16;
      if (preg_match("/width=\"(\\d+)/", $embeds[0], $matches)):
        $blockWidth = $matches[1] * 1;
      endif;
      $blockHeight = 9;
      if (preg_match("/height=\"(\\d+)/", $embeds[0], $matches)):
        $blockHeight = $matches[1] * 1;
      endif;
      $paddingTop = 100 / $blockWidth * $blockHeight;
      $blockAdds .= ' style="padding-top: ' . $paddingTop . '%"';
      $blockClasses .= ' video-embed';
      $video .= '<div class="gb-block"><div class="resp_video"' . $blockAdds . '>' . $embeds[0] . '</div></div>';
    endif;
  endif;
endif;

$css = 'temp-' . get_post_type() . '-video';
// disable content loading
if($args['mediaOnly'] && $args['mediaOnly'] == 1):
  $returnExcerpt = false;
else:
  $css .= $video ? ' flex' : '';
  $returnExcerpt = true;
endif;
?>

<article class="<?php echo $css; ?>">
  <?php
    if($returnExcerpt):
      if($video):
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
        if($video):
          echo '</div>';
        else:
          echo '';
        endif;
      endif;
    ?>

  <?php echo $video; ?>
</article>
