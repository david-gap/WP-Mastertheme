
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
REGISTER BLOCK
==================================================================================*/

  /* register
  /------------------------*/
  export default registerBlockType( 'templates/gallery-item', {
    title: __( 'Swiper Item', 'devTheme' ),
    description: __( 'Insert a gallery item', 'devTheme' ),
    category: 'media',
    icon: 'format-image',
    keywords: [
      __( 'Swiper item', 'devTheme' ),
      __( 'Images', 'devTheme' ),
      __( 'Item', 'devTheme' )
    ],
    parent: [ 'templates/gallery' ],
    supports: {
      html: false,                // Remove support for an HTML mode
      anchor: true,               // Declare support for anchor links
      customClassName: true,      // Remove the support for the custom className
      className: false,           // Remove the support for the generated className
      align: false,                // Declare support for block's alignment
      alignWide: false,            // Remove the support for wide alignment
      defaultStylePicker: false,  // Remove the Default Style picker
      inserter: true,             // Hide this block from the inserter
      multiple: true,             // Use the block just once per post
      reusable: true              // Don't allow the block to be converted into a reusable block
  	},
    attributes,
    edit: props => {
      const {
        attributes: {},
        attributes,
        className,
        setAttributes
      } = props;

      let settings = getSettings(attributes);

      const MY_TEMPLATE = [
          [ 'core/image', {} ]
      ];

      return [
        <Inspector {...{ setAttributes, ...props }} />,
        <li className={classnames(
          'gallery-item', className
        )}>
          <InnerBlocks
            template={ MY_TEMPLATE }
          />
        </li>
      ];
    },
    save: props => {
      const {
        attributes: {},
        attributes
      } = props;

      return (
        <li className={classnames(
          'gallery-item'
        )}>
          <InnerBlocks.Content />
        </li>
      );
    }

  });
