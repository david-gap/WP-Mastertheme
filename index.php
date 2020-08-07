<?php
/**
 * Home File
 *
 * @author      David Voglgsang
 * @version     1.1
 *
*/

get_header();
?>
<section id="home" <?php echo prefix_template::AddContainer(prefix_template::$template_container, true); ?>>
  <h1><?php the_archive_title(); ?></h1>
  <?php if (have_posts() ) : while (have_posts()) : the_post() ?>
    <article>
        <h2><?php the_title(); ?></h2>
      <?php the_excerpt(); ?>
    </article>
    <?php get_sidebar(); ?>
  <?php endwhile; endif; ?>
</section>
<?php get_footer(); ?>
