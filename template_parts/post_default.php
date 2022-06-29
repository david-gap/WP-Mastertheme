<?php
/**
 * Blog template for defaults
 *
 * @author      David Voglgsang
 * @version     1.0.1
 *
*/
if($args['id'] && $args['id'] !== 0):
  global $post;
  $post = get_post($args['id']);
endif;

$thumb = get_the_post_thumbnail();

$css = 'temp-' . get_post_type() . '-default';
$css .= $thumb ? ' flex' : '';
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
