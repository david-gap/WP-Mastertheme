<?php
/**
 * Search results page
 *
 * @author      David Voglgsang
 * @version     1.2.1
 *
*/

get_header();
?>
<section id="search-results" <?php echo prefix_template::AddContainer(prefix_template::$template_container, true); ?>>
  <?php echo prefix_template::get_thumbnail(); ?>
  <h1 class="post-title">
    <?php echo $wp_query->found_posts; ?> <?php _e('Search results for','devTheme'); ?>: "<?php the_search_query(); ?>"
  </h1>
  <?php if ( have_posts() ) : ?>
    <div class="results">
      <?php while ( have_posts() ) : the_post();
        if(get_post_type() == "post" || post_type_supports(get_post_type(), 'post-formats')):
          // blog output
          $blog_type = get_post_format();
          if(locate_template('template_parts/' . get_post_type() . '_' . $blog_type)):
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
  <?php else: ?>
    <p><?php _e('Sorry, but nothing matched your search terms. Please try again with some different keywords.','devTheme'); ?></p>
  <?php endif; ?>
</section>
<nav class="pagination">
  <?php
  $big = 999999999; // need an unlikely integer
  echo paginate_links( array(
      'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
      'format' => '?paged=%#%',
      'current' => max( 1, get_query_var('paged') ),
      'total' => $wp_query->max_num_pages
  ) );
  ?>
</nav>
<?php get_footer(); ?>
