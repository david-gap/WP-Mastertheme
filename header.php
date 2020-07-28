<?php
/**
 * @author      David Voglgsang
 * @version     1.0
*/
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1, initial-scale=1">
    <?php wp_head(); ?>
  </head>
  <?php
    $obj = get_queried_object();
    // page options
    $options = prefix_template::PageOptions($obj->ID);
    // body class
    $pt = $obj ? 'pt-' . $obj->post_type : '';
  ?>
  <body class="frontend <?php echo $pt; ?> <?php echo prefix_template::$template_coloring; ?> <?php echo prefix_template::CheckSticky(prefix_template::$template_header_sticky); ?>">
    <?php echo prefix_WPseo::GoogleTracking(true); ?>
    <?php if(!in_array('header', $options)): ?>
      <header>
        <nav <?php echo prefix_template::AddContainer(prefix_template::$template_container, true); ?>>
          <?php echo prefix_template::HeaderContent(); ?>
        </nav>
        <?php
          // Header divider
          echo prefix_template::Divider(prefix_template::$template_header_divider);
        ?>
      </header>
    <?php endif; ?>
    <main>
