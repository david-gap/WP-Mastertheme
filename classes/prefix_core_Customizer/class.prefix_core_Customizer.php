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
  private $tree = array(
    'key' => array(
      'label' => 'Label',
      'panels' => array(
        'label' => 'Label',
      ),
      'sections' => array(
        'label' => 'Label',
      ),
      'inputs' => array(
        'key' => array(
          'label' => 'Label',
          'type' => 'input',
          'default' => '1'
        )
      )
    )
  );

  private $defaultValues = array(
    'settings' => array(
      'label' => 'Settings',
      'sections' => array(
        'container' => array(
          'label' => 'Container',
          'inputs' => array(
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
            'mobile_breakpoint' => array(
              'label' => 'Breakpoint to mobile',
              'type' => 'input',
              'default' => '768px'
            )
          )
        ),
        'coloring' => array(
          'label' => 'Main colors',
          'inputs' => array(
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
            'light__main_color' => array(
              'label' => 'Font color',
              'type' => 'color',
              'default' => '#343434'
            ),
            'light__main_background' => array(
              'label' => 'Background color',
              'type' => 'color',
              'default' => '#f9f9f9'
            ),
            'dark__main_background' => array(
              'label' => 'Background color (dark mode)',
              'type' => 'color',
              'default' => '#1d1e1f'
            ),
            'dark__main_color' => array(
              'label' => 'Font color (dark mode)',
              'type' => 'color',
              'default' => '#c7cacc'
            ),
            'text__marked' => array(
              'label' => 'Marker text color',
              'type' => 'color',
              'default' => '#ffffff'
            ),
            'text__marked_bg' => array(
              'label' => 'Marker background color',
              'type' => 'color',
              'default' => '#0175bc'
            )
          )
        ),
        'desktop' => array(
          'label' => 'Desktop',
          'inputs' => array(
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
            )
          )
        ),
        'mobile' => array(
          'label' => 'Mobile',
          'inputs' => array(
            'html__fontsize_mobile' => array(
              'label' => 'Main font size',
              'type' => 'input',
              'default' => '14px'
            ),
            'html__lineheight_mobile' => array(
              'label' => 'Main line height',
              'type' => 'input',
              'default' => '1.3'
            ),
            'gutenberg__font_scale' => array(
              'label' => 'Gutenberg font scaling',
              'type' => 'input',
              'default' => '.55'
            )
          )
        ),
        'theme_popup' => array (
          'label' => 'Lightbox',
          'inputs' => array(
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
      )
    ),
    'header' => array(
      'label' => 'Header',
      'sections' => array(
        'header_coloring' => array(
          'label' => 'Colors',
          'inputs' => array(
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
            'dark__header_background' => array(
              'label' => 'Header background (dark mode)',
              'type' => 'color',
              'default' => '#1d1e1f'
            ),
            'dark__headercontainer_background' => array(
              'label' => 'header container background (dark mode)',
              'type' => 'color',
              'default' => '#1d1e1f'
            )
          )
        ),
        'header_menu' => array(
          'label' => 'Menu',
          'inputs' => array(
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
            'mnav__fontsize_mobile' => array(
              'label' => 'Main menu font size (mobile)',
              'type' => 'input',
              'default' => '120%'
            ),
            'mnav__lineheight_mobile' => array(
              'label' => 'Main menu line height (mobile)',
              'type' => 'input',
              'default' => '1.3'
            )
          )
        ),
        'hamburger' => array(
          'label' => 'Hamburger',
          'inputs' => array(
            'light__hamburger_color' => array(
              'label' => 'Hamburger color',
              'type' => 'color',
              'default' => '#000'
            ),
            'light__mnav_background' => array(
              'label' => 'Hamburger navigation background color',
              'type' => 'color',
              'default' => '#f9f9f9'
            ),
            'dark__hamburger_color' => array(
              'label' => 'Hamburger color (dark mode)',
              'type' => 'color',
              'default' => '#fff'
            ),
            'dark__mnav_background' => array(
              'label' => 'Hamburger navigation background color (dark mode)',
              'type' => 'color',
              'default' => '#1d1e1f'
            ),
            'content__blur_activemenu' => array(
              'label' => 'Blur Content while hamburger navigation is open',
              'type' => 'input',
              'default' => '0px'
            )
          )
        )
      )
    ),
    'main' => array (
      'label' => 'Content area',
      'sections' => array(
        'main_desktop' => array(
          'label' => 'Desktop',
          'inputs' => array(
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
            'html__anchor' => array(
              'label' => 'Anchor position',
              'type' => 'input',
              'default' => '100px'
            )
          )
        ),
        'main_mobile' => array(
          'label' => 'Mobile',
          'inputs' => array(
            'content__space_mobile' => array(
              'label' => 'Content spacing',
              'type' => 'input',
              'default' => '20px'
            ),
            'input__padding_mobile' => array(
              'label' => 'Input padding',
              'type' => 'input',
              'default' => '7px 10px'
            ),
            'html__anchor_mobile' => array(
              'label' => 'Anchor position',
              'type' => 'input',
              'default' => '120px'
            )
          )
        )
      )
    ),
    'gutenberg' => array(
      'label' => 'Gutenberg Blocks',
      'sections' => array(
        'gutenberg_seperator' => array(
          'label' => 'Seperator',
          'inputs' => array(
            'light__gbSeperator_color' => array(
              'label' => 'Default color',
              'type' => 'color',
              'default' => '#dddddd'
            ),
            'dark__gbSeperator_color' => array(
              'label' => 'Default color (dark mode)',
              'type' => 'color',
              'default' => '#343434'
            )
          )
        ),
        'gutenberg_accordion' => array(
          'label' => 'Accordion',
          'inputs' => array(
            'block__accordion_label_bg' => array(
              'label' => 'Label background color',
              'type' => 'color',
              'default' => '0175bc'
            ),
            'block__accordion_label' => array(
              'label' => 'Label text color',
              'type' => 'color',
              'default' => 'ffffff'
            ),
            'block__accordion_label_spacing' => array(
              'label' => 'Space inside label',
              'type' => 'input',
              'default' => '20px 10px'
            ),
            'block__accordion_label_fontsize' => array(
              'label' => 'Label font-size',
              'type' => 'input',
              'default' => 'inherit'
            ),
            'block__accordion_label_lineheight' => array(
              'label' => 'Label line-height',
              'type' => 'input',
              'default' => 'inherit'
            ),
            'block__accordion_iconbox_bg' => array(
              'label' => 'Iconbox background color',
              'type' => 'color',
              'default' => '000000'
            ),
            'block__accordion_icon_borderRadius' => array(
              'label' => 'Iconbox radius',
              'type' => 'input',
              'default' => '4px'
            ),
            'block__accordion_icon_width' => array(
              'label' => 'Iconbox width',
              'type' => 'input',
              'default' => '30px'
            ),
            'block__accordion_icon_height' => array(
              'label' => 'Iconbox height',
              'type' => 'input',
              'default' => '30px'
            ),
            'block__accordion_icon_seperator' => array(
              'label' => 'Placeholder between text and icon',
              'type' => 'input',
              'default' => '20px'
            ),
            'block__accordion_label_arrow' => array(
              'label' => 'Plus sign color',
              'type' => 'color',
              'default' => '89c0ff'
            ),
            'block__accordion_icon_plusSize' => array(
              'label' => 'Plus sign size',
              'type' => 'input',
              'default' => '50%'
            ),
            'block__accordion_icon_plusRadius' => array(
              'label' => 'Plus sign radius',
              'type' => 'input',
              'default' => '1px'
            ),
            'block__accordion_icon_plusWeight' => array(
              'label' => 'Plus sign weight',
              'type' => 'input',
              'default' => '4px'
            ),
            'block__accordion_content_bg' => array(
              'label' => 'toggled content background color',
              'type' => 'color',
              'default' => 'ffffff'
            ),
            'block__accordion_content' => array(
              'label' => 'toggled content text color',
              'type' => 'color',
              'default' => '000000'
            ),
            'block__accordion_content_spacing' => array(
              'label' => 'Space inside toggled content',
              'type' => 'input',
              'default' => '20px 10px'
            ),
            'block__accordion_content_fontsize' => array(
              'label' => 'Content font-size',
              'type' => 'input',
              'default' => 'inherit'
            ),
            'block__accordion_content_lineheight' => array(
              'label' => 'Content line-height',
              'type' => 'input',
              'default' => 'inherit'
            )
          )
        )
      )
    ),
    'footer' => array(
      'label' => 'Footer',
      'sections' => array(
        'footer_colors' => array(
          'label' => 'Colors',
          'inputs' => array(
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
            'dark__footer_background' => array(
              'label' => 'Footer background (dark mode)',
              'type' => 'color',
              'default' => '#1d1e1f'
            ),
            'dark__footercontainer_background' => array(
              'label' => 'Footer container background (dark mode)',
              'type' => 'color',
              'default' => '#1d1e1f'
            )
          )
        ),
        'footer_desktop' => array(
          'label' => 'Desktop',
          'inputs' => array(
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
        'footer_mobile' => array(
          'label' => 'Mobile',
          'inputs' => array(
            'footer__fontsize_mobile' => array(
              'label' => 'Footer font size',
              'type' => 'input',
              'default' => '10px'
            ),
            'footer__lineheight_mobile' => array(
              'label' => 'Footer line height',
              'type' => 'input',
              'default' => '1.7'
            )
          )
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
      __('Settings', 'devTheme'),
      __('Container', 'devTheme'),
      __('Container width', 'devTheme'),
      __('Container side padding', 'devTheme'),
      __('Align wide left', 'devTheme'),
      __('Align wide right', 'devTheme'),
      __('Breakpoint to mobile', 'devTheme'),
      __('Main colors', 'devTheme'),
      __('Main color', 'devTheme'),
      __('Scondary color', 'devTheme'),
      __('Font color', 'devTheme'),
      __('Background color', 'devTheme'),
      __('Background color (dark mode)', 'devTheme'),
      __('Font color (dark mode)', 'devTheme'),
      __('Marker text color', 'devTheme'),
      __('Marker background color', 'devTheme'),
      __('Desktop', 'devTheme'),
      __('Main font family', 'devTheme'),
      __('Main font size', 'devTheme'),
      __('Main line height', 'devTheme'),
      __('Mobile', 'devTheme'),
      __('Main font size', 'devTheme'),
      __('Main line height', 'devTheme'),
      __('Gutenberg font scaling', 'devTheme'),
      __('Lightbox', 'devTheme'),
      __('Lightbox width', 'devTheme'),
      __('Lightbox container padding', 'devTheme'),
      __('Lightbox preview visibility', 'devTheme'),
      __('Header', 'devTheme'),
      __('Colors', 'devTheme'),
      __('Header background color', 'devTheme'),
      __('Header container background color', 'devTheme'),
      __('Header background (dark mode)', 'devTheme'),
      __('header container background (dark mode)', 'devTheme'),
      __('Menu', 'devTheme'),
      __('Main menu font size', 'devTheme'),
      __('Main menu line height', 'devTheme'),
      __('Main menu font size (mobile)', 'devTheme'),
      __('Main menu line height (mobile)', 'devTheme'),
      __('Hamburger', 'devTheme'),
      __('Hamburger color', 'devTheme'),
      __('Hamburger navigation background color', 'devTheme'),
      __('Hamburger color (dark mode)', 'devTheme'),
      __('Hamburger navigation background color (dark mode)', 'devTheme'),
      __('Blur Content while hamburger navigation is open', 'devTheme'),
      __('Content area', 'devTheme'),
      __('Desktop', 'devTheme'),
      __('Content spacing', 'devTheme'),
      __('Input padding', 'devTheme'),
      __('Anchor position', 'devTheme'),
      __('Mobile', 'devTheme'),
      __('Content spacing', 'devTheme'),
      __('Input padding', 'devTheme'),
      __('Anchor position', 'devTheme'),
      __('Gutenberg Blocks', 'devTheme'),
      __('Seperator', 'devTheme'),
      __('Default color', 'devTheme'),
      __('Default color (dark mode)', 'devTheme'),
      __('Accordion', 'devTheme'),
      __('Label background color', 'devTheme'),
      __('Label text color', 'devTheme'),
      __('Space inside label', 'devTheme'),
      __('Label font-size', 'devTheme'),
      __('Label line-height', 'devTheme'),
      __('Iconbox background color', 'devTheme'),
      __('Iconbox radius', 'devTheme'),
      __('Iconbox width', 'devTheme'),
      __('Iconbox height', 'devTheme'),
      __('Placeholder between text and icon', 'devTheme'),
      __('Plus sign color', 'devTheme'),
      __('Plus sign size', 'devTheme'),
      __('Plus sign radius', 'devTheme'),
      __('Plus sign weight', 'devTheme'),
      __('toggled content background color', 'devTheme'),
      __('toggled content text color', 'devTheme'),
      __('Space inside toggled content', 'devTheme'),
      __('Content font-size', 'devTheme'),
      __('Content line-height', 'devTheme'),
      __('Footer', 'devTheme'),
      __('Colors', 'devTheme'),
      __('Footer background color', 'devTheme'),
      __('Footer container background color', 'devTheme'),
      __('Footer background (dark mode)', 'devTheme'),
      __('Footer container background (dark mode)', 'devTheme'),
      __('Desktop', 'devTheme'),
      __('Footer font size', 'devTheme'),
      __('Footer line height', 'devTheme'),
      __('Mobile', 'devTheme'),
      __('Footer font size', 'devTheme'),
      __('Footer line height', 'devTheme')
    );
  }


  /* 1.3 EXTEND CUSTOMIZER
  /------------------------*/
  function extendCustomizer( $wp_customize ) {

    foreach ($this->defaultValues as $panelKey => $panelValues) {
      SELF::buildPanel($wp_customize, $panelKey, $panelValues, '', 1);
    }

  }
  // build panal
  function buildPanel($wp_customize, $panelKey, $panelValues, $panalParent, $priority){
    // build panal
    if($panalParent !== ''):
      $wp_customize->add_panel($panelKey,
        array(
          'title' => $panelValues["label"],
          'priority' => $priority,
          'panel' => $panalParent
        )
      );
    else:
      $wp_customize->add_panel($panelKey,
        array(
          'title' => $panelValues["label"],
          'priority' => $priority
        )
      );
    endif;
    // add sub panals
    if(array_key_exists("panels",$panelValues)):
      $priority = $priority + 1;
      foreach ($panelValues["panels"] as $subpanelKey => $subpanelValues) {
        SELF::buildPanel($wp_customize, $subpanelKey, $subpanelValues, $panelKey, $priority);
      }
    endif;
    // add sections
    if(array_key_exists("sections",$panelValues)):
      foreach ($panelValues["sections"] as $sectionKey => $sectionValues) {
        SELF::buildSection($wp_customize, $sectionKey, $sectionValues, $panelKey);
      }
    endif;
    // add inputs
    // if(array_key_exists("inputs",$panelValues)):
    //   foreach ($panelValues["inputs"] as $inputKey => $inputValues) {
    //     SELF::buildInput($wp_customize, $inputKey, $inputValues, $panelKey);
    //   }
    // endif;
  }
  // build sections
  function buildSection($wp_customize, $sectionKey, $sectionValues, $panelKey){
    $wp_customize->add_section( $sectionKey, array(
      'title'    => __( $sectionValues["label"], 'customizer' ),
      'priority' => 120,
      'panel' => $panelKey
    ) );
    // add inputs
    if(array_key_exists("inputs",$sectionValues)):
      foreach ($sectionValues["inputs"] as $inputKey => $inputValues) {
        SELF::buildInput($wp_customize, $inputKey, $inputValues, $sectionKey);
      }
    endif;
  }
  // build input fields
  function buildInput($wp_customize, $inputKey, $inputValues, $sectionKey){
    // add featured category settings and controls.
    // https://developer.wordpress.org/reference/classes/wp_customize_control/__construct/
    if($inputValues["type"] == 'color'):
      $wp_customize->add_setting($inputKey, array(
        'transport'         => 'refresh',
        'default'           => $inputValues["default"],
        'sanitize_callback' => 'sanitize_hex_color',
      ));
      $wp_customize->add_control(new WP_Customize_Color_Control( $wp_customize, $inputKey, array(
       'label'    => __( $inputValues["label"], 'customizer' ),
       'section'  => $sectionKey,
       'priority' => 1
     )));
    else:
      $wp_customize->add_setting($inputKey, array(
        'transport'         => 'refresh',
        'default'           => $inputValues["default"],
        'sanitize_callback' => 'wp_filter_nohtml_kses',
      ));
     $wp_customize->add_control($inputKey, array(
      'label'    => __( $inputValues["label"], 'customizer' ),
      'section'  => $sectionKey,
      'type'     => 'input',
      'priority' => 1
     ));
    endif;
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
    $get_mobile_breakpoint = preg_split('/(?<=[0-9])(?=[a-z]+)/i',get_theme_mod('mobile_breakpoint', $this->defaultValues['settings']['sections']['container']['inputs']['mobile_breakpoint']['default']));
    $mobile_breakpoint = $get_mobile_breakpoint[0] - 1;
    $container_width = preg_split('/(?<=[0-9])(?=[a-z]+)/i',get_theme_mod('container__width', $this->defaultValues['settings']['sections']['container']['inputs']['container__width']['default']));
    $wide_left = preg_split('/(?<=[0-9])(?=[a-z]+)/i',get_theme_mod('wide__left', $this->defaultValues['settings']['sections']['container']['inputs']['wide__left']['default']));
    $wide_right = preg_split('/(?<=[0-9])(?=[a-z]+)/i',get_theme_mod('wide__right', $this->defaultValues['settings']['sections']['container']['inputs']['wide__right']['default']));
    $wide_reset = $container_width[0] + $wide_left[0] + $wide_right[0];
    $popup_width = preg_split('/(?<=[0-9])(?=[a-z]+)/i',get_theme_mod('popup__width', $this->defaultValues['settings']['sections']['theme_popup']['values']['popup__width']['default']));
    $popup_space = preg_split('/(?<=[0-9])(?=[a-z]+)/i',get_theme_mod('popup__space', $this->defaultValues['settings']['sections']['theme_popup']['values']['popup__space']['default']));
    $popup_breakpoint = $popup_width[0] + $popup_space[0] + $popup_space[0];
    // build new file content
    $mobileOutput = '';
    $output = '';
    $output .= ':root {';
      foreach ($this->defaultValues as $panelKey => $panelValues) {
        foreach ($panelValues["sections"] as $sectionKey => $sectionValues) {
          foreach ($sectionValues["inputs"] as $valueKey => $ValueSettings) {
            if (strpos($valueKey, '_mobile') !== false):
              $mobileOutput .= '--' . str_replace('_mobile', '', $valueKey) . ': ' . get_theme_mod($valueKey, $ValueSettings["default"]) . ';';
            else:
              // move to mobile
              $output .= '--' . $valueKey . ': ' . get_theme_mod($valueKey, $ValueSettings["default"]) . ';';
            endif;
          }
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
