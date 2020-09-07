<?php
/**
 * Post Type File Overview
 *
 * @author      David Voglgsang
 * @version     1.2
 *
*/

get_header();
?>
<section id="archive" <?php echo prefix_template::AddContainer(prefix_template::$template_container, true); ?>>
  <div>
    <?php if (have_posts() ) : while (have_posts()) : the_post();
      $blog_type = get_post_meta(get_the_ID(), 'template_blog_type', true) ? get_post_meta(get_the_ID(), 'template_blog_type', true) : "default";
      get_template_part('template_parts/' . get_post_type() . '_' . $blog_type);
    endwhile; endif; ?>
  </div>
  <?php get_sidebar(); ?>
</section>
<?php get_footer(); ?>
