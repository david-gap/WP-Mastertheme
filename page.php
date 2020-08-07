<?php
/**
 * Pages File
 *
 * @author      David Voglgsang
 * @version     1.1
 *
*/

get_header();

$obj = get_queried_object();
// page options
$options = $obj && array_key_exists('ID', $obj) ? prefix_template::PageOptions($obj->ID) : array();
?>
<section id="page" <?php echo prefix_template::AddContainer(prefix_template::$template_container, true); ?>>
  <?php if (have_posts() ) : while (have_posts()) : the_post() ?>
    <article>
      <?php if(!in_array('title', $options)): ?>
        <h1><?php the_title(); ?></h1>
      <?php endif; ?>
      <?php the_content(); ?>
    </article>
    <?php comments_template();?>
    <?php get_sidebar(); ?>
  <?php endwhile; endif; ?>
</section>
<?php get_footer(); ?>
