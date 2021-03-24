/**
 * Internal block libraries
*/
const { __ } = wp.i18n;
const { Component } = wp.element;
const { registerBlockType } = wp.blocks;
const {
  InspectorControls,
  ColorPalette,
  PanelColorSettings,
  ContrastChecker
} = wp.editor;

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
        videoID,
        videoAutoPlay,
        videoBackgroud,
        videoLoop,
        videoDimensionX,
        videoDimensionY
      },
      setAttributes
    } = this.props;

    return (
      <InspectorControls>
          <PanelBody title={ __( 'Video settings', 'WPgutenberg' ) } >
              <TextControl
                label={__("ID", "WPgutenberg")}
                help={__("example: https://player.vimeo.com/video/xxxxxxxxx", "WPgutenberg")}
                value={videoID}
                onChange={videoID => setAttributes({ videoID })}
              />
              <TextControl
                label={__("Dimension X", "WPgutenberg")}
                value={videoDimensionX}
                onChange={videoDimensionX => setAttributes({ videoDimensionX })}
              />
              <TextControl
                label={__("Dimension Y", "WPgutenberg")}
                help={__("example: 4:3 = ", "WPgutenberg")}
                value={videoDimensionY}
                onChange={videoDimensionY => setAttributes({ videoDimensionY })}
              />
              <PanelRow>
                <ToggleControl
                    id="vimeoblock-autoplay"
                    label={ __( 'Autoplay', 'WPgutenberg' ) }
                    checked={ videoAutoPlay }
                    onChange={videoAutoPlay => setAttributes({ videoAutoPlay })}
                />
              </PanelRow>
              <PanelRow>
                <ToggleControl
                    id="vimeoblock-background"
                    label={ __( 'Background Video', 'WPgutenberg' ) }
                    checked={ videoBackgroud }
                    onChange={videoBackgroud => setAttributes({ videoBackgroud })}
                />
              </PanelRow>
              <PanelRow>
                <ToggleControl
                    id="vimeoblock-loop"
                    label={ __( 'Loop', 'WPgutenberg' ) }
                    checked={ videoLoop }
                    onChange={videoLoop => setAttributes({ videoLoop })}
                />
              </PanelRow>
          </PanelBody>
      </InspectorControls>
    );
  }
}
