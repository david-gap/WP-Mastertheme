<?php
/**
 *
 *
 * Customizer extension
 * Author:      David Voglgsnag
 * @version     1.1
 *
 */

 /*=======================================================
 Table of Contents:
 ---------------------------------------------------------
 1.0 INIT & VARS
   1.1 CONFIGURATION
   1.2 ON LOAD RUN
   1.3 EXTEND CUSTOMIZER
 2.0 FUNCTIONS
   2.1 ENQUEUE SCRIPTS/STYLES
   2.2 GENERATE THE CUSTOMIZER FILE
 3.0 OUTPUT
   3.1 PREVIEW CUSTOMIZER CHANGES
 =======================================================*/


class prefix_core_Customizer {

  /*==================================================================================
    1.0 INIT & VARS
  ==================================================================================*/

  /* 1.1 CONFIGURATION
  /------------------------*/
  /**
    * default vars
    *'key' => array(
    *  'label' => 'Label',
    *  'type' => 'input',
    *  'default' => '1'
    *)
  */
  private $defaultValues = array (
    'theme_sizes' => array (
      'label' => 'Template sizes',
      'values' => array(
        'container__width' => array(
          'label' => 'Container width',
          'type' => 'input',
          'default' => '1000px'
        ),
        'container__side' => array(
          'label' => 'Container side padding',
          'type' => 'input',
          'default' => '40px'
        ),
        'content__space' => array(
          'label' => 'Content spacing',
          'type' => 'input',
          'default' => '20px'
        ),
        'input__padding' => array(
          'label' => 'Input padding',
          'type' => 'input',
          'default' => '7px 10px'
        ),
        'wide__left' => array(
          'label' => 'Align wide left',
          'type' => 'input',
          'default' => '200px'
        ),
        'wide__right' => array(
          'label' => 'Align wide right',
          'type' => 'input',
          'default' => '200px'
        ),
        'html__anchor' => array(
          'label' => 'Anchor position',
          'type' => 'input',
          'default' => '100px'
        ),
        'mobile_breakpoint' => array(
          'label' => 'Breakpoint (mobile)',
          'type' => 'input',
          'default' => '768px'
        ),
        'html__anchor_mobile' => array(
          'label' => 'Anchor position (mobile)',
          'type' => 'input',
          'default' => '120px'
        ),
        'content__space_mobile' => array(
          'label' => 'Content spacing (mobile)',
          'type' => 'input',
          'default' => '20px'
        )
      )
    ),
    'theme_fonts' => array (
      'label' => 'Fonts',
      'values' => array(
        'html__fontfamily' => array(
          'label' => 'Main font family',
          'type' => 'input',
          'default' => 'sans-serif'
        ),
        'html__fontsize' => array(
          'label' => 'Main font size',
          'type' => 'input',
          'default' => '12px'
        ),
        'html__lineheight' => array(
          'label' => 'Main line height',
          'type' => 'input',
          'default' => '1.4'
        ),
        'html__mobile_fontsize' => array(
          'label' => 'Main font size (mobile)',
          'type' => 'input',
          'default' => '14px'
        ),
        'html__mobile_lineheight' => array(
          'label' => 'Main line height (mobile)',
          'type' => 'input',
          'default' => '1.3'
        ),
        'gutenberg__font_scale' => array(
          'label' => 'Gutenberg font scaling (mobile)',
          'type' => 'input',
          'default' => '.55'
        ),
        'mnav__fontsize' => array(
          'label' => 'Main menu font size',
          'type' => 'input',
          'default' => '100%'
        ),
        'mnav__lineheight' => array(
          'label' => 'Main menu line height',
          'type' => 'input',
          'default' => '1.4'
        ),
        'mnav__mobile_fontsize' => array(
          'label' => 'Main menu font size (mobile)',
          'type' => 'input',
          'default' => '120%'
        ),
        'mnav__mobile_lineheight' => array(
          'label' => 'Main menu line height (mobile)',
          'type' => 'input',
          'default' => '1.3'
        ),
        'footer__fontsize' => array(
          'label' => 'Footer font size',
          'type' => 'input',
          'default' => '10px'
        ),
        'footer__lineheight' => array(
          'label' => 'Footer line height',
          'type' => 'input',
          'default' => '1.7'
        )
      )
    ),
    'theme_colors' => array (
      'label' => 'Colors',
      'values' => array(
        'color__main' => array(
          'label' => 'Main color',
          'type' => 'color',
          'default' => '#0175bc'
        ),
        'color__secondary' => array(
          'label' => 'Scondary color',
          'type' => 'color',
          'default' => '#89c0ff'
        ),
        'light__hamburger_color' => array(
          'label' => 'Hamburger color',
          'type' => 'color',
          'default' => '#000'
        ),
        'light__main_background' => array(
          'label' => 'Background color',
          'type' => 'color',
          'default' => '#f9f9f9'
        ),
        'light__main_color' => array(
          'label' => 'Font color',
          'type' => 'color',
          'default' => '#343434'
        ),
        'light__header_background' => array(
          'label' => 'Header background color',
          'type' => 'color',
          'default' => '#f9f9f9'
        ),
        'light__headercontainer_background' => array(
          'label' => 'Header container background color',
          'type' => 'color',
          'default' => '#f9f9f9'
        ),
        'light__mnav_background' => array(
          'label' => 'Hamburger navigation background color',
          'type' => 'color',
          'default' => '#f9f9f9'
        ),
        'light__footer_background' => array(
          'label' => 'Footer background color',
          'type' => 'color',
          'default' => '#f9f9f9'
        ),
        'light__footercontainer_background' => array(
          'label' => 'Footer container background color',
          'type' => 'color',
          'default' => '#f9f9f9'
        ),
        'dark__hamburger_color' => array(
          'label' => 'Hamburger color (dark)',
          'type' => 'color',
          'default' => '#fff'
        ),
        'dark__main_background' => array(
          'label' => 'Background color (dark)',
          'type' => 'color',
          'default' => '#1d1e1f'
        ),
        'dark__main_color' => array(
          'label' => 'Font color (dark)',
          'type' => 'color',
          'default' => '#c7cacc'
        ),
        'dark__header_background' => array(
          'label' => 'Header background (dark)',
          'type' => 'color',
          'default' => '#1d1e1f'
        ),
        'dark__headercontainer_background' => array(
          'label' => 'header container background (dark)',
          'type' => 'color',
          'default' => '#1d1e1f'
        ),
        'dark__mnav_background' => array(
          'label' => 'Hamburger navigation background color (dark)',
          'type' => 'color',
          'default' => '#1d1e1f'
        ),
        'dark__footer_background' => array(
          'label' => 'Footer background (dark)',
          'type' => 'color',
          'default' => '#1d1e1f'
        ),
        'dark__footercontainer_background' => array(
          'label' => 'Footer container background (dark)',
          'type' => 'color',
          'default' => '#1d1e1f'
        )
      )
    ),
    'theme_popup' => array (
      'label' => 'Lightbox',
      'values' => array(
        'popup__width' => array(
          'label' => 'Lightbox width',
          'type' => 'input',
          'default' => '800px'
        ),
        'popup__space' => array(
          'label' => 'Lightbox container padding',
          'type' => 'input',
          'default' => '40px'
        ),
        'popup_prev_visible' => array(
          'label' => 'Lightbox preview visibility',
          'type' => 'input',
          'default' => '30px'
        )
      )
    )
  );


