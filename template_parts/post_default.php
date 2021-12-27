<?php
/**
 * Blog template for defaults
 *
 * @author      David Voglgsang
 * @version     1.0.1
 *
*/
$thumb = get_the_post_thumbnail();

$css = 'temp-' . get_post_type() . '-default';
$css .= $thumb ? ' flex' : '';
?>

<article class="<?php echo $css; ?>">
  <?php
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
    ?>

  <?php echo $thumb; ?>
</article>
