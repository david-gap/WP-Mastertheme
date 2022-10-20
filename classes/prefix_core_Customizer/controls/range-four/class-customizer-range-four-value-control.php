<?php
class Customizer_Range_Four_Value_Control extends \WP_Customize_Control {

  public function enqueue() {
    wp_enqueue_script( 'customizer-range-four-value-control', get_template_directory_uri() . '/classes/prefix_core_Customizer/controls/range-four/customizer-range-four-value-control.js', array( 'jquery' ), rand(), true );
    wp_enqueue_style( 'customizer-range-four-value-control', get_template_directory_uri() . '/classes/prefix_core_Customizer/controls/range-four/customizer-range-four-value-control.css', array(), rand() );
  }


  public function render_content() {
    ?>
    <div class="range-four-slider-container">
      <span class="start-editing">
        <?php echo __( 'Edit', 'customizer' ); ?>
      </span>
      <label>
        <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
        <div class="range-four-slider">
          <input class="range-four-slider__value main" type="hidden" value="<?php echo esc_attr( $this->value() ); ?>"
            <?php
              $this->input_attrs();
              $this->link();
            ?>
          >
          <input class="range-four-slider__range main" type="range" value="<?php echo esc_attr( str_replace(array('px', 'pt', '%', 'em', 'rem', 'vw', 'vh'), array("", "", "", "", "", "", ""), $this->value() ) ); ?>"
            <?php
              $this->input_attrs();
            ?>
          >
          <input class="range-four-slider__text main" type="number" value="<?php echo esc_attr( str_replace(array('px', 'pt', '%', 'em', 'rem', 'vw', 'vh'), array("", "", "", "", "", "", ""), $this->value() ) ); ?>"
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
          <select class="range-four-slider__unit main"<?php echo $attrAdd; ?>>
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
        // values
        $splitedValue = explode(" ", $this->value());
        $activeSplit = count($splitedValue) > 1 ? ' active' : '';
        $splitOne = $splitedValue[0];
        $splitTwo = count($splitedValue) > 1 ? $splitedValue[1] : $splitOne;
        $splitThree = count($splitedValue) > 2 ? $splitedValue[2] : $splitOne;
        $splitFour = count($splitedValue) > 3 ? $splitedValue[3] : $splitTwo;
        // units
        if($this->input_attrs['suffix'] !== 'none'):
          $splitOneUnit = $this->input_attrs['suffix'];
          $splitTwoUnit = $this->input_attrs['suffix'];
          $splitThreeUnit = $this->input_attrs['suffix'];
          $splitFourUnit = $this->input_attrs['suffix'];
          $splitAttrAdd = ' disabled';
        else:
          $splitOneUnit = $splitOne ? preg_replace('/[0-9\.,]+/', '', $splitOne) : $this->input_attrs['suffix'];
          $splitTwoUnit = $splitTwo ? preg_replace('/[0-9\.,]+/', '', $splitTwo) : $this->input_attrs['suffix'];
          $splitThreeUnit = $splitThree ? preg_replace('/[0-9\.,]+/', '', $splitThree) : $this->input_attrs['suffix'];
          $splitFourUnit = $splitFour ? preg_replace('/[0-9\.,]+/', '', $splitFour) : $this->input_attrs['suffix'];
          $splitAttrAdd = '';
        endif;
      ?>
      <ul class="range-four-value-splited<?php echo $activeSplit; ?>">
        <li>
          <label>
            <span><?php echo esc_html( $this->label ); ?></span> <span><?php echo __( 'Top', 'customizer' ); ?></span>
          </label>
          <div class="range-four-slider">
            <input class="range-four-slider__range row-one" type="range" value="<?php echo esc_attr( str_replace(array('px', 'pt', '%', 'em', 'rem', 'vw', 'vh'), array("", "", "", "", "", "", ""), $splitOne ) ); ?>"
              <?php
                $this->input_attrs();
              ?>
            >
            <input class="range-four-slider__text row-one" type="number" value="<?php echo esc_attr( str_replace(array('px', 'pt', '%', 'em', 'rem', 'vw', 'vh'), array("", "", "", "", "", "", ""), $splitOne ) ); ?>"
              <?php
                $this->input_attrs();
              ?>
            >
            <select class="range-four-slider__unit row-one"<?php echo $splitAttrAdd; ?>>
              <option value="" <?php echo prefix_core_BaseFunctions::setSelected($splitOneUnit, array('', 'none')) ?>>-</option>
              <option value="px" <?php echo prefix_core_BaseFunctions::setSelected($splitOneUnit, 'px') ?>>PX</option>
              <option value="pt" <?php echo prefix_core_BaseFunctions::setSelected($splitOneUnit, 'pt') ?>>PT</option>
              <option value="%" <?php echo prefix_core_BaseFunctions::setSelected($splitOneUnit, '%') ?>>%</option>
              <option value="em" <?php echo prefix_core_BaseFunctions::setSelected($splitOneUnit, 'em') ?>>EM</option>
              <option value="rem" <?php echo prefix_core_BaseFunctions::setSelected($splitOneUnit, 'rem') ?>>REM</option>
              <option value="vw" <?php echo prefix_core_BaseFunctions::setSelected($splitOneUnit, 'vw') ?>>VW</option>
              <option value="vh" <?php echo prefix_core_BaseFunctions::setSelected($splitOneUnit, 'vh') ?>>VH</option>
            </select>
          </div>
        </li>
        <li>
          <label>
            <span><?php echo esc_html( $this->label ); ?></span> <span><?php echo __( 'Right', 'customizer' ); ?></span>
          </label>
          <div class="range-four-slider">
            <input class="range-four-slider__range row-two" type="range" value="<?php echo esc_attr( str_replace(array('px', 'pt', '%', 'em', 'rem', 'vw', 'vh'), array("", "", "", "", "", "", ""), $splitTwo ) ); ?>"
              <?php
                $this->input_attrs();
              ?>
            >
            <input class="range-four-slider__text row-two" type="number" value="<?php echo esc_attr( str_replace(array('px', 'pt', '%', 'em', 'rem', 'vw', 'vh'), array("", "", "", "", "", "", ""), $splitTwo ) ); ?>"
              <?php
                $this->input_attrs();
              ?>
            >
            <select class="range-four-slider__unit row-two"<?php echo $splitAttrAdd; ?>>
              <option value="" <?php echo prefix_core_BaseFunctions::setSelected($splitTwoUnit, array('', 'none')) ?>>-</option>
              <option value="px" <?php echo prefix_core_BaseFunctions::setSelected($splitTwoUnit, 'px') ?>>PX</option>
              <option value="pt" <?php echo prefix_core_BaseFunctions::setSelected($splitTwoUnit, 'pt') ?>>PT</option>
              <option value="%" <?php echo prefix_core_BaseFunctions::setSelected($splitTwoUnit, '%') ?>>%</option>
              <option value="em" <?php echo prefix_core_BaseFunctions::setSelected($splitTwoUnit, 'em') ?>>EM</option>
              <option value="rem" <?php echo prefix_core_BaseFunctions::setSelected($splitTwoUnit, 'rem') ?>>REM</option>
              <option value="vw" <?php echo prefix_core_BaseFunctions::setSelected($splitTwoUnit, 'vw') ?>>VW</option>
              <option value="vh" <?php echo prefix_core_BaseFunctions::setSelected($splitTwoUnit, 'vh') ?>>VH</option>
            </select>
          </div>
        </li>
        <li>
          <label>
            <span><?php echo esc_html( $this->label ); ?></span> <span><?php echo __( 'Bottom', 'customizer' ); ?></span>
          </label>
          <div class="range-four-slider">
            <input class="range-four-slider__range row-three" type="range" value="<?php echo esc_attr( str_replace(array('px', 'pt', '%', 'em', 'rem', 'vw', 'vh'), array("", "", "", "", "", "", ""), $splitThree ) ); ?>"
              <?php
                $this->input_attrs();
              ?>
            >
            <input class="range-four-slider__text row-three" type="number" value="<?php echo esc_attr( str_replace(array('px', 'pt', '%', 'em', 'rem', 'vw', 'vh'), array("", "", "", "", "", "", ""), $splitThree ) ); ?>"
              <?php
                $this->input_attrs();
              ?>
            >
            <select class="range-four-slider__unit row-three"<?php echo $splitAttrAdd; ?>>
              <option value="" <?php echo prefix_core_BaseFunctions::setSelected($splitThreeUnit, array('', 'none')) ?>>-</option>
              <option value="px" <?php echo prefix_core_BaseFunctions::setSelected($splitThreeUnit, 'px') ?>>PX</option>
              <option value="pt" <?php echo prefix_core_BaseFunctions::setSelected($splitThreeUnit, 'pt') ?>>PT</option>
              <option value="%" <?php echo prefix_core_BaseFunctions::setSelected($splitThreeUnit, '%') ?>>%</option>
              <option value="em" <?php echo prefix_core_BaseFunctions::setSelected($splitThreeUnit, 'em') ?>>EM</option>
              <option value="rem" <?php echo prefix_core_BaseFunctions::setSelected($splitThreeUnit, 'rem') ?>>REM</option>
              <option value="vw" <?php echo prefix_core_BaseFunctions::setSelected($splitThreeUnit, 'vw') ?>>VW</option>
              <option value="vh" <?php echo prefix_core_BaseFunctions::setSelected($splitThreeUnit, 'vh') ?>>VH</option>
            </select>
          </div>
        </li>
        <li>
          <label>
            <span><?php echo esc_html( $this->label ); ?></span> <span><?php echo __( 'Left', 'customizer' ); ?></span>
          </label>
          <div class="range-four-slider">
            <input class="range-four-slider__range row-four" type="range" value="<?php echo esc_attr( str_replace(array('px', 'pt', '%', 'em', 'rem', 'vw', 'vh'), array("", "", "", "", "", "", ""), $splitFour ) ); ?>"
              <?php
                $this->input_attrs();
              ?>
            >
            <input class="range-four-slider__text row-four" type="number" value="<?php echo esc_attr( str_replace(array('px', 'pt', '%', 'em', 'rem', 'vw', 'vh'), array("", "", "", "", "", "", ""), $splitFour ) ); ?>"
              <?php
                $this->input_attrs();
              ?>
            >
            <select class="range-four-slider__unit row-four"<?php echo $splitAttrAdd; ?>>
              <option value="" <?php echo prefix_core_BaseFunctions::setSelected($splitFourUnit, array('', 'none')) ?>>-</option>
              <option value="px" <?php echo prefix_core_BaseFunctions::setSelected($splitFourUnit, 'px') ?>>PX</option>
              <option value="pt" <?php echo prefix_core_BaseFunctions::setSelected($splitFourUnit, 'pt') ?>>PT</option>
              <option value="%" <?php echo prefix_core_BaseFunctions::setSelected($splitFourUnit, '%') ?>>%</option>
              <option value="em" <?php echo prefix_core_BaseFunctions::setSelected($splitFourUnit, 'em') ?>>EM</option>
              <option value="rem" <?php echo prefix_core_BaseFunctions::setSelected($splitFourUnit, 'rem') ?>>REM</option>
              <option value="vw" <?php echo prefix_core_BaseFunctions::setSelected($splitFourUnit, 'vw') ?>>VW</option>
              <option value="vh" <?php echo prefix_core_BaseFunctions::setSelected($splitFourUnit, 'vh') ?>>VH</option>
            </select>
          </div>
        </li>
      </ul>
      <span class="stop-editing">
        <?php echo __( 'Close', 'customizer' ); ?>
      </span>
    </div>
    <?php
  }

}
