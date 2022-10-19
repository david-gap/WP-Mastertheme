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
        addBulletNav,
        addPopUp,
        addPopUpInfo,
        addPopUpPreview,
        addDownloadButton,
        addDownloadAllButton
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
                    id="add-bulletnav"
                    label={ __( 'Activate bullet navigation', 'devTheme' ) }
                    checked={ addBulletNav }
                    onChange={addBulletNav => setAttributes({ addBulletNav })}
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
                    id="posts-popup-info"
                    label={ __( 'Load post info inside Lightbox', 'devTheme' ) }
                    checked={ addPopUpInfo }
                    onChange={addPopUpInfo => setAttributes({ addPopUpInfo })}
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
              <PanelRow>
                <ToggleControl
                    id="add-download-button"
                    label={ __( 'Download button', 'devTheme' ) }
                    checked={ addDownloadButton }
                    onChange={addDownloadButton => setAttributes({ addDownloadButton })}
                />
              </PanelRow>
              <PanelRow>
                <ToggleControl
                    id="add-download-all-button"
                    label={ __( 'Download all button', 'devTheme' ) }
                    checked={ addDownloadAllButton }
                    onChange={addDownloadAllButton => setAttributes({ addDownloadAllButton })}
                />
              </PanelRow>
          </PanelBody>
      </InspectorControls>
    );
  }
}
