<?php
/**
 * Search results page
 *
 * @author      David Voglgsang
 * @version     1.6.1
 *
*/

get_header();
?>
<section id="search-results" <?php echo prefix_template::AddContainer(prefix_template::$template_container, prefix_template::$template_container_searchresults_wide, true); ?>>
  <?php
    if(array_key_exists('thumbnail', prefix_template::$template_header_sort) && prefix_template::$template_header_sort['thumbnail'] == 1):
    else:
      echo prefix_template::get_thumbnail();
    endif;
  ?>
  <h1 class="post-title">
    <?php echo $wp_query->found_posts; ?> <?php _e('Search results for','devTheme'); ?>: "<?php the_search_query(); ?>"
  </h1>
  <?php if ( have_posts() ) : ?>
    <div class="results">
      <?php while ( have_posts() ) : the_post();
        if(get_post_type() == "post" || post_type_supports(get_post_type(), 'post-formats')):
          // blog output
          $blog_type = get_post_format() ? get_post_format() : 'default';
          if(locate_template('template_parts/' . get_post_type() . '_' . $blog_type)):
            get_template_part('template_parts/' . get_post_type() . '_' . $blog_type, '', array('callingFrom' => 'searchresults'));
          else:
            get_template_part('template_parts/post_' . $blog_type, '', array('callingFrom' => 'searchresults'));
          endif;
        else:
          // default output
          get_template_part('template_parts/post_default', '', array('callingFrom' => 'searchresults'));
        endif;
      endwhile;	?>
    </div>
  <?php else: ?>
    <p><?php _e('Sorry, but nothing matched your search terms. Please try again with some different keywords.','devTheme'); ?></p>
  <?php endif; ?>
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
