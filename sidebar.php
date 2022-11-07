<?php
/**
 * Sidebar File
 *
 * @author      David Voglgsang
 * @version     1.3.1
 *
*/

$obj = get_queried_object();
// page options
$options = $obj && property_exists($obj, 'ID') ? prefix_template::PageOptions($obj->ID) : array();

if(!in_array('sidebar', $options) && is_active_sidebar('sidebar-' . $obj->post_type)): ?>
  <aside id="sidebar" class="sidebar-<?php echo $obj->post_type; ?>">
    <?php
      dynamic_sidebar('sidebar-' . $obj->post_type);
    ?>
  </aside>
<?php endif; ?>
