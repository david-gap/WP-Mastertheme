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

$pageOptions = prefix_template::PageOptions(get_the_id());
?>

<header>
  <h2>
    <?php if(!in_array('disableDetailpage', $pageOptions)): ?><a href="<?php the_permalink(); ?>"><?php endif; ?>
      <?php the_title(); ?>
    <?php if(!in_array('disableDetailpage', $pageOptions)): ?></a><?php endif; ?>
  </h2>
  <?php get_template_part('template_parts/meta'); ?>
</header>
