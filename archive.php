<?php
/**
 * Post Type File Overview
 *
 * @author      David Voglgsang
 * @version     1.0
 *
*/

get_header();

$obj = get_queried_object();
// page options
$options = prefix_template::PageOptions($obj->ID);
// body class
$pt = $obj ? 'pt-' . $obj->post_type : '';
?>
<section id="archive" <?php echo prefix_template::AddContainer(prefix_template::$template_container, true); ?>>
  <?php if (have_posts() ) : while (have_posts()) : the_post() ?>
    <article>
      <?php if(!in_array('title', $options)): ?>
        <h2><?php the_title(); ?></h2>
      <?php endif; ?>
      <?php the_content(); ?>
    </article>
    <?php get_sidebar(); ?>
  <?php endwhile; endif; ?>
</section>
<?php get_footer(); ?>
