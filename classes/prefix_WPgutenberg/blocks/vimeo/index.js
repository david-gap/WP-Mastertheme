
/*==================================================================================
  SETTINGS
==================================================================================*/

  /* import needed files and constant
  /------------------------*/
  import classnames from 'classnames';
  import attributes from "./attributes";
  import Inspector from "./inspector";

  const { __ } = wp.i18n;
  const { registerBlockType } = wp.blocks;
  const { RichText } = wp.editor;
  const { InnerBlocks } = wp.blockEditor;


  /* atts changed from attributes, see below
  /------------------------*/
  function getSettings(atts) {
    let settings = [];
    // The following code sorts the list alphabetically
    let attributes = {};
    Object.keys(atts)
      .sort()
      .forEach(function(key) {
        attributes[key] = atts[key];
      });
    // End updated code
    for (let attribute in attributes) {
      let value = attributes[attribute];
      if ("boolean" === typeof attributes[attribute]) {
        value = value.toString();
      }
      settings.push(
        <li>
          {attribute}: {value}
        </li>
      );
    }
    return settings;
  }



/*==================================================================================
  CONTENT BUILDING
==================================================================================*/

  /* video url
  /------------------------*/
  function getURL(atts){
    // default config
    let autoplay = atts["videoAutoPlay"] === true && atts["posterVideoID"] == '' ? "1" : "0";
    let loop = atts["videoLoop"] === true ? "1" : "0";
    let mute = atts["videoMute"] === true ? "1" : "0";
    let background = atts["videoBackgroud"] === true ? "1" : "0";
    // final url
    let videoURL = 'https://player.vimeo.com/video/' + atts["videoID"] + '?autoplay=' + autoplay + '&loop=' + loop + '&muted=' + mute + '&background=' + background + '&autopause=false';
    return videoURL;
  }


  /* preview video url
  /------------------------*/
  function getPreviewURL(atts){
    let previewVideoURL = 'https://player.vimeo.com/video/' + atts["posterVideoID"] + '?autoplay=1&loop=1&muted=1&background=1&autopause=false';
    return previewVideoURL;
  }


  /* link
  /------------------------*/
  function getVideoLink(atts){
    let buildlink = [];
    if(atts["videoBackgroud"] === true && atts["videoLink"]){
      buildlink.push(
        <a href={atts.videoLink} target={atts.videoLinkTarget} rel="noopener">&nbsp;</a>
      );
    }
    return buildlink;
  }


  /* table of content
  /------------------------*/
  function getTableOfContent(atts){
    if(atts["videoTableOfContent"] === true){
      let table = [],
          css = "table-of-content",
          toggleContainer = 'arrow-toggle',
          autoplay = atts["videoTOCautoplay"] === true ? "1" : "0",
          stop = atts["videoTOCstop"] === true ? "1" : "0";
      // define position
      if(atts["videoTOCposition"]){
        toggleContainer += ' position-' + atts["videoTOCposition"];
        css += ' position-' + atts["videoTOCposition"];
      }
      // build
      if(atts["videoTOCtoggle"] && atts["videoTOCtoggle"] === true){
        table.push(
          <div class={toggleContainer}>
            <span class="label"><svg width="15.135" height="11.064" viewBox="0 0 15.135 11.064"><g transform="translate(-331.529 -434.15)"><g><line y1="1.05" x2="9" transform="matrix(-0.574, -0.819, 0.819, -0.574, 338.236, 443.67)" fill="none" stroke="#000" stroke-linecap="round" stroke-width="2"></line><line x2="9" y2="1.05" transform="matrix(0.574, -0.819, 0.819, 0.574, 339.096, 443.068)" fill="none" stroke="#000" stroke-linecap="round" stroke-width="2"></line></g></g></svg></span>
            <div class={css} data-autoplay={autoplay} data-stop={stop}>
            </div>
          </div>
        );
      } else {
        table.push(
          <div class={css} data-autoplay={autoplay} data-stop={stop}>
          </div>
        );
      }
      return table;
    }
  }

  /* video dimention
  /------------------------*/
  function getDimension(atts){
    let math = 100 / atts["videoDimensionX"] * atts["videoDimensionY"];
    let dimention = math + '%';
    return dimention;
  }



