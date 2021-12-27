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
        videoID,
        videoAutoPlay,
        videoBackgroud,
        videoLoop,
        videoMute,
        videoDimensionX,
        videoDimensionY,
        videoTableOfContent,
        videoTOCtoggle,
        videoTOCposition,
        videoTOCautoplay,
        videoTOCstop,
        videoLink,
        videoLinkTarget
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
                label={__("Width", "WPgutenberg")}
                value={videoDimensionX}
                onChange={videoDimensionX => setAttributes({ videoDimensionX })}
              />
              <TextControl
                label={__("Height", "WPgutenberg")}
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
              <PanelRow>
                <ToggleControl
                    id="vimeoblock-mute"
                    label={ __( 'Mute', 'WPgutenberg' ) }
                    checked={ videoMute }
                    onChange={videoMute => setAttributes({ videoMute })}
                />
              </PanelRow>
            </PanelBody>
            <PanelBody title={ __( 'Table of content (by chapters)', 'WPgutenberg' ) } >
              <PanelRow>
                <ToggleControl
                    id="vimeoblock-TOC"
                    label={ __( 'Active', 'WPgutenberg' ) }
                    checked={ videoTableOfContent }
                    onChange={videoTableOfContent => setAttributes({ videoTableOfContent })}
                />
              </PanelRow>
              <PanelRow>
                <ToggleControl
                    id="vimeoblock-TOC"
                    label={ __( 'Toggle', 'WPgutenberg' ) }
                    checked={ videoTOCtoggle }
                    onChange={videoTOCtoggle => setAttributes({ videoTOCtoggle })}
                />
              </PanelRow>
              <PanelRow>
                <SelectControl
                  label={__("Position", "WPgutenberg")}
                  value={videoTOCposition}
                  options={[
                    { value: "top", label: __( 'Top', 'WPgutenberg' ) },
                    { value: "left", label: __( 'Left', 'WPgutenberg' ) },
                    { value: "bottom", label: __( 'Bottom', 'WPgutenberg' ) },
                    { value: "right", label: __( 'Right', 'WPgutenberg' ) }
                  ]}
                  onChange={videoTOCposition => setAttributes({ videoTOCposition })}
                />
              </PanelRow>
              <PanelRow>
                <ToggleControl
                    id="vimeoblock-TOCautoplay"
                    label={ __( 'Play on chapter selection', 'WPgutenberg' ) }
                    checked={ videoTOCautoplay }
                    onChange={videoTOCautoplay => setAttributes({ videoTOCautoplay })}
                />
              </PanelRow>
              <PanelRow>
                <ToggleControl
                    id="vimeoblock-TOCend"
                    label={ __( 'Stop on chapter end', 'WPgutenberg' ) }
                    checked={ videoTOCstop }
                    onChange={videoTOCstop => setAttributes({ videoTOCstop })}
                />
              </PanelRow>
          </PanelBody>
          <PanelBody title={ __( 'Video Link (background video only)', 'WPgutenberg' ) } >
            <PanelRow>
              <TextControl
                label={__("Link", "WPgutenberg")}
                help={__("Can only be used with background videos", "WPgutenberg")}
                value={videoLink}
                onChange={videoLink => setAttributes({ videoLink })}
              />
            </PanelRow>
            <PanelRow>
              <SelectControl
                label={__("Target", "WPgutenberg")}
                value={videoLinkTarget}
                options={[
                  { value: "_self", label: __( 'Same window', 'WPgutenberg' ) },
                  { value: "_blank", label: __( 'New window', 'WPgutenberg' ) }
                ]}
                onChange={videoLinkTarget => setAttributes({ videoLinkTarget })}
              />
            </PanelRow>
          </PanelBody>
      </InspectorControls>
    );
  }
}
