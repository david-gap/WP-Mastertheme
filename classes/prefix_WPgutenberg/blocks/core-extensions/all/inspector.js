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
        hideOnDesktop,
        hideOnMobile
      },
      setAttributes
    } = this.props;

    return (
      <InspectorControls>
          <PanelBody title={ __( 'Extensions', 'WPgutenberg' ) } >
              <PanelRow>
                <ToggleControl
                    id="hide-desktop"
                    label={ __( 'Hide on desktop', 'WPgutenberg' ) }
                    checked={ hideOnDesktop }
                    onChange={hideOnDesktop => setAttributes({ hideOnDesktop })}
                />
              </PanelRow>
              <PanelRow>
                <ToggleControl
                    id="hide-mobile"
                    label={ __( 'Hide on mobile', 'WPgutenberg' ) }
                    checked={ hideOnMobile }
                    onChange={hideOnMobile => setAttributes({ hideOnMobile })}
                />
              </PanelRow>
          </PanelBody>
      </InspectorControls>
    );
  }
}
