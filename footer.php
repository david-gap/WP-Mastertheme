<?php
/**
 * @author      David Voglgsang
 * @version     1.1
*/

$obj = get_queried_object();
// page options
$options = $obj && array_key_exists('ID', $obj) ? prefix_template::PageOptions($obj->ID) : array();
// custom content before footer
prefix_template::ContentBlock(prefix_template::$template_footer_before);
?>
    </main>
    <?php if(prefix_template::$template_footer_active == 1 && !in_array('footer', $options)): ?>
      <footer>
        <div class="footer-container <?php echo prefix_template::AddContainer(prefix_template::$template_container, false); ?>">
          <?php echo prefix_template::FooterContent(); ?>
        </div>
      </footer>
    <?php endif; ?>
    <?php
    wp_footer();
    ?>
  </body>
</html>
