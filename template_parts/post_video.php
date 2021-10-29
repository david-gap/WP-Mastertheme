<?php
/**
 * Blog template for video
 *
 * @author      David Voglgsang
 * @version     1.0.1
 *
*/
$video = '';
$content = do_shortcode(apply_filters('the_content', get_the_content()));
$embeds = get_media_embedded_in_content($content);
if (!empty($embeds)):
  //check what is the first embed containg video tag, youtube or vimeo
  foreach ($embeds as $embed) {
    $wrapper = true;
    // css
    if(strpos($embed, 'youtube')):
      $video_css = 'wp-block-embed-youtube wp-block-embed is-type-video is-provider-youtube';
    elseif(strpos($embed, 'vimeo')):
      $video_css = 'wp-block-embed-vimeo wp-block-embed is-type-video is-provider-vimeo';
    elseif(strpos($embed, 'dailymotion')):
      $video_css = 'wp-block-embed-dailymotion wp-block-embed is-type-video is-provider-dailymotion';
    elseif(strpos($embed, 'vine')):
      $video_css = 'wp-block-embed-vine wp-block-embed is-type-video is-provider-vine';
    elseif(strpos($embed, 'wordPress.tv')):
      $video_css = 'wp-block-embed-wordPress-Tv wp-block-embed is-type-video is-provider-wordPress-Tv';
    elseif(strpos($embed, 'hulu')):
      $video_css = 'wp-block-embed-hulu wp-block-embed is-type-video is-provider-hulu';
    elseif(strpos($embed, 'video')):
        $wrapper = false;
        $video_css = 'wp-block-video';
    endif;
    // return
    if (strpos($embed, 'video') || strpos($embed, 'youtube') || strpos($embed, 'vimeo') || strpos($embed, 'dailymotion') || strpos($embed, 'vine') || strpos($embed, 'wordPress.tv') || strpos($embed, 'hulu')):
      $video .= '<figure class="' . $video_css . '">';
        $video .= $wrapper !== false ? '' : '<div class"wp-block-embed__wrapper">';
          $video .= $embed;
        $video .= $wrapper !== false ? '' : '</div>';
      $video .= '</figure>';
      break;
    endif;
  }
endif;

$css = 'temp-' . get_post_type() . '-video';
$css .= $video ? ' flex' : '';
?>

<article class="<?php echo $css; ?>">
  <?php echo $video ? '<div>' : ''; ?>

    <?php get_template_part('template_parts/header'); ?>
    <div class="entry-content">
      <?php the_excerpt(); ?>
    </div>
    <?php get_template_part('template_parts/footer'); ?>

  <?php echo $video ? '</div>' : ''; ?>

  <?php echo $video; ?>
</article>
