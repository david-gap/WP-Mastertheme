<?php
class Customizer_Range_Value_Control extends \WP_Customize_Control {

  public function enqueue() {
    wp_enqueue_script( 'customizer-range-value-control', get_template_directory_uri() . '/classes/prefix_core_Customizer/controls/range/customizer-range-value-control.js', array( 'jquery' ), rand(), true );
    wp_enqueue_style( 'customizer-range-value-control', get_template_directory_uri() . '/classes/prefix_core_Customizer/controls/range/customizer-range-value-control.css', array(), rand() );
  }


  public function render_content() {
    ?>
    <label>
      <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
      <div class="range-slider">
        <input class="range-slider__value" type="hidden" value="<?php echo esc_attr( $this->value() ); ?>"
          <?php
            $this->input_attrs();
            $this->link();
          ?>
        >
        <input class="range-slider__range" type="range" value="<?php echo esc_attr( str_replace(array('px', 'pt', '%', 'em', 'rem', 'vw', 'vh'), array("", "", "", "", "", "", ""), $this->value() ) ); ?>"
          <?php
            $this->input_attrs();
          ?>
        >
        <input class="range-slider__text" type="number" value="<?php echo esc_attr( str_replace(array('px', 'pt', '%', 'em', 'rem', 'vw', 'vh'), array("", "", "", "", "", "", ""), $this->value() ) ); ?>"
          <?php
            $this->input_attrs();
          ?>
        >
        <?php
        if($this->input_attrs['suffix'] !== 'none'):
          $currentValue = $this->input_attrs['suffix'];
          $attrAdd = ' disabled';
        else:
          $currentValue = $this->value() ? preg_replace('/[0-9\.,]+/', '', $this->value()) : $this->input_attrs['suffix'];
          $attrAdd = '';
        endif;
        ?>
        <select class="range-slider__unit"<?php echo $attrAdd; ?>>
          <option value="" <?php echo prefix_core_BaseFunctions::setSelected($currentValue, array('', 'none')) ?>>-</option>
          <option value="px" <?php echo prefix_core_BaseFunctions::setSelected($currentValue, 'px') ?>>PX</option>
          <option value="pt" <?php echo prefix_core_BaseFunctions::setSelected($currentValue, 'pt') ?>>PT</option>
          <option value="%" <?php echo prefix_core_BaseFunctions::setSelected($currentValue, '%') ?>>%</option>
          <option value="em" <?php echo prefix_core_BaseFunctions::setSelected($currentValue, 'em') ?>>EM</option>
          <option value="rem" <?php echo prefix_core_BaseFunctions::setSelected($currentValue, 'rem') ?>>REM</option>
          <option value="vw" <?php echo prefix_core_BaseFunctions::setSelected($currentValue, 'vw') ?>>VW</option>
          <option value="vh" <?php echo prefix_core_BaseFunctions::setSelected($currentValue, 'vh') ?>>VH</option>
        </select>
      </div>
      <?php if ( ! empty( $this->description ) ) : ?>
      <span class="description customize-control-description"><?php echo $this->description; ?></span>
      <?php endif; ?>
    </label>
    <?php
  }

}
