<?php
/**
 * @author      David Voglgsang
 * @version     1.5.1
*/

$obj = get_queried_object();
// page options
$options = $obj && property_exists($obj, 'ID') ? prefix_template::PageOptions($obj->ID) : array();
// custom post code after main
if(prefix_template::$template_page_options['afterMain'] == 1 && array_key_exists('afterMain', $options)):
  prefix_template::ContentBlock($options['afterMain']);
endif;
// custom content before footer
prefix_template::ContentBlock(prefix_template::$template_footer_before);
?>
    </main>
    <?php if(prefix_template::$template_scrolltotop_active == 1 && !in_array('scrolltotop', $options)):
      echo prefix_template::scrollToTop();
    endif; ?>
    <?php if(prefix_template::$template_footer_active == 1 && !in_array('footer', $options)): ?>
      <footer>
          <?php echo prefix_template::FooterContent(); ?>
          <?php
          // custom html before footer end
          prefix_template::ContentBlock(prefix_template::$template_footer_end);
          wp_footer();
          ?>
      </footer>
    <?php endif; ?>
    <?php
    // custom content after footer
    prefix_template::ContentBlock(prefix_template::$template_footer_after);
    wp_footer();
    ?>
  </body>
</html>
