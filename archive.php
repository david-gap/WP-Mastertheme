<?php
/**
 * Post Type File Overview
 *
 * @author      David Voglgsang
 * @version     1.6
 *
*/

get_header();
?>
<section id="archive" <?php echo prefix_template::AddContainer(prefix_template::$template_container, prefix_template::$template_container_archive_wide, true); ?>>
  <div class="results">
    <?php while ( have_posts() ) : the_post();
      if(get_post_type() == "post" || post_type_supports(get_post_type(), 'post-formats')):
        $blog_type = get_post_format(get_the_ID()) ? get_post_format(get_the_ID()) : "default";
        // blog output
        if(locate_template('template_parts/' . get_post_type() . '_' . $blog_type . '.php')):
          get_template_part('template_parts/' . get_post_type() . '_' . $blog_type, '', array('callingFrom' => 'archive'));
        else:
          get_template_part('template_parts/post_' . $blog_type, '', array('callingFrom' => 'archive'));
        endif;
      else:
        // default output
        get_template_part('template_parts/post_default', '', array('callingFrom' => 'archive'));
      endif;
    endwhile;	?>
  </div>
  <?php
    $big = 999999999; // need an unlikely integer
    $paginationPages = paginate_links(array(
        'prev_next' => false,
        'type' => 'plain',
        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format' => '?paged=%#%',
        'current' => max( 1, get_query_var('paged') ),
        'total' => $wp_query->max_num_pages
    ));
    if($paginationPages):
  ?>
    <nav class="wp-block-query-pagination pagination">
      <?php echo get_previous_posts_link(); ?>
      <div class="wp-block-query-pagination-numbers">
        <?php echo $paginationPages; ?>
      </div>
      <?php echo get_next_posts_link(); ?>
    </nav>
  <?php endif; ?>
</section>
<?php get_footer(); ?>
