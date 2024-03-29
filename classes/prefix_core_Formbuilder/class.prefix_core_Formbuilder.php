<?php
/**
 *
 *
 * Form Builder
 * https://github.com/david-gap/classes
 * Author: David Voglgsang
 * @version     2.1.1
 */

class prefix_core_Formbuilder {

  /* INIT FUNCTIONS
  /===================================================== */
  /**
    * call formular
  */
  function __construct(){
  }



  /* FUNCTIONS
  /===================================================== */

  /* INPUT BUILDER
  /------------------------*/
  /**
    * @param array $input has to be a array
    * @param string $prefix prefix for name and classes
    * @return string form input
  */
  /*
  array(
    "type" => "",               // hidden, select, textarea, checkbox, radio, email, text
    "name" => "" ,              // field name
    "disabled" => "",           // disable field
    "value" => "",              // default value
    "id" => "",                 // field id
    "attributes" => "",         // field additional attributes
    "class" => "",              // field css class
    "label" => "",              // field label
    "placeholder" => "",        // placeholder
    "form_input_before" => "",  // html code before input container
    "form_input_after" => ""    // html code after input container
  )
  */
  static function BuildInput(array $input, string $prefix = "form-builder"){
    // vars
    $output = '';
    $type = array_key_exists('type', $input) ? $input['type'] : false;
    $name = array_key_exists('name', $input) ? $input['name'] : false;
    $disabled = array_key_exists('disabled', $input) ? $input['disabled'] : false;
    $autocomplete = array_key_exists('autocomplete', $input) ? $input['autocomplete'] : false;
    $readonly = array_key_exists('readonly', $input) ? $input['readonly'] : false;
    $value = array_key_exists('value', $input) ? $input['value'] : false;
    $classes = '';
    $classes .= array_key_exists('css', $input) ? ' ' . $input['css'] : '';
    // container conditions
    $c_addition = '';
    if(array_key_exists('attributes', $input)):
      foreach ($input['attributes'] as $datakey => $data) {
        $c_addition .= ' ' . $datakey . '="' . $data . '"';
      }
    endif;
    $c_addition .= array_key_exists('id', $input) ? 'id="' . $input['id'] . '" ' : '';
    // input conditions
    $i_addition = '';
    $prefix = $prefix !== '' ? $prefix . '-' : '';
    $i_addition .= $name ? 'name="'. $prefix . $name . '" ' : '';
    $i_addition .= array_key_exists('placeholder', $input) && $type !== 'select' ? 'placeholder="' . $input['placeholder'] . '" ' : '';
    $i_addition .= $disabled ? 'disabled ' : '';
    $i_addition .= $autocomplete ? 'autocomplete="' . $input['autocomplete'] . '" ' : '';
    $i_addition .= $readonly ? 'readonly="' . $input['readonly'] . '" ' : '';
    // output
    switch ($type) {
      // fallback for hidden fields
      case "hidden":
        $output .= '<input type="' . $type . '" ' . $i_addition . ' value="' . $value . '" ' . $c_addition . '>';
        break;
      default:
          $output .= array_key_exists('form_input_before', $input) ? $input['form_input_before'] : '';
          $output .= '<div class="form-row form-type-' . $type . ' '. $prefix . $type . $classes . '" ' . $c_addition . '>';
            $output .= array_key_exists('label', $input) ? '<label for="for-' . $name . '">' . $input['label'] . '</label>' : '';
            // output by input type
            switch ($type) {
              case "select":
                $output .= '<select ' . $i_addition . '>';
                  if(array_key_exists('placeholder', $input)):
                    $output .= '<option selected="selected">' . $input['placeholder'] . '</option>';
                  endif;
                  foreach ($value as $option) {
                    $select = prefix_core_BaseFunctions::setSelected($option, prefix_core_BaseFunctions::getFormPost($prefix . $name));
                    $output .= '<option value="' . $option . '" ' . $select . '>' . $option . '</option>';
                  }
                $output .= '</select>';
                break;
              case "textarea":
                $output .= '<textarea ' . $i_addition . ' id="for-' . $name . '">' . prefix_core_BaseFunctions::getFormPost($prefix . $name, $value) . '</textarea>';
                break;
              case "checkbox":
                $output .= '<div class="option-container">';
                  if (is_array($value)):
                    foreach ($value as $key => $checkbox) {
                      $output .= '<div class="option-row">';
                        $checked = prefix_core_BaseFunctions::setChecked($checkbox, prefix_core_BaseFunctions::getFormPost($prefix . $name));
                        $output .= '<input type="checkbox" name="' . $prefix . $name . '[]" value="' . $key . '" ' . $checked . '>';
                        $output .= '<label>';
                          $output .= $checkbox;
                        $output .= '</label>';
                      $output .= '</div>';
                    }
                  else:
                    $checked = prefix_core_BaseFunctions::setChecked($value, prefix_core_BaseFunctions::getFormPost($prefix . $name));
                    $output .= '<div class="option-row">';
                    $output .= '<input type="checkbox" name="' . $prefix . $name . '" value="' . $value . '" ' . $checked . '>';
                      $output .= '<label>';
                        $output .= $value;
                      $output .= '</label>';
                    $output .= '</div>';
                  endif;
                $output .= '</div>';
                break;
              case "radio":
                if (is_array($value)):
                  $output .= '<div class="option-container">';
                    foreach ($value as $key => $radio) {
                      $output .= '<div class="option-row">';
                        $checked = prefix_core_BaseFunctions::setChecked($radio, prefix_core_BaseFunctions::getFormPost($prefix . $name));
                        $output .= '<input type="radio" name="' . $prefix . $name . '[]" value="' . $key . '" ' . $checked . '>';
                        $output .= '<label>';
                          $output .= $radio;
                        $output .= '</label>';
                      $output .= '</div>';
                    }
                  $output .= '</div>';
                else:
                  // Fallback if radio value is a string
                endif;
                break;
              default:
                $output .= '<input type="' . $type . '" id="for-' . $name . '" value="' . prefix_core_BaseFunctions::getFormPost($prefix . $name, $value) . '" ' . $i_addition . '>';
            }
          $output .= '</div>';
          $output .= array_key_exists('form_input_after', $input) ? $input['form_input_after'] : '';
    }

    return $output;
  }



