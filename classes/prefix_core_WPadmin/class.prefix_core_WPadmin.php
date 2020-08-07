<?
/**
 *
 *
 * Backend area to manage configuration file
 * Author:      David Voglgsnag
 * @version     1.0.1
 *
 */

 /*=======================================================
 Table of Contents:
 ---------------------------------------------------------
 1.0 INIT & VARS
   1.1 CONFIGURATION
   1.2 ON LOAD RUN
 2.0 FUNCTIONS
   2.1 ADD BACKEND PAGE
   2.2 ENQUEUE BACKEND SCRIPTS/STYLES
 3.0 OUTPUT
   3.1 CONFIGURATOR FORM
   3.2 BUILD INPUT
 =======================================================*/


class prefix_core_WPadmin {

  /*==================================================================================
    1.0 INIT & VARS
  ==================================================================================*/

  /* 1.1 CONFIGURATION
  /------------------------*/
  /**
    * default vars
  */


  /* 1.2 ON LOAD RUN
  /------------------------*/
  public function __construct() {
    // add backend custom page
    add_action( 'admin_menu', array( $this, 'WPadmin_BackendPage' ) );
    // add class assets
    add_action('admin_enqueue_scripts', array( $this, 'WPadmin_backend_enqueue_scripts_and_styles' ) );
  }



  /*==================================================================================
    2.0 FUNCTIONS
  ==================================================================================*/

  /* 2.1 ADD BACKEND PAGE
  /------------------------*/
  function WPadmin_BackendPage() {
    add_menu_page(
      __('Configurator','WPadmin'),
      __('Configurator','WPadmin'),
      'page_configuration',
      'configuration',
      array( $this, 'WPadmin_Configurator' ),
      '',
      100
    );
    // give access to administrator
    $role_admin = get_role( 'administrator' );
    $role_admin->add_cap( 'page_configuration' );
  }


  /* 2.2 ENQUEUE BACKEND SCRIPTS/STYLES
  /------------------------*/
  function WPadmin_backend_enqueue_scripts_and_styles(){
    $class_path = get_template_directory_uri() . '/classes/prefix_core_WPadmin/';
    $backend_ajax_action_file = $class_path . 'ajax.php';
    // scripts
    wp_enqueue_script('backend/WPadmin-script', $class_path . 'WPadmin-backend.js', false, 0.7);
    wp_localize_script( 'backend/WPadmin-script', 'Ajax_File', $backend_ajax_action_file );
    // css
    wp_enqueue_script( 'backend/WPadmin-styles' );
    wp_enqueue_style('backend/WPadmin-styles', $class_path . 'WPadmin-backend.css', false, 0.2);
  }



  /*==================================================================================
    3.0 OUTPUT
  ==================================================================================*/

