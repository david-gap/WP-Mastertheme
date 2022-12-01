<?php
/**
 * Blog template footer for all
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

<footer>
  <?php if(prefix_template::$template_meta_overview["categories"] == 1):
    echo prefix_core_BaseFunctions::ListTaxonomies('category', get_the_ID(), false, ',&nbsp;');
  endif; ?>
</footer>
