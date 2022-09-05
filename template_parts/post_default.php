<?php
/**
 * Blog template for defaults
 *
 * @author      David Voglgsang
 * @version     1.1.1
 *
*/
if($args['id'] && $args['id'] !== 0):
  global $post;
  $post = get_post($args['id']);
endif;


if(function_exists('has_post_video') && has_post_video()):
  $thumb = get_the_post_video();
else:
  $thumb = get_the_post_thumbnail();
endif;

$css = 'temp-' . get_post_type() . '-default';
// disable content loading
if($args['mediaOnly'] && $args['mediaOnly'] == 1):
  $returnExcerpt = false;
else:
  $css .= $thumb ? ' flex' : '';
  $returnExcerpt = true;
endif;
?>

<article class="<?php echo $css; ?>">
  <?php
    if($returnExcerpt):
      if($thumb):
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
        if($thumb):
          echo '</div>';
        else:
          echo '';
        endif;
      endif;
    ?>

  <?php echo $thumb; ?>
</article>
