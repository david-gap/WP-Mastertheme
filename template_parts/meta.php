<?php
/**
 * Blog template meta for all
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

<?php
// entry meta
$meta = '';
// meta date and time
if(prefix_template::$template_blog_type_parts["date"] == 1 || prefix_template::$template_blog_type_parts["time"] == 1):
  $meta .= '<time class="entry-date" datetime="' . get_the_time( 'c' ) . '">';
  // if date active
  if(prefix_template::$template_blog_type_parts["date"] == 1):
    $meta .= '<span class="date">' . get_the_date(prefix_template::$template_blog_dateformat) . '</span>';
  endif;
  // if time active
  if(prefix_template::$template_blog_type_parts["time"] == 1):
    $meta .= '<span class="time">' . get_the_date('G:i') . '</span>';
  endif;
  $meta .= '</time>';
endif;
// meta author
if(prefix_template::$template_blog_type_parts["author"] == 1):
  $meta .= '<span class="entry-author">' . get_the_author() . '</span>';
endif;
// return values
if($meta !== ''):
  echo '<div class="post-meta">';
    echo $meta;
  echo '</div>';
endif;
?>
