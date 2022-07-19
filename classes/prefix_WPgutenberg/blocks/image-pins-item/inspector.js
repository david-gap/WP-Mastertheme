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
  FocalPointPicker,
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
        pinPostion,
        pinImgId,
        pinImageURL,
        pinPostType,
        pinPostId,
        pinTarget,
        pinInfo,
        pinInfoRowOne,
        pinInfoRowTwo,
        pinInfoTrigger,
        parentAttributes
      },
      setAttributes
    } = this.props;

    // parent attributes
    const parentClientId = select( 'core/block-editor' ).getBlockHierarchyRootClientId( this.props.clientId );
    const getParentAttributes = select('core/block-editor').getBlockAttributes( parentClientId );
    setAttributes({
      parentAttributes: getParentAttributes
    });

    // query
    const query = {
      'status': 'publish',
      'per_page': -1
    };
    const posts = select( 'core' ).getEntityRecords( 'postType', pinPostType, query );
    const img = select( 'core' ).getMedia(getParentAttributes.imageId);


    /* pin image selection
    /------------------------*/
    const onUpdatePinImage = ( image ) => {
      setAttributes( {
        pinImgId: image.id,
        pinImageURL: image.url
      } );
    };


    /* image remove
    /------------------------*/
    const removePinMedia = () => {
      setAttributes( {
          pinImgId: undefined,
          pinImageURL: undefined
      } );
    };


    /* post target options
    /------------------------*/
    let pinTargetOptions = [
      { value: "heritage", label: __( 'Heritage from parent', 'devTheme' ) },
      { value: "", label: __( '-', 'devTheme' ) },
      { value: "self", label: __( 'Inside block', 'devTheme' ) },
      { value: "link", label: __( 'Link', 'devTheme' ) },
      { value: "window", label: __( 'Link to new window', 'devTheme' ) }
    ];


    /* opin info options
    /------------------------*/
    let pinInfoOptions = [
      { value: "heritage", label: __( 'Heritage from parent', 'devTheme' ) },
      { value: "", label: __( 'No Infobox', 'devTheme' ) },
      { value: "click", label: __( 'On click', 'devTheme' ) },
      { value: "hover", label: __( 'On hover', 'devTheme' ) }
    ];


    /* pin info
    /------------------------*/
    let pinRowOptions = [
      { value: "heritage", label: __( 'Heritage from parent', 'devTheme' ) },
      { value: "", label: "-" },
      { value: "title", label: __( 'Title', 'devTheme' ) },
      { value: "date", label: __( 'Date', 'devTheme' ) },
      { value: "excerpt", label: __( 'Excerpt', 'devTheme' ) },
      { value: "template", label: __( 'Post template', 'devTheme' ) },
      { value: "templateMedia", label: __( 'Post template (media only)', 'devTheme' ) }
    ];
    if(posts && posts.length > 0){
      if(posts[0].meta !== undefined){
        Object.entries(posts[0].meta).forEach(([key, value]) => {
          pinRowOptions.push( { value: key, label: "Meta: " + key } );
        });
      }
      if(posts[0]._links["wp:term"] !== undefined){
        const terms = posts[0]._links["wp:term"];
        Object.entries(terms).forEach(([key, value]) => {
          if(value.taxonomy == "post_tag"){
            pinRowOptions.push( { value: 'tax__post_tag', label: "Taxonomy: Tags" } );
          } else {
            pinRowOptions.push( { value: 'tax__' + value.taxonomy, label: "Taxonomy: " + value.taxonomy } );
          }
        });
      }
    }


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
      if (pinInfoTrigger && pinInfoTrigger.length >= 1 && pinInfoTrigger.includes(name)) {
        return true;
      } else {
        return false;
      }
    };
    // on change
    const onchangePinTrigger = (check) => {
      const value = window.event.target.defaultValue;
      const newSelection = [];
      if (pinInfoTrigger && pinInfoTrigger.length >= 1) {
        pinInfoTrigger.forEach(function(element) {
            newSelection.push(element);
        });
      }
      if(check){
        newSelection.push(value);
      } else {
        var index = newSelection.indexOf(value);
        newSelection.splice(index, 1);
      }
      setAttributes({ pinInfoTrigger: newSelection });
    };


    /* update post type selection options
    /------------------------*/
    let pinPostTypeOptions = [];
    const getposttypes = select('core').getPostTypes({ per_page: -1 });
    if(getposttypes){
      getposttypes.forEach( type => {
        if(type.slug !== "wp_block"){
          pinPostTypeOptions.push( { value: type.slug, label: type.labels.name } );
        }
      });
    }


    /* post id
    /------------------------*/
    // post id selection
    let postNames = [];
    let postsFieldValue = [];
    if ( posts !== null ) {
      postNames = posts.map( ( post ) => post.title.raw );
      if(pinPostId){
        postsFieldValue = pinPostId.map( ( pinPostId ) => {
          let wantedPost = posts.find( ( post ) => {
            return post.id === pinPostId;
          } );
          if ( wantedPost === undefined || ! wantedPost ) {
            return false;
          }
          return wantedPost.title.raw;
        } );
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


    /* focal point
    /------------------------*/
    let dimensions = {
      width: getImageInformation(img, "width"),
      height: getImageInformation(img, "height"),
    };



    return (
      <InspectorControls>
          <PanelBody title={ __( 'Pin position', 'devTheme' ) } >
            <PanelRow>
              <FocalPointPicker
                value={ pinPostion }
                dimensions={ dimensions }
                url={ getParentAttributes.imageURL }
                onChange={ ( pinPos ) => {
                  setAttributes({ pinPostion: pinPos });
                } }
              />
            </PanelRow>
          </PanelBody>
          <PanelBody title={ __( 'Pin image', 'devTheme' ) } >
            <PanelRow>
              <MediaUploadCheck>
                <MediaUpload
                  title={ __( 'Pin image', 'devTheme' ) }
                  onSelect={ onUpdatePinImage }
                  value={ pinImgId }
                  render={ ( { open } ) => (
                    <Button
                      className={ ! pinImgId ? 'editor-post-featured-image__toggle' : 'editor-post-featured-image__preview' }
                      onClick={ open }>
                        { ! pinImgId && ( __( 'Set pin image', 'devTheme' ) ) }
                        { !! pinImgId && pinImageURL == '' && <Spinner /> }
                        { pinImgId && pinImageURL !== '' &&
                          <ResponsiveWrapper
                            naturalWidth={ getImageInformation(select( 'core' ).getMedia( pinImgId ), "width") }
                            naturalHeight={ getImageInformation(select( 'core' ).getMedia( pinImgId ), "height") }
                          >
                            <img src={ pinImageURL } alt={ __( 'Pin image', 'devTheme' ) } />
                          </ResponsiveWrapper>
                        }
                    </Button>
                  ) }
                />
              </MediaUploadCheck>
              {pinImgId && pinImgId != 0 &&
                <MediaUploadCheck>
                  <Button onClick={removePinMedia} isLink isDestructive>{__('Remove pin image', 'devTheme')}</Button>
                </MediaUploadCheck>
              }
            </PanelRow>
            <PanelRow>
              {__("Image size is 50% of its size", "devTheme")}
            </PanelRow>
          </PanelBody>
          <PanelBody title={ __( 'Pin query', 'devTheme' ) } >
            <PanelRow>
              <SelectControl
                label={__("Post type", "devTheme")}
                value={pinPostType}
                options={pinPostTypeOptions}
                onChange={pinPostType => setAttributes({ pinPostType })}
              />
            </PanelRow>
            <PanelRow>
              <FormTokenField
                label={__("Select post", "devTheme")}
                value={ postsFieldValue }
                maxLength={ 1 }
                suggestions={ postNames }
                maxSuggestions={ 20 }
                onChange={ ( pinPostId ) => {
                  // Build array of selected posts.
                  let pinPostIdArray = [];
                  pinPostId.map(
                    ( postName ) => {
                      const matchingPost = posts.find( ( post ) => {
                        return post.title.raw === postName;
                      } );
                      if ( matchingPost !== undefined ) {
                        pinPostIdArray.push( matchingPost.id );
                      }
                    }
                  )
                  setAttributes( { pinPostId: pinPostIdArray } );
                } }
              />
            </PanelRow>
          </PanelBody>
          <PanelBody title={ __( 'Override pins settings', 'devTheme' ) } initialOpen={ false } >
            <PanelRow>
              <SelectControl
                label={__("Value target", "devTheme")}
                value={pinTarget}
                options={pinTargetOptions}
                onChange={pinTarget => setAttributes({ pinTarget })}
              />
            </PanelRow>
            <PanelRow>
              <SelectControl
                label={__("Pin info", "devTheme")}
                value={pinInfo}
                options={pinInfoOptions}
                onChange={pinInfo => setAttributes({ pinInfo })}
              />
            </PanelRow>
            <PanelRow>
              <SelectControl
                label={__("Pin Info text row 1", "devTheme")}
                value={pinInfoRowOne}
                options={pinRowOptions}
                onChange={pinInfoRowOne => setAttributes({ pinInfoRowOne })}
              />
            </PanelRow>
            <PanelRow>
              <SelectControl
                label={__("Pin Info text row 2", "devTheme")}
                value={pinInfoRowTwo}
                options={pinRowOptions}
                onChange={pinInfoRowTwo => setAttributes({ pinInfoRowTwo })}
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
