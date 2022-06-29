/**
 * Internal block libraries
*/
const { __ } = wp.i18n;
const { Component } = wp.element;
const { registerBlockType } = wp.blocks;
const {
  ColorPalette,
  PanelColorSettings,
  ContrastChecker
} = wp.editor;

const {
  InspectorControls
} = wp.blockEditor;

const {
  CheckboxControl,
  PanelBody,
  PanelRow,
  RadioControl,
  RangeControl,
  TextControl,
  TextareaControl,
  ToggleControl,
  SelectControl
} = wp.components;

/**
 * Create an Inspector Controls wrapper Component
*/
export default class Inspector extends Component {
  constructor() {
    super(...arguments);
  }
  render() {
    const {
      attributes: {
        addSwiper,
        addPopUp,
        addPopUpPreview
      },
      setAttributes
    } = this.props;

    return (
      <InspectorControls>
          <PanelBody title={ __( 'Swiper & Lightbox', 'devTheme' ) } initialOpen={ false } >
              <PanelRow>
                <ToggleControl
                    id="add-swiper"
                    label={ __( 'Activate Swiper', 'devTheme' ) }
                    checked={ addSwiper }
                    onChange={addSwiper => setAttributes({ addSwiper })}
                />
              </PanelRow>
              <PanelRow>
                <ToggleControl
                    id="add-popup"
                    label={ __( 'Activate Lightbox', 'devTheme' ) }
                    checked={ addPopUp }
                    onChange={addPopUp => setAttributes({ addPopUp })}
                />
              </PanelRow>
              <PanelRow>
                <ToggleControl
                    id="add-popup"
                    label={ __( 'Activate Lightbox preview', 'devTheme' ) }
                    checked={ addPopUpPreview }
                    onChange={addPopUpPreview => setAttributes({ addPopUpPreview })}
                />
              </PanelRow>
          </PanelBody>
      </InspectorControls>
    );
  }
}
