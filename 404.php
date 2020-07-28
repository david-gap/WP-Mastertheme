<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @author      David Voglgsang
 * @version     1.0
*/

get_header();
?>
<section id="error-page" <?php echo prefix_template::AddContainer(prefix_template::$template_container, true); ?>>
    <article>
      <h1><?php echo _e('404 Error', 'Template'); ?></h1>
      <p><?php echo _e('Page could not be found.', 'Template'); ?></p>
      <a href="<?php echo get_bloginfo('url'); ?>" class="button"><?php echo _e('Back to home', 'Template'); ?></a>
    </article>
</section>
<? get_footer() ?>
