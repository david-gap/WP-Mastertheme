<?php
/**
 * Pages File
 *
 * @author      David Voglgsang
 * @version     1.1.3
 *
*/

get_header();

$obj = get_queried_object();
// page options
$options = $obj && property_exists($obj, 'ID') ? prefix_template::PageOptions($obj->ID) : array();
?>
<section id="page" <?php echo prefix_template::AddContainer(prefix_template::$template_container, true); ?>>
  <?php if (have_posts() ) : while (have_posts()) : the_post() ?>
    <article>
      <?php echo prefix_SwissTopo::topoMaps(); ?>
      <?php echo prefix_template::postMeta($obj->post_type, $options); ?>
      <?php if(!in_array('title', $options)): ?>
        <h1 class="post-title"><?php the_title(); ?></h1>
      <?php endif; ?>
      <?php the_content(); ?>
      <?php comments_template();?>
    </article>
  <?php endwhile; endif; ?>
  <?php get_sidebar(); ?>
</section>
<?php get_footer(); ?>