  /* 1.2 ON LOAD RUN
  /------------------------*/
  public function __construct() {
    // add customizer extensitions
    add_action( 'customize_register', array($this, 'extendCustomizer') );
    // frontend css/js files
    add_action('wp_enqueue_scripts', array( $this, 'customizerEnqueue' ));
    // add preview css to customizer
    add_action( 'customize_preview_init', array($this, 'customizerPreview') );
    // create new customizer file after saving customizer
    add_action( 'customize_save_after', array($this, 'generateCusomizerFile') );
    // register strings
    $backendStrings = array(
      __('Label', 'devTheme'),
      __('Template sizes', 'devTheme'),
      __('Container width', 'devTheme'),
      __('Container side padding', 'devTheme'),
      __('Content spacing', 'devTheme'),
      __('Input padding', 'devTheme'),
      __('Align wide left', 'devTheme'),
      __('Align wide right', 'devTheme'),
      __('Anchor position', 'devTheme'),
      __('Breakpoint (mobile)', 'devTheme'),
      __('Anchor position (mobile)', 'devTheme'),
      __('Content spacing (mobile)', 'devTheme'),
      __('Fonts', 'devTheme'),
      __('Main font family', 'devTheme'),
      __('Main font size', 'devTheme'),
      __('Main line height', 'devTheme'),
      __('Main font size (mobile)', 'devTheme'),
      __('Main line height (mobile)', 'devTheme'),
      __('Gutenberg font scaling (mobile)', 'devTheme'),
      __('Main menu font size', 'devTheme'),
      __('Main menu line height', 'devTheme'),
      __('Main menu font size (mobile)', 'devTheme'),
      __('Main menu line height (mobile)', 'devTheme'),
      __('Footer font size', 'devTheme'),
      __('Footer line height', 'devTheme'),
      __('Colors', 'devTheme'),
      __('Main color', 'devTheme'),
      __('Scondary color', 'devTheme'),
      __('Hamburger color', 'devTheme'),
      __('Background color', 'devTheme'),
      __('Font color', 'devTheme'),
      __('Header background color', 'devTheme'),
      __('Header container background color', 'devTheme'),
      __('Hamburger navigation background color', 'devTheme'),
      __('Footer background color', 'devTheme'),
      __('Footer container background color', 'devTheme'),
      __('Hamburger color (dark)', 'devTheme'),
      __('Background color (dark)', 'devTheme'),
      __('Font color (dark)', 'devTheme'),
      __('Header background (dark)', 'devTheme'),
      __('header container background (dark)', 'devTheme'),
      __('Hamburger navigation background color (dark)', 'devTheme'),
      __('Footer background (dark)', 'devTheme'),
      __('Footer container background (dark)', 'devTheme'),
      __('Lightbox', 'devTheme'),
      __('Lightbox width', 'devTheme'),
      __('Lightbox container padding', 'devTheme'),
      __('Lightbox preview visibility', 'devTheme')
    );
  }


