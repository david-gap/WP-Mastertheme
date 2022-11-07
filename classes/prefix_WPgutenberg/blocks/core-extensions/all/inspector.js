/**
 * Internal block libraries
*/
const { __ } = wp.i18n;
const { Component } = wp.element;
const { registerBlockType, getBlockDefaultClassName } = wp.blocks;
const { select, withSelect, setState } = wp.data;
const {
  ColorPalette,
  PanelColorSettings,
  ContrastChecker
} = wp.editor;

const {
  InspectorControls,
  MediaUploadCheck,
  MediaUpload
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
  DateTimePicker,
  ResponsiveWrapper,
  Button,
  Spinner
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
        scaduleEnd,
        removeSpacing,
        additionalSpacingOne,
        additionalSpacingTwo,
        sideSpacing,
        dsgvoImgId,
        dsgvoImageURL,
        dsgvoCookie
      },
      setAttributes
    } = this.props;

    // spacing
    const updateSpacing = (check) => {
      if(check){
        setAttributes({ removeSpacing: check, additionalSpacingOne: false, additionalSpacingTwo: false});
      } else {
        setAttributes({ removeSpacing: check });
      }
    }
    const updateAdditionalSpacingOne = (check) => {
      if(check){
        setAttributes({ removeSpacing: false, additionalSpacingOne: check, additionalSpacingTwo: false});
      } else {
        setAttributes({ additionalSpacingOne: check });
      }
    }
    const updateAdditionalSpacingTwo = (check) => {
      if(check){
        setAttributes({ removeSpacing: false, additionalSpacingOne: false, additionalSpacingTwo: check});
      } else {
        setAttributes({ additionalSpacingTwo: check });
      }
    }


    /* get saved configurator settings
    /------------------------*/
    var dsgvoActive = false;
    var videoBlock = false;
    if (this.props.name === "core/embed" || this.props.name === "templates/vimeo") {
      videoBlock = true;
    }
    let cookieOptions = [
      {value: '', label: '-'},
      {value: 'cookielawinfo-checkbox-analytics', label: 'Analytics'},
      {value: 'cookielawinfo-checkbox-functional', label: 'Functional'},
      {value: 'cookielawinfo-checkbox-advertisement', label: 'Marketing'},
      {value: 'cookielawinfo-checkbox-performance', label: 'Performance'},
      {value: 'cookielawinfo-checkbox-thirdparty', label: 'Thirdparty'}
    ];
    if(configurations){
      if(configurations["dsgvo"]){
        if(configurations["dsgvo"]["activate"] && configurations["dsgvo"]["activate"] == "1"){
          dsgvoActive = true;
          if(configurations["dsgvo"]["addRules"]){
            Array.from(configurations["dsgvo"]["addRules"]).forEach(function(rule) {
              cookieOptions.push( { value: rule["cssClass"], label: rule["cookieName"] } );
            });
          }
        }
      }
    }


    /* get image attributes
    /------------------------*/
    function getImageInformation(image, target){
      if(image && target == 'source_url'){
        return image.source_url;
      } else if (image && target == 'width') {
        return image.media_details.width;
      } else if (image && target == 'height') {
        return image.media_details.height;
      }
    }

    /* dsgvo image
    /------------------------*/
    const onUpdateDsgvoImage = ( image ) => {
      setAttributes( {
        dsgvoImgId: image.id,
        dsgvoImageURL: image.url
      } );
    };


    /* remove dsgvo image
    /------------------------*/
    const removeDsgvoMedia = () => {
      setAttributes( {
          dsgvoImgId: undefined,
          dsgvoImageURL: undefined
      } );
    };

    return (
      <InspectorControls>
          <PanelBody title={ __( 'Visibility', 'devTheme' ) } initialOpen={ false } >
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
              <PanelBody title={ __( 'Spacing', 'devTheme' ) } initialOpen={ false } >
                  <PanelRow>
                    <ToggleControl
                        id="no-margin"
                        label={ __( 'Remove bottom margin', 'devTheme' ) }
                        checked={ removeSpacing }
                        onChange={updateSpacing}
                    />
                  </PanelRow>
                  <PanelRow>
                    <ToggleControl
                        id="additional-spacing-one"
                        label={ __( 'Override bottom margin 1', 'devTheme' ) }
                        checked={ additionalSpacingOne }
                        onChange={updateAdditionalSpacingOne}
                    />
                  </PanelRow>
                  <PanelRow>
                    <ToggleControl
                        id="additional-spacing-two"
                        label={ __( 'Override bottom margin 2', 'devTheme' ) }
                        checked={ additionalSpacingTwo }
                        onChange={updateAdditionalSpacingTwo}
                    />
                  </PanelRow>
                  <PanelRow>
                    <ToggleControl
                        id="additional-spacing-sides"
                        label={ __( 'Side padding', 'devTheme' ) }
                        checked={ sideSpacing }
                        onChange={sideSpacing => setAttributes({ sideSpacing })}
                    />
                  </PanelRow>
              </PanelBody>
          <PanelBody title={ __( 'Schedule', 'devTheme' ) } initialOpen={ false } >
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
          {dsgvoActive &&
            <PanelBody title={ __( 'DSGVO', 'devTheme' ) } initialOpen={ false } >
              {! videoBlock &&
                <PanelRow>
                  <SelectControl
                    label={__("Select cookie", "devTheme")}
                    value={dsgvoCookie}
                    options={cookieOptions}
                    onChange={dsgvoCookie => setAttributes({ dsgvoCookie })}
                  />
                </PanelRow>
              }
              <PanelRow>
                <MediaUploadCheck>
                  <MediaUpload
                    title={ __( 'Selected image', 'devTheme' ) }
                    onSelect={ onUpdateDsgvoImage }
                    value={ dsgvoImgId }
                    render={ ( { open } ) => (
                      <Button
                        className={ ! dsgvoImgId ? 'editor-post-featured-image__toggle' : 'editor-post-featured-image__preview' }
                        onClick={ open }>
                          { ! dsgvoImgId && ( __( 'Set placeholder image', 'devTheme' ) ) }
                          { !! dsgvoImgId && dsgvoImageURL == '' && <Spinner /> }
                          { dsgvoImgId && dsgvoImageURL !== '' &&
                            <ResponsiveWrapper
                              naturalWidth={ getImageInformation(select( 'core' ).getMedia( dsgvoImgId ), "width") }
                              naturalHeight={ getImageInformation(select( 'core' ).getMedia( dsgvoImgId ), "height") }
                            >
                              <img src={ dsgvoImageURL } alt={ __( 'Placeholder image', 'devTheme' ) } />
                            </ResponsiveWrapper>
                          }
                      </Button>
                    ) }
                  />
                </MediaUploadCheck>
                {dsgvoImgId && dsgvoImgId != 0 &&
                  <MediaUploadCheck>
                    <Button onClick={removeDsgvoMedia} isLink isDestructive>{__('Remove selected image', 'devTheme')}</Button>
                  </MediaUploadCheck>
                }
              </PanelRow>
            </PanelBody>
          }
      </InspectorControls>
    );
  }
}
