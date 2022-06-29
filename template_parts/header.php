<?php
/**
 * Blog template header for all
 *
 * @author      David Voglgsang
 * @version     1.0
 *
*/
if($args['id'] && $args['id'] !== 0):
  global $post;
  $post = get_post($args['id']);
endif;
?>

<header>
  <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
  <?php get_template_part('template_parts/meta'); ?>
</header>