  /* 1.3 EXTEND CUSTOMIZER
  /------------------------*/
  function extendCustomizer( $wp_customize ) {
    // call default vars
    foreach ($this->defaultValues as $sectionKey => $sectionValues) {
      // add layout options section.
      $wp_customize->add_section( $sectionKey, array(
        'title'    => __( $sectionValues["label"], 'customizer' ),
        'priority' => 120,
      ) );
      // build values
      foreach ($sectionValues["values"] as $valueKey => $ValueSettings) {
          // add featured category settings and controls.
          // https://developer.wordpress.org/reference/classes/wp_customize_control/__construct/
          if($ValueSettings["type"] == 'color'):
            $wp_customize->add_setting($valueKey, array(
              'transport'         => 'refresh',
              'default'           => $ValueSettings["default"],
              'sanitize_callback' => 'sanitize_hex_color',
            ));
            $wp_customize->add_control(new WP_Customize_Color_Control( $wp_customize, $valueKey, array(
             'label'    => __( $ValueSettings["label"], 'customizer' ),
             'section'  => $sectionKey,
             'priority' => 1
           )));
          else:
            $wp_customize->add_setting($valueKey, array(
              'transport'         => 'refresh',
              'default'           => $ValueSettings["default"],
              'sanitize_callback' => 'wp_filter_nohtml_kses',
            ));
           $wp_customize->add_control($valueKey, array(
            'label'    => __( $ValueSettings["label"], 'customizer' ),
            'section'  => $sectionKey,
            'type'     => 'input',
            'priority' => 1
           ));
          endif;
      }
    }
  }



  /*==================================================================================
    2.0 FUNCTIONS
  ==================================================================================*/

  /* 2.1 ENQUEUE SCRIPTS/STYLES
  /------------------------*/
  function customizerEnqueue() {
    wp_enqueue_style('theme/customizer', get_stylesheet_directory_uri() . '/customizer.css', false, "0." . time());
  }


