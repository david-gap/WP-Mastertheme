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
        addPopUpPreview,
        addDownloadButton
      },
      setAttributes
    } = this.props;

    return (
      <InspectorControls>
          <PanelBody title={ __( 'Lightbox', 'devTheme' ) } initialOpen={ false } >
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
                    id="add-download-button"
                    label={ __( 'Download button', 'devTheme' ) }
                    checked={ addDownloadButton }
                    onChange={addDownloadButton => setAttributes({ addDownloadButton })}
                />
              </PanelRow>
          </PanelBody>
      </InspectorControls>
    );
  }
}
