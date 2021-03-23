/**
 * Internal block libraries
*/
import classnames from 'classnames';
import attributes from "./attributes";
import Inspector from "./inspector";

const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const { RichText } = wp.editor;

// Note: atts changed from attributes, see below
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

// geneeate video url
function getURL(atts){
  let autoplay = atts["videoAutoPlay"] === true ? "1" : "0";
  let loop = atts["videoLoop"] === true ? "1" : "0";
  let background = atts["videoBackgroud"] === true ? "1" : "0";
  let videoURL = 'https://player.vimeo.com/video/' + atts["videoID"] + '?autoplay=' + autoplay + '&loop=' + loop + '&background=' + background;
  return videoURL;
}

// geneeate video dimention
function getDimention(atts){
  let math = 100 / atts["videoDimentionX"] * atts["videoDimentionY"];
  let dimention = math + '%';
  return dimention;
}

export default registerBlockType( 'templates/vimeo', {
  title: __( 'Vimeo', 'WPgutenberg' ),
  description: __( 'Insert vimeo video and configurate the output', 'WPgutenberg' ),
  category: 'media',
  icon: 'video-alt3',
  keywords: [
    __( 'video', 'WPgutenberg' ),
    __( 'vimeo', 'WPgutenberg' )
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
      attributes: { videoID, videoDimentionX, videoDimentionY, videoAutoPlay, videoBackgroud, videoLoop },
      attributes,
      className,
      setAttributes
    } = props;

    let settings = getSettings(attributes);
    let videoURL = getURL(attributes);
    let videoDimention = getDimention(attributes);

    return [
      <Inspector {...{ setAttributes, ...props }} />,
      <div className={classnames(
        'block-vimeo'
      )}>
        <div style={{paddingTop: videoDimention}} className={classnames(
          'resp_video',
        )}>
          {
            // <ul>{settings}</ul>
          }
          <iframe src={videoURL} frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
          <script src="https://player.vimeo.com/api/player.js"></script>
        </div>
      </div>
    ];
  },
  save: props => {
    const {
      attributes: { videoID, videoDimentionX, videoDimentionY, videoAutoPlay, videoBackgroud, videoLoop },
      attributes
    } = props;

    let videoURL = getURL(attributes);
    let videoDimention = getDimention(attributes);

    return (
      <div className={classnames(
        'block-vimeo'
      )}>
        <div style={{paddingTop: videoDimention}} className={classnames(
          'resp_video',
        )}>
          {
            // <ul>{settings}</ul>
          }
          <iframe src={videoURL} frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
          <script src="https://player.vimeo.com/api/player.js"></script>
        </div>
      </div>
    );
  }
	// save: props => {
	// 	// const { videoID, videoAutoPlay, videoLoop, videoDimentionX, videoDimentionY } = props.attributes;
	// 	return (
	// 		<div>
	// 		</div>
	// 	);
	// }

});