  /* 2.2 GENERATE THE CUSTOMIZER FILE
  /------------------------*/
  function generateCusomizerFile() {
    // ob_start();
    // require(get_template_directory() . "/dist/responsive_contentW.css");
    // $output .= ob_get_clean();
    // ob_end_flush();

    // do math for master theme responsive file
    $get_mobile_breakpoint = preg_split('/(?<=[0-9])(?=[a-z]+)/i',get_theme_mod('mobile_breakpoint', $this->defaultValues['theme_sizes']['values']['mobile_breakpoint']['default']));
    $mobile_breakpoint = $get_mobile_breakpoint[0] - 1;
    $container_width = preg_split('/(?<=[0-9])(?=[a-z]+)/i',get_theme_mod('container__width', $this->defaultValues['theme_sizes']['values']['container__width']['default']));
    $wide_left = preg_split('/(?<=[0-9])(?=[a-z]+)/i',get_theme_mod('wide__left', $this->defaultValues['theme_sizes']['values']['wide__left']['default']));
    $wide_right = preg_split('/(?<=[0-9])(?=[a-z]+)/i',get_theme_mod('wide__right', $this->defaultValues['theme_sizes']['values']['wide__right']['default']));
    $wide_reset = $container_width[0] + $wide_left[0] + $wide_right[0];
    $popup_width = preg_split('/(?<=[0-9])(?=[a-z]+)/i',get_theme_mod('popup__width', $this->defaultValues['theme_popup']['values']['popup__width']['default']));
    $popup_space = preg_split('/(?<=[0-9])(?=[a-z]+)/i',get_theme_mod('popup__space', $this->defaultValues['theme_popup']['values']['popup__space']['default']));
    $popup_breakpoint = $popup_width[0] + $popup_space[0] + $popup_space[0];
    // build new file content
    $mobileOutput = '';
    $output = '';
    $output .= ':root {';
      foreach ($this->defaultValues as $sectionKey => $sectionValues) {
        foreach ($sectionValues["values"] as $valueKey => $ValueSettings) {
          if (strpos($valueKey, '_mobile') !== false):
            $output .= '--' . $valueKey . ': ' . get_theme_mod($valueKey, $ValueSettings["default"]) . ';';
          else:
            // move to mobile
            $mobileOutput .= '--' . str_replace('_mobile', '', $valueKey) . ': ' . get_theme_mod($valueKey, $ValueSettings["default"]) . ';';
          endif;
        }
      }
    $output .= '}';
    // wide
    $output .= '@media screen and (min-width: ' . $wide_reset . $container_width[1] . ') {';
      if(file_exists(get_template_directory() . "/dist/responsive_wideW.css")):
        $output .= file_get_contents(get_template_directory() . "/dist/responsive_wideW.css");
      endif;
    $output .= '}';
    // container
    $output .= '@media screen and (max-width: ' . $container_width[0] . $container_width[1] . ') {';
      if(file_exists(get_template_directory() . "/dist/responsive_contentW.css")):
        $output .= file_get_contents(get_template_directory() . "/dist/responsive_contentW.css");
      endif;
    $output .= '}';
    // popup/lightbox
    $output .= '@media screen and (max-width: ' . $popup_breakpoint . $popup_breakpoint[1] . ') {';
      if(file_exists(get_template_directory() . "/dist/responsive_popup.css")):
        $output .= file_get_contents(get_template_directory() . "/dist/responsive_popup.css");
      endif;
    $output .= '}';
    // desktop
    $output .= '@media screen and (min-width: ' . $get_mobile_breakpoint[0] . $get_mobile_breakpoint[1] . ') {';
      if(file_exists(get_template_directory() . "/dist/responsive_desktop.css")):
        $output .= file_get_contents(get_template_directory() . "/dist/responsive_desktop.css");
      endif;
    $output .= '}';
    // mobile
    $output .= '@media screen and (max-width: ' . $mobile_breakpoint . $get_mobile_breakpoint[1] . ') {';
      if($mobileOutput !== ''):
        $output .= ':root {';
          $output .= $mobileOutput;
        $output .= '}';
      endif;
      if(file_exists(get_template_directory() . "/dist/responsive_mobile.css")):
        $output .= file_get_contents(get_template_directory() . "/dist/responsive_mobile.css");
      endif;
    $output .= '}';

    // root directories
    $uploads = wp_upload_dir();
    $css_dir = get_stylesheet_directory() . '/';
    // directory depends on multisite
    if(is_multisite()):
        $aq_uploads_dir = trailingslashit($uploads['basedir']);
    else:
        $aq_uploads_dir = $css_dir;
    endif;
    // initialise wordpress filesystem
    global $wp_filesystem;
    if (empty($wp_filesystem)) {
        require_once(ABSPATH .'/wp-admin/includes/file.php');
        WP_Filesystem();
    }
    // save file
    if ( ! $wp_filesystem->put_contents( $aq_uploads_dir . 'customizer.css', $output, FS_CHMOD_FILE) ) {
        return true;
    }
  }



  /*==================================================================================
    3.0 OUTPUT
  ==================================================================================*/

  /* 3.1 PREVIEW CUSTOMIZER CHANGES
  /------------------------*/
  function customizerPreview() {
    wp_enqueue_script('theme/customizer', get_template_directory_uri() . '/classes/prefix_core_Customizer/assets/theme-customizer.js', array( 'jquery', 'customize-preview' ), '0.1', true);
  }

}
