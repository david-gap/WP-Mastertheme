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
        zoomActive,
        zoomMax,
        zoomSteps,
        zoomPosition
      },
      setAttributes
    } = this.props;

    return (
      <InspectorControls>
          <PanelBody title={ __( 'Zoom', 'devTheme' ) } initialOpen={ false } >
              <PanelRow>
                <ToggleControl
                    id="add-swiper"
                    label={ __( 'Activate zoom options', 'devTheme' ) }
                    checked={ zoomActive }
                    onChange={zoomActive => setAttributes({ zoomActive })}
                />
              </PanelRow>
              <PanelRow>
                <RangeControl
                  label={__("Max zoom in", "devTheme")}
                  value={zoomMax}
                  onChange={zoomMax => setAttributes({ zoomMax })}
                  min={1}
                  max={10}
                />
              </PanelRow>
              <PanelRow>
                <RangeControl
                  label={__("Zoom steps", "devTheme")}
                  value={zoomSteps}
                  onChange={zoomSteps => setAttributes({ zoomSteps })}
                  min={0.1}
                  max={1}
                  step={0.1}
                />
              </PanelRow>
              <PanelRow>
                <SelectControl
                  label={__("Position", "devTheme")}
                  value={zoomPosition}
                  options={[
                    { value: "top-left", label: __( 'Top and left', 'devTheme' ) },
                    { value: "top-right", label: __( 'Top and right', 'devTheme' ) },
                    { value: "bottom-left", label: __( 'Bottom and left', 'devTheme' ) },
                    { value: "bottom-right", label: __( 'Bottom and right', 'devTheme' ) }
                  ]}
                  onChange={zoomPosition => setAttributes({ zoomPosition })}
                />
              </PanelRow>
          </PanelBody>
      </InspectorControls>
    );
  }
}
