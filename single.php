<?php
/**
 * Post Type File Single
 *
 * @author      David Voglgsang
 * @version     1.3.4
 *
*/

get_header();

$obj = get_queried_object();
// page options
$options = $obj && property_exists($obj, 'ID') ? prefix_template::PageOptions($obj->ID) : array();
?>
<section id="detail-page" <?php echo prefix_template::AddContainer(prefix_template::$template_container, 0, true); ?>>
  <?php if(!in_array('thumbnail', $options)):
     if(array_key_exists('thumbnail', prefix_template::$template_header_sort) && prefix_template::$template_header_sort['thumbnail'] == 1):
     else:
       echo prefix_template::get_thumbnail();
     endif;
  endif; ?>
  <?php if (have_posts() ) : while (have_posts()) : the_post() ?>
    <article>
      <?php echo prefix_template::postMeta($obj->post_type, $options); ?>
      <?php if(!in_array('title', $options)): ?>
        <h1 class="post-title<?php if(in_array('titleWide', $options)): ?> alignwide<?php endif; ?>"><?php the_title(); ?></h1>
      <?php endif; ?>
      <?php the_content(); ?>
      <?php comments_template(); ?>
    </article>
  <?php endwhile; endif; ?>
  <?php get_sidebar(); ?>
</section>
<?php get_footer(); ?>
