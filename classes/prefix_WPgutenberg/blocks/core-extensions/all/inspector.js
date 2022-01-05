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
  SelectControl,
  DateTimePicker
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
        hideOnMobile,
        disabledValue,
        scaduleStart,
        scaduleEnd
      },
      setAttributes
    } = this.props;

    return (
      <InspectorControls>
          <PanelBody title={ __( 'Visibility', 'devTheme' ) } >
              <PanelRow>
                <ToggleControl
                    id="hide-desktop"
                    label={ __( 'Hide on desktop', 'devTheme' ) }
                    checked={ hideOnDesktop }
                    onChange={hideOnDesktop => setAttributes({ hideOnDesktop })}
                />
              </PanelRow>
              <PanelRow>
                <ToggleControl
                    id="hide-mobile"
                    label={ __( 'Hide on mobile', 'devTheme' ) }
                    checked={ hideOnMobile }
                    onChange={hideOnMobile => setAttributes({ hideOnMobile })}
                />
              </PanelRow>
              <PanelRow>
                <ToggleControl
                    id="disabled-content"
                    label={ __( 'Disable content', 'devTheme' ) }
                    checked={ disabledValue }
                    onChange={disabledValue => setAttributes({ disabledValue })}
                />
              </PanelRow>
          </PanelBody>
          <PanelBody title={ __( 'Schedule', 'devTheme' ) } >
            <PanelRow>
              {__("Start", "devTheme")}{<br />}
              {__("If block availability starts on this date", "devTheme")}
            </PanelRow>
            <PanelRow>
              <DateTimePicker
                currentDate={scaduleStart}
                onChange={scaduleStart => setAttributes({ scaduleStart })}
              />
            </PanelRow>
            <PanelRow>
              {__("End", "devTheme")}{<br />}
              {__("If block availability stops on this date", "devTheme")}
            </PanelRow>
            <PanelRow>
              <DateTimePicker
                currentDate={scaduleEnd}
                onChange={scaduleEnd => setAttributes({ scaduleEnd })}
              />
            </PanelRow>
          </PanelBody>
      </InspectorControls>
    );
  }
}
