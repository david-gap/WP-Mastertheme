<?php
/**
 *
 *
 * Customizer extension
 * Author:      David Voglgsnag
 * @version     1.4
 *
 */

 /*=======================================================
 Table of Contents:
 ---------------------------------------------------------
 1.0 INIT & VARS
   1.1 CONFIGURATION
   1.2 ON LOAD RUN
   1.3 EXTEND CUSTOMIZER
   1.4 THEME MOD UPDATE
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
            'main_color' => array(
              'label' => 'Font color',
              'type' => 'color',
              'default' => '#343434'
            ),
            'main_background' => array(
              'label' => 'Background color',
              'type' => 'color',
              'default' => '#f9f9f9'
            ),
            'dark__main_background' => array(
              'label' => 'Background color',
              'type' => 'color',
              'default' => '#1d1e1f'
            ),
            'dark__main_color' => array(
              'label' => 'Font color',
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
          'label' => 'Typography',
          'inputs' => array(
            'html__fontfamily' => array(
              'label' => 'Main font family',
              'type' => 'input'
            ),
            'html__fontsize' => array(
              'label' => 'Main font size',
              'type' => 'input'
            ),
            'html__lineheight' => array(
              'label' => 'Main line height',
              'type' => 'input'
            ),
            'html__fontweight' => array(
              'label' => 'Main font weight',
              'type' => 'input'
            ),
            'html__fontsize_small' => array(
              'label' => 'Small text size',
              'type' => 'input'
            ),
            'html__fontsize_subsup' => array(
              'label' => 'sub/sup text size',
              'type' => 'input'
            )
          )
        ),
        'mobile' => array(
          'label' => 'Mobile',
          'inputs' => array(
            'container__side_mobile' => array(
              'label' => 'Container side padding',
              'type' => 'input'
            ),
            'html__fontsize_mobile' => array(
              'label' => 'Main font size',
              'type' => 'input'
            ),
            'html__lineheight_mobile' => array(
              'label' => 'Main line height',
              'type' => 'input'
            ),
            'gutenberg__font_scale' => array(
              'label' => 'Gutenberg font scaling',
              'type' => 'input',
              'default' => '.55'
            ),
            'html__fontsize_small_mobile' => array(
              'label' => 'Small text size',
              'type' => 'input'
            ),
            'html__fontsize_subsup_mobile' => array(
              'label' => 'sub/sup text size',
              'type' => 'input'
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
            'header_background' => array(
              'label' => 'Header background color',
              'type' => 'color',
              'default' => '#f9f9f9'
            ),
            'headercontainer_background' => array(
              'label' => 'Header container background color',
              'type' => 'color',
              'default' => 'transparent'
            ),
            'dark__header_background' => array(
              'label' => 'Header background',
              'type' => 'color',
              'default' => '#1d1e1f'
            ),
            'dark__headercontainer_background' => array(
              'label' => 'header container background',
              'type' => 'color',
              'default' => 'transparent'
            )
          )
        ),
        'header_menu' => array(
          'label' => 'Menu',
          'inputs' => array(
            'mnav__ul_gap' => array(
              'label' => 'First level gap',
              'type' => 'input'
            ),
            'mnav__ul_paddingTop' => array(
              'label' => 'Padding top',
              'type' => 'input'
            ),
            'mnav__ul_paddingBottom' => array(
              'label' => 'Padding bottom',
              'type' => 'input'
            ),
            'mnav__ul_gap_mobile' => array(
              'label' => 'First level gap',
              'type' => 'input'
            ),
            'mnav__ul_paddingTop_mobile' => array(
              'label' => 'Padding top',
              'type' => 'input'
            ),
            'mnav__ul_paddingBottom_mobile' => array(
              'label' => 'Padding bottom',
              'type' => 'input'
            ),
            'mnav__ul_lastChild_marginBottom' => array(
              'label' => 'Last child margin bottom',
              'type' => 'input'
            ),
            'mnav__ul_lastChild_marginBottom_mobile' => array(
              'label' => 'Last child margin bottom',
              'type' => 'input'
            ),
            'submenu__toggle_width' => array(
              'label' => 'Toggle arrow container width',
              'type' => 'input'
            ),
            'submenu__toggle_strokeWidth' => array(
              'label' => 'Toggle arrow stroke width',
              'type' => 'input'
            ),
            'submenu__toggle_padding' => array(
              'label' => 'Toggle arrow container padding',
              'type' => 'input'
            ),
            'submenu__toggle_width_mobile' => array(
              'label' => 'Toggle arrow container width',
              'type' => 'input'
            ),
            'submenu__toggle_strokeWidth_mobile' => array(
              'label' => 'Toggle arrow stroke width',
              'type' => 'input'
            ),
            'submenu__toggle_padding_mobile' => array(
              'label' => 'Toggle arrow container padding',
              'type' => 'input'
            ),
            'mnav__color' => array(
              'label' => 'Color',
              'type' => 'color',
              'default' => '#000000'
            ),
            'mnav__background_color' => array(
              'label' => 'Background color',
              'type' => 'color',
              'default' => 'transparent'
            ),
            'mnav__color_hover' => array(
              'label' => 'Color (hover)',
              'type' => 'color',
              'default' => '#000000'
            ),
            'mnav__background_color_hover' => array(
              'label' => 'Background color (hover)',
              'type' => 'color',
              'default' => 'transparent'
            ),
            'mnav__color_active' => array(
              'label' => 'Color (active)',
              'type' => 'color',
              'default' => 'transparent'
            ),
            'mnav__background_color_active' => array(
              'label' => 'Background color (active)',
              'type' => 'color',
              'default' => 'transparent'
            ),
            'mnav__border_color' => array(
              'label' => 'Border color',
              'type' => 'color',
              'default' => 'transparent'
            ),
            'mnav__border_width' => array(
              'label' => 'Border width',
              'type' => 'input'
            ),
            'mnav__padding' => array(
              'label' => 'Padding',
              'type' => 'input'
            ),
            'mnav__margin' => array(
              'label' => 'Margin',
              'type' => 'input'
            ),
            'mnav__fontfamily' => array(
              'label' => 'Font family',
              'type' => 'input'
            ),
            'mnav__fontsize' => array(
              'label' => 'Font size',
              'type' => 'input'
            ),
            'mnav__fontWeight' => array(
              'label' => 'Font weight',
              'type' => 'input'
            ),
            'mnav__lineheight' => array(
              'label' => 'Line height',
              'type' => 'input'
            ),
            'mnav__textTransform' => array(
              'label' => 'Text transform',
              'type' => 'input'
            ),
            'mnav__letterSpacing' => array(
              'label' => 'Letter spacing',
              'type' => 'input'
            ),
            'mnav__border_width_mobile' => array(
              'label' => 'Border width',
              'type' => 'input'
            ),
            'mnav__fontsize_mobile' => array(
              'label' => 'Font size',
              'type' => 'input'
            ),
            'mnav__lineheight_mobile' => array(
              'label' => 'Line height',
              'type' => 'input'
            ),
            'mnav__padding_mobile' => array(
              'label' => 'Padding',
              'type' => 'input'
            ),
            'mnav__margin_mobile' => array(
              'label' => 'Margin',
              'type' => 'input'
            ),
            'mnav__sub_color' => array(
              'label' => 'Level 2 - color',
              'type' => 'color',
              'default' => '#000000'
            ),
            'mnav__sub_background_color' => array(
              'label' => 'Level 2 - background color',
              'type' => 'color',
              'default' => 'transparent'
            ),
            'mnav__sub_color_hover' => array(
              'label' => 'Level 2 - color (hover)',
              'type' => 'color',
              'default' => '#000000'
            ),
            'mnav__sub_background_color_hover' => array(
              'label' => 'Level 2 - background color (hover)',
              'type' => 'color',
              'default' => 'transparent'
            ),
            'mnav__sub_color_active' => array(
              'label' => 'Level 2 - color (active)',
              'type' => 'color',
              'default' => 'transparent'
            ),
            'mnav__sub_background_color_active' => array(
              'label' => 'Level 2 - background color (active)',
              'type' => 'color',
              'default' => 'transparent'
            ),
            'mnav__sub_border_color' => array(
              'label' => 'Level 2 - border color',
              'type' => 'color',
              'default' => 'transparent'
            ),
            'mnav__sub_border_width' => array(
              'label' => 'Level 2 - border width',
              'type' => 'input'
            ),
            'mnav__sub_padding' => array(
              'label' => 'Level 2 - padding',
              'type' => 'input'
            ),
            'mnav__sub_margin' => array(
              'label' => 'Level 2 - margin',
              'type' => 'input'
            ),
            'mnav__sub_fontfamily' => array(
              'label' => 'Level 2 - font family',
              'type' => 'input'
            ),
            'mnav__sub_fontsize' => array(
              'label' => 'Level 2 - font size',
              'type' => 'input'
            ),
            'mnav__sub_lineheight' => array(
              'label' => 'Level 2 - line height',
              'type' => 'input'
            ),
            'mnav__sub_fontWeight' => array(
              'label' => 'Level 2 - font weight',
              'type' => 'input'
            ),
            'mnav__sub_textTransform' => array(
              'label' => 'Level 2 - text transform',
              'type' => 'input'
            ),
            'mnav__sub_letterSpacing' => array(
              'label' => 'Level 2 - Letter spacing',
              'type' => 'input'
            ),
            'mnav__sub_border_width_mobile' => array(
              'label' => 'Level 2 - border width',
              'type' => 'input'
            ),
            'mnav__sub_fontsize_mobile' => array(
              'label' => 'Level 2 - font size',
              'type' => 'input'
            ),
            'mnav__sub_lineheight_mobile' => array(
              'label' => 'Level 2 - line height',
              'type' => 'input'
            ),
            'mnav__sub_padding_mobile' => array(
              'label' => 'Level 2 - padding',
              'type' => 'input'
            ),
            'mnav__sub_margin_mobile' => array(
              'label' => 'Level 2 - margin',
              'type' => 'input'
            ),
            'mnav__subSub_color' => array(
              'label' => 'Level 3 - color',
              'type' => 'color',
              'default' => '#000000'
            ),
            'mnav__subSub_background_color' => array(
              'label' => 'Level 3 - background color',
              'type' => 'color',
              'default' => 'transparent'
            ),
            'mnav__subSub_color_hover' => array(
              'label' => 'Level 3 - color (hover)',
              'type' => 'color',
              'default' => '#000000'
            ),
            'mnav__subSub_background_color_hover' => array(
              'label' => 'Level 3 - background color (hover)',
              'type' => 'color',
              'default' => 'transparent'
            ),
            'mnav__subSub_color_active' => array(
              'label' => 'Level 3 - color (active)',
              'type' => 'color',
              'default' => 'transparent'
            ),
            'mnav__subSub_background_color_active' => array(
              'label' => 'Level 3 - background color (active)',
              'type' => 'color',
              'default' => 'transparent'
            ),
            'mnav__subSub_border_color' => array(
              'label' => 'Level 3 - border color',
              'type' => 'color',
              'default' => 'transparent'
            ),
            'mnav__subSub_border_width' => array(
              'label' => 'Level 3 - border width',
              'type' => 'input'
            ),
            'mnav__subSub_padding' => array(
              'label' => 'Level 3 - padding',
              'type' => 'input'
            ),
            'mnav__subSub_margin' => array(
              'label' => 'Level 3 - margin',
              'type' => 'input'
            ),
            'mnav__subSub_fontfamily' => array(
              'label' => 'Level 3 - font family',
              'type' => 'input'
            ),
            'mnav__subSub_fontsize' => array(
              'label' => 'Level 3 - font size',
              'type' => 'input'
            ),
            'mnav__subSub_fontWeight' => array(
              'label' => 'Level 3 - font weight',
              'type' => 'input'
            ),
            'mnav__subSub_lineheight' => array(
              'label' => 'Level 3 - line height',
              'type' => 'input'
            ),
            'mnav__subSub_textTransform' => array(
              'label' => 'Level 3 - text transform',
              'type' => 'input'
            ),
            'mnav__subSub_letterSpacing' => array(
              'label' => 'Level 3 - Letter spacing',
              'type' => 'input'
            ),
            'mnav__subSub_border_width_mobile' => array(
              'label' => 'Level 3 - border width',
              'type' => 'input'
            ),
            'mnav__subSub_fontsize_mobile' => array(
              'label' => 'Level 3 - font size',
              'type' => 'input'
            ),
            'mnav__subSub_lineheight_mobile' => array(
              'label' => 'Level 3 - line height',
              'type' => 'input'
            ),
            'mnav__subSub_padding_mobile' => array(
              'label' => 'Level 3 - padding',
              'type' => 'input'
            ),
            'mnav__subSub_margin_mobile' => array(
              'label' => 'Level 3 - margin',
              'type' => 'input'
            ),
            'mnav__subSubSub_color' => array(
              'label' => 'Level 4 - color',
              'type' => 'color',
              'default' => '#000000'
            ),
            'mnav__subSubSub_background_color' => array(
              'label' => 'Level 4 - background color',
              'type' => 'color',
              'default' => 'transparent'
            ),
            'mnav__subSubSub_color_hover' => array(
              'label' => 'Level 4 - color (hover)',
              'type' => 'color',
              'default' => '#000000'
            ),
            'mnav__subSubSub_background_color_hover' => array(
              'label' => 'Level 4 - background color (hover)',
              'type' => 'color',
              'default' => 'transparent'
            ),
            'mnav__subSubSub_color_active' => array(
              'label' => 'Level 4 - color (active)',
              'type' => 'color',
              'default' => 'transparent'
            ),
            'mnav__subSubSub_background_color_active' => array(
              'label' => 'Level 4 - background color (active)',
              'type' => 'color',
              'default' => 'transparent'
            ),
            'mnav__subSubSub_border_color' => array(
              'label' => 'Level 4 - border color',
              'type' => 'color',
              'default' => 'transparent'
            ),
            'mnav__subSubSub_border_width' => array(
              'label' => 'Level 4 - border width',
              'type' => 'input'
            ),
            'mnav__subSubSub_padding' => array(
              'label' => 'Level 4 - padding',
              'type' => 'input'
            ),
            'mnav__subSubSub_margin' => array(
              'label' => 'Level 4 - margin',
              'type' => 'input'
            ),
            'mnav__subSubSub_fontfamily' => array(
              'label' => 'Level 4 - font family',
              'type' => 'input'
            ),
            'mnav__subSubSub_fontsize' => array(
              'label' => 'Level 4 - font size',
              'type' => 'input'
            ),
            'mnav__subSubSub_fontWeight' => array(
              'label' => 'Level 4 - font weight',
              'type' => 'input'
            ),
            'mnav__subSubSub_lineheight' => array(
              'label' => 'Level 4 - line height',
              'type' => 'input'
            ),
            'mnav__subSubSub_textTransform' => array(
              'label' => 'Level 4 - text transform',
              'type' => 'input'
            ),
            'mnav__subSubSub_letterSpacing' => array(
              'label' => 'Level 4 - Letsubter spacing',
              'type' => 'input'
            ),
            'mnav__subSubSub_border_width_mobile' => array(
              'label' => 'Level 4 - border width',
              'type' => 'input'
            ),
            'mnav__subSubSub_fontsize_mobile' => array(
              'label' => 'Level 4 - font size',
              'type' => 'input'
            ),
            'mnav__subSubSub_lineheight_mobile' => array(
              'label' => 'Level 4 - line height',
              'type' => 'input'
            ),
            'mnav__subSubSub_padding_mobile' => array(
              'label' => 'Level 4 - padding',
              'type' => 'input'
            ),
            'mnav__subSubSub_margin_mobile' => array(
              'label' => 'Level 4 - margin',
              'type' => 'input'
            )
          )
        ),
        'hamburger' => array(
          'label' => 'Hamburger',
          'inputs' => array(
            'hamburger__container_width' => array(
              'label' => 'Width',
              'type' => 'input'
            ),
            'hamburger__container_height' => array(
              'label' => 'Height',
              'type' => 'input'
            ),
            'hamburger__size' => array(
              'label' => 'Size',
              'type' => 'input'
            ),
            'hamburger_color' => array(
              'label' => 'Hamburger color',
              'type' => 'color',
              'default' => '#000000'
            ),
            'hamburger_text_color' => array(
              'label' => 'Hamburger text color',
              'type' => 'color'
            ),
            'mnav_background' => array(
              'label' => 'Hamburger navigation background color',
              'type' => 'color',
              'default' => '#f9f9f9'
            ),
            'dark__hamburger_color' => array(
              'label' => 'Hamburger color',
              'type' => 'color',
              'default' => '#ffffff'
            ),
            'dark__hamburger_text_color' => array(
              'label' => 'Hamburger text color',
              'type' => 'color'
            ),
            'dark__mnav_background' => array(
              'label' => 'Hamburger navigation background color',
              'type' => 'color',
              'default' => '#1d1e1f'
            ),
            'content__blur_activemenu' => array(
              'label' => 'Blur Content while hamburger navigation is open',
              'type' => 'input'
            ),
            'hamburger__title_space' => array(
              'label' => 'Title spacing',
              'type' => 'input'
            ),
            'hamburger__title_fontSize' => array(
              'label' => 'Title font size',
              'type' => 'input'
            ),
            'hamburger__title_LineHeight' => array(
              'label' => 'Title line height',
              'type' => 'input'
            ),
            'hamburger__title_fontWeight' => array(
              'label' => 'Title font weight',
              'type' => 'input'
            ),
            'hamburger__container_width_mobile' => array(
              'label' => 'Width',
              'type' => 'input'
            ),
            'hamburger__container_height_mobile' => array(
              'label' => 'Height',
              'type' => 'input'
            ),
            'hamburger__title_space_mobile' => array(
              'label' => 'Title spacing',
              'type' => 'input'
            ),
            'hamburger__title_fontSize_mobile' => array(
              'label' => 'Title font size',
              'type' => 'input'
            ),
            'hamburger__title_LineHeight_mobile' => array(
              'label' => 'Title line height',
              'type' => 'input'
            )
          )
        ),
        'header_desktop' => array(
          'label' => 'Desktop',
          'inputs' => array(
            'header__paddingTop' => array(
              'label' => 'Container padding top',
              'type' => 'input'
            ),
            'header__paddingBottom' => array(
              'label' => 'Container padding bottom',
              'type' => 'input'
            ),
            'header__negativTopPosition_sticky' => array(
              'label' => 'Top negativ position',
              'type' => 'input'
            ),
            'header__paddingTop_sticky' => array(
              'label' => 'Container padding top',
              'type' => 'input'
            ),
            'header__paddingBottom_sticky' => array(
              'label' => 'Container padding bottom',
              'type' => 'input'
            ),
            'header__itemSpacingHorizontal' => array(
              'label' => 'Vertical spacing between items',
              'type' => 'input'
            )
          )
        ),
        'header_mobile' => array(
          'label' => 'Mobile',
          'inputs' => array(
            'header__paddingTop_mobile' => array(
              'label' => 'Container padding top',
              'type' => 'input'
            ),
            'header__paddingBottom_mobile' => array(
              'label' => 'Container padding bottom',
              'type' => 'input'
            ),
            'header__negativTopPosition_sticky_mobile' => array(
              'label' => 'Top negativ position',
              'type' => 'input'
            ),
            'header__paddingTop_sticky_mobile' => array(
              'label' => 'Container padding top',
              'type' => 'input'
            ),
            'header__paddingBottom_sticky_mobile' => array(
              'label' => 'Container padding bottom',
              'type' => 'input'
            ),
            'header__itemSpacingHorizontal_mobile' => array(
              'label' => 'Vertical spacing between items',
              'type' => 'input'
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
              'type' => 'input'
            ),
            'content__space_one' => array(
              'label' => 'Override content spacing 1',
              'type' => 'input'
            ),
            'content__space_two' => array(
              'label' => 'Override content spacing 2',
              'type' => 'input'
            ),
            'content__space_last' => array(
              'label' => 'Content last spacing',
              'type' => 'input'
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
              'type' => 'input'
            ),
            'content__space_one_mobile' => array(
              'label' => 'Override content spacing 1',
              'type' => 'input'
            ),
            'content__space_two_mobile' => array(
              'label' => 'Override content spacing 2',
              'type' => 'input'
            ),
            'content__space_last_mobile' => array(
              'label' => 'Content last spacing',
              'type' => 'input'
            ),
            'html__anchor_mobile' => array(
              'label' => 'Anchor position',
              'type' => 'input',
              'default' => '120px'
            )
          )
        ),
        'mainSection' => array(
          'label' => 'Main section',
          'inputs' => array(
            'mainSection__bgColor' => array(
              'label' => 'Background color',
              'type' => 'color'
            ),
            'mainSection__marginTop' => array(
              'label' => 'Margin top',
              'type' => 'input'
            ),
            'mainSection__marginBottom' => array(
              'label' => 'Margin bottom',
              'type' => 'input'
            ),
            'mainSection__paddingTop' => array(
              'label' => 'Padding top',
              'type' => 'input'
            ),
            'mainSection__paddingBottom' => array(
              'label' => 'Padding bottom',
              'type' => 'input'
            ),
            'mainSection__marginTop_mobile' => array(
              'label' => 'Margin top',
              'type' => 'input'
            ),
            'mainSection__marginBottom_mobile' => array(
              'label' => 'Margin bottom',
              'type' => 'input'
            ),
            'mainSection__paddingTop_mobile' => array(
              'label' => 'Padding top',
              'type' => 'input'
            ),
            'mainSection__paddingBottom_mobile' => array(
              'label' => 'Padding bottom',
              'type' => 'input'
            )
          )
        ),
        'thumbnail' => array(
          'label' => 'Thumbnail',
          'inputs' => array(
            'thumbnail__height' => array(
              'label' => 'Height',
              'type' => 'input'
            ),
            'thumbnail__marginTop' => array(
              'label' => 'Margin top',
              'type' => 'input'
            ),
            'thumbnail__marginBottom' => array(
              'label' => 'Margin bottom',
              'type' => 'input'
            ),
            'thumbnail__height_mobile' => array(
              'label' => 'Height',
              'type' => 'input'
            ),
            'thumbnail__marginTop_mobile' => array(
              'label' => 'Margin top',
              'type' => 'input'
            ),
            'thumbnail__marginBottom_mobile' => array(
              'label' => 'Margin bottom',
              'type' => 'input'
            )
          )
        ),
        'breadcrumbs' => array(
          'label' => 'Breadcrumbs',
          'inputs' => array(
            'bc__color' => array(
              'label' => 'Color',
              'type' => 'color',
              'default' => 'inherit'
            ),
            'bc__background_color' => array(
              'label' => 'Background color',
              'type' => 'color',
              'default' => 'transparent'
            ),
            'bc__link_color' => array(
              'label' => 'Link color',
              'type' => 'color',
              'default' => 'inherit'
            ),
            'bc__link_color_hover' => array(
              'label' => 'Link color (hover)',
              'type' => 'color',
              'default' => 'inherit'
            ),
            'bc__color_active' => array(
              'label' => 'Color (active)',
              'type' => 'color',
              'default' => 'transparent'
            ),
            'bc__padding' => array(
              'label' => 'Padding',
              'type' => 'input'
            ),
            'bc__fontfamily' => array(
              'label' => 'Font family',
              'type' => 'input'
            ),
            'bc__fontsize' => array(
              'label' => 'Font size',
              'type' => 'input'
            ),
            'bc__fontWeight' => array(
              'label' => 'Font weight',
              'type' => 'input'
            ),
            'bc__lineheight' => array(
              'label' => 'Line height',
              'type' => 'input'
            ),
            'bc__textTransform' => array(
              'label' => 'Text transform',
              'type' => 'input'
            ),
            'bc__fontsize_mobile' => array(
              'label' => 'Font size',
              'type' => 'input'
            ),
            'bc__lineheight_mobile' => array(
              'label' => 'Line height',
              'type' => 'input'
            ),
            'bc__padding_mobile' => array(
              'label' => 'Padding',
              'type' => 'input'
            )
          )
        ),
        'languageswitcher' => array(
          'label' => 'Language switcher',
          'inputs' => array(
            'ls__background_color' => array(
              'label' => 'Background Image',
              'type' => 'color'
            ),
            'ls__color_active' => array(
              'label' => 'Active language color',
              'type' => 'color'
            ),
            'ls__link_color' => array(
              'label' => 'Link color',
              'type' => 'color'
            ),
            'ls__link_color_hover' => array(
              'label' => 'Link hover color',
              'type' => 'color'
            ),
            'ls__link_fontfamily' => array(
              'label' => 'Link font family',
              'type' => 'input'
            ),
            'ls__link_fontsize' => array(
              'label' => 'Link font size',
              'type' => 'input'
            ),
            'ls__link_lineheight' => array(
              'label' => 'Link line height',
              'type' => 'input'
            ),
            'ls__link_fontWeight' => array(
              'label' => 'Link font weight',
              'type' => 'input'
            ),
            'ls__link_textTransform' => array(
              'label' => 'Link text transform',
              'type' => 'input'
            ),
            'ls__link_letterSpacing' => array(
              'label' => 'Link letter spacing',
              'type' => 'input'
            ),
            'ls__link_margin' => array(
              'label' => 'Link margin',
              'type' => 'input'
            ),
            'ls__link_padding' => array(
              'label' => 'Link padding',
              'type' => 'input'
            ),
            'ls__link_fontsize_mobile' => array(
              'label' => 'Link font size',
              'type' => 'input'
            ),
            'ls__link_lineheight_mobile' => array(
              'label' => 'Link line height',
              'type' => 'input'
            ),
            'ls__link_margin_mobile' => array(
              'label' => 'Link margin',
              'type' => 'input'
            ),
            'ls__link_padding_mobile' => array(
              'label' => 'Link padding',
              'type' => 'input'
            ),
            'dark__ls__background_color' => array(
              'label' => 'Background Image',
              'type' => 'color'
            ),
            'dark__ls__color_active' => array(
              'label' => 'Active language color',
              'type' => 'color'
            ),
            'dark__ls__link_color' => array(
              'label' => 'Link color',
              'type' => 'color'
            ),
            'dark__ls__link_color_hover' => array(
              'label' => 'Link hover color',
              'type' => 'color'
            )
          )
        ),
        'inputs' => array(
          'label' => 'Input fields',
          'inputs' => array(
            'input__color' => array(
              'label' => 'Input color',
              'type' => 'color'
            ),
            'input__bg_color' => array(
              'label' => 'Input background color',
              'type' => 'color',
              'default' => '#ffffff'
            ),
            'input__border_width' => array(
              'label' => 'Input border width',
              'type' => 'input'
            ),
            'input__border_color' => array(
              'label' => 'Input border color',
              'type' => 'color',
              'default' => '#000000'
            ),
            'input__fontFamily' => array(
              'label' => 'Input font family',
              'type' => 'input'
            ),
            'input__fontSize' => array(
              'label' => 'Input font size',
              'type' => 'input'
            ),
            'input__lineHeight' => array(
              'label' => 'Input line height',
              'type' => 'input'
            ),
            'input__fontWeight' => array(
              'label' => 'Input font weight',
              'type' => 'input'
            ),
            'input__fontSize_mobile' => array(
              'label' => 'Input font size',
              'type' => 'input'
            ),
            'input__lineHeight_mobile' => array(
              'label' => 'Input line height',
              'type' => 'input'
            ),
            'input__borderRadius' => array(
              'label' => 'Input border radius',
              'type' => 'input'
            ),
            'input__padding' => array(
              'label' => 'Input padding',
              'type' => 'input'
            ),
            'input__padding_mobile' => array(
              'label' => 'Input padding mobile',
              'type' => 'input'
            ),
            'input__checkbox_bg' => array(
              'label' => 'Checkbox/Radio background color',
              'type' => 'color',
              'default' => '#ffffff'
            ),
            'input__checkbox_fontSize' => array(
              'label' => 'Checkbox/Radio font size',
              'type' => 'input'
            ),
            'input__checkbox_lineHeight' => array(
              'label' => 'Checkbox/Radio line height',
              'type' => 'input'
            ),
            'input__checkbox_fontWeight' => array(
              'label' => 'Checkbox/Radio font weight',
              'type' => 'input'
            ),
            'input__checkbox_fontSize_mobile' => array(
              'label' => 'Checkbox/Radio font size',
              'type' => 'input'
            ),
            'input__checkbox_lineHeight_mobile' => array(
              'label' => 'Checkbox/Radio line height',
              'type' => 'input'
            ),
            'input__checkbox_width' => array(
              'label' => 'Checkbox/Radio width/height',
              'type' => 'input'
            ),
            'input__checkbox_border_width' => array(
              'label' => 'Checkbox/Radio border',
              'type' => 'input'
            ),
            'input__checkbox_space' => array(
              'label' => 'Checkbox/Radio space to text',
              'type' => 'input'
            ),
            'input__checkbox_border_color' => array(
              'label' => 'Checkbox/Radio border color',
              'type' => 'color',
              'default' => '#0175bc'
            ),
            'input__checkbox_bg_checked' => array(
              'label' => 'Checkbox/Radio background color (checked)',
              'type' => 'color',
              'default' => '#0175bc'
            ),
            'input__select_bg_color' => array(
              'label' => 'Select background color',
              'type' => 'color'
            ),
            'input__select_color' => array(
              'label' => 'Select text color',
              'type' => 'color'
            ),
            'input__select_border_color' => array(
              'label' => 'Select border color',
              'type' => 'color'
            ),
            'input__select_padding' => array(
              'label' => 'Select padding',
              'type' => 'input'
            ),
            'input__select_border_width' => array(
              'label' => 'Select border width',
              'type' => 'input'
            ),
            'input__select_padding_mobile' => array(
              'label' => 'Select padding',
              'type' => 'input'
            ),
            'input__select_fontFamily' => array(
              'label' => 'Input font family',
              'type' => 'input'
            ),
            'input__select_fontSize' => array(
              'label' => 'Select font size',
              'type' => 'input'
            ),
            'input__select_lineHeight' => array(
              'label' => 'Select line height',
              'type' => 'input'
            ),
            'input__select_fontWeight' => array(
              'label' => 'Select font weight',
              'type' => 'input'
            ),
            'input__select_fontSize_mobile' => array(
              'label' => 'Select font size',
              'type' => 'input'
            ),
            'input__select_lineHeight_mobile' => array(
              'label' => 'Select line height',
              'type' => 'input'
            ),
            'input__selectContainer_color' => array(
              'label' => 'Select container text color',
              'type' => 'color'
            ),
            'input__selectContainer_bg_color' => array(
              'label' => 'Select container background color',
              'type' => 'color'
            ),
            'input__selectContainer_width' => array(
              'label' => 'Select container size',
              'type' => 'input'
            ),
            'input__selectContainer_width_mobile' => array(
              'label' => 'Select container size',
              'type' => 'input'
            ),
            'input__required' => array(
              'label' => 'Required color',
              'type' => 'color',
              'default' => '#a53737'
            ),
            'input__placeholder_color' => array(
              'label' => 'Placeholder color',
              'type' => 'color'
            ),
            'input__placeholder_fontFamily' => array(
              'label' => 'Placeholder font family',
              'type' => 'input'
            ),
            'input__placeholder_fontSize' => array(
              'label' => 'Placeholder font size',
              'type' => 'input'
            ),
            'input__placeholder_lineHeight' => array(
              'label' => 'Placeholder line height',
              'type' => 'input'
            ),
            'input__placeholder_fontWeight' => array(
              'label' => 'Placeholder font weight',
              'type' => 'input'
            ),
            'input__placeholder_textTransform' => array(
              'label' => 'Placeholder text transform',
              'type' => 'input'
            ),
            'input__submit_fontFamily' => array(
              'label' => 'Submit font family',
              'type' => 'input'
            ),
            'input__submit_fontSize' => array(
              'label' => 'Submit/button font size',
              'type' => 'input'
            ),
            'input__submit_letterSpacing' => array(
              'label' => 'Submit/button letter spacing',
              'type' => 'input'
            ),
            'input__submit_lineHeight' => array(
              'label' => 'Submit/button line height',
              'type' => 'input'
            ),
            'input__submit_fontWeight' => array(
              'label' => 'Submit/button font weight',
              'type' => 'input'
            ),
            'input__submit_textTransform' => array(
              'label' => 'Submit/button text transform',
              'type' => 'input'
            ),
            'input__submit_fontSize_mobile' => array(
              'label' => 'Submit/button font size',
              'type' => 'input'
            ),
            'input__submit_lineHeight_mobile' => array(
              'label' => 'Submit/button line height',
              'type' => 'input'
            ),
            'input__submit_letterSpacing_mobile' => array(
              'label' => 'Submit/button letter spacing',
              'type' => 'input'
            ),
            'input__submit_bg_color' => array(
              'label' => 'Submit/button background color',
              'type' => 'color',
              'default' => '#0175bc'
            ),
            'input__submit_color' => array(
              'label' => 'Submit/button text color',
              'type' => 'color',
              'default' => '#ffffff'
            ),
            'input__submit_border_color' => array(
              'label' => 'Submit/button border color',
              'type' => 'color',
              'default' => '#0175bc'
            ),
            'input__submit_bg_color_hover' => array(
              'label' => 'Submit/button background color (hover)',
              'type' => 'color',
              'default' => '#0175bc'
            ),
            'input__submit_border_color_hover' => array(
              'label' => 'Submit/button border color (hover)',
              'type' => 'color',
              'default' => '#0175bc'
            ),
            'input__submit_color_hover' => array(
              'label' => 'Submit/button text color (hover)',
              'type' => 'color',
              'default' => '#ffffff'
            ),
            'input__submit_borderRadius' => array(
              'label' => 'Submit/button border radius',
              'type' => 'input'
            ),
            'input__submit_borderWidth' => array(
              'label' => 'Submit/button border width',
              'type' => 'input'
            ),
            'input__submit_padding' => array(
              'label' => 'Submit/button padding',
              'type' => 'input'
            ),
            'input__submit_padding_mobile' => array(
              'label' => 'Submit/button padding',
              'type' => 'input'
            ),
            'input__reset_fontFamily' => array(
              'label' => 'Reset font family',
              'type' => 'input'
            ),
            'input__reset_fontSize' => array(
              'label' => 'Reset/button font size',
              'type' => 'input'
            ),
            'input__reset_letterSpacing' => array(
              'label' => 'Reset/button letter spacing',
              'type' => 'input'
            ),
            'input__reset_lineHeight' => array(
              'label' => 'Reset/button line height',
              'type' => 'input'
            ),
            'input__reset_fontWeight' => array(
              'label' => 'Reset/button font weight',
              'type' => 'input'
            ),
            'input__reset_textTransform' => array(
              'label' => 'Reset/button text transform',
              'type' => 'input'
            ),
            'input__reset_fontSize_mobile' => array(
              'label' => 'Reset/button font size',
              'type' => 'input'
            ),
            'input__reset_lineHeight_mobile' => array(
              'label' => 'Reset/button line height',
              'type' => 'input'
            ),
            'input__reset_letterSpacing_mobile' => array(
              'label' => 'Reset/button letter spacing',
              'type' => 'input'
            ),
            'input__reset_bg_color' => array(
              'label' => 'Reset/button background color',
              'type' => 'color',
              'default' => '#0175bc'
            ),
            'input__reset_color' => array(
              'label' => 'Reset/button text color',
              'type' => 'color',
              'default' => '#ffffff'
            ),
            'input__reset_border_color' => array(
              'label' => 'Reset/button border color',
              'type' => 'color',
              'default' => '#0175bc'
            ),
            'input__reset_bg_color_hover' => array(
              'label' => 'Reset/button background color (hover)',
              'type' => 'color',
              'default' => '#0175bc'
            ),
            'input__reset_border_color_hover' => array(
              'label' => 'Reset/button border color (hover)',
              'type' => 'color',
              'default' => '#0175bc'
            ),
            'input__reset_color_hover' => array(
              'label' => 'Reset/button text color (hover)',
              'type' => 'color',
              'default' => '#ffffff'
            ),
            'input__reset_borderRadius' => array(
              'label' => 'Reset/button border radius',
              'type' => 'input'
            ),
            'input__reset_borderWidth' => array(
              'label' => 'Reset/button border width',
              'type' => 'input'
            ),
            'input__reset_padding' => array(
              'label' => 'Reset/button padding',
              'type' => 'input'
            ),
            'input__reset_padding_mobile' => array(
              'label' => 'Reset/button padding',
              'type' => 'input'
            )
          )
        ),
        'blog' => array(
          'label' => 'Blog & Archive',
          'inputs' => array(
            'blog__marginTop' => array(
              'label' => 'Margin top',
              'type' => 'input'
            ),
            'blog__marginBottom' => array(
              'label' => 'Margin bottom',
              'type' => 'input'
            ),
            'blog__paddingTop' => array(
              'label' => 'Padding top',
              'type' => 'input'
            ),
            'blog__paddingBottom' => array(
              'label' => 'Padding bottom',
              'type' => 'input'
            ),
            'blog__marginTop_mobile' => array(
              'label' => 'Margin top',
              'type' => 'input'
            ),
            'blog__marginBottom_mobile' => array(
              'label' => 'Margin bottom',
              'type' => 'input'
            ),
            'blog__paddingTop_mobile' => array(
              'label' => 'Padding top',
              'type' => 'input'
            ),
            'blog__paddingBottom_mobile' => array(
              'label' => 'Padding bottom',
              'type' => 'input'
            ),
            'blog__pagination_margin' => array(
              'label' => 'Space around pagination',
              'type' => 'input'
            ),
            'blog__article_flexDirection' => array(
              'label' => 'Article direction',
              'type' => 'input'
            ),
            'blog__article_flexGap' => array(
              'label' => 'Article gap',
              'type' => 'input'
            ),
            'blog__article_flexDivWidth' => array(
              'label' => 'Article excerpt width',
              'type' => 'input'
            ),
            'blog__article_flexMediaWidth' => array(
              'label' => 'Article media width',
              'type' => 'input'
            ),
            'blog__article_flexDirection_mobile' => array(
              'label' => 'Article direction',
              'type' => 'input'
            ),
            'blog__article_flexGap_mobile' => array(
              'label' => 'Article gap',
              'type' => 'input'
            ),
            'blog__article_flexDivWidth_mobile' => array(
              'label' => 'Article excerpt width',
              'type' => 'input'
            ),
            'blog__article_flexMediaWidth_mobile' => array(
              'label' => 'Article media width',
              'type' => 'input'
            ),
            'blog__article_margin' => array(
              'label' => 'Article margin',
              'type' => 'input'
            ),
            'blog__article_padding' => array(
              'label' => 'Article padding',
              'type' => 'input'
            ),
            'blog__article_border' => array(
              'label' => 'Article border width',
              'type' => 'input'
            ),
            'blog__article_borderColor' => array(
              'label' => 'Article border color',
              'type' => 'color'
            ),
            'blog__article_margin_mobile' => array(
              'label' => 'Article margin',
              'type' => 'input'
            ),
            'blog__article_padding_mobile' => array(
              'label' => 'Article padding',
              'type' => 'input'
            ),
            'blog__article_title_margin' => array(
              'label' => 'Article title margin',
              'type' => 'input'
            ),
            'blog__article_title_padding' => array(
              'label' => 'Article title padding',
              'type' => 'input'
            ),
            'blog__article_title_fontFamily' => array(
              'label' => 'Article title font family',
              'type' => 'input'
            ),
            'blog__article_title_fontSize' => array(
              'label' => 'Article title font size',
              'type' => 'input'
            ),
            'blog__article_title_lineHeight' => array(
              'label' => 'Article title line height',
              'type' => 'input'
            ),
            'blog__article_title_fontWeight' => array(
              'label' => 'Article title font weight',
              'type' => 'input'
            ),
            'blog__article_title_textTransform' => array(
              'label' => 'Article title text transform',
              'type' => 'input'
            ),
            'blog__article_title_fontSize_mobile' => array(
              'label' => 'Article title font size',
              'type' => 'input'
            ),
            'blog__article_title_lineHeight_mobile' => array(
              'label' => 'Article title line height',
              'type' => 'input'
            ),
            'blog__article_title_margin_mobile' => array(
              'label' => 'Article title margin',
              'type' => 'input'
            ),
            'blog__article_title_padding_mobile' => array(
              'label' => 'Article title padding',
              'type' => 'input'
            )
          )
        ),
        'searchResults' => array(
          'label' => 'Search results',
          'inputs' => array(
            'search__marginTop' => array(
              'label' => 'Margin top',
              'type' => 'input'
            ),
            'search__marginBottom' => array(
              'label' => 'Margin bottom',
              'type' => 'input'
            ),
            'search__paddingTop' => array(
              'label' => 'Padding top',
              'type' => 'input'
            ),
            'search__paddingBottom' => array(
              'label' => 'Padding bottom',
              'type' => 'input'
            ),
            'search__marginTop_mobile' => array(
              'label' => 'Margin top',
              'type' => 'input'
            ),
            'search__marginBottom_mobile' => array(
              'label' => 'Margin bottom',
              'type' => 'input'
            ),
            'search__paddingTop_mobile' => array(
              'label' => 'Padding top',
              'type' => 'input'
            ),
            'search__paddingBottom_mobile' => array(
              'label' => 'Padding bottom',
              'type' => 'input'
            ),
            'search__pagination_margin' => array(
              'label' => 'Space around pagination',
              'type' => 'input'
            ),
            'search__article_flexDirection' => array(
              'label' => 'Article direction',
              'type' => 'input'
            ),
            'search__article_flexGap' => array(
              'label' => 'Article gap',
              'type' => 'input'
            ),
            'search__article_flexDivWidth' => array(
              'label' => 'Article excerpt width',
              'type' => 'input'
            ),
            'search__article_flexMediaWidth' => array(
              'label' => 'Article media width',
              'type' => 'input'
            ),
            'search__article_flexDirection_mobile' => array(
              'label' => 'Article direction',
              'type' => 'input'
            ),
            'search__article_flexGap_mobile' => array(
              'label' => 'Article gap',
              'type' => 'input'
            ),
            'search__article_flexDivWidth_mobile' => array(
              'label' => 'Article excerpt width',
              'type' => 'input'
            ),
            'search__article_flexMediaWidth_mobile' => array(
              'label' => 'Article media width',
              'type' => 'input'
            ),
            'search__article_margin' => array(
              'label' => 'Article margin',
              'type' => 'input'
            ),
            'search__article_padding' => array(
              'label' => 'Article padding',
              'type' => 'input'
            ),
            'search__article_border' => array(
              'label' => 'Article border width',
              'type' => 'input'
            ),
            'search__article_borderColor' => array(
              'label' => 'Article border color',
              'type' => 'color'
            ),
            'search__article_margin_mobile' => array(
              'label' => 'Article margin',
              'type' => 'input'
            ),
            'search__article_padding_mobile' => array(
              'label' => 'Article padding',
              'type' => 'input'
            ),
            'search__article_title_margin' => array(
              'label' => 'Article title margin',
              'type' => 'input'
            ),
            'search__article_title_padding' => array(
              'label' => 'Article title padding',
              'type' => 'input'
            ),
            'search__article_title_fontFamily' => array(
              'label' => 'Article title font family',
              'type' => 'input'
            ),
            'search__article_title_fontSize' => array(
              'label' => 'Article title font size',
              'type' => 'input'
            ),
            'search__article_title_lineHeight' => array(
              'label' => 'Article title line height',
              'type' => 'input'
            ),
            'search__article_title_fontWeight' => array(
              'label' => 'Article title font weight',
              'type' => 'input'
            ),
            'search__article_title_textTransform' => array(
              'label' => 'Article title text transform',
              'type' => 'input'
            ),
            'search__article_title_fontSize_mobile' => array(
              'label' => 'Article title font size',
              'type' => 'input'
            ),
            'search__article_title_lineHeight_mobile' => array(
              'label' => 'Article title line height',
              'type' => 'input'
            ),
            'search__article_title_margin_mobile' => array(
              'label' => 'Article title margin',
              'type' => 'input'
            ),
            'search__article_title_padding_mobile' => array(
              'label' => 'Article title padding',
              'type' => 'input'
            )
          )
        ),
        'postTitle' => array(
          'label' => 'Post title',
          'inputs' => array(
            'postTitle__color' => array(
              'label' => 'Color',
              'type' => 'color'
            ),
            'postTitle__bg' => array(
              'label' => 'Background color',
              'type' => 'color'
            ),
            'postTitle__fontFamily' => array(
              'label' => 'Title font family',
              'type' => 'input'
            ),
            'postTitle__fontSize' => array(
              'label' => 'Font size',
              'type' => 'input'
            ),
            'postTitle__lineHeight' => array(
              'label' => 'Line height',
              'type' => 'input'
            ),
            'postTitle__padding' => array(
              'label' => 'Padding',
              'type' => 'input'
            ),
            'postTitle__margin' => array(
              'label' => 'Margin',
              'type' => 'input'
            ),
            'postTitle__fontWeight' => array(
              'label' => 'Font weight',
              'type' => 'input'
            ),
            'postTitle__textTransform' => array(
              'label' => 'Text transform',
              'type' => 'input'
            ),
            'postTitle__letterSpacing' => array(
              'label' => 'Letter spacing',
              'type' => 'input'
            ),
            'postTitle__fontSize_mobile' => array(
              'label' => 'Font size',
              'type' => 'input'
            ),
            'postTitle__lineHeight_mobile' => array(
              'label' => 'Line height',
              'type' => 'input'
            ),
            'postTitle__padding_mobile' => array(
              'label' => 'Padding',
              'type' => 'input'
            ),
            'postTitle__margin_mobile' => array(
              'label' => 'Margin',
              'type' => 'input'
            )
          )
        ),
        'titleOne' => array(
          'label' => 'Title 1',
          'inputs' => array(
            'titleOne__color' => array(
              'label' => 'Color',
              'type' => 'color'
            ),
            'titleOne__bg' => array(
              'label' => 'Background color',
              'type' => 'color'
            ),
            'titleOne__fontFamily' => array(
              'label' => 'Title font family',
              'type' => 'input'
            ),
            'titleOne__fontSize' => array(
              'label' => 'Font size',
              'type' => 'input'
            ),
            'titleOne__lineHeight' => array(
              'label' => 'Line height',
              'type' => 'input'
            ),
            'titleOne__padding' => array(
              'label' => 'Padding',
              'type' => 'input'
            ),
            'titleOne__marginTop' => array(
              'label' => 'Margin top',
              'type' => 'input'
            ),
            'titleOne__marginBottom' => array(
              'label' => 'Margin bottom',
              'type' => 'input'
            ),
            'titleOne__fontWeight' => array(
              'label' => 'Font weight',
              'type' => 'input'
            ),
            'titleOne__textTransform' => array(
              'label' => 'Text transform',
              'type' => 'input'
            ),
            'titleOne__letterSpacing' => array(
              'label' => 'Letter spacing',
              'type' => 'input'
            ),
            'titleOne__fontSize_mobile' => array(
              'label' => 'Font size',
              'type' => 'input'
            ),
            'titleOne__lineHeight_mobile' => array(
              'label' => 'Line height',
              'type' => 'input'
            ),
            'titleOne__padding_mobile' => array(
              'label' => 'Padding',
              'type' => 'input'
            ),
            'titleOne__marginTop_mobile' => array(
              'label' => 'Margin top',
              'type' => 'input'
            ),
            'titleOne__marginBottom_mobile' => array(
              'label' => 'Margin bottom',
              'type' => 'input'
            )
          )
        ),
        'titleTwo' => array(
          'label' => 'Title 2',
          'inputs' => array(
            'titleTwo__color' => array(
              'label' => 'Color',
              'type' => 'color'
            ),
            'titleTwo__bg' => array(
              'label' => 'Background color',
              'type' => 'color'
            ),
            'titleTwo__fontFamily' => array(
              'label' => 'Title font family',
              'type' => 'input'
            ),
            'titleTwo__fontSize' => array(
              'label' => 'Font size',
              'type' => 'input'
            ),
            'titleTwo__lineHeight' => array(
              'label' => 'Line height',
              'type' => 'input'
            ),
            'titleTwo__padding' => array(
              'label' => 'Padding',
              'type' => 'input'
            ),
            'titleTwo__marginTop' => array(
              'label' => 'Margin top',
              'type' => 'input'
            ),
            'titleTwo__marginBottom' => array(
              'label' => 'Margin bottom',
              'type' => 'input'
            ),
            'titleTwo__fontWeight' => array(
              'label' => 'Font weight',
              'type' => 'input'
            ),
            'titleTwo__textTransform' => array(
              'label' => 'Text transform',
              'type' => 'input'
            ),
            'titleTwo__letterSpacing' => array(
              'label' => 'Letter spacing',
              'type' => 'input'
            ),
            'titleTwo__fontSize_mobile' => array(
              'label' => 'Font size',
              'type' => 'input'
            ),
            'titleTwo__lineHeight_mobile' => array(
              'label' => 'Line height',
              'type' => 'input'
            ),
            'titleTwo__padding_mobile' => array(
              'label' => 'Padding',
              'type' => 'input'
            ),
            'titleTwo__marginTop_mobile' => array(
              'label' => 'Margin top',
              'type' => 'input'
            ),
            'titleTwo__marginBottom_mobile' => array(
              'label' => 'Margin bottom',
              'type' => 'input'
            )
          )
        ),
        'titleThree' => array(
          'label' => 'Title 3',
          'inputs' => array(
            'titleThree__color' => array(
              'label' => 'Color',
              'type' => 'color'
            ),
            'titleThree__bg' => array(
              'label' => 'Background color',
              'type' => 'color'
            ),
            'titleThree__fontFamily' => array(
              'label' => 'Title font family',
              'type' => 'input'
            ),
            'titleThree__fontSize' => array(
              'label' => 'Font size',
              'type' => 'input'
            ),
            'titleThree__lineHeight' => array(
              'label' => 'Line height',
              'type' => 'input'
            ),
            'titleThree__padding' => array(
              'label' => 'Padding',
              'type' => 'input'
            ),
            'titleThree__marginTop' => array(
              'label' => 'Margin top',
              'type' => 'input'
            ),
            'titleThree__marginBottom' => array(
              'label' => 'Margin bottom',
              'type' => 'input'
            ),
            'titleThree__fontWeight' => array(
              'label' => 'Font weight',
              'type' => 'input'
            ),
            'titleThree__textTransform' => array(
              'label' => 'Text transform',
              'type' => 'input'
            ),
            'titleThree__letterSpacing' => array(
              'label' => 'Letter spacing',
              'type' => 'input'
            ),
            'titleThree__fontSize_mobile' => array(
              'label' => 'Font size',
              'type' => 'input'
            ),
            'titleThree__lineHeight_mobile' => array(
              'label' => 'Line height',
              'type' => 'input'
            ),
            'titleThree__padding_mobile' => array(
              'label' => 'Padding',
              'type' => 'input'
            ),
            'titleThree__marginTop_mobile' => array(
              'label' => 'Margin top',
              'type' => 'input'
            ),
            'titleThree__marginBottom_mobile' => array(
              'label' => 'Margin bottom',
              'type' => 'input'
            )
          )
        ),
        'leadText' => array(
          'label' => 'Lead Text',
          'inputs' => array(
            'leadText__color' => array(
              'label' => 'Color',
              'type' => 'color'
            ),
            'leadText__bg' => array(
              'label' => 'Background color',
              'type' => 'color'
            ),
            'dark__leadText__color' => array(
              'label' => 'Color',
              'type' => 'color'
            ),
            'dark__leadText__bg' => array(
              'label' => 'Background color',
              'type' => 'color'
            ),
            'leadText__fontFamily' => array(
              'label' => 'Lead font family',
              'type' => 'input'
            ),
            'leadText__fontSize' => array(
              'label' => 'Lead font size',
              'type' => 'input'
            ),
            'leadText__lineHeight' => array(
              'label' => 'Line height',
              'type' => 'input'
            ),
            'leadText__padding' => array(
              'label' => 'Padding',
              'type' => 'input'
            ),
            'leadText__fontWeight' => array(
              'label' => 'Font weight',
              'type' => 'input'
            ),
            'leadText__textTransform' => array(
              'label' => 'Text transform',
              'type' => 'input'
            ),
            'leadText__letterSpacing' => array(
              'label' => 'Letter spacing',
              'type' => 'input'
            ),
            'leadText__fontSize_mobile' => array(
              'label' => 'Font size',
              'type' => 'input'
            ),
            'leadText__lineHeight_mobile' => array(
              'label' => 'Line height',
              'type' => 'input'
            ),
            'leadText__padding_mobile' => array(
              'label' => 'Padding',
              'type' => 'input'
            )
          )
        ),
        'page404' => array(
          'label' => '404 Page',
          'inputs' => array(
            'error__padding' => array(
              'label' => 'Article padding',
              'type' => 'input'
            ),
            'error__margin' => array(
              'label' => 'Article margin',
              'type' => 'input'
            ),
            'error__title_fontFamily' => array(
              'label' => 'Title font family',
              'type' => 'input'
            ),
            'error__title_fontSize' => array(
              'label' => 'Title font size',
              'type' => 'input'
            ),
            'error__title_lineHeight' => array(
              'label' => 'Title line height',
              'type' => 'input'
            ),
            'error__title_padding' => array(
              'label' => 'Title padding',
              'type' => 'input'
            ),
            'error__title_margin' => array(
              'label' => 'Title margin',
              'type' => 'input'
            ),
            'error__title_fontWeight' => array(
              'label' => 'Title font weight',
              'type' => 'input'
            ),
            'error__title_textTransform' => array(
              'label' => 'Title text transform',
              'type' => 'input'
            ),
            'error__title_letterSpacing' => array(
              'label' => 'Title letter spacing',
              'type' => 'input'
            ),
            'error__title_fontSize_mobile' => array(
              'label' => 'Title font size',
              'type' => 'input'
            ),
            'error__title_lineHeight_mobile' => array(
              'label' => 'Title line height',
              'type' => 'input'
            ),
            'error__title_padding_mobile' => array(
              'label' => 'Title padding',
              'type' => 'input'
            ),
            'error__title_margin_mobile' => array(
              'label' => 'Title margin',
              'type' => 'input'
            )
          )
        ),
        'consentContainer' => array(
          'label' => 'DSGVO consent container',
          'inputs' => array(
            'consentContainer__bg' => array(
              'label' => 'Background color',
              'type' => 'color'
            ),
            'consentContainer__color' => array(
              'label' => 'Text color',
              'type' => 'color'
            ),
            'consentContainer__borderColor' => array(
              'label' => 'Border color',
              'type' => 'color'
            ),
            'consentContainer__fontFamily' => array(
              'label' => 'Font family',
              'type' => 'input'
            ),
            'consentContainer__fontSize' => array(
              'label' => 'Font size',
              'type' => 'input'
            ),
            'consentContainer__lineHeight' => array(
              'label' => 'Line height',
              'type' => 'input'
            ),
            'consentContainer__fontWeight' => array(
              'label' => 'Font weight',
              'type' => 'input'
            ),
            'consentContainer__textAlign' => array(
              'label' => 'Text align',
              'type' => 'input'
            ),
            'consentContainer__padding' => array(
              'label' => 'Padding',
              'type' => 'input'
            ),
            'consentContainer__borderWidth' => array(
              'label' => 'Border width',
              'type' => 'input'
            ),
            'consentContainer__borderRadius' => array(
              'label' => 'Border radius',
              'type' => 'input'
            ),
            'consentContainer__fontSize_mobile' => array(
              'label' => 'Font size',
              'type' => 'input'
            ),
            'consentContainer__lineHeight_mobile' => array(
              'label' => 'Line height',
              'type' => 'input'
            ),
            'consentContainer__padding_mobile' => array(
              'label' => 'Padding',
              'type' => 'input'
            ),
            'consentContainer__Button_bg' => array(
              'label' => 'Button background color',
              'type' => 'color'
            ),
            'consentContainer__Button_color' => array(
              'label' => 'Button text color',
              'type' => 'color'
            ),
            'consentContainer__Button_borderColor' => array(
              'label' => 'Button border color',
              'type' => 'color'
            ),
            'consentContainer__Button_bg_hover' => array(
              'label' => 'Button background color',
              'type' => 'color'
            ),
            'consentContainer__Button_color_hover' => array(
              'label' => 'Button text color',
              'type' => 'color'
            ),
            'consentContainer__Button_borderColor_hover' => array(
              'label' => 'Button border color',
              'type' => 'color'
            ),
            'consentContainer__Button_fontFamily' => array(
              'label' => 'Button font family',
              'type' => 'input'
            ),
            'consentContainer__Button_fontSize' => array(
              'label' => 'Button font size',
              'type' => 'input'
            ),
            'consentContainer__Button_fontWeight' => array(
              'label' => 'Button font weight',
              'type' => 'input'
            ),
            'consentContainer__Button_lineHeight' => array(
              'label' => 'Button line height',
              'type' => 'input'
            ),
            'consentContainer__Button_textTransform' => array(
              'label' => 'Button text transform',
              'type' => 'input'
            ),
            'consentContainer__Button_letterSpacing' => array(
              'label' => 'Button letter spacing',
              'type' => 'input'
            ),
            'consentContainer__Button_padding' => array(
              'label' => 'Button padding',
              'type' => 'input'
            ),
            'consentContainer__Button_borderWidth' => array(
              'label' => 'Button border width',
              'type' => 'input'
            ),
            'consentContainer__Button_borderRadius' => array(
              'label' => 'Button border radius',
              'type' => 'input'
            ),
            'consentContainer__Button_fontSize_mobile' => array(
              'label' => 'Button font size',
              'type' => 'input'
            ),
            'consentContainer__Button_lineHeight_mobile' => array(
              'label' => 'Button line height',
              'type' => 'input'
            ),
            'consentContainer__Button_padding_mobile' => array(
              'label' => 'Button padding',
              'type' => 'input'
            )
          )
        )
      )
    ),
    'gutenberg' => array(
      'label' => 'Gutenberg Blocks',
      'sections' => array(
        'gutenberg_group' => array(
          'label' => 'Group',
          'inputs' => array(
            'block__group_hasBackground_paddingTop' => array(
              'label' => 'Padding top',
              'type' => 'input'
            ),
            'block__group_hasBackground_paddingBottom' => array(
              'label' => 'Padding bottom',
              'type' => 'input'
            ),
            'block__group_hasBackground_paddingTop_mobile' => array(
              'label' => 'Padding top',
              'type' => 'input'
            ),
            'block__group_hasBackground_paddingBottom_mobile' => array(
              'label' => 'Padding bottom',
              'type' => 'input'
            )
          )
        ),
        'gutenberg_imageGallery' => array(
          'label' => 'Image gallery',
          'inputs' => array(
            'gallery-block--gutter-size' => array(
              'label' => 'Space between',
              'type' => 'input'
            ),
            'block__imagegallery_arrow_position' => array(
              'label' => 'Swiper arrow position from sides',
              'type' => 'input'
            ),
            'block__imagegallery_arrow_position_mobile' => array(
              'label' => 'Swiper arrow position from sides',
              'type' => 'input'
            ),
            'block__imagegallery_arrow_color' => array(
              'label' => 'Swiper arrow color',
              'type' => 'color'
            ),
            'block__imagegallery_arrow_opacity' => array(
              'label' => 'Swiper arrow opacity',
              'type' => 'input'
            ),
            'swiper__bulletNav_position' => array(
              'label' => 'Bullet navigation position from bottom',
              'type' => 'input'
            ),
            'swiper__bulletNav_position_mobile' => array(
              'label' => 'Bullet navigation position from bottom',
              'type' => 'input'
            ),
            'swiper__bulletNav_gap' => array(
              'label' => 'Bullet navigation gap',
              'type' => 'input'
            ),
            'swiper__bulletNav_item_bg' => array(
              'label' => 'Bullet navigation item backgorund color',
              'type' => 'color'
            ),
            'swiper__bulletNav_item_color' => array(
              'label' => 'Bullet navigation item color',
              'type' => 'color'
            ),
            'swiper__bulletNav_item_borderColor' => array(
              'label' => 'Bullet navigation active item border color',
              'type' => 'color'
            ),
            'swiper__bulletNav_item_borderRadius' => array(
              'label' => 'Bullet navigation item border radius',
              'type' => 'input'
            ),
            'swiper__bulletNav_item_borderWidth' => array(
              'label' => 'Bullet navigation item border width',
              'type' => 'input'
            ),
            'swiper__bulletNav_item_fontSize' => array(
              'label' => 'Bullet navigation item font size',
              'type' => 'input'
            ),
            'swiper__bulletNav_item_width' => array(
              'label' => 'Bullet navigation item width',
              'type' => 'input'
            ),
            'swiper__bulletNav_item_height' => array(
              'label' => 'Bullet navigation item height',
              'type' => 'input'
            ),
            'swiper__bulletNav_item_width_mobile' => array(
              'label' => 'Bullet navigation item width',
              'type' => 'input'
            ),
            'swiper__bulletNav_item_height_mobile' => array(
              'label' => 'Bullet navigation item height',
              'type' => 'input'
            ),
            'swiper__bulletNav_itemActive_bg' => array(
              'label' => 'Bullet navigation active item backgorund color',
              'type' => 'color'
            ),
            'swiper__bulletNav_itemActive_color' => array(
              'label' => 'Bullet navigation active item color',
              'type' => 'color'
            ),
            'swiper__bulletNav_itemActive_borderColor' => array(
              'label' => 'Bullet navigation active item border color',
              'type' => 'color'
            )
          )
        ),
        'gutenberg_seperator' => array(
          'label' => 'Seperator',
          'inputs' => array(
            'block__separator_width' => array(
              'label' => 'Height',
              'type' => 'input'
            ),
            'block__separator_marginTop' => array(
              'label' => 'Margin top',
              'type' => 'input'
            ),
            'block__separator_marginBottom' => array(
              'label' => 'Margin bottom',
              'type' => 'input'
            ),
            'gbSeperator_color' => array(
              'label' => 'Default color',
              'type' => 'color',
              'default' => '#dddddd'
            ),
            'dark__gbSeperator_color' => array(
              'label' => 'Default color',
              'type' => 'color',
              'default' => '#343434'
            ),
            'block__separator_width_mobile' => array(
              'label' => 'Height',
              'type' => 'input'
            ),
            'block__separator_marginTop_mobile' => array(
              'label' => 'Margin top',
              'type' => 'input'
            ),
            'block__separator_marginBottom_mobile' => array(
              'label' => 'Margin bottom',
              'type' => 'input'
            ),
            'block__separatorDots_fontSize' => array(
              'label' => 'Dots font size',
              'type' => 'input'
            ),
            'block__separatorDots_fontSize_mobile' => array(
              'label' => 'Dots font size',
              'type' => 'input'
            )
          )
        ),
        'gutenberg_columns' => array(
          'label' => 'Columns',
          'inputs' => array(
            'wp--style--block-gap' => array(
              'label' => 'Space between',
              'type' => 'input',
              'default' => '20px'
            ),
            'block__columns_hasBackground_padding' => array(
              'label' => 'Padding',
              'type' => 'input'
            ),
            'block__columns_hasBackground_gap' => array(
              'label' => 'Space between',
              'type' => 'input'
            ),
            'wp--style--block-gap_mobile' => array(
              'label' => 'Space between',
              'type' => 'input'
            ),
            'block__columns_hasBackground_padding_mobile' => array(
              'label' => 'Padding',
              'type' => 'input'
            ),
            'block__columns_hasBackground_gap_mobile' => array(
              'label' => 'Space between',
              'type' => 'input'
            ),
            'block__columns_3columns_gap' => array(
              'label' => '3 columns space between',
              'type' => 'input'
            ),
            'block__columns_3columns_hasBackground_gap' => array(
              'label' => '3 columns space between',
              'type' => 'input'
            ),
            'block__columns_3columns_gap_mobile' => array(
              'label' => '3 columns space between',
              'type' => 'input'
            ),
            'block__columns_3columns_hasBackground_gap_mobile' => array(
              'label' => '3 columns space between',
              'type' => 'input'
            ),
            'block__columns_4columns_gap' => array(
              'label' => '4 columns space between',
              'type' => 'input'
            ),
            'block__columns_4columns_hasBackground_gap' => array(
              'label' => '4 columns space between',
              'type' => 'input'
            ),
            'block__columns_4columns_gap_mobile' => array(
              'label' => '4 columns space between',
              'type' => 'input'
            ),
            'block__columns_4columns_hasBackground_gap_mobile' => array(
              'label' => '4 columns space between',
              'type' => 'input'
            ),
            'block__columns_5columns_gap' => array(
              'label' => '5 columns space between',
              'type' => 'input'
            ),
            'block__columns_5columns_hasBackground_gap' => array(
              'label' => '5 columns space between',
              'type' => 'input'
            ),
            'block__columns_5columns_gap_mobile' => array(
              'label' => '5 columns space between',
              'type' => 'input'
            ),
            'block__columns_5columns_hasBackground_gap_mobile' => array(
              'label' => '5 columns space between',
              'type' => 'input'
            ),
            'block__columns_6columns_gap' => array(
              'label' => '6 columns space between',
              'type' => 'input'
            ),
            'block__columns_6columns_hasBackground_gap' => array(
              'label' => '6 columns space between',
              'type' => 'input'
            ),
            'block__columns_6columns_gap_mobile' => array(
              'label' => '6 columns space between',
              'type' => 'input',
              'default' => '20px'
            ),
            'block__columns_6columns_hasBackground_gap_mobile' => array(
              'label' => '6 columns space between',
              'type' => 'input'
            )
          )
        ),
        'gutenberg_image' => array(
          'label' => 'Image',
          'inputs' => array(
            'block__imageFigcaption_fontSize' => array(
              'label' => 'Figcaption font size',
              'type' => 'input'
            ),
            'block__imageFigcaption_lineHeight' => array(
              'label' => 'Figcaption line height',
              'type' => 'input'
            ),
            'block__imageFigcaption_margin' => array(
              'label' => 'Figcaption margin',
              'type' => 'input'
            ),
            'block__imageFigcaption_padding' => array(
              'label' => 'Figcaption padding',
              'type' => 'input'
            ),
            'block__imageFigcaption_fontSize_mobile' => array(
              'label' => 'Figcaption font size',
              'type' => 'input'
            ),
            'block__imageFigcaption_lineHeight_mobile' => array(
              'label' => 'Figcaption line height',
              'type' => 'input'
            ),
            'block__imageFigcaption_margin_mobile' => array(
              'label' => 'Figcaption margin',
              'type' => 'input'
            ),
            'block__imageFigcaption_padding_mobile' => array(
              'label' => 'Figcaption padding',
              'type' => 'input'
            )
          )
        ),
        'gutenberg_buttons' => array(
          'label' => 'Buttons',
          'inputs' => array(
            'block__buttons_spacing' => array(
              'label' => 'Space between buttons',
              'type' => 'input'
            ),
            'block__buttons_fontFamily' => array(
              'label' => 'Font',
              'type' => 'input'
            ),
            'block__buttons_fontSize' => array(
              'label' => 'Font size',
              'type' => 'input'
            ),
            'block__buttons_fontWeight' => array(
              'label' => 'Font weight',
              'type' => 'input'
            ),
            'block__buttons_lineHeight' => array(
              'label' => 'Line height',
              'type' => 'input'
            ),
            'block__buttons_textTransform' => array(
              'label' => 'Text transform',
              'type' => 'input'
            ),
            'block__buttons_letterSpacing' => array(
              'label' => 'Text letter spacing',
              'type' => 'input'
            ),
            'block__buttons_padding' => array(
              'label' => 'Padding',
              'type' => 'input'
            ),
            'block__buttons_borderWidth' => array(
              'label' => 'Border width',
              'type' => 'input'
            ),
            'block__buttons_borderRadius' => array(
              'label' => 'Border radius',
              'type' => 'input'
            ),
            'block__buttons_color' => array(
              'label' => 'Text color',
              'type' => 'color'
            ),
            'block__buttons_bgColor' => array(
              'label' => 'Background color',
              'type' => 'color'
            ),
            'block__buttons_borderColor' => array(
              'label' => 'Border color',
              'type' => 'color'
            ),
            'block__buttonsHover_color' => array(
              'label' => 'Text color (hover)',
              'type' => 'color'
            ),
            'block__buttonsHover_bgColor' => array(
              'label' => 'Background color (hover)',
              'type' => 'color'
            ),
            'block__buttonsHover_borderColor' => array(
              'label' => 'Border color (hover)',
              'type' => 'color'
            ),
            'block__buttons_fontSize_mobile' => array(
              'label' => 'Font size',
              'type' => 'input'
            ),
            'block__buttons_lineHeight_mobile' => array(
              'label' => 'Line height',
              'type' => 'input'
            ),
            'block__buttons_textTransform_mobile' => array(
              'label' => 'Text transform',
              'type' => 'input'
            ),
            'block__buttons_padding_mobile' => array(
              'label' => 'Padding',
              'type' => 'input'
            ),
            'block__buttons_borderWidth_mobile' => array(
              'label' => 'Border width',
              'type' => 'input'
            ),
            'block__buttons_borderRadius_mobile' => array(
              'label' => 'Border radius',
              'type' => 'input'
            ),
            'dark__block__buttons_color' => array(
              'label' => 'Text color',
              'type' => 'color'
            ),
            'dark__block__buttons_bgColor' => array(
              'label' => 'Background color',
              'type' => 'color'
            ),
            'dark__block__buttons_borderColor' => array(
              'label' => 'Border color',
              'type' => 'color'
            ),
            'dark__block__buttonsHover_color' => array(
              'label' => 'Text color (hover)',
              'type' => 'color'
            ),
            'dark__block__buttonsHover_bgColor' => array(
              'label' => 'Background color (hover)',
              'type' => 'color'
            ),
            'dark__block__buttonsHover_borderColor' => array(
              'label' => 'Border color (hover)',
              'type' => 'color'
            )
          )
        ),
        'gutenberg_list' => array(
          'label' => 'List',
          'inputs' => array(
            'block__list_marker_value' => array(
              'label' => 'Marker value',
              'type' => 'input',
              'default' => '•',
              'quotemark' => '1'
            ),
            'block__list_marker_size' => array(
              'label' => 'Marker size',
              'type' => 'input',
              'default' => '150%'
            ),
            'block__list_lineHeight' => array(
              'label' => 'Marker line height',
              'type' => 'input'
            ),
            'block__list_marker_space' => array(
              'label' => 'Marker spacing',
              'type' => 'input'
            ),
            'gbList_marker_color' => array(
              'label' => 'Marker color',
              'type' => 'color',
              'default' => 'inherit'
            ),
            'dark__gbList_marker_color' => array(
              'label' => 'Marker color',
              'type' => 'color',
              'default' => 'inherit'
            ),
            'block__list_marker_size_mobile' => array(
              'label' => 'Marker size',
              'type' => 'input'
            ),
            'block__list_lineHeight_mobile' => array(
              'label' => 'Marker line height',
              'type' => 'input'
            ),
            'block__list_marker_space_mobile' => array(
              'label' => 'Marker spacing',
              'type' => 'input'
            )
          )
        ),
        'gutenberg_cover' => array(
          'label' => 'Cover',
          'inputs' => array(
            'block__cover_minHeight' => array(
              'label' => 'Minimum height',
              'type' => 'input'
            ),
            'block__cover_alignfull_minHeight' => array(
              'label' => 'Minimum height',
              'type' => 'input'
            ),
            'block__cover_alignwide_minHeight' => array(
              'label' => 'Minimum height',
              'type' => 'input'
            ),
            'block__cover_container_paddingTop' => array(
              'label' => 'Container padding top',
              'type' => 'input'
            ),
            'block__cover_container_paddingBottom' => array(
              'label' => 'Container padding bottom',
              'type' => 'input'
            ),
            'block__cover_zoomer_scale' => array(
              'label' => 'Background image zoom animation',
              'type' => 'input'
            ),
            'block__cover_minHeight_mobile' => array(
              'label' => 'Minimum height',
              'type' => 'input'
            ),
            'block__cover_alignfull_minHeight_mobile' => array(
              'label' => 'Minimum height',
              'type' => 'input'
            ),
            'block__cover_alignwide_minHeight_mobile' => array(
              'label' => 'Minimum height',
              'type' => 'input'
            ),
            'block__cover_container_paddingTop_mobile' => array(
              'label' => 'Container padding top',
              'type' => 'input'
            ),
            'block__cover_container_paddingBottom_mobile' => array(
              'label' => 'Container padding bottom',
              'type' => 'input'
            )
          )
        ),
        'gutenberg_table' => array(
          'label' => 'Table',
          'inputs' => array(
            'block__tableHead_fontFamily' => array(
              'label' => 'Head font family',
              'type' => 'input'
            ),
            'block__tableHead_fontSize' => array(
              'label' => 'Head font size',
              'type' => 'input'
            ),
            'block__tableHead_lineHeight' => array(
              'label' => 'Head line height',
              'type' => 'input'
            ),
            'block__tableHead_fontWeight' => array(
              'label' => 'Head font weight',
              'type' => 'input'
            ),
            'block__tableHead_textTransform' => array(
              'label' => 'Head text transform',
              'type' => 'input'
            ),
            'block__tableHead_letterSpacing' => array(
              'label' => 'Head letter spacing',
              'type' => 'input'
            ),
            'block__tableHead_fontSize_mobile' => array(
              'label' => 'Head font size',
              'type' => 'input'
            ),
            'block__tableHead_lineHeight_mobile' => array(
              'label' => 'Head line height',
              'type' => 'input'
            ),
            'block__tableHead_letterSpacing_mobile' => array(
              'label' => 'Head letter spacing',
              'type' => 'input'
            ),
            'block__table_fontFamily' => array(
              'label' => 'font family',
              'type' => 'input'
            ),
            'block__table_fontSize' => array(
              'label' => 'font size',
              'type' => 'input'
            ),
            'block__table_lineHeight' => array(
              'label' => 'line height',
              'type' => 'input'
            ),
            'block__table_fontWeight' => array(
              'label' => 'font weight',
              'type' => 'input'
            ),
            'block__table_textTransform' => array(
              'label' => 'text transform',
              'type' => 'input'
            ),
            'block__table_letterSpacing' => array(
              'label' => 'letter spacing',
              'type' => 'input'
            ),
            'block__table_fontSize_mobile' => array(
              'label' => 'font size',
              'type' => 'input'
            ),
            'block__table_lineHeight_mobile' => array(
              'label' => 'line height',
              'type' => 'input'
            ),
            'block__table_letterSpacing_mobile' => array(
              'label' => 'letter spacing',
              'type' => 'input'
            )
          )
        ),
        'gutenberg_quote' => array(
          'label' => 'Quote',
          'inputs' => array(
            'block__quote_color' => array(
              'label' => 'Color',
              'type' => 'color'
            ),
            'block__quote_bg' => array(
              'label' => 'Background color',
              'type' => 'color'
            ),
            'block__quote_borderColor' => array(
              'label' => 'Border color',
              'type' => 'color'
            ),
            'block__quote_borderWidth' => array(
              'label' => 'Border width',
              'type' => 'input'
            ),
            'block__quote_padding' => array(
              'label' => 'Padding',
              'type' => 'input'
            ),
            'block__quote_fontFamily' => array(
              'label' => 'Font family',
              'type' => 'input'
            ),
            'block__quote_fontSize' => array(
              'label' => 'Font size',
              'type' => 'input'
            ),
            'block__quote_lineHeight' => array(
              'label' => 'Line height',
              'type' => 'input'
            ),
            'block__quote_fontWeight' => array(
              'label' => 'Font weight',
              'type' => 'input'
            ),
            'block__quote_textTransform' => array(
              'label' => 'Text transform',
              'type' => 'input'
            ),
            'block__quote_letterSpacing' => array(
              'label' => 'Letter spacing',
              'type' => 'input'
            ),
            'block__quote_padding_mobile' => array(
              'label' => 'Padding',
              'type' => 'input'
            ),
            'block__quote_fontSize_mobile' => array(
              'label' => 'Font size',
              'type' => 'input'
            ),
            'block__quote_lineHeight_mobile' => array(
              'label' => 'Line height',
              'type' => 'input'
            ),
            'block__quote_cite_color' => array(
              'label' => 'Cite color',
              'type' => 'color'
            ),
            'block__quote_cite_bg' => array(
              'label' => 'Cite background color',
              'type' => 'color'
            ),
            'block__quote_cite_padding' => array(
              'label' => 'Cite padding',
              'type' => 'input'
            ),
            'block__quote_cite_fontFamily' => array(
              'label' => 'Cite font family',
              'type' => 'input'
            ),
            'block__quote_cite_fontSize' => array(
              'label' => 'Cite font size',
              'type' => 'input'
            ),
            'block__quote_cite_lineHeight' => array(
              'label' => 'Cite line height',
              'type' => 'input'
            ),
            'block__quote_cite_fontWeight' => array(
              'label' => 'Cite font weight',
              'type' => 'input'
            ),
            'block__quote_cite_textTransform' => array(
              'label' => 'Cite text transform',
              'type' => 'input'
            ),
            'block__quote_cite_letterSpacing' => array(
              'label' => 'Cite letter spacing',
              'type' => 'input'
            ),
            'block__quote_cite_padding_mobile' => array(
              'label' => 'Cite padding',
              'type' => 'input'
            ),
            'block__quote_cite_fontSize_mobile' => array(
              'label' => 'Cite font size',
              'type' => 'input'
            ),
            'block__quote_cite_lineHeight_mobile' => array(
              'label' => 'Cite line height',
              'type' => 'input'
            )
          )
        ),
        'gutenberg_accordion' => array(
          'label' => 'Accordion',
          'inputs' => array(
            'block__accordion_separator' => array(
              'label' => 'Space between accordions',
              'type' => 'input'
            ),
            'block__accordion_label_bg' => array(
              'label' => 'Label background color',
              'type' => 'color',
              'default' => '#0175bc'
            ),
            'block__accordion_label' => array(
              'label' => 'Label text color',
              'type' => 'color',
              'default' => '#ffffff'
            ),
            'block__accordion_label_spacing' => array(
              'label' => 'Space inside label',
              'type' => 'input'
            ),
            'block__accordion_label_fontfamily' => array(
              'label' => 'Label font family',
              'type' => 'input'
            ),
            'block__accordion_label_textTransform' => array(
              'label' => 'Label text transform',
              'type' => 'input'
            ),
            'block__accordion_label_letterSpacing' => array(
              'label' => 'Label letter spacing',
              'type' => 'input'
            ),
            'block__accordion_label_fontsize' => array(
              'label' => 'Label font-size',
              'type' => 'input'
            ),
            'block__accordion_label_fontweight' => array(
              'label' => 'Label font weight',
              'type' => 'input'
            ),
            'block__accordion_label_lineheight' => array(
              'label' => 'Label line-height',
              'type' => 'input'
            ),
            'block__accordion_label_spacing_mobile' => array(
              'label' => 'Space inside label',
              'type' => 'input'
            ),
            'block__accordion_label_fontsize_mobile' => array(
              'label' => 'Label font-size',
              'type' => 'input'
            ),
            'block__accordion_label_lineheight_mobile' => array(
              'label' => 'Label line-height',
              'type' => 'input'
            ),
            'block__accordion_iconbox_bg' => array(
              'label' => 'Iconbox background color',
              'type' => 'color',
              'default' => '#000000'
            ),
            'block__accordion_icon_borderRadius' => array(
              'label' => 'Iconbox radius',
              'type' => 'input'
            ),
            'block__accordion_icon_width' => array(
              'label' => 'Iconbox width',
              'type' => 'input'
            ),
            'block__accordion_icon_height' => array(
              'label' => 'Iconbox height',
              'type' => 'input'
            ),
            'block__accordion_icon_seperator' => array(
              'label' => 'Placeholder between text and icon',
              'type' => 'input'
            ),
            'block__accordion_icon_width_mobile' => array(
              'label' => 'Iconbox width',
              'type' => 'input'
            ),
            'block__accordion_icon_height_mobile' => array(
              'label' => 'Iconbox height',
              'type' => 'input'
            ),
            'block__accordion_label_arrow' => array(
              'label' => 'Plus sign color',
              'type' => 'color',
              'default' => '#89c0ff'
            ),
            'block__accordion_icon_plusSize' => array(
              'label' => 'Plus sign size',
              'type' => 'input'
            ),
            'block__accordion_icon_plusRadius' => array(
              'label' => 'Plus sign radius',
              'type' => 'input'
            ),
            'block__accordion_icon_plusWeight' => array(
              'label' => 'Plus sign weight',
              'type' => 'input'
            ),
            'block__accordion_content_bg' => array(
              'label' => 'toggled content background color',
              'type' => 'color',
              'default' => '#ffffff'
            ),
            'block__accordion_content' => array(
              'label' => 'toggled content text color',
              'type' => 'color',
              'default' => '#000000'
            ),
            'block__accordion_content_spacing' => array(
              'label' => 'Space inside toggled content',
              'type' => 'input'
            ),
            'block__accordion_content_fontsize' => array(
              'label' => 'Content font size',
              'type' => 'input'
            ),
            'block__accordion_content_lineheight' => array(
              'label' => 'Content line height',
              'type' => 'input'
            ),
            'block__accordion_content_spacing_mobile' => array(
              'label' => 'Space inside toggled content',
              'type' => 'input'
            ),
            'block__accordion_content_fontsize_mobile' => array(
              'label' => 'Content font size',
              'type' => 'input'
            ),
            'block__accordion_content_lineheight_mobile' => array(
              'label' => 'Content line height',
              'type' => 'input'
            )
          )
        ),
        'gutenberg_imagePins' => array(
          'label' => 'Image with pins',
          'inputs' => array(
            'imagePins__pinColor' => array(
              'label' => 'Pin color',
              'type' => 'color'
            ),
            'imagePins__pinColor_hover' => array(
              'label' => 'Pin color',
              'type' => 'color'
            ),
            'imagePins__pinColor_loaded' => array(
              'label' => 'Loaded pin color',
              'type' => 'color'
            ),
            'imagePins__pinSize' => array(
              'label' => 'Pin width',
              'type' => 'input'
            ),
            'imagePins__pinInfo_bc' => array(
              'label' => 'Info window background color',
              'type' => 'color'
            ),
            'imagePins__pinInfo_borderColor' => array(
              'label' => 'Info window border color',
              'type' => 'color'
            ),
            'imagePins__pinInfo_width' => array(
              'label' => 'Info window max width',
              'type' => 'input'
            ),
            'imagePins__pinInfo_padding' => array(
              'label' => 'Info window padding',
              'type' => 'input'
            ),
            'imagePins__pinInfo_borderWidth' => array(
              'label' => 'Info window border width',
              'type' => 'input'
            ),
            'imagePins__pinInfo_borderRadius' => array(
              'label' => 'Info window border radius',
              'type' => 'input'
            ),
            'imagePins__pinInfo_closeColor' => array(
              'label' => 'Pin color',
              'type' => 'color'
            ),
            'imagePins__pinInfo_closeColor_hover' => array(
              'label' => 'Pin color',
              'type' => 'color'
            ),
            'imagePins__pinInfo_closeSize' => array(
              'label' => 'Pin width',
              'type' => 'input'
            )
          )
        ),
        'gutenberg_video' => array(
          'label' => 'Video',
          'inputs' => array(
            'block__videojs_iconFont' => array(
              'label' => 'VideoJS Icons font family',
              'type' => 'input',
              'default' => 'VideoJS'
            ),
            'block__videojs_coverStart_bgColor' => array(
              'label' => 'VideoJS cover background color on start',
              'type' => 'color'
            ),
            'block__videojs_coverStart_opacity' => array(
              'label' => 'VideoJS cover opacity on start',
              'type' => 'input'
            ),
            'block__videojs_coverPause_bgColor' => array(
              'label' => 'VideoJS cover background color on pause',
              'type' => 'color'
            ),
            'block__videojs_coverPause_opacity' => array(
              'label' => 'VideoJS cover opacity on pause',
              'type' => 'input'
            ),
            'block__videojs_firstPlay_bgColor' => array(
              'label' => 'VideoJS big play button background color',
              'type' => 'color'
            ),
            'block__videojs_firstPlay_borderColor' => array(
              'label' => 'VideoJS big play button border color',
              'type' => 'color'
            ),
            'block__videojs_firstPlay_color' => array(
              'label' => 'VideoJS big play button icon color',
              'type' => 'color'
            ),
            'block__videojs_firstPlay_bgColor_hover' => array(
              'label' => 'VideoJS big play button background color',
              'type' => 'color'
            ),
            'block__videojs_firstPlay_borderColor_hover' => array(
              'label' => 'VideoJS big play button border color',
              'type' => 'color'
            ),
            'block__videojs_firstPlay_color_hover' => array(
              'label' => 'VideoJS big play button icon color',
              'type' => 'color'
            ),
            'block__videojs_firstPlay_size' => array(
              'label' => 'VideoJS big play button icon size',
              'type' => 'input'
            ),
            'block__videojs_firstPlay_size_mobile' => array(
              'label' => 'VideoJS big play button icon size',
              'type' => 'input'
            ),
            'block__videojs_firstPlay_padding' => array(
              'label' => 'VideoJS big play button padding',
              'type' => 'input'
            ),
            'block__videojs_firstPlay_borderWidth' => array(
              'label' => 'VideoJS big play button border width',
              'type' => 'input'
            ),
            'block__videojs_firstPlay_borderWidth_mobile' => array(
              'label' => 'VideoJS big play button border width',
              'type' => 'input'
            ),
            'block__videojs_firstPlay_borderRadius' => array(
              'label' => 'VideoJS big play button border radius',
              'type' => 'input'
            ),
            'block__videojs_controlBar_bgColor' => array(
              'label' => 'VideoJS control bar background color',
              'type' => 'color'
            ),
            'block__videojs_controlBar_spacing' => array(
              'label' => 'VideoJS control bar spacing',
              'type' => 'input'
            ),
            'block__videojs_controlBar_borderRadius' => array(
              'label' => 'VideoJS control bar border radius',
              'type' => 'input'
            ),
            'block__videojs_controlBar_padding' => array(
              'label' => 'VideoJS control bar padding',
              'type' => 'input'
            ),
            'block__videojs_controlBar_gap' => array(
              'label' => 'VideoJS control bar gap',
              'type' => 'input'
            ),
            'block__videojs_controlBarButton_color' => array(
              'label' => 'VideoJS control bar icon color',
              'type' => 'color'
            ),
            'block__videojs_controlBarButton_color_hover' => array(
              'label' => 'VideoJS control bar icon color',
              'type' => 'color'
            ),
            'block__videojs_controlBarButton_fontSize' => array(
              'label' => 'VideoJS Icons icon size',
              'type' => 'input'
            ),
            'block__videojs_progress_bgColor' => array(
              'label' => 'VideoJS progress bar background color',
              'type' => 'color'
            ),
            'block__videojs_progress_height' => array(
              'label' => 'VideoJS progress bar height',
              'type' => 'input'
            ),
            'block__videojs_progress_button_color' => array(
              'label' => 'VideoJS progress bar button',
              'type' => 'color'
            ),
            'block__videojs_progress_button_fontSize' => array(
              'label' => 'VideoJS progress bar button size',
              'type' => 'input'
            ),
            'block__videojs_progress_passed_bgColor' => array(
              'label' => 'VideoJS passed progress bar',
              'type' => 'color'
            ),
            'block__videojs_progress_remainingTime_color' => array(
              'label' => 'VideoJS remaining time color',
              'type' => 'color'
            ),
            'block__videojs_progress_remainingTime_fontSize' => array(
              'label' => 'VideoJS remaining time font size',
              'type' => 'input'
            ),
            'block__videojs_tooltip_bgColor' => array(
              'label' => 'VideoJS tooltip background color',
              'type' => 'color'
            ),
            'block__videojs_tooltip_Color' => array(
              'label' => 'VideoJS tooltip color',
              'type' => 'color'
            ),
            'bblock__videojs_tooltip_fontSize' => array(
              'label' => 'VideoJS tooltip font size',
              'type' => 'input'
            ),
            'bblock__videojs_tooltip_lineHeight' => array(
              'label' => 'VideoJS tooltip line height',
              'type' => 'input'
            ),
            'block__videojs_tooltip_decoSize' => array(
              'label' => 'VideoJS tooltip decoration size',
              'type' => 'input'
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
            'footer_background' => array(
              'label' => 'Footer background color',
              'type' => 'color',
              'default' => '#f9f9f9'
            ),
            'footercontainer_background' => array(
              'label' => 'Footer container background color',
              'type' => 'color',
              'default' => 'transparent'
            ),
            'footer_color' => array(
              'label' => 'Text color',
              'type' => 'color'
            ),
            'footer_link_color' => array(
              'label' => 'Link color',
              'type' => 'color'
            ),
            'footer_linkHover_color' => array(
              'label' => 'Link hover color',
              'type' => 'color'
            ),
            'dark__footer_background' => array(
              'label' => 'Footer background',
              'type' => 'color',
              'default' => '#1d1e1f'
            ),
            'dark__footercontainer_background' => array(
              'label' => 'Footer container background',
              'type' => 'color',
              'default' => 'transparent'
            ),
            'dark__footer_color' => array(
              'label' => 'Text color',
              'type' => 'color'
            ),
            'dark__footer_link_color' => array(
              'label' => 'Link color',
              'type' => 'color'
            ),
            'dark__footer_linkHover_color' => array(
              'label' => 'Link hover color',
              'type' => 'color'
            )
          )
        ),
        'footer_desktop' => array(
          'label' => 'Desktop',
          'inputs' => array(
            'footer__fontsize' => array(
              'label' => 'Footer font size',
              'type' => 'input'
            ),
            'footer__lineheight' => array(
              'label' => 'Footer line height',
              'type' => 'input'
            ),
            'footer__paddingTop' => array(
              'label' => 'Container padding top',
              'type' => 'input',
            ),
            'footer__paddingBottom' => array(
              'label' => 'Container padding bottom',
              'type' => 'input'
            ),
            'footer_itemSpacing' => array(
              'label' => 'Item Spacing (vertical)',
              'type' => 'input'
            )
          )
        ),
        'footer_mobile' => array(
          'label' => 'Mobile',
          'inputs' => array(
            'footer__fontsize_mobile' => array(
              'label' => 'Footer font size',
              'type' => 'input'
            ),
            'footer__lineheight_mobile' => array(
              'label' => 'Footer line height',
              'type' => 'input'
            ),
            'footer__paddingTop_mobile' => array(
              'label' => 'Container padding top',
              'type' => 'input'
            ),
            'footer__paddingBottom_mobile' => array(
              'label' => 'Container padding bottom',
              'type' => 'input'
            ),
            'footer_itemSpacing_mobile' => array(
              'label' => 'Item Spacing (vertical)',
              'type' => 'input'
            )
          )
        ),
        'footerMenu' => array(
          'label' => 'Menu',
          'inputs' => array(
            'footer__menu_link_color' => array(
              'label' => 'Link color',
              'type' => 'color'
            ),
            'footer__menu_linkHover_color' => array(
              'label' => 'Link hover color',
              'type' => 'color'
            ),
            'footer__menu_link_fontfamily' => array(
              'label' => 'Link font family',
              'type' => 'input'
            ),
            'footer__menu_link_fontsize' => array(
              'label' => 'Link font size',
              'type' => 'input'
            ),
            'footer__menu_link_lineheight' => array(
              'label' => 'Link line height',
              'type' => 'input'
            ),
            'footer__menu_link_fontWeight' => array(
              'label' => 'Link font weight',
              'type' => 'input'
            ),
            'footer__menu_link_textTransform' => array(
              'label' => 'Link text transform',
              'type' => 'input'
            ),
            'footer__menu_link_letterSpacing' => array(
              'label' => 'Link letter spacing',
              'type' => 'input'
            ),
            'footer__menu_link_fontsize_mobile' => array(
              'label' => 'Link font size',
              'type' => 'input'
            ),
            'footer__menu_link_lineheight_mobile' => array(
              'label' => 'Link line height',
              'type' => 'input'
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
    add_action('admin_enqueue_scripts', array( $this, 'customizerEnqueue' ));
    // add preview css to customizer
    add_action( 'customize_preview_init', array($this, 'customizerPreview') );
    // create new customizer file after saving customizer
    add_action( 'customize_save_after', array($this, 'generateCusomizerFile') );
    // update DB
    add_action( 'admin_init', array($this, 'updateThemeMods') );
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
      __('Background color', 'devTheme'),
      __('Font color', 'devTheme'),
      __('Marker text color', 'devTheme'),
      __('Marker background color', 'devTheme'),
      __('Typography', 'devTheme'),
      __('Main font family', 'devTheme'),
      __('Main font size', 'devTheme'),
      __('Main line height', 'devTheme'),
      __('Main font weight', 'devTheme'),
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
      __('Header background', 'devTheme'),
      __('header container background', 'devTheme'),
      __('Menu', 'devTheme'),
      __('Main menu font size', 'devTheme'),
      __('Main menu line height', 'devTheme'),
      __('Main menu font size', 'devTheme'),
      __('Main menu line height', 'devTheme'),
      __('Hamburger', 'devTheme'),
      __('Hamburger color', 'devTheme'),
      __('Hamburger navigation background color', 'devTheme'),
      __('Hamburger color', 'devTheme'),
      __('Hamburger navigation background color', 'devTheme'),
      __('Title spacing', 'devTheme'),
      __('Blur Content while hamburger navigation is open', 'devTheme'),
      __('Content area', 'devTheme'),
      __('Desktop', 'devTheme'),
      __('Content spacing', 'devTheme'),
      __('Background color', 'devTheme'),
      __('Border width', 'devTheme'),
      __('Border color', 'devTheme'),
      __('Required color', 'devTheme'),
      __('Padding', 'devTheme'),
      __('Padding mobile', 'devTheme'),
      __('Anchor position', 'devTheme'),
      __('Mobile', 'devTheme'),
      __('Content spacing', 'devTheme'),
      __('Input padding', 'devTheme'),
      __('Anchor position', 'devTheme'),
      __('Gutenberg Blocks', 'devTheme'),
      __('Seperator', 'devTheme'),
      __('Default color', 'devTheme'),
      __('Default color', 'devTheme'),
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
      __('Text color', 'devTheme'),
      __('Link color', 'devTheme'),
      __('Link hover color', 'devTheme'),
      __('Footer background', 'devTheme'),
      __('Footer container background', 'devTheme'),
      __('Text color', 'devTheme'),
      __('Link color', 'devTheme'),
      __('Link hover color', 'devTheme'),
      __('Desktop', 'devTheme'),
      __('Footer font size', 'devTheme'),
      __('Footer line height', 'devTheme'),
      __('Container padding top', 'devTheme'),
      __('Container padding bottom', 'devTheme'),
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

    // label addOns
    $activeLabels = array();
    $labelAdd = '';
    // add labels
    if (strpos($inputKey, 'dark__') !== false):
      $activeLabels[] = __( 'dark mode', 'customizer' );
    endif;
    if (strpos($inputKey, '_sticky') !== false):
      $activeLabels[] = __( 'sticky', 'customizer' );
    endif;
    if (strpos($inputKey, '_alignfull') !== false):
      $activeLabels[] = __( 'alignfull', 'customizer' );
    endif;
    if (strpos($inputKey, '_alignwide') !== false):
      $activeLabels[] = __( 'alignwide', 'customizer' );
    endif;
    if (strpos($inputKey, '_hasBackground') !== false):
      $activeLabels[] = __( 'has background', 'customizer' );
    endif;
    if (strpos($inputKey, '_mobile') !== false):
      $activeLabels[] = __( 'mobile', 'customizer' );
    endif;
    if (strpos($inputKey, '_hover') !== false):
      $activeLabels[] = __( 'hover', 'customizer' );
    endif;
    // build labels
    if(!empty($activeLabels)):
      $labelAdd .= ' [';
        $labelAdd .= implode(" | ",$activeLabels);
      $labelAdd .= ']';
    endif;

    // add featured category settings and controls.
    // https://developer.wordpress.org/reference/classes/wp_customize_control/__construct/
    if($inputValues["type"] == 'color'):
      $wp_customize->add_setting($inputKey, array(
        'transport'         => 'postMessage',
        'default'           => array_key_exists('default', $inputValues) ? $inputValues["default"] : '',
        'sanitize_callback' => 'sanitize_hex_color',
      ));
      $wp_customize->add_control(new WP_Customize_Color_Control( $wp_customize, $inputKey, array(
       'label'    => __( $inputValues["label"], 'customizer' ) . $labelAdd,
       'section'  => $sectionKey,
       'priority' => 1
     )));
    else:
      $wp_customize->add_setting($inputKey, array(
        'transport'         => 'postMessage',
        'default'           => array_key_exists('default', $inputValues) ? $inputValues["default"] : '',
        'sanitize_callback' => 'wp_filter_nohtml_kses',
      ));
     $wp_customize->add_control($inputKey, array(
      'label'    => __( $inputValues["label"], 'customizer' ) . $labelAdd,
      'section'  => $sectionKey,
      'type'     => 'input',
      'priority' => 1
     ));
    endif;
  }


  /* 1.4 THEME MOD UPDATE
  /------------------------*/
  function updateThemeMods(){
    $getModsUpdate = get_option( 'theme_mods_childtheme_update' ) ? get_option('theme_mods_childtheme_update') : 0;
    // check if update exists
    if($getModsUpdate == 0):
      // get mod options
      $getMods = get_option( 'theme_mods_childtheme' ) ? get_option('theme_mods_childtheme') : false;
      if($getMods):
        $updateMods = array();
        foreach ($getMods as $key => $mod) {

          // 1. update (remove light__ from keys)
          if($getModsUpdate < 1):
            if(strpos($key, 'light__') !== false):
              $newKey = str_replace('light__', '', $key);
              $updateMods[$newKey] = $mod;
            else:
              $updateMods[$key] = $mod;
            endif;
          endif;

        }
        update_option('theme_mods_childtheme', $updateMods, false);
        // update the update nr.
        update_option('theme_mods_childtheme_update', 1, false);
      endif;
    endif;



    // check if value exists

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
    $mobileDarkOutput = '';
    $darkOutput = '';
    $mobileOutput = '';
    $output = '';
    $output .= ':root {';
      $output .= '--wideWidth: ' . $wide_reset . 'px;';
      foreach ($this->defaultValues as $panelKey => $panelValues) {
        foreach ($panelValues["sections"] as $sectionKey => $sectionValues) {
          foreach ($sectionValues["inputs"] as $valueKey => $ValueSettings) {
            $quotemark = array_key_exists("quotemark",$ValueSettings) && $ValueSettings["quotemark"]  == '1' ? '"' : '';
            $insert = htmlspecialchars(get_theme_mod($valueKey, $ValueSettings["default"]));
            if($insert !== ''):
              if(strpos($valueKey, 'dark__') !== false && strpos($valueKey, '_mobile') !== false):
                // move to mobile dark mode
                $mobileDarkOutput .= '--' . str_replace(arrray('dark__', '_mobile'), array('', ''), $valueKey) . ': ' . $quotemark . $insert . $quotemark . ';';
              elseif(strpos($valueKey, 'dark__') !== false):
                // move to dark mode
                $darkOutput .= '--' . str_replace('dark__', '', $valueKey) . ': ' . $quotemark . $insert . $quotemark . ';';
              elseif (strpos($valueKey, '_mobile') !== false):
                // move to mobile
                $mobileOutput .= '--' . str_replace('_mobile', '', $valueKey) . ': ' . $quotemark . $insert . $quotemark . ';';
              else:
                if($valueKey == 'gutenberg__font_scale'):
                  $output .= '--' . $valueKey . ': ' . $quotemark . '1' . $quotemark . ';';
                  $mobileOutput .= '--' . $valueKey . ': ' . $quotemark . $insert . $quotemark . ';';
                else:
                  $output .= '--' . $valueKey . ': ' . $quotemark . $insert . $quotemark . ';';
                endif;
              endif;
            endif;
          }
        }
      }
    $output .= '}';
    // dark mode
    $output .= '.dark {';
      $output .= $darkOutput;
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
        // $output .= '.wp-block-columns:not(.is-not-stacked-on-mobile) {';
        //   $output .= '--block__columns_hasBackground_gap: 0;';
        // $output .= '}';
      endif;
      if($mobileDarkOutput !== ''):
        $output .= '.dark {';
          $output .= $mobileDarkOutput;
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
    if (empty($wp_filesystem)):
      require_once(ABSPATH .'/wp-admin/includes/file.php');
      WP_Filesystem();
    endif;
    // save file
    if ( ! $wp_filesystem->put_contents( $aq_uploads_dir . 'customizer.css', $output, FS_CHMOD_FILE) ):
      return true;
    endif;
  }



  /*==================================================================================
    3.0 OUTPUT
  ==================================================================================*/

  /* 3.1 PREVIEW CUSTOMIZER CHANGES
  /------------------------*/
  function customizerPreview() {
    wp_enqueue_script('theme/customizer', get_template_directory_uri() . '/classes/prefix_core_Customizer/assets/theme-customizer.js', ['jquery', 'customize-preview'], '0.1', true);
  }

}