  /* FORM BUILDER
  /===================================================== */
  /**
    * Formular
    * @param $args: formular arguments
    * @return string with formular
  */
  /*
  $args = array(
    "container" => array(
      "css" => "",         // css classes inside container div
      "add" => ""          // all inside container div tag except class and id
    ),
    "form" => "",          // all inside form tag
    "inputs" => array(),   // BuildInput
    "submit" => array(
      "name" => "",        // submit name add to prefix
      "id" => "",          // submit id
    )
  );
  bd_Formbuilder::FormBuilder($args, "prefix");
  */
  public static function FormBuilder(array $args = array(), string $prefix = "form-builder"){
    $output = '';
    // build container
    $container_css = 'form-builder-container ' . $prefix;
    $container_add = '';
    if(array_key_exists('container', $args)):
      $container_css .= array_key_exists('css', $args['container']) ? ' ' . $args['container']['css'] : '';
      $container_add .= array_key_exists('add', $args['container']) ? ' ' . $args['container']['add'] :' ';
    endif;
    // build form
    $form = '';
    if(array_key_exists('form', $args)):
      $form .= ' ' . $args['form'];
    endif;
    // build submit
    $submit = '';
    if(array_key_exists('submit', $args)):
      $submit_name = array_key_exists('name', $args['submit']) ? $args['submit']['name'] : 'submit';
      $submit_id = array_key_exists('id', $args['submit']) ? ' id="' . $args['submit']['id'] .'"' : '';
      $submit_value = array_key_exists('value', $args['submit']) ? ' ' . $args['submit']['value'] :'Submit';
      $submit .= '<input type="submit" name="' . $prefix . '-' . $submit_name . '" value="' . $submit_value . '"' . $submit_id . '>';
    endif;

    $output .= '<div class="' . $container_css . '"' . $container_add . '>';
      $output .= '<form' . $form . '>';
          // form inputs
          if($args['inputs']):
            foreach ($args['inputs'] as $input) {
              $output .= SELF::BuildInput($input, $prefix);
            }
          else:
            $output .= '';
          endif;
          // form submit
          $output .= $submit;
      $output .= '</form>';
    $output .= '</div>';

    return $output;
  }

}
