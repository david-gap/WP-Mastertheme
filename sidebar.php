<?php
/**
 * Sidebar File
 *
 * @author      David Voglgsang
 * @version     1.0
 *
*/

get_header();

$obj = get_queried_object();
// page options
$options = prefix_template::PageOptions($obj->ID);
// post type
$pt = $obj ? 'pt-' . $obj->post_type : '';

if(!in_array('sidebar', $options)): ?>
  <aside id="sidebar">
  </aside>
<?php endif; ?>
