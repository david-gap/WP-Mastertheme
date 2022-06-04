<?php
/**
 * Post Type File Overview
 *
 * @author      David Voglgsang
 * @version     1.3
 *
*/

get_header();
?>
<section id="archive" <?php echo prefix_template::AddContainer(prefix_template::$template_container, true); ?>>
  <div>
    <?php while ( have_posts() ) : the_post();
      if(get_post_type() == "post" || post_type_supports(get_post_type(), 'post-formats')):
        $blog_type = get_post_format(get_the_ID()) ? get_post_format(get_the_ID()) : "default";
        // blog output
        if(locate_template('template_parts/' . get_post_type() . '_' . $blog_type . '.php')):
          get_template_part('template_parts/' . get_post_type() . '_' . $blog_type);
        else:
          get_template_part('template_parts/post_' . $blog_type);
        endif;
      else:
        // default output
        get_template_part('template_parts/post_default');
      endif;
    endwhile;	?>
  </div>
  <?php get_sidebar(); ?>
</section>
<?php get_footer(); ?>
