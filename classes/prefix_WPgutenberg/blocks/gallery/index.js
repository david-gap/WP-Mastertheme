
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

  const ALLOWED_BLOCKS = [ 'templates/gallery-item' ];
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



/*==================================================================================
REGISTER BLOCK
==================================================================================*/

  /* register
  /------------------------*/
  export default registerBlockType( 'templates/gallery', {
    title: __( 'Swiper Gallery', 'devTheme' ),
    description: __( 'Insert a image gallery', 'devTheme' ),
    category: 'media',
    icon: 'format-gallery',
    keywords: [
      __( 'Gallery', 'devTheme' ),
      __( 'Images', 'devTheme' )
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
        attributes: {},
        attributes,
        className,
        setAttributes
      } = props;

      let settings = getSettings(attributes);

      return [
        <Inspector {...{ setAttributes, ...props }} />,
        <div className={classnames(
          'gallery-block gallery-swiper', className
        )}>
          <ul>
            <InnerBlocks
              allowedBlocks={ ALLOWED_BLOCKS }
            />
          </ul>
        </div>
      ];
    },
    save: props => {
      const {
        attributes: {},
        attributes
      } = props;

      return (
        <div className={classnames(
          'gallery-block gallery-swiper'
        )}>
          <ul>
            <InnerBlocks.Content />
          </ul>
        </div>
      );
    }

  });
