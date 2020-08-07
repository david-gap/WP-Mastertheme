<?php
/**
 * Search results page
 *
 * @author      David Voglgsang
 * @version     1.1
 *
*/

get_header();
?>
<section id="search-results" <?php echo prefix_template::AddContainer(prefix_template::$template_container, true); ?>>
  <h1>
    <?php echo $wp_query->found_posts; ?> <?php echo __('Search results for','Template'); ?>: "<?php the_search_query(); ?>"
  </h1>
  <?php if ( have_posts() ) : ?>
    <div class="results">
      <?php while ( have_posts() ) : the_post(); ?>
        <article class="post">
          <h3><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h3>
          <?php the_excerpt(); ?>
        </article>
      <?php endwhile;	?>
    </div>
  <?php else: ?>
    <p><?php echo __('Sorry, but nothing matched your search terms. Please try again with some different keywords.','Template'); ?></p>
  <?php endif; ?>
</section>
<nav class="pagination">
  <?
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
