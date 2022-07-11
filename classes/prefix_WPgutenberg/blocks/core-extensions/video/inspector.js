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
        videoJS,
        playCentered
      },
      setAttributes
    } = this.props;

    return (
      <InspectorControls>
          <PanelBody title={ __( 'Video JS', 'devTheme' ) } initialOpen={ false } >
              <PanelRow>
                <ToggleControl
                    id="add-swiper"
                    label={ __( 'Activate JS', 'devTheme' ) }
                    checked={ videoJS }
                    onChange={videoJS => setAttributes({ videoJS })}
                />
              </PanelRow>
              <PanelRow>
                <ToggleControl
                    id="add-popup"
                    label={ __( 'First play button centered', 'devTheme' ) }
                    checked={ playCentered }
                    onChange={playCentered => setAttributes({ playCentered })}
                />
              </PanelRow>
          </PanelBody>
      </InspectorControls>
    );
  }
}
