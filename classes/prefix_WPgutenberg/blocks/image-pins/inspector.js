/**
 * Internal block libraries
*/
const { __ } = wp.i18n;
const { Component, useState } = wp.element;
const { registerBlockType } = wp.blocks;
const { select, withSelect, setState } = wp.data;
const {withState} = wp.compose;
const {
  ColorPalette,
  PanelColorSettings,
  ContrastChecker,
  MediaUpload,
  MediaUploadCheck
} = wp.editor;

const {
  InspectorControls
} = wp.blockEditor;

const {
  CheckboxControl,
  FormTokenField,
  PanelBody,
  PanelRow,
  RadioControl,
  RangeControl,
  TextControl,
  TextareaControl,
  ToggleControl,
  SelectControl,
  MyFormTokenField,
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
        anchor,
        imageId,
        imageURL,
        pinsTarget,
        pinsInfo,
        pinsInfoRowOne,
        pinsInfoRowTwo,
        pinsInfoTrigger
      },
      setAttributes
    } = this.props;


    /* image selection
    /------------------------*/
    const onUpdateImage = ( image ) => {
      setAttributes( {
        imageId: image.id,
        imageURL: image.url
      } );
    };


    /* image remove
    /------------------------*/
    const removeMedia = () => {
      setAttributes( {
          imageId: undefined,
          imageURL: undefined
      } );
    };


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

    // query
    // const query = {
    //   'status': 'publish',
    //   'per_page': -1
    // };
    // const posts = select( 'core' ).getEntityRecords( 'postType', pinPostType, query );


    /* post target options
    /------------------------*/
    let pinsTargetOptions = [
      { value: "self", label: __( 'Inside block', 'devTheme' ) },
      { value: "link", label: __( 'Link', 'devTheme' ) },
      { value: "window", label: __( 'Link to new window', 'devTheme' ) }
    ];


    /* opin info options
    /------------------------*/
    let pinsInfoOptions = [
      { value: "", label: __( 'No Infobox', 'devTheme' ) },
      { value: "click", label: __( 'On click', 'devTheme' ) },
      { value: "hover", label: __( 'On hover', 'devTheme' ) }
    ];


    /* pin info
    /------------------------*/
    let pinRowOptions = [
      { value: "", label: "-" },
      { value: "title", label: __( 'Title', 'devTheme' ) },
      { value: "date", label: __( 'Date', 'devTheme' ) },
      { value: "excerpt", label: __( 'Excerpt', 'devTheme' ) },
      { value: "template", label: __( 'Post template', 'devTheme' ) },
      { value: "templateMedia", label: __( 'Post template (media only)', 'devTheme' ) }
    ];
    // if(posts && posts.length > 0){
    //   if(posts[0].meta !== undefined){
    //     Object.entries(posts[0].meta).forEach(([key, value]) => {
    //       pinRowOptions.push( { value: key, label: "Meta: " + key } );
    //     });
    //   }
    //   if(posts[0]._links["wp:term"] !== undefined){
    //     const terms = posts[0]._links["wp:term"];
    //     Object.entries(terms).forEach(([key, value]) => {
    //       if(value.taxonomy == "post_tag"){
    //         pinRowOptions.push( { value: 'tax__post_tag', label: "Taxonomy: Tags" } );
    //       } else {
    //         pinRowOptions.push( { value: 'tax__' + value.taxonomy, label: "Taxonomy: " + value.taxonomy } );
    //       }
    //     });
    //   }
    // }


    /* load content triggers
    /------------------------*/
    // select options
    const postOptions = [
      { value: "link_pin", label: __( 'Link pin', 'devTheme' ) },
      { value: "link_box", label: __( 'Link Info window', 'devTheme' ) },
      { value: "link_row1", label: __( 'Link row 1', 'devTheme' ) },
      { value: "link_row2", label: __( 'Link row 2', 'devTheme' ) }
    ];
    // check checked
    function checkPinTrigger(name){
      if (pinsInfoTrigger && pinsInfoTrigger.length >= 1 && pinsInfoTrigger.includes(name)) {
        return true;
      } else {
        return false;
      }
    };
    // on change
    const onchangePinTrigger = (check) => {
      const value = window.event.target.defaultValue;
      const newSelection = [];
      if (pinsInfoTrigger && pinsInfoTrigger.length >= 1) {
        pinsInfoTrigger.forEach(function(element) {
            newSelection.push(element);
        });
      }
      if(check){
        newSelection.push(value);
      } else {
        var index = newSelection.indexOf(value);
        newSelection.splice(index, 1);
      }
      setAttributes({ pinsInfoTrigger: newSelection });
    };



    return (
      <InspectorControls>
          <PanelBody title={ __( 'Image', 'devTheme' ) } >
            <MediaUploadCheck>
              <MediaUpload
                title={ __( 'Background image', 'devTheme' ) }
                onSelect={ onUpdateImage }
                value={ imageId }
                render={ ( { open } ) => (
                  <Button
                    className={ ! imageId ? 'editor-post-featured-image__toggle' : 'editor-post-featured-image__preview' }
                    onClick={ open }>
                      { ! imageId && ( __( 'Set background image', 'devTheme' ) ) }
                      { !! imageId && imageURL == '' && <Spinner /> }
                      { imageId && imageURL !== '' &&
                        <ResponsiveWrapper
                          naturalWidth={ getImageInformation(select( 'core' ).getMedia( imageId ), "width") }
                          naturalHeight={ getImageInformation(select( 'core' ).getMedia( imageId ), "height") }
                        >
                          <img src={ imageURL } alt={ __( 'Background image', 'devTheme' ) } />
                        </ResponsiveWrapper>
                      }
                  </Button>
                ) }
              />
            </MediaUploadCheck>
            {imageId && imageId != 0 &&
              <MediaUploadCheck>
                <Button onClick={removeMedia} isLink isDestructive>{__('Remove image', 'devTheme')}</Button>
              </MediaUploadCheck>
            }
          </PanelBody>
          <PanelBody title={ __( 'Pins settings', 'devTheme' ) } >
            <PanelRow>
              <SelectControl
                label={__("Value target", "devTheme")}
                value={pinsTarget}
                options={pinsTargetOptions}
                onChange={pinsTarget => setAttributes({ pinsTarget })}
              />
            </PanelRow>
            <PanelRow>
              <SelectControl
                label={__("Pin info", "devTheme")}
                value={pinsInfo}
                options={pinsInfoOptions}
                onChange={pinsInfo => setAttributes({ pinsInfo })}
              />
            </PanelRow>
            <PanelRow>
              <SelectControl
                label={__("Pin Info text row 1", "devTheme")}
                value={pinsInfoRowOne}
                options={pinRowOptions}
                onChange={pinsInfoRowOne => setAttributes({ pinsInfoRowOne })}
              />
            </PanelRow>
            <PanelRow>
              <SelectControl
                label={__("Pin Info text row 2", "devTheme")}
                value={pinsInfoRowTwo}
                options={pinRowOptions}
                onChange={pinsInfoRowTwo => setAttributes({ pinsInfoRowTwo })}
              />
            </PanelRow>
            <PanelRow>
              <div>
                <label><strong>{ __( 'Trigger content load by', 'devTheme' ) }</strong></label>
                  <ul>
                { postOptions.map(
                  (options, setState) => {
                  return(
                    <li>
                      <CheckboxControl
                        label={options.label}
                        key={options.value}
                        value={options.value}
                        name='getPinTriggers[]'
                        checked={ checkPinTrigger(options.value) }
                        onChange={ onchangePinTrigger }
                      />
                    </li>
                  );
                }) }
                </ul>
              </div>
            </PanelRow>
          </PanelBody>
      </InspectorControls>
    );
  }
}
