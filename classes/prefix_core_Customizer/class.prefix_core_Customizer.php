<?php
/**
 *
 *
 * Customizer extension
 * Author:      David Voglgsnag
 * @version     1.11
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
    'panel_one' => array(
      'label' => 'Panel 1',
      'panels' => array(
        'panel_two' => array(
          'label' => 'Panel 2',
          'sections' => array(
            'sectionone' => array(
              'label' => 'Section 1',
              'inputs' => array(
                'inputone' => array(
                  'label' => 'Label',
                  'type' => 'input'
                )
              )
            ),
            'sectiontwo' => array(
              'label' => 'Section 2',
              'inputs' => array(
                'inputtwo' => array(
                  'label' => 'Label',
                  'type' => 'input'
                )
              )
            )
          )
        )
      )
    )
  );


  private $defaultValues = array(
    'settings' => array(
      'label' => 'Settings',
      'panels' => array(),
      'sections' => array(
        'breakpoints' => array(
          'label' => 'Breakpoints',
          'inputs' => array(
            'mobile_breakpoint' => array(
              'label' => 'Mobile',
              'type' => 'input',
              'default' => '768px'
            )
          )
        ),
        'container' => array(
          'label' => 'Container',
          'inputs' => array(
            'container__width' => array(
              'label' => 'Width',
              'type' => 'input',
              'default' => '1000px'
            ),
            'container__side' => array(
              'label' => 'Side padding',
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
            'container__side_mobile' => array(
              'label' => 'Container side padding',
              'type' => 'input'
            )
          )
        ),
        'coloring' => array(
          'label' => 'Default colors',
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
            'main_background' => array(
              'label' => 'Background color',
              'type' => 'color',
              'default' => '#f9f9f9'
            ),
            'main_color' => array(
              'label' => 'Font color',
              'type' => 'color',
              'default' => '#343434'
            ),
            'link__color' => array(
              'label' => 'Link color',
              'type' => 'color'
            ),
            'link__color_hover' => array(
              'label' => 'Link color',
              'type' => 'color'
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
            'dark__link__color' => array(
              'label' => 'Link color',
              'type' => 'color'
            ),
            'dark__link__color_hover' => array(
              'label' => 'Link color',
              'type' => 'color'
            ),
            'dark__text__marked' => array(
              'label' => 'Marker text color',
              'type' => 'color',
              'default' => '#ffffff'
            ),
            'dark__text__marked_bg' => array(
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
              'label' => 'Font family',
              'type' => 'input'
            ),
            'html__fontsize' => array(
              'label' => 'Font size',
              'type' => 'input'
            ),
            'html__lineheight' => array(
              'label' => 'Line height',
              'type' => 'input'
            ),
            'html__fontweight' => array(
              'label' => 'Main font weight',
              'type' => 'select'
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
          'label' => 'Typography (Mobile)',
          'inputs' => array(
            'html__fontsize_mobile' => array(
              'label' => 'Font size',
              'type' => 'input'
            ),
            'html__lineheight_mobile' => array(
              'label' => 'Line height',
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
        )
      )
    ),
    'header' => array(
      'label' => 'Header',
      'panels' => array(
        'header_settings' => array(
          'label' => 'Settings',
          'sections' => array(
            'header_colors' => array(
              'label' => 'Colors',
              'inputs' => array(
                'header_background' => array(
                  'label' => 'Background color',
                  'type' => 'color',
                  'default' => '#f9f9f9'
                ),
                'headercontainer_background' => array(
                  'label' => 'Container background color',
                  'type' => 'color',
                  'default' => 'transparent'
                ),
                'dark__header_background' => array(
                  'label' => 'Background',
                  'type' => 'color',
                  'default' => '#1d1e1f'
                ),
                'dark__headercontainer_background' => array(
                  'label' => 'Container background color',
                  'type' => 'color',
                  'default' => 'transparent'
                )
              )
            ),
            'header_spacing' => array(
              'label' => 'Spacing',
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
                  'label' => 'Horizontal spacing between items',
                  'type' => 'input'
                ),
                'header__itemSpacingVertical' => array(
                  'label' => 'Vertical spacing between items',
                  'type' => 'input'
                ),
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
                  'label' => 'Horizontal spacing between items',
                  'type' => 'input'
                ),
                'header__itemSpacingVertical_mobile' => array(
                  'label' => 'Vertical spacing between items',
                  'type' => 'input'
                )
              )
            )
          )
        ),
        'mainmenu' => array(
          'label' => 'Main Menu',
          'sections' => array(
            'mainmenu_settings' => array(
              'label' => 'Settings',
              'inputs' => array(
                'mnav__ul_paddingTop' => array(
                  'label' => 'Padding top',
                  'type' => 'input'
                ),
                'mnav__ul_paddingBottom' => array(
                  'label' => 'Padding bottom',
                  'type' => 'input'
                ),
                'mnav__ul_lastChild_marginBottom' => array(
                  'label' => 'Last child margin bottom',
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
                'mnav__ul_lastChild_marginBottom_mobile' => array(
                  'label' => 'Last child margin bottom',
                  'type' => 'input'
                )
              )
            ),
            'mainmenu_toggle' => array(
              'label' => 'Toggler',
              'inputs' => array(
                'submenu__toggle_width' => array(
                  'label' => 'Container width',
                  'type' => 'input'
                ),
                'submenu__toggle_padding' => array(
                  'label' => 'Container padding',
                  'type' => 'input'
                ),
                'submenu__toggle_strokeWidth' => array(
                  'label' => 'Stroke width',
                  'type' => 'input'
                ),
                'submenu__toggle_width_mobile' => array(
                  'label' => 'Container width',
                  'type' => 'input'
                ),
                'submenu__toggle_padding_mobile' => array(
                  'label' => 'Container padding',
                  'type' => 'input'
                ),
                'submenu__toggle_strokeWidth_mobile' => array(
                  'label' => 'Stroke width',
                  'type' => 'input'
                )
              )
            ),
            'mainmenu_level1' => array(
              'label' => 'Level 1',
              'inputs' => array(
                'mnav__ul_gap' => array(
                  'label' => 'Gap',
                  'type' => 'input'
                ),
                // 'mnav__ul_flexDirection' => array(
                //   'label' => 'Direction',
                //   'type' => 'select'
                // ),
                'mnav__ul_gap_mobile' => array(
                  'label' => 'Gap',
                  'type' => 'input'
                ),
                // 'mnav__ul_flexDirection_mobile' => array(
                //   'label' => 'Direction',
                //   'type' => 'select'
                // ),
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
                  'label' => 'Color',
                  'type' => 'color',
                  'default' => '#000000'
                ),
                'mnav__background_color_hover' => array(
                  'label' => 'Background color',
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
                  'type' => 'select'
                ),
                'mnav__lineheight' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'mnav__textTransform' => array(
                  'label' => 'Text transform',
                  'type' => 'select'
                ),
                'mnav__fontStyle' => array(
                  'label' => 'Font style',
                  'type' => 'select',
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
                'dark__mnav__color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'dark__mnav__background_color' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__mnav__color_hover' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'dark__mnav__background_color_hover' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__mnav__color_active' => array(
                  'label' => 'Color (active)',
                  'type' => 'color'
                ),
                'dark__mnav__background_color_active' => array(
                  'label' => 'Background color (active)',
                  'type' => 'color'
                ),
                'dark__mnav__border_color' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                )
              )
            ),
            'mainmenu_level2' => array(
              'label' => 'Level 2',
              'inputs' => array(
                'mnav__sub_gap' => array(
                  'label' => 'Gap',
                  'type' => 'input'
                ),
                'mnav__sub_flexDirection' => array(
                  'label' => 'Direction',
                  'type' => 'select'
                ),
                'mnav__sub_gap_mobile' => array(
                  'label' => 'Gap',
                  'type' => 'input'
                ),
                'mnav__sub_flexDirection_mobile' => array(
                  'label' => 'Direction',
                  'type' => 'select'
                ),
                'mnav__sub_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'mnav__sub_background_color' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'mnav__sub_color_hover' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'mnav__sub_background_color_hover' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'mnav__sub_color_active' => array(
                  'label' => 'Color (active)',
                  'type' => 'color'
                ),
                'mnav__sub_background_color_active' => array(
                  'label' => 'Background color (active)',
                  'type' => 'color'
                ),
                'mnav__sub_border_color' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'mnav__sub_border_width' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'mnav__sub_padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'mnav__sub_margin' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'mnav__sub_fontfamily' => array(
                  'label' => 'Font family',
                  'type' => 'input'
                ),
                'mnav__sub_fontsize' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'mnav__sub_lineheight' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'mnav__sub_fontWeight' => array(
                  'label' => 'Font weight',
                  'type' => 'select'
                ),
                'mnav__sub_textTransform' => array(
                  'label' => 'Text transform',
                  'type' => 'select'
                ),
                'mnav__sub_fontStyle' => array(
                  'label' => 'Font style',
                  'type' => 'select'
                ),
                'mnav__sub_letterSpacing' => array(
                  'label' => 'Letter spacing',
                  'type' => 'input'
                ),
                'mnav__sub_border_width_mobile' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'mnav__sub_fontsize_mobile' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'mnav__sub_lineheight_mobile' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'mnav__sub_padding_mobile' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'mnav__sub_margin_mobile' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'dark__mnav__sub_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'dark__mnav__sub_background_color' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__mnav__sub_color_hover' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'dark__mnav__sub_background_color_hover' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__mnav__sub_color_active' => array(
                  'label' => 'Color (active)',
                  'type' => 'color'
                ),
                'dark__mnav__sub_background_color_active' => array(
                  'label' => 'Background color (active)',
                  'type' => 'color'
                ),
                'dark__mnav__sub_border_color' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                )
              )
            ),
            'mainmenu_level3' => array(
              'label' => 'Level 3',
              'inputs' => array(
                'mnav__subSub_gap' => array(
                  'label' => 'Gap',
                  'type' => 'input'
                ),
                'mnav__subSub_flexDirection' => array(
                  'label' => 'Direction',
                  'type' => 'select'
                ),
                'mnav__subSub_gap_mobile' => array(
                  'label' => 'Gap',
                  'type' => 'input'
                ),
                'mnav__subSub_flexDirection_mobile' => array(
                  'label' => 'Direction',
                  'type' => 'select'
                ),
                'mnav__subSub_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'mnav__subSub_background_color' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'mnav__subSub_color_hover' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'mnav__subSub_background_color_hover' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'mnav__subSub_color_active' => array(
                  'label' => 'Color (active)',
                  'type' => 'color'
                ),
                'mnav__subSub_background_color_active' => array(
                  'label' => 'Background color (active)',
                  'type' => 'color'
                ),
                'mnav__subSub_border_color' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'mnav__subSub_border_width' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'mnav__subSub_padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'mnav__subSub_margin' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'mnav__subSub_fontfamily' => array(
                  'label' => 'Font family',
                  'type' => 'input'
                ),
                'mnav__subSub_fontsize' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'mnav__subSub_fontWeight' => array(
                  'label' => 'Font weight',
                  'type' => 'select'
                ),
                'mnav__subSub_lineheight' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'mnav__subSub_textTransform' => array(
                  'label' => 'Text transform',
                  'type' => 'select'
                ),
                'mnav__subSub_fontStyle' => array(
                  'label' => 'Font style',
                  'type' => 'select'
                ),
                'mnav__subSub_letterSpacing' => array(
                  'label' => 'Letter spacing',
                  'type' => 'input'
                ),
                'mnav__subSub_border_width_mobile' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'mnav__subSub_fontsize_mobile' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'mnav__subSub_lineheight_mobile' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'mnav__subSub_padding_mobile' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'mnav__subSub_margin_mobile' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'dark__mnav__subSub_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'dark__mnav__subSub_background_color' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__mnav__subSub_color_hover' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'dark__mnav__subSub_background_color_hover' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__mnav__subSub_color_active' => array(
                  'label' => 'Color (active)',
                  'type' => 'color'
                ),
                'dark__mnav__subSub_background_color_active' => array(
                  'label' => 'Background color (active)',
                  'type' => 'color'
                ),
                'dark__mnav__subSub_border_color' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                )
              )
            ),
            'mainmenu_level4' => array(
              'label' => 'Level 4',
              'inputs' => array(
                'mnav__subSubSub_gap' => array(
                  'label' => 'Gap',
                  'type' => 'input'
                ),
                'mnav__subSubSub_flexDirection' => array(
                  'label' => 'Direction',
                  'type' => 'select'
                ),
                'mnav__subSubSub_gap_mobile' => array(
                  'label' => 'Gap',
                  'type' => 'input'
                ),
                'mnav__subSubSub_flexDirection_mobile' => array(
                  'label' => 'Direction',
                  'type' => 'select'
                ),
                'mnav__subSubSub_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'mnav__subSubSub_background_color' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'mnav__subSubSub_color_hover' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'mnav__subSubSub_background_color_hover' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'mnav__subSubSub_color_active' => array(
                  'label' => 'Color (active)',
                  'type' => 'color'
                ),
                'mnav__subSubSub_background_color_active' => array(
                  'label' => 'Background color (active)',
                  'type' => 'color'
                ),
                'mnav__subSubSub_border_color' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'mnav__subSubSub_border_width' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'mnav__subSubSub_padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'mnav__subSubSub_margin' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'mnav__subSubSub_fontfamily' => array(
                  'label' => 'Font family',
                  'type' => 'input'
                ),
                'mnav__subSubSub_fontsize' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'mnav__subSubSub_fontWeight' => array(
                  'label' => 'Font weight',
                  'type' => 'select'
                ),
                'mnav__subSubSub_lineheight' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'mnav__subSubSub_textTransform' => array(
                  'label' => 'Text transform',
                  'type' => 'select'
                ),
                'mnav__subSubSub_fontStyle' => array(
                  'label' => 'Font style',
                  'type' => 'select'
                ),
                'mnav__subSubSub_letterSpacing' => array(
                  'label' => 'Letter spacing',
                  'type' => 'input'
                ),
                'mnav__subSubSub_border_width_mobile' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'mnav__subSubSub_fontsize_mobile' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'mnav__subSubSub_lineheight_mobile' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'mnav__subSubSub_padding_mobile' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'mnav__subSubSub_margin_mobile' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'dark__mnav__subSubSub_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'dark__mnav__subSubSub_background_color' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__mnav__subSubSub_color_hover' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'dark__mnav__subSubSub_background_color_hover' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__mnav__subSubSub_color_active' => array(
                  'label' => 'Color (active)',
                  'type' => 'color'
                ),
                'dark__mnav__subSubSub_background_color_active' => array(
                  'label' => 'Background color (active)',
                  'type' => 'color'
                ),
                'dark__mnav__subSubSub_border_color' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                )
              )
            )
          )
        ),
        'hamburger' => array(
          'label' => 'Hamburger',
          'sections' => array(
            'hamburger_settings' => array(
              'label' => 'Settings',
              'inputs' => array(
                'hamburger_color' => array(
                  'label' => 'Hamburger color',
                  'type' => 'color',
                  'default' => '#000000'
                ),
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
                'content__blur_activemenu' => array(
                  'label' => 'Blur Content while hamburger navigation is open',
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
                'dark__hamburger_color' => array(
                  'label' => 'Color',
                  'type' => 'color',
                  'default' => '#ffffff'
                )
              )
            ),
            'hamburger_title' => array(
              'label' => 'Title',
              'inputs' => array(
                'hamburger_text_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'hamburger__title_space' => array(
                  'label' => 'Spacing',
                  'type' => 'input'
                ),
                'hamburger__title_fontSize' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'hamburger__title_LineHeight' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'hamburger__title_fontWeight' => array(
                  'label' => 'Font weight',
                  'type' => 'select'
                ),
                'hamburger__title_space_mobile' => array(
                  'label' => 'Spacing',
                  'type' => 'input'
                ),
                'hamburger__title_fontSize_mobile' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'hamburger__title_LineHeight_mobile' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'dark__hamburger_text_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                )
              )
            ),
            'hamburger_menu' => array(
              'label' => 'Menu',
              'inputs' => array(
                'mnav_background' => array(
                  'label' => 'Menu background color',
                  'type' => 'color',
                  'default' => '#f9f9f9'
                ),
                'dark__mnav_background' => array(
                  'label' => 'Menu background color',
                  'type' => 'color',
                  'default' => '#1d1e1f'
                )
              )
            )
          )
        )
      ),
      'sections' => array()
    ),
    'tmp' => array(
      'label' => 'Template parts',
      'panels' => array(
        'tmp_spacing' => array(
          'label' => 'Content spacing',
          'sections' => array(
            'tmp_spacing_default' => array(
              'label' => 'Default spacings',
              'inputs' => array(
                'content__space' => array(
                  'label' => 'Space between elements',
                  'type' => 'input'
                ),
                'content__space_last' => array(
                  'label' => 'Last element spacing',
                  'type' => 'input'
                ),
                'html__anchor' => array(
                  'label' => 'Anchor position (IE fix)',
                  'type' => 'input',
                  'default' => '100px'
                ),
                'content__space_mobile' => array(
                  'label' => 'Space between elements',
                  'type' => 'input'
                ),
                'content__space_last_mobile' => array(
                  'label' => 'Last element spacing',
                  'type' => 'input'
                ),
                'html__anchor_mobile' => array(
                  'label' => 'Anchor position (IE fix)',
                  'type' => 'input',
                  'default' => '120px'
                )
              )
            ),
            'tmp_spacing_rules' => array(
              'label' => 'Override spacing rules',
              'inputs' => array(
                'content__space_one' => array(
                  'label' => 'Rule 1',
                  'type' => 'input'
                ),
                'content__space_two' => array(
                  'label' => 'Rule 2',
                  'type' => 'input'
                ),
                'content__space_one_mobile' => array(
                  'label' => 'Rule 1',
                  'type' => 'input'
                ),
                'content__space_two_mobile' => array(
                  'label' => 'Rule 2',
                  'type' => 'input'
                )
              )
            )
          )
        ),
        'tmp_menuItem' => array(
          'label' => 'Menu items',
          'sections' => array(
            'tmp_menuItem_svg' => array(
              'label' => 'SVG',
              'inputs' => array(
                'menuItem__svg_fillColor' => array(
                  'label' => 'Filling color',
                  'type' => 'color'
                ),
                'menuItem__svg_strokeColor' => array(
                  'label' => 'stroking color',
                  'type' => 'color'
                ),
                'menuItem__svg_fillColor_hover' => array(
                  'label' => 'Filling color',
                  'type' => 'color'
                ),
                'menuItem__svg_strokeColor_hover' => array(
                  'label' => 'stroking color',
                  'type' => 'color'
                ),
                'dark__menuItem__svg_fillColor' => array(
                  'label' => 'Filling color',
                  'type' => 'color'
                ),
                'dark__menuItem__svg_strokeColor' => array(
                  'label' => 'stroking color',
                  'type' => 'color'
                ),
                'dark__menuItem__svg_fillColor_hover' => array(
                  'label' => 'Filling color',
                  'type' => 'color'
                ),
                'dark__menuItem__svg_strokeColor_hover' => array(
                  'label' => 'stroking color',
                  'type' => 'color'
                )
              )
            ),
            'tmp_menuItem_svgBehind' => array(
              'label' => 'SVG behind link',
              'inputs' => array(
                'menuItem__svg_positionBehind_opacity' => array(
                  'label' => 'Opacity',
                  'type' => 'input'
                ),
                'menuItem__svg_positionBehind_opacity_hover' => array(
                  'label' => 'Opacity',
                  'type' => 'input'
                )
              )
            ),
            'tmp_menuItem_svgContainer' => array(
              'label' => 'SVG left container',
              'inputs' => array(
                'menuItem__svg_positionLeft_backgroundColor' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'menuItem__svg_positionLeft_borderColor' => array(
                  'label' => 'border color',
                  'type' => 'color'
                ),
                'menuItem__svg_positionLeft_backgroundColor_hover' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'menuItem__svg_positionLeft_borderColor_hover' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'menuItem__svg_positionLeft_width' => array(
                  'label' => 'Width',
                  'type' => 'input'
                ),
                'menuItem__svg_positionLeft_borderRadius' => array(
                  'label' => 'Border radius',
                  'type' => 'input'
                ),
                'menuItem__svg_positionLeft_borderStyle' => array(
                  'label' => 'Border style',
                  'type' => 'select'
                ),
                'menuItem__svg_positionLeft_borderWidth' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'menuItem__svg_positionLeft_margin' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'menuItem__svg_positionLeft_padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'menuItem__svg_positionLeft_width_mobile' => array(
                  'label' => 'Width',
                  'type' => 'input'
                ),
                'menuItem__svg_positionLeft_margin_mobile' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'menuItem__svg_positionLeft_padding_mobile' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'dark__menuItem__svg_positionLeft_backgroundColor' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__menuItem__svg_positionLeft_borderColor' => array(
                  'label' => 'border color',
                  'type' => 'color'
                ),
                'dark__menuItem__svg_positionLeft_backgroundColor_hover' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__menuItem__svg_positionLeft_borderColor_hover' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                )
              )
            ),
            'tmp_menuItem_description' => array(
              'label' => 'Description',
              'inputs' => array(
                'menuItem__description_backgroundColor' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'menuItem__description_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'menuItem__description_borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'dark__menuItem__description_backgroundColor' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__menuItem__description_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'dark__menuItem__description_borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'menuItem__description_borderRadius' => array(
                  'label' => 'Border radius',
                  'type' => 'input'
                ),
                'menuItem__description_borderStyle' => array(
                  'label' => 'Border style',
                  'type' => 'select'
                ),
                'menuItem__description_borderWidth' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'menuItem__description_margin' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'menuItem__description_padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'menuItem__description_fontFamiliy' => array(
                  'label' => 'Title font family',
                  'type' => 'input'
                ),
                'menuItem__description_fontSize' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'menuItem__description_lineHeight' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'menuItem__description_fontWeight' => array(
                  'label' => 'Font weight',
                  'type' => 'select'
                ),
                'menuItem__description_textTransform' => array(
                  'label' => 'Text transform',
                  'type' => 'select'
                ),
                'menuItem__description_fontStyle' => array(
                  'label' => 'Font style',
                  'type' => 'select'
                ),
                'menuItem__description_letterSpacing' => array(
                  'label' => 'Letter spacing',
                  'type' => 'input'
                ),
                'menuItem__description_fontSize_mobile' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'menuItem__description_margin_mobile' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'menuItem__description_padding_mobile' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'dark__menuItem__description_backgroundColor' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__menuItem__description_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'dark__menuItem__description_borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                )
              )
            )
          )
        ),
        'thumbnails' => array(
          'label' => 'Thumbnail',
          'sections' => array(
            'thumbnails_desktop' => array(
              'label' => 'Desktop',
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
                )
              )
            ),
            'thumbnails_mobile' => array(
              'label' => 'Mobile',
              'inputs' => array(
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
            )
          )
        ),
        'breadcrumbs' => array(
          'label' => 'Breadcrumbs',
          'sections' => array(
            'breadcrumbs_desktop' => array(
              'label' => 'Desktop',
              'inputs' => array(
                'bc__color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'bc__background_color' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'bc__link_color' => array(
                  'label' => 'Link color',
                  'type' => 'color'
                ),
                'bc__link_color_hover' => array(
                  'label' => 'Link color',
                  'type' => 'color'
                ),
                'bc__color_active' => array(
                  'label' => 'Color (active)',
                  'type' => 'color'
                ),
                'bc__margin' => array(
                  'label' => 'Margin',
                  'type' => 'input'
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
                  'type' => 'select'
                ),
                'bc__lineheight' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'bc__textTransform' => array(
                  'label' => 'Text transform',
                  'type' => 'select'
                ),
                'bc__fontStyle' => array(
                  'label' => 'font style',
                  'type' => 'select'
                ),
                'dark__bc__color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'dark__bc__background_color' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__bc__link_color' => array(
                  'label' => 'Link color',
                  'type' => 'color'
                ),
                'dark__bc__link_color_hover' => array(
                  'label' => 'Link color',
                  'type' => 'color'
                ),
                'dark__bc__color_active' => array(
                  'label' => 'Color (active)',
                  'type' => 'color'
                )
              )
            ),
            'breadcrumbs_mobile' => array(
              'label' => 'Mobile',
              'inputs' => array(
                'bc__fontsize_mobile' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'bc__lineheight_mobile' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'bc__margin_mobile' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'bc__padding_mobile' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                )
              )
            )
          )
        ),
        'languageswitcher' => array(
          'label' => 'Language switcher',
          'sections' => array(
            'languageswitcher_settings' => array(
              'label' => 'Settings',
              'inputs' => array(
                'ls__background_color' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'ls__color_active' => array(
                  'label' => 'Active language color',
                  'type' => 'color'
                ),
                'dark__ls__background_color' => array(
                  'label' => 'Background Image',
                  'type' => 'color'
                ),
                'dark__ls__color_active' => array(
                  'label' => 'Active language color',
                  'type' => 'color'
                )
              )
            ),
            'languageswitcher_links' => array(
              'label' => 'Buttons',
              'inputs' => array(
                'ls__link_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'ls__link_color_hover' => array(
                  'label' => 'Hover color',
                  'type' => 'color'
                ),
                'ls__link_fontfamily' => array(
                  'label' => 'Font family',
                  'type' => 'input'
                ),
                'ls__link_fontsize' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'ls__link_lineheight' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'ls__link_fontWeight' => array(
                  'label' => 'Font weight',
                  'type' => 'select'
                ),
                'ls__link_textTransform' => array(
                  'label' => 'Text transform',
                  'type' => 'select'
                ),
                'ls__link_fontStyle' => array(
                  'label' => 'Font style',
                  'type' => 'select'
                ),
                'ls__link_letterSpacing' => array(
                  'label' => 'Letter spacing',
                  'type' => 'input'
                ),
                'ls__link_margin' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'ls__link_padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'ls__link_fontsize_mobile' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'ls__link_lineheight_mobile' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'ls__link_margin_mobile' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'ls__link_padding_mobile' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'dark__ls__link_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'dark__ls__link_color_hover' => array(
                  'label' => 'Hover color',
                  'type' => 'color'
                )
              )
            )
          )
        ),
        'tagStyles' => array(
          'label' => 'Tag styles',
          'sections' => array(
            'tagStyles_section' => array(
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
            'tagStyles_h1' => array(
              'label' => 'h1',
              'inputs' => array(
                'h1__bg' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'h1__color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'h1__borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'h1__borderRadius' => array(
                  'label' => 'Border radius',
                  'type' => 'input'
                ),
                'h1__borderStyle' => array(
                  'label' => 'Border style',
                  'type' => 'select'
                ),
                'h1__borderWidth' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'h1__marginTop' => array(
                  'label' => 'Margin top',
                  'type' => 'input'
                ),
                'h1__marginBottom' => array(
                  'label' => 'Margin bottom',
                  'type' => 'input'
                ),
                'h1__padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'h1__fontFamily' => array(
                  'label' => 'Title font family',
                  'type' => 'input'
                ),
                'h1__fontSize' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'h1__lineHeight' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'h1__fontWeight' => array(
                  'label' => 'Font weight',
                  'type' => 'select'
                ),
                'h1__textTransform' => array(
                  'label' => 'Text transform',
                  'type' => 'select'
                ),
                'h1__fontStyle' => array(
                  'label' => 'Font style',
                  'type' => 'select'
                ),
                'h1__letterSpacing' => array(
                  'label' => 'Letter spacing',
                  'type' => 'input'
                ),
                'h1__marginTop_mobile' => array(
                  'label' => 'Margin top',
                  'type' => 'input'
                ),
                'h1__marginBottom_mobile' => array(
                  'label' => 'Margin bottom',
                  'type' => 'input'
                ),
                'h1__padding_mobile' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'h1__fontSize_mobile' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'h1__lineHeight_mobile' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'dark__h1__bg' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__h1__color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'dark__h1__borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                )
              )
            ),
            'tagStyles_h2' => array(
              'label' => 'h2',
              'inputs' => array(
                'h2__bg' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'h2__color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'h2__borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'h2__borderRadius' => array(
                  'label' => 'Border radius',
                  'type' => 'input'
                ),
                'h2__borderStyle' => array(
                  'label' => 'Border style',
                  'type' => 'select'
                ),
                'h2__borderWidth' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'h2__marginTop' => array(
                  'label' => 'Margin top',
                  'type' => 'input'
                ),
                'h2__marginBottom' => array(
                  'label' => 'Margin bottom',
                  'type' => 'input'
                ),
                'h2__padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'h2__fontFamily' => array(
                  'label' => 'Title font family',
                  'type' => 'input'
                ),
                'h2__fontSize' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'h2__lineHeight' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'h2__fontWeight' => array(
                  'label' => 'Font weight',
                  'type' => 'select'
                ),
                'h2__textTransform' => array(
                  'label' => 'Text transform',
                  'type' => 'select'
                ),
                'h2__fontStyle' => array(
                  'label' => 'Font style',
                  'type' => 'select'
                ),
                'h2__letterSpacing' => array(
                  'label' => 'Letter spacing',
                  'type' => 'input'
                ),
                'h2__marginTop_mobile' => array(
                  'label' => 'Margin top',
                  'type' => 'input'
                ),
                'h2__marginBottom_mobile' => array(
                  'label' => 'Margin bottom',
                  'type' => 'input'
                ),
                'h2__padding_mobile' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'h2__fontSize_mobile' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'h2__lineHeight_mobile' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'dark__h2__bg' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__h2__color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'dark__h2__borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                )
              )
            ),
            'tagStyles_h3' => array(
              'label' => 'h3',
              'inputs' => array(
                'h3__bg' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'h3__color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'h3__borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'h3__borderRadius' => array(
                  'label' => 'Border radius',
                  'type' => 'input'
                ),
                'h3__borderStyle' => array(
                  'label' => 'Border style',
                  'type' => 'select'
                ),
                'h3__borderWidth' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'h3__marginTop' => array(
                  'label' => 'Margin top',
                  'type' => 'input'
                ),
                'h3__marginBottom' => array(
                  'label' => 'Margin bottom',
                  'type' => 'input'
                ),
                'h3__padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'h3__fontFamily' => array(
                  'label' => 'Title font family',
                  'type' => 'input'
                ),
                'h3__fontSize' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'h3__lineHeight' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'h3__fontWeight' => array(
                  'label' => 'Font weight',
                  'type' => 'select'
                ),
                'h3__textTransform' => array(
                  'label' => 'Text transform',
                  'type' => 'select'
                ),
                'h3__fontStyle' => array(
                  'label' => 'Font style',
                  'type' => 'select'
                ),
                'h3__letterSpacing' => array(
                  'label' => 'Letter spacing',
                  'type' => 'input'
                ),
                'h3__marginTop_mobile' => array(
                  'label' => 'Margin top',
                  'type' => 'input'
                ),
                'h3__marginBottom_mobile' => array(
                  'label' => 'Margin bottom',
                  'type' => 'input'
                ),
                'h3__padding_mobile' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'h3__fontSize_mobile' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'h3__lineHeight_mobile' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'dark__h3__bg' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__h3__color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'dark__h3__borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                )
              )
            ),
            'tagStyles_h4' => array(
              'label' => 'h4',
              'inputs' => array(
                'h4__bg' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'h4__color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'h4__borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'h4__borderRadius' => array(
                  'label' => 'Border radius',
                  'type' => 'input'
                ),
                'h4__borderStyle' => array(
                  'label' => 'Border style',
                  'type' => 'select'
                ),
                'h4__borderWidth' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'h4__marginTop' => array(
                  'label' => 'Margin top',
                  'type' => 'input'
                ),
                'h4__marginBottom' => array(
                  'label' => 'Margin bottom',
                  'type' => 'input'
                ),
                'h4__padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'h4__fontFamily' => array(
                  'label' => 'Title font family',
                  'type' => 'input'
                ),
                'h4__fontSize' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'h4__lineHeight' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'h4__fontWeight' => array(
                  'label' => 'Font weight',
                  'type' => 'select'
                ),
                'h4__textTransform' => array(
                  'label' => 'Text transform',
                  'type' => 'select'
                ),
                'h4__fontStyle' => array(
                  'label' => 'Font style',
                  'type' => 'select'
                ),
                'h4__letterSpacing' => array(
                  'label' => 'Letter spacing',
                  'type' => 'input'
                ),
                'h4__marginTop_mobile' => array(
                  'label' => 'Margin top',
                  'type' => 'input'
                ),
                'h4__marginBottom_mobile' => array(
                  'label' => 'Margin bottom',
                  'type' => 'input'
                ),
                'h4__padding_mobile' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'h4__fontSize_mobile' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'h4__lineHeight_mobile' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'dark__h4__bg' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__h4__color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'dark__h4__borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                )
              )
            ),
            'tagStyles_h5' => array(
              'label' => 'h5',
              'inputs' => array(
                'h5__bg' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'h5__color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'h5__borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'h5__borderRadius' => array(
                  'label' => 'Border radius',
                  'type' => 'input'
                ),
                'h5__borderStyle' => array(
                  'label' => 'Border style',
                  'type' => 'select'
                ),
                'h5__borderWidth' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'h5__marginTop' => array(
                  'label' => 'Margin top',
                  'type' => 'input'
                ),
                'h5__marginBottom' => array(
                  'label' => 'Margin bottom',
                  'type' => 'input'
                ),
                'h5__padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'h5__fontFamily' => array(
                  'label' => 'Title font family',
                  'type' => 'input'
                ),
                'h5__fontSize' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'h5__lineHeight' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'h5__fontWeight' => array(
                  'label' => 'Font weight',
                  'type' => 'select'
                ),
                'h5__textTransform' => array(
                  'label' => 'Text transform',
                  'type' => 'select'
                ),
                'h5__fontStyle' => array(
                  'label' => 'Font style',
                  'type' => 'select'
                ),
                'h5__letterSpacing' => array(
                  'label' => 'Letter spacing',
                  'type' => 'input'
                ),
                'h5__marginTop_mobile' => array(
                  'label' => 'Margin top',
                  'type' => 'input'
                ),
                'h5__marginBottom_mobile' => array(
                  'label' => 'Margin bottom',
                  'type' => 'input'
                ),
                'h5__padding_mobile' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'h5__fontSize_mobile' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'h5__lineHeight_mobile' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'dark__h5__bg' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__h5__color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'dark__h5__borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                )
              )
            ),
            'tagStyles_h6' => array(
              'label' => 'h6',
              'inputs' => array(
                'h6__bg' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'h6__color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'h6__borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'h6__borderRadius' => array(
                  'label' => 'Border radius',
                  'type' => 'input'
                ),
                'h6__borderStyle' => array(
                  'label' => 'Border style',
                  'type' => 'select'
                ),
                'h6__borderWidth' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'h6__marginTop' => array(
                  'label' => 'Margin top',
                  'type' => 'input'
                ),
                'h6__marginBottom' => array(
                  'label' => 'Margin bottom',
                  'type' => 'input'
                ),
                'h6__padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'h6__fontFamily' => array(
                  'label' => 'Title font family',
                  'type' => 'input'
                ),
                'h6__fontSize' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'h6__lineHeight' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'h6__fontWeight' => array(
                  'label' => 'Font weight',
                  'type' => 'select'
                ),
                'h6__textTransform' => array(
                  'label' => 'Text transform',
                  'type' => 'select'
                ),
                'h6__fontStyle' => array(
                  'label' => 'Font style',
                  'type' => 'select'
                ),
                'h6__letterSpacing' => array(
                  'label' => 'Letter spacing',
                  'type' => 'input'
                ),
                'h6__marginTop_mobile' => array(
                  'label' => 'Margin top',
                  'type' => 'input'
                ),
                'h6__marginBottom_mobile' => array(
                  'label' => 'Margin bottom',
                  'type' => 'input'
                ),
                'h6__padding_mobile' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'h6__fontSize_mobile' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'h6__lineHeight_mobile' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'dark__h6__bg' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__h6__color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'dark__h6__borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                )
              )
            ),
            'tagStyles_b' => array(
              'label' => 'B',
              'inputs' => array(
                'b_fontWeight' => array(
                  'label' => 'Font weight',
                  'type' => 'select'
                )
              )
            ),
            'tagStyles_strong' => array(
              'label' => 'Strong',
              'inputs' => array(
                'strong_fontWeight' => array(
                  'label' => 'Font weight',
                  'type' => 'select'
                )
              )
            )
          )
        ),
        'forms' => array(
          'label' => 'Formular',
          'sections' => array(
            'forms_messages' => array(
              'label' => 'Massages',
              'inputs' => array(
                'input__required' => array(
                  'label' => 'Color (required)',
                  'type' => 'color',
                  'default' => '#a53737'
                ),
                'dark__input__required' => array(
                  'label' => 'Color (required)',
                  'type' => 'color'
                )
              )
            ),
            'forms_label' => array(
              'label' => 'Label',
              'inputs' => array(
                'label_backgroundColor' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'label_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'label_border_color' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'label_width' => array(
                  'label' => 'Width',
                  'type' => 'input'
                ),
                'label_borderRadius' => array(
                  'label' => 'Border radius',
                  'type' => 'input'
                ),
                'label_borderWidth' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'label_borderStyle' => array(
                  'label' => 'Border style',
                  'type' => 'select'
                ),
                'label_margin' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'label_padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'label_fontFamily' => array(
                  'label' => 'Font family',
                  'type' => 'input'
                ),
                'label_fontSize' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'label_lineHeight' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'label_fontWeight' => array(
                  'label' => 'Font weight',
                  'type' => 'select'
                ),
                'label_textTransform' => array(
                  'label' => 'Text transform',
                  'type' => 'select'
                ),
                'label_letterSpacing' => array(
                  'label' => 'Letter spacing',
                  'type' => 'input'
                ),
                'label_width_mobile' => array(
                  'label' => 'Minimum width',
                  'type' => 'input'
                ),
                'label_margin_mobile' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'label_padding_mobile' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'label_fontSize_mobile' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'label_lineHeight_mobile' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'label_letterSpacing_mobile' => array(
                  'label' => 'Letter spacing',
                  'type' => 'input'
                ),
                'dark__label_backgroundColor' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__label_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'dark__label_border_color' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                )
              )
            ),
            'forms_input' => array(
              'label' => 'Input field',
              'inputs' => array(
                'input__color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'input__bg_color' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'input__border_color' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'input_width' => array(
                  'label' => 'Width',
                  'type' => 'input'
                ),
                'input__border_width' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'input__borderRadius' => array(
                  'label' => 'Border radius',
                  'type' => 'input'
                ),
                'input_borderStyle' => array(
                  'label' => 'Border style',
                  'type' => 'select'
                ),
                'input__padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'input__fontFamily' => array(
                  'label' => 'Font family',
                  'type' => 'input'
                ),
                'input__fontSize' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'input__lineHeight' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'input__fontWeight' => array(
                  'label' => 'Font weight',
                  'type' => 'select'
                ),
                'input_width_mobile' => array(
                  'label' => 'Width',
                  'type' => 'input'
                ),
                'input__padding_mobile' => array(
                  'label' => 'Padding mobile',
                  'type' => 'input'
                ),
                'input__fontSize_mobile' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'input__lineHeight_mobile' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'dark__input__color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'dark__input__bg_color' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__input__border_color' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                )
              )
            ),
            'forms_checkboxRadio' => array(
              'label' => 'Radio & Checkbox',
              'inputs' => array(
                'input__checkbox_bg' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'input__checkbox_bg_checked' => array(
                  'label' => 'Background color (checked)',
                  'type' => 'color'
                ),
                'input__checkbox_border_color' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'input__checkbox_width' => array(
                  'label' => 'Width/height',
                  'type' => 'input'
                ),
                'input__checkbox_border_width' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'input__checkbox_marginTop' => array(
                  'label' => 'Margin top',
                  'type' => 'input'
                ),
                'input__checkbox_space' => array(
                  'label' => 'Space to text',
                  'type' => 'input'
                ),
                'input__checkbox_fontSize' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'input__checkbox_lineHeight' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'input__checkbox_fontWeight' => array(
                  'label' => 'Font weight',
                  'type' => 'select'
                ),
                'input__checkbox_fontSize_mobile' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'input__checkbox_lineHeight_mobile' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'dark__input__checkbox_bg' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__input__checkbox_border_color' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'dark__input__checkbox_bg_checked' => array(
                  'label' => 'Background color (checked)',
                  'type' => 'color'
                )
              )
            ),
            'forms_select' => array(
              'label' => 'Select',
              'inputs' => array(
                'input__select_bg_color' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'input__select_color' => array(
                  'label' => 'Text color',
                  'type' => 'color'
                ),
                'input__select_border_color' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'input__select_padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'input__select_border_width' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'input_select_borderStyle' => array(
                  'label' => 'Border style',
                  'type' => 'select'
                ),
                'input__select_padding_mobile' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'input__select_fontFamily' => array(
                  'label' => 'Font family',
                  'type' => 'input'
                ),
                'input__select_fontSize' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'input__select_lineHeight' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'input__select_fontWeight' => array(
                  'label' => 'Font weight',
                  'type' => 'select'
                ),
                'input__select_fontSize_mobile' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'input__select_lineHeight_mobile' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'input__selectContainer_color' => array(
                  'label' => 'Container text color',
                  'type' => 'color'
                ),
                'input__selectContainer_bg_color' => array(
                  'label' => 'Container background color',
                  'type' => 'color'
                ),
                'input__selectContainer_width' => array(
                  'label' => 'Container size',
                  'type' => 'input'
                ),
                'input__selectContainer_width_mobile' => array(
                  'label' => 'Container size',
                  'type' => 'input'
                ),
                'dark__input__select_bg_color' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__input__select_color' => array(
                  'label' => 'Text color',
                  'type' => 'color'
                ),
                'dark__input__select_border_color' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'dark__input__selectContainer_color' => array(
                  'label' => 'Container text color',
                  'type' => 'color'
                ),
                'dark__input__selectContainer_bg_color' => array(
                  'label' => 'Container background color',
                  'type' => 'color'
                )
              )
            ),
            'forms_placeholder' => array(
              'label' => 'Placeholder',
              'inputs' => array(
                'input__placeholder_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'input__placeholder_fontFamily' => array(
                  'label' => 'Font family',
                  'type' => 'input'
                ),
                'input__placeholder_fontSize' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'input__placeholder_lineHeight' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'input__placeholder_fontWeight' => array(
                  'label' => 'Font weight',
                  'type' => 'select'
                ),
                'input__placeholder_textTransform' => array(
                  'label' => 'Text transform',
                  'type' => 'select'
                ),
                'dark__input__placeholder_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                )
              )
            ),
            'forms_range' => array(
              'label' => 'Range',
              'inputs' => array(
                'input__range_progressbar_backgroundColor' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'input__range_progressbar_backgroundColor_hover' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'input__range_progressbar_backgroundColor_active' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'input__range_progressbar_borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'input__range_progressbar_borderColor_hover' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'input__range_progressbar_borderColor_active' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'input__range_progressbar_height' => array(
                  'label' => 'Height',
                  'type' => 'input'
                ),
                'input__range_progressbar_borderWidth' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'input__range_progressbar_borderStyle' => array(
                  'label' => 'Border style',
                  'type' => 'select'
                ),
                'input__range_progressbar_borderRadius' => array(
                  'label' => 'Border radius',
                  'type' => 'input'
                ),
                'input__range_handler_backgroundColor' => array(
                  'label' => 'Handler color',
                  'type' => 'color'
                ),
                'input__range_handler_backgroundColor_hover' => array(
                  'label' => 'Handler color',
                  'type' => 'color'
                ),
                'input__range_handler_backgroundColor_active' => array(
                  'label' => 'Handler color',
                  'type' => 'color'
                ),
                'input__range_handler_borderColor' => array(
                  'label' => 'Handler border color',
                  'type' => 'color'
                ),
                'input__range_handler_borderColor_hover' => array(
                  'label' => 'Handler border color',
                  'type' => 'color'
                ),
                'input__range_handler_borderColor_active' => array(
                  'label' => 'Handler border color',
                  'type' => 'color'
                ),
                'input__range_handle_width' => array(
                  'label' => 'Handler width',
                  'type' => 'input'
                ),
                'input__range_handle_height' => array(
                  'label' => 'Handler height',
                  'type' => 'input'
                ),
                'input__range_handle_borderWidth' => array(
                  'label' => 'Handler border width',
                  'type' => 'input'
                ),
                'input__range_handle_borderStyle' => array(
                  'label' => 'Handler border style',
                  'type' => 'select'
                ),
                'input__range_handle_borderRadius' => array(
                  'label' => 'Handler border radius',
                  'type' => 'input'
                ),
                'input__range_progressed_backgroundColor' => array(
                  'label' => 'Prozessed color',
                  'type' => 'color'
                ),
                'input__range_progressed_backgroundColor_hover' => array(
                  'label' => 'Prozessed color',
                  'type' => 'color'
                ),
                'input__range_progressed_backgroundColor_active' => array(
                  'label' => 'Prozessed color',
                  'type' => 'color'
                ),
                'dark__input__range_progressbar_backgroundColor' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__input__range_progressbar_backgroundColor_hover' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__input__range_progressbar_backgroundColor_active' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__input__range_progressbar_borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'dark__input__range_progressbar_borderColor_hover' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'dark__input__range_progressbar_borderColor_active' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'dark__input__range_handler_backgroundColor' => array(
                  'label' => 'Handler color',
                  'type' => 'color'
                ),
                'dark__input__range_handler_backgroundColor_hover' => array(
                  'label' => 'Handler color',
                  'type' => 'color'
                ),
                'dark__input__range_handler_backgroundColor_active' => array(
                  'label' => 'Handler color',
                  'type' => 'color'
                ),
                'dark__input__range_handler_borderColor' => array(
                  'label' => 'Handler border color',
                  'type' => 'color'
                ),
                'dark__input__range_handler_borderColor_hover' => array(
                  'label' => 'Handler border color',
                  'type' => 'color'
                ),
                'dark__input__range_handler_borderColor_active' => array(
                  'label' => 'Handler border color',
                  'type' => 'color'
                ),
                'dark__input__range_progressed_backgroundColor' => array(
                  'label' => 'Prozessed color',
                  'type' => 'color'
                ),
                'dark__input__range_progressed_backgroundColor_hover' => array(
                  'label' => 'Prozessed color',
                  'type' => 'color'
                ),
                'dark__input__range_progressed_backgroundColor_active' => array(
                  'label' => 'Prozessed color',
                  'type' => 'color'
                )
              )
            ),
            'forms_submit' => array(
              'label' => 'Submit button',
              'inputs' => array(
                'input__submit_bg_color' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'input__submit_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'input__submit_border_color' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'input__submit_bg_color_hover' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'input__submit_color_hover' => array(
                  'label' => 'Text color',
                  'type' => 'color'
                ),
                'input__submit_border_color_hover' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'input__submit_padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'input__submit_borderRadius' => array(
                  'label' => 'Border radius',
                  'type' => 'input'
                ),
                'input__submit_borderWidth' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'input__submit_fontFamily' => array(
                  'label' => 'Font family',
                  'type' => 'input'
                ),
                'input__submit_fontSize' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'input__submit_lineHeight' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'input__submit_fontWeight' => array(
                  'label' => 'Font weight',
                  'type' => 'select'
                ),
                'input__submit_letterSpacing' => array(
                  'label' => 'Letter spacing',
                  'type' => 'input'
                ),
                'input__submit_textTransform' => array(
                  'label' => 'Text transform',
                  'type' => 'select'
                ),
                'input__submit_padding_mobile' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'input__submit_fontSize_mobile' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'input__submit_lineHeight_mobile' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'input__submit_letterSpacing_mobile' => array(
                  'label' => 'Letter spacing',
                  'type' => 'input'
                ),
                'dark__input__submit_bg_color' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__input__submit_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'dark__input__submit_border_color' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'dark__input__submit_bg_color_hover' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__input__submit_color_hover' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'dark__input__submit_border_color_hover' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                )
              )
            ),
            'forms_reset' => array(
              'label' => 'Reset button',
              'inputs' => array(
                'input__reset_bg_color' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'input__reset_color' => array(
                  'label' => 'Text color',
                  'type' => 'color'
                ),
                'input__reset_border_color' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'input__reset_bg_color_hover' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'input__reset_color_hover' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'input__reset_border_color_hover' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'input__reset_padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'input__reset_borderRadius' => array(
                  'label' => 'Border radius',
                  'type' => 'input'
                ),
                'input__reset_borderWidth' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'input__reset_fontFamily' => array(
                  'label' => 'Font family',
                  'type' => 'input'
                ),
                'input__reset_fontSize' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'input__reset_lineHeight' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'input__reset_fontWeight' => array(
                  'label' => 'Font weight',
                  'type' => 'select'
                ),
                'input__reset_letterSpacing' => array(
                  'label' => 'Letter spacing',
                  'type' => 'input'
                ),
                'input__reset_textTransform' => array(
                  'label' => 'Text transform',
                  'type' => 'select'
                ),
                'input__reset_padding_mobile' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'input__reset_fontSize_mobile' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'input__reset_lineHeight_mobile' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'input__reset_letterSpacing_mobile' => array(
                  'label' => 'Letter spacing',
                  'type' => 'input'
                ),
                'dark__input__reset_bg_color' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__input__reset_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'dark__input__reset_border_color' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'dark__input__reset_bg_color_hover' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__input__reset_color_hover' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'dark__input__reset_border_color_hover' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                )
              )
            ),
            'forms_mautic' => array(
              'label' => 'Mautic',
              'inputs' => array(
                'mautic__row_marginBottom' => array(
                  'label' => 'Margin bottom',
                  'type' => 'input'
                ),
                'mautic__row_gap' => array(
                  'label' => 'Gap',
                  'type' => 'input'
                ),
                'mautic__row_rowgap' => array(
                  'label' => 'Row gap',
                  'type' => 'input'
                ),
                'mautic__row_marginBottom_mobile' => array(
                  'label' => 'Margin bottom',
                  'type' => 'input'
                ),
                'mautic__row_gap_mobile' => array(
                  'label' => 'Gap',
                  'type' => 'input'
                ),
                'mautic__row_rowgap_mobile' => array(
                  'label' => 'Row gap',
                  'type' => 'input'
                )
              )
            )
          )
        ),
        'search_form' => array(
          'label' => 'Search form',
          'sections' => array(
            'search_form_settings' => array(
              'label' => 'Settings',
              'inputs' => array()
            ),
            'search_form_input' => array(
              'label' => 'Input',
              'inputs' => array(
                'searchForm__bg_color' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'searchForm__color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'searchForm__border_color' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'searchForm__border_width' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'searchForm__borderRadius' => array(
                  'label' => 'Border radius',
                  'type' => 'input'
                ),
                'searchForm__margin' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'searchForm__padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'searchForm__fontFamily' => array(
                  'label' => 'Font family',
                  'type' => 'input'
                ),
                'searchForm__fontSize' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'searchForm__lineHeight' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'searchForm__fontWeight' => array(
                  'label' => 'Font weight',
                  'type' => 'select'
                ),
                'searchForm__margin_mobile' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'searchForm__padding_mobile' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'searchForm__fontSize_mobile' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'searchForm__lineHeight_mobile' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'dark__searchForm__color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'dark__searchForm__bg_color' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__searchForm__border_color' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                )
              )
            ),
            'search_form_placeholder' => array(
              'label' => 'Placeholder',
              'inputs' => array(
                'searchForm__placeholder_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'searchForm__placeholder_fontFamily' => array(
                  'label' => 'Font family',
                  'type' => 'input'
                ),
                'searchForm__placeholder_fontSize' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'searchForm__placeholder_lineHeight' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'searchForm__placeholder_fontWeight' => array(
                  'label' => 'Font weight',
                  'type' => 'select'
                ),
                'searchForm__placeholder_textTransform' => array(
                  'label' => 'Text transform',
                  'type' => 'select'
                ),
                'dark__searchForm__placeholder_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                )
              )
            ),
            'search_form_button' => array(
              'label' => 'Button',
              'inputs' => array(
                'searchForm__submit_bg_color' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'searchForm__submit_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'searchForm__submit_border_color' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'searchForm__submit_bg_color_hover' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'searchForm__submit_color_hover' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'searchForm__submit_border_color_hover' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'searchForm__submit_borderRadius' => array(
                  'label' => 'Border radius',
                  'type' => 'input'
                ),
                'searchForm__submit_borderWidth' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'searchForm__submit_margin' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'searchForm__submit_padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'searchForm__submit_fontFamily' => array(
                  'label' => 'Font family',
                  'type' => 'input'
                ),
                'searchForm__submit_fontSize' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'searchForm__submit_letterSpacing' => array(
                  'label' => 'Letter spacing',
                  'type' => 'input'
                ),
                'searchForm__submit_lineHeight' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'searchForm__submit_fontWeight' => array(
                  'label' => 'Font weight',
                  'type' => 'select'
                ),
                'searchForm__submit_textTransform' => array(
                  'label' => 'Text transform',
                  'type' => 'select'
                ),
                'searchForm__submit_fontSize_mobile' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'searchForm__submit_lineHeight_mobile' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'searchForm__submit_letterSpacing_mobile' => array(
                  'label' => 'Letter spacing',
                  'type' => 'input'
                ),
                'searchForm__submit_margin_mobile' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'searchForm__submit_padding_mobile' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'dark__searchForm__submit_bg_color' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__searchForm__submit_color' => array(
                  'label' => 'Text color',
                  'type' => 'color'
                ),
                'dark__searchForm__submit_border_color' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'dark__searchForm__submit_bg_color_hover' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__searchForm__submit_border_color_hover' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'dark__searchForm__submit_color_hover' => array(
                  'label' => 'Color',
                  'type' => 'color'
                )
              )
            )
          )
        ),
        'search_results' => array(
          'label' => 'Search results',
          'sections' => array(
            'search_results_settings' => array(
              'label' => 'Settings',
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
                )
              )
            ),
            'search_results_item' => array(
              'label' => 'Item',
              'inputs' => array(
                'search__article_borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'search__article_border' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'search__article_margin' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'search__article_padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'search__article_flexDirection' => array(
                  'label' => 'Direction',
                  'type' => 'select'
                ),
                'search__article_flexGap' => array(
                  'label' => 'Gap',
                  'type' => 'input'
                ),
                'search__article_flexDivWidth' => array(
                  'label' => 'Excerpt width',
                  'type' => 'input'
                ),
                'search__article_flexMediaWidth' => array(
                  'label' => 'Media width',
                  'type' => 'input'
                ),
                'search__article_margin_mobile' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'search__article_padding_mobile' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'search__article_flexDirection_mobile' => array(
                  'label' => 'Direction',
                  'type' => 'select'
                ),
                'search__article_flexGap_mobile' => array(
                  'label' => 'Gap',
                  'type' => 'input'
                ),
                'search__article_flexDivWidth_mobile' => array(
                  'label' => 'Excerpt width',
                  'type' => 'input'
                ),
                'search__article_flexMediaWidth_mobile' => array(
                  'label' => 'Media width',
                  'type' => 'input'
                )
              )
            ),
            'search_results_item_title' => array(
              'label' => 'Item title',
              'inputs' => array(
                'search__article_title_backgroundColor' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'search__article_title_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'search__article_title_borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'search__article_title_borderWidth' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'search__article_title_borderStyle' => array(
                  'label' => 'Border style',
                  'type' => 'select'
                ),
                'search__article_title_margin' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'search__article_title_padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'search__article_title_fontFamily' => array(
                  'label' => 'Font family',
                  'type' => 'input'
                ),
                'search__article_title_fontSize' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'search__article_title_lineHeight' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'search__article_title_fontWeight' => array(
                  'label' => 'Font weight',
                  'type' => 'select'
                ),
                'search__article_title_textTransform' => array(
                  'label' => 'Text transform',
                  'type' => 'select'
                ),
                'search__article_title_fontStyle' => array(
                  'label' => 'Font style',
                  'type' => 'select'
                ),
                'search__article_title_fontSize_mobile' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'search__article_title_lineHeight_mobile' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'search__article_title_margin_mobile' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'search__article_title_padding_mobile' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                )
              )
            ),
            'search_results_pagination' => array(
              'label' => 'Pagination',
              'inputs' => array(
                'search__pagination_margin' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                )
              )
            )
          )
        ),
        'blog' => array(
          'label' => 'Blog & Archive',
          'sections' => array(
            'blog_settings' => array(
              'label' => 'Settings',
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
                )
              )
            ),
            'blog_item' => array(
              'label' => 'Item',
              'inputs' => array(
                'blog__article_borderColor' => array(
                  'label' => 'Article border color',
                  'type' => 'color'
                ),
                'blog__article_border' => array(
                  'label' => 'Article border width',
                  'type' => 'input'
                ),
                'blog__article_margin' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'blog__article_padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'blog__article_flexDirection' => array(
                  'label' => 'Direction',
                  'type' => 'select'
                ),
                'blog__article_flexGap' => array(
                  'label' => 'Gap',
                  'type' => 'input'
                ),
                'blog__article_flexDivWidth' => array(
                  'label' => 'Excerpt width',
                  'type' => 'input'
                ),
                'blog__article_flexMediaWidth' => array(
                  'label' => 'Media width',
                  'type' => 'input'
                ),
                'blog__article_margin_mobile' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'blog__article_padding_mobile' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'blog__article_flexDirection_mobile' => array(
                  'label' => 'Direction',
                  'type' => 'select'
                ),
                'blog__article_flexGap_mobile' => array(
                  'label' => 'Gap',
                  'type' => 'input'
                ),
                'blog__article_flexDivWidth_mobile' => array(
                  'label' => 'Excerpt width',
                  'type' => 'input'
                ),
                'blog__article_flexMediaWidth_mobile' => array(
                  'label' => 'Article media width',
                  'type' => 'input'
                )
              )
            ),
            'blog_item_title' => array(
              'label' => 'Item title',
              'inputs' => array(
                'blog__article_title_backgroundColor' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'blog__article_title_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'blog__article_title_borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'blog__article_title_borderWidth' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'blog__article_title_borderStyle' => array(
                  'label' => 'Border style',
                  'type' => 'select'
                ),
                'blog__article_title_margin' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'blog__article_title_padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'blog__article_title_fontFamily' => array(
                  'label' => 'Font family',
                  'type' => 'input'
                ),
                'blog__article_title_fontSize' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'blog__article_title_lineHeight' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'blog__article_title_fontWeight' => array(
                  'label' => 'Font weight',
                  'type' => 'select'
                ),
                'blog__article_title_textTransform' => array(
                  'label' => 'Text transform',
                  'type' => 'select'
                ),
                'blog__article_title_fontStyle' => array(
                  'label' => 'Font style',
                  'type' => 'select'
                ),
                'blog__article_title_fontSize_mobile' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'blog__article_title_lineHeight_mobile' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'blog__article_title_margin_mobile' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'blog__article_title_padding_mobile' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                )
              )
            ),
            'blog_pagination' => array(
              'label' => 'Pagination',
              'inputs' => array(
                'blog__pagination_margin' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                )
              )
            )
          )
        ),
        'tmp_comments' => array(
          'label' => 'Comments',
          'sections' => array(
            'tmp_comments_settings' => array(
              'label' => 'Settings',
              'inputs' => array(
                'comments__bg' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'comments__borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'comments__borderRadius' => array(
                  'label' => 'Border radius',
                  'type' => 'input'
                ),
                'comments__borderStyle' => array(
                  'label' => 'Border style',
                  'type' => 'select'
                ),
                'comments__borderWidth' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'comments__margin' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'comments__padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                )
              )
            ),
            'tmp_comments_title' => array(
              'label' => 'Title',
              'inputs' => array(
                'comments__title_bg' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'comments__title_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'comments__title_borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'comments__title_borderRadius' => array(
                  'label' => 'Border radius',
                  'type' => 'input'
                ),
                'comments__title_borderStyle' => array(
                  'label' => 'Border style',
                  'type' => 'select'
                ),
                'comments__title_borderWidth' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'comments__title_margin' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'comments__title_padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'comments__title_fontFamiliy' => array(
                  'label' => 'Title font family',
                  'type' => 'input'
                ),
                'comments__title_fontSize' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'comments__title_lineHeight' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'comments__title_fontWeight' => array(
                  'label' => 'Font weight',
                  'type' => 'select'
                ),
                'comments__title_textTransform' => array(
                  'label' => 'Text transform',
                  'type' => 'select'
                ),
                'comments__title_fontStyle' => array(
                  'label' => 'Font style',
                  'type' => 'select'
                ),
                'comments__title_letterSpacing' => array(
                  'label' => 'Letter spacing',
                  'type' => 'input'
                ),
                'comments__title_margin_mobile' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'comments__title_padding_mobile' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'comments__title_fontSize_mobile' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'comments__title_lineHeight_mobile' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'dark__comments__title_bg' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__comments__title_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'dark__comments__title_borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                )
              )
            ),
            'tmp_comments_list' => array(
              'label' => 'Commentlist',
              'inputs' => array(
                'comments__commentlist_margin' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'comments__commentlist_padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'comments__commentlist_margin_mobile' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'comments__commentlist_padding_mobile' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                )
              )
            ),
            'tmp_comments_list_item' => array(
              'label' => 'Comment item',
              'inputs' => array(
                'comments__commentlist_item_borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'comments__commentlist_item_margin' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'comments__commentlist_item_padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'comments__commentlist_item_borderWidth' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'comments__commentlist_item_borderStyle' => array(
                  'label' => 'Border style',
                  'type' => 'select'
                ),
                'comments__commentlist_item_margin_mobile' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'comments__commentlist_item_padding_mobile' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                )
              )
            ),
            'tmp_comments_list_respond' => array(
              'label' => 'Commentlist respond',
              'inputs' => array(
                'comments__commentlist_respond_margin' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'comments__commentlist_respond_padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'comments__commentlist_respond_margin_mobile' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'comments__commentlist_respond_padding_mobile' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                )
              )
            ),
            'tmp_comments_list_respond_item' => array(
              'label' => 'Comment item',
              'inputs' => array(
                'comments__commentlist_respond_item_borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'comments__commentlist_respond_item_margin' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'comments__commentlist_respond_item_padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'comments__commentlist_respond_item_borderWidth' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'comments__commentlist_respond_item_borderStyle' => array(
                  'label' => 'Border style',
                  'type' => 'select'
                ),
                'comments__commentlist_respond_item_margin_mobile' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'comments__commentlist_respond_item_padding_mobile' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                )
              )
            ),
            'tmp_comments_form' => array(
              'label' => 'Form',
              'inputs' => array(
                'comments__form_flexDirection' => array(
                  'label' => 'Direction',
                  'type' => 'select'
                ),
                'comments__form_margin' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'comments__form_flexDirection_mobile' => array(
                  'label' => 'Direction',
                  'type' => 'select'
                ),
                'comments__form_margin_mobile' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                )
              )
            ),
            'tmp_comments_avatar' => array(
              'label' => 'Avatar',
              'inputs' => array(
                'comments__avatar_display' => array(
                  'label' => 'Display',
                  'type' => 'select'
                ),
                'comments__avatar_width' => array(
                  'label' => 'Width',
                  'type' => 'input'
                ),
                'comments__avatar_margin' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'comments__avatar_width_mobile' => array(
                  'label' => 'Width',
                  'type' => 'input'
                ),
                'comments__avatar_margin_mobile' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                )
              )
            )
          )
        ),
        'page404' => array(
          'label' => '404 Page',
          'sections' => array(
            'page404_settings' => array(
              'label' => 'Settings',
              'inputs' => array(
                'error__margin' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'error__padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'error__textAlign' => array(
                  'label' => 'Text align',
                  'type' => 'input'
                )
              )
            ),
            'page404_title' => array(
              'label' => 'Title',
              'inputs' => array(
                'error__title_margin' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'error__title_padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'error__title_fontFamily' => array(
                  'label' => 'Font family',
                  'type' => 'input'
                ),
                'error__title_fontSize' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'error__title_lineHeight' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'error__title_fontWeight' => array(
                  'label' => 'Font weight',
                  'type' => 'select'
                ),
                'error__title_textTransform' => array(
                  'label' => 'Text transform',
                  'type' => 'select'
                ),
                'error__title_fontStyle' => array(
                  'label' => 'Font style',
                  'type' => 'select'
                ),
                'error__title_letterSpacing' => array(
                  'label' => 'Letter spacing',
                  'type' => 'input'
                ),
                'error__title_fontSize_mobile' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'error__title_lineHeight_mobile' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'error__title_margin_mobile' => array(
                  'label' => 'Title margin',
                  'type' => 'input'
                ),
                'error__title_padding_mobile' => array(
                  'label' => 'Title padding',
                  'type' => 'input'
                )
              )
            )
          )
        ),
        'tmp_lightbox' => array(
          'label' => 'Lightbox',
          'sections' => array(
            'theme_popup_box' => array(
              'label' => 'Box',
              'inputs' => array(
                'popup__backgoundColor' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'popup__container_backgroundColor' => array(
                  'label' => 'Container background color',
                  'type' => 'color'
                ),
                'popup__width' => array(
                  'label' => 'Lightbox width',
                  'type' => 'input',
                  'default' => '800px'
                ),
                'popup__space' => array(
                  'label' => 'Container padding',
                  'type' => 'input',
                  'default' => '40px'
                ),
                'popup_prev_visible' => array(
                  'label' => 'Preview visibility',
                  'type' => 'input',
                  'default' => '30px'
                )
              )
            ),
            'theme_popup_arrow' => array(
              'label' => 'Arrow navigation',
              'inputs' => array(
                'popup__arrow_backgroundColor' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'popup__arrow_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'popup__arrow_borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'popup__arrow_borderWidth' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'popup__arrow_opacity' => array(
                  'label' => 'Opacity',
                  'type' => 'input'
                ),
                'popup__arrow_height' => array(
                  'label' => 'Height',
                  'type' => 'input'
                ),
                'popup__arrow_padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                )
              )
            ),
            'theme_popup_close' => array(
              'label' => 'Close button',
              'inputs' => array(
                'popup__close_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'popup__close_size' => array(
                  'label' => 'Size',
                  'type' => 'input'
                ),
                'popup__close_opacity' => array(
                  'label' => 'Opacity',
                  'type' => 'input'
                )
              )
            ),
            'figcaption' => array(
              'label' => 'Figcaption',
              'inputs' => array(
                'popup__figcaption_backgroundColor' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'popup__figcaption_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'popup__figcaption_display' => array(
                  'label' => 'Display',
                  'type' => 'select'
                ),
                'popup__figcaption_textAlign' => array(
                  'label' => 'Text align',
                  'type' => 'select'
                ),
                'popup__figcaption_fontSize' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'popup__figcaption_lineHeight' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'popup__figcaption_padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                )
              )
            ),
            'downloadLink' => array(
              'label' => 'Download link',
              'inputs' => array(
                'popup__downloadLink_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'popup__downloadLink_color_hover' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'popup__downloadLink_display' => array(
                  'label' => 'Display',
                  'type' => 'select'
                ),
                'popup__downloadLink_fontSize' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'popup__downloadLink_lineHeight' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'popup__downloadLink_padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                )
              )
            )
          )
        ),
        'consentContainer' => array(
          'label' => 'DSGVO consent container',
          'sections' => array(
            'consentContainer_' => array(
              'label' => 'Container',
              'inputs' => array(
                'consentContainer__bg' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'consentContainer__color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'consentContainer__borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'consentContainer__borderWidth' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'consentContainer__borderRadius' => array(
                  'label' => 'Border radius',
                  'type' => 'input'
                ),
                'consentContainer__padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
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
                  'type' => 'select'
                ),
                'consentContainer__textAlign' => array(
                  'label' => 'Text align',
                  'type' => 'input'
                ),
                'consentContainer__padding_mobile' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'consentContainer__fontSize_mobile' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'consentContainer__lineHeight_mobile' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                )
              )
            ),
            'consentContainer_button' => array(
              'label' => 'Button',
              'inputs' => array(
                'consentContainer__Button_bg' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'consentContainer__Button_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'consentContainer__Button_borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'consentContainer__Button_bg_hover' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'consentContainer__Button_color_hover' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'consentContainer__Button_borderColor_hover' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'consentContainer__Button_borderWidth' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'consentContainer__Button_borderRadius' => array(
                  'label' => 'Border radius',
                  'type' => 'input'
                ),
                'consentContainer__Button_padding' => array(
                  'label' => 'Button padding',
                  'type' => 'input'
                ),
                'consentContainer__Button_fontFamily' => array(
                  'label' => 'Font family',
                  'type' => 'input'
                ),
                'consentContainer__Button_fontSize' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'consentContainer__Button_fontWeight' => array(
                  'label' => 'Font weight',
                  'type' => 'select'
                ),
                'consentContainer__Button_lineHeight' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'consentContainer__Button_textTransform' => array(
                  'label' => 'Text transform',
                  'type' => 'select'
                ),
                'consentContainer__Button_fontStyle' => array(
                  'label' => 'Font style',
                  'type' => 'select'
                ),
                'consentContainer__Button_letterSpacing' => array(
                  'label' => 'Letter spacing',
                  'type' => 'input'
                ),
                'consentContainer__Button_padding_mobile' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'consentContainer__Button_fontSize_mobile' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'consentContainer__Button_lineHeight_mobile' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                )
              )
            )
          )
        ),
        'tmp_socialmedia' => array(
          'label' => 'Social media',
          'sections' => array(
            'tmp_socialmedia_settings' => array(
              'label' => 'Settings',
              'inputs' => array(
                'sm__icon_space' => array(
                  'label' => 'Gap',
                  'type' => 'input'
                ),
              )
            ),
            'tmp_socialmedia_item' => array(
              'label' => 'Item',
              'inputs' => array(
                'sm__icon_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'sm__icon_color_hover' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'sm__icon_width' => array(
                  'label' => 'Width',
                  'type' => 'input'
                ),
                'dark__sm__icon_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'dark__sm__icon_color_hover' => array(
                  'label' => 'Color',
                  'type' => 'color'
                )
              )
            )
          )
        ),
        'scrollToTop' => array(
          'label' => 'Scroll to top',
          'sections' => array(
            'scrollToTop_settings' => array(
              'label' => 'Settings',
              'inputs' => array(
                'scrollToTop__background' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'scrollToTop__container_background' => array(
                  'label' => 'Container background color',
                  'type' => 'color'
                ),
                'scrollToTop__container_paddingTop' => array(
                  'label' => 'Container padding top',
                  'type' => 'input'
                ),
                'scrollToTop__container_paddingBottom' => array(
                  'label' => 'Container padding bottom',
                  'type' => 'input'
                )
              )
            ),
            'scrollToTop_button' => array(
              'label' => 'Button',
              'inputs' => array(
                'scrollToTop__Button_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'scrollToTop__Button_bg' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'scrollToTop__Button_borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'scrollToTop__Button_bg_hover' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'scrollToTop__Button_color_hover' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'scrollToTop__Button_borderColor_hover' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'scrollToTop__Button_borderWidth' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'scrollToTop__Button_borderRadius' => array(
                  'label' => 'Border radius',
                  'type' => 'input'
                ),
                'scrollToTop__Button_padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'scrollToTop__Button_fontFamily' => array(
                  'label' => 'Font family',
                  'type' => 'input'
                ),
                'scrollToTop__Button_fontSize' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'scrollToTop__Button_fontWeight' => array(
                  'label' => 'Font weight',
                  'type' => 'select'
                ),
                'scrollToTop__Button_lineHeight' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'scrollToTop__Button_textTransform' => array(
                  'label' => 'Text transform',
                  'type' => 'select'
                ),
                'scrollToTop__Button_fontStyle' => array(
                  'label' => 'Font style',
                  'type' => 'select'
                ),
                'scrollToTop__Button_letterSpacing' => array(
                  'label' => 'Letter spacing',
                  'type' => 'input'
                )
              )
            )
          )
        )
      ),
      'sections' => array()
    ),
    'gutenberg' => array(
      'label' => 'Gutenberg Blocks',
      'panels' => array(
        'gutenberg_accordion' => array(
          'label' => 'Accordion',
          'sections' => array(
            'gutenberg_accordion_settings' => array(
              'label' => 'Settings',
              'inputs' => array(
                'block__accordion_separator' => array(
                  'label' => 'Gap between accordions',
                  'type' => 'input'
                )
              )
            ),
            'gutenberg_accordion_label' => array(
              'label' => 'Label',
              'inputs' => array(
                'block__accordion_label_bg' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'block__accordion_label' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'block__accordion_label_spacing' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'block__accordion_label_fontfamily' => array(
                  'label' => 'Font family',
                  'type' => 'input'
                ),
                'block__accordion_label_fontsize' => array(
                  'label' => 'Font-size',
                  'type' => 'input'
                ),
                'block__accordion_label_fontweight' => array(
                  'label' => 'Font weight',
                  'type' => 'select'
                ),
                'block__accordion_label_lineheight' => array(
                  'label' => 'Line-height',
                  'type' => 'input'
                ),
                'block__accordion_label_textTransform' => array(
                  'label' => 'Text transform',
                  'type' => 'select'
                ),
                'block__accordion_label_letterSpacing' => array(
                  'label' => 'Letter spacing',
                  'type' => 'input'
                ),
                'block__accordion_label_spacing_mobile' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'block__accordion_label_fontsize_mobile' => array(
                  'label' => 'Font-size',
                  'type' => 'input'
                ),
                'block__accordion_label_lineheight_mobile' => array(
                  'label' => 'Line-height',
                  'type' => 'input'
                )
              )
            ),
            'gutenberg_accordion_icon' => array(
              'label' => 'Icon',
              'inputs' => array(
                'block__accordion_iconbox_bg' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'block__accordion_icon_borderRadius' => array(
                  'label' => 'Radius',
                  'type' => 'input'
                ),
                'block__accordion_icon_width' => array(
                  'label' => 'Width',
                  'type' => 'input'
                ),
                'block__accordion_icon_height' => array(
                  'label' => 'Height',
                  'type' => 'input'
                ),
                'block__accordion_icon_seperator' => array(
                  'label' => 'Placeholder between text and icon',
                  'type' => 'input'
                ),
                'block__accordion_icon_width_mobile' => array(
                  'label' => 'Width',
                  'type' => 'input'
                ),
                'block__accordion_icon_height_mobile' => array(
                  'label' => 'Height',
                  'type' => 'input'
                ),
                'block__accordion_label_arrow' => array(
                  'label' => 'Plus sign color',
                  'type' => 'color'
                ),
                'block__accordion_icon_plusRadius' => array(
                  'label' => 'Plus sign radius',
                  'type' => 'input'
                ),
                'block__accordion_icon_plusSize' => array(
                  'label' => 'Plus sign size',
                  'type' => 'input'
                ),
                'block__accordion_icon_plusWeight' => array(
                  'label' => 'Plus sign weight',
                  'type' => 'input'
                )
              )
            ),
            'gutenberg_accordion_content' => array(
              'label' => 'Content',
              'inputs' => array(
                'block__accordion_content_bg' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'block__accordion_content' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'block__accordion_content_spacing' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'block__accordion_content_fontsize' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'block__accordion_content_lineheight' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'block__accordion_content_spacing_mobile' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'block__accordion_content_fontsize_mobile' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'block__accordion_content_lineheight_mobile' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                )
              )
            )
          )
        ),
        'gutenberg_buttons' => array(
          'label' => 'Buttons',
          'sections' => array(
            'gutenberg_buttons_settings' => array(
              'label' => 'Settings',
              'inputs' => array(
                'block__buttons_spacing' => array(
                  'label' => 'Space between',
                  'type' => 'input'
                )
              )
            ),
            'gutenberg_buttons_item' => array(
              'label' => 'Item',
              'inputs' => array(
                'block__buttons_bgColor' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'block__buttons_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'block__buttons_borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'block__buttonsHover_bgColor' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'block__buttonsHover_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'block__buttonsHover_borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'block__buttons_borderWidth' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'block__buttons_borderRadius' => array(
                  'label' => 'Border radius',
                  'type' => 'input'
                ),
                'block__buttons_padding' => array(
                  'label' => 'Padding',
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
                  'type' => 'select'
                ),
                'block__buttons_lineHeight' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'block__buttons_textTransform' => array(
                  'label' => 'Text transform',
                  'type' => 'select'
                ),
                'block__buttons_fontStyle' => array(
                  'label' => 'Font style',
                  'type' => 'select'
                ),
                'block__buttons_letterSpacing' => array(
                  'label' => 'Text letter spacing',
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
                'dark__block__buttons_bgColor' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__block__buttons_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'dark__block__buttons_borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'dark__block__buttonsHover_bgColor' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__block__buttonsHover_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'dark__block__buttonsHover_borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                )
              )
            )
          )
        ),
        'gutenberg_columns' => array(
          'label' => 'Columns',
          'sections' => array(
            'gutenberg_columns_settings' => array(
              'label' => 'Settings',
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
                'block__columns_column_hasBackground_padding' => array(
                  'label' => 'Column padding',
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
                'block__columns_column_hasBackground_padding_mobile' => array(
                  'label' => 'Column padding',
                  'type' => 'input'
                )
              )
            ),
            'gutenberg_columns_three' => array(
              'label' => '3 Columns',
              'inputs' => array(
                'block__columns_3columns_gap' => array(
                  'label' => 'Space between',
                  'type' => 'input'
                ),
                'block__columns_3columns_hasBackground_gap' => array(
                  'label' => 'Space between',
                  'type' => 'input'
                ),
                'block__columns_3columns_gap_mobile' => array(
                  'label' => 'Space between',
                  'type' => 'input'
                ),
                'block__columns_3columns_hasBackground_gap_mobile' => array(
                  'label' => 'Space between',
                  'type' => 'input'
                )
              )
            ),
            'gutenberg_columns_four' => array(
              'label' => '4 Columns',
              'inputs' => array(
                'block__columns_4columns_gap' => array(
                  'label' => 'Space between',
                  'type' => 'input'
                ),
                'block__columns_4columns_hasBackground_gap' => array(
                  'label' => 'Space between',
                  'type' => 'input'
                ),
                'block__columns_4columns_gap_mobile' => array(
                  'label' => 'Space between',
                  'type' => 'input'
                ),
                'block__columns_4columns_hasBackground_gap_mobile' => array(
                  'label' => 'Space between',
                  'type' => 'input'
                )
              )
            ),
            'gutenberg_columns_five' => array(
              'label' => '5 Columns',
              'inputs' => array(
                'block__columns_5columns_gap' => array(
                  'label' => 'Space between',
                  'type' => 'input'
                ),
                'block__columns_5columns_hasBackground_gap' => array(
                  'label' => 'Space between',
                  'type' => 'input'
                ),
                'block__columns_5columns_gap_mobile' => array(
                  'label' => 'Space between',
                  'type' => 'input'
                ),
                'block__columns_5columns_hasBackground_gap_mobile' => array(
                  'label' => 'Space between',
                  'type' => 'input'
                )
              )
            ),
            'gutenberg_columns_six' => array(
              'label' => '6 Columns',
              'inputs' => array(
                'block__columns_6columns_gap' => array(
                  'label' => 'Space between',
                  'type' => 'input'
                ),
                'block__columns_6columns_hasBackground_gap' => array(
                  'label' => 'Space between',
                  'type' => 'input'
                ),
                'block__columns_6columns_gap_mobile' => array(
                  'label' => 'Space between',
                  'type' => 'input',
                  'default' => '20px'
                ),
                'block__columns_6columns_hasBackground_gap_mobile' => array(
                  'label' => 'Space between',
                  'type' => 'input'
                )
              )
            )
          )
        ),
        'gutenberg_cover' => array(
          'label' => 'Cover',
          'sections' => array(
            'gutenberg_cover_settings' => array(
              'label' => 'Settings',
              'inputs' => array(
                'block__cover_minHeight' => array(
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
            'gutenberg_cover_alignwide' => array(
              'label' => 'Align wide',
              'inputs' => array(
                'block__cover_alignwide_minHeight' => array(
                  'label' => 'Minimum height',
                  'type' => 'input'
                ),
                'block__cover_alignwide_minHeight_mobile' => array(
                  'label' => 'Minimum height',
                  'type' => 'input'
                )
              )
            ),
            'gutenberg_cover_alignfull' => array(
              'label' => 'Align full',
              'inputs' => array(
                'block__cover_alignfull_minHeight' => array(
                  'label' => 'Minimum height',
                  'type' => 'input'
                ),
                'block__cover_alignfull_minHeight_mobile' => array(
                  'label' => 'Minimum height',
                  'type' => 'input'
                )
              )
            )
          )
        ),
        'gutenberg_group' => array(
          'label' => 'Group',
          'sections' => array(
            'gutenberg_group_' => array(
              'label' => 'Has background',
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
            )
          )
        ),
        'gutenberg_image' => array(
          'label' => 'Image',
          'sections' => array(
            'gutenberg_image_figcaption' => array(
              'label' => 'Figcaption',
              'inputs' => array(
                'block__imageFigcaption_margin' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'block__imageFigcaption_padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'block__imageFigcaption_fontSize' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'block__imageFigcaption_lineHeight' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'block__imageFigcaption_margin_mobile' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'block__imageFigcaption_padding_mobile' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'block__imageFigcaption_fontSize_mobile' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'block__imageFigcaption_lineHeight_mobile' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                )
              )
            ),
            'gutenberg_image_donloadbutton' => array(
              'label' => 'Download button',
              'inputs' => array(
                'block__imageDonloadButton_marginTop' => array(
                  'label' => 'Margin top',
                  'type' => 'input'
                ),
                'block__imageDonloadButton_marginTop_mobile' => array(
                  'label' => 'Margin top',
                  'type' => 'input'
                )
              )
            )
          )
        ),
        'gutenberg_gallery' => array(
          'label' => 'Image gallery',
          'sections' => array(
            'gutenberg_gallery_' => array(
              'label' => 'Settings',
              'inputs' => array(
                'gallery-block--gutter-size' => array(
                  'label' => 'Space between',
                  'type' => 'input'
                )
              )
            ),
            'gutenberg_gallery_arrows' => array(
              'label' => 'Swiper arrows',
              'inputs' => array(
                'block__imagegallery_arrow_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'block__imagegallery_arrow_opacity' => array(
                  'label' => 'Opacity',
                  'type' => 'input'
                ),
                'block__imagegallery_arrow_position' => array(
                  'label' => 'Position from sides',
                  'type' => 'input'
                ),
                'block__imagegallery_arrow_position_mobile' => array(
                  'label' => 'Position from sides',
                  'type' => 'input'
                )
              )
            ),
            'gutenberg_gallery_bulletNav' => array(
              'label' => 'Bullet navigation',
              'inputs' => array(
                'swiper__bulletNav_gap' => array(
                  'label' => 'Gap',
                  'type' => 'input'
                ),
                'swiper__bulletNav_position' => array(
                  'label' => 'Position from bottom',
                  'type' => 'input'
                ),
                'swiper__bulletNav_position_mobile' => array(
                  'label' => 'Position from bottom',
                  'type' => 'input'
                )
              )
            ),
            'gutenberg_gallery_bulletNav_items' => array(
              'label' => 'Bullet navigation items',
              'inputs' => array(
                'swiper__bulletNav_item_bg' => array(
                  'label' => 'Backgorund color',
                  'type' => 'color'
                ),
                'swiper__bulletNav_item_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'swiper__bulletNav_item_borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'swiper__bulletNav_itemActive_bg' => array(
                  'label' => 'Backgorund color (active)',
                  'type' => 'color'
                ),
                'swiper__bulletNav_itemActive_color' => array(
                  'label' => 'Color (active)',
                  'type' => 'color'
                ),
                'swiper__bulletNav_itemActive_borderColor' => array(
                  'label' => 'Border color (active)',
                  'type' => 'color'
                ),
                'swiper__bulletNav_item_borderRadius' => array(
                  'label' => 'Border radius',
                  'type' => 'input'
                ),
                'swiper__bulletNav_item_borderWidth' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'swiper__bulletNav_item_fontSize' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'swiper__bulletNav_item_width' => array(
                  'label' => 'Width',
                  'type' => 'input'
                ),
                'swiper__bulletNav_item_height' => array(
                  'label' => 'Height',
                  'type' => 'input'
                ),
                'swiper__bulletNav_item_width_mobile' => array(
                  'label' => 'Width',
                  'type' => 'input'
                ),
                'swiper__bulletNav_item_height_mobile' => array(
                  'label' => 'Height',
                  'type' => 'input'
                )
              )
            ),
            'gutenberg_gallery_downloadAll' => array(
              'label' => 'Download all button',
              'inputs' => array(
                'downloadAll__backgroundColor' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'downloadAll__color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'downloadAll__borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'downloadAll__backgroundColor_hover' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'downloadAll__color_hover' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'downloadAll__borderColor_hover' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'downloadAll__borderRadius' => array(
                  'label' => 'Border raduis',
                  'type' => 'input'
                ),
                'downloadAll__borderWidth' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'downloadAll__borderStyle' => array(
                  'label' => 'Border style',
                  'type' => 'select'
                ),
                'downloadAll__padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'downloadAll__fontFamily' => array(
                  'label' => 'Font',
                  'type' => 'input'
                ),
                'downloadAll__fontSize' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'downloadAll__lineHeight' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'downloadAll__fontWeight' => array(
                  'label' => 'Font weight',
                  'type' => 'select'
                ),
                'downloadAll__textTransform' => array(
                  'label' => 'Text transform',
                  'type' => 'select'
                ),
                'downloadAll__fontStyle' => array(
                  'label' => 'Font style',
                  'type' => 'select'
                ),
                'downloadAll__letterSpacing' => array(
                  'label' => 'Text letter spacing',
                  'type' => 'input'
                ),
                'downloadAll__padding_mobile' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'downloadAll__fontSize_mobile' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'downloadAll__lineHeight_mobile' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'downloadAll__letterSpacing_mobile' => array(
                  'label' => 'Text letter spacing',
                  'type' => 'input'
                ),
                'dark__downloadAll__backgroundColor' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__downloadAll__color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'dark__downloadAll__borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'dark__downloadAll__backgroundColor_hover' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__downloadAll__color_hover' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'dark__downloadAll__borderColor_hover' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'downloadAll__progressbar_backgroundColor' => array(
                  'label' => 'Prozessbar Background color',
                  'type' => 'color'
                ),
                'downloadAll__progressbar_prozess_backgroundColor' => array(
                  'label' => 'Prozessbar color',
                  'type' => 'color'
                ),
                'downloadAll__progressbar_prozess_height' => array(
                  'label' => 'Prozessbar height',
                  'type' => 'input'
                ),
                'dark__downloadAll__progressbar_backgroundColor' => array(
                  'label' => 'Prozessbar Background color',
                  'type' => 'color'
                ),
                'dark__downloadAll__progressbar_prozess_backgroundColor' => array(
                  'label' => 'Prozessbar color',
                  'type' => 'color'
                )
              )
            )
          )
        ),
        'gutenberg_imagePins' => array(
          'label' => 'Image with pins',
          'sections' => array(
            'gutenberg_imagePins_pins' => array(
              'label' => 'Pins',
              'inputs' => array(
                'imagePins__pinColor' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'imagePins__pinColor_hover' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'imagePins__pinColor_loaded' => array(
                  'label' => 'Color (loaded)',
                  'type' => 'color'
                ),
                'imagePins__pinSize' => array(
                  'label' => 'Width',
                  'type' => 'input'
                )
              )
            ),
            'gutenberg_imagePins_info' => array(
              'label' => 'Info window',
              'inputs' => array(
                'imagePins__pinInfo_bc' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'imagePins__pinInfo_borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'imagePins__pinInfo_borderWidth' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'imagePins__pinInfo_borderRadius' => array(
                  'label' => 'Border radius',
                  'type' => 'input'
                ),
                'imagePins__pinInfo_width' => array(
                  'label' => 'Max width',
                  'type' => 'input'
                ),
                'imagePins__pinInfo_padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                )
              )
            ),
            'gutenberg_imagePins_infoClose' => array(
              'label' => 'Close info window',
              'inputs' => array(
                'imagePins__pinInfo_closeColor' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'imagePins__pinInfo_closeColor_hover' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'imagePins__pinInfo_closeSize' => array(
                  'label' => 'Width',
                  'type' => 'input'
                )
              )
            )
          )
        ),
        'gutenberg_list' => array(
          'label' => 'List',
          'sections' => array(
            'gutenberg_list_numbered_settings' => array(
              'label' => 'Numbered settings',
              'inputs' => array(
                'block__list_ol_borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'block__list_ol_borderWidth' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'block__list_ol_borderStyle' => array(
                  'label' => 'Border style',
                  'type' => 'select'
                ),
                'block__list_ol_padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'block__list_ol_gap' => array(
                  'label' => 'Gap',
                  'type' => 'input'
                ),
                'block__list_ol_padding_mobile' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'block__list_ol_gap_mobile' => array(
                  'label' => 'Gap',
                  'type' => 'input'
                ),
                'dark__block__list_ol_borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                )
              )
            ),
            'gutenberg_list_numbered_marker' => array(
              'label' => 'Numbered marker & item',
              'inputs' => array(
                'block__list_ol_item_marker_color' => array(
                  'label' => 'Marker color',
                  'type' => 'color',
                  'default' => 'inherit'
                ),
                'block__list_ol_item_borderColor' => array(
                  'label' => 'Item border color',
                  'type' => 'color'
                ),
                'block__list_ol_item_borderWidth' => array(
                  'label' => 'Item border width',
                  'type' => 'input'
                ),
                'block__list_ol_item_borderStyle' => array(
                  'label' => 'Item border style',
                  'type' => 'select'
                ),
                'block__list_ol_item_margin' => array(
                  'label' => 'Item Margin',
                  'type' => 'input'
                ),
                'block__list_ol_item_padding' => array(
                  'label' => 'Item Padding',
                  'type' => 'input'
                ),
                'block__list_ol_marker_listStylePosition' => array(
                  'label' => 'List style position',
                  'type' => 'select'
                ),
                'block__list_ol_marker_fontSize' => array(
                  'label' => 'Marker font size',
                  'type' => 'input'
                ),
                'block__list_ol_marker_lineHeight' => array(
                  'label' => 'Marker line height',
                  'type' => 'input'
                ),
                'block__list_ol_item_margin_mobile' => array(
                  'label' => 'Item Margin',
                  'type' => 'input'
                ),
                'block__list_ol_item_padding_mobile' => array(
                  'label' => 'Item Padding',
                  'type' => 'input'
                ),
                'block__list_ol_marker_fontSize_mobile' => array(
                  'label' => 'Marker font size',
                  'type' => 'input'
                ),
                'block__list_ol_marker_lineHeight_mobile' => array(
                  'label' => 'Marker line height',
                  'type' => 'input'
                ),
                'dark__block__list_ol_item_marker_color' => array(
                  'label' => 'Marker color',
                  'type' => 'color',
                  'default' => 'inherit'
                ),
                'dark__block__list_ol_item_borderColor' => array(
                  'label' => 'Item border color',
                  'type' => 'color'
                )
              )
            ),
            'gutenberg_list_bullet_settings' => array(
              'label' => 'Bullet Settings',
              'inputs' => array(
                'block__list_borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'block__list_borderWidth' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'block__list_borderStyle' => array(
                  'label' => 'Border style',
                  'type' => 'select'
                ),
                'block__list_gap' => array(
                  'label' => 'Gap',
                  'type' => 'input'
                )
              )
            ),
            'gutenberg_list_bullet_marker' => array(
              'label' => 'Bullet marker & item',
              'inputs' => array(
                'gbList_marker_color' => array(
                  'label' => 'Marker color',
                  'type' => 'color',
                  'default' => 'inherit'
                ),
                'block__list_item_borderColor' => array(
                  'label' => 'Item border color',
                  'type' => 'color'
                ),
                'block__list_item_borderWidth' => array(
                  'label' => 'Item border width',
                  'type' => 'input'
                ),
                'block__list_item_borderStyle' => array(
                  'label' => 'Item border style',
                  'type' => 'select'
                ),
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
                ),
                'dark__gbList_marker_color' => array(
                  'label' => 'Marker color',
                  'type' => 'color',
                  'default' => 'inherit'
                )
              )
            )
          )
        ),
        'gutenberg_mediatext' => array(
          'label' => 'Media & Text',
          'sections' => array(
            'gutenberg_mediatext_settings' => array(
              'label' => 'Settings',
              'inputs' => array(
                'block__mediatext_gap' => array(
                  'label' => 'Gap',
                  'type' => 'input'
                ),
                'block__mediatext_backgroundColor' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'block__mediatext_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'block__mediatext_borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'block__mediatext_borderWidth' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'block__mediatext_borderStyle' => array(
                  'label' => 'Border style',
                  'type' => 'select'
                ),
                'block__mediatext_padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'block__mediatext_gap_mobile' => array(
                  'label' => 'Gap',
                  'type' => 'input'
                ),
                'block__mediatext_padding_mobile' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'dark__block__mediatext_backgroundColor' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__block__mediatext_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'dark__block__mediatext_borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                )
              )
            ),
            'gutenberg_mediatext_media' => array(
              'label' => 'Media',
              'inputs' => array(
                'block__mediatext_media_borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'block__mediatext_media_borderWidth' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'block__mediatext_media_borderStyle' => array(
                  'label' => 'Border style',
                  'type' => 'select'
                ),
                'block__mediatext_media_padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'block__mediatext_media_minHeight' => array(
                  'label' => 'Minimum height',
                  'type' => 'input'
                ),
                'block__mediatext_media_maxHeight' => array(
                  'label' => 'Maximum height',
                  'type' => 'input'
                ),
                'block__mediatext_media_padding_mobile' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'block__mediatext_media_minHeight_mobile' => array(
                  'label' => 'Minimum height',
                  'type' => 'input'
                ),
                'block__mediatext_media_maxHeight_mobile' => array(
                  'label' => 'Maximum height',
                  'type' => 'input'
                ),
                'dark__block__mediatext_media_borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                )
              )
            ),
            'gutenberg_mediatext_text' => array(
              'label' => 'Text',
              'inputs' => array(
                'block__mediatext_text_borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'block__mediatext_hasBackground_text_borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'block__mediatext_text_borderWidth' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'block__mediatext_text_borderStyle' => array(
                  'label' => 'Border style',
                  'type' => 'select'
                ),
                'block__mediatext_text_padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'block__mediatext_hasBackground_text_borderWidth' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'block__mediatext_hasBackground_text_borderStyle' => array(
                  'label' => 'Border style',
                  'type' => 'select'
                ),
                'block__mediatext_hasBackground_text_padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'dark__block__mediatext_text_borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'dark__block__mediatext_hasBackground_text_borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                )
              )
            )
          )
        ),
        'gutenberg_paragraph' => array(
          'label' => 'Paragraph',
          'sections' => array(
            'gutenberg_paragraph_hasBackgound' => array(
              'label' => 'Lead text',
              'inputs' => array(
                'block__paragraph_hasBackground_padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                )
              )
            ),
            'gutenberg_paragraph_lead' => array(
              'label' => 'Lead text',
              'inputs' => array(
                'leadText__bg' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'leadText__color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'leadText__borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'leadText__borderWidth' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'leadText__borderStyle' => array(
                  'label' => 'Border style',
                  'type' => 'select'
                ),
                'leadText__padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
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
                'leadText__fontWeight' => array(
                  'label' => 'Font weight',
                  'type' => 'select'
                ),
                'leadText__textTransform' => array(
                  'label' => 'Text transform',
                  'type' => 'select'
                ),
                'leadText__fontStyle' => array(
                  'label' => 'Font style',
                  'type' => 'select'
                ),
                'leadText__letterSpacing' => array(
                  'label' => 'Letter spacing',
                  'type' => 'input'
                ),
                'leadText__padding_mobile' => array(
                  'label' => 'Padding',
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
                'dark__leadText__bg' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__leadText__color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'dark__leadText__borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                )
              )
            )
          )
        ),
        'gutenberg_postsblock' => array(
          'label' => 'Posts',
          'sections' => array(
            'gutenberg_postsblock_item' => array(
              'label' => 'Item',
              'inputs' => array(
                'block__posts_backgroundColor' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'block__posts_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'block__posts_borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'block__posts_borderRadius' => array(
                  'label' => 'Border radius',
                  'type' => 'input'
                ),
                'block__posts_border' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'block__posts_padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'block__posts_flexGap' => array(
                  'label' => 'Gap',
                  'type' => 'input'
                ),
                'block__posts_fontSize' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'block__posts_lineHeight' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'block__posts_fontWeight' => array(
                  'label' => 'Font weight',
                  'type' => 'select'
                )
              )
            ),
            'gutenberg_postsblock_itemthumb' => array(
              'label' => 'Item thumbnail',
              'inputs' => array(
                'block__posts_thumb_margin' => array(
                  'label' => 'Thumbnail margin',
                  'type' => 'input'
                ),
                'block__posts_thumb_padding' => array(
                  'label' => 'Thumbnail padding',
                  'type' => 'input'
                )
              )
            ),
            'gutenberg_postsblock_itemtitle' => array(
              'label' => 'Item title',
              'inputs' => array(
                'block__posts_title_backgroundColor' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'block__posts_title_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'block__posts_title_borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'block__posts_title_borderWidth' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'block__posts_title_borderStyle' => array(
                  'label' => 'Border style',
                  'type' => 'select'
                ),
                'block__posts_title_margin' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'block__posts_title_padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'block__posts_title_fontfamily' => array(
                  'label' => 'Font family',
                  'type' => 'input'
                ),
                'block__posts_title_fontSize' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'block__posts_title_lineHeight' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'block__posts_title_fontWeight' => array(
                  'label' => 'Font weight',
                  'type' => 'select'
                ),
                'block__posts_title_textTransform' => array(
                  'label' => 'Text transform',
                  'type' => 'select'
                ),
                'block__posts_title_fontStyle' => array(
                  'label' => 'Font style',
                  'type' => 'select'
                ),
                'block__posts_title_letterSpacing' => array(
                  'label' => 'Letter spacing',
                  'type' => 'input'
                )
              )
            )
          )
        ),
        'gutenberg_postsfilter' => array(
          'label' => 'Posts filter',
          'sections' => array(
            'gutenberg_postsfilter_item' => array(
              'label' => 'Item',
              'inputs' => array(
                'block__postsfilter_backgroundColor' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'block__postsfilter_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'block__postsfilter_borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'block__postsfilter_borderRadius' => array(
                  'label' => 'Border radius',
                  'type' => 'input'
                ),
                'block__postsfilter_border' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'block__postsfilter_flexGap' => array(
                  'label' => 'Gap',
                  'type' => 'input'
                ),
                'block__postsfilter_padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'block__postsfilter_fontSize' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'block__postsfilter_lineHeight' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'block__postsfilter_fontWeight' => array(
                  'label' => 'Font weight',
                  'type' => 'select'
                )
              )
            ),
            'gutenberg_postsfilter_itemthumb' => array(
              'label' => 'Item thumbnail',
              'inputs' => array(
                'block__postsfilter_thumb_margin' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'block__postsfilter_thumb_padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                )
              )
            ),
            'gutenberg_postsfilter_itemtitle' => array(
              'label' => 'Item title',
              'inputs' => array(
                'block__postsfilter_title_backgroundColor' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'block__postsfilter_title_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'block__postsfilter_title_borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'block__postsfilter_title_borderWidth' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'block__postsfilter_title_borderStyle' => array(
                  'label' => 'Border style',
                  'type' => 'select'
                ),
                'block__postsfilter_title_margin' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'block__postsfilter_title_padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'block__postsfilter_title_fontfamily' => array(
                  'label' => 'Font family',
                  'type' => 'input'
                ),
                'block__postsfilter_title_fontSize' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'block__postsfilter_title_lineHeight' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'block__postsfilter_title_fontWeight' => array(
                  'label' => 'Font weight',
                  'type' => 'select'
                ),
                'block__postsfilter_title_textTransform' => array(
                  'label' => 'Text transform',
                  'type' => 'select'
                ),
                'block__postsfilter_title_fontStyle' => array(
                  'label' => 'Font style',
                  'type' => 'select'
                ),
                'block__postsfilter_title_letterSpacing' => array(
                  'label' => 'Letter spacing',
                  'type' => 'input'
                )
              )
            )
          )
        ),
        'gutenberg_quote' => array(
          'label' => 'Quote',
          'sections' => array(
            'gutenberg_quote_' => array(
              'label' => 'Settings',
              'inputs' => array(
                'block__quote_bg' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'block__quote_color' => array(
                  'label' => 'Color',
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
                  'type' => 'select'
                ),
                'block__quote_textTransform' => array(
                  'label' => 'Text transform',
                  'type' => 'select'
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
                'dark__block__quote_bg' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__block__quote_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'dark__block__quote_borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                )
              )
            ),
            'gutenberg_quote_cite' => array(
              'label' => 'Cite',
              'inputs' => array(
                'block__quote_cite_bg' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'block__quote_cite_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'block__quote_cite_padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'block__quote_cite_fontFamily' => array(
                  'label' => 'Font family',
                  'type' => 'input'
                ),
                'block__quote_cite_fontSize' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'block__quote_cite_lineHeight' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'block__quote_cite_fontWeight' => array(
                  'label' => 'Font weight',
                  'type' => 'select'
                ),
                'block__quote_cite_textTransform' => array(
                  'label' => 'Cite text transform',
                  'type' => 'select'
                ),
                'block__quote_cite_letterSpacing' => array(
                  'label' => 'Letter spacing',
                  'type' => 'input'
                ),
                'block__quote_cite_padding_mobile' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'block__quote_cite_fontSize_mobile' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'block__quote_cite_lineHeight_mobile' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'dark__block__quote_cite_bg' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__block__quote_cite_color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                )
              )
            )
          )
        ),
        'gutenberg_seperator' => array(
          'label' => 'Seperator',
          'sections' => array(
            'gutenberg_seperator_settings' => array(
              'label' => 'Settings',
              'inputs' => array(
                'gbSeperator_color' => array(
                  'label' => 'Default color',
                  'type' => 'color'
                ),
                'block__separator_marginTop' => array(
                  'label' => 'Margin top',
                  'type' => 'input'
                ),
                'block__separator_marginBottom' => array(
                  'label' => 'Margin bottom',
                  'type' => 'input'
                ),
                'block__separator_width' => array(
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
                'block__separator_width_mobile' => array(
                  'label' => 'Height',
                  'type' => 'input'
                ),
                'dark__gbSeperator_color' => array(
                  'label' => 'Default color',
                  'type' => 'color'
                )
              )
            ),
            'gutenberg_seperator_dots' => array(
              'label' => 'Dotted',
              'inputs' => array(
                'block__separatorDots_fontSize' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'block__separatorDots_fontSize_mobile' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                )
              )
            )
          )
        ),
        'gutenberg_table' => array(
          'label' => 'Table',
          'sections' => array(
            'gutenberg_table_head' => array(
              'label' => 'Head',
              'inputs' => array(
                'block__tableHead_fontFamily' => array(
                  'label' => 'Font family',
                  'type' => 'input'
                ),
                'block__tableHead_fontSize' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'block__tableHead_lineHeight' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'block__tableHead_fontWeight' => array(
                  'label' => 'Font weight',
                  'type' => 'select'
                ),
                'block__tableHead_textTransform' => array(
                  'label' => 'Text transform',
                  'type' => 'select'
                ),
                'block__tableHead_letterSpacing' => array(
                  'label' => 'Letter spacing',
                  'type' => 'input'
                ),
                'block__tableHead_fontSize_mobile' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'block__tableHead_lineHeight_mobile' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'block__tableHead_letterSpacing_mobile' => array(
                  'label' => 'Letter spacing',
                  'type' => 'input'
                )
              )
            ),
            'gutenberg_table_columns' => array(
              'label' => 'Columns',
              'inputs' => array(
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
                  'type' => 'select'
                ),
                'block__table_textTransform' => array(
                  'label' => 'text transform',
                  'type' => 'select'
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
            )
          )
        ),
        'gutenberg_title' => array(
          'label' => 'Title',
          'sections' => array(
            'gutenberg_title_postTitle' => array(
              'label' => 'Post title',
              'inputs' => array(
                'postTitle__bg' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'postTitle__color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'postTitle__borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'postTitle__borderStyle' => array(
                  'label' => 'Border style',
                  'type' => 'select'
                ),
                'postTitle__borderWidth' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'postTitle__margin' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'postTitle__padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
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
                'postTitle__fontWeight' => array(
                  'label' => 'Font weight',
                  'type' => 'select'
                ),
                'postTitle__textTransform' => array(
                  'label' => 'Text transform',
                  'type' => 'select'
                ),
                'postTitle__fontStyle' => array(
                  'label' => 'Font style',
                  'type' => 'select'
                ),
                'postTitle__letterSpacing' => array(
                  'label' => 'Letter spacing',
                  'type' => 'input'
                ),
                'postTitle__margin_mobile' => array(
                  'label' => 'Margin',
                  'type' => 'input'
                ),
                'postTitle__padding_mobile' => array(
                  'label' => 'Padding',
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
                'dark__postTitle__color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'dark__postTitle__bg' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__postTitle__borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                )
              )
            ),
            'gutenberg_title_title1' => array(
              'label' => 'Title 1',
              'inputs' => array(
                'titleOne__bg' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'titleOne__color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'titleOne__borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'titleOne__borderStyle' => array(
                  'label' => 'Border style',
                  'type' => 'select'
                ),
                'titleOne__borderWidth' => array(
                  'label' => 'Border width',
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
                'titleOne__padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
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
                'titleOne__fontWeight' => array(
                  'label' => 'Font weight',
                  'type' => 'select'
                ),
                'titleOne__textTransform' => array(
                  'label' => 'Text transform',
                  'type' => 'select'
                ),
                'titleOne__fontStyle' => array(
                  'label' => 'Font style',
                  'type' => 'select'
                ),
                'titleOne__letterSpacing' => array(
                  'label' => 'Letter spacing',
                  'type' => 'input'
                ),
                'titleOne__marginTop_mobile' => array(
                  'label' => 'Margin top',
                  'type' => 'input'
                ),
                'titleOne__marginBottom_mobile' => array(
                  'label' => 'Margin bottom',
                  'type' => 'input'
                ),
                'titleOne__padding_mobile' => array(
                  'label' => 'Padding',
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
                'dark__titleOne__bg' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__titleOne__color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'dark__titleOne__borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                )
              )
            ),
            'gutenberg_title_title2' => array(
              'label' => 'Title 2',
              'inputs' => array(
                'titleTwo__bg' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'titleTwo__color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'titleTwo__borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'titleTwo__borderStyle' => array(
                  'label' => 'Border style',
                  'type' => 'select'
                ),
                'titleTwo__borderWidth' => array(
                  'label' => 'Border width',
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
                'titleTwo__padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
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
                'titleTwo__fontWeight' => array(
                  'label' => 'Font weight',
                  'type' => 'select'
                ),
                'titleTwo__textTransform' => array(
                  'label' => 'Text transform',
                  'type' => 'select'
                ),
                'titleTwo__fontStyle' => array(
                  'label' => 'Font style',
                  'type' => 'select'
                ),
                'titleTwo__letterSpacing' => array(
                  'label' => 'Letter spacing',
                  'type' => 'input'
                ),
                'titleTwo__marginTop_mobile' => array(
                  'label' => 'Margin top',
                  'type' => 'input'
                ),
                'titleTwo__marginBottom_mobile' => array(
                  'label' => 'Margin bottom',
                  'type' => 'input'
                ),
                'titleTwo__padding_mobile' => array(
                  'label' => 'Padding',
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
                'dark__titleTwo__color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'dark__titleTwo__bg' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__titleTwo__borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                )
              )
            ),
            'gutenberg_title_title3' => array(
              'label' => 'Title 3',
              'inputs' => array(
                'titleThree__bg' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'titleThree__color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'titleThree__borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'titleThree__borderStyle' => array(
                  'label' => 'Border style',
                  'type' => 'select'
                ),
                'titleThree__borderWidth' => array(
                  'label' => 'Border width',
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
                'titleThree__padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
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
                'titleThree__fontWeight' => array(
                  'label' => 'Font weight',
                  'type' => 'select'
                ),
                'titleThree__textTransform' => array(
                  'label' => 'Text transform',
                  'type' => 'select'
                ),
                'titleThree__fontStyle' => array(
                  'label' => 'Font style',
                  'type' => 'select'
                ),
                'titleThree__letterSpacing' => array(
                  'label' => 'Letter spacing',
                  'type' => 'input'
                ),
                'titleThree__marginTop_mobile' => array(
                  'label' => 'Margin top',
                  'type' => 'input'
                ),
                'titleThree__marginBottom_mobile' => array(
                  'label' => 'Margin bottom',
                  'type' => 'input'
                ),
                'titleThree__padding_mobile' => array(
                  'label' => 'Padding',
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
                'dark__titleThree__bg' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__titleThree__color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'dark__titleThree__borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                )
              )
            ),
            'gutenberg_title_title4' => array(
              'label' => 'Title 4',
              'inputs' => array(
                'titleFour__bg' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'titleFour__color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'titleFour__borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'titleFour__borderStyle' => array(
                  'label' => 'Border style',
                  'type' => 'select'
                ),
                'titleFour__borderWidth' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'titleFour__marginTop' => array(
                  'label' => 'Margin top',
                  'type' => 'input'
                ),
                'titleFour__marginBottom' => array(
                  'label' => 'Margin bottom',
                  'type' => 'input'
                ),
                'titleFour__padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'titleFour__fontFamily' => array(
                  'label' => 'Title font family',
                  'type' => 'input'
                ),
                'titleFour__fontSize' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'titleFour__lineHeight' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'titleFour__fontWeight' => array(
                  'label' => 'Font weight',
                  'type' => 'select'
                ),
                'titleFour__textTransform' => array(
                  'label' => 'Text transform',
                  'type' => 'select'
                ),
                'titleFour__fontStyle' => array(
                  'label' => 'Font style',
                  'type' => 'select'
                ),
                'titleFour__letterSpacing' => array(
                  'label' => 'Letter spacing',
                  'type' => 'input'
                ),
                'titleFour__marginTop_mobile' => array(
                  'label' => 'Margin top',
                  'type' => 'input'
                ),
                'titleFour__marginBottom_mobile' => array(
                  'label' => 'Margin bottom',
                  'type' => 'input'
                ),
                'titleFour__padding_mobile' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'titleFour__fontSize_mobile' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'titleFour__lineHeight_mobile' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'dark__titleFour__bg' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__titleFour__color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'dark__titleFour__borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                )
              )
            ),
            'gutenberg_title_title5' => array(
              'label' => 'Title 5',
              'inputs' => array(
                'titleFive__bg' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'titleFive__color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'titleFive__borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'titleFive__borderStyle' => array(
                  'label' => 'Border style',
                  'type' => 'select'
                ),
                'titleFive__borderWidth' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'titleFive__marginTop' => array(
                  'label' => 'Margin top',
                  'type' => 'input'
                ),
                'titleFive__marginBottom' => array(
                  'label' => 'Margin bottom',
                  'type' => 'input'
                ),
                'titleFive__padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'titleFive__fontFamily' => array(
                  'label' => 'Title font family',
                  'type' => 'input'
                ),
                'titleFive__fontSize' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'titleFive__lineHeight' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'titleFive__fontWeight' => array(
                  'label' => 'Font weight',
                  'type' => 'select'
                ),
                'titleFive__textTransform' => array(
                  'label' => 'Text transform',
                  'type' => 'select'
                ),
                'titleFive__fontStyle' => array(
                  'label' => 'Font style',
                  'type' => 'select'
                ),
                'titleFive__letterSpacing' => array(
                  'label' => 'Letter spacing',
                  'type' => 'input'
                ),
                'titleFive__marginTop_mobile' => array(
                  'label' => 'Margin top',
                  'type' => 'input'
                ),
                'titleFive__marginBottom_mobile' => array(
                  'label' => 'Margin bottom',
                  'type' => 'input'
                ),
                'titleFive__padding_mobile' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'titleFive__fontSize_mobile' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'titleFive__lineHeight_mobile' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'dark__titleFive__bg' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__titleFive__color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'dark__titleFive__borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                )
              )
            )
          )
        ),
        'gutenberg_video' => array(
          'label' => 'Video',
          'sections' => array(
            'gutenberg_video_settings' => array(
              'label' => 'Settings (Video JS)',
              'inputs' => array(
                'block__videojs_iconFont' => array(
                  'label' => 'Icons font family',
                  'type' => 'input',
                  'default' => 'VideoJS'
                )
              )
            ),
            'gutenberg_video_coverstart' => array(
              'label' => 'Start cover (Video JS)',
              'inputs' => array(
                'block__videojs_coverStart_bgColor' => array(
                  'label' => 'Background color (on start)',
                  'type' => 'color'
                ),
                'block__videojs_coverStart_opacity (on start)' => array(
                  'label' => 'Opacity',
                  'type' => 'input'
                ),
                'block__videojs_coverPause_bgColor' => array(
                  'label' => 'Background color (on pause)',
                  'type' => 'color'
                ),
                'block__videojs_coverPause_opacity' => array(
                  'label' => 'Opacity (on pause)',
                  'type' => 'input'
                )
              )
            ),
            'gutenberg_video_playbutton' => array(
              'label' => 'Play button (Video JS)',
              'inputs' => array(
                'block__videojs_firstPlay_bgColor' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'block__videojs_firstPlay_borderColor' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'block__videojs_firstPlay_color' => array(
                  'label' => 'Icon color',
                  'type' => 'color'
                ),
                'block__videojs_firstPlay_bgColor_hover' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'block__videojs_firstPlay_borderColor_hover' => array(
                  'label' => 'Border color',
                  'type' => 'color'
                ),
                'block__videojs_firstPlay_color_hover' => array(
                  'label' => 'Icon color',
                  'type' => 'color'
                ),
                'block__videojs_firstPlay_borderWidth' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'block__videojs_firstPlay_borderRadius' => array(
                  'label' => 'Border radius',
                  'type' => 'input'
                ),
                'block__videojs_firstPlay_padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'block__videojs_firstPlay_size' => array(
                  'label' => 'Icon size',
                  'type' => 'input'
                ),
                'block__videojs_firstPlay_borderWidth_mobile' => array(
                  'label' => 'Border width',
                  'type' => 'input'
                ),
                'block__videojs_firstPlay_size_mobile' => array(
                  'label' => 'Icon size',
                  'type' => 'input'
                )
              )
            ),
            'gutenberg_video_controlbar' => array(
              'label' => 'Control bar (Video JS)',
              'inputs' => array(
                'block__videojs_controlBar_bgColor' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'block__videojs_controlBarButton_color' => array(
                  'label' => 'Icon color',
                  'type' => 'color'
                ),
                'block__videojs_controlBarButton_color_hover' => array(
                  'label' => 'Icon color',
                  'type' => 'color'
                ),
                'block__videojs_controlBar_borderRadius' => array(
                  'label' => 'Border radius',
                  'type' => 'input'
                ),
                'block__videojs_controlBar_spacing' => array(
                  'label' => 'Spacing',
                  'type' => 'input'
                ),
                'block__videojs_controlBar_padding' => array(
                  'label' => 'Padding',
                  'type' => 'input'
                ),
                'block__videojs_controlBar_gap' => array(
                  'label' => 'Gap',
                  'type' => 'input'
                ),
                'block__videojs_controlBarButton_fontSize' => array(
                  'label' => 'Icon size',
                  'type' => 'input'
                )
              )
            ),
            'gutenberg_video_progressbar' => array(
              'label' => 'Progress bar (Video JS)',
              'inputs' => array(
                'block__videojs_progress_bgColor' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'block__videojs_progress_height' => array(
                  'label' => 'Height',
                  'type' => 'input'
                ),
                'block__videojs_progress_button_color' => array(
                  'label' => 'Button color',
                  'type' => 'color'
                ),
                'block__videojs_progress_button_fontSize' => array(
                  'label' => 'Button size',
                  'type' => 'input'
                ),
                'block__videojs_progress_passed_bgColor' => array(
                  'label' => 'Passed progress bar',
                  'type' => 'color'
                ),
                'block__videojs_progress_remainingTime_color' => array(
                  'label' => 'Remaining time color',
                  'type' => 'color'
                ),
                'block__videojs_progress_remainingTime_fontSize' => array(
                  'label' => 'Remaining time font size',
                  'type' => 'input'
                )
              )
            ),
            'gutenberg_video_tooltip' => array(
              'label' => 'Tooltip (Video JS)',
              'inputs' => array(
                'block__videojs_tooltip_bgColor' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'block__videojs_tooltip_Color' => array(
                  'label' => 'Color',
                  'type' => 'color'
                ),
                'bblock__videojs_tooltip_fontSize' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'bblock__videojs_tooltip_lineHeight' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'block__videojs_tooltip_decoSize' => array(
                  'label' => 'Decoration size',
                  'type' => 'input'
                )
              )
            )
          )
        )
      ),
      'sections' => array()
    ),
    'footer' => array(
      'label' => 'Footer',
      'panels' => array(
        'footer_settings' => array(
          'label' => 'Settings',
          'sections' => array(
            'footer_settings_colors' => array(
              'label' => 'Colors',
              'inputs' => array(
                'footer_background' => array(
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'footercontainer_background' => array(
                  'label' => 'Container background color',
                  'type' => 'color'
                ),
                'footer_color' => array(
                  'label' => 'Color',
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
                  'label' => 'Background color',
                  'type' => 'color'
                ),
                'dark__footercontainer_background' => array(
                  'label' => 'Container background color',
                  'type' => 'color'
                ),
                'dark__footer_color' => array(
                  'label' => 'Color',
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
            'footer_settings_spacing' => array(
              'label' => 'Spacing',
              'inputs' => array(
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
            'footer_settings_typography' => array(
              'label' => 'Typography',
              'inputs' => array(
                'footer__fontsize' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'footer__lineheight' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                ),
                'footer__fontsize_mobile' => array(
                  'label' => 'Font size',
                  'type' => 'input'
                ),
                'footer__lineheight_mobile' => array(
                  'label' => 'Line height',
                  'type' => 'input'
                )
              )
            )
          )
        )
      ),
      'sections' => array(
        'gutenberg_menu' => array(
          'label' => 'Menu',
          'inputs' => array(
            'footer__menu_link_color' => array(
              'label' => 'Color',
              'type' => 'color'
            ),
            'footer__menu_linkHover_color' => array(
              'label' => 'Hover color',
              'type' => 'color'
            ),
            'footer__menu_link_fontfamily' => array(
              'label' => 'Font family',
              'type' => 'input'
            ),
            'footer__menu_link_fontsize' => array(
              'label' => 'Font size',
              'type' => 'input'
            ),
            'footer__menu_link_lineheight' => array(
              'label' => 'Line height',
              'type' => 'input'
            ),
            'footer__menu_link_fontWeight' => array(
              'label' => 'Font weight',
              'type' => 'select'
            ),
            'footer__menu_link_textTransform' => array(
              'label' => 'Text transform',
              'type' => 'select'
            ),
            'footer__menu_link_letterSpacing' => array(
              'label' => 'Letter spacing',
              'type' => 'input'
            ),
            'footer__menu_link_fontsize_mobile' => array(
              'label' => 'Font size',
              'type' => 'input'
            ),
            'footer__menu_link_lineheight_mobile' => array(
              'label' => 'Line height',
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

    // Inlcude the Alpha Color Picker control file.
    require_once( dirname( __FILE__ ) . '/alpha-color-picker/alpha-color-picker.php' );
    require_once( dirname( __FILE__ ) . '/nesting/nesting.php' );
    $wp_customize->register_panel_type( 'PE_WP_Customize_Panel' );

    foreach ($this->defaultValues as $panelKey => $panelValues) {
      SELF::buildPanel($wp_customize, $panelKey, $panelValues, '', 1);
    }

  }
  // build panal
  function buildPanel($wp_customize, $panelKey, $panelValues, $panalParent, $priority){
    // build panal
    if($panalParent !== ''):
      // $wp_customize->add_panel($panelKey,
      //   array(
      //     'title' => $panelValues["label"],
      //     'priority' => $priority,
      //     'panel' => $panalParent
      //   )
      // );
      $panelBuilder = new PE_WP_Customize_Panel( $wp_customize, $panelKey, array(
        'title' => $panelValues["label"],
        'priority' => $priority,
        'panel' => $panalParent
      ));
    else:
      // $wp_customize->add_panel($panelKey,
      //   array(
      //     'title' => $panelValues["label"],
      //     'priority' => $priority
      //   )
      // );
      $panelBuilder = new PE_WP_Customize_Panel( $wp_customize, $panelKey, array(
        'title' => $panelValues["label"],
        'priority' => $priority
      ));
    endif;
    $wp_customize->add_panel( $panelBuilder );
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
    // if (strpos($inputKey, 'dark__') !== false):
    //   $activeLabels[] = __( 'dark mode', 'customizer' );
    // endif;
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
    if (strpos($inputKey, '_hover') !== false || strpos($inputKey, 'Hover_') !== false):
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
        'default'           => array_key_exists('default', $inputValues) ? $inputValues["default"] : ''
      ));
      $wp_customize->add_control(new Customize_Alpha_Color_Control( $wp_customize, $inputKey, array(
        'label'        => __( $inputValues["label"], 'customizer' ) . $labelAdd,
        'section'      => $sectionKey,
        'show_opacity' => true,
        'priority'     => 1
     )));
    elseif($inputValues["type"] == 'select'):
      // default options
      if(!array_key_exists('options', $inputValues) && strpos($inputKey, '_fontStyle') !== false):
        $selectOptions = array(
          '' => '-',
          'italic' => 'italic',
          'normal' => 'normal',
          'oblique' => 'oblique'
        );
      elseif(!array_key_exists('options', $inputValues) && strpos($inputKey, '_listStylePosition') !== false):
        $selectOptions = array(
          '' => '-',
          'inside' => 'inside',
          'outside' => 'outside',
          'inherit' => 'inherit'
        );
      elseif(!array_key_exists('options', $inputValues) && strpos($inputKey, '_borderStyle') !== false):
        $selectOptions = array(
          '' => '-',
          'dashed' => 'dashed',
          'dotted' => 'dotted',
          'double' => 'double',
          'groove' => 'groove',
          'hidden' => 'hidden',
          'inset' => 'inset',
          'outset' => 'outset',
          'ridge' => 'ridge',
          'solid' => 'solid',
          'inherit' => 'inherit'
        );
      elseif(!array_key_exists('options', $inputValues) && strpos($inputKey, '_display') !== false):
        $selectOptions = array(
          '' => '-',
          'block' => 'block',
          'contents' => 'contents',
          'flex' => 'flex',
          'flow-root' => 'flow-root',
          'grid' => 'grid',
          'inline' => 'inline',
          'inline-block' => 'inline-block',
          'inline-flex' => 'inline-flex',
          'inline-grid' => 'inline-grid',
          'inline-table' => 'inline-table',
          'list-item' => 'list-item',
          'none' => 'none',
          'run-in' => 'run-in',
          'subgrid' => 'subgrid',
          'table' => 'table',
          'table-caption' => 'table-caption',
          'table-cell' => 'table-cell',
          'table-column' => 'table-column',
          'table-column-group' => 'table-column-group',
          'table-footer-group' => 'table-footer-group',
          'table-header-group' => 'table-header-group',
          'table-row' => 'table-row',
          'table-row-group' => 'table-row-group',
          'inherit' => 'inherit'
        );
      elseif(!array_key_exists('options', $inputValues) && strpos($inputKey, '_textAlign') !== false):
        $selectOptions = array(
          '' => '-',
          'inherit' => 'inherit',
          'justify' => 'justify',
          'left' => 'left',
          'center' => 'center',
          'right' => 'right'
        );
      elseif(!array_key_exists('options', $inputValues) && strpos($inputKey, '_textTransform') !== false):
        $selectOptions = array(
          '' => '-',
          'capitalize' => 'capitalize',
          'full-width' => 'full-width',
          'lowercase' => 'lowercase',
          'none' => 'none',
          'uppercase' => 'uppercase',
          'inherit' => 'inherit'
        );
      elseif(!array_key_exists('options', $inputValues) && strpos($inputKey, '_fontWeight') !== false || !array_key_exists('options', $inputValues) && strpos($inputKey, '_fontweight') !== false):
        $selectOptions = array(
          '' => '-',
          '100' => '100',
          '200' => '200',
          '300' => '300',
          '400' => '400',
          '500' => '500',
          '600' => '600',
          '700' => '700',
          '800' => '800',
          '900' => '900'
        );
      elseif(!array_key_exists('options', $inputValues) && strpos($inputKey, '_flexDirection') !== false):
        $selectOptions = array(
          '' => '-',
          'column' => 'column',
          'column-reverse' => 'column reverse',
          'row' => 'row',
          'row-reverse' => 'row reverse'
        );
      elseif(array_key_exists('options', $inputValues)):
        $selectOptions = $inputValues["options"];
      else:
        $selectOptions = array('' => '-');
      endif;
      //
      $wp_customize->add_setting($inputKey, array(
        'transport'         => 'postMessage',
        'default'           => array_key_exists('default', $inputValues) ? $inputValues["default"] : '',
        'sanitize_callback' => 'wp_filter_nohtml_kses',
      ));
      $wp_customize->add_control($inputKey, array(
        'label'    => __( $inputValues["label"], 'customizer' ) . $labelAdd,
        'section'  => $sectionKey,
        'type'     => 'select',
        'choices'  => $selectOptions,
        'priority' => 1
      ));
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
    elseif($getModsUpdate == "1"):
      $customizerUpdate = SELF::generateCusomizerFile();
      update_option('theme_mods_childtheme_update', 2, false);
    endif;
  }



  /*==================================================================================
    2.0 FUNCTIONS
  ==================================================================================*/

  /* 2.1 ENQUEUE SCRIPTS/STYLES
  /------------------------*/
  function customizerEnqueue() {
    wp_enqueue_style('theme/customizer', get_stylesheet_directory_uri() . '/customizer.css', false, "1.9" . time());
  }


  /* 2.2 GENERATE THE CUSTOMIZER FILE
  /------------------------*/
  public function generateCusomizerFile() {
    // ob_start();
    // require(get_template_directory() . "/dist/responsive_contentW.css");
    // $output .= ob_get_clean();
    // ob_end_flush();

    // do math for master theme responsive file
    $inputsToBuild = array();
    $get_mobile_breakpoint = preg_split('/(?<=[0-9])(?=[a-z]+)/i',get_theme_mod('mobile_breakpoint', '768px'));
    $mobile_breakpoint = $get_mobile_breakpoint[0] - 1;
    $container_width = preg_split('/(?<=[0-9])(?=[a-z]+)/i',get_theme_mod('container__width', '1000px'));
    $wide_left = preg_split('/(?<=[0-9])(?=[a-z]+)/i',get_theme_mod('wide__left', '200px'));
    $wide_right = preg_split('/(?<=[0-9])(?=[a-z]+)/i',get_theme_mod('wide__right', '200px'));
    $wide_reset = $container_width[0] + $wide_left[0] + $wide_right[0];
    $popup_width = preg_split('/(?<=[0-9])(?=[a-z]+)/i',get_theme_mod('popup__width', '800px'));
    $popup_space = preg_split('/(?<=[0-9])(?=[a-z]+)/i',get_theme_mod('popup__space', '40px'));
    $popup_breakpoint = $popup_width[0] + $popup_space[0] + $popup_space[0];
    // build new file content
    $mobileDarkOutput = '';
    $darkOutput = '';
    $mobileOutput = '';
    $output = '';
    $output .= ':root {';
      $output .= '--wideWidth: ' . $wide_reset . 'px;';
      foreach ($this->defaultValues as $panelKey => $panelValues) {
        // first level sections
        foreach ($panelValues["sections"] as $sectionKey => $sectionValues) {
          foreach ($sectionValues["inputs"] as $valueKey => $ValueSettings) {
            $inputsToBuild[$valueKey] = $ValueSettings;
          }
        }
        // second level sections
        foreach ($panelValues["panels"] as $subPanelKey => $subPanelValues) {
          foreach ($subPanelValues["sections"] as $sectionKey => $sectionValues) {
            foreach ($sectionValues["inputs"] as $valueKey => $ValueSettings) {
              $inputsToBuild[$valueKey] = $ValueSettings;
            }
          }
          // third level sections
          foreach ($subPanelValues["panels"] as $subsubPanelKey => $subsubPanelValues) {
            foreach ($subsubPanelValues["sections"] as $sectionKey => $sectionValues) {
              foreach ($sectionValues["inputs"] as $valueKey => $ValueSettings) {
                $inputsToBuild[$valueKey] = $ValueSettings;
              }
            }
          }
        }
      }
      foreach ($inputsToBuild as $valueKey => $ValueSettings) {
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

    // get configurator settings
    global $configuration;
    if($configuration && array_key_exists('gutenberg', $configuration)):
      $gutenbergCofig = $configuration['gutenberg'];
      // add custom colors
      if(array_key_exists('ColorPalette', $gutenbergCofig)):
        foreach ($gutenbergCofig['ColorPalette'] as $colorKey => $color) {
          $slug = prefix_core_BaseFunctions::Slugify($color["key"]);
          $output .= '.has-' . $slug . '-background-color {background-color: ' . $color["value"] . ';}';
          $output .= '.has-' . $slug . '-border-color {border-color: ' . $color["value"] . ';}';
          $output .= '.has-' . $slug . '-color, .has-' . $slug . '-color > * {color: ' . $color["value"] . ';}';
        }
      endif;
      // add custom font sizes
      if(array_key_exists('FontSizes', $gutenbergCofig)):
        $fontSizeMobile = '';
        foreach ($gutenbergCofig['FontSizes'] as $fontsizeKey => $fontsize) {
          $slug = prefix_core_BaseFunctions::Slugify($fontsize["key"]);
          $output .= 'body.frontend .has-' . $slug . '---font-size, .block-editor .editor-styles-wrapper .has-' . $slug . '---font-size, body.page-template .has-' . $slug . '---font-size, ';
          $output .= 'body.frontend .has-' . $slug . '---font-size > *, .block-editor .editor-styles-wrapper .has-' . $slug . '---font-size > *, body.page-template .has-' . $slug . '---font-size > * ';
          $output .= '{font-size: ' . $fontsize["value"] . ';}';
          if(array_key_exists('valueMobile', $fontsize)):
            $fontSizeMobile .= 'body.frontend .has-' . $slug . '---font-size, .block-editor .editor-styles-wrapper .has-' . $slug . '---font-size, body.page-template .has-' . $slug . '---font-size, ';
            $fontSizeMobile .= 'body.frontend .has-' . $slug . '---font-size > *, .block-editor .editor-styles-wrapper .has-' . $slug . '---font-size > *, body.page-template .has-' . $slug . '---font-size > * ';
            $fontSizeMobile .= '{font-size: ' . $fontsize["valueMobile"] . ';}';
          endif;
        }
        if($fontSizeMobile !== ''):
          $output .= '@media screen and (max-width: ' . $mobile_breakpoint . $get_mobile_breakpoint[1] . ') {';
            $output .= $fontSizeMobile;
          $output .= '}';
        endif;
      endif;
    endif;

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
    wp_enqueue_script('theme/customizer', get_template_directory_uri() . '/classes/prefix_core_Customizer/assets/theme-customizer.js', ['jquery', 'customize-preview'], '1.0', true);
  }

}