/*==================================================================================
  REGISTER BLOCK
==================================================================================*/

  /* register
  /------------------------*/
  export default registerBlockType( 'templates/vimeo', {
    title: __( 'Extended Vimeo', 'devTheme' ),
    description: __( 'Insert vimeo video and configurate the output', 'devTheme' ),
    category: 'media',
    icon: 'video-alt3',
    keywords: [
      __( 'video', 'devTheme' ),
      __( 'vimeo', 'devTheme' )
    ],
    supports: {
      html: false,                // Remove support for an HTML mode
      anchor: true,               // Declare support for anchor links
      customClassName: true,      // Remove the support for the custom className
      className: false,           // Remove the support for the generated className
      align: true,                // Declare support for block's alignment
      alignWide: true,            // Remove the support for wide alignment
      defaultStylePicker: false,  // Remove the Default Style picker
      inserter: true,             // Hide this block from the inserter
      multiple: true,             // Use the block just once per post
      reusable: true              // Don't allow the block to be converted into a reusable block
  	},
    attributes,
    edit: props => {
      const {
        attributes: { videoID, posterVideoID, videoDimensionX, videoDimensionY, videoAutoPlay, videoBackgroud, videoLoop, videoMute, videoTableOfContent, videoTOCtoggle, videoTOCposition, videoTOCautoplay, videoTOCstop, videoLink, videoLinkTarget },
        attributes,
        className,
        setAttributes
      } = props;

      let settings = getSettings(attributes);
      let videoURL = getURL(attributes);
      let previewVideoURL = getPreviewURL(attributes);
      let videoDimension = getDimension(attributes);
      let videoTOC = getTableOfContent(attributes);
      let videoLinkContainer = getVideoLink(attributes);

      return [
        <Inspector {...{ setAttributes, ...props }} />,
        <div className={classnames(
          'block-vimeo'
        )}>
          {videoLinkContainer}
          {attributes.posterVideoID > 0 && (
            <div class="video-container video-preview">
              <div style={{paddingTop: videoDimension}} className={classnames(
                'resp_video',
              )}>
                <iframe src={previewVideoURL} frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
              </div>
            </div>
          )}
          {videoTOC}
          <div class="video-container">
            <div style={{paddingTop: videoDimension}} className={classnames(
              'resp_video',
            )}>
              {
                // <ul>{settings}</ul>
              }
              <iframe src={videoURL} frameborder="0" class="vimeo-video" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
            </div>
            {attributes.videoBackgroud > 0 && (
              <div class="video-cover">
                <InnerBlocks />
              </div>
            )}
          </div>
        </div>
      ];
    },
    save: props => {
      const {
        attributes: { videoID, posterVideoID, videoDimensionX, videoDimensionY, videoAutoPlay, videoBackgroud, videoLoop, videoMute, videoTableOfContent, videoTOCtoggle, videoTOCposition, videoTOCautoplay, videoTOCstop, videoLink, videoLinkTarget },
        attributes
      } = props;

      let videoURL = getURL(attributes);
      let previewVideoURL = getPreviewURL(attributes);
      let videoDimension = getDimension(attributes);
      let videoTOC = getTableOfContent(attributes);
      let videoLinkContainer = getVideoLink(attributes);

      return (
        <div className={classnames(
          'block-vimeo'
        )} data-autoplay={attributes.videoAutoPlay}>
          {videoLinkContainer}
          {attributes.posterVideoID > 0 && (
            <div class="video-container video-preview">
              <div style={{paddingTop: videoDimension}} className={classnames(
                'resp_video',
              )}>
                <iframe src={previewVideoURL} frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
              </div>
            </div>
          )}
          {videoTOC}
          <div class="video-container">
            <div style={{paddingTop: videoDimension}} className={classnames(
              'resp_video',
            )}>
              {
                // <ul>{settings}</ul>
              }
              <iframe src={videoURL} frameborder="0" class="vimeo-video" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
            </div>
            {attributes.videoBackgroud > 0 && (
              <div class="video-cover">
                <InnerBlocks.Content />
              </div>
            )}
          </div>
        </div>
      );
    }
  });
