
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
  const { select, withSelect } = wp.data;

  const ALLOWED_BLOCKS = [ 'templates/image-pins-item', 'core/buttons' ];
  // const getCount = memoize( ( count ) => {
  // 	return times( count, () => [ 'templates/accordion-item' ] );
  // } );


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


  /* Get the selected image
  /------------------------*/
  function getImage(id, media){
    if(media){
      let themedia = media;
      return (
        <img src={themedia} data-id={ id } width="100%" />
      );
    } else {
      return (
        <div class="placeholder">
          {__( 'Select Image', 'devTheme' )}
        </div>
      );
    }
  }



/*==================================================================================
REGISTER BLOCK
==================================================================================*/

  /* register
  /------------------------*/
  export default registerBlockType( 'templates/image-pins', {
    title: __( 'Image Pins', 'devTheme' ),
    description: __( 'Image Pins', 'devTheme' ),
    category: 'media',
    icon: 'embed-post',
    keywords: [
      __( 'Image', 'devTheme' ),
      __( 'Posts', 'devTheme' ),
      __( 'Pins', 'devTheme' )
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
        attributes: { anchor, imageId, imageURL, pinsTarget, pinsInfo, pinsInfoRowOne, pinsInfoRowTwo, pinsInfoTrigger },
        attributes,
        className,
        setAttributes
      } = props;

      let settings = getSettings(attributes);
      let returnImage = getImage(imageId, imageURL);

      return [
        <Inspector {...{ setAttributes, ...props }} />,
        <div className={classnames(
          'block-image-pins', className
        )}>
          <figure>
            {returnImage}
            <div class="pins">
              <InnerBlocks
                allowedBlocks={ ALLOWED_BLOCKS }
              />
            </div>
          </figure>
          <div class="wp-block-group pin-target dn"><div class="wp-block-group__inner-container"></div></div>
        </div>
      ];
    },
    save: props => {
      const {
        attributes: { anchor, imageId, imageURL, pinsTarget, pinsInfo, pinsInfoRowOne, pinsInfoRowTwo, pinsInfoTrigger },
        className,
        attributes
      } = props;

      let settings = getSettings(attributes);
      let returnImage = getImage(imageId, imageURL);

      return (
        <div className={classnames(
          'block-image-pins'
        )}>
          <figure>
            {returnImage}
            <div class="pins">
              <InnerBlocks.Content />
            </div>
          </figure>
          <div class="wp-block-group pin-target dn"><div class="wp-block-group__inner-container"></div></div>
        </div>
      );
    }

  });
