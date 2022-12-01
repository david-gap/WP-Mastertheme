<?php
/**
 * Blog template for defaults
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



$thumb = get_the_post_thumbnail(get_the_id(), 'full', array('callingFrom' => $callingFrom));

$css = 'temp-' . get_post_type() . '-default';
// disable content loading
if($args && array_key_exists('mediaOnly', $args) && $args['mediaOnly'] == 1):
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
