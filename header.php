<?php
/**
 * @author      David Voglgsang
 * @version     1.4
*/
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="<?= prefix_core_BaseFunctions::get_browser_name(); ?>">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1, initial-scale=1">
    <?php wp_head(); ?>
  </head>
  <?php
    $obj = get_queried_object();
    // page options
    $options = $obj && array_key_exists('ID', $obj) ? prefix_template::PageOptions($obj->ID) : array();
  ?>
  <body class="<? prefix_template::BodyCSS(); ?>">
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
    <?php prefix_template::ContentBlock(prefix_template::$template_header_after); ?>
    <main>
