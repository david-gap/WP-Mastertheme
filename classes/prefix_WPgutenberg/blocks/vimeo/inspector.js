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
        posterVideoID,
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
          <PanelBody title={ __( 'Video settings', 'devTheme' ) } >
              <TextControl
                label={__("ID", "devTheme")}
                help={__("example: https://player.vimeo.com/video/xxxxxxxxx", "devTheme")}
                value={videoID}
                onChange={videoID => setAttributes({ videoID })}
              />
              <TextControl
                label={__("Poster Video ID", "devTheme")}
                help={__("example: https://player.vimeo.com/video/xxxxxxxxx", "devTheme")}
                value={posterVideoID}
                onChange={posterVideoID => setAttributes({ posterVideoID })}
              />
              <TextControl
                label={__("Width", "devTheme")}
                value={videoDimensionX}
                onChange={videoDimensionX => setAttributes({ videoDimensionX })}
              />
              <TextControl
                label={__("Height", "devTheme")}
                value={videoDimensionY}
                onChange={videoDimensionY => setAttributes({ videoDimensionY })}
              />
              <PanelRow>
                <ToggleControl
                    id="vimeoblock-autoplay"
                    label={ __( 'Autoplay', 'devTheme' ) }
                    checked={ videoAutoPlay }
                    onChange={videoAutoPlay => setAttributes({ videoAutoPlay })}
                />
              </PanelRow>
              <PanelRow>
                <ToggleControl
                    id="vimeoblock-background"
                    label={ __( 'Background Video', 'devTheme' ) }
                    checked={ videoBackgroud }
                    onChange={videoBackgroud => setAttributes({ videoBackgroud })}
                />
              </PanelRow>
              <PanelRow>
                <ToggleControl
                    id="vimeoblock-loop"
                    label={ __( 'Loop', 'devTheme' ) }
                    checked={ videoLoop }
                    onChange={videoLoop => setAttributes({ videoLoop })}
                />
              </PanelRow>
              <PanelRow>
                <ToggleControl
                    id="vimeoblock-mute"
                    label={ __( 'Mute', 'devTheme' ) }
                    checked={ videoMute }
                    onChange={videoMute => setAttributes({ videoMute })}
                />
              </PanelRow>
            </PanelBody>
            <PanelBody title={ __( 'Table of content (by chapters)', 'devTheme' ) } initialOpen={ false } >
              <PanelRow>
                <ToggleControl
                    id="vimeoblock-TOC"
                    label={ __( 'Active', 'devTheme' ) }
                    checked={ videoTableOfContent }
                    onChange={videoTableOfContent => setAttributes({ videoTableOfContent })}
                />
              </PanelRow>
              <PanelRow>
                <ToggleControl
                    id="vimeoblock-TOC"
                    label={ __( 'Toggle', 'devTheme' ) }
                    checked={ videoTOCtoggle }
                    onChange={videoTOCtoggle => setAttributes({ videoTOCtoggle })}
                />
              </PanelRow>
              <PanelRow>
                <SelectControl
                  label={__("Position", "devTheme")}
                  value={videoTOCposition}
                  options={[
                    { value: "top", label: __( 'Top', 'devTheme' ) },
                    { value: "left", label: __( 'Left', 'devTheme' ) },
                    { value: "bottom", label: __( 'Bottom', 'devTheme' ) },
                    { value: "right", label: __( 'Right', 'devTheme' ) }
                  ]}
                  onChange={videoTOCposition => setAttributes({ videoTOCposition })}
                />
              </PanelRow>
              <PanelRow>
                <ToggleControl
                    id="vimeoblock-TOCautoplay"
                    label={ __( 'Play on chapter selection', 'devTheme' ) }
                    checked={ videoTOCautoplay }
                    onChange={videoTOCautoplay => setAttributes({ videoTOCautoplay })}
                />
              </PanelRow>
              <PanelRow>
                <ToggleControl
                    id="vimeoblock-TOCend"
                    label={ __( 'Stop on chapter end', 'devTheme' ) }
                    checked={ videoTOCstop }
                    onChange={videoTOCstop => setAttributes({ videoTOCstop })}
                />
              </PanelRow>
          </PanelBody>
          <PanelBody title={ __( 'Video Link (background video only)', 'devTheme' ) } initialOpen={ false } >
            <PanelRow>
              <TextControl
                label={__("Link", "devTheme")}
                help={__("Can only be used with background videos", "devTheme")}
                value={videoLink}
                onChange={videoLink => setAttributes({ videoLink })}
              />
            </PanelRow>
            <PanelRow>
              <SelectControl
                label={__("Target", "devTheme")}
                value={videoLinkTarget}
                options={[
                  { value: "_self", label: __( 'Same window', 'devTheme' ) },
                  { value: "_blank", label: __( 'New window', 'devTheme' ) }
                ]}
                onChange={videoLinkTarget => setAttributes({ videoLinkTarget })}
              />
            </PanelRow>
          </PanelBody>
      </InspectorControls>
    );
  }
}
