<?php
/**
 * Comments File
 *
 * @author      David Voglgsang
 * @version     1.1.2
 *
*/

$obj = get_queried_object();
// page options
$options = $obj && property_exists($obj, 'ID') ? prefix_template::PageOptions($obj->ID) : array();

if (comments_open() && !in_array('comments', $options)):
  if ( post_password_required() )
   return;
   if($obj->post_type == 'page' && prefix_template::$template_comments_activePages == 0 || $obj->post_type == 'post' && prefix_template::$template_comments_activeBlog == 0)
   return;
?>
<div id="comments" class="comments-area <?php echo prefix_template::AddContainer(prefix_template::$template_container, prefix_template::$template_container_comments_wide, false); ?>">
  <?php if (0 != get_comments_number()): ?>
    <h3 class="comments-title">
      <?php
        printf( _nx( 'One thought on "%2$s"', '%1$s thoughts on "%2$s"', get_comments_number(), 'comments title', 'devTheme' ),
                number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
      ?>
    </h3>
    <ol class="commentlist">
      <?php
         wp_list_comments( array(
             'style'       => 'ol',
             'short_ping'  => true,
             'avatar_size' => 32,
         ) );
      ?>
    </ol>
  <?php endif; ?>
  <?php comment_form(); ?>
</div>
<?php endif; ?>
