<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @author      David Voglgsang
 * @version     1.2.2
*/

get_header();
?>
<section id="error-page" <?php echo prefix_template::AddContainer(prefix_template::$template_container, true); ?>>
  <?php
    if(array_key_exists('thumbnail', prefix_template::$template_header_sort) && prefix_template::$template_header_sort['thumbnail'] == 1):
    else:
      echo prefix_template::get_thumbnail();
    endif;
  ?>
  <article>
    <h1 class="post-title"><?php echo _e('404 Error', 'devTheme'); ?></h1>
    <p><?php _e('Page could not be found.', 'devTheme'); ?></p>
    <?php
      if(prefix_template::$template_404_searchForm == 1):
        echo get_search_form();
      endif;
      if(prefix_template::$template_404_backToHome == 1):
        echo '<a href="' . get_bloginfo('url') . '" class="button">' . __('Back to home', 'devTheme') . '</a>';
      endif;
    ?>
  </article>
</section>
<?php get_footer() ?>
