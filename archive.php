<?php
/**
 * Post Type File Overview
 *
 * @author      David Voglgsang
 * @version     1.1
 *
*/

get_header();
?>
<section id="archive" <?php echo prefix_template::AddContainer(prefix_template::$template_container, true); ?>>
  <?php if (have_posts() ) : while (have_posts()) : the_post() ?>
    <article>
      <h2><?php the_title(); ?></h2>
      <?php the_excerpt(); ?>
    </article>
    <?php get_sidebar(); ?>
  <?php endwhile; endif; ?>
</section>
<?php get_footer(); ?>
