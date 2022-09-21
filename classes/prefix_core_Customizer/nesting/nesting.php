<?php
// https://gist.github.com/OriginalEXE/9a6183e09f4cae2f30b006232bb154af

// Enqueue our scripts and styles
function pe_customize_controls_scripts() {
  wp_enqueue_script( 'pe-customize-controls', get_template_directory_uri() . '/classes/prefix_core_Customizer/nesting/pe-customize-controls.js', array(), '1.0', true );
}

add_action( 'customize_controls_enqueue_scripts', 'pe_customize_controls_scripts' );


if ( class_exists( 'WP_Customize_Panel' ) ) {
  class PE_WP_Customize_Panel extends WP_Customize_Panel {
    public $panel;
    public $type = 'pe_panel';
    public function json() {
      $array = wp_array_slice_assoc( (array) $this, array( 'id', 'description', 'priority', 'type', 'panel', ) );
      $array['title'] = html_entity_decode( $this->title, ENT_QUOTES, get_bloginfo( 'charset' ) );
      $array['content'] = $this->get_content();
      $array['active'] = $this->active();
      $array['instanceNumber'] = $this->instance_number;
      return $array;
    }
  }
}
?>
