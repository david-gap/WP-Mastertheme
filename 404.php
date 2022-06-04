<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @author      David Voglgsang
 * @version     1.0.2
*/

get_header();
?>
<section id="error-page" <?php echo prefix_template::AddContainer(prefix_template::$template_container, true); ?>>
  <?php echo prefix_template::get_thumbnail(); ?>
  <article>
    <h1 class="post-title"><?php echo _e('404 Error', 'devTheme'); ?></h1>
    <p><?php _e('Page could not be found.', 'devTheme'); ?></p>
    <a href="<?php echo get_bloginfo('url'); ?>" class="button"><?php _e('Back to home', 'devTheme'); ?></a>
  </article>
</section>
<?php get_footer() ?>
