<?php
/**
 * @author      David Voglgsang
 * @version     1.4.1
*/

$obj = get_queried_object();
// page options
$options = $obj && property_exists($obj, 'ID') ? prefix_template::PageOptions($obj->ID) : array();
// custom content before footer
prefix_template::ContentBlock(prefix_template::$template_footer_before);
// custom post code after main
if(prefix_template::$template_page_options['afterMain'] == 1 && array_key_exists('afterMain', $options)):
  prefix_template::ContentBlock($options['afterMain']);
endif;
?>
    </main>
    <?php if(prefix_template::$template_scrolltotop_active == 1 && !in_array('scrolltotop', $options)):
      echo prefix_template::scrollToTop();
    endif; ?>
    <?php if(prefix_template::$template_footer_active == 1 && !in_array('footer', $options)): ?>
      <footer>
          <?php echo prefix_template::FooterContent(); ?>
      </footer>
    <?php endif; ?>
    <?php
    // custom content before footer
    prefix_template::ContentBlock(prefix_template::$template_footer_after);
    wp_footer();
    ?>
  </body>
</html>
