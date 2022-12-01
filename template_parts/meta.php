<?php
/**
 * Blog template meta for all
 *
 * @author      David Voglgsang
 * @version     1.1.1
 *
*/
if($args && array_key_exists('id', $args) && $args['id'] !== 0):
  global $post;
  $post = get_post($args['id']);
endif;
?>

<?php
// page options
$options = prefix_template::PageOptions(get_the_id());
echo prefix_template::postMeta(get_post_type(), $options, 1);
?>
