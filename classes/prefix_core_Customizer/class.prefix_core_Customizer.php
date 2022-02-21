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
          'label' => 'Typography',
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
            ),
            'html__fontweight' => array(
              'label' => 'Main font weight',
              'type' => 'input',
              'default' => '400'
            ),
            'html__fontsize_small' => array(
              'label' => 'Small text size',
              'type' => 'input',
              'default' => '70%'
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
            'mnav__color' => array(
              'label' => 'Color',
              'type' => 'color',
              'default' => '#000'
            ),
            'mnav__background_color' => array(
              'label' => 'Background color',
              'type' => 'color',
              'default' => 'transparent'
            ),
            'mnav__color_hover' => array(
              'label' => 'Color (hover)',
              'type' => 'color',
              'default' => '#000'
            ),
            'mnav__background_color_hover' => array(
              'label' => 'Background color (hover)',
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
              'type' => 'input',
              'default' => '0'
            ),
            'mnav__padding' => array(
              'label' => 'Padding',
              'type' => 'input',
              'default' => '0px'
            ),
            'mnav__margin' => array(
              'label' => 'Margin',
              'type' => 'input',
              'default' => '0px'
            ),
            'mnav__fontfamily' => array(
              'label' => 'Font family',
              'type' => 'input',
              'default' => 'inherit'
            ),
            'mnav__fontsize' => array(
              'label' => 'Font size',
              'type' => 'input',
              'default' => '100%'
            ),
            'mnav__fontWeight' => array(
              'label' => 'Font weight',
              'type' => 'input',
              'default' => '700'
            ),
            'mnav__lineheight' => array(
              'label' => 'Line height',
              'type' => 'input',
              'default' => '1.4'
            ),
            'mnav__textTransform' => array(
              'label' => 'Text transform',
              'type' => 'input',
              'default' => 'uppercase'
            ),
            'mnav__fontsize_mobile' => array(
              'label' => 'Font size (mobile)',
              'type' => 'input',
              'default' => '120%'
            ),
            'mnav__lineheight_mobile' => array(
              'label' => 'Line height (mobile)',
              'type' => 'input',
              'default' => '1.3'
            ),
            'mnav__padding_mobile' => array(
              'label' => 'Padding (mobile)',
              'type' => 'input'
            ),
            'mnav__margin_mobile' => array(
              'label' => 'Margin (mobile)',
              'type' => 'input'
            ),
            'mnav__sub_color' => array(
              'label' => 'Submenu color',
              'type' => 'color',
              'default' => '#000'
            ),
            'mnav__sub_background_color' => array(
              'label' => 'Submenu background color',
              'type' => 'color',
              'default' => 'transparent'
            ),
            'mnav__sub_color_hover' => array(
              'label' => 'Submenu color (hover)',
              'type' => 'color',
              'default' => '#000'
            ),
            'mnav__sub_background_color_hover' => array(
              'label' => 'Submenu background color (hover)',
              'type' => 'color',
              'default' => 'transparent'
            ),
            'mnav__sub_border_color' => array(
              'label' => 'Submenu border color',
              'type' => 'color',
              'default' => 'transparent'
            ),
            'mnav__sub_border_width' => array(
              'label' => 'Submenu border width',
              'type' => 'input',
              'default' => '0'
            ),
            'mnav__sub_padding' => array(
              'label' => 'Submenu padding',
              'type' => 'input',
              'default' => '0px'
            ),
            'mnav__sub_margin' => array(
              'label' => 'Submenu margin',
              'type' => 'input',
              'default' => '0px'
            ),
            'mnav__sub_fontfamily' => array(
              'label' => 'Submenu font family',
              'type' => 'input',
              'default' => 'inherit'
            ),
            'mnav__sub_fontsize' => array(
              'label' => 'Submenu font size',
              'type' => 'input',
              'default' => '80%'
            ),
            'mnav__sub_fontWeight' => array(
              'label' => 'Submenu font weight',
              'type' => 'input',
              'default' => '500'
            ),
            'mnav__sub_lineheight' => array(
              'label' => 'Submenu line height',
              'type' => 'input',
              'default' => 'inherit'
            ),
            'mnav__sub_textTransform' => array(
              'label' => 'Submenu text transform',
              'type' => 'input',
              'default' => 'none'
            ),
            'mnav__sub_fontsize_mobile' => array(
              'label' => 'Submenu font size (mobile)',
              'type' => 'input'
            ),
            'mnav__sub_lineheight_mobile' => array(
              'label' => 'Submenu line height (mobile)',
              'type' => 'input'
            ),
            'mnav__sub_padding_mobile' => array(
              'label' => 'Submenu padding (mobile)',
              'type' => 'input'
            ),
            'mnav__sub_margin_mobile' => array(
              'label' => 'Submenu margin (mobile)',
              'type' => 'input'
            ),
            'mnav__subSub_color' => array(
              'label' => 'Subsubmenu color',
              'type' => 'color',
              'default' => '#000'
            ),
            'mnav__subSub_background_color' => array(
              'label' => 'Subsubmenu background color',
              'type' => 'color',
              'default' => 'transparent'
            ),
            'mnav__subSub_color_hover' => array(
              'label' => 'Subsubmenu color (hover)',
              'type' => 'color',
              'default' => '#000'
            ),
            'mnav__subSub_background_color_hover' => array(
              'label' => 'Subsubmenu background color (hover)',
              'type' => 'color',
              'default' => 'transparent'
            ),
            'mnav__subSub_border_color' => array(
              'label' => 'Subsubmenu border color',
              'type' => 'color',
              'default' => 'transparent'
            ),
            'mnav__subSub_border_width' => array(
              'label' => 'Subsubmenu border width',
              'type' => 'input',
              'default' => '0'
            ),
            'mnav__subSub_padding' => array(
              'label' => 'Subsubmenu padding',
              'type' => 'input',
              'default' => '0px'
            ),
            'mnav__subSub_margin' => array(
              'label' => 'Subsubmenu margin',
              'type' => 'input',
              'default' => '0px'
            ),
            'mnav__subSub_fontfamily' => array(
              'label' => 'Subsubmenu font family',
              'type' => 'input',
              'default' => 'inherit'
            ),
            'mnav__subSub_fontsize' => array(
              'label' => 'Subsubmenu font size',
              'type' => 'input'
            ),
            'mnav__subSub_fontWeight' => array(
              'label' => 'Subsubmenu font weight',
              'type' => 'input'
            ),
            'mnav__subSub_lineheight' => array(
              'label' => 'Subsubmenu line height',
              'type' => 'input'
            ),
            'mnav__subSub_textTransform' => array(
              'label' => 'Subsubmenu text transform',
              'type' => 'input'
            ),
            'mnav__subSub_fontsize_mobile' => array(
              'label' => 'Subsubmenu font size (mobile)',
              'type' => 'input'
            ),
            'mnav__subSub_lineheight_mobile' => array(
              'label' => 'Subsubmenu line height (mobile)',
              'type' => 'input'
            ),
            'mnav__subSub_padding_mobile' => array(
              'label' => 'Subsubmenu padding (mobile)',
              'type' => 'input'
            ),
            'mnav__subSub_margin_mobile' => array(
              'label' => 'Subsubmenu margin (mobile)',
              'type' => 'input'
            )
          )
        ),
        'hamburger' => array(
          'label' => 'Hamburger',
          'inputs' => array(
            'hamburger__container_width' => array(
              'label' => 'Width',
              'type' => 'input',
              'default' => '40px'
            ),
            'hamburger__container_height' => array(
              'label' => 'Height',
              'type' => 'input',
              'default' => '40px'
            ),
            'hamburger__size' => array(
              'label' => 'Size',
              'type' => 'input',
              'default' => '4px'
            ),
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
            ),
            'hamburger__title_space' => array(
              'label' => 'Title spacing',
              'type' => 'input',
              'default' => '0 0 0 10px'
            ),
            'hamburger__title_fontSize' => array(
              'label' => 'Title font size',
              'type' => 'input',
              'default' => 'inherit'
            ),
            'hamburger__title_LineHeight' => array(
              'label' => 'Title line height',
              'type' => 'input',
              'default' => 'inherit'
            ),
            'hamburger__title_fontWeight' => array(
              'label' => 'Title spacing',
              'type' => 'input',
              'default' => 'inherit'
            ),
            'hamburger__container_width_mobile' => array(
              'label' => 'Width (mobile)',
              'type' => 'input'
            ),
            'hamburger__container_height_mobile' => array(
              'label' => 'Height (mobile)',
              'type' => 'input'
            )
          )
        ),
        'header_desktop' => array(
          'label' => 'Desktop',
          'inputs' => array(
            'header__paddingTop' => array(
              'label' => 'Container padding top',
              'type' => 'input',
              'default' => '10px'
            ),
            'header__paddingBottom' => array(
              'label' => 'Container padding bottom',
              'type' => 'input',
              'default' => '10px'
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
              'type' => 'input',
              'default' => '20px'
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
            'html__anchor_mobile' => array(
              'label' => 'Anchor position',
              'type' => 'input',
              'default' => '120px'
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
              'default' => '#fff'
            ),
            'input__border_width' => array(
              'label' => 'Input border width',
              'type' => 'input',
              'default' => '1px'
            ),
            'input__border_color' => array(
              'label' => 'Input border color',
              'type' => 'color',
              'default' => '#000'
            ),
            'input__fontFamily' => array(
              'label' => 'Input font family',
              'type' => 'input',
              'default' => 'inherit'
            ),
            'input__fontSize' => array(
              'label' => 'Input font size',
              'type' => 'input',
              'default' => 'inherit'
            ),
            'input__lineHeight' => array(
              'label' => 'Input line height',
              'type' => 'input',
              'default' => 'inherit'
            ),
            'input__fontWeight' => array(
              'label' => 'Input font weight',
              'type' => 'input',
              'default' => 'inherit'
            ),
            'input__fontSize_mobile' => array(
              'label' => 'Input font size (mobile)',
              'type' => 'input',
              'default' => 'inherit'
            ),
            'input__lineHeight_mobile' => array(
              'label' => 'Input line height (mobile)',
              'type' => 'input',
              'default' => 'inherit'
            ),
            'input__borderRadius' => array(
              'label' => 'Input border radius',
              'type' => 'input',
              'default' => '0px'
            ),
            'input__padding' => array(
              'label' => 'Input padding',
              'type' => 'input',
              'default' => '7px 10px'
            ),
            'input__padding_mobile' => array(
              'label' => 'Input padding mobile',
              'type' => 'input',
              'default' => '7px 10px'
            ),
            'input__checkbox_bg' => array(
              'label' => 'Checkbox/Radio background color',
              'type' => 'color',
              'default' => '#fff'
            ),
            'input__checkbox_fontSize' => array(
              'label' => 'Checkbox/Radio font size',
              'type' => 'input',
              'default' => 'inherit'
            ),
            'input__checkbox_lineHeight' => array(
              'label' => 'Checkbox/Radio line height',
              'type' => 'input',
              'default' => 'inherit'
            ),
            'input__checkbox_fontWeight' => array(
              'label' => 'Checkbox/Radio font weight',
              'type' => 'input',
              'default' => 'inherit'
            ),
            'input__checkbox_fontSize_mobile' => array(
              'label' => 'Checkbox/Radio font size (mobile)',
              'type' => 'input',
              'default' => 'inherit'
            ),
            'input__checkbox_lineHeight_mobile' => array(
              'label' => 'Checkbox/Radio line height (mobile)',
              'type' => 'input',
              'default' => 'inherit'
            ),
            'input__checkbox_width' => array(
              'label' => 'Checkbox/Radio width/height',
              'type' => 'input',
              'default' => '20px'
            ),
            'input__checkbox_border_width' => array(
              'label' => 'Checkbox/Radio border',
              'type' => 'input',
              'default' => '1px'
            ),
            'input__checkbox_space' => array(
              'label' => 'Checkbox/Radio space to text',
              'type' => 'input',
              'default' => '20px'
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
            'input__submit_fontFamily' => array(
              'label' => 'Submit font family',
              'type' => 'input',
              'default' => 'inherit'
            ),
            'input__submit_fontSize' => array(
              'label' => 'Submit/button font size',
              'type' => 'input',
              'default' => 'inherit'
            ),
            'input__submit_lineHeight' => array(
              'label' => 'Submit/button line height',
              'type' => 'input',
              'default' => 'inherit'
            ),
            'input__submit_fontWeight' => array(
              'label' => 'Submit/button font weight',
              'type' => 'input',
              'default' => 'inherit'
            ),
            'input__submit_textTransform' => array(
              'label' => 'Submit/button text transform',
              'type' => 'input'
            ),
            'input__submit_fontSize_mobile' => array(
              'label' => 'Submit/button font size (mobile)',
              'type' => 'input',
              'default' => 'inherit'
            ),
            'input__submit_lineHeight_mobile' => array(
              'label' => 'Submit/button line height (mobile)',
              'type' => 'input',
              'default' => 'inherit'
            ),
            'input__submit_bg_color' => array(
              'label' => 'Submit/button background color',
              'type' => 'color',
              'default' => '#0175bc'
            ),
            'input__submit_color' => array(
              'label' => 'Submit/button text color',
              'type' => 'color',
              'default' => '#fff'
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
              'default' => '#fff'
            ),
            'input__submit_borderRadius' => array(
              'label' => 'Submit/button border radius',
              'type' => 'input',
              'default' => '0px'
            ),
            'input__submit_padding' => array(
              'label' => 'Submit/button padding',
              'type' => 'input',
              'default' => '10px 20px'
            ),
            'input__submit_padding_mobile' => array(
              'label' => 'Submit/button padding (mobile)',
              'type' => 'input'
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
              'label' => 'Select padding (mobile)',
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
              'label' => 'Select font size (mobile)',
              'type' => 'input'
            ),
            'input__select_lineHeight_mobile' => array(
              'label' => 'Select line height (mobile)',
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
              'type' => 'input',
              'default' => '30px'
            ),
            'input__selectContainer_width_mobile' => array(
              'label' => 'Select container size (mobile)',
              'type' => 'input'
            ),
            'input__required' => array(
              'label' => 'Required color',
              'type' => 'color',
              'default' => '#a53737'
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
            'block__separator_width' => array(
              'label' => 'Height',
              'type' => 'input',
              'default' => '1px'
            ),
            'block__separator_marginTop' => array(
              'label' => 'Margin top',
              'type' => 'input'
            ),
            'block__separator_marginBottom' => array(
              'label' => 'Margin bottom',
              'type' => 'input'
            ),
            'light__gbSeperator_color' => array(
              'label' => 'Default color',
              'type' => 'color',
              'default' => '#dddddd'
            ),
            'dark__gbSeperator_color' => array(
              'label' => 'Default color (dark mode)',
              'type' => 'color',
              'default' => '#343434'
            ),
            'block__separator_width_mobile' => array(
              'label' => 'Height (mobile)',
              'type' => 'input'
            ),
            'block__separator_marginTop_mobile' => array(
              'label' => 'Margin top (mobile)',
              'type' => 'input'
            ),
            'block__separator_marginBottom_mobile' => array(
              'label' => 'Margin bottom (mobile)',
              'type' => 'input'
            )
          )
        ),
        'columns' => array(
          'label' => 'Columns',
          'inputs' => array(
            'wp--style--block-gap' => array(
              'label' => 'Space between',
              'type' => 'input',
              'default' => '20px'
            )
          )
        ),
        'buttons' => array(
          'label' => 'Buttons',
          'inputs' => array(
            'block__buttons_spacing' => array(
              'label' => 'Space between buttons',
              'type' => 'input',
              'default' => '20px'
            ),
            'block__buttons_fontFamily' => array(
              'label' => 'Font',
              'type' => 'input',
              'default' => 'inherit'
            ),
            'block__buttons_fontSize' => array(
              'label' => 'Font size',
              'type' => 'input',
              'default' => 'inherit'
            ),
            'block__buttons_fontWeight' => array(
              'label' => 'Font weight',
              'type' => 'input',
              'default' => 'inherit'
            ),
            'block__buttons_lineHeight' => array(
              'label' => 'Line height',
              'type' => 'input',
              'default' => 'inherit'
            ),
            'block__buttons_textTransform' => array(
              'label' => 'Text transform',
              'type' => 'input',
              'default' => 'inherit'
            ),
            'block__buttons_padding' => array(
              'label' => 'Padding',
              'type' => 'input',
              'default' => '10px 20px'
            ),
            'block__buttons_borderWidth' => array(
              'label' => 'Border width',
              'type' => 'input',
              'default' => '1px'
            ),
            'block__buttons_borderRadius' => array(
              'label' => 'Border radius',
              'type' => 'input',
              'default' => '0px'
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
              'label' => 'Font size (mobile)',
              'type' => 'input'
            ),
            'block__buttons_lineHeight_mobile' => array(
              'label' => 'Line height (mobile)',
              'type' => 'input'
            ),
            'block__buttons_textTransform_mobile' => array(
              'label' => 'Text transform (mobile)',
              'type' => 'input'
            ),
            'block__buttons_padding_mobile' => array(
              'label' => 'Padding (mobile)',
              'type' => 'input'
            ),
            'block__buttons_borderWidth_mobile' => array(
              'label' => 'Border width (mobile)',
              'type' => 'input'
            ),
            'block__buttons_borderRadius_mobile' => array(
              'label' => 'Border radius (mobile)',
              'type' => 'input'
            )
          )
        ),
        'list' => array(
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
            'block__list_marker_space' => array(
              'label' => 'Marker spacing',
              'type' => 'input',
              'default' => '20px'
            ),
            'block__list_marker_space_mobile' => array(
              'label' => 'Marker spacing (mobile)',
              'type' => 'input'
            ),
            'light__gbList_marker_color' => array(
              'label' => 'Marker color',
              'type' => 'color',
              'default' => 'inherit'
            ),
            'dark__gbList_marker_color' => array(
              'label' => 'Marker color (dark mode)',
              'type' => 'color',
              'default' => 'inherit'
            )
          )
        ),
        'gutenberg_accordion' => array(
          'label' => 'Accordion',
          'inputs' => array(
            'block__accordion_separator' => array(
              'label' => 'Space between accordions',
              'type' => 'input',
              'default' => '20px'
            ),
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
            'block__accordion_label_fontweight' => array(
              'label' => 'Label font weight',
              'type' => 'input',
              'default' => 'inherit'
            ),
            'block__accordion_label_lineheight' => array(
              'label' => 'Label line-height',
              'type' => 'input',
              'default' => 'inherit'
            ),
            'block__accordion_label_fontsize_mobile' => array(
              'label' => 'Label font-size (mobile)',
              'type' => 'input'
            ),
            'block__accordion_label_lineheight_mobile' => array(
              'label' => 'Label line-height (mobile)',
              'type' => 'input'
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
              'label' => 'Content font size',
              'type' => 'input',
              'default' => 'inherit'
            ),
            'block__accordion_content_lineheight' => array(
              'label' => 'Content line height',
              'type' => 'input',
              'default' => 'inherit'
            ),
            'block__accordion_content_fontsize_mobile' => array(
              'label' => 'Content font size (mobile)',
              'type' => 'input',
              'default' => 'inherit'
            ),
            'block__accordion_content_lineheight_mobile' => array(
              'label' => 'Content line height (mobile)',
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
            'light__footer_color' => array(
              'label' => 'Text color',
              'type' => 'color'
            ),
            'light__footer_link_color' => array(
              'label' => 'Link color',
              'type' => 'color'
            ),
            'light__footer_linkHover_color' => array(
              'label' => 'Link hover color',
              'type' => 'color'
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
            ),
            'dark__footer_color' => array(
              'label' => 'Text color (dark mode)',
              'type' => 'color'
            ),
            'dark__footer_link_color' => array(
              'label' => 'Link color (dark mode)',
              'type' => 'color'
            ),
            'dark__footer_linkHover_color' => array(
              'label' => 'Link hover color (dark mode)',
              'type' => 'color'
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
            ),
            'footer__paddingTop' => array(
              'label' => 'Container padding top',
              'type' => 'input',
              'default' => '40px'
            ),
            'footer__paddingBottom' => array(
              'label' => 'Container padding bottom',
              'type' => 'input',
              'default' => '20px'
            ),
            'footer_itemSpacing' => array(
              'label' => 'Item Spacing (vertical)',
              'type' => 'input',
              'default' => '20px'
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
      __('Text color', 'devTheme'),
      __('Link color', 'devTheme'),
      __('Link hover color', 'devTheme'),
      __('Footer background (dark mode)', 'devTheme'),
      __('Footer container background (dark mode)', 'devTheme'),
      __('Text color (dark mode)', 'devTheme'),
      __('Link color (dark mode)', 'devTheme'),
      __('Link hover color (dark mode)', 'devTheme'),
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
            $quotemark = array_key_exists("quotemark",$ValueSettings) && $ValueSettings["quotemark"]  == '1' ? '"' : '';
            $insert = htmlspecialchars(get_theme_mod($valueKey, $ValueSettings["default"]));
            if($insert !== ''):
              if (strpos($valueKey, '_mobile') !== false):
                $mobileOutput .= '--' . str_replace('_mobile', '', $valueKey) . ': ' . $quotemark . $insert . $quotemark . ';';
              else:
                // move to mobile
                $output .= '--' . $valueKey . ': ' . $quotemark . $insert . $quotemark . ';';
              endif;
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
