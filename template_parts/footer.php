<?php
/**
 * Blog template footer for all
 *
 * @author      David Voglgsang
 * @version     1.0
 *
*/
if($args['id'] && $args['id'] !== 0):
  global $post;
  $post = get_post($args['id']);
endif;
?>

<footer>
  <?php if(prefix_template::$template_blog_type_parts["categories"] == 1):
    echo prefix_core_BaseFunctions::ListTaxonomies('category', get_the_ID(), false, ',&nbsp;');
  endif; ?>
</footer>
