<?php
/**
 * Search results page
 *
 * @author      David Voglgsang
 * @version     1.0
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
    <?php echo __('No results were found','Template'); ?>
  <?php endif; ?>
</section>
<?php get_footer(); ?>