  /* 3.1 CONFIGURATOR FORM
  /------------------------*/
  function WPadmin_Configurator(){
      if ( !current_user_can( 'page_configuration' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
      }
      // call wp media
      wp_enqueue_media();
      // vars
      $output = '';
      $registered_classes = get_declared_classes();
      $db_option = get_option('WPadmin_configuration') ? get_option('WPadmin_configuration') : array();
      // print_r($db_option);
      // output
      $output .= '<div class="wrap" id="configuration">';
        $output .= '<h1 class="wp-heading-inline">' . __('Page Configurator','WPadmin') . '</h1>';
        $output .= '<button class="page-title-action ajax-action" data-action="GeneratConfigFile">' . __('Generate configuration file','WPadmin') . '</button>';
        $output .= '<span id="config-message"></span>';
        $output .= '<form>';
          foreach ($registered_classes as $class_key => $classname) {
            if(strpos($classname, 'prefix_') === 0 && strpos($classname, '_core_') == false):
              // for each registered custom class
              $builder = isset($classname::$backend) ? $classname::$backend : '';
              $builder_title = isset($classname::$classtitle) ? $classname::$classtitle : '';
              $builder_slug = isset($classname::$classkey) ? $classname::$classkey : $classname;
              // db values
              $db_settings = array_key_exists($builder_slug, $db_option) ? $db_option[$builder_slug] : array();
              // check if backend values exists
              if($builder !== ''):
                // container
                $output .= '<table class="config-group ' . $classname . '">';
                  // return title
                  if($builder_title !== ''):
                    $output .= '<tr>';
                      $output .= '<th colspan="2"><h2>' . $builder_title . '</h2></th>';
                    $output .= '</tr>';
                  endif;
                  // return inputs
                  foreach ($builder as $input_key => $input) {
                    $output .= '<tr>';
                      $output .= '<td><label for="WPadmin_' . $builder_slug . '_' . $input_key . '">';
                      if(array_key_exists('label', $input)):
                        $output .= $input["label"];
                      else:
                        $output .= '<span class="error">' . __('Label is missing','WPadmin') . '</span>';
                      endif;
                      $output .= '</label></td>';
                      $output .= '<td>';
                        if(array_key_exists('type', $input)):
                          $css = '';
                          $css .= array_key_exists('css', $input) ? ' ' . $input["css"] : '';
                          $value = array_key_exists('value', $input) ? $input["value"] : false;
                          $db_value = array_key_exists($input_key, $db_settings) ? $db_settings[$input_key] : false;
                          $output .= SELF::BuildInput(
                            $input["type"],
                            $value,
                            $builder_slug . '[' . $input_key. ']',
                            'WPadmin_' . $builder_slug . '_' . $input_key,
                            $css,
                            $db_value
                          );
                        else:
                          $output .= '<span class="error">' . __('Input type is missing','WPadmin') . '</span>';
                        endif;
                      $output .= '</td>';
                    $output .= '</tr>';
                  }
                $output .= '</table>';
              endif;
            endif;
          }
          $output .= '<input type="submit" class="button button-primary" data-action="SaveFormInput" value="' . __( 'Save', 'WPadmin' ) . '">';
        $output .= '</form>';
      $output .= '</div>';
      echo $output;
  }

  /* 3.2 BUILD INPUT
  /------------------------*/
  /**
    * @param string $type input type
    * @param $multiple field for multiple inputs
    * @param string $name field name
    * @param string $id field id
    * @param string $css multiple is sortable
    * @param $value value saved in DB
    * @return string form input
  */
  function BuildInput(string $type = 'text', $multiple = '', string $name = '', string $id = '', string $css = "", $value = false){
    // vars
    $output = '';
    $attr   = '';
    $attr   .= $name !== '' && $type !== 'select' ? ' name="' . $name . '"' : '';
    $attr   .= $id !== '' && $type !== 'switchbutton' ? ' id="' . $id . '"' : '';
    // build input
    switch ($type) {
      case "checkbox":
        $attr .= $value !== false ? prefix_core_BaseFunctions::setChecked('1', $value) : '';
        $output .= '<input type="checkbox"' . $attr . ' value="1">';
        break;

      case "switchbutton":
          $output .= '<span class="switchbutton">';
            $output .= '<span class="circle"></span>';
            $output .= '<input type="radio"' . $attr . ' value="1" id="' . $id . '_switch-yes" ' . prefix_core_BaseFunctions::setChecked('1', $value) . '>';
            $output .= '<label for="' . $id . '_switch-yes">';
              $output .= __('yes','WPadmin');
            $output .= '</label>';
            $output .= '<input type="radio"' . $attr . ' value="0" id="' . $id . '_switch-no" ' . prefix_core_BaseFunctions::setChecked('0', $value) . '>';
            $output .= '<label for="' . $id . '_switch-no">';
              $output .= __('no','WPadmin');
            $output .= '</label>';
          $output .= '</span>';
        break;

      case "text":
        $attr .= $value !== false ? 'value="' . $value . '"' : '';
        $output .= '<input type="text"' . $attr . '>';
        break;

      case "textarea":
        $output .= '<textarea' . $attr . '>';
          $output .= $value !== false ? $value : '';
        $output .= '</textarea>';
        break;

      case "img":
        $output .= '<div data-id="' . $name . '">';
          $attr .= $value !== false ? 'value="' . $value . '"' : '';
          $output .= '<input id="img-saved_' . $name . '" class="img-saved" type="hidden"' . $attr . '>';
          // select button
          $output .= '<button class="wp-single-media" data-action="WPadmin">' . __('Select images','WPadmin') . '</button><br />';
          // img
          $output .= '<span class="img-selected">';
            if($value !== false && $value !== ''):
              $output .= '<span class="remove_image"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 24.9 24.9" xml:space="preserve"><rect x="-3.7" y="10.9" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -5.1549 12.4451)" fill="#000" width="32.2" height="3"/><rect x="10.9" y="-3.7" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -5.1549 12.4451)" fill="#000" width="3" height="32.2"/></svg></span>';
              $output .= '<img src="' . wp_get_attachment_thumb_url($value) . '">';
            endif;
          $output .= '</span>';
        $output .= '</div>';
        break;

      case "select":
      $attr .= strpos($css, 'multiple') !== false ? 'multiple' : '';
      $attr .= $name !== '' && strpos($css, 'multiple') == false ? ' name="' . $name . '"' : '';
      $attr .= $name !== '' && strpos($css, 'multiple') !== false ? ' name="' . $name . '[]"' : '';
        $output .= '<select ' . $attr . '>';
        foreach ($multiple as $multiple_key => $multiple_input) {
          $selected = $value !== false ? prefix_core_BaseFunctions::setSelected($multiple_input, $value) : '';
          $output .= '<option value="' . $multiple_input . '" ' . $selected . '>';
            $output .= $multiple_input;
          $output .= '</option>';
        }
        $output .= '</select>';
        break;

      case "multiple":
        // sort by DB
        if(strpos($css, 'sortable') !== false && $value !== false):
          $resort = array();
          foreach ($value as $single_key => $single) {
            $resort[$single_key] = $multiple[$single_key];
          }
          $multiple = $resort;
        endif;
        // output
        $output .= '<ul class="multiple' . $css . '">';
          foreach ($multiple as $multiple_key => $multiple_input) {
            $multiple_value = array_key_exists('value', $multiple_input) ? $multiple_input["value"] : false;
            $multiple_css = array_key_exists('css', $multiple_input) ? ' ' . $multiple_input["css"] : '';
            $db_value = $value !== false && array_key_exists($multiple_key, $value) ? $value[$multiple_key] : false;
            $output .= '<li>';
              $output .= '<label for="' . $id . '_' . $multiple_key . '">' . $multiple_input["label"] . '</label>';
              $output .= SELF::BuildInput(
                $multiple_input["type"],
                $multiple_value,
                $name . '[' . $multiple_key. ']',
                $id . '_' . $multiple_key,
                $multiple_css,
                $db_value
              );
            $output .= '</li>';
          }
        $output .= '</ul>';
        break;

      case "array_addable":
       $css .= $value !== false && count($value) > 1 ? '' : ' disable-remove';
       $output .= '<ul class="addable' . $css . '">';
          if($multiple !== false):
            // multiple inputs
            if($value !== false):
              foreach ($value as $single_key => $single_value) {
                $output .= '<li data-row="' . $single_key . '">';
                  $output .= '<ul class="multiple">';
                    foreach ($multiple as $multiple_key => $multiple_input) {
                      $multiple_value = array_key_exists('value', $multiple_input) ? $multiple_input["value"] : false;
                      $db_value = $single_value !== false && array_key_exists($multiple_key, $single_value) ? $single_value[$multiple_key] : false;
                      $output .= '<li>';
                        $output .= '<label>' . $multiple_input["label"] . '</label>';
                        $output .= SELF::BuildInput(
                          $multiple_input["type"],
                          $multiple_value,
                          $name . '[' . $single_key . '][' . $multiple_key. ']',
                          $id . '_' . $multiple_key,
                          '',
                          $db_value
                        );
                      $output .= '</li>';
                    }
                  $output .= '</ul>';
                  $output .= '<span class="remove" data-value="" data-target="input">X</span>';
                $output .= '</li>';
              }
            else:
              $output .= '<li data-row="0">';
                $output .= '<ul class="multiple">';
                  foreach ($multiple as $multiple_key => $multiple_input) {
                    $multiple_value = array_key_exists('value', $multiple_input) ? $multiple_input["value"] : false;
                    $multiple_css = array_key_exists('css', $multiple_input) ? ' ' . $multiple_input["css"] : '';
                    $db_value = $value !== false && array_key_exists($multiple_key, $value) ? $value[$multiple_key] : false;
                    $output .= '<li>';
                      $output .= '<label>' . $multiple_input["label"] . '</label>';
                      $output .= SELF::BuildInput(
                        $multiple_input["type"],
                        $multiple_value,
                        $name . '[0][' . $multiple_key. ']',
                        $id . '_' . $multiple_key,
                        $multiple_css,
                        $db_value
                      );
                    $output .= '</li>';
                  }
                $output .= '</ul>';
                $output .= '<span class="remove" data-value="" data-target="input">X</span>';
              $output .= '</li>';
            endif;
          else:
            // no multiple inputs
            if($value !== false):
              foreach ($value as $single_key => $single_value) {
                $output .= '<li data-row="' . $single_key . '">';
                  $output .= SELF::BuildInput(
                    'text',
                    '',
                    $name . '[' . $single_key . ']',
                    '',
                    '',
                    $single_value
                  );
                  $output .= '<span class="remove" data-value="" data-target="input">X</span>';
                $output .= '</li>';
              }
            else:
              $output .= '<li data-row="0">';
                $output .= SELF::BuildInput(
                  'text',
                  '',
                  $name . '[0]'
                );
                $output .= '<span class="remove" data-value="" data-target="input">X</span>';
              $output .= '</li>';
            endif;
          endif;
        $output .= '</ul>';
        $output .= '<button class="button button-primary input-fields-adder" data-action="addInputRow">' . __( 'Add entry', 'WPadmin' ) . '</button>';
        break;

      default:
        $output .= "<span>input type <strong>" . $type . "</strong> not defined</span>";
    }

    return $output;
  }

}
