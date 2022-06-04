<?php
/**
 * Blog template for images
 *
 * @author      David Voglgsang
 * @version     1.0.1
 *
*/
$thumb = get_the_post_thumbnail();
$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', get_the_content(), $matches);
$thumb = isset($matches[1][0]) ? '<img src="' . $matches[1][0] . '">' : $thumb;

$css = 'temp-' . get_post_type() . '-image';
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
