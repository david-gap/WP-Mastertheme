
/*==================================================================================
  SETTINGS
==================================================================================*/

  /* import needed files and constant
  /------------------------*/

  const { __ } = wp.i18n;
  const { addFilter } = wp.hooks;
  const { Component, Fragment, useState } = wp.element;
  const { createHigherOrderComponent, withState, compose } = wp.compose;
  const { select, withSelect, setState, useSelect, withDispatch, useDispatch, dispatch } = wp.data;
  const {
    ColorPalette,
    PanelColorSettings,
    ContrastChecker
  } = wp.editor;
  const { InspectorControls, MediaUpload, MediaUploadCheck } = wp.blockEditor;

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



/*==================================================================================
  VARIABLES
==================================================================================*/

  /* options
  /------------------------*/
  const thumbOptions = [
    { value: "detailpage", label: __( 'Detail page', 'devTheme' ) },
    { value: "searchresults", label: __( 'Search results', 'devTheme' ) },
    { value: "archive", label: __( 'Archive', 'devTheme' ) },
    { value: "postsblock", label: __( 'Posts block', 'devTheme' ) },
    { value: "postsfilterblock", label: __( 'Posts filter block', 'devTheme' ) }
  ]



/*==================================================================================
  FUNCTIONS
==================================================================================*/

  /* get media attributes
  /------------------------*/
  function getMediaInformation(media, target){
    if(media && target == 'source_url'){
      return media.source_url;
    } else if (media && target == 'url') {
      return media.media_details.url;
    } else if (media && target == 'width') {
      return media.media_details.width;
    } else if (media && target == 'height') {
      return media.media_details.height;
    }
  }



/*==================================================================================
  BUILD OUTPUT
==================================================================================*/
  function extendPostFeaturedImage( OriginalComponent ) {
    return ( props ) => {
      /* get meta field information from the DB
      /------------------------*/
      const videoThumbOptions = useSelect(select => select('core/editor').getEditedPostAttribute('meta').template_page_videothumb_options);
      const videoId = useSelect(select => select('core/editor').getEditedPostAttribute('meta').template_page_videothumb_videoId);
      const videoUrl = useSelect(select => select('core/editor').getEditedPostAttribute('meta').template_page_videothumb_videoUrl);
      /* video selection
      /------------------------*/
      const onUpdateThumbVideo = ( video ) => {
        dispatch('core/editor').editPost({meta: {template_page_videothumb_videoId: video.id}});
        dispatch('core/editor').editPost({meta: {template_page_videothumb_videoUrl: video.url}});
      };
      /* video remove
      /------------------------*/
      const removeThumbVideo = () => {
        dispatch('core/editor').editPost({meta: {template_page_videothumb_videoId: 0}});
        dispatch('core/editor').editPost({meta: {template_page_videothumb_videoUrl: ''}});
      };
      /* video options - set
      /------------------------*/
      function checkThumbOptions(name, videoThumbOptions){
        if (videoThumbOptions && videoThumbOptions.length >= 1 && videoThumbOptions.includes(name)) {
          return true;
        } else {
          return false;
        }
      };
      /* video options - checked
      /------------------------*/
      const onchangeThumbOptions = (check) => {
        const value = window.event.target.defaultValue;
        const newSelection = [];
        // add existing selection to new selection
        if (videoThumbOptions && videoThumbOptions.length >= 1) {
          videoThumbOptions.forEach(function(element) {
              newSelection.push(element);
          });
        }
        // add/remove checked values
        if(check){
          newSelection.push(value);
        } else {
          var index = newSelection.indexOf(value);
          newSelection.splice(index, 1);
        }
        dispatch('core/editor').editPost({meta: {template_page_videothumb_options: newSelection}});
      };
      return (
        <div>
          <PanelRow>
            <OriginalComponent {...props} />
          </PanelRow>
          {configurations && configurations["template"] && configurations["template"]["page"] && configurations["template"]["page"]["videoThumb"] && configurations["template"]["page"]["videoThumb"] == "1" &&
            <div>
              <PanelRow>
                <label><br /><strong>{ __( 'Video thumb', 'devTheme' ) }</strong><br /><br /></label>
              </PanelRow>
              <PanelRow>
                <MediaUploadCheck>
                  <MediaUpload
                    onSelect={ onUpdateThumbVideo }
                    allowedTypes={ [ 'video' ] }
                    value={ videoId }
                    render={ ( { open } ) => (
                      <Button
                        className={ ! videoId ? 'editor-post-featured-image__toggle' : 'editor-post-featured-image__preview' }
                        onClick={ open }>
                          { ! videoId && ( __( 'Set video', 'devTheme' ) ) }
                          { !! videoId && videoUrl == '' && <Spinner /> }
                          { !! videoId && videoUrl !== '' &&
                            <ResponsiveWrapper
                              naturalWidth="400"
                              naturalHeight="300"
                            >
                              <video src={ videoUrl } autoplay muted playsinline></video>
                            </ResponsiveWrapper>
                          }
                      </Button>
                    ) }
                  />
                </MediaUploadCheck>
              </PanelRow>
              <PanelRow>
                {!! videoId &&
                  <MediaUploadCheck>
                    <Button onClick={removeThumbVideo} isLink isDestructive>{__('Remove video', 'devTheme')}</Button>
                  </MediaUploadCheck>
                }
              </PanelRow>
              <PanelRow>
                <div>
                  <label><br /><strong>{ __( 'Replace thumb image with video on:', 'devTheme' ) }</strong></label>
                  <ul>
                    { thumbOptions.map((options, setState) => {
                      const [ isChecked, setChecked ] = useState( false );
                      return(
                        <li>
                        <CheckboxControl
                        label={options.label}
                        key={options.value}
                        value={options.value}
                        name='template_page_videothumb_options'
                        checked={ checkThumbOptions(options.value, videoThumbOptions) }
                        onChange={ onchangeThumbOptions }
                        />
                        </li>
                      );
                    }) }
                  </ul>
                </div>
              </PanelRow>
            </div>
          }
        </div>
      );
    }
  }



/*==================================================================================
  FILTERS
==================================================================================*/

  addFilter(
    'editor.PostFeaturedImage',
    'template/wrap-post-featured-image',
    extendPostFeaturedImage
  );
