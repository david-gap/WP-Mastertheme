<?php
/**
 * @author      David Voglgsang
 * @version     1.0
*/

$obj = get_queried_object();
// page options
$options = prefix_template::PageOptions($obj->ID);
// body class
$pt = $obj ? 'pt-' . $obj->post_type : '';
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
