<?php
/**
 * @author      David Voglgsang
 * @version     1.5.3
*/
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="<?= prefix_core_BaseFunctions::get_browser_name(); ?>">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1, initial-scale=1">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <?php wp_head(); ?>
  </head>
  <?php
    $obj = get_queried_object();
    // page options
    $options = $obj && property_exists($obj, 'ID') ? prefix_template::PageOptions($obj->ID) : array();
  ?>
  <body class="<?php prefix_template::BodyCSS(); ?>">
    <?php echo prefix_WPseo::GoogleTracking(true); ?>
    <?php if(!in_array('header', $options)): ?>
      <header>
        <nav>
          <?php echo prefix_template::HeaderContent(); ?>
        </nav>
        <?php
          // Header divider
          echo prefix_template::Divider(prefix_template::$template_header_divider);
        ?>
      </header>
    <?php endif; ?>
    <?php
      // global code after header
      prefix_template::ContentBlock(prefix_template::$template_header_after);
      // custom post code before main
      if(prefix_template::$template_page_options['beforeMain'] == 1 && array_key_exists('beforeMain', $options)):
        prefix_template::ContentBlock($options['beforeMain']);
      endif;
    ?>
    <main>
