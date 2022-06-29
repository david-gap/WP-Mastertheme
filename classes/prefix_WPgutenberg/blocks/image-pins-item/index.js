
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
  const { RichText, InnerBlocks } = wp.editor;
  const { Draggable} = wp.components;
  const { select, withSelect } = wp.data;



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


  /* pin image
  /------------------------*/
  function getPinImage(id, url, object){
    if(object.hasOwnProperty(id) && object[id] !== undefined && object[id].hasOwnProperty("media_details")){
      let maxWidth = object[id].media_details.width / 2;
      return (
        <img src={url} data-id={ id } width={ maxWidth } />
      );
    } else {
      return (
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18"><g transform="translate(111 -41)"><circle cx="5" cy="5" r="5" transform="translate(-107 45)" class="svg-fill" /><g transform="translate(-111 41)" fill="none" class="svg-stroke" stroke-width="2"><circle cx="9" cy="9" r="9" stroke="none"/><circle cx="9" cy="9" r="8" fill="none"/></g></g></svg>
      );
    }
  }



/*==================================================================================
REGISTER BLOCK
==================================================================================*/

  /* register
  /------------------------*/
  export default registerBlockType( 'templates/image-pins-item', {
    title: __( 'Image Pins item', 'devTheme' ),
    description: __( 'Image Pin', 'devTheme' ),
    category: 'media',
    icon: 'sticky',
    parent: [ 'templates/image-pins' ],
    keywords: [
      __( 'Image', 'devTheme' ),
      __( 'Item', 'devTheme' ),
      __( 'Pins', 'devTheme' )
    ],
    supports: {
      html: false,                // Remove support for an HTML mode
      anchor: true,               // Declare support for anchor links
      customClassName: true,      // Remove the support for the custom className
      className: false,           // Remove the support for the generated className
      align: false,                // Declare support for block's alignment
      alignWide: false,            // Remove the support for wide alignment
      defaultStylePicker: true,  // Remove the Default Style picker
      inserter: true,             // Hide this block from the inserter
      multiple: true,             // Use the block just once per post
      reusable: false              // Don't allow the block to be converted into a reusable block
    },
    attributes,
    edit: withSelect( ( select, props ) => {
      let taxOne = {};
      let taxTwo = {};
      let pinImageObject = {};
      if(props.attributes.pinInfoRowOne.startsWith("tax__")){
        var cleanTextOne = props.attributes.pinInfoRowOne.replace("tax__", "");
        const getTaxOne = select( 'core' ).getEntityRecords( 'taxonomy', cleanTextOne );
        if(getTaxOne){
          getTaxOne.forEach( tax => {
            taxOne[ tax.id ] = tax.name;
          });
        }
      }
      if(props.attributes.pinInfoRowTwo.startsWith("tax__")){
        var cleanTextTwo = props.attributes.pinInfoRowTwo.replace("tax__", "");
        const getTaxTwo = select( 'core' ).getEntityRecords( 'taxonomy', cleanTextTwo );
        if(getTaxTwo){
          getTaxTwo.forEach( tax => {
            taxTwo[ tax.id ] = tax.name;
          });
        }
      }
      if(props.attributes.pinImgId){
        pinImageObject[ props.attributes.pinImgId ] = select( 'core' ).getMedia(props.attributes.pinImgId);
      }
      return {
        taxOne, taxTwo, pinImageObject
      };
    } )( props => {
      const {
        attributes: { anchor, pinPostion, pinImgId, pinImageURL, pinPostType, pinPostId, pinTarget, pinInfo, pinInfoRowOne, pinInfoRowTwo, pinInfoTrigger, parentAttributes },
        attributes,
        className,
        pinImageObject,
        setAttributes
      } = props;

      let settings = getSettings(attributes);
      let tPosition = pinPostion.y * 100;
      let lPosition = pinPostion.x * 100;
      let returnPin = getPinImage(pinImgId, pinImageURL, pinImageObject);

      return [
        <Inspector {...{ setAttributes, ...props }} />,
        <div className={classnames(
          'block-image-pin', className
        )} style={{'top': tPosition + '%', 'left': lPosition + '%'}}
          >
          <span>
            {returnPin}
          </span>
        </div>

      ];
    } ),
    save: props => {
      const {
        attributes: { anchor, pinPostion, pinImgId, pinImageURL, pinPostType, pinPostId, pinTarget, pinInfo, pinInfoRowOne, pinInfoRowTwo, pinInfoTrigger, parentAttributes },
        attributes
      } = props;

      return null;
    }

  });
