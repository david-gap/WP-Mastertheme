<?php
/**
 *
 *
 * Backend area to manage configuration file
 * Author:      David Voglgsnag
 * @version     1.6.8
 *
 */

 /*=======================================================
 Table of Contents:
 ---------------------------------------------------------
 1.0 INIT & VARS
   1.1 CONFIGURATION
   1.2 ON LOAD RUN
 2.0 FUNCTIONS
   2.1 ADD BACKEND PAGES
   2.2 ENQUEUE BACKEND SCRIPTS/STYLES
 3.0 OUTPUT
   3.1 CONFIGURATOR FORM
   3.2 BUILD INPUT
   3.3 EXPORT PAGE
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

  /* 2.1 ADD BACKEND PAGES
  /------------------------*/
  function WPadmin_BackendPage() {
    add_menu_page(
      __('Configurator','devTheme'),
      __('Configurator','devTheme'),
      'page_configuration',
      'configuration',
      array( $this, 'WPadmin_Configurator' ),
      '',
      100
    );
    add_submenu_page(
      'configuration',
      __('Export configuration','devTheme'),
      __('Import / Export','devTheme'),
      'page_configuration',
      'configurationImportExport',
      array( $this, 'WPadmin_ConfiguratorImportExport' ),
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
    wp_enqueue_script('backend/WPadmin-script', $class_path . 'WPadmin-backend.js', false, 0.8);
    wp_localize_script( 'backend/WPadmin-script', 'Ajax_File', $backend_ajax_action_file );
    // Add the color picker css file
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');
  }



  /*==================================================================================
    3.0 OUTPUT
  ==================================================================================*/

  /* 3.1 CONFIGURATOR FORM
  /------------------------*/
  function WPadmin_Configurator(){
      if ( !current_user_can( 'page_configuration' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.', 'devTheme' ) );
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
        $output .= '<h1 class="wp-heading-inline">' . __('Page Configurator','devTheme') . '</h1>';
        $output .= '<div id="settings-group">';
          $output .= '<ul id="configuration-navigation">';
            foreach ($registered_classes as $class_key => $classname) {
              if(strpos($classname, 'prefix_') === 0 && strpos($classname, '_core_') == false):
                $builder = isset($classname::$backend) ? $classname::$backend : '';
                if($builder !== ''):
                  $builder_title = isset($classname::$classtitle) ? $classname::$classtitle : '';
                  $output .= '<li><a href="#' . $classname . '">' . $builder_title . '</a></li>';
                endif;
              endif;
            }
          $output .= '</ul>';
          $output .= '<form>';
            $output .= '<div class="configSubmit">';
              $output .= '<button class="page-title-action ajax-action" data-action="GenerateConfigFile">' . __('Generate configuration file','devTheme') . '</button>';
              $output .= '<input type="submit" class="button button-primary" data-action="SaveFormInput" value="' . __( 'Save', 'devTheme' ) . '">';
              $output .= '<span id="config-message"></span>';
            $output .= '</div>';
            foreach ($registered_classes as $class_key => $classname) {
              if(strpos($classname, 'prefix_') === 0 && strpos($classname, '_core_') == false):
                // for each registered custom class
                $builder = isset($classname::$backend) ? $classname::$backend : '';
                // check if backend values exists
                if($builder !== ''):
                  $builder_title = isset($classname::$classtitle) ? $classname::$classtitle : '';
                  $builder_slug = isset($classname::$classkey) ? $classname::$classkey : $classname;
                  // db values
                  $db_settings = array_key_exists($builder_slug, $db_option) ? $db_option[$builder_slug] : array();
                  // container
                  $output .= '<table id="' . $classname . '" class="config-group">';
                    // return title
                    if($builder_title !== ''):
                      $output .= '<tr>';
                        $output .= '<th colspan="2"><h2>' . $builder_title . '</h2></th>';
                      $output .= '</tr>';
                    endif;
                    // return inputs
                    foreach ($builder as $input_key => $input) {
                      $output .= '<tr>';
                        if($input["type"] == 'title'):
                          $output .= '<td class="title" colspan="2">' . $input["label"] . '</td>';
                        elseif(array_key_exists('labelTitled', $input) && $input["labelTitled"] == 1):
                            $output .= '<td class="title" colspan="2">' . $input["label"] . '</td>';
                          $output .= '</tr>';
                          $output .= '<tr>';
                            $output .= '<td colspan="2" class="' . $input["type"] . '">';
                              if(array_key_exists('type', $input)):
                                $css = '';
                                $css .= array_key_exists('css', $input) ? ' ' . $input["css"] : '';
                                $value = array_key_exists('value', $input) ? $input["value"] : false;
                                $db_value = array_key_exists($input_key, $db_settings) ? $db_settings[$input_key] : false;
                                $placeholder = array_key_exists('placeholder', $input) ? ' ' . $input["placeholder"] : '';
                                $translate = array_key_exists('translation', $input) ? $input["translation"] : '';
                                $output .= SELF::BuildInput(
                                  $input["type"],
                                  $value,
                                  $builder_slug . '[' . $input_key. ']',
                                  'WPadmin_' . $builder_slug . '_' . $input_key,
                                  $css,
                                  $db_value,
                                  $placeholder,
                                  $translate
                                );
                              else:
                                $output .= '<span class="error">' . __('Input type is missing','devTheme') . '</span>';
                              endif;
                            $output .= '</td>';
                        else:
                          $output .= '<td><label for="WPadmin_' . $builder_slug . '_' . $input_key . '">';
                          if(array_key_exists('label', $input)):
                            $output .= esc_html( stripslashes( $input["label"] ) );
                          else:
                            $output .= '<span class="error">' . __('Label is missing','devTheme') . '</span>';
                          endif;
                          $output .= '</label></td>';
                          $output .= '<td class="' . $input["type"] . '">';
                            if(array_key_exists('type', $input)):
                              $css = '';
                              $css .= array_key_exists('css', $input) ? ' ' . $input["css"] : '';
                              $value = array_key_exists('value', $input) ? $input["value"] : false;
                              $db_value = array_key_exists($input_key, $db_settings) ? $db_settings[$input_key] : false;
                              $placeholder = array_key_exists('placeholder', $input) ? ' ' . $input["placeholder"] : '';
                              $translate = array_key_exists('translation', $input) ? $input["translation"] : '';
                              $output .= SELF::BuildInput(
                                $input["type"],
                                $value,
                                $builder_slug . '[' . $input_key. ']',
                                'WPadmin_' . $builder_slug . '_' . $input_key,
                                $css,
                                $db_value,
                                $placeholder,
                                $translate
                              );
                            else:
                              $output .= '<span class="error">' . __('Input type is missing','devTheme') . '</span>';
                            endif;
                          $output .= '</td>';
                        endif;
                      $output .= '</tr>';
                    }
                  $output .= '</table>';
                endif;
              endif;
            }
          $output .= '</form>';
        $output .= '</div>';
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
  function BuildInput(string $type = 'text', $multiple = '', string $name = '', string $id = '', string $css = "", $value = false, $placeholder = '', $translate = ''){
    // vars
    $attr   = '';
    $attr   .= $name !== '' && $type !== 'select' && $type !== 'checkboxes' ? ' name="' . $name . '"' : '';
    $attr   .= $id !== '' && $type !== 'switchbutton' ? ' id="' . $id . '"' : '';
    $attr   .= $placeholder !== '' ? ' placeholder="' . $placeholder . '"' : '';
    $output = '';
    $translationValue = '';
    $translationName = $translate !== '' ? $translate : str_replace(array('[', ']'), array('-', ''), $name);
    // build input
    switch ($type) {
      case "checkbox":
        $attr .= $value !== false ? prefix_core_BaseFunctions::setChecked('1', $value) : '';
        $output .= '<input type="checkbox"' . $attr . ' value="1">';
        break;

      case "checkboxes":
        $attr .= $name !== '' ? ' name="' . $name . '[]"' : '';
        $output .= $css && strpos($css, 'selectAll') !== false ? '<label><input type="checkbox" class="select-all" data-name="' . $name . '">' . __('Select all','devTheme') . '</label><br>' : '';
        foreach ($multiple as $multiple_key => $multiple_input) {
          $selected = $value !== false ? prefix_core_BaseFunctions::setChecked($multiple_input, $value) : '';
          $output .= '<label><input type="checkbox"' . $attr . ' value="' . $multiple_input . '" ' . $selected . '>' . $multiple_input . '</label><br>';
          // $output .= '<option value="' . $multiple_input . '" ' . $selected . '>';
          //   $output .= $multiple_input;
          // $output .= '</option>';
        }
        if($name == "gutenberg[AllowedBlocks]"):
          $registered_blocks = WP_Block_Type_Registry::get_instance()->get_all_registered();
          foreach ($registered_blocks as $blockkey => $block) {
            if(!in_array($block->name, $multiple) && $block->name !== 'core/block'):
              $selected = $value !== false ? prefix_core_BaseFunctions::setChecked($block->name, $value) : '';
              $output .= '<label><input type="checkbox"' . $attr . ' value="' . $block->name . '" ' . $selected . '>' . $block->name . '</label><br>';
            endif;
          }
        endif;
        break;

      case "switchbutton":
          $output .= '<span class="switchbutton">';
            $output .= '<span class="circle"></span>';
            $output .= '<input type="radio"' . $attr . ' value="1" id="' . $id . '_switch-yes" ' . prefix_core_BaseFunctions::setChecked('1', $value) . '>';
            $output .= '<label for="' . $id . '_switch-yes">';
              $output .= __('yes','devTheme');
            $output .= '</label>';
            $output .= '<input type="radio"' . $attr . ' value="0" id="' . $id . '_switch-no" ' . prefix_core_BaseFunctions::setChecked('0', $value) . '>';
            $output .= '<label for="' . $id . '_switch-no">';
              $output .= __('no','devTheme');
            $output .= '</label>';
          $output .= '</span>';
        break;

      case "hr":
        $attr .= ' value="1"';
        $output .= '<hr>';
        $output .= '<input type="hidden"' . $attr . '>';
        break;

      case "text":
        $attr .= $value !== false ? "value='" . stripslashes($value) . "'" : '';
        $attr .= $css !== '' ? ' ' . ' class="' . $css . '"' : '';
        $output .= '<input type="text"' . $attr . '>';
        // translation option
        $translationValue .= '<input type="text" name="langid[' . $translationName . ']" value="">';
        break;

      case "textarea":
        $output .= '<textarea' . $attr . '>';
          $output .= $value !== false ? stripslashes($value) : '';
        $output .= '</textarea>';
        break;

      case "img":
        $output .= '<div data-id="' . $name . '">';
          $attr .= $value !== false ? 'value="' . $value . '"' : '';
          $output .= '<input id="img-saved_' . $name . '" class="img-saved" type="hidden"' . $attr . '>';
          // select button
          $output .= '<button class="wp-single-media" data-action="WPadmin">' . __('Select images','devTheme') . '</button><br />';
          // img
          $output .= '<span class="img-selected">';
            if($value !== false && $value !== ''):
              $output .= '<span class="remove_image"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 24.9 24.9" xml:space="preserve"><rect x="-3.7" y="10.9" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -5.1549 12.4451)" fill="#000" width="32.2" height="3"/><rect x="10.9" y="-3.7" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -5.1549 12.4451)" fill="#000" width="3" height="32.2"/></svg></span>';
              $output .= '<img src="' . wp_get_attachment_thumb_url($value) . '">';
            endif;
          $output .= '</span>';
        $output .= '</div>';
        // translation option
        // $translationValue .= '<input type="text" name="langid[' . $translationName . ']" value="">';
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
        // save multiple before sort by DB
        $backend_inputs = $multiple;
        // sort by DB
        if(strpos($css, 'sortable') !== false && $value !== false):
          $resort = array();
          $new = array();
          // check if option new
          foreach ($multiple as $single_key => $single) {
            if(!array_key_exists($single_key, $value)):
              $new[$single_key] = $multiple[$single_key];
            endif;
          }
          // sort given options
          foreach ($value as $single_key => $single) {
            $resort[$single_key] = $multiple[$single_key];
          }
          $multiple = $resort;
          $multiple = array_merge($multiple, $new);
        endif;
        // output
        $output .= '<ul class="multiple' . $css . '">';
          foreach ($multiple as $multiple_key => $multiple_input) {
            if(array_key_exists($multiple_key, $backend_inputs)):
              $multiple_value = array_key_exists('value', $multiple_input) ? $multiple_input["value"] : false;
              $multiple_css = array_key_exists('css', $multiple_input) ? ' ' . $multiple_input["css"] : '';
              $db_value = $value !== false && array_key_exists($multiple_key, $value) ? $value[$multiple_key] : false;
              $multiple_ph = array_key_exists('placeholder', $multiple_input) ? ' ' . $multiple_input["placeholder"] : '';
              $multiple_translate = array_key_exists('translation', $multiple_input) ? $multiple_input["translation"] : '';
              $output .= '<li>';
                $output .= '<label for="' . $id . '_' . $multiple_key . '">' . $multiple_input["label"] . '</label>';
                $output .= SELF::BuildInput(
                  $multiple_input["type"],
                  $multiple_value,
                  $name . '[' . $multiple_key. ']',
                  $id . '_' . $multiple_key,
                  $multiple_css,
                  $db_value,
                  $multiple_ph,
                  $multiple_translate
                );
              $output .= '</li>';
            endif;
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
                      $multiple_css = array_key_exists('css', $multiple_input) ? ' ' . $multiple_input["css"] : '';
                      $db_value = $single_value !== false && array_key_exists($multiple_key, $single_value) ? $single_value[$multiple_key] : false;
                      $multiple_ph = array_key_exists('placeholder', $multiple_input) ? ' ' . $multiple_input["placeholder"] : '';
                      $multiple_translate = array_key_exists('translation', $multiple_input) ? $multiple_input["translation"] : '';
                      $output .= '<li>';
                        $output .= '<label>' . $multiple_input["label"] . '</label>';
                        $output .= SELF::BuildInput(
                          $multiple_input["type"],
                          $multiple_value,
                          $name . '[' . $single_key . '][' . $multiple_key. ']',
                          $id . '_' . $multiple_key,
                          $multiple_css,
                          $db_value,
                          $multiple_ph,
                          $multiple_translate
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
                    $multiple_translate = array_key_exists('translation', $multiple_input) ? $multiple_input["translation"] : '';
                    $output .= '<li>';
                      $output .= '<label>' . $multiple_input["label"] . '</label>';
                      $output .= SELF::BuildInput(
                        $multiple_input["type"],
                        $multiple_value,
                        $name . '[0][' . $multiple_key. ']',
                        $id . '_' . $multiple_key,
                        $multiple_css,
                        $db_value,
                        '',
                        $multiple_translate
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
        $output .= '<button class="button button-primary input-fields-adder" data-action="addInputRow">' . __( 'Add entry', 'devTheme' ) . '</button>';
        break;

      default:
        $output .= "<span>input type <strong>" . $type . "</strong> not defined</span>";
    }

    // TRANSLATE
    if($translate !== '' && $translationValue !== ''):
      if (class_exists('SitePress')):
        $languages = icl_get_languages();
      elseif(function_exists('pll_the_languages')):
        $languages = icl_get_languages();
      else:
        $languages = get_available_languages();
      endif;
      $db_option = get_option('WPadmin_configuration') ? get_option('WPadmin_configuration') : array();
      $output .= '<span class="config-translations"><span>T</span><ul>';
        foreach ($languages as $key => $lang) {
          $languageCode = is_array($lang) ? $key : $lang;
          // check if value exisits
          $langTranslations = array_key_exists($languageCode, $db_option) ? $db_option[$languageCode] : array();
          $value = array_key_exists($translationName, $langTranslations) ? $langTranslations[$translationName] : '';
          //
          $output .= '<li>';
            $output .= '<label> ' . $languageCode . ':</label> ' . str_replace(array('langid', 'value=""'), array($languageCode, 'value="' . htmlspecialchars($value) . '"'), $translationValue);
          $output .= '</li>';
        }
      $output .= '</ul></span>';
    endif;


    return $output;
  }

  /* 3.3 EXPORT PAGE
  /------------------------*/
  function WPadmin_ConfiguratorImportExport(){
    if ( !current_user_can( 'page_configuration' ) )  {
      wp_die( __( 'You do not have sufficient permissions to access this page.', 'devTheme' ) );
    }
    // vars
    $output = '';
    // output
    $output .= '<div class="wrap" id="configurationImportExport">';
      $output .= '<h1 class="wp-heading-inline">' . __('Export page','devTheme') . '</h1>';
      $output .= '<span id="config-message"></span>';
      $output .= '<h2>' . __('Export options','devTheme') . '</h2>';
      $output .= '<button class="page-title-action ajax-action" data-action="ExportConfigSettings">' . __('Download configuration settings','devTheme') . '</button>';
      $output .= '<br><button class="page-title-action ajax-action" data-action="ExportCustomizerSettings">' . __('Download customizer settings','devTheme') . '</button>';
      $output .= '<br><button class="page-title-action ajax-action" data-action="GenerateCssFile">' . __('Download css file','devTheme') . '</button>';
      $output .= '<br><br><h2>' . __('Import configuration','devTheme') . '</h2>';
      $output .= '<form>';
        $output .= '<input type="file" accept="application/json" name="uploadFile">';
        $output .= '<input type="submit" class="button button-primary" data-action="uploadConfigurationSettings" value="' . __( 'Upload', 'devTheme' ) . '">';
      $output .= '</form>';
      $output .= '<br><br><h2>' . __('Import customizer','devTheme') . '</h2>';
      $output .= '<form>';
        $output .= '<input type="file" accept="application/json" name="uploadFile">';
        $output .= '<input type="submit" class="button button-primary" data-action="uploadCustomizerSettings" value="' . __( 'Upload', 'devTheme' ) . '">';
      $output .= '</form>';
    $output .= '</div>';
    echo $output;
  }

}
